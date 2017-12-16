<?php
	require_once("../../crud/crud.php");
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$dataUser = dataUser();
?>
<html>
  <head>
    <meta charset ="utf-8">
      <title>Minha Conta</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Minha Conta
        </div>
        <div>
		<?php
		if(isset($_POST['save'])) {
			
			$usuario = $_POST['usuario'];
			$nome    = $_POST['nome'];
			$cpf     = $_POST['cpf'];
			$email   = $_POST['email'];
			$senha   = $_POST['senha'];
			
			if(empty($usuario) OR empty($nome) OR empty($cpf) OR empty($email)) {
				echo '<script>alert("Preencha os campos obrigatórios!");</script>';
			} elseif(!val_email($email)) {
				echo '<script>alert("E-mail inserido não é válido!");</script>';
			} elseif(!val_cpf($cpf)) {
				echo '<script>alert("CPF inserido não é válido!");</script>';
			} else {
				$perfil = userPerfil($usuario, $nome, $cpf, $email, $senha);
				echo '<script>alert("Seus dados foram salvos com sucesso! Agora vocês será redirecionado para fazer login novamente. Lembrando se você alterou seu e-mail ou senha insira seus novos dados!");</script>';
				echo '<script>window.location = "/logado/lib/logout.php";</script>';
			}
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Nome de usuário:
              </div>
              <input type="text" name="usuario" placeholder="Nome de usuário" value="<?php echo $dataUser->name_user; ?>">
            </div>
            <div>
              <div>
                Nome Completo:
              </div>
              <input type="text" name="nome" placeholder="Nome Completo" value="<?php echo $dataUser->full_name_user; ?>">
            </div>
            <div>
              <div>
                Cpf:
              </div>
              <input type="text" name="cpf" placeholder="CPF" class="cpf" value="<?php echo $dataUser->cpf_user; ?>">
              </div>
            <div>
              <div>
                Email:
              </div>
              <input type="text" name="email" placeholder="E-mail" value="<?php echo $dataUser->email_user; ?>">
            </div>
            <div>
              <div>
                Senha:
              </div>
              <input type="password" name="senha" placeholder="Senha" value="">
			  <span>Apenas inserir se for alterar!</span>
            </div>
            <div>
              <button id="btn-success" type="submit" name="save">Atualizar Perfil</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
<script>
$(document).ready(function() {
	$('.cpf').mask('000.000.000-00', {reverse: true});
});
</script>
</html>