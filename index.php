<?php
	require_once("crud/crud.php");
	if($_SESSION['logged'] == "logged") {
		header("Location: /logado/admin/admin.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Facima - Login</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body class="body-login">
		<div id="color_background">
			<center>
		        <div id="logo">
		            <img src="assets/img/logo.png">
		        </div>
		 	</center>
			<div>
				<?php
					if(isset($_POST['login'])) {
						$email = filter_input(INPUT_POST,"email_user", FILTER_SANITIZE_STRING);
						$password = sha1(md5(filter_input(INPUT_POST,"password_user", FILTER_SANITIZE_STRING)));
						
						if(empty($_POST['email_user']) OR empty($_POST['password_user'])) {
							echo '<div class="alert">Preencha todos os campos!</div>';
						} else {
							$login = login($email, $password);
							if($login->status == "inative") {
								echo '<div class="alert">Usuário inativo, solicite a ativação do usuário para um administrador!</div>';
							} elseif($login->status == "error-login") {
								echo '<div class="alert">E-mail ou senha estão incorretos!</div>';
							} elseif($login->status == "ok") {
								echo '<script>window.location = "logado/admin/admin.php";</script>';
							}
						}
					}
				?>
				<form method="POST" id="form_field">					
					<div class="form-group">
						<label for="userLogin">Email:</label>
						<input name="email_user" type="text" aria-label="Usuário" placeholder="Usuário">
					</div>
	 
					<div class="form-group">
						<label for="userPassword">Senha:</label>
						<input type="password" name="password_user" aria-label="Senha" placeholder="Senha">
					</div>
	 
					<div id="forgot_password">
						<center><a href="/recuperar_senha.php">Esqueceu sua senha?</a></center>
					</div>
					<button type="submit" id="login" name="login">Entrar</button>
					<p>Não possui cadastro?
						<a href="/cadastro.php">Cadastre-se agora</a>
					</p>
				</form>
			</div>
		</div>
	</body>
</html>
