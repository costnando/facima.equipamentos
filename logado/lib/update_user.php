<?php
	require_once("../../crud/crud.php");
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$id = $_GET['id'];
	$verifyUser = verifyUser($id);
	if($verifyUser->status != "ok") {
		header('Location: /logado/lib/user.php');
	}
	$dataUser = dataUser();
	$dataEditUser = dataEditUser($id);
	if($dataUser->permission_user < 3) {
		header('Location: /logado/admin/admin.php');
	}
?>
<html>
  <head>
    <meta charset ="utf-8">
      <title>Editar Usuário</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Editar usuário (<?php echo $dataEditUser->email_user; ?>)
        </div>
        <div>
		<?php
		if(isset($_POST['save'])) {
			
			$usuario   = $_POST['usuario'];
			$nome      = $_POST['nome'];
			$cpf       = $_POST['cpf'];
			$email     = $_POST['email'];
			$status    = $_POST['status'];
			$permissao = $_POST['permissao'];
			$senha     = $_POST['senha'];
			
			if(empty($usuario) OR empty($nome) OR empty($cpf) OR empty($email) OR empty($status) OR empty($permissao)) {
				echo '<script>alert("Preencha os campos obrigatórios!");</script>';
			} elseif(!val_email($email)) {
				echo '<script>alert("E-mail inserido não é válido!");</script>';
			} elseif(!val_cpf($cpf)) {
				echo '<script>alert("CPF inserido não é válido!");</script>';
			} else {
				$perfil = editUser($id, $usuario, $nome, $cpf, $email, $status, $permissao, $senha);
				echo '<script>alert("Os dados foram salvos com sucesso!");</script>';
				echo '<script>window.location = "/logado/lib/user.php";</script>';
			}
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Nome de usuário:
              </div>
              <input type="text" name="usuario" placeholder="Nome de usuário" value="<?php echo $dataEditUser->name_user; ?>">
            </div>
            <div>
              <div>
                Nome Completo:
              </div>
              <input type="text" name="nome" placeholder="Nome Completo" value="<?php echo $dataEditUser->full_name_user; ?>">
            </div>
            <div>
              <div>
                Cpf:
              </div>
              <input type="text" name="cpf" placeholder="CPF" class="cpf" value="<?php echo $dataEditUser->cpf_user; ?>">
              </div>
            <div>
              <div>
                Email:
              </div>
              <input type="text" name="email" placeholder="E-mail" value="<?php echo $dataEditUser->email_user; ?>">
            </div>
            <div>
			<div>
              <div>
                Status:
              </div>
              <select name="status">
				<option value="true"<?php if($dataEditUser->status == "true") echo " selected" ?>>Ativo</option>
				<option value="false"<?php if($dataEditUser->status == "false") echo " selected" ?>>Inativo</option>
			  </select>
            </div>
			<div>
              <div>
                Permissão:
              </div>
              <select name="permissao">
				<option value="1"<?php if($dataEditUser->permission_user == 1) echo " selected" ?>>Usuário</option>
				<option value="2"<?php if($dataEditUser->permission_user == 2) echo " selected" ?>>Professor</option>
				<option value="3"<?php if($dataEditUser->permission_user == 3) echo " selected" ?>>Administrador</option>
			  </select>
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
			  <a href="/logado/lib/user.php" id="btn-default">Voltar</a>
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