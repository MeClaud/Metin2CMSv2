<?php
// Page access restrictions
if (!defined('RETRO_MODE')) { exit('Access denied!'); }

$url = isset($_GET['url']) ? $_GET['url'] : 'index';
$url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
$url = explode('/', $url);


switch ($url[0]) {
	case 'index':
		$page_name = 'Prima pagina';
		$page_file = 'pages/home.php';
		break;
	case 'tos':
		$page_name = 'Terms of Service';
		$page_file = 'pages/tos.php';
		break;
	case 'download':
		$page_name = 'Descarcare';
		$page_file = 'pages/download.php';
		break;
	case 'highscore':
		$page_name = 'Clasament';
		$page_file = 'pages/highscore.php';
		break;
	case 'pwreset':
		$page_name = 'Resetare parola';
		$page_file = 'pages/pwreset.php';
		break;
	case 'premium':
		$page_name = 'Treceti la premium';
		$page_file = 'pages/premium.php';
		break;	
	case 'profile':
		$page_name = 'User profile';
		$page_file = 'pages/user_profile.php';
		break;
	case 'settings':
		$page_name = 'User settings';
		$page_file = 'pages/user_settings.php';
		break;
	case 'admin':
		$page_name = 'Contact';
		$page_file = 'pages/admin_dashboard.php';
		break;
	default:
		$page_name = 'Prima pagina';
		$page_file = 'pages/home.php';
		break;
}

$page_title = $page_name.' - '.config('appname');