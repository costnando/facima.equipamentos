<?php
	require_once("../../crud/crud.php");
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$id = $_GET['id'];
	$verifyStock = verifyStock($id);
	if($verifyStock->status != "ok") {
		header('Location: /logado/lib/stock.php');
	}
	$dataUser = dataUser();
	$dataEditStock = dataEditStock($id);
	if($dataUser->permission_user < 3) {
		header('Location: /logado/admin/admin.php');
	}
?>
<html>
  <head>
    <meta charset ="utf-8">
      <title>Deletar Item</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Deletar Item (<?php echo $dataEditStock->name_item; ?>)
        </div>
        <div>
		<?php
		if(isset($_POST['delete'])) {
			deleteStock($id);
			deleteReserveforStock($id);
			echo '<script>alert("Item deletado com sucesso!");</script>';
			echo '<script>window.location = "/logado/lib/stock.php";</script>';
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Você realmente deseja deletar esse item?
              </div>
            </div>
            <div>
              <button id="btn-success" type="submit" name="delete">Deletar</button>
			  <a href="/logado/lib/stock.php" id="btn-default">Cancelar</a>
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