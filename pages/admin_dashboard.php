<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
?>
<div class="well">
	<legend>Panou administrare</legend>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-microchip"></i> Core Settings</a>
		<a href="<?= BASE_URI ?>website-settings" class="list-group-item"><i class="fa fa-cogs"></i> Website settings</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-file-o"></i> Custom pages Settings</a>
		<a href="<?= BASE_URI ?>download-settings" class="list-group-item"><i class="fa fa-download"></i> Administrare pagina download</a>
		<a href="<?= BASE_URI ?>premium-admin" class="list-group-item"><i class="fa fa-star-o"></i> Premium page content</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-users"></i> User controll Settings</a>
		<a href="<?= BASE_URI ?>user-search" class="list-group-item"><i class="fa fa-search"></i> Search user</a>
		<a href="<?= BASE_URI ?>admin-blocked-users" class="list-group-item"><i class="fa fa-lock"></i> Blocked users</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-leaf"></i> Another Settings</a>
		<a href="<?= BASE_URI ?>add-post" class="list-group-item"><i class="fa fa-pencil-square-o"></i> Post something</a>
		<a href="<?= BASE_URI ?>admin-posts" class="list-group-item"><i class="fa fa-newspaper-o"></i> Posts</a>
	</div>
</div>