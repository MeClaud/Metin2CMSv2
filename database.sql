CREATE TABLE IF NOT EXISTS `cms_settings` (
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

ALTER TABLE `account` ADD COLUMN `coins` int(11) NOT NULL DEFAULT '0',
ALTER TABLE `account` ADD COLUMN `web_admin` int(1) NOT NULL DEFAULT '0',
ALTER TABLE `account` ADD COLUMN `web_ip` varchar(15) DEFAULT NULL,
