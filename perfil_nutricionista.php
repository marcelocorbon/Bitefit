<?php
require_once "conexao.php";

// Verifica se o usuário está logado como nutricionista
session_start();
if (!isset($_SESSION['nutricionista_id'])) {
  header("Location: login_nutricionista.php");
  exit();
}

// Recupera as informações do nutricionista logado
$sql = "SELECT * FROM nutricionista WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['nutricionista_id']]);
$nutricionista = $stmt->fetch();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Perfil do Nutricionista</title>
</head>
<body>
  <h1>Bem vindo ao seu perfil, Nutricionista!</h1>
  <h2>Dados Pessoais</h2>
  <p><strong>Nome completo:</strong> <?php echo $nutricionista['nome']; ?></p>
  <p><strong>Email:</strong> <?php echo $nutricionista['email']; ?></p>
  <p><strong>CRN:</strong> <?php echo $nutricionista['crn']; ?></p>
  <p><strong>Telefone:</strong> <?php echo $nutricionista['telefone']; ?></p>
  <p><strong>Celular:</strong> <?php echo $nutricionista['celular']; ?></p>
  <p><strong>Endereço:</strong> <?php echo $nutricionista['endereco']; ?></p>
  
  <h2>Informações sobre as consultas:</h2>

  <strong>Horário de início:</strong> <?php echo $nutricionista['horario_inicio']; ?> | 
  <strong>Horário de fim:</strong> <?php echo $nutricionista['horario_fim']; ?>

  <p><strong>Dias de atendimento:</strong>
<?php 
$semana = explode(',', $nutricionista['dias_semana']);
foreach($semana as $dia) {
    echo '<br>' . $dia . ' ';
}
?>
</p>

  <a href="editar_nutricionista.php?id=<?php echo $nutricionista['id']; ?>">Editar</a>
  <br>
  <a href="inicio_nutricionista.php">Voltar para o início</a>
</body>
</html>

