<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
?>
<div class="card p-4 text-light bg-dark">
	<legend>Utilizatori blocati <a style="float: right;" href="<?= BASE_URI ?>admin/"><i class="fa fa-arrow-left"></i> Inapoi</a></legend>
	<p>@todo</p>
</div>