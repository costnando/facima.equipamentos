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
      <title>Deletar Usuário</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Deletar usuário (<?php echo $dataEditUser->email_user; ?>)
        </div>
        <div>
		<?php
		if(isset($_POST['delete'])) {
			deleteUser($id);
			echo '<script>alert("Usuário deletado com sucesso!");</script>';
			echo '<script>window.location = "/logado/lib/user.php";</script>';
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Você realmente deseja deletar esse usuário?
              </div>
            </div>
            <div>
              <button id="btn-success" type="submit" name="delete">Deletar</button>
			  <a href="/logado/lib/user.php" id="btn-default">Cancelar</a>
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