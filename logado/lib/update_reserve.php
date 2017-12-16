<?php
	require_once("../../crud/crud.php");
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$id = $_GET['id'];
	$verifyReserve = verifyReserve($id);
	if($verifyReserve->status != "ok") {
		header('Location: /logado/admin/admin.php');
	}
	$dataUser = dataUser();
	$dataEditReserve = dataEditReserve($id);
	if($dataUser->permission_user < 3) {
		header('Location: /logado/admin/admin.php');
	}
	$dataReserve = dataReserve($id);
	if($dataReserve->status == 3) {
		header('Location: /logado/admin/admin.php');
	}
?>
<html>
  <head>
    <meta charset ="utf-8">
      <title>Editar Pedido</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Editar Pedido (<?php echo $dataEditReserve->id_reserve; ?>)
        </div>
        <div>
		<?php
		if(isset($_POST['save'])) {
			$status = $_POST['status'];
			
			$dataReserve = dataReserve($id);
			
			$dataStock = dataStock($dataEditReserve->item);
			
			$novoStock = $dataStock->remaining + $dataReserve->quantidade;
			
			if(empty($status)) {
				echo "<script>alert('Preencha todos os campos!');</script>";
			} elseif($status == 3) {
				updateReserve($id, $status);
				updateStockforReserve($dataEditReserve->item, $novoStock);
				echo '<script>alert("Os dados foram salvos com sucesso!");</script>';
				echo '<script>window.location = "/logado/admin/admin.php";</script>';
			} else {
				updateReserve($id, $status);
				echo '<script>alert("Os dados foram salvos com sucesso!");</script>';
				echo '<script>window.location = "/logado/admin/admin.php";</script>';
			}
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Status do Pedido:
              </div>
              <select name="status">
				<option value="1"<?php if($dataEditReserve->status == 1) echo " selected" ?>>Pendente</option>
				<option value="2"<?php if($dataEditReserve->status == 2) echo " selected" ?>>Entregue</option>
				<option value="3"<?php if($dataEditReserve->status == 3) echo " selected" ?>>Devolvido</option>
			  </select>
            </div>
            <div>
              <button id="btn-success" type="submit" name="save">Atualizar</button>
			  <a href="/logado/admin/admin.php" id="btn-default">Voltar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>