<?php
session_start();

// Verifica se o usuário está logado como paciente
if (!isset($_SESSION['paciente_id'])) {
  header("Location: login_paciente.php");
  exit();
}

require_once "conexao.php";

// Busca as informações do nutricionista que cadastrou o paciente
$sql = "SELECT * FROM nutricionista WHERE id = (SELECT nutricionista_id FROM paciente WHERE id = ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['paciente_id']]);
$nutricionista = $stmt->fetch();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfil do Nutricionista</title>
	<meta charset="UTF-8">
</head>
<body>
	<h1>Perfil do seu Nutricionista</h1>
	<h2>Aqui você verá todas as informações do seu nutricionista: </h2>
	<p><strong>Nome:</strong><?php echo $nutricionista['nome']; ?></p>
	<p><strong>E-mail:</strong> <?php echo $nutricionista['email']; ?></p>
	<p><strong>Telefone:</strong> <?php echo $nutricionista['telefone']; ?></p>
	<p><strong>Celular:</strong> <?php echo $nutricionista['celular']; ?></p>	
	<p><strong>CRN:</strong> <?php echo $nutricionista['crn']; ?></p>
	<h2>Informações da consulta:</h2>
	<p><strong>Endereço:</strong> <?php echo $nutricionista['endereco']; ?></p>
	<p><strong>Horário que começa a atender:</strong> <?php echo $nutricionista['horario_inicio']; ?></p>
	<p><strong>Último horário que atende:</strong> <?php echo $nutricionista['horario_fim']; ?></p>
	<p><strong>Dias da semana que atende:</strong></p>
		<?php
			$dias_semana = explode(',', $nutricionista['dias_semana']);
			foreach ($dias_semana as $dia) {
    		echo "$dia" . "<br>";
			}
		?>
	<br>
	<a href="inicio_paciente.php">Voltar para o ínicio</a>
</body>
</html>
