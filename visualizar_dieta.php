<?php 
session_start();

require_once('conexao.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca a dieta selecionada
    $query_dieta = "SELECT * FROM dietas_receitas WHERE id = :id";
    $stmt_dieta = $pdo->prepare($query_dieta);
    $stmt_dieta->bindParam(':id', $id);
    $stmt_dieta->execute();
    $dieta = $stmt_dieta->fetch(PDO::FETCH_ASSOC);

    // Verifica se a dieta existe
    if (!$dieta) {
        die('Dieta não encontrada');
    }

    
    // Verifica se houve uma requisição para excluir a dieta
    if (isset($_POST['excluir'])) {
        $query_excluir_dieta = "DELETE FROM dietas_receitas WHERE id = :id";
        $stmt_excluir_dieta = $pdo->prepare($query_excluir_dieta);
        $stmt_excluir_dieta->bindParam(':id', $id);
        $stmt_excluir_dieta->execute();

        header('Location: listar_dietas.php');
        exit();
    }
}
else {
    die('ID de dieta não fornecido');
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informações da Dieta:</title>
    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza de que deseja excluir esta dieta?");
        }
    </script>
</head>
<body>
    <h1>Informações da dieta: <?= $dieta['nome'] ?></h1>

    <h3>Segue abaixo as informações da dieta selecionada:</h3>

<p><strong>Objetivo:</strong> <?= $dieta['objetivo'] ?></p>
<p><strong>Data de Validade:</strong> <?= $dieta['data_validade'] ?></p>

<table>
    <thead>
        <tr>
            <th>Dia da semana</th>
            <th>Alimentação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Segunda-feira</td>
            <td><?= $dieta['segunda'] ?></td>
        </tr>
        <tr>
            <td>Terça-feira</td>
            <td><?= $dieta['terca'] ?></td>
        </tr>
        <tr>
            <td>Quarta-feira</td>
            <td><?= $dieta['quarta'] ?></td>
        </tr>
        <tr>
            <td>Quinta-feira</td>
            <td><?= $dieta['quinta'] ?></td>
        </tr>
        <tr>
            <td>Sexta-feira</td>
            <td><?= $dieta['sexta'] ?></td>
        </tr>
        <tr>
            <td>Sábado</td>
            <td><?= $dieta['sabado'] ?></td>
        </tr>
        <tr>
            <td>Domingo</td>
            <td><?= $dieta['domingo'] ?></td>
        </tr>
    </tbody>
</table>
<br>
<form method="post" action="excluir_dieta.php" onsubmit="return confirmarExclusao();">
    <input type="hidden" name="id" value="<?= $dieta['id'] ?>">
    <button type="submit" name="excluir">Excluir Dieta</button> |
    <a href="editar_dieta.php?id=<?= $dieta['id'] ?>">Editar</a>

</form>
<br>
<a href="listar_dietas_receitas.php">Voltar para a lista de dietas</a>

</body>
</html>
