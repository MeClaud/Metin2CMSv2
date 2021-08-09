<?php
defined('RETRO_MODE') or exit('Access denied!'); // @ignore
?>
<div class="card p-4 text-light bg-dark">
	<legend>Descarcare</legend>
	<center>
		<h4>Descarca clientul <?= config("appname") ?> gratuit</h4>
		<?php if (config('download-torrent-enabled') == 'Y'): ?>
			<a href="<?= config('download-torrent') ?>" class="btn btn-success">DOWNLOAD<br><small>(Torrent)</small></a>
		<?php endif ?>
		<?php if (config('download-direct-enabled') == 'Y'): ?>
			<a href="<?= config('download-direct') ?>" class="btn btn-info">DOWNLOAD<br><small>(Direct)</small></a>
		<?php endif ?>
		<?php if (config('download-mirror-enabled') == 'Y'): ?>
			<a href="<?= config('download-mirror') ?>" class="btn btn-primary">DOWNLOAD<br><small>(Mirror)</small></a>
		<?php endif ?>
	</center>
	<hr>
	<p>Memoria insuficienta a placii grafice de memorie poate duce la pierderea FPS. Configureaza-ti setarile jocului pentru a evita aceasta problema. In cazul in care descarcarea are loc de catre mai multi useri in acelasi timp, aceasta poate fi mai scazuta, de aceea te rugam sa ai rabdare.</p>
	<legend>Cerinte sistem</legend>
	<table class="table table-bordered text-light">
			<thead>
				<th></th>
				<th>Minim</th>
				<th>Recomandat</th>
			</thead>
			<tr>
				<td>CPU</td>
				<td>Cartof / Pentium3 1GHz</td>
				<td>Pentium4 1.8GHz</td>
			</tr>
			<tr>
				<td>GPU</td>
				<td>32MB</td>
				<td>64MB</td>
			</tr>
			<tr>
				<td>HDD</td>
				<td>1.5GB</td>
				<td>2GB</td>
			</tr>
			<tr>
				<td>RAM</td>
				<td>256MB</td>
				<td>1GB</td>
			</tr>
			<tr>
				<td>OS</td>
				<td colspan="2"><i class="ti ti-microsoft-alt"></i> XP, Vista, 7, 8, 8.1, 10</td>
			</tr>
			<tr>
				<td>Periferice</td>
				<td colspan="2"><i class="fa fa-mouse-pointer"></i> Maus, <i class="fa fa-keyboard-o"></i> Tastatura</td>
			</tr>
			<tr>
				<td>Sunet</td>
				<td colspan="2">rlly m8?</td>
			</tr>

		</table>
</div>