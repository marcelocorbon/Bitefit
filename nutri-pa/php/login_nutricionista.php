<?php
  // Inicia a sessão
session_start();

  // Verifica se o usuário já está logado
if (isset($_SESSION['nutricionista_id'])) {
  header("Location: inicio_nutricionista.php");
  exit();
}

  // Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
  $email = $_POST['email'];
  $senha = $_POST['senha'];

    // Conecta ao banco de dados
  require_once 'conexao.php';

    // Busca o nutricionista pelo email
  $sql  = 'SELECT id, nome, senha FROM nutricionista WHERE email = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $nutricionista = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o nutricionista foi encontrado e se a senha está correta
  if ($nutricionista && password_verify($senha, $nutricionista['senha'])) {
      // Armazena os dados do nutricionista na sessão
    $_SESSION['nutricionista_id']   = $nutricionista['id'];
    $_SESSION['nutricionista_nome'] = $nutricionista['nome'];

      // Redireciona para a página inicial
    header("Location: inicio_nutricionista.php");
    exit();
  } else {
      // Exibe uma mensagem de erro
    $erro = 'Email ou senha inválidos.';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500&display=swap" rel="stylesheet">
    <title>Login | BiteFit</title>
</head>
<body>
  

<div class="container-login-nutri">

  <div class="div">
  <a class="botao-voltar" href="index.html">
  			<img src="../imagens/icons/seta-esquerda.png" alt="Meu botão">
</a>
   
  

  <form method = "POST">
  <img src="../imagens/icons/logoFila.svg" alt="logoBiteFit">
  <h1></h1>
    <div class="textfield">
      <label for  = "email">Email:</label>
      <input type = "email" name = "email" required>
    </div>
    <div class="textfield">
      <label for  = "senha">Senha:</label>
      <input type = "password" name = "senha" required>
    </div>

    <?php if (isset($erro)): ?>
    <p><?php echo $erro; ?></p>
    <?php endif; ?>

      <button class="botao-login-nutri" type = "submit">Entrar</button>
    
    <p class="paragrafo-cadastro">Não possui cadastro? <a href="cadastro_nutricionista.php">Cadastar-se</a></p>
    
  </form>
</div>

  <img class="img" src="../imagens/illustrations/Login.svg" alt="helth">

</div>
</body>
</html>
