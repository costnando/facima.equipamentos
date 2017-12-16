<?php
$dataUser = dataUser();
?>
			<script src="../../assets/js/jquery.min.js"></script>
			<div id="toolbar">
				<div class="logo">
					<a href="../admin/admin.php">
						<img src="/assets/img/logo.png">
					</a>
				</div>
				<div class="menu-toolbar">
					<nav class="menu">
						<ul>
							<?php if($dataUser->permission_user >= 1) {?><li>
								<a href="../admin/admin.php">
									<span class="icon-home"></span>
									Início
								</a>
							</li><?php } ?>
							<?php if($dataUser->permission_user >= 3) {?><li>
								<a href="../lib/user.php">
									<span class="icon-user"></span>
									Usuários
								</a>
							</li><?php } ?>
							<?php if($dataUser->permission_user >= 1) {?><li>
								<a href="../lib/add_reserve.php">
									<span class="icon-reserve"></span>
									Reservar
								</a>
							</li><?php } ?>
							<?php if($dataUser->permission_user >= 1) {?><li>
								<a href="../lib/stock.php">
									<span class="icon-stock"></span>
									Estoque
								</a>
							</li><?php } ?>
							<?php if($dataUser->permission_user >= 2) {?><li>
								<a href="../lib/stats.php">
									<span class="icon-stats"></span>
									Estatisticas
								</a>
							</li><?php } ?>
						</ul>
					</nav>
				</div>
				<div class="subnavi align-right">
				<?php
					$avatar = $dataUser->avatar;
					if($avatar == "profile.jpg") {
						$avatar = "/assets/img/".$avatar;
					} else {
						$avatar = "/assets/uploads/".$avatar;
					}
				?>
					<img src="<?php echo $avatar; ?>" class="avatar">
					<?php echo $dataUser->full_name_user; ?>
					<ul>
					    <li><a href="../lib/profile.php">Minha Conta</a></li>
						<li><a href="../lib/logout.php">Sair</a></li>
					</ul>
				</div>
			</div>
			<script src="../../assets/js/nando.js"></script>