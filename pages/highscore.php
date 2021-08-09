<?php
if(!defined('RETRO_MODE')){exit();}

global $url;
$section = (isset($url[1]) && !empty($url[1])) ? $url[1] : 'players';
$page = (isset($url[2]) && !empty($url[2])) ? $url[2] : 1;
$per_page = 10;
$start = ($page-1)*$per_page;

if ($section == 'guilds') {
?>
<div class="card p-4 text-light bg-dark">
	<legend><i class="fa fa-tower"></i> Clasament bresle</legend>
	<div class="p-2 text-center">
		<a class="btn btn-dark border-secondary" href="<?= BASE_URI ?>highscore/players">Jucatori</a>
	</div>
	<?php 
		$qryNumGuilds = $conn->query("SELECT COUNT(*) AS count FROM `player`.`guild`");
		$maxPages = ceil($qryNumGuilds->fetchObject()->count / $per_page);
	?>
	<table class="table table-bordered text-center text-light">
		<thead>
			<th>Rang</th>
			<th>Breasla</th>
			<th>Lider breasla</th>
			<th>Regat</th>
			<th>Nivel</th>
			<th>Puncte</th>
		</thead>
		<tbody>
			<?php
				$guildsHighscore = getHighscore($start, $per_page, true);
				$i = $start;
				foreach ($guildsHighscore as $id => $g) {
					$i++;
					if ($i == 1) {
						$a = '<i class="fa fa-trophy" style="color:gold; text-shadow: 0 0 1px black;"></i>';
					} elseif ($i == 2) {
						$a = '<i class="fa fa-trophy" style="color:silver; text-shadow: 0 0 1px black;"></i>';
					} elseif ($i == 3) {
						$a = '<i class="fa fa-trophy" style="color:orange; text-shadow: 0 0 1px black;"></i>';
					} else {
						$a = $i;
					}
			?>		
				<tr>
					<td><?= $a ?></td>
					<td><?= $g['name'] ?></td>
					<td><?= $g['master'] ?></td>
					<td><img src="<?= BASE_URI ?>/img/empires/<?=$g['empire']?>.jpg"?></td>
					<td><?= $g['level'] ?></td>
					<td><?= $g['points'] ?></td>
				</tr>
			<?php } ?>	
		</tbody>
	</table>
	
</div>
<?php } else { 
	$qryNumPlayers = $conn->prepare("SELECT `id` FROM `player`.`player`");
	$qryNumPlayers->execute([]);
	$maxPages = ceil($qryNumPlayers->rowCount() / $per_page);
?>
<div class="card p-4 text-light bg-dark">
	<legend><i class="fa fa-tower"></i> Clasament jucatori</legend>
	<div class="p-2 text-center">
			<a class="btn btn-dark border-secondary" href="<?= BASE_URI ?>highscore/guilds">Bresle</a></li>
	</div>
	<table class="table table-bordered text-center text-light">
		<thead>
			<th>Rang</th>
			<th>Numele Caracterului</th>
			<th>Regat</th>
			<th>Nivel</th>
			<th>EXP</th>
		</thead>
		<tbody>
			<?php 
				$playersHighscore = getHighscore($start, $per_page, false);
				$i = $start;
				foreach($playersHighscore AS $id => $p){
					$i++;
					if ($i == 1) {
						$a = '<i class="fa fa-trophy" style="color:gold; text-shadow: 0 0 1px black;"></i>';
					} elseif ($i == 2) {
						$a = '<i class="fa fa-trophy" style="color:silver; text-shadow: 0 0 1px black;"></i>';
					} elseif ($i == 3) {
						$a = '<i class="fa fa-trophy" style="color:orange; text-shadow: 0 0 1px black;"></i>';
					} else {
						$a = $i;
					}
			?>
			<tr>
				<td><?= $a ?></td>
				<td><?= $p['name'] ?></td>
				<td><img src="<?= BASE_URI ?>img/empires/<?=$p['empire']?>.jpg"?></td>
				<td><?= $p['level'] ?></td>
				<td><?= $p['exp'] ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php } ?>

<!-- PAGINATION -->
<?php if ($maxPages >> 1): ?>
<div class="p-3 text-center">
	<div class="btn-group" aria-label="Pagination">
		<a class="btn btn-dark <?= $page >> 1 ?: ' disabled' ?>" href="<?= BASE_URI ?>highscore/<?= $section ?>/<?= $page-1 ?>"><i class="fa fa-step-backward fa-fw"></i></a>
		<a class="btn btn-dark" href=""><?= $page ?></a>
		<a class="btn btn-dark <?= $page <= $maxPages-1 ?: ' disabled' ?>" href="<?= BASE_URI ?>highscore/<?= $section ?>/<?= $page+1 ?>"><i class="fa fa-step-forward fa-fw"></i></a>
	</div>
</div>
<?php endif ?>
