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
<br>
<a href="dietas_pacientes.php">Voltar para suas dietas</a>

</body>
</html>
