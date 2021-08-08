<?php

/**
*	This function loads automatically settings from database and config file
*/
$valuesDB = ['appname', 'motto', 'forum', 'download-torrent', 'download-torrent-enabled', 'download-direct', 'download-direct-enabled', 'download-mirror', 'download-mirror-enabled'];

function config($val)
{
	global $conn;
	global $valuesDB;

	$valuesCF = [];
	
	if (in_array($val, $valuesDB)) {
		$qry = $conn->prepare("SELECT `value` FROM `cms_settings` WHERE name = ?");
		$value = $qry->execute([$val]);

		return $qry->fetchObject()->value;
	} elseif (in_array($val, $valuesCF)) {
		global $val;

		return $val;
	} else {
		return false;
	}
}

function redirect($url, $method = 'php', $time = 3){
	if ($method == 'php') {
		header('Location: '.$url);
	} elseif ($method == 'html') {
		echo "<meta http-equiv=\"refresh\" content=\"".$time."; URL=".$url."\">";
	}
}

function testPort($ip, $port)
{
	if (@fsockopen($ip, $port, $errno, $errstr, 10)) {
		return true;
	} else {
		return false;
	}
}

function register($username, $password, $nickname, $sid, $email, $question1, $answer1){
	global $conn;

	if (!user_exists($username)) {
		$qry = $conn->prepare("INSERT INTO `account`.`account` (`login`, `password`, `real_name`, `social_id`, `email`, `create_time`, `question1`, `answer1`) VALUES (:login, PASSWORD(:password), :real_name, :social_id, :email, NOW(), NULL, NULL)");
		$ret = $qry->execute([
				'login' => $username,
				'password' => $password,
				'email' => $email,
				'real_name' => $nickname,
				'social_id' => $sid,
				'email' => $email,
				// 'question1' => $question1,
				// 'answer1' => $answer1
			]);

		return $ret;
	}
}

/**
*	Login function
*	@todo log every login [time, ip]
*/
function login($user, $password){
	global $conn;

	$qry = $conn->prepare("SELECT `id` FROM `account`.`account` WHERE login = :user AND password = PASSWORD(:pass)");
	$res = $qry->execute(['user' => $user, 'pass' => $password]);

	if ($qry->rowCount() >= 1) {
		$_SESSION['id'] = $qry->fetchObject()->id;
		return true;
	} else {
		return false;
	}
}

/**
*	This function will check if user with username <$user> exists
*/
function user_exists($user)
{
	global $conn;
	if ((int)$user){
		$qry = $conn->prepare("SELECT COUNT(*) AS entries FROM `account`.`account` WHERE id = ?");
		$ret = $qry->execute([$user]);

		if ($qry->fetchObject()->entries >= 1) {
			return true;
		}
	} else {
		$qry = $conn->prepare("SELECT COUNT(*) AS entries FROM `account`.`account` WHERE login = ?");
		$ret = $qry->execute([$user]);

		if ($qry->fetchObject()->entries >= 1) {
			return true;
		}
	}
}

/**
*	This function will check if user is connected and will return a boolean value
*/
function logged_in()
{
	if (isset($_SESSION['id'])) {
		return true;
	} else {
		return false;
	}
}

/**
*	This function will check if user $id is banned and will return a boolean value
*/
function is_banned($id)
{
	global $conn;

	$qry = $conn->prepare("SELECT `status` FROM `account`.`account` WHERE id = ?");
	$ret = $qry->execute([$id]);

	if ($qry->fetchObject()->status !== 'OK') {
		return true;
	} else {
		return false;
	}
}

/**
*	This function will check if user $id is admin and will return a boolean value
*/
function is_admin($id)
{
	global $conn;

	$qry = $conn->prepare("SELECT `web_admin` FROM `account`.`account` WHERE id = ?");
	$ret = $qry->execute([$id]);

	if ($qry->fetchObject()->web_admin >= 1) {
		return true;
	} else {
		return false;
	}
}

/**
*	This function will return the id of the account with username <$user>
*/
function get_user_id($user)
{
	global $conn;

	$qry = $conn->prepare("SELECT `id` FROM `account`.`account` WHERE login = ?");
	$ret = $qry->execute([$user]);

	if (user_exists($user)) {
		return $qry->fetchObject()->id;
	} else {
		return false;
	}
}

/**
*	This function returns informations about <$user>
*/
function get_user_info($user, $par){
	global $conn;
	if (user_exists($user)) {
		$user = !(int)$user ? get_user_id($user) : $user;
		$available_params = ['username', 'email', 'nickname', 'coins'];
		$params = [
			'username' => 'login',
			'email' => 'email',
			'nickname' => 'real_name',
			'coins' => 'coins',
		];
		$stmt = $conn->prepare("SELECT `login`,`email`,`real_name`,`coins` FROM `account`.`account` WHERE id = ?");
		$stmt->execute([$user]);

		if (in_array($par, $available_params)) {
			$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
			
			/** 
			 * Issue #3
			 * shows the username as nickname when the field "real_name" is empty
			*/
			$params['nickname'] = !empty($fetch['real_name']) ? 'real_name' : 'login';

			return $fetch[$params[$par]];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function getServerStatus() {
	$ret = [];

	global $serverSettings;
	global $conn;
	if ($serverSettings['SERVER_CLOSED']) {
		$ret['status'] = 'closed';
	} else {
		if (testPort(DBHOST, $metin2_ports['LOGIN']) == true) {
			$ret['status'] = 'online';
		} else {
			$ret['status'] = 'offline';
		}
	}
	
	$online_players = $conn->query("SELECT COUNT(*) AS players FROM player.player WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < last_play;")->fetchObject()->players;
	$ret['online_players'] =  $online_players;

	$created_accounts = $conn->query("SELECT COUNT(*) AS accounts FROM account.account WHERE status = 'OK'")->fetchObject()->accounts;
	$ret['accounts'] = $created_accounts;

	return $ret;
}

function getHighscore($start = 1, $stop = 10, $guilds = false) {
	global $conn;

	if ($guilds == false) {
		$return = array();

		$qryGetPlayers = $conn->query("SELECT player.id,player.name,player.level,player.exp,player_index.empire,guild.name AS guild_name
									  FROM player.player
									  LEFT JOIN player.player_index
									  ON player_index.id=player.account_id
									  LEFT JOIN player.guild_member
									  ON guild_member.pid=player.id
									  LEFT JOIN player.guild
									  ON guild.id=guild_member.guild_id
									  INNER JOIN account.account
									  ON account.id=player.account_id
									  WHERE player.name NOT LIKE '[%]%' AND player.name NOT LIKE '%[%]'  AND player.name NOT LIKE '[%]' AND account.status!='BLOCK'
									  ORDER BY player.level DESC, player.exp DESC
									  LIMIT {$start},{$stop}");
		   $order = 0;
		while ($p = $qryGetPlayers->fetchObject()) {
			$order++;
			$return[$p->id]['order'] = $order;
			$return[$p->id]['name'] = $p->name;
			$return[$p->id]['exp'] = $p->exp;
			$return[$p->id]['empire'] = $p->empire;
			$return[$p->id]['level'] = $p->level;
		}
		return $return;
	} elseif($guilds == true) {
		$return = array();

		$qryGetGuilds = $conn->query("SELECT * FROM player.guild ORDER BY ladder_point DESC, level DESC LIMIT {$start},{$stop}");
			$order = 0;
		while ($g = $qryGetGuilds->fetchObject()) {
			$order++;
			
			$qryGetGuildEmpire = $conn->query("SELECT empire FROM player.player_index WHERE pid1 = {$g->master} OR pid2 = {$g->master} OR pid3 = {$g->master} OR pid4 = {$g->master}")->fetchObject()->empire;
			$qryGetGuildMasterName = $conn->query("SELECT name FROM player.player WHERE id = {$g->master}")->fetchObject()->name;
			$return[$g->id]['order'] = $order;
			$return[$g->id]['name'] = $g->name;
			$return[$g->id]['level'] = $g->level;
			$return[$g->id]['empire'] = $qryGetGuildEmpire;
			$return[$g->id]['master'] = $qryGetGuildMasterName;
			$return[$g->id]['points'] = $g->ladder_point;
		}
		return $return;	
	}
}

function getCharsForAcc($id)
{
	global $conn;

	$qry = $conn->prepare("SELECT player.id, player.name, player.job, player.level, player.playtime, player_index.empire, guild.name AS guild_name FROM `player`.`player` LEFT JOIN player.guild_member ON guild_member.pid=player.id LEFT JOIN player.guild ON guild.id=guild_member.guild_id LEFT JOIN player.player_index ON player_index.id = player.account_id WHERE account_id = ?");
	$res = $qry->execute([$id]);
	if ($qry->rowCount() >= 1) {
		while ($r = $qry->fetchObject()) {
			$ret[$r->id]['id'] = $r->id;
			$ret[$r->id]['name'] = $r->name;
			$ret[$r->id]['job'] = $r->job;
			$ret[$r->id]['level'] = $r->level;
			$ret[$r->id]['guild'] = $r->guild_name;
			$ret[$r->id]['playtime'] = $r->playtime;
			$ret[$r->id]['empire'] = $r->empire;
		}

		return $ret;
	} 
}

function debugChar($id, $empire)
{
	global $conn;
	global $resetPos;

	$qry = $conn->query("UPDATE player.player SET map_index='".$resetPos[$empire]['map_index']."', x='".$resetPos[$empire]['x']."', y='".$resetPos[$empire]['y']."',     exit_x='".$resetPos[$empire]['x']."', exit_y='".$resetPos[$empire]['y']."', exit_map_index='".$resetPos[$empire]['map_index']."', horse_riding='0' WHERE id={$id} LIMIT 1");

	return $qry;
}

function editAccount($userid, $indexVal, $value)
{
	global $conn;

	$iList = ['password', 'real_name', 'email'];
	$encS = ($indexVal == 'password') ? "PASSWORD(" : "";
	$encs = ($indexVal == 'password') ? ")" : "";

	if (in_array($indexVal, $iList)) {
		$qry = $conn->prepare("UPDATE `account`.`account` SET `".$indexVal."` = ".$encS.":val".$encs." WHERE  `id`= :id");
		$res = $qry->execute(['val' => $value, 'id' => $userid]);

		return $res;
	} else {
		return false;
	}
}

function checkPassword($userid, $password){
	global $conn;

	$qry = $conn->prepare("SELECT id FROM `account`.`account` WHERE id = ? AND password=PASSWORD(?)");
	$res = $qry->execute([$userid, $password]);
	return ($qry->rowCount() >= 1) ? true : false;
}

function updateSettings($key, $value)
{
	global $conn;
	global $valuesDB;

	if (in_array($key, $valuesDB)) {
		$qry = $conn->prepare("UPDATE `cms_settings` SET `value` = :val WHERE `name` = :key");
		$res = $qry->execute(['key' => $key, 'val' => $value]);

		return $res;
	} else {
		return false;
	}
}

function getJsonPageContent($page)
{
	$json_file = file_get_contents("include/sections/".$page.".json");
	$json_data = json_decode($json_file, true);

	return base64_decode($json_data['content']);
}

function updateJsonPageContent($page, $html_content)
{
	$json_data = ['content' => base64_encode($html_content)];
	$json_data = json_encode($json_data);
	
	return file_put_contents('include/sections/'.$page.'.json', $json_data);
}

function getPremiumPageData()
{
	global $conn;
	$qry = $conn->prepare("SELECT `key`, `value` FROM `mcms2`.`cms_pages` WHERE  `key`=:key;");
	$res = $qry->execute(['key' => 'premium']);
	$res = $qry->fetchObject();

	return $res->value;
}

function editPageContent($key, $value)
{
	global $conn;

	$qry = $conn->prepare("UPDATE `cms_pages` SET `value` = :val WHERE `key` = :key");
	$res = $qry->execute(['val' => $value, 'key' => $key]);

	return $res;
}