CREATE TABLE IF NOT EXISTS `#__pricelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `val` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `#__pricelist` ADD UNIQUE KEY `ordering` (`catid`, `ordering`);


CREATE TABLE IF NOT EXISTS `#__pricelist_points` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
