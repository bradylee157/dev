ALTER TABLE `#__hoduma_statuses` ADD `fontcolor` varchar(16) NOT NULL DEFAULT '#000000';
ALTER TABLE `#__hoduma_priorities` ADD `fontcolor` varchar(16) NOT NULL DEFAULT '#000000';
UPDATE `#__hoduma_statuses` SET `fontcolor` = '#000000';
UPDATE `#__hoduma_priorities` SET `fontcolor` = '#000000';