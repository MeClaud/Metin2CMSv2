<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in() || !is_admin($_SESSION['id'])) { redirect(BASE_URI, 'php'); }
?>
<div class="well">
	<legend>Panou administrare</legend>
	@todo
</div>