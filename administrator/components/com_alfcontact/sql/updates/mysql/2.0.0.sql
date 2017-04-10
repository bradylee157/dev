CREATE TABLE IF NOT EXISTS `#__alfcontact` (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL,
		`email` varchar(255) NOT NULL,
		`prefix` varchar(255) NOT NULL,
		`extra` varchar(255) NOT NULL,
		`extra2` varchar(255) NOT NULL,
		`defsubject` varchar(255) NOT NULL,
		`ordering` INT(11) NOT NULL,
		`access` TINYINT(3) UNSIGNED NOT NULL, 
		`published` TINYINT(1) NOT NULL default '1',
		PRIMARY KEY (`id`)
		)ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__alfcontact` VALUES (1, 'Sales', 'sales@mysite.com', '[Sales]', 'Client No:', 'Order No:', 'Order inquiry', 1, 0, 1);
INSERT INTO `#__alfcontact` VALUES (2, 'Webmaster', 'webmaster@mysite.com\nadmin@mysite.com', '[Webmaster]', '', '', '', 2, 0, 1);
INSERT INTO `#__alfcontact` VALUES (3, 'Support', 'support1@mysite.com\nsupport2@mysite.com\nsupport3@mysite.com', '[Support]', '', '', 'Question', 3, 2, 0);