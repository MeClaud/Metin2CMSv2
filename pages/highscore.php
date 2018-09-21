<?php
if(!defined('RETRO_MODE')){exit();}

global $url;
$section = (isset($url[1]) && !empty($url[1])) ? $url[1] : 'players';
$page = (isset($url[2]) && !empty($url[2])) ? $url[2] : 1;
$per_page = 10;
$start = ($page-1)*$per_page;

if ($section == 'guilds') {
?>
<div class="well">
	<legend><i class="fa fa-tower"></i> Clasament bresle</legend>
	<div class="row">
		<ul class="nav nav-tabs" style="width: 90%; margin: auto;">
			<li><a href="<?= BASE_URI ?>highscore/players">Jucatori</a></li>
			<li class="active"><a href="<?= BASE_URI ?>highscore/guilds">Bresle</a></li>
		</ul>
	</div>
	<?php 
		$qryNumGuilds = $conn->query("SELECT COUNT(*) AS count FROM `player`.`guild`");
		$maxPages = ceil($qryNumGuilds->fetchObject()->count / $per_page);
	?>
	<table class="table table-bordered table-striped table-center">
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
	$qryNumPlayers = $conn->query("SELECT COUNT(*) AS count FROM `player`.`player`");
	$maxPages = ceil($qryNumPlayers->fetchObject()->count / $per_page);
?>
<div class="well">
	<legend><i class="fa fa-tower"></i> Clasament jucatori</legend>
	<div class="row">
		<ul class="nav nav-tabs" style="width: 90%; margin: auto;">
			<li class="active"><a href="<?= BASE_URI ?>highscore/players">Jucatori</a></li>
			<li><a href="<?= BASE_URI ?>highscore/guilds">Bresle</a></li>
		</ul>
	</div>
	<table class="table table-bordered table-striped table-center">
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
	<center>
		<ul class="pagination">
			<li<?= ($page == 1)? ' class="disabled"' : '' ?>>
				<a href="<?= BASE_URI ?>highscore/<?= $section ?>/<?= $page-1 ?>" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<li class="active">
				<a href="<?= BASE_URI ?>highscore/<?= $section ?>/<?= $page ?>"><?=$page?></a>
			</li>
			<li<?=($page == $maxPages)? ' class="disabled"' : ''?>>
				<a href="<?= BASE_URI ?>highscore/<?= $section ?>/<?= $page+1 ?>" aria-label="Previous">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</center>
<?php endif ?>
