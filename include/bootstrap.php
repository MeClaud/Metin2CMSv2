<?php
// Page access restrictions
if (!defined('RETRO_MODE')) { exit('Access denied!'); }

$url = isset($_GET['url']) ? $_GET['url'] : 'index';
$url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
$url = explode('/', $url);

if (!isset($_GET['url'])) {
  header("Location:" . BASE_URI . "home");
}
else {
  switch ($url[0]) {
    case 'index':
      $page_name = 'Prima pagina';
      $page_file = 'pages/home.php';
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
      $page_name = 'Panou administrare';
      $page_file = 'pages/admin_dashboard.php';
      break;
    case 'premium-admin':
      $page_name = 'Premium page content';
      $page_file = 'pages/admin_premium.php';
      break;
    case 'website-settings':
      $page_name = 'Setari Website';
      $page_file = 'pages/admin_settings.php';
      break;
    case 'admin-posts':
      $page_name = 'administrare Postari';
      $page_file = 'pages/admin_posts.php';
      break;
    case 'add-post':
      $page_name = 'Postare noua';
      $page_file = 'pages/admin_add_post.php';
      break;
    case 'user-search':
      $page_name = 'Cautare utilizator';
      $page_file = 'pages/admin_user_search.php';
      break;
    case 'admin-blocked-users':
      $page_name = 'Postare noua';
      $page_file = 'pages/admin_user_blocked.php';
      break;
    case 'download-settings':
      $page_name = 'Administrare pagina download';
      $page_file = 'pages/admin_download.php';
      break;
    default:
      $page_name = 'Prima pagina';
      $page_file = 'pages/home.php';
      break;
  }

  $page_file = str_replace(["/"], DIRECTORY_SEPARATOR, $page_file);

  $page_title = $page_name.' - '.config('appname');
}
