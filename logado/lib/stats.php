<?php
    require "../../crud/crud.php";
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$dataUser = dataUser();
?>
<html>
    <head>
        <meta charset ="utf-8">
        <title>Estatísticas</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="../../assets/css/morris.css">
		<script src="../../assets/js/jquery.min.js"></script>
		<script src="../../assets/js/other.min.js"></script>
		<script src="../../assets/js/morris.min.js"></script>
    </head>
    <body>
        <div class="body_logged">
			<?php include('../../includes/menu.php'); ?>
			<div class="container">
                <div class="head-content">
                    Estatísticas
				</div>
                <div class="body-content"><br><br>
					<div id="stats-facima"></div>
				</div>
            </div>
        </div>
    </body>
	
<script>
Morris.Bar({
	element: 'stats-facima',
	data: [
	<?php
	$getStock = getAllStock();
	foreach($getStock as $stock) {
	?>
		{produto: '<?php echo ucfirst($stock->name_item); ?>', quantidade: <?php echo $stock->amount_item; ?>, restante: <?php echo $stock->remaining; ?>},
	<?php
	}
	?>
	],
	xkey: 'produto',
	ykeys: ['quantidade','restante'],
	labels: ['Quantidade','Disponível'],
	barRatio: 0.4,
	xLabelAngle: 35,
	hideHover: 'auto'
});
</script>

</html>