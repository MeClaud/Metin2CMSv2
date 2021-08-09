<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
?>
<div class="card p-4 text-light bg-dark">
	<legend>Panou administrare</legend>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-microchip fa-fw"></i> Core Settings</a>
		<a href="<?= BASE_URI ?>website-settings" class="list-group-item"><i class="fa fa-cogs fa-fw"></i> Website settings</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-file-o fa-fw"></i> Continut Pagini Speciale</a>
		<a href="<?= BASE_URI ?>download-settings" class="list-group-item"><i class="fa fa-download fa-fw"></i> Administrare pagina download</a>
		<a href="<?= BASE_URI ?>home-admin" class="list-group-item"><i class="fa fa-home fa-fw"></i> Pagina Home</a>
		<a href="<?= BASE_URI ?>premium-admin" class="list-group-item"><i class="fa fa-star-o fa-fw"></i> Pagina Premium</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-users fa-fw"></i> User controll Settings</a>
		<a href="<?= BASE_URI ?>user-search" class="list-group-item"><i class="fa fa-search fa-fw"></i> Search user</a>
		<a href="<?= BASE_URI ?>admin-blocked-users" class="list-group-item"><i class="fa fa-lock fa-fw"></i> Blocked users</a>
	</div>
	<div class="list-group">
		<a class="list-group-item active"><i class="fa fa-leaf fa-fw"></i> Another Settings</a>
		<a href="<?= BASE_URI ?>add-post" class="list-group-item"><i class="fa fa-pencil-square-o fa-fw"></i> Post something</a>
		<a href="<?= BASE_URI ?>admin-posts" class="list-group-item"><i class="fa fa-newspaper-o fa-fw"></i> Posts</a>
	</div>
</div>