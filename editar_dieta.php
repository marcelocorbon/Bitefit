<?php 
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

    // Verifica se houve uma requisição para atualizar a dieta
    if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $objetivo = $_POST['objetivo'];
        $data_validade = $_POST['data_validade'];
        $segunda = $_POST['segunda'];
        $terca = $_POST['terca'];
        $quarta = $_POST['quarta'];
        $quinta = $_POST['quinta'];
        $sexta = $_POST['sexta'];
        $sabado = $_POST['sabado'];
        $domingo = $_POST['domingo'];

        $query_atualizar_dieta = "UPDATE dietas SET nome = :nome, objetivo = :objetivo, data_validade = :data_validade, segunda = :segunda, terca = :terca, quarta = :quarta, quinta = :quinta, sexta = :sexta, sabado = :sabado, domingo = :domingo WHERE id = :id";
        $stmt_atualizar_dieta = $pdo->prepare($query_atualizar_dieta);
        $stmt_atualizar_dieta->bindParam(':nome', $nome);
        $stmt_atualizar_dieta->bindParam(':objetivo', $objetivo);
        $stmt_atualizar_dieta->bindParam(':data_validade', $data_validade);
        $stmt_atualizar_dieta->bindParam(':segunda', $segunda);
        $stmt_atualizar_dieta->bindParam(':terca', $terca);
        $stmt_atualizar_dieta->bindParam(':quarta', $quarta);
        $stmt_atualizar_dieta->bindParam(':quinta', $quinta);
        $stmt_atualizar_dieta->bindParam(':sexta', $sexta);
        $stmt_atualizar_dieta->bindParam(':sabado', $sabado);
        $stmt_atualizar_dieta->bindParam(':domingo', $domingo);
        $stmt_atualizar_dieta->bindParam(':id', $id);
        $stmt_atualizar_dieta->execute();

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
    <title>Editar Dieta:</title>
</head>
<body>
    <h1>Editar Dieta: <?= $dieta['nome'] ?></h1>

    <form method="post" action="editar_dieta.php">
        <input type="hidden" name="id" value="<?= $dieta['id'] ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $dieta['nome'] ?>"><br>
        <label for="objetivo">Objetivo:</label>
    <input type="text" name="objetivo" id="objetivo" value="<?= $dieta['objetivo'] ?>"><br>

    <label for="data_validade">Data de Validade:</label>
    <input type="date" name="data_validade" id="data_validade" value="<?= $dieta['data_validade'] ?>"><br>
    <br>
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
                <td><textarea name="segunda" id="segunda" value="<?= $dieta['segunda'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Terça-feira</td>
                <td><textarea name="terca" id="terca" value="<?= $dieta['terca'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Quarta-feira</td>
                <td><textarea name="quarta" id="quarta" value="<?= $dieta['quarta'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Quinta-feira</td>
                <td><textarea name="quinta" id="quinta" value="<?= $dieta['quinta'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Sexta-feira</td>
                <td><textarea name="sexta" id="sexta" value="<?= $dieta['sexta'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Sábado</td>
                <td><textarea name="sabado" id="sabado" value="<?= $dieta['sabado'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Domingo</td>
                <td><textarea name="domingo" id="domingo" value="<?= $dieta['domingo'] ?>" rows="4" cols="50"></textarea></td>
            </tr>
        </tbody>
    </table>
    <br>
    <button type="submit" name="atualizar">Atualizar</button>
</form>

<script>
    function confirmarExclusao() {
        return confirm('Tem certeza que deseja excluir esta dieta?');
    }
</script>
<br>
    <a href="listar_dietas_receitas.php">Voltar para as dietas</a>
</body>
</html>
