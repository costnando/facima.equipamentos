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
        <title>Reserva Item</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="../../assets/css/datepicker.min.css">
		<link rel="stylesheet" type="text/css" href="../../assets/css/datepicker.nando.css">
		<script src="../../assets/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="body_logged">
            <?php include('../../includes/menu.php'); ?>
            <div class="container">
                <div class="head-content">
                    Reservar Item
                </div>
				<br/>
                <?php
                    if(isset($_POST['save'])) {
						
						$item          = $_POST['item'];
						$quantidade    = $_POST['quantidade'];
						$entrega       = $_POST['entrega'];
						$horaentrega   = $_POST['horaentrega'];
						$devolucao     = $_POST['devolucao'];
						$horadevolucao = $_POST['horadevolucao'];
						$local         = $_POST['local'];
						
						$dataStock = dataStock($item);
						$restanteEstoque = $dataStock->remaining;
						
						if(empty($item) OR empty($quantidade) OR empty($entrega) OR empty($horaentrega) OR empty($devolucao) OR empty($horadevolucao) OR empty($local)) {
							echo "<script>alert('Preencha todos os campos!');</script>";
						} elseif($quantidade > $restanteEstoque) {
							echo "<script>alert('A Quantidade solicitada é maior que a quantidade do estoque!');</script>";
						} else {
							$novoStock = $dataStock->remaining - $quantidade;
							updateStockforReserve($item, $novoStock);
							reserveItem($item, $quantidade, $entrega, $horaentrega, $devolucao, $horadevolucao, $local);
							echo "<script>alert('Reservado com sucesso!');</script>";
						}
					}
                ?>
                <form method="POST" id="form_field">
                    <div>
                        <div>
                            Selecione o item
                        </div>
                        <select name="item">
							<?php
								$getAllStock = getAllStock();
								foreach($getAllStock as $stock) {
							?>
							<option value="<?php echo $stock->id_item; ?>"><?php echo $stock->name_item; ?> (<?php echo $stock->remaining; ?>)</option>
							<?php
								}
							?>
						</select>
						<br/><small>Item (Quantidade no Estoque)</small>
                    </div>
                    <br/>
					
                    <div>
                        <div>
                            Quantidade
                        </div>
                        <input type="number" name="quantidade" min="1" placeholder="Quantidade do produto">
                    </div>
					
                    <div>
                        <div>
                            Data de Entrega
                        </div>
                        <input type="text" name="entrega" class="date" placeholder="Data de Entrega">
                    </div>
					
					<div>
                        <div>
                            Hora de Entrega
                        </div>
                        <input type="text" name="horaentrega" class="hour" placeholder="Hora de Entrega">
                    </div>
					
					<div>
                        <div>
                            Data de Devolução
                        </div>
                        <input type="text" name="devolucao" class="date" placeholder="Data de Devolução">
                    </div>
					
					<div>
                        <div>
                            Hora de Devolução
                        </div>
                        <input type="text" name="horadevolucao" class="hour" placeholder="Hora de Devolução">
                    </div>
					
                    <div>
                        <div>
                            Local de utilização
                        </div>
                        <input type="text" name="local" placeholder="Local de utilização">
                    </div>
					
                    <div>
                        <button id="btn-success" type="submit" name="save">Reservar</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
	
<script src="../../assets/js/jquery.mask.min.js"></script>
<script src="../../assets/js/datepicker.min.js"></script>
<script src="../../assets/js/datepicker.pt-BR.js"></script>

<script>
$(document).ready(function() {
	$(".date").mask("00/00/0000");
	$(".hour").mask("00:00");
});

$(function() {
	$(".date").datepicker({
		autoHide: true,
		language: 'pt-BR',
		autoPick: false,
		zIndex: 2048,
	});
});
</script>
</html>