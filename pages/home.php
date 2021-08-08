<?php 
if(!defined('RETRO_MODE')){exit();}
?>
<div class="well">
<?php if (logged_in()): ?>
	<p>
		<a href="<?= BASE_URI ?>premium/" type="button" class="btn btn-info btn-lg btn-block">Ai vazut avantajele premium?</a>
	</p>
<?php endif ?>
	<article>
		<?= getJsonPageContent('home') ?>
	</article>
</div>