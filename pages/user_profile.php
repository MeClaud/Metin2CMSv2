<?php 
if(!defined('RETRO_MODE')){exit();}
if(!logged_in()) {redirect(BASE_URI, 'php');}

$notif['debug-success'] = false;
$notif['debug-fail'] = false;

if (isset($_POST['debug-char'])) {
	$debugid = filter_var($_POST['debug-id'], FILTER_SANITIZE_STRING);
	$empire = filter_var($_POST['debug-empire'], FILTER_SANITIZE_STRING);
	if (!empty($_POST['debug-id']) && !empty($_POST['debug-empire'])) {
		if (debugChar($debugid, $empire)) {
			$notif['debug-success'] = true;
		} else {
			$notif['debug-fail'] = true;
		}
	}
}
?>

<?php if ($notif['debug-success']): ?>
	<div class="alert alert-success">
		<strong>Succes!</strong> Caracterul a fost resetat in map1.
	</div>
<?php endif ?>

<?php if ($notif['debug-fail']): ?>
	<div class="alert alert-danger">
		<strong>Eroare!</strong> Caracterul nu a putut fi resetat.
	</div>
<?php endif ?>

<div class="well">
	<legend>Panou utilizator</legend>
	<ul>
		<li>Nume de utilizator: <?= get_user_info($_SESSION['id'], 'username') ?></li>
		<li>Email: <?= get_user_info($_SESSION['id'], 'email') ?></li>
		<li>Monede: <?= get_user_info($_SESSION['id'], 'coins') ?> (<a href="<?= BASE_URI ?>premium/">Obtine</a>)</li>
	</ul>
	<legend>Lista caractere</legend>
	<div class="row">
		<?php 
			$pInfo = getCharsForAcc($_SESSION['id']);
			if (!is_null($pInfo)) {
			foreach ($pInfo as $k => $v) {
				$empireClass = [
					1 => 'primary',
					2 => 'danger',
					3 => 'info'
				];
		?>
		<div class="col-lg-6">
			<div class="panel panel-<?= $empireClass[$v['empire']] ?> table-center">
				<div class="panel-heading"><?= $v['name'] ?></div>
				<table class="table table-bordered table-responsive">
					<tr>
						<td colspan="2">
							<img src="<?= BASE_URI ?>img/classes/<?= $v['job'] ?>.png" alt="">
						</td>
					</tr>
					<tr>
						<td>Nivel</td>
						<td><?= $v['level'] ?></td>
					</tr>
					<tr>
						<td>Breasla</td>
						<td><?= $v['guild'] ?></td>
					</tr>
					<tr>
						<td>Minute jucate</td>
						<td><?= $v['playtime'] ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<form method="POST">
								<input type="hidden" name="debug-id" value="<?= $v['id'] ?>">
								<input type="hidden" name="debug-empire" value="<?= $v['empire'] ?>">
								<button class="btn btn-success" type="submit" name="debug-char">Debug</button>
							</form>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php } } else { ?>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> Nu exista caractere pe acest cont!</div>
		<?php } ?>
	</div>
	</div>