<?php
require_once "conexao.php";

// Verifica se o usuário está logado como nutricionista
session_start();
if (!isset($_SESSION['nutricionista_id'])) {
  header("Location: login_nutricionista.php");
  exit();
}

// Busca os dados do nutricionista
$sql = "SELECT * FROM nutricionista WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['nutricionista_id']]);
$nutricionista = $stmt->fetch();

// Define o valor inicial de $dias_semana
$dias_semana = '';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Define $dias_semana antes de verificar se é um array
  $dias_semana = $_POST['dias_semana'];
  
  // Verifica se dias_semana é um array e converte em uma string separada por vírgulas
  if (is_array($dias_semana)) {
    $dias_semana = implode(',', $dias_semana);
  }
  
  // Atualiza os dados do nutricionista no banco de dados
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $celular = $_POST['celular'];
  $crn = $_POST['crn'];
  $endereco = $_POST['endereco'];
  $horario_inicio = $_POST['horario_inicio'];
  $horario_fim = $_POST['horario_fim'];
  
  $sql = "UPDATE nutricionista SET nome = ?, email = ?, telefone = ?, celular = ?, crn = ?, endereco = ?, horario_inicio = ?, horario_fim = ?, dias_semana = ? WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $email, $telefone, $celular, $crn, $endereco, $horario_inicio, $horario_fim, $dias_semana, $_SESSION['nutricionista_id']]);
  
  // Redireciona para a página de perfil do nutricionista
  header("Location: perfil_nutricionista.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar Nutricionista</title>
    <meta charset="UTF-8">
</head>
<body>
  <h1>Edite suas informações:</h1>
  <form method="POST">

  <h2>Dados Pessoais</h2>
  
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php echo $nutricionista['email']; ?>">
  <br>

  <label for="nome">Nome:</label>
  <input type="text" id="nome" name="nome" value="<?php echo $nutricionista['nome']; ?>">
  <br>

  <label for="telefone">Telefone:</label>
  <input type="text" id="telefone" name="telefone" value="<?php echo $nutricionista['telefone']; ?>">
  <br>

	<label for="celular">Celular:</label>
	<input type="text" id="celular" name="celular" value="<?php echo $nutricionista['celular']; ?>">
	<br>

	<label for="crn">CRN:</label>
	<input type="text" id="crn" name="crn" value="<?php echo $nutricionista['crn']; ?>">
	<br>

	<label for="endereco">Endereço:</label>
	<input type="text" id="endereco" name="endereco" value="<?php echo $nutricionista['endereco']; ?>">
	<br>

  <h2>Informações sobre as consultas:</h2>

	<label for="horario_inicio">Horário de Início:</label>
	<input type="time" id="horario_inicio" name="horario_inicio" value="<?php echo $nutricionista['horario_inicio']; ?>">
	<br>

	<label for="horario_fim">Horário de Fim:</label>
	<input type="time" id="horario_fim" name="horario_fim" value="<?php echo $nutricionista['horario_fim']; ?>">
	<br>

	<label for="dias_semana">Dias da Semana:</label><br>

	<input type="checkbox" id="segunda" name="dias_semana[]" value="Segunda-Feira" <?php if (in_array("Segunda-Feira", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="segunda">Segunda-Feira</label><br>

	<input type="checkbox" id="terca" name="dias_semana[]" value="Terça-Feira" <?php if (in_array("Terça-Feira", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="terca">Terça-Feira</label><br>

	<input type="checkbox" id="quarta" name="dias_semana[]" value="Quarta-Feira" <?php if (in_array("Quarta-Feira", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="quarta">Quarta-Feira</label><br>

	<input type="checkbox" id="quinta" name="dias_semana[]" value="Quinta-Feira" <?php if (in_array("Quinta-Feira", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="quinta">Quinta-Feira</label><br>

	<input type="checkbox" id="sexta" name="dias_semana[]" value="Sexta-Feira" <?php if (in_array("Sexta-Feira", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="sexta">Sexta-Feira</label><br>

	<input type="checkbox" id="sabado" name="dias_semana[]" value="Sábado" <?php if (in_array("Sábado", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="sabado">Sábado</label><br>

	<input type="checkbox" id="domingo" name="dias_semana[]" value="Domingo" <?php if (in_array("Domingo", explode(',', $nutricionista['dias_semana']))) echo 'checked'; ?>>
	<label for="domingo">Domingo</label><br><br>

  <input type="submit" value="Salvar">
</form>
<br>
<a href="perfil_nutricionista.php">Voltar para o perfil</a>
</body>
</html>

