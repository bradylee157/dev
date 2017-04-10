ALTER TABLE `#__hoduma_categories` ADD `published` tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE `#__hoduma_categories` ADD `checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `#__hoduma_categories` ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

ALTER TABLE `#__hoduma_departments` ADD `published` tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE `#__hoduma_departments` ADD `checked_out` INTEGER UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `#__hoduma_departments` ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';