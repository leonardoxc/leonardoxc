CREATE TABLE `leonardo_waypoints_new` (
`ID` mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
`name` varchar( 100 ) NOT NULL default '',
`intName` varchar( 100 ) NOT NULL default '',
`lat` float NOT NULL default '0',
`lon` float NOT NULL default '0',
`type` int( 11 ) NOT NULL default '0',
`countryCode` varchar( 10 ) NOT NULL default 'GR',
`location` varchar( 100 ) NOT NULL default '',
`intLocation` varchar( 100 ) NOT NULL default '',
`link` varchar( 255 ) NOT NULL default '',
`description` text NOT NULL ,
`modifyDate` date NOT NULL default '2005-09-01',
PRIMARY KEY ( `ID` ) ,
KEY `lat` ( `lat` , `lon` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 ;

INSERT INTO `leonardo_waypoints_new` SELECT * FROM `leonardo_waypoints` ;

ALTER TABLE `leonardo_waypoints` RENAME `leonardo_waypoints_iso` ;

ALTER TABLE `leonardo_waypoints_new` RENAME `leonardo_waypoints` ;
