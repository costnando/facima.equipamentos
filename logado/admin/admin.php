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
		<title>Administrador</title>
		<link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	</head>
	<body>
		<div class="body_logged">
			<?php include('../../includes/menu.php'); ?>
			<div class="container">
				<table>
					<thead> 
						<div class="head-content">
							Reservados
						</div>             
						<tr>
							<th>Pedido:</th>
							<th>Data de pedido:</th>
							<th>Data de Entrega:</th>
							<th>Hora de Entrega:</th>
							<th>Data de Devolução:</th>
							<th>Hora de Devolução:</th>
							<th>Itens do Pedido:</th>
							<th>Local de Entrega:</th>
							<th>Solicitante:</th>
							<th>Status:</th>
							<?php if($dataUser->permission_user >= 3) {?><th>Ação:</th><?php } ?>
						</tr>
					</thead>
					<tbody id="content-table">
						<?php
							if($dataUser->permission_user >= 3) {
								$getPedidos = getReserve();
							} else {
								$getPedidos = getReserve("user=".$dataUser->id_user);
							}
							foreach($getPedidos as $pedido) {
								
								// getDataStock
								$getDataStock = getDataStock($pedido->item);
								
								// getDataUserStock
								$getDataUserStock = getDataUserStock($pedido->user);
								
								// Status Reserve
								if($pedido->status == 1) {
									$status = "<font color='#FFA500'>Pendente</font>";
								} elseif($pedido->status == 2) {
									$status = "<font color='#1A9100'>Entregue</font>";
								} elseif($pedido->status == 3) {
									$status = "<font color='#0058BC'>Devolvido</font>";
								}
						?>
						<tr>
							<td><?php echo $pedido->id_reserve; ?></td>
							<td><?php echo date('d/m/Y', $pedido->date_reserve); ?></td>
							<td><?php echo $pedido->delivery_reserve; ?></td>
							<td><?php echo $pedido->horaentrega; ?></td>
							<td><?php echo $pedido->devolution; ?></td>
							<td><?php echo $pedido->horadevolucao; ?></td>
							<td><?php echo $getDataStock->name_item ." (". $pedido->quantidade .")" ?></td>
							<td><?php echo $pedido->local_reserve; ?></td>
							<td><?php echo $getDataUserStock->full_name_user; ?></td>
							<td><?php echo $status; ?></td>
							<?php if($dataUser->permission_user >= 3) {?><td><?php 
								if($pedido->status != 3) {
								?>
									<?php if($dataUser->permission_user >= 3) {?><a href="../lib/update_reserve.php?id=<?php echo $pedido->id_reserve; ?>">Atualizar</a><?php } ?>
								<?php
								} else {
									echo "<font color='#ff0000'>Entregue</font>";
								}
							?></td><?php } ?>
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