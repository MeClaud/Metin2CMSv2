<?php

// Database connection
try {
	$conn = @new PDO('mysql:host='.DBHOST.';dbname='.DB, DBUSER, DBPASS);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

/**
*	Register
*/
$notif['user-exists'] = false;
$notif['register-passwords-confirmation-failed'] = false;
$notif['register-username-invalid'] = false;
$notif['register-email-invalid'] = false;
$notif['register-success'] = false;
$notif['register-failed'] = false;

if (isset($_POST['register-trigger'])) {
	$reg_username = filter_var($_POST['register-username'], FILTER_SANITIZE_STRING);	
	$reg_nickname = filter_var($_POST['register-nickname'], FILTER_SANITIZE_STRING);
	$reg_email = filter_var($_POST['register-email'], FILTER_SANITIZE_STRING);
	$reg_pass = filter_var($_POST['register-password'], FILTER_SANITIZE_STRING);
	$reg_pass_conf = filter_var($_POST['register-password-confirmation'], FILTER_SANITIZE_STRING);
	$reg_sid = filter_var($_POST['register-security-core'], FILTER_SANITIZE_STRING);
	$reg_question1 = '-';
	$reg_answer1 = '-';

	$errors = 0;
	if (user_exists($reg_username)) {
		$notif['user-exists'] = true;
		$errors++;
	}
	if ($reg_pass != $reg_pass_conf) {
		$notif['register-passwords-confirmation-failed'] = true;
		$errors++;
	}
	if (strlen($reg_username) <= 6 || strlen($reg_username) >= 16 || !preg_match('/^[a-zA-Z0-9_\-\.]+$/', $reg_username)) {
		$notif['register-username-invalid'] = true;
		$errors++;
	}
	/*if (filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
		$notif['register-email-invalid'] = true;
		$errors++;
	}*/

	if ($errors == 0) {
		if (register($reg_username, $reg_pass, $reg_nickname, $reg_sid, $reg_email, $reg_question1, $reg_answer1)) {
			$notif['register-success'] = true;
		} else {
			$notif['register-failed'] = true;
		}
	}
}


/**
*	Login part of the website
*/
$notif['login-success'] = false;
$notif['login-failed'] = false;
$notif['user-is-banned'] = false;
$notif['user-invalid'] = false;

if (isset($_POST['login-trigger'])) {
	$login_user = filter_var($_POST['login-username'], FILTER_SANITIZE_STRING);
	$login_pass = filter_var($_POST['login-password'], FILTER_SANITIZE_STRING);

	if(!user_exists($login_user)){
		$notif['user-invalid'] = true;
	} elseif (is_banned(get_user_id($login_user))){
		$notif['user-is-banned'] = true;
	} elseif (login($login_user, $login_pass)) {
		$notif['login-success'] = true;
		redirect(BASE_URI, 'html', 2);
	} else {
		$notif['login-failed'] = true;
	}
}

/**
*	Logout script
*/
if (isset($_GET['logout'])) {
	session_destroy();
	redirect(BASE_URI, 'php');
}
