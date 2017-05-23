<?php

/**
*	This function loads automatically settings from database and config file
*/

function config($val)
{
	global $conn;

	$valuesDB = ['appname', 'motto', 'forum', 'download-torrent', 'download-torrent-enabled', 'download-direct', 'download-direct-enabled', 'download-mirror', 'download-mirror-enabled'];
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

	if ($res) {
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
		$available_params = ['username', 'email', 'avatar', 'nickname'];
		$params = [
			'username' => 'login',
			'email' => 'email',
			'nickname' => 'real_name',
		];
		$qry = $conn->prepare("SELECT `login`,`email`,`real_name` FROM `account`.`account` WHERE id = ?");
		$ret = $qry->execute([$user]);

		if (in_array($par, $available_params)) {
			return $qry->fetchObject()->$params[$par];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
*	This function returns informations about the server
*	
*/
function getServerStatus() {
	$ret = [];
	// Status server
		global $metin2_ports;
		global $conn;
		if (testPort(DBHOST, $metin2_ports['LOGIN']) == true) {
			$ret['status'] = true;
		} else {
			$ret['status'] = false;
		}

		$online_players = $conn->query("SELECT COUNT(*) AS players FROM player.player WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < last_play;")->fetchObject()->players;
		$ret['online_players'] =  $online_players;

		$created_accounts = $conn->query("SELECT COUNT(*) AS accounts FROM account.account WHERE status = 'OK'")->fetchObject()->accounts;
		$ret['accounts'] = $created_accounts;
	return $ret;
}

function getHighscore($start = 1, $stop = 10, $guilds = false)
	{
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
				$qryGetGuildMasterName = $onn->query("SELECT name FROM player.player WHERE id = {$g->master}")->fetchObject()->name;
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