<?php
// Inclui o arquivo de conexão com o banco de dados
require_once "conexao.php";

// Inicia a sessão
session_start();

// Verifica se o usuário já está logado e redireciona para a página de pacientes
if (isset($_SESSION['nutricionista_id'])) {
  header("Location: inicio_nutricionista.php");
  exit();
}

// Define as variáveis que serão usadas no formulário de cadastro
$nome           = "";
$email          = "";
$senha          = "";
$confirmarSenha = "";
$telefone       = "";
$celular        = "";
$crn            = "";
$endereco       = "";
$horario_inicio = "";
$horario_fim    = "";
$dias_semana    = [];

// Define as variáveis que serão usadas para exibir mensagens de erro
$nomeErro           = "";
$emailErro          = "";
$senhaErro          = "";
$confirmarSenhaErro = "";
$telefoneErro       = "";
$celularErro        = "";
$crnErro            = "";
$enderecoErro       = "";
$horarioInicioErro  = "";
$horarioFimErro     = "";
$diasSemanaErro     = "";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Define as variáveis com os dados enviados pelo formulário
  $nome = trim($_POST["nome"]);
  $email = trim($_POST["email"]);
  $telefone = trim($_POST["telefone"]);
  $celular = trim($_POST["celular"]);
  $crn = trim($_POST["crn"]);
  $endereco = trim($_POST["endereco"]);
  $senha = $_POST["senha"];
  $confirmarSenha = $_POST["confirmarSenha"];
  $horario_inicio = $_POST["horario_inicio"];
  $horario_fim = $_POST["horario_fim"];
  $dias_semana = $_POST["dias_semana"];

  // Verifica se o nome foi preenchido
  if (empty($nome)) {
    $nomeErro = "Por favor, informe seu nome.";
  }

  // Verifica se o email foi preenchido e se é válido
  if (empty($email)) {
    $emailErro = "Por favor, informe seu email.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErro = "Por favor, informe um email válido.";
  }

  // Verifica se a senha foi preenchida e se tem pelo menos 8 caracteres
  if (empty($senha)) {
    $senhaErro = "Por favor, informe uma senha.";
  } elseif (strlen($senha) < 8) {
    $senhaErro = "Sua senha deve ter pelo menos 8 caracteres.";
  }

  // Verifica se a confirmação de senha foi preenchida e se é igual à senha informada
  if (empty($confirmarSenha)) {
    $confirmarSenhaErro = "Por favor, confirme sua senha.";
  } elseif ($senha !== $confirmarSenha) {
    $confirmarSenhaErro = "As senhas não são iguais.";
  }

  // Verifica se o email já existe no banco de dados
  $sql_verificar_email = "SELECT id FROM nutricionista WHERE email = ?";
  $stmt = $pdo->prepare($sql_verificar_email);
  $stmt->execute([$email]);

  if ($stmt->rowCount() > 0) {$emailErro = "Este email já está cadastrado.";
  }

  // Verifica se o CRN foi preenchido
  if (empty($crn)) {
    $crnErro = "Por favor, informe seu CRN.";
  }

  // Verifica se o endereço foi preenchido
  if (empty($endereco)) {
    $enderecoErro = "Por favor, informe seu endereço.";
  }

  // Verifica se o horário de início e fim foram preenchidos
  if (empty($horario_inicio)) {
    $horarioInicioErro = "Por favor, informe o horário de início.";
  }

  if (empty($horario_fim)) {
    $horarioFimErro = "Por favor, informe o horário de fim.";
  }

  // Verifica se os dias da semana foram selecionados
  if (empty($dias_semana)) {
    $diasSemanaErro = "Por favor, selecione pelo menos um dia da semana.";
  }

  // Se não houver erros, insere o nutricionista no banco de dados
  if (empty($nomeErro) && empty($emailErro) && empty($senhaErro) && empty($confirmarSenhaErro) && empty($crnErro) && empty($enderecoErro) && empty($horarioInicioErro) && empty($horarioFimErro) && empty($diasSemanaErro)) {

    // Criptografa a senha
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o nutricionista no banco de dados
    $sql_inserir_nutricionista = "INSERT INTO nutricionista (nome, email, senha, telefone, celular, crn, endereco, horario_inicio, horario_fim, dias_semana) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql_inserir_nutricionista);
    $stmt->execute([$nome, $email, $senhaCriptografada, $telefone, $celular, $crn, $endereco, $horario_inicio, $horario_fim, implode(',', $dias_semana)]);

    // Redireciona o nutricionista para a página de login
    header("Location: login_nutricionista.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Nutricionista</title>
  <meta charset="UTF-8">
</head>
<body>
	<h1>Cadastro de Nutricionista</h1>
  
  <h2>Dados Pessoais</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="nome">Nome:</label>
  <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>">
  <span class="erro"><?php echo $nomeErro; ?></span>
  <br>
  <label for="telefone">Telefone:</label>
  <input type="text" id="telefone" name="telefone" value="<?php echo $telefone; ?>">
  <br>
  <label for="celular">Celular:</label>
  <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>">
  <br>
  <label for="crn">CRN:</label>
  <input type="text" id="crn" name="crn" value="<?php echo $crn; ?>">
  <br>
  <label for="endereco">Endereço:</label>
  <input type="text" id="endereco" name="endereco" value="<?php echo $endereco; ?>">
  <span class="erro"><?php echo $enderecoErro; ?></span>

  <h2>Dados de Usuário</h2>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php echo $email; ?>">
  <span class="erro"><?php echo $emailErro; ?></span>
  <br>
  <label for="senha">Senha:</label>
  <input type="password" id="senha" name="senha">
  <span class="erro"><?php echo $senhaErro; ?></span>
  <br>
  <label for="confirmarSenha">Confirmar senha:</label>
  <input type="password" id="confirmarSenha" name="confirmarSenha">
  <span class="erro"><?php echo $confirmarSenhaErro; ?></span>
  <br>
  <h2>Informações sobre as consultas:</h2>

  <label for="horario_inicio">Horário de início:</label>
  <input type="time" id="horario_inicio" name="horario_inicio" value="<?php echo $horario_inicio; ?>">
  <span class="erro"><?php echo $horarioInicioErro; ?></span>
  
  <label for="horario_fim">Horário de fim:</label>
  <input type="time" id="horario_fim" name="horario_fim" value="<?php echo $horario_fim; ?>">
  <span class="erro"><?php echo $horarioFimErro; ?></span>
  <br>
  <label for="dias_semana">Dias de atendimento:</label><br>

  <input type="checkbox" id="segunda" name="dias_semana[]" value="Segunda" <?php if(in_array('segunda', $dias_semana)) echo "checked"; ?>>
  <label for="segunda">Segunda-feira</label><br>

  <input type="checkbox" id="terca" name="dias_semana[]" value="Terça" <?php if(in_array('terca', $dias_semana)) echo "checked"; ?>>
  <label for="terca">Terça-feira</label><br>

  <input type="checkbox" id="quarta" name="dias_semana[]" value="Quarta" <?php if(in_array('quarta', $dias_semana)) echo "checked"; ?>>
  <label for="quarta">Quarta-feira</label><br>

  <input type="checkbox" id="quinta" name="dias_semana[]" value="Quinta" <?php if(in_array('quinta', $dias_semana)) echo "checked"; ?>>
  <label for="quinta">Quinta-feira</label><br>

  <input type="checkbox" id="sexta" name="dias_semana[]" value="Sexta" <?php if(in_array('sexta', $dias_semana)) echo "checked"; ?>>
  <label for="sexta">Sexta-feira</label><br>

  <input type="checkbox" id="sabado" name="dias_semana[]" value="Sábado" <?php if(in_array('sabado', $dias_semana)) echo "checked"; ?>>
  <label for="sabado">Sábado</label><br>

  <input type="checkbox" id="domingo" name="dias_semana[]" value="Domingo" <?php if(in_array('domingo', $dias_semana)) echo "checked"; ?>>
  <label for="domingo">Domingo</label><br>
  <br>
  <input type="submit" value="Cadastrar">
  </form>
  <br>
  <a href="index.html"><button>Voltar para o início</button></a>

  </body>
</html>
