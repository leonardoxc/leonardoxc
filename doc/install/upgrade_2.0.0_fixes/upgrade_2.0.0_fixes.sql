
ALTER TABLE `leonardo_flights` ADD INDEX ( `takeoffID` ) ;


ALTER TABLE `leonardo_flights` ADD `grecord` SMALLINT NOT NULL , ADD `validated` SMALLINT NOT NULL ;

ALTER TABLE `leonardo_flights` CHANGE `grecord` `grecord` SMALLINT( 6 ) NOT NULL DEFAULT '0';

ALTER TABLE `leonardo_flights` CHANGE `validated` `validated` SMALLINT( 6 ) NOT NULL DEFAULT '0';