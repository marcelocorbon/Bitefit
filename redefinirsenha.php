<?php

require_once("conexao.php");

if(isset($_POST['submit'])){

	// Receber a nova senha e o token
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$token = $_POST['token'];

	// Verificar se a nova senha e a confirmação da senha correspondem
	if($password == $confirm_password){
		// Verificar se o token existe no banco de dados
		$sql = "SELECT * FROM nutricionista WHERE token='$token'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// Atualizar a senha do nutricionista
			$row = $result->fetch_assoc();
			$id = $row['id'];
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$sql = "UPDATE nutricionista SET senha='$hashed_password', token=NULL WHERE id=$id";

			if ($conn->query($sql) === TRUE) {
				echo "Senha atualizada com sucesso.";
			} else {
				echo "Houve um problema ao atualizar o banco de dados.";
			}
		} else {
			echo "Token inválido.";
		}
	}else{
		echo "As senhas não correspondem.";
	}

	$conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Redefinir senha</title>
</head>
<body>
	<h2>Redefinir senha</h2>
	<form method="POST" action="redefinirsenha.php">
		<label for="password">Nova senha:</label>
		<input type="password" name="password" id="password" required><br><br>
		<label for="confirm_password">Confirmar nova senha:</label>
		<input type="password" name="confirm_password" id="confirm_password" required><br><br>
		<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
		<input type="submit" name="submit" value="Redefinir senha">
	</form>
</body>
</html>
