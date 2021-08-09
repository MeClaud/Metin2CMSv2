<?php 
if(!defined('RETRO_MODE')){exit();}
?>
<div class="card p-4 text-light bg-dark">
	<?php if (!logged_in()): ?>
	<div class="d-grid mb-3">
		<a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#registerForm"><i class="fa fa-play fa-fw"></i> Incepe aventura!</a>
	</div>
	<?php endif; ?>
	<?php if (logged_in()): ?>
		<div class="d-grid mb-3">
			<a href="<?= BASE_URI ?>premium/" class="btn btn-dark text-warning border-warning"><i class="fa fa-star fa-fw"></i> Ai vazut avantajele premium?</a>
		</div>
	<?php endif ?>
	<article>
		<?= getJsonPageContent('home') ?>
	</article>
</div>