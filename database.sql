-- --------------------------------------------------------
-- Server:                       127.0.0.1
-- Versiune server:              5.7.14 - MySQL Community Server (GPL)
-- SO server:                    Win64
-- HeidiSQL Versiune:            9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Descarcă structura pentru tabelă mcms2.cms_pages
CREATE TABLE IF NOT EXISTS `cms_pages` (
  `key` varchar(255) NOT NULL,
  `value` longtext,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Descarcă datele pentru tabela mcms2.cms_pages: 1 rows
/*!40000 ALTER TABLE `cms_pages` DISABLE KEYS */;
INSERT INTO `cms_pages` (`key`, `value`) VALUES
	('premium', '<h3 style="text-align: center;">Descopera avantajele Premium</h3>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Sed tincidunt sem at turpis ornare, condimentum malesuada massa ultrices.</li>\r\n<li>Fusce sollicitudin magna a ex ultricies fringilla.</li>\r\n<li>Pellentesque et nibh at turpis ultrices fringilla sit amet ut lorem.</li>\r\n<li>Pellentesque auctor nisi eu quam sagittis pellentesque.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Praesent varius libero nec ornare rhoncus.</li>\r\n<li>In id leo condimentum, malesuada mauris ac, lobortis purus.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Quisque at diam et dui tempus vestibulum.</li>\r\n<li>Etiam nec augue feugiat, viverra diam non, feugiat libero.</li>\r\n<li>Integer ultrices ligula quis ligula eleifend, et maximus justo vehicula.</li>\r\n<li>Ut vestibulum massa a est varius consectetur.</li>\r\n<li>Praesent placerat augue et diam mollis iaculis.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Cras eget leo quis ante cursus ullamcorper et vitae urna.</li>\r\n<li>Nunc nec lectus ut justo elementum mollis scelerisque sit amet neque.</li>\r\n<li>Curabitur quis libero ac quam bibendum porta.</li>\r\n<li>Etiam a ex blandit elit facilisis dignissim.</li>\r\n<li>Donec sodales arcu nec urna consectetur, ut tempor libero volutpat.</li>\r\n<li>Proin porta eros vitae elit tincidunt imperdiet.</li>\r\n</ul>\r\n<h3 style="text-align: center;">Preturi</h3>\r\n<table style="width: 100%; margin-left: auto; margin-right: auto;" border="2px" cellpadding="4em">\r\n<tbody>\r\n<tr>\r\n<td style="text-align: center;">Pachet VIP 1</td>\r\n<td style="text-align: center;">20&euro;</td>\r\n</tr>\r\n<tr>\r\n<td style="text-align: center;">Pachet VIP 2</td>\r\n<td style="text-align: center;">30&euro;</td>\r\n</tr>\r\n<tr>\r\n<td style="text-align: center;">Pachet VIP 3</td>\r\n<td style="text-align: center;">50&euro;</td>\r\n</tr>\r\n</tbody>\r\n</table>');
/*!40000 ALTER TABLE `cms_pages` ENABLE KEYS */;

-- Descarcă structura pentru tabelă mcms2.cms_settings
CREATE TABLE IF NOT EXISTS `cms_settings` (
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Descarcă datele pentru tabela mcms2.cms_settings: 9 rows
/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` (`name`, `value`) VALUES
	('appname', 'Aries2'),
	('motto', 'Little things make the difference'),
	('forum', '#forum'),
	('download-direct', '#DIRECT'),
	('download-torrent', '#TORRENT'),
	('download-mirror', '#MIRROR'),
	('download-direct-enabled', 'Y'),
	('download-torrent-enabled', 'Y'),
	('download-mirror-enabled', 'Y');
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;

ALTER TABLE `account` ADD COLUMN `coins` int(11) NOT NULL DEFAULT '0',
ALTER TABLE `account` ADD COLUMN `web_admin` int(1) NOT NULL DEFAULT '0',
ALTER TABLE `account` ADD COLUMN `web_ip` varchar(15) DEFAULT NULL,

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
