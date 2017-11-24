<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
$notif['update-status-direct-success'] = false;
$notif['update-status-direct-error'] = false;
$notif['update-status-torrent-success'] = false;
$notif['update-status-torrent-error'] = false;
$notif['update-status-mirror-success'] = false;
$notif['update-status-mirror-error'] = false;
$notif['update-url-direct-success'] = false;
$notif['update-url-direct-error'] = false;
$notif['update-url-torrent-success'] = false;
$notif['update-url-torrent-error'] = false;
$notif['update-url-mirror-success'] = false;
$notif['update-url-mirror-error'] = false;


if (isset($_POST['save-settings-trigger'])) {
	$statusDirect = filter_var($_POST['statusDirect'], FILTER_SANITIZE_STRING);
	$statusTorrent = filter_var($_POST['statusTorrent'], FILTER_SANITIZE_STRING);
	$statusMirror = filter_var($_POST['statusMirror'], FILTER_SANITIZE_STRING);
	$urlDirect = filter_var($_POST['urlDirect'], FILTER_SANITIZE_STRING);
	$urlTorrent = filter_var($_POST['urlTorrent'], FILTER_SANITIZE_STRING);
	$urlMirror = filter_var($_POST['urlMirror'], FILTER_SANITIZE_STRING);

	if ($statusDirect !== config('download-direct-enabled') && in_array($statusDirect, ['Y', 'N'])) {
		if (updateSettings('download-direct-enabled', $statusDirect)) {
			$notif['update-status-direct-success'] = true;
		} else {
			$notif['update-status-direct-error'] = true;
		}
	}
	if ($statusMirror !== config('download-mirror-enabled') && in_array($statusDirect, ['Y', 'N'])) {
		if (updateSettings('download-mirror-enabled', $statusMirror)) {
			$notif['update-status-mirror-success'] = true;
		} else {
			$notif['update-status-mirror-error'] = true;
		}
	}
	if ($statusTorrent !== config('download-torrent-enabled') && in_array($statusDirect, ['Y', 'N'])) {
		if (updateSettings('download-torrent-enabled', $statusMirror)) {
			$notif['update-status-torrent-success'] = true;
		} else {
			$notif['update-status-torrent-error'] = true;
		}
	}
	if ($urlDirect !== config('download-direct')) {
		if (updateSettings('download-direct', $urlDirect)) {
			$notif['update-status-direct-success'] = true;
		} else {
			$notif['update-status-direct-error'] = true;
		}
	}
	if ($urlMirror !== config('download-mirror')) {
		if (updateSettings('download-mirror', $urlMirror)) {
			$notif['update-status-mirror-success'] = true;
		} else {
			$notif['update-status-mirror-error'] = true;
		}
	}
	if ($urlTorrent !== config('download-torrent')) {
		if (updateSettings('download-torrent', $urlTorrent)) {
			$notif['update-status-torrent-success'] = true;
		} else {
			$notif['update-status-torrent-error'] = true;
		}
	}
}
?>
<div class="well">
	<legend>Administrare pagina download <a style="float: right;" href="<?= BASE_URI ?>admin/"><i class="fa fa-arrow-left"></i> Inapoi</a></legend>
	<!-- Notifications -->
	<?php if ($notif['update-status-direct-error'] || $notif['update-status-torrent-error'] || $notif['update-status-mirror-error'] || $notif['update-url-direct-error'] || $notif['update-url-torrent-error'] || $notif['update-url-mirror-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Setarile nu au putut fi salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['update-status-direct-success'] || $notif['update-status-mirror-success'] || $notif['update-status-torrent-success'] || $notif['update-url-direct-success']  || $notif['update-url-torrent-success'] || $notif['update-url-mirror-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Starile au fost salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<!-- /Notifications -->
	<form method="post" class="form-horizontal">
		<legend style="margin-left: 10px;">Direct</legend>
		<div class="form-group">
			<label class="control-label col-sm-2" for="statusDirect">Status</label>
			<div class="col-sm-10">
				<select name="statusDirect" id="statusDirect" class="form-control">
					<option value="Y" <?= (config('download-direct-enabled') == 'Y') ? 'selected=""' : '' ?>>Activ</option>
					<option value="N" <?= (config('download-direct-enabled') == 'N') ? 'selected=""' : '' ?>>Inactiv</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="urlDirect">Url</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="urlDirect" id="urlDirect" value="<?= config('download-direct') ?>">
			</div>
		</div>
		<legend style="margin-left: 10px;">Torrent</legend>
		<div class="form-group">
			<label class="control-label col-sm-2" for="statusTorrent">Status</label>
			<div class="col-sm-10">
				<select name="statusTorrent" id="statusTorrent" class="form-control">
					<option value="Y" <?= (config('download-torrent-enabled') == 'Y') ? 'selected=""' : '' ?>>Activ</option>
					<option value="N" <?= (config('download-torrent-enabled') == 'N') ? 'selected=""' : '' ?>>Inactiv</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="urlTorrent">Url</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="urlTorrent" id="urlTorrent" value="<?= config('download-torrent') ?>">
			</div>
		</div>
		<legend style="margin-left: 10px;">Mirror</legend>
		<div class="form-group">
			<label class="control-label col-sm-2" for="statusDirect">Status</label>
			<div class="col-sm-10">
				<select name="statusMirror" id="statusMirror" class="form-control">
					<option value="Y" <?= (config('download-mirror-enabled') == 'Y') ? 'selected=""' : '' ?>>Activ</option>
					<option value="N" <?= (config('download-mirror-enabled') == 'N') ? 'selected=""' : '' ?>>Inactiv</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="urlMirror">Url</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="urlMirror" id="urlMirror" value="<?= config('download-mirror') ?>">
			</div>
		</div>
		<hr>
		<div class="form-group text-center">
			<button class="btn btn-primary" type="submit" name="save-settings-trigger"><i class="fa fa-save"></i> Save</button>
		</div>
	</form>
</div>