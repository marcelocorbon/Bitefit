<?php 
session_start();

require_once('conexao.php');

// Verifica se o paciente está logado
if (!isset($_SESSION['paciente_id'])) {
    header('Location: login.php');
    exit();
}

// Busca as dietas do paciente
$query_dietas = "SELECT * FROM dietas_receitas WHERE paciente_id = :paciente_id ORDER BY data_validade DESC";
$stmt_dietas = $pdo->prepare($query_dietas);
$stmt_dietas->bindParam(':paciente_id', $_SESSION['paciente_id']);
$stmt_dietas->execute();
$dietas = $stmt_dietas->fetchAll(PDO::FETCH_ASSOC);

// Verifica se houve uma requisição para filtrar por data de validade
if (isset($_POST['filtrar'])) {
    $data_validade = $_POST['data_validade'];

    // Busca as dietas do paciente com a data de validade selecionada
    $query_dietas_filtradas = "SELECT * FROM dietas_receitas WHERE paciente_id = :paciente_id AND data_validade = :data_validade ORDER BY data_validade DESC";
    $stmt_dietas_filtradas = $pdo->prepare($query_dietas_filtradas);
    $stmt_dietas_filtradas->bindParam(':paciente_id', $_SESSION['paciente_id']);
    $stmt_dietas_filtradas->bindParam(':data_validade', $data_validade);
    $stmt_dietas_filtradas->execute();
    $dietas = $stmt_dietas_filtradas->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Suas Dietas</title>
</head>
<body>
    <h1>Suas Dietas</h1>

    <form method="post">
        <label for="data_validade">Filtrar por data de validade:</label>
        <input type="date" name="data_validade">
        <button type="submit" name="filtrar">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Objetivo</th>
                <th>Data de Validade</th>
                <th>Visualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dietas as $dieta): ?>
                <tr>
                    <td><?= $dieta['nome'] ?></td>
                    <td><?= $dieta['objetivo'] ?></td>
                    <td><?= $dieta['data_validade'] ?></td>
                    <td><a href="visualizar_dieta_paciente.php?id=<?= $dieta['id'] ?>">Visualizar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="inicio_paciente.php">Voltar para o início</a>
</body>
</html>
