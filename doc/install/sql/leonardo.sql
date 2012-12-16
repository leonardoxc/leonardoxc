
--
-- Table structure for table `leonardo_airspace`
--

DROP TABLE IF EXISTS `leonardo_airspace`;
CREATE TABLE `leonardo_airspace` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL default '',
  `serial` tinyint(4) NOT NULL default '0',
  `disabled` tinyint(4) NOT NULL default '0',
  `updated` tinyint(4) NOT NULL default '0',
  `Type` varchar(30) NOT NULL default '',
  `Shape` tinyint(3) unsigned NOT NULL default '0',
  `Comments` varchar(255) NOT NULL default '',
  `minx` float NOT NULL default '0',
  `miny` float NOT NULL default '0',
  `maxx` float NOT NULL default '0',
  `maxy` float NOT NULL default '0',
  `Base` blob NOT NULL,
  `Top` blob NOT NULL,
  `Points` mediumblob NOT NULL,
  `Radius` float NOT NULL default '0',
  `Latitude` float NOT NULL default '0',
  `Longitude` float NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`,`serial`),
  KEY `minx` (`minx`,`miny`,`maxx`,`maxy`),
  KEY `serial` (`serial`,`disabled`),
  KEY `serial_2` (`serial`,`disabled`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_areas`
--

DROP TABLE IF EXISTS `leonardo_areas`;
CREATE TABLE `leonardo_areas` (
  `ID` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  `descInt` varchar(255) NOT NULL default '',
  `areaType` smallint(5) unsigned NOT NULL default '0',
  `min_lat` float NOT NULL default '999',
  `max_lat` float NOT NULL default '-999',
  `min_lon` float NOT NULL default '999',
  `max_lon` float NOT NULL default '-999',
  `center_lat` float NOT NULL default '0',
  `center_lon` float NOT NULL default '0',
  `radius` float NOT NULL default '0',
  `polygon` text NOT NULL,
  `isInclusive` smallint(6) NOT NULL default '1',
  PRIMARY KEY  (`ID`),
  KEY `areaType` (`areaType`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_areas_takeoffs`
--

DROP TABLE IF EXISTS `leonardo_areas_takeoffs`;
CREATE TABLE `leonardo_areas_takeoffs` (
  `areaID` mediumint(8) unsigned NOT NULL default '0',
  `takeoffID` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs`
--

DROP TABLE IF EXISTS `leonardo_clubs`;
CREATE TABLE `leonardo_clubs` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set greek NOT NULL default '',
  `intName` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `intDescription` text NOT NULL,
  `cat` smallint(5) unsigned NOT NULL default '1',
  `location` varchar(60) NOT NULL default '',
  `intLocation` varchar(60) NOT NULL default '',
  `countryCode` varchar(30) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `club_admin` bigint(20) unsigned NOT NULL default '0',
  `contact_person` varchar(255) NOT NULL default '',
  `formula` smallint(6) NOT NULL default '0',
  `formula_parameters` text NOT NULL,
  `areaID` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs_flights`
--

DROP TABLE IF EXISTS `leonardo_clubs_flights`;
CREATE TABLE `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL default '0',
  `flightID` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs_pilots`
--

DROP TABLE IF EXISTS `leonardo_clubs_pilots`;
CREATE TABLE `leonardo_clubs_pilots` (
  `clubID` bigint(20) unsigned NOT NULL default '0',
  `pilotID` bigint(20) unsigned NOT NULL default '0',
  `pilotServerID` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clubID`,`pilotID`,`pilotServerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights`
--

DROP TABLE IF EXISTS `leonardo_flights`;
CREATE TABLE `leonardo_flights` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `originalURL` varchar(255) NOT NULL default '',
  `originalKML` varchar(255) NOT NULL,
  `original_ID` mediumint(8) unsigned NOT NULL default '0',
  `cat` smallint(5) unsigned NOT NULL default '1',
  `subcat` smallint(5) unsigned NOT NULL default '1',
  `category` smallint(5) unsigned NOT NULL default '2',
  `active` smallint(6) NOT NULL default '0',
  `excludeFrom` tinyint(3) unsigned NOT NULL default '0',
  `dateAdded` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateUpdated` datetime NOT NULL,
  `timesViewed` mediumint(9) NOT NULL default '0',
  `userID` mediumint(8) unsigned NOT NULL default '0',
  `originalUserID` varchar(30) NOT NULL,
  `userServerID` mediumint(8) unsigned NOT NULL default '0',
  `filename` varchar(200) NOT NULL default '',
  `place` varchar(100) NOT NULL default '',
  `glider` varchar(50) NOT NULL default '',
  `gliderBrandID` smallint(5) unsigned NOT NULL default '0',
  `comments` text NOT NULL,
  `linkURL` varchar(200) NOT NULL default '',
  `hasPhotos` tinyint(3) unsigned NOT NULL default '0',
  `takeoffID` mediumint(9) NOT NULL default '0',
  `takeoffVinicity` float NOT NULL default '0',
  `landingID` mediumint(9) NOT NULL default '0',
  `landingVinicity` float NOT NULL default '0',
  `DATE` date NOT NULL default '0000-00-00',
  `timezone` float NOT NULL default '0',
  `MAX_SPEED` float NOT NULL default '0',
  `MEAN_SPEED` float NOT NULL default '0',
  `MAX_ALT` int(11) NOT NULL default '0',
  `MIN_ALT` int(11) NOT NULL default '0',
  `TAKEOFF_ALT` int(11) NOT NULL default '0',
  `MAX_VARIO` float NOT NULL default '0',
  `MIN_VARIO` float NOT NULL default '0',
  `LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `MAX_LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `START_TIME` mediumint(9) NOT NULL default '0',
  `END_TIME` mediumint(9) NOT NULL default '0',
  `DURATION` mediumint(9) NOT NULL default '0',
  `BEST_FLIGHT_TYPE` varchar(30) NOT NULL default '',
  `FLIGHT_KM` float NOT NULL default '0',
  `FLIGHT_POINTS` float NOT NULL default '0',
  `autoScore` float NOT NULL default '0',
  `isLive` tinyint(3) unsigned NOT NULL default '0',
  `externalFlightType` tinyint(3) unsigned NOT NULL default '0',
  `forceBounds` tinyint(3) unsigned NOT NULL default '0',
  `firstPointTM` int(10) unsigned NOT NULL default '0',
  `firstLat` float NOT NULL,
  `firstLon` float NOT NULL,
  `lastPointTM` int(10) unsigned NOT NULL default '0',
  `lastLat` float NOT NULL,
  `lastLon` float NOT NULL,
  `private` tinyint(3) unsigned NOT NULL default '0',
  `gpsTrack` tinyint(3) unsigned NOT NULL default '1',
  `grecord` smallint(6) NOT NULL default '0',
  `validated` smallint(6) NOT NULL default '0',
  `validationMessage` text NOT NULL,
  `airspaceCheck` tinyint(4) NOT NULL default '0',
  `airspaceCheckFinal` tinyint(4) NOT NULL default '0',
  `airspaceCheckMsg` text NOT NULL,
  `checkedBy` varchar(100) NOT NULL default '',
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACclubID` bigint(20) NOT NULL default '0',
  `hash` varchar(100) NOT NULL default '',
  `batchOpProcessed` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `takeoffID` (`takeoffID`),
  KEY `NACClubIndex` (`NACclubID`,`NACid`),
  KEY `userID` (`userID`,`userServerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights_deleted`
--

DROP TABLE IF EXISTS `leonardo_flights_deleted`;
CREATE TABLE `leonardo_flights_deleted` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `originalURL` varchar(255) NOT NULL default '',
  `originalKML` varchar(255) NOT NULL,
  `original_ID` mediumint(8) unsigned NOT NULL default '0',
  `cat` smallint(5) unsigned NOT NULL default '1',
  `subcat` smallint(5) unsigned NOT NULL default '1',
  `category` smallint(5) unsigned NOT NULL default '2',
  `active` smallint(6) NOT NULL default '0',
  `excludeFrom` tinyint(3) unsigned NOT NULL default '0',
  `dateAdded` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateUpdated` datetime NOT NULL,
  `timesViewed` mediumint(9) NOT NULL default '0',
  `userID` mediumint(8) unsigned NOT NULL default '0',
  `originalUserID` varchar(30) NOT NULL,
  `userServerID` mediumint(8) unsigned NOT NULL default '0',
  `filename` varchar(200) NOT NULL default '',
  `place` varchar(100) NOT NULL default '',
  `glider` varchar(50) NOT NULL default '',
  `gliderBrandID` smallint(5) unsigned NOT NULL default '0',
  `comments` text NOT NULL,
  `linkURL` varchar(200) NOT NULL default '',
  `hasPhotos` tinyint(3) unsigned NOT NULL default '0',
  `takeoffID` mediumint(9) NOT NULL default '0',
  `takeoffVinicity` float NOT NULL default '0',
  `landingID` mediumint(9) NOT NULL default '0',
  `landingVinicity` float NOT NULL default '0',
  `DATE` date NOT NULL default '0000-00-00',
  `timezone` float NOT NULL default '0',
  `MAX_SPEED` float NOT NULL default '0',
  `MEAN_SPEED` float NOT NULL default '0',
  `MAX_ALT` int(11) NOT NULL default '0',
  `MIN_ALT` int(11) NOT NULL default '0',
  `TAKEOFF_ALT` int(11) NOT NULL default '0',
  `MAX_VARIO` float NOT NULL default '0',
  `MIN_VARIO` float NOT NULL default '0',
  `LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `MAX_LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `START_TIME` mediumint(9) NOT NULL default '0',
  `END_TIME` mediumint(9) NOT NULL default '0',
  `DURATION` mediumint(9) NOT NULL default '0',
  `BEST_FLIGHT_TYPE` varchar(30) NOT NULL default '',
  `FLIGHT_KM` float NOT NULL default '0',
  `FLIGHT_POINTS` float NOT NULL default '0',
  `autoScore` float NOT NULL default '0',
  `isLive` tinyint(3) unsigned NOT NULL default '0',
  `externalFlightType` tinyint(3) unsigned NOT NULL default '0',
  `forceBounds` tinyint(3) unsigned NOT NULL default '0',
  `firstPointTM` int(10) unsigned NOT NULL default '0',
  `firstLat` float NOT NULL,
  `firstLon` float NOT NULL,
  `lastPointTM` int(10) unsigned NOT NULL default '0',
  `lastLat` float NOT NULL,
  `lastLon` float NOT NULL,
  `private` tinyint(3) unsigned NOT NULL default '0',
  `gpsTrack` tinyint(3) unsigned NOT NULL default '1',
  `grecord` smallint(6) NOT NULL default '0',
  `validated` smallint(6) NOT NULL default '0',
  `validationMessage` text NOT NULL,
  `airspaceCheck` tinyint(4) NOT NULL default '0',
  `airspaceCheckFinal` tinyint(4) NOT NULL default '0',
  `airspaceCheckMsg` text NOT NULL,
  `checkedBy` varchar(100) NOT NULL default '',
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACclubID` bigint(20) NOT NULL default '0',
  `hash` varchar(100) NOT NULL default '',
  `batchOpProcessed` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `takeoffID` (`takeoffID`),
  KEY `NACClubIndex` (`NACclubID`,`NACid`),
  KEY `userID` (`userID`,`userServerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights_score`
--

DROP TABLE IF EXISTS `leonardo_flights_score`;
CREATE TABLE `leonardo_flights_score` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `flightID` bigint(20) unsigned NOT NULL,
  `method` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `isBest` tinyint(1) NOT NULL,
  `distance` float NOT NULL,
  `score` float NOT NULL,
  `turnpoint1` varchar(50) NOT NULL,
  `turnpoint2` varchar(50) NOT NULL,
  `turnpoint3` varchar(50) NOT NULL,
  `turnpoint4` varchar(50) NOT NULL,
  `turnpoint5` varchar(50) NOT NULL,
  `turnpoint6` varchar(50) NOT NULL,
  `turnpoint7` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `flightID` (`flightID`,`method`,`type`,`isBest`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_log`
--

DROP TABLE IF EXISTS `leonardo_log`;
CREATE TABLE `leonardo_log` (
  `transactionID` bigint(20) unsigned NOT NULL auto_increment,
  `actionTime` bigint(20) unsigned NOT NULL default '0',
  `userID` mediumint(8) unsigned NOT NULL default '0',
  `effectiveUserID` mediumint(8) unsigned NOT NULL default '0',
  `ItemType` mediumint(8) unsigned NOT NULL default '0',
  `ItemID` mediumint(8) unsigned NOT NULL default '0',
  `ServerItemID` mediumint(8) unsigned NOT NULL default '0',
  `ActionID` mediumint(8) unsigned NOT NULL default '0',
  `ActionXML` text NOT NULL,
  `Modifier` mediumint(8) unsigned NOT NULL default '0',
  `ModifierID` mediumint(8) unsigned NOT NULL default '0',
  `ServerModifierID` mediumint(8) unsigned NOT NULL default '0',
  `Result` mediumint(8) unsigned NOT NULL default '0',
  `ResultDescription` text NOT NULL,
  PRIMARY KEY  (`transactionID`),
  KEY `ItemType` (`ItemType`,`ServerItemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_maps`
--

DROP TABLE IF EXISTS `leonardo_maps`;
CREATE TABLE `leonardo_maps` (
  `ID` bigint(20) NOT NULL auto_increment,
  `filename` varchar(200) NOT NULL default '',
  `leftX` double(10,2) NOT NULL default '0.00',
  `topY` double(10,2) NOT NULL default '0.00',
  `rightX` double(10,2) NOT NULL default '0.00',
  `bottomY` double(10,2) NOT NULL default '0.00',
  `UTMzone` smallint(6) NOT NULL default '0',
  `pixelWidth` mediumint(9) NOT NULL default '0',
  `pixelHeight` mediumint(9) NOT NULL default '0',
  `metersPerPixel` float NOT NULL default '0',
  PRIMARY KEY  (`ID`,`filename`),
  UNIQUE KEY `filename` (`filename`),
  KEY `UTMzone` (`UTMzone`),
  KEY `metersPerPixel` (`metersPerPixel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_nac_clubs`
--

DROP TABLE IF EXISTS `leonardo_nac_clubs`;
CREATE TABLE `leonardo_nac_clubs` (
  `NAC_ID` mediumint(9) NOT NULL default '0',
  `clubID` bigint(20) NOT NULL default '0',
  `clubName` varchar(255) NOT NULL,
  PRIMARY KEY  (`NAC_ID`,`clubID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_photos`
--

DROP TABLE IF EXISTS `leonardo_photos`;
CREATE TABLE `leonardo_photos` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `flightID` mediumint(8) unsigned NOT NULL default '0',
  `path` varchar(255)  NOT NULL default '',
  `name` varchar(255)  NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `flightID` (`flightID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_pilots`
--

DROP TABLE IF EXISTS `leonardo_pilots`;
CREATE TABLE `leonardo_pilots` (
  `pilotID` bigint(20) NOT NULL default '0',
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `countryCode` char(2) NOT NULL default '',
  `CIVL_ID` mediumint(8) unsigned NOT NULL default '0',
  `CIVL_NAME` varchar(80) NOT NULL,
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACmemberID` bigint(20) unsigned NOT NULL default '0',
  `NACclubID` bigint(20) NOT NULL default '0',
  `olcBirthDate` varchar(8) NOT NULL default '',
  `olcFirstName` varchar(100) NOT NULL default '',
  `olcLastName` varchar(100) NOT NULL default '',
  `olcCallSign` varchar(50) NOT NULL default '',
  `olcFilenameSuffix` varchar(4) NOT NULL default '',
  `olcAutoSubmit` tinyint(4) NOT NULL default '0',
  `FirstName` varchar(40) NOT NULL default '',
  `LastName` varchar(50) NOT NULL default '',
  `NickName` varchar(25) NOT NULL,
  `clubID` mediumint(8) unsigned NOT NULL default '0',
  `sponsor` varchar(255) default NULL,
  `Sex` varchar(6) NOT NULL default '',
  `Birthdate` varchar(15) NOT NULL default '',
  `BirthdateHideMask` varchar(10) NOT NULL default 'xx.xx.xxxx',
  `Occupation` varchar(100) NOT NULL default '',
  `MartialStatus` varchar(20) NOT NULL default '',
  `OtherInterests` longtext NOT NULL,
  `PersonalWebPage` varchar(150) NOT NULL default '',
  `PilotLicence` varchar(100) NOT NULL default '',
  `BestMemory` longtext NOT NULL,
  `WorstMemory` longtext NOT NULL,
  `Training` varchar(200) NOT NULL default '',
  `personalDistance` varchar(150) NOT NULL default '',
  `personalHeight` varchar(150) NOT NULL default '',
  `glider` varchar(200) NOT NULL default '',
  `FlyingSince` varchar(100) NOT NULL default '',
  `HoursFlown` varchar(50) NOT NULL default '',
  `HoursPerYear` varchar(50) NOT NULL default '',
  `FavoriteLocation` varchar(250) NOT NULL default '',
  `UsualLocation` varchar(150) NOT NULL default '',
  `FavoriteBooks` varchar(150) NOT NULL default '',
  `FavoriteActors` varchar(150) NOT NULL default '',
  `FavoriteSingers` varchar(150) NOT NULL default '',
  `FavoriteMovies` varchar(150) NOT NULL default '',
  `FavoriteSite` varchar(150) NOT NULL default '',
  `Sign` varchar(40) NOT NULL default '',
  `Spiral` varchar(60) NOT NULL default '',
  `Bline` varchar(100) NOT NULL default '',
  `FullStall` varchar(100) NOT NULL default '',
  `Sat` varchar(100) NOT NULL default '',
  `AsymmetricSpiral` varchar(100) NOT NULL default '',
  `Spin` varchar(100) NOT NULL default '',
  `OtherAcro` varchar(150) NOT NULL default '',
  `camera` varchar(150) NOT NULL default '',
  `camcorder` varchar(150) NOT NULL default '',
  `Vario` varchar(60) NOT NULL default '',
  `GPS` varchar(60) NOT NULL default '',
  `Harness` varchar(60) NOT NULL default '',
  `Reserve` varchar(60) NOT NULL default '',
  `Helmet` varchar(60) NOT NULL default '',
  `PilotPhoto` varchar(30) NOT NULL default '',
  `FirstOlcYear` int(10) NOT NULL default '0',
  `FirstNameEn` int(40) NOT NULL default '',
  `LastNameEn` int(50) NOT NULL default '',
  PRIMARY KEY  (`pilotID`,`serverID`),
  KEY `FirstName` (`FirstName`),
  KEY `LastName` (`LastName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_remote_pilots`
--

DROP TABLE IF EXISTS `leonardo_remote_pilots`;
CREATE TABLE `leonardo_remote_pilots` (
  `remoteServerID` smallint(5) unsigned NOT NULL default '0',
  `remoteUserID` bigint(20) unsigned NOT NULL default '0',
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `userID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`remoteServerID`,`remoteUserID`,`serverID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_servers`
--

DROP TABLE IF EXISTS `leonardo_servers`;
CREATE TABLE `leonardo_servers` (
  `ID` mediumint(8) unsigned NOT NULL auto_increment,
  `lastPullUpdateID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_stats`
--

DROP TABLE IF EXISTS `leonardo_stats`;
CREATE TABLE `leonardo_stats` (
  `tm` bigint(20) unsigned NOT NULL default '0',
  `year` smallint(5) unsigned NOT NULL default '0',
  `month` tinyint(3) unsigned NOT NULL default '0',
  `day` tinyint(3) unsigned NOT NULL default '0',
  `userID` bigint(20) unsigned NOT NULL default '0',
  `sessionID` bigint(20) unsigned NOT NULL default '0',
  `visitorID` bigint(20) unsigned NOT NULL default '0',
  `op` char(25) NOT NULL default '',
  `flightID` bigint(20) unsigned NOT NULL default '0',
  `executionTime` float unsigned NOT NULL default '0',
  `os` char(20) NOT NULL default '',
  `browser` char(15) NOT NULL default '',
  `browser_version` char(10) NOT NULL default '',
  KEY `tm` (`tm`,`year`,`month`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_thermals`
--

DROP TABLE IF EXISTS `leonardo_thermals`;
CREATE TABLE `leonardo_thermals` (
  `id` bigint(20) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `name` char(6) NOT NULL,
  `climbrate` smallint(6) NOT NULL,
  `climbseconds` smallint(6) NOT NULL,
  `climbmeters` smallint(6) NOT NULL,
  `windsourcedeg` smallint(6) NOT NULL,
  `windspeed` tinyint(4) NOT NULL,
  `class` char(1) NOT NULL,
  `icon` tinyint(4) NOT NULL,
  `createddatetime` datetime NOT NULL,
  `altitude` smallint(6) NOT NULL,
  `notes` text NOT NULL,
  KEY `class` (`class`),
  KEY `latitude` (`latitude`,`longitude`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_waypoints`
--

DROP TABLE IF EXISTS `leonardo_waypoints`;
CREATE TABLE `leonardo_waypoints` (
  `ID` mediumint(9) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `intName` varchar(100) NOT NULL default '',
  `lat` float NOT NULL default '0',
  `lon` float NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `countryCode` varchar(10) NOT NULL default 'GR',
  `location` varchar(100) NOT NULL default '',
  `intLocation` varchar(100) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `modifyDate` date NOT NULL default '2005-09-01',
  PRIMARY KEY  (`ID`),
  KEY `lat` (`lat`,`lon`),
  KEY `countryCode` (`countryCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

