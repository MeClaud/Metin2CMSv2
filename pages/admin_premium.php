<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }

$notif['premium-page-update-success'] = false;
$notif['premium-page-update-error'] = false;

if (isset($_POST['save-settings-trigger'])) {
	$pageContent = $_POST['pageContent'];
	
	if ($pageContent !== getPremiumPageData()) {
		if (editPageContent('premium', $pageContent)) {
			$notif['premium-page-update-success'] = true;
		} else {
			$notif['premium-page-update-error'] = true;
		}
	}
}
?>
<div class="well">
	<legend>Premium page content <a style="float: right;" href="<?= BASE_URI ?>admin/"><i class="fa fa-arrow-left"></i> Inapoi</a></legend>
	<!-- Notifications -->
	<?php if ($notif['premium-page-update-error']): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Setarile nu au putut fi salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($notif['premium-page-update-success']): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Setarile au fost salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<!-- /Notifications -->
	<form method="POST">
		<div class="form-group">
			<textarea name="pageContent" id="" cols="30" rows="10"><?= getPremiumPageData() ?></textarea>
		</div>
		<div class="form-group text-center">
			<button name="save-settings-trigger" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		</div>
	</form>
</div>