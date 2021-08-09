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

<div class="card p-4 text-light bg-dark">
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
		<div class="col-sm-3">
			<div class="card bg-dark border-light">
				<img src="<?= BASE_URI ?>img/classes/<?= $v['job'] ?>.png" class="card-img-top p-5" alt="...">
				<div class="card-body">
					<h5 class="card-title"><?= $v['name'] ?></h5>
					<p class="card-text">
						<span class="badge bg-primary">Nivel <?= $v['level'] ?></span>
						<span class="badge bg-danger"><?= $v['guild'] == '' ? 'Fara Breasla' : 'Breasla '.$v['guild'] ?></span>
						<span class="badge bg-secondary"><?= $v['playtime'] ?> Minute petrecute in joc</span>
					</p>
					<form method="POST" class="text-center">
						<input type="hidden" name="debug-id" value="<?= $v['id'] ?>">
						<input type="hidden" name="debug-empire" value="<?= $v['empire'] ?>">
						<button class="btn btn-success btn-sm mt-3" type="submit" name="debug-char">DEBUG</button>
					</form>
				</div>
			</div>
		</div>
		<?php } } else { ?>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> Nu exista caractere pe acest cont!</div>
		<?php } ?>
	</div>
	</div>