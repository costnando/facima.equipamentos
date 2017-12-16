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
        <title>Estoque</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    </head>
    <body>
        <div class="body_logged">
            <?php include('../../includes/menu.php'); ?>
            <div class="container">
                <table>
                    <thead>
                        <div class="head-content">
                            Estoque
                        </div>
                        <?php if($dataUser->permission_user >= 3) {?><div id="add-stock">
                            <a href="add_stock.php">
                              <span class="icon-addstock"></span>
                              Adicionar Itens no Estoque
                            </a>
                        </div><?php } ?>
                        <tr>
                            <th>Codigo</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
				            <th>Restante</th>
                            <?php if($dataUser->permission_user >= 3) {?><th>Opção</th><?php } ?>
                        </tr>
                    </thead>
				    <br/>
                    <tbody>
    					<?php
    						$getStock = getStock();
    						foreach($getStock as $stock) {
    					?>
                        <tr>
    						<td><?php echo $stock->code_item; ?></td>	
    						<td><?php echo $stock->name_item; ?></td>
    						<td><?php echo $stock->description_item; ?></td>
    						<td><?php echo $stock->amount_item; ?></td>
    						<td><?php echo $stock->remaining; ?></td>
    						<?php if($dataUser->permission_user >= 3) {?><td>
    							<a href="update_stock.php?id=<?php echo $stock->id_item; ?>">Atualizar</a> |
    							<a class="delete" href="delete_stock.php?id=<?php echo $stock->id_item; ?>">Remover</a>
    						</td><?php } ?>
    					</tr>
    					<?php
    						}
    					?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>