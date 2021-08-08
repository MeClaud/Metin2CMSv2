<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in()) {redirect(BASE_URI, 'php');}
?>
<div class="well">
	<legend>Premium</legend>
	<?= getJsonPageContent('premium') ?>
</div>