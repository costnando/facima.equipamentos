<?php
    require_once("../../crud/crud.php");
	if($_SESSION['logged'] == "no-logged") {
		header("Location: index.php");
		exit;
	}
	$dataUser = dataUser();
	if($dataUser->permission_user < 3) {
		header('Location: /logado/admin/admin.php');
	}
?>
<html>
    <head>
        <meta charset ="utf-8">
        <title>Adicionar Items</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    </head>
    <body>
        <div class="body_logged">
            <?php include('../../includes/menu.php'); ?>
            <div class="container">
                <div class="head-content">
                    Cadastrar Novo Item
                </div>
                <div id="backtostock">
                    <a href="stock.php">Voltar para o estoque</a>
                </div>
                <?php
					if(isset($_POST['cadastrar_item'])) {
						
						$code_item        = $_POST['code_item'];
						$name_item        = $_POST['name_item'];
						$amount_item      = $_POST['amount_item'];
						$description_item = $_POST['description_item'];
						$conteudo_item    = $_POST['img_item'];
						
						if(empty($code_item) OR empty($name_item) OR empty($amount_item) OR empty($description_item) OR empty($conteudo_item)) {
							echo "<script>alert('Preencha todos os campos!');</script>";
						} else {
							insertStock($code_item, $name_item, $amount_item, $description_item, $conteudo_item);
							echo "<script>alert('Sucesso!!!');</script>";
						}
						
					}
                ?>
                <form method="POST" id="form_field">
                    <div>
                        <div>
                            Codigo do Item
                        </div>
                        <input type="text" name="code_item" placeholder="Digite o código do item">
                    </div>
                    <div>
                        <div>
                            Nome do Item
                        </div>
                        <input type="text" name="name_item" placeholder="Digite o nome do Item">
                    </div>
                    <div>
                        <div>
                            Descrição do Item
                        </div>
                        <input type="text" name="description_item" placeholder="Digite a descrição do item">
                    </div>
                    <div>
                        <div>
                            Quantidade de itens
                        </div>
                        <input type="number" name="amount_item" min="1" placeholder="Digite a quantidade dos itens">
                    </div>
                    <div>
                        <div>
                            Imagem do Item
                        </div>
                        <input type="file" name="img_item">
                    </div>
                    <div>
                        <input id="btn-success" type="submit" name="cadastrar_item" value="Cadastrar Item">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>