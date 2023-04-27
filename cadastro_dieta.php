<?php
require_once 'conexao.php';

// Recupera a lista de pacientes para o dropdown
$query_pacientes = "SELECT id, nome FROM paciente ORDER BY nome";
$stmt_pacientes = $pdo->query($query_pacientes);
$pacientes = $stmt_pacientes->fetchAll(PDO::FETCH_ASSOC);

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $paciente_id = $_POST['paciente_id'];
    $nome_dieta = $_POST['nome_dieta'];
    $objetivo = $_POST['objetivo'];
    $data_validade = $_POST['data_validade'];
    $segunda = $_POST['segunda'];
    $terca = $_POST['terca'];
    $quarta = $_POST['quarta'];
    $quinta = $_POST['quinta'];
    $sexta = $_POST['sexta'];
    $sabado = $_POST['sabado'];
    $domingo = $_POST['domingo'];

    // Insere os dados na tabela de dietas e receitas
    $query = "INSERT INTO dietas_receitas (paciente_id, nome, objetivo, data_validade, segunda, terca, quarta, quinta, sexta, sabado, domingo) 
              VALUES (:paciente_id, :nome_dieta, :objetivo, :data_validade, :segunda, :terca, :quarta, :quinta, :sexta, :sabado, :domingo)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':paciente_id', $paciente_id);
    $stmt->bindParam(':nome_dieta', $nome_dieta);
    $stmt->bindParam(':objetivo', $objetivo);
    $stmt->bindParam(':data_validade', $data_validade);
    $stmt->bindParam(':segunda', $segunda);
    $stmt->bindParam(':terca', $terca);
    $stmt->bindParam(':quarta', $quarta);
    $stmt->bindParam(':quinta', $quinta);
    $stmt->bindParam(':sexta', $sexta);
    $stmt->bindParam(':sabado', $sabado);
    $stmt->bindParam(':domingo', $domingo);
    $stmt->execute();

    // Redireciona para a página de listagem de dietas e receitas do paciente
    header("Location: listar_dietas_receitas.php?paciente_id=" . $paciente_id);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Dietas e Receitas</title>
</head>
<body>
    <h1>Cadastro de Dietas e Receitas</h1>
    <form method="post">
    <label for="paciente_id">Paciente:</label>
    <select name="paciente_id" id="paciente_id">
        <?php foreach ($pacientes as $paciente) { ?>
            <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
        <?php } ?>
    </select>
    <br><br>
    <label for="nome_dieta">Nome da dieta:</label>
<input type="text" name="nome_dieta" id="nome_dieta" required>
<br><br>

<label for="objetivo">Objetivo:</label>
<input type="text" name="objetivo" id="objetivo" required>
<br><br>

<label for="data_validade">Data de validade:</label>
<input type="date" name="data_validade" id="data_validade" required>
<br><br>

<h2>Receitas para cada dia da semana</h2>

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
<input type="submit" value="Salvar">
</form>
<br>
<a href="listar_dietas_receitas.php">Voltar para as dietas</a>
<br>
</body>
</html>

   
