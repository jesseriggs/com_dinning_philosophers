DROP TABLE IF EXISTS `#__dinning_philosophers`;

CREATE TABLE `#__dinning_philosophers` (
	`id`		INT(11)			NOT NULL AUTO_INCREMENT,
	`asset_id`	INT(10)			NOT NULL DEFAULT '0',
	`created`	DATETIME		NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by`	INT(10)		UNSIGNED NOT NULL DEFAULT '0',
	`alias`		VARCHAR(40)		NOT NULL DEFAULT '',
	`published`	TINYINT(4)		NOT NULL DEFAULT '1',
	`catid`		INT(11)			NOT NULL DEFAULT '0',
	`params`	VARCHAR(1024)	NOT NULL DEFAULT '',
	`image`		VARCHAR(1024)	NOT NULL DEFAULT '',
	`title`		VARCHAR(255)	NOT NULL DEFAULT '',
	`metadesc`	VARCHAR(255)	NOT NULL DEFAULT 'Dinning_philosophers Description',
	`created_by_alias` VARCHAR(255)	NOT NULL DEFAULT '',
	`language`	char(7)			NOT NULL DEFAULT 'en_us',
	PRIMARY KEY	(`id`)
)
	ENGINE		=MyISAM
	AUTO_INCREMENT	=0
	DEFAULT CHARSET	=utf8;

CREATE UNIQUE INDEX `aliasindex` ON `#__dinning_philosophers` (`alias`);
