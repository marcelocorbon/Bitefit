<?php
// Inclui o arquivo de conexão com o banco de dados
require_once "conexao.php";

// Inicia a sessão
session_start();

// Verifica se o nutricionista já está logado e redireciona para a página de início do nutricionista
if (!isset($_SESSION['nutricionista_id'])) {
  header("Location: login_nutricionista.php");
  exit();
}

// Obtém o ID do nutricionista logado
$nutricionista_id = $_SESSION['nutricionista_id'];

// Obtém os dados do nutricionista
$stmt = $pdo->prepare('SELECT * FROM nutricionista WHERE id = ?');
$stmt->execute([$nutricionista_id]);
$nutricionista = $stmt->fetch();

// Verifica se o formulário de agendamento de consulta foi submetido
if (isset($_POST['agendar_consulta'])) {
  $data = $_POST['data'];
  $horario = $_POST['horario'];
  $paciente_id = $_POST['paciente_id'];

  // Verifica se já existe uma consulta agendada para o mesmo horário e dia
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM consulta WHERE data = ? AND horario = ? AND nutricionista_id = ?');
  $stmt->execute([$data, $horario, $nutricionista_id]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
    // Consulta já agendada para o mesmo horário e dia
    $erro = "Já existe uma consulta agendada para o mesmo horário e dia.";
  } else {
    // Insere a consulta no banco de dados
    $stmt = $pdo->prepare('INSERT INTO consulta (data, horario, paciente_id, nutricionista_id) VALUES (?, ?, ?, ?)');
    $stmt->execute([$data, $horario, $paciente_id, $nutricionista_id]);
    
    // Redireciona para a página de consultas
    header('Location: consultas_nutricionista.php');
    exit();
  }
}

// Obtém os pacientes do nutricionista
$stmt = $pdo->prepare('SELECT * FROM paciente WHERE nutricionista_id = ?');
$stmt->execute([$nutricionista_id]);
$pacientes = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Consultas - Nutricionista</title>
</head>
<body>
  <h1>Agendar Consulta</h1>
  <?php if (isset($erro)): ?>
  <p style="color: red;"><?php echo $erro; ?></p>
  <?php endif; ?>
  <form method="post">
    <label>Paciente:</label>
    <select name="paciente_id" required>
      <option value="">Selecione um paciente</option>
      <?php foreach ($pacientes as $paciente): ?>
      <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
      <?php endforeach; ?>
    </select><br><br>
    <label>Data:</label>
    <input type="date" name="data" required>
    <label>Horário:</label>
    <input type="time" name="horario" required><br><br>
    <input type="submit" name="agendar_consulta" value="Agendar Consulta">
  </form>
  <br>
  <a href="consultas_nutri.php">Voltar para a lista de consultas</a>
</body>
</html>