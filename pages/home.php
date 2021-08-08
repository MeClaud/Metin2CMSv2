<?php 
if(!defined('RETRO_MODE')){exit();}
?>
<div class="card p-4 text-light bg-dark">
	<?php if (!logged_in()): ?>
	<div class="d-grid mb-3">
		<a class="btn btn-success" href="#"><i class="fa fa-play fa-fw"></i> Incepe aventura!</a>
	</div>
	<?php endif; ?>
	<?php if (logged_in()): ?>
	<p>
		<a href="<?= BASE_URI ?>premium/" type="button" class="btn btn-info btn-lg btn-block">Ai vazut avantajele premium?</a>
	</p>
	<?php endif ?>
	<article>
		<?= getJsonPageContent('home') ?>
	</article>
</div>