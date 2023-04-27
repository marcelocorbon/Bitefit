<?php

session_start();

require_once('conexao.php');

// Busca todos os pacientes
$query_pacientes = "SELECT id, nome FROM paciente ORDER BY nome";
$stmt_pacientes = $pdo->query($query_pacientes);
$pacientes = $stmt_pacientes->fetchAll(PDO::FETCH_ASSOC);

// Recupera o id do paciente, se existir
$paciente_id = isset($_GET['paciente_id']) ? $_GET['paciente_id'] : null;

// Busca as dietas e receitas dos pacientes
$query_dietas_receitas = "SELECT dieta.id, dieta.nome, dieta.objetivo, dieta.data_validade, dieta.segunda, 
dieta.terca, dieta.quarta, dieta.quinta, dieta.sexta, dieta.sabado, dieta.domingo, paciente.nome AS paciente_nome
                         FROM dietas_receitas dieta
                         INNER JOIN paciente ON dieta.paciente_id = paciente.id";

if ($paciente_id) {
    $query_dietas_receitas .= " WHERE dieta.paciente_id = :paciente_id";
}

$query_dietas_receitas .= " ORDER BY dieta.data_validade DESC";

$stmt_dietas_receitas = $pdo->prepare($query_dietas_receitas);

if ($paciente_id) {
    $stmt_dietas_receitas->bindParam(':paciente_id', $paciente_id);
}

$stmt_dietas_receitas->execute();
$dietas_receitas = $stmt_dietas_receitas->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listagem de Dietas e Receitas</title>
</head>
<body>
    <h1>Listagem de Dietas e Receitas</h1>

    <form method="get" action="listar_dietas_receitas.php">
        <label>Selecione um paciente: 
            <select name="paciente_id">
                <option value="">Todos</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id'] ?>"<?= $paciente_id == $paciente['id'] ? ' selected' : '' ?>>
                        <?= $paciente['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <h2>Dietas e Receitas Cadastradas</h2>

    <?php if (count($dietas_receitas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Nome</th>
                    <th>Objetivo</th>
                    <th>Data de Validade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dietas_receitas as $dieta): ?>
                    <tr>
                        <td><?= $dieta['paciente_nome'] ?></td>
                        <td><?= $dieta['nome'] ?></td>
                        <td><?= $dieta['objetivo'] ?></td>
                        <td><?= date('d/m/Y', strtotime($dieta['data_validade'])) ?></td>
                        <td>
                            <a href="visualizar_dieta.php?id=<?= $dieta['id'] ?>">Visualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
    <p>Não foram encontradas dietas ou receitas cadastradas.</p>
<?php endif; 

?>
<br>
<a href="inicio_nutricionista.php">Voltar para o ínicio</a>
<br>
<a href="cadastro_dieta.php">Cadastrar novas dietas</a>

</body>
</html>
