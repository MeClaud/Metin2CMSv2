<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
$notif['update-appname-success'] = false;
$notif['update-appname-error'] = false;
$notif['update-forum-address-success'] = false;
$notif['update-forum-address-error'] = false;
$notif['update-motto-success'] = false;
$notif['update-motto-error'] = false;

if (isset($_POST['settings-save-trigger'])) {
	$setAppname = filter_var($_POST['appname'], FILTER_SANITIZE_STRING);
	$setMotto = filter_var($_POST['motto'], FILTER_SANITIZE_STRING);
	$setForumAddress = filter_var($_POST['forumAddress'], FILTER_SANITIZE_STRING);

	if ($setAppname !== config('appname')) {
		if (updateSettings('appname', $setAppname)) {
			$notif['update-appname-success'] = true;
		} else {
			$notif['update-appname-error'] = true;
		}
	}

	if ($setForumAddress !== config('forum')) {
		if (updateSettings('forum', $setForumAddress)) {
			$notif['update-forum-address-success'] = true;
		} else {
			$notif['update-forum-address-error'] = true;
		}
	}

	if ($setMotto !== config('motto')) {
		if (updateSettings('motto', $setMotto)) {
			$notif['update-motto-success'] = true;
		} else {
			$notif['update-motto-error'] = true;
		}
	}
}
?>
<div class="card p-4 text-light bg-dark">
	<legend>Setari website <a style="float: right;" href="<?= BASE_URI ?>admin/"><i class="fa fa-arrow-left"></i> Inapoi</a></legend>
	<!-- Notifications -->
	<?php if ($notif['update-appname-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Titlul websiteului nu a putut fi salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-appname-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Titlul websiteului a fost salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-forum-address-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Adresa forumului nu a putut fi salvata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-forum-address-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Adresa forumului a fost salvata!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-motto-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Noul motto nu a putut fi salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-motto-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Noul motto a fost salvat!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<!-- /Notifications -->
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<label for="appname" class="control-label col-sm-4">Website Name</label>
			<div class="col-sm-8">
				<input type="text" name="appname" id="appname" class="form-control" value="<?= config('appname') ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="motto" class="control-label col-sm-4">Website Motto</label>
			<div class="col-sm-8">
				<input type="text" name="motto" id="motto" class="form-control" value="<?= config('motto') ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="forumAddress" class="control-label col-sm-4">Forum Address</label>
			<div class="col-sm-8">
				<input type="text" name="forumAddress" id="forumAddress" class="form-control" value="<?= config('forum') ?>">
			</div>
		</div>
		<div class="form-group text-center">
			<button class="btn btn-primary" type="submit" name="settings-save-trigger"><i class="fa fa-save"></i> Save</button>
		</div>
	</form>
</div>