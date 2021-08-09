<?php 
	session_start();
	ob_start();

	define('RETRO_MODE', true);


	require 'include/config.php';
	require 'include/functions.php';
	require 'include/core.php';
	require 'include/bootstrap.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $page_title ?></title>

	<link rel="stylesheet" href="<?= BASE_URI ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= BASE_URI ?>css/m2cmsv2.css">
	<link rel="stylesheet" href="<?= BASE_URI ?>css/font-awesome.css">

	<link rel="icon" href="<?= BASE_URI ?>img/favicon.png">

	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container-xxl">
				<a href="<?= BASE_URI ?>" class="navbar-brand"><?= config('appname') ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse d-flex" id="navbarNav">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link <?= $url[0] !== 'index' ?: ' active'?>" href="<?= BASE_URI ?>"><i class="fa fa-home fa-fw"></i> Home</a>
						</li>
						<li class="nav-item"><a class="nav-link <?= $url[0] !== 'highscore' ?: ' active'?>" href="<?= BASE_URI ?>highscore/"><i class="fa fa-trophy fa-fw"></i> Clasament</a></li>
						<li class="nav-item"><a class="nav-link <?= $url[0] !== 'download' ?: ' active'?>" href="<?= BASE_URI ?>download/"><i class="fa fa-download fa-fw"></i> Descarcare</a></li>
						<li class="nav-item"><a class="nav-link" href="<?= BASE_URI ?>forum/"><i class="fa fa-users"></i> Comunitate</a></li>
					</ul>
					
					<ul class="navbar-nav justify-content-end">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="user-menu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-user-circle-o fa-fw"></i> <?= (!logged_in()) ? 'Guest' : get_user_info($_SESSION['id'], 'nickname') ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="user-menu">
								<?php if (logged_in()): ?>
									<li><a class="dropdown-item <?= $url[0] !== 'profile' ?: ' active'?>" href="<?= BASE_URI ?>profile/"><i class="fa fa-user"></i> Profile</a></li>
									<li><a class="dropdown-item <?= $url[0] !== 'premium' ?: ' active'?>" href="<?= BASE_URI ?>premium/"><i class="fa fa-star"></i> Premium</a></li>
									<li><a class="dropdown-item <?= $url[0] !== 'settings' ?: ' active'?>" href="<?= BASE_URI ?>settings/"><i class="fa fa-cog"></i> Account Settings</a></li>
									<li><a class="dropdown-item" href="?logout"><i class="fa fa-sign-out"></i> Sign Out</a></li>
									<?php if(is_admin($_SESSION['id'])) { ?>
									<li>
										<a class="dropdown-item <?= $url[0] !== 'admin%' ?: ' active'?>" href="<?= BASE_URI ?>admin/"><i class="fa fa-cogs"></i> Website settings</a>
									</li> 
									<?php } ?>
								<?php else: ?>
									<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginForm"><i class="fa fa-sign-in"></i> Sign In</a></li>
									<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerForm"><i class="fa fa-user-plus"></i> Sign Up</a></li>
								<?php endif ?>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<main>
		<!-- MODALS -->
			<div class="modal fade" id="loginForm" tabindex="-1" aria-labelledby="login" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header"><strong><i class="fa fa-sign-in"></i> Sign In</strong></div>
						<div class="modal-body p-3">
							<form method="POST">
								<div class="mb-3">
									<label for="login-username" class="form-label">Username:</label>
									<input type="text" class="form-control bg-dark text-light border-secondary" id="login-username" name="login-username">
								</div>
								<div class="mb-3">
									<label for="login-password" class="form-label">Password:</label>
									<input type="password" class="form-control bg-dark text-light border-secondary" id="login-password" name="login-password">
								</div>
								<div class="text-center">
									<button type="submit" name="login-trigger" class="btn btn-dark border-secondary"><i class="fa fa-sign-in"></i> Sign In</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="registerForm" tabindex="-1" aria-labelledby="register" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header"><strong><i class="fa fa-user-plus"></i> Inregistrare</strong></div>
						<div class="modal-body">
							<form method="POST">
								<div class="mb-3">
									<label for="register-username" class="form-label">Nume utilizator:</label>
									<input type="text" class="form-control bg-dark text-light border-secondary" id="register-username" name="register-username" placeholder="john.smith">
								</div>
								<div class="mb-3">
									<label for="register-nickname" class="form-label">Porecla:</label>
									<input type="text" class="form-control bg-dark text-light border-secondary" id="register-nickname" name="register-nickname" placeholder="John Smith">
								</div>
								<div class="mb-3">
									<label for="register-email" class="form-label">Adresa E-Mail:</label>
									<input type="email" class="form-control bg-dark text-light border-secondary" id="register-email" name="register-email" placeholder="john@smith.com">
								</div>
								<div class="mb-3">
									<label for="register-password" class="form-label">Parola:</label>
									<input type="password" class="form-control bg-dark text-light border-secondary" id="register-password" name="register-password">
								</div>
								<div class="mb-3">
									<label for="register-password-confirmation" class="form-label">Repeta Parola:</label>
									<input type="password" class="form-control bg-dark text-light border-secondary" id="register-password-confirmation" name="register-password-confirmation">
								</div>
								<div class="mb-3">
									<label for="register-security-core" class="form-label">Cod siguranta caractere:</label>
									<input type="text" class="form-control bg-dark text-light border-secondary" id="register-security-core" name="register-security-core" placeholder="John Smith">
								</div>
								<div class="text-center">
									<button type="submit" name="register-success" class="btn btn-dark border-secondary"><i class="fa fa-user-plus"></i> Inregistrare</button>
									<ul class="list-unstyled text-start">
										<li><a href="<?= BASE_URI ?>pwreset/" class="link-light">Parola uitata?</a></li>
									</ul>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /MODALS -->
			<div class="logo my-5 text-center">
				<img src="<?= BASE_URI ?>img/logo.png" alt="">
			</div>
			<div class="container-lg">
				<div class="row my-2">
					<div class="col-sm-3 mb-1 text-center">
						<div class="card p-3 bg-dark text-light clock"></div>
					</div>
					<div class="col-sm-6 mb-1 text-center">
						<div class="card p-3 bg-dark text-light">
							<div class="row">
								<div class="col-sm-4">Jucatori Online: <?= $serverStatus['online_players'] ?></div>
								<div class="col-sm-4">
									<?php if ($serverStatus['status'] == 'online'): ?>
									<span class="badge bg-success">SERVER ONLINE <i class="fa fa-arrow-up fa-fw"></i></span>
									<?php elseif ($serverStatus['status'] == 'offline'): ?>
									<span class="badge bg-danger">SERVER OFFLINE <i class="fa fa-arrow-down fa-fw"></i></span>
									<?php else: ?>
									<span class="badge bg-danger">SERVER CLOSED <i class="fa fa-ban fa-fw"></i></span>
									<?php endif; ?>
								</div>
								<div class="col-sm-4">Conturi create: <?= $serverStatus['accounts'] ?></div>	
							</div>
						</div>
					</div>
					<div class="col-sm-3 mb-1 text-center">
						<div class="card p-3 bg-dark text-light date"></div>
					</div>
				</div>
				
				<?php if ($notif['user-exists']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Inregistrarea nu s-a putut realiza! <br />
						Acest nume de utilizator este deja folosit!
					</div>
				<?php endif ?>
				<?php if ($notif['register-passwords-confirmation-failed']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Inregistrarea nu s-a putut realiza! <br />
						Parolele nu corespund!
					</div>
				<?php endif ?>
				<?php if ($notif['register-username-invalid']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Inregistrarea nu s-a putut realiza! <br />
						Campul username nu indeplineste conditiile! <br />
					</div>
				<?php endif ?>
				<?php if ($notif['register-success']): ?>
					<div class="alert alert-success auto-remove">
						<strong>Succes!</strong> Inregistrarea s-a realizat cu succes! <br />
						Va puteti autentifica acum! <br />
					</div>
				<?php endif ?>
				<?php if ($notif['register-failed']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Inregistrarea nu s-a putut realiza! <br />
					</div>
				<?php endif ?>
				<?php if ($notif['login-success']): ?>
					<div class="alert alert-success auto-remove">
						<strong>Succes!</strong> Autentificarea s-a realizat cu succes!
					</div>
				<?php endif ?>
				<?php if ($notif['login-failed']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Autentificarea nu s-a putut realiza! <br />
						Parola este incorecta!
					</div>
				<?php endif ?>
				<?php if ($notif['user-is-banned']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Autentificarea nu s-a putut realiza! <br />
						Verificati numele de utilizator si parola!
					</div>
				<?php endif ?>
				<?php if ($notif['user-invalid']): ?>
					<div class="alert alert-danger">
						<strong>Oooops...</strong> Autentificarea nu s-a putut realiza! <br />
						Acest cont nu exista!
					</div>
				<?php endif ?>
				</div>
			</div>
		<div class="container-lg mt-2">
			<div class="row">
				<div class="col-sm-9">
					<?php require $page_file; ?>	
				</div>
				<div class="col-sm-3">		
					<div class="card bg-dark text-light tab-content text-center">
						<h5 class="card-header">
							<i class="fa fa-trophy"></i> Top 10 </b>
						</h5>
						<div class="card-body">
							<ul class="nav nav-tabs justify-content-center" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="top10-players-tab" data-bs-toggle="tab" data-bs-target="#top10-players" type="button" role="tab" aria-controls="top10-players" aria-selected="true">Jucatori</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="top10-guilds-tab" data-bs-toggle="tab" data-bs-target="#top10-guilds" type="button" role="tab" aria-controls="top10-guilds" aria-selected="false">Bresle</button>
								</li>
							</ul>
							<div class="tab-content" id="top-10-tab-content">
								<div class="tab-pane fade show active" id="top10-players" role="tabpanel" aria-labelledby="top10-players">
									<div class="table-responsive">
										<table class="table table-bordered text-light">
											<thead>
												<th class="col-sm-1">#</th>
												<th class="col-sm-9">Nume</th>
												<th class="col-sm-1">Nivel</th>
												<th class="col-sm-1">Regat</th>
											</thead>
											<tbody>
												<?php
												$i = 0;
												foreach($top10_players as $k => $v){
													$i++;
														if ($i == 1) {
															$a = '<i class="fa fa-trophy" style="color:gold; text-shadow: 0 0 1px black;"></i>';
														} elseif ($i == 2) {
															$a = '<i class="fa fa-trophy" style="color:silver; text-shadow: 0 0 1px black;"></i>';
														} elseif ($i == 3) {
															$a = '<i class="fa fa-trophy" style="color:orange; text-shadow: 0 0 1px black;"></i>';
														} else {
															$a = $i;
															}
												?>
													<tr>
														<td><?= $a ?></td>
														<td><?= $v['name'] ?></td>
														<td><?= $v['level'] ?></td>
														<td><img src="<?= BASE_URI ?>img/empires/<?= $v['empire'] ?>.jpg" width="28px;"></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="top10-guilds" role="tabpanel" aria-labelledby="top10-guilds">
									<div class="table-responsive">
										<table class="table table-bordered text-light">
											<thead>
												<th class="col-sm-1">#</th>
												<th class="col-sm-10">Nume</th>
												<th class="col-sm-1">Regat</th>
											</thead>
											<tbody>
											<?php
												$i = 0;
												foreach($top10_guilds as $k => $v){
													$i++;
														if ($i == 1) {
															$a = '<i class="fa fa-trophy" style="color:gold; text-shadow: 0 0 1px black;"></i>';
														} elseif ($i == 2) {
															$a = '<i class="fa fa-trophy" style="color:silver; text-shadow: 0 0 1px black;"></i>';
														} elseif ($i == 3) {
															$a = '<i class="fa fa-trophy" style="color:orange; text-shadow: 0 0 1px black;"></i>';
														} else {
															$a = $i;
														}
											?>
											<tr>
												<td><?= $a ?></td>
												<td><?= $v['name'] ?></td>
												<td><img src="<?= BASE_URI ?>img/empires/<?= $v['empire'] ?>.jpg" width="28px;"></td>
											</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			</div>
	</main>
	<footer>
		<div class="text-light text-center">
			Copyright &copy; <a href="<?= BASE_URI ?>" class="link-light"><?= config('appname') ?></a> <?= date('Y') ?>. All rights reserved<br>
			<i class="fa fa-code"></i> cms by <a href="https://github.com/MeClaud" class="link-light">MeClaud</a>
		</div>
	</footer>
	<script src="<?= BASE_URI ?>js/jquery-3.1.1.min.js"></script>
	<script src="<?= BASE_URI ?>js/bootstrap.bundle.min.js"></script>
	<script src="<?= BASE_URI ?>js/alert.remover.js"></script>
	<script src="<?= BASE_URI ?>js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
		selector: 'textarea',
		plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: '//www.tinymce.com/css/codepen.min.css'
	});
	</script>
	<!-- Ceas/data start -->
	<script>
		// Ceas
		$(document).ready(function() {
			updateTime();
			clock = window.setInterval(updateTime, 1000);
		});

		function updateTime() {
			var d = new Date;
			var hours = d.getHours();
			var mins = d.getMinutes();
			var secs = d.getSeconds();

			var time = hours + " : " + mins + ' : ' + secs;
			$(".clock").html(time);
		}

		// Data
		$(document).ready(function() {
			var date = new Date;
			var day = date.getDay();
			var mDay = date.getDate();
			var month = date.getMonth();
			var year = date.getFullYear();
			var dayNames = ['Duminică', 'Luni', 'marți', 'Miercuri', 'Joi', 'Vineri', 'Sâmbătă'];

			var day = dayNames[day];
			$(".date").html(day + ', ' + mDay + '/' + month + '/' + year);
		});
	</script>
	<!-- /Ceas/data -->
</body>
</html>
