<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in()) {redirect(BASE_URI, 'php');}

$notif['nickname-change-success'] = false;
$notif['nickname-change-error'] = false;
$notif['current-password-error'] = false;
$notif['email-address-error'] = false;
$notif['email-address-change-succes'] = false;
$notif['email-address-change-error'] = false;
$notif['password-change-confirmation-error'] = false;
$notif['password-change-confirmation-match-error'] = false;
$notif['password-change-invalid'] = false;
$notif['password-change-success'] = false;

if (isset($_POST['save-settings-trigger'])) {
	$set_nickname = filter_var($_POST['newNickname'], FILTER_SANITIZE_STRING);
	$set_email = filter_var($_POST['newEmail'], FILTER_SANITIZE_STRING);
	$set_password = filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING);
	$currentPassword = filter_var($_POST['currentPassword'], FILTER_SANITIZE_STRING);

	if (!empty($_POST['newNickname']) && $set_nickname !== get_user_info($_SESSION['id'], 'nickname')) {
		$fct1 = editAccount($_SESSION['id'], "real_name", $set_nickname);
		if ($fct1) {
			$notif['nickname-change-success'] = true;
			redirect("#", 'html', 2);
		} else {
			$notif['nickname-change-error'] = true;
		}
	}
	if (!empty($_POST['newEmail'])){
		if (checkPassword($_SESSION['id'], $currentPassword)){
			if (filter_var($set_email, FILTER_VALIDATE_EMAIL)) {
				$fct2 = editAccount($_SESSION['id'], 'email', $set_email);
				if ($fct2) {
					$notif['email-address-change-succes'] = true;
				} else {
					$notif['email-address-change-error'] = true;
				}
			} else {
				$notif['email-address-error'] = true;
			}
		} else {
			$notif['current-password-error'] = true;
		}
	}
	if (!empty($_POST['newPassword'])) {
		if (!empty($_POST['newPasswordRepeat']) && checkPassword($_SESSION['id'], $currentPassword)) {
			if ($set_password == $_POST['newPasswordRepeat']) {
				$fct3 = editAccount($_SESSION['id'], 'password', $set_password);
				if ($fct3) {
					$notif['password-change-success'] = true;
				} else {
					$notif['password-change-invalid'] = true;
				}
			} else {
				$notif['password-change-confirmation-match-error'] = true;
			}
		} else {
			$notif['password-change-confirmation-error'] = true;
		}
	}
}

?>
<div class="well">
	<legend>Setari cont</legend>
	<!-- Notifications -->
	<?php if ($notif['nickname-change-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Noul nickname a fost salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['nickname-change-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Noul nickname a putut fi salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['current-password-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Parola actuala a contului este incorecta!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['email-address-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Adresa de email introdusa este incorecta!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['email-address-change-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Adresa de email nu a putut fi modificata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['email-address-change-succes']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Succes!</strong> Adresa de email a fost modificata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['password-change-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Succes!</strong> Parola a fost modificata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['password-change-invalid']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Parola noua este invalida si nu a putut fi modificata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['password-change-confirmation-match-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Parolele nu corespund!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['password-change-confirmation-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Confirmati parola noua!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<!-- /Notifications -->
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<label class="col-lg-4 control-label" for="userName">Username:</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" disabled="" id="userName" value="<?= get_user_info($_SESSION['id'], 'username'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="newNickname">Nickname:</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" name="newNickname" id="newNickname" value="<?= get_user_info($_SESSION['id'], 'nickname'); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="currentEmail">Current Email:</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" disabled="" name="currentEmail" id="currentEmail" value="<?= get_user_info($_SESSION['id'], 'email'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="newEmail">New Email:</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" name="newEmail" id="newEmail">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="newPassword">New password:</label>
			<div class="col-lg-8">
				<input type="password" class="form-control" name="newPassword" id="newPassword">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="newPasswordRepeat">Repeat the new password:</label>
			<div class="col-lg-8">
				<input type="password" class="form-control" name="newPasswordRepeat" id="newPasswordRepeat">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-lg-4 control-label" for="currentPassword">Current password:</label>
			<div class="col-lg-8">
				<input type="password" class="form-control" name="currentPassword" id="currentPassword">
			</div>
		</div>
		<hr>
		<div class="form-group text-center">
			<button type="submit" name="save-settings-trigger" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
		</div>
	</form>
</div>