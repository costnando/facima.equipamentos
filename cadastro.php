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
		<title>Facima - Cadastro</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<script src="../../assets/js/jquery.min.js"></script>
		<script src="../../assets/js/jquery.mask.min.js"></script>
	</head>
	<body class="body-login">
		<div>
        	<center>
	        <div id="logo" class="register">
	            <img src="assets/img/logo.png">
	        </div>
	 		</center>
			<div id="form_cadastro">
			<?php
				if(isset($_POST['cadastrar'])){
					$nome    = $_POST['nome'];
					$usuario = $_POST['usuario'];
					$email   = $_POST['email'];
					$cpf     = $_POST['cpf'];
					$senha   = $_POST['senha'];
					$senha2  = $_POST['senha2'];
					
					if(empty($nome) OR empty($usuario) OR empty($email) OR empty($cpf) OR empty($senha) OR empty($senha2)) {
						echo '<div class="alert">Preencha todos os campos!</div>';
					} elseif(!val_email($email)) {
						echo '<div class="alert">E-mail não é válido!</div>';
					} elseif(existing_user($usuario)) {
						echo '<div class="alert">Usuário já existe em nossos cadastros!</div>';
					} elseif(existing_email($email)) {
						echo '<div class="alert">E-mail já existe em nossos cadastros!</div>';
					} elseif(existing_cpf($cpf)) {
						echo '<div class="alert">CPF já existe em nossos cadastros!</div>';
					} elseif(!val_cpf($cpf)) {
						echo '<div class="alert">CPF não é válido!</div>';
					} elseif($senha != $senha2) {
						echo '<div class="alert">As senhas não são iguais!</div>';
					} else {
						register($nome, $usuario, $email, $cpf, $senha);
						echo '<div class="alert">Cadastrado com sucesso!</div>';
					}
				}
			?>
			<form method="POST">
                <div id="title_form">
                	<center>
                		<label>Tela de Cadastro</label>                		
                	</center>
                </div>
				<div class="form-group">
					<div>
						<label>Nome Completo:</label>
					</div>
					<input type="text" name="nome" placeholder="Digite o seu Nome Completo">
				</div>
				<div class="form-group">
					<div>
						<label>Nome do Usuário:</label>
					</div>
					<input type="text" name="usuario" placeholder="Digite o seu nome de usuário">
				</div>
				<div class="form-group">
					<div>
						<label>Email:</label>
					</div>
					<input type="text" name="email" placeholder="Digite o seu email">
				</div>
				<div class="form-group">
					<div>
						<label>CPF:</label>
					</div>
					<input type="text" name="cpf" class="cpf" placeholder="Digite o seu CPF">
				</div>
				<div class="form-group">
					<div>
						<label>Senha:</label>
					</div>
					<input type="password" name="senha" placeholder="Digite a sua senha">
				</div>
				<div class="form-group">
					<div>
						<label>Repita a sua Senha:</label>
					</div>
					<input type="password" name="senha2" placeholder="Digite a sua senha novamente">
				</div>
				<div class="form-group">
					<button type="submit" name="cadastrar" id="btn-success">Cadastrar</button>
					<p>Já possui cadastro? <a href="/">Realize o login</a></p>
				</div>
			</form>
			</div>
		</div>
	</body>
<script>
$(document).ready(function() {
	$('.cpf').mask('000.000.000-00', {reverse: true});
});
</script>
</html>