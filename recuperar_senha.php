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
		<title>Facima - Recuperar Senha</title>
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
					if(isset($_POST['recuperar'])) {
						$email = $_POST['email'];
						
						if(empty($email)) {
							echo '<div class="alert">Preencha todos os campos!</div>';
						} elseif(!val_email($email)) {
							echo '<div class="alert">E-mail não é válido!</div>';
						} elseif(!existing_email($email)) {
							echo '<div class="alert">E-mail inserido não existe!</div>';
						} else {
							forgotPassword($email);
							echo '<div class="alert">Nova senha foi enviada para seu e-mail com sucesso!</div>';
						}
					}
				?>
				<form method="POST" id="form_field">	
					
					<div class="form-group">
						<p>Insira seu E-mail cadastrado, lembrando que será enviado para seu e-mail uma nova senha de acesso!</p>
					</div>
					
					<div class="form-group">
						<label for="userLogin">Email:</label>
						<input name="email" type="text" placeholder="email@facima.edu.br">
					</div>
					
					<button type="submit" id="login" name="recuperar">Recuperar</button>
					<p>Já possui cadastro? <a href="/">Realize o login</a></p>
				</form>
			</div>
		</div>
	</body>
</html>
