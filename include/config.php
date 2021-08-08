<?php

/* Connection to database */
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DB', 'mcms2');

/* Base path of the website */
define('BASE_URI', 'http://localhost/Metin2CMSv2/'); 
define('BASE_PATH', '/Metin2CMSv2/');


/* Default ports for metin2 server */
$serverSettings = [
	'SERVER_CLOSED' => true,
	'LOGIN' => 11000,
	'CH1' => 13001,
	'CH2' => 13002
];

$resetPos[1]['map_index']=1; // Shinsoo
$resetPos[1]['x']=468779;
$resetPos[1]['y']=962107;
$resetPos[2]['map_index']=21; // Chunjo
$resetPos[2]['x']=55700;
$resetPos[2]['y']=157900;
$resetPos[3]['map_index']=41; // Jinno
$resetPos[3]['x']=969066;
$resetPos[3]['y']=278290;
