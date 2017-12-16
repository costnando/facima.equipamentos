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
      <title>Editar Item</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="body_logged">
	 <?php include('../../includes/menu.php'); ?>
      <div class="container">
         <div class="head-content">
          Editar Item (<?php echo $dataEditStock->name_item; ?>)
        </div>
        <div>
		<?php
		if(isset($_POST['save'])) {
			$codigo    = $_POST['codigo'];
			$nome      = $_POST['nome'];
			$descricao = $_POST['descricao'];
			
			if(empty($codigo) OR empty($nome) OR empty($descricao)) {
				echo "<script>alert('Preencha todos os campos!');</script>";
			} else {
				updateStock($id, $codigo, $nome, $descricao);
				echo '<script>alert("Os dados foram salvos com sucesso!");</script>';
				echo '<script>window.location = "/logado/lib/stock.php";</script>';
			}
		}
		?>
          <form method="POST" id="form_field">
            <div>
              <div>
                Código do Item:
              </div>
              <input type="text" name="codigo" placeholder="Código do Item" value="<?php echo $dataEditStock->code_item; ?>">
            </div>
            <div>
              <div>
                Nome do Item:
              </div>
              <input type="text" name="nome" placeholder="Nome do Item" value="<?php echo $dataEditStock->name_item; ?>">
            </div>
            <div>
              <div>
                Descrição do Item:
              </div>
              <input type="text" name="descricao" placeholder="Descrição do Item" value="<?php echo $dataEditStock->description_item; ?>">
            </div>
            <div>
              <button id="btn-success" type="submit" name="save">Atualizar Item</button>
			  <a href="/logado/lib/stock.php" id="btn-default">Voltar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>