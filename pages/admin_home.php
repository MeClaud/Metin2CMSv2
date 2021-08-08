<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }

if (isset($_POST['save-settings-trigger'])) {
	$pageContent = $_POST['pageContent'];
	
	if ($pageContent !== getJsonPageContent('home')) {
		if (updateJsonPageContent('home', $pageContent) >> 0) {
			$state = "update-success";
		} else {
			$state = "update-error";
		}
	}
}
?>
<div class="well">
	<legend>Premium page content <a style="float: right;" href="<?= BASE_URI ?>admin/"><i class="fa fa-arrow-left"></i> Inapoi</a></legend>
	<?php if ($state == "update-error"): ?>
		<div class="alert alert-danger alert-dismissable">
			<strong><i class="fa fa-exclamation-triangle"></i> Eroare:</strong> Setarile nu au putut fi salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if ($state == "update-success"): ?>
		<div class="alert alert-success alert-dismissable">
			<strong><i class="fa fa-check"></i> Succes!</strong> Setarile au fost salvate!
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	<?php endif ?>
	<form method="POST">
		<div class="form-group">
			<textarea name="pageContent" id="" cols="30" rows="20"><?= getJsonPageContent('home') ?></textarea>
		</div>
		<div class="form-group text-center">
			<button name="save-settings-trigger" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		</div>
	</form>
</div>