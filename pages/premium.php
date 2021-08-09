<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in()) {redirect(BASE_URI, 'php');}
?>
<div class="card p-4 text-light bg-dark">
	<legend>Premium</legend>
	<?= getJsonPageContent('premium') ?>
</div>