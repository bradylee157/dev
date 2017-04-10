CREATE TABLE IF NOT EXISTS `#__hoduma` (
	`id` int(11) UNSIGNED NOT NULL auto_increment,
	`version` varchar(32) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__hoduma` (`version`) VALUES ('1.0.12');

CREATE TABLE IF NOT EXISTS `#__hoduma_categories` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`asset_id` INTEGER UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`cname` text NOT NULL,
	`rep_id` bigint(20) NOT NULL,
	`ordering` int(11) NOT NULL DEFAULT 0,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_config` (
  `id` int(11) NOT NULL,
  `hdreply` text NOT NULL,
  `hdurl` text NOT NULL,
  `notifyuser` int(11) NOT NULL,
  `enablekb` int(11) NOT NULL,
  `defaultpriority` bigint(20) NOT NULL,
  `defaultstatus` bigint(20) NOT NULL,
  `closestatus` bigint(20) NOT NULL,
  `allowanonymous` int(11) NOT NULL,
  `defaultlang` int(11) NOT NULL,
  `pagerpriority` int(11) NOT NULL,
  `userselect` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hoduma_departments` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`asset_id` INTEGER UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`dname` text NOT NULL,
	`ordering` int(11) NOT NULL DEFAULT 0,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_emailmsg` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`type` text NOT NULL,
	`subject` text NOT NULL,
	`body` longtext NOT NULL,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_notes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `problem_id` bigint(20) NOT NULL,
  `eventcode` int(11) NOT NULL DEFAULT 0,
  `note` longtext NOT NULL,
  `adddate` datetime NOT NULL,
  `uid` text NOT NULL,
  `priv` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `note` (`note`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `size` int(11) NOT NULL,
  `content` MEDIUMBLOB NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_priorities` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`pname` text NOT NULL,
	`fontcolor` varchar(16) NOT NULL DEFAULT '#000000',
	`ordering` int(11) NOT NULL DEFAULT 0,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_problems` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` text NOT NULL,
  `uemail` text NOT NULL,
  `ulocation` text NOT NULL,
  `uphone` text NOT NULL,
  `rep` bigint(20) NOT NULL,
  `status` bigint(20) NOT NULL,
  `time_spent` bigint(20) NOT NULL,
  `category` bigint(20) NOT NULL,
  `close_date` datetime NOT NULL,
  `department` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `solution` text NOT NULL,
  `start_date` datetime NOT NULL,
  `priority` bigint(20) NOT NULL,
  `entered_by` bigint(20) NOT NULL,
  `kb` bigint(20) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `rep` (`rep`,`status`,`category`,`department`,`priority`),
  FULLTEXT KEY `solution` (`solution`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_statuses` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`status_id` bigint(20) NOT NULL,
	`sname` text NOT NULL,
	`fontcolor` varchar(16) NOT NULL DEFAULT '#000000',
	`ordering` int(11) NOT NULL DEFAULT 0,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

CREATE TABLE IF NOT EXISTS `#__hoduma_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`joomla_id` int(11) NOT NULL,
	`isuser` int(1) NOT NULL,
	`isrep` int(1) NOT NULL,
	`isadmin` int(1) NOT NULL,
	`phone` text NOT NULL,
	`pageraddress` text NOT NULL,
	`phonemobile` text NOT NULL,
	`phonehome` text NOT NULL,
	`location1` text NOT NULL,
	`location2` text NOT NULL,
	`department` bigint(20) NOT NULL,
	`language` bigint(20) NOT NULL,
	`viewreports` int(11) NOT NULL,
	`published` tinyint(1) NOT NULL DEFAULT 0,
	`checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `#__hoduma_config` (`id`, `hdreply`, `hdurl`, `notifyuser`, `enablekb`, `defaultpriority`, `defaultstatus`, `closestatus`, `allowanonymous`, `defaultlang`, `pagerpriority`, `userselect`) VALUES
(1, 'helpdesk@yourdomain.com', 'http://www.yourdomain.com/', 1, 1, 3, 15, 24, 1, 1, 10, 1);

INSERT IGNORE INTO `#__hoduma_emailmsg` (`id`, `type`, `subject`, `body`) VALUES
(1, 'repclose', 'HELPDESK: Problem [problemid] Closed', 'The following problem has been closed.  You can view the problem at [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nUser: [uid]\r\nDate: [startdate]\r\nTitle: [title]\r\nPriority: [priority]\r\nCategory: [category]\r\n\r\nSOLUTION\r\n--------\r\n[solution]'),
(2, 'repnew', 'HELPDESK: Problem [problemid] Assigned', 'The following problem has been assigned to you.  You can update the problem at [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nDate: [startdate]\r\nTitle: [title]\r\nPriority: [priority]\r\nCategory: [category]\r\n\r\nUSER INFORMATION\r\n----------------\r\nUsername: [uid]\r\nEmail: [uemail]\r\nPhone: [phone]\r\nLocation: [location]\r\nDepartment: [department]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]'),
(3, 'reppager', 'HELPDESK: Problem [problemid] Assigned/Updated', 'Title:[title]\r\nUser:[uid]\r\nPriority:[priority]'),
(4, 'repupdate', 'HELPDESK: Problem [problemid] Updated', 'The following problem has been updated.  You can view the problem at [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nUser: [uid]\r\nDate: [startdate]\r\nTitle: [title]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]\r\n\r\nNOTES\r\n-----------\r\n[notes]'),
(5, 'userclose', 'HELPDESK: Problem [problemid] Closed', 'Your help desk problem has been closed.  You can view the solution below or at: [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nUser: [uid]\r\nDate: [startdate]\r\nTitle: [title]\r\n\r\nSOLUTION\r\n--------\r\n[solution]'),
(6, 'usernew', 'HELPDESK: Problem [problemid] Created', 'Thank you for submitting your problem to the help desk.  You can view or update the problem at: [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nUser: [uid]\r\nDate: [startdate]\r\nTitle: [title]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]'),
(7, 'userupdate', 'HELPDESK: Problem [problemid] Updated', 'Your help desk problem has been updated.  You can view the problem at: [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nUser: [uid]\r\nDate: [startdate]\r\nTitle: [title]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]\r\n\r\nNOTES\r\n-----------\r\n[notes]'),
(8, 'adminnew', 'HELPDESK: Problem [problemid] Created', 'The following problem has been created.  You can update the problem at [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nDate: [startdate]\r\nTitle: [title]\r\nPriority: [priority]\r\nCategory: [category]\r\n\r\nUSER INFORMATION\r\n----------------\r\nFullname: [fullname]\r\nUsername: [uid]\r\nEmail: [uemail]\r\nPhone: [phone]\r\nLocation: [location]\r\nDepartment: [department]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]'),
(9, 'adminupdate', 'HELPDESK: Problem [problemid] Updated', 'The following problem has been updated.  You can view the problem at [url]\r\n\r\nPROBLEM DETAILS\r\n---------------\r\nID: [problemid]\r\nDate: [startdate]\r\nTitle: [title]\r\nPriority: [priority]\r\nCategory: [category]\r\n\r\nUSER INFORMATION\r\n----------------\r\nFullname: [fullname]\r\nUsername: [uid]\r\nEmail: [uemail]\r\nPhone: [phone]\r\nLocation: [location]\r\nDepartment: [department]\r\n\r\nDESCRIPTION\r\n-----------\r\n[description]');

INSERT IGNORE INTO `#__hoduma_departments` (`id`, `dname`, `published`) VALUES
(1,'Support',1);

INSERT IGNORE INTO `#__hoduma_categories` (`id`, `cname`, `published`) VALUES
(1,'General',1);

INSERT IGNORE INTO `#__hoduma_priorities` (`id`, `pname`, `published`) VALUES
(6, '6 - VERY HIGH',1),
(5, '5 - HIGH',1),
(4, '4 - ELEVATED',1),
(3, '3 - NORMAL',1),
(2, '2 - LOW',1),
(1, '1 - VERY LOW',1),
(10, '10 - EMERGENCY - PAGE',1),
(9, '9 - EMERGENCY - NO PAGE',1);

INSERT IGNORE INTO `#__hoduma_statuses` (`id`, `status_id`, `sname`, `published`) VALUES
(22, 65, 'TESTING',1),
(21, 63, 'WAITING',1),
(20, 60, 'HOLD',1),
(19, 55, 'ESCALATED',1),
(18, 50, 'IN PROGRESS',1),
(17, 20, 'OPEN',1),
(16, 10, 'RECEIVED',1),
(15, 1, 'NEW',1),
(24, 100, 'CLOSED',1);