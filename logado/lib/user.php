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
      <title>Usuários</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
  </head>
  <body>
    <div class="body_logged">
      <?php include('../../includes/menu.php'); ?>
      <div class="container">
        <table>
          <thead> 
            <div class="head-content">
              Usuários
            </div>              
            <tr>
              <th>Nome Completo:</th>
              <th>Usuário:</th>
              <th>E-mail:</th>
              <th>CPF:</th>
			  <th>Status:</th>
              <th>Permissão:</th>
              <th>Opções:</th>
            </tr>
          </thead>
          <tbody>
			<?php
				$allUsers = allUsers();
				foreach($allUsers as $user) {
					if($user->status == "true") {
						$status = "<font color='#006FA7'>Ativo</font>";
					} elseif($user->status == "false") {
						$status = "<font color='#CC0000'>Inativo</font>";
					}
					
					if($user->permission_user == 1) {
						$permission = "Usuário";
					} elseif($user->permission_user == 2) {
						$permission = "Professor";
					} elseif($user->permission_user == 3) {
						$permission = "Administrador";
					}
			?>
            <tr>
				<td><?php echo $user->full_name_user; ?></td>
				<td><?php echo $user->name_user; ?></td>
				<td><?php echo $user->email_user; ?></td>
				<td><?php echo $user->cpf_user; ?></td>
				<td><?php echo $status; ?></td>
				<td><?php echo $permission; ?></td>
				<td>
					<a href="update_user.php?id=<?php echo $user->id_user; ?>">Atualizar</a> |
					<a class="delete" href="delete_user.php?id=<?php echo $user->id_user; ?>">Remover</a>
				</td>
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