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

	<link rel="stylesheet" href="<?= BASE_URI ?>css/simplex.css">
	<link rel="stylesheet" href="<?= BASE_URI ?>css/custom.css">
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
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="<?= BASE_URI ?>" class="navbar-brand"><?= config('appname') ?></a>
				</div>
				<div class="collapse navbar-collapse" id="main-navigation">
					<ul class="nav navbar-nav">
						<li<?= ($url[0] == 'index') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>"><i class="fa fa-home"></i> Home</a></li>
						<li<?= ($url[0] == 'highscore') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>highscore/"><i class="fa fa-table"></i> Clasament</a></li>
						<li<?= ($url[0] == 'contact') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>download/"><i class="fa fa-download"></i> Descarcare</a></li>
						<li<?= ($url[0] == 'contact') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>forum/"><i class="fa fa-users"></i> Comunitate</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= (!logged_in()) ? 'Guest' : get_user_info($_SESSION['id'], 'nickname') ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php if (logged_in()): ?>
									<li<?= ($url[0] == 'profile') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>profile/"><i class="fa fa-user"></i> Profile</a></li>
									<li<?= ($url[0] == 'premium') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>premium/"><i class="fa fa-star"></i> Premium</a></li>
									<li<?= ($url[0] == 'settings') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>settings/"><i class="fa fa-cog"></i> Account Settings</a></li>
									<li><a href="?logout"><i class="fa fa-sign-out"></i> Sign Out</a></li>
									<?php if(is_admin($_SESSION['id'])) { ?><li<?= ($url[0] == 'admin') ? ' class="active"' : '' ?>><a href="<?= BASE_URI ?>admin/"><i class="fa fa-cogs"></i> Website settings</a></li> <?php } ?>
								<?php else: ?>
									<li><a href="#" data-toggle="modal" data-target="#loginForm"><i class="fa fa-sign-in"></i> Sign In</a></li>
									<li><a href="#" data-toggle="modal" data-target="#registerForm"><i class="fa fa-user-plus"></i> Sign Up</a></li>
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
			<div class="modal fade" id="loginForm" tabindex="-1" role="dialog" aria-labelledby="login">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header"><strong><i class="fa fa-sign-in"></i> Sign In</strong></div>
						<div class="modal-body">
							<form method="POST">
								<div class="form-group">
									<label for="login-username" class="control-label">Username:</label>
									<input type="text" class="form-control" id="login-username" name="login-username">
								</div>
								<div class="form-group">
									<label for="login-password" class="control-label">Password:</label>
									<input type="password" class="form-control" id="login-password" name="login-password">
								</div>
								<div class="form-group">
									<center>
										<button type="submit" name="login-trigger" class="btn btn-primary"><i class="fa fa-sign-in"></i> Sign In</button>
									</center>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="registerForm" tabindex="-1" role="dialog" aria-labelledby="register">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header"><strong><i class="fa fa-user-plus"></i> Inregistrare</strong></div>
						<div class="modal-body">
							<form method="POST">
								<div class="form-group">
									<label for="register-username" class="control-label">Nume utilizator:</label>
									<input type="text" class="form-control" id="register-username" name="register-username" placeholder="john.smith">
								</div>
								<div class="form-group">
									<label for="register-nickname" class="control-label">Porecla:</label>
									<input type="text" class="form-control" id="register-nickname" name="register-nickname" placeholder="John Smith">
								</div>
								<div class="form-group">
									<label for="register-email" class="control-label">Your Email:</label>
									<input type="email" class="form-control" id="register-email" name="register-email" placeholder="john@smith.com">
								</div>
								<div class="form-group">
									<label for="register-password" class="control-label">Password:</label>
									<input type="password" class="form-control" id="register-password" name="register-password">
								</div>
								<div class="form-group">
									<label for="register-password-confirmation" class="control-label">Repeat Password:</label>
									<input type="password" class="form-control" id="register-password-confirmation" name="register-password-confirmation">
								</div>
								<div class="form-group">
									<label for="register-security-core" class="control-label">Cod siguranta caractere:</label>
									<input type="text" class="form-control" id="register-security-core" name="register-security-core" placeholder="John Smith">
								</div>
								<div class="form-group">
									<center>
										<button type="submit" name="register-trigger" class="btn btn-primary"><i class="fa fa-user-plus"></i> Register</button>
									</center>	
									<ul class="list-unstyled text-right">
										<li><a href="#" data-toggle="modal" data-target="#registerForm">Ai deja un cont?</a></li>
										<li><a href="<?= BASE_URI ?>pwreset/">Parola uitata?</a></li>
									</ul>									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /MODALS -->
			<div class="logo">
				<img src="<?= BASE_URI ?>img/logo.png" alt="">
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="well">
							<div class="pull-left clock" style="width: 100px;"></div>
							<div class="pull-right date" style="width: 150px; text-align: right;"></div>
							<center>
								<b>
									<?php 
										$stats = getServerStatus();
									?>
									Jucatori Online: <?= $stats['online_players'] ?> | 
									<?php if ($stats['status'] === true) {echo '<span class="label label-success">SERVER ONLINE  <i class="fa fa-arrow-up"></i></span></span>';} else {echo '<span class="label label-danger">SERVER OFFLINE <i class="fa fa-arrow-down"></i></span>';}?>
									 | Conturi create: <?= $stats['accounts'] ?>
								</b>
							</center>
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
				<div class="row">
			<div class="col-xs-8">
				<?php require $page_file; ?>	
			</div>
				<div class="col-xs-4">
			<div class="well">
				<a href="#" data-toggle="modal" data-target="#registerForm" type="button" class="btn btn-success btn-lg btn-block">Joaca acum</a>
				<a href="<?= config('forum') ?>" type="button" class="btn btn-primary btn-lg btn-block">Comunitate</a>
				<a href="<?= BASE_URI ?>download/" type="button" class="btn btn-warning btn-lg btn-block">Descarcare</a>
			</div>
			<div class="panel panel-default tab-content">
				<div class="panel-heading">
					<center><b><i class="fa fa-trophy"></i> Top 10 </b></center>
				</div>
				<div role="tabpanel" class="tab-pane active" id="top10-players">
					<table class="table table-bordered table-responsive table-center" style="margin-bottom: 0px;">
						<thead>
							<th class="col-sm-1">#</th>
							<th class="col-sm-9">Nume</th>
							<th class="col-sm-1">Nivel</th>
							<th class="col-sm-1">Regat</th>
						</thead>
						<tbody>
							<?php
							$top10_players = getHighscore(0, 10, false);
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
						<tr>
							<td colspan="4" role="tablist" role="presentation"><a class="btn btn-default btn-sm" href="#top10-guilds" aria-expanded="true" aria-controls="top10-guilds" role="tab" data-toggle="tab">Bresle</a></td>
						</tr>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane" id="top10-guilds">
					<table class="table table-bordered table-responsive table-center" style="margin-bottom: 0px;">
						<thead>
							<th class="col-sm-1">#</th>
							<th class="col-sm-10">Nume</th>
							<th class="col-sm-1">Regat</th>
						</thead>
						<tbody>
					<?php
						$top10_guilds = getHighscore(0, 10, true);
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
						<tr>
							<td colspan="3" role="tablist"><a class="btn btn-default btn-sm" href="#top10-players" aria-controls="top10-players" role="tab" data-toggle="tab">Jucatori</a></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

			</div>
	</main>
	<footer>
		<p>
			Copyright &copy; <a href="<?= BASE_URI ?>"><?= config('appname') ?></a> <?= date('Y') ?>. All rights reserved<br>
			<i class="fa fa-code"></i> cms by <a href="https://meclaud.github.io">MeClaud</a>
		</p>
	</footer>
	<script src="<?= BASE_URI ?>js/jquery-3.1.1.min.js"></script>
	<script src="<?= BASE_URI ?>js/bootstrap.js"></script>
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
