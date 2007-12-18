<?


$ranksList=array(

1=>array('id'=>1,
		 'type'=>'national',
		 'entity'=>'pilot',
		 'name'=>'German National Ranking',
		 'localName'=>'Deutsche Gleitschirm Wertung',
		 'localLanguage'=>'german',
		 'dontShowCatSelection'=>1, // no glider type selection menu on top
 		 'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>0, // NAC club selection menu on top
		'forceNacId'=>1, // the only NAC ID to be used

		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		 'subranks'=>array(
			1=>array('id'=>1,
				'name'=>'PG Sport',
				'localName'=>'PG Sport',
			),
			2=>array('id'=>2,
				'name'=>'PG Open',
				'localName'=>'PG Open',
			),
			3=>array('id'=>3,
				'name'=>'PG Tandem',
				'localName'=>'PG Tandem',
			),
			/*4=>array('id'=>4,
				'name'=>'Hangglider',
				'localName'=>'Drachenflieger',
			),
			5=>array('id'=>5,
				'name'=>'Rigid Wing',
				'localName'=>'Starrflügel',
			),*/
			6=>array('id'=>6,
				'name'=>'Junior PG',
				'localName'=>'Junior PG',
			),
			/*7=>array('id'=>7,
				'name'=>'Junior HG',
				'localName'=>'Junior HG',
			),*/
			8=>array('id'=>8,
				'name'=>'Womens PG',
				'localName'=>'Damen PG',
			),
			/*9=>array('id'=>9,
				'name'=>'Womens HG',
				'localName'=>'Damen HG',
			),*/
			10=>array('id'=>10,
				'name'=>'Newcomer PG',
				'localName'=>'Newcomer PG',
			),
			/*11=>array('id'=>11,
				'name'=>'Newcomer HG',
				'localName'=>'Newcomer HG',
			),*/
			12=>array('id'=>12,
				'name'=>'FAI3',
				'localName'=>'FAI3',
			),
		 
		),
	),
4=>array(
		'id'=>1,
		'type'=>'national',
		'entity'=>'pilot',
		'name'=>'German HG Ranking',
		'localName'=>'Deutsche Drachenwertung',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>0, // NAC club selection menu on top
		'forceNacId'=>1, // the only NAC ID to be used
		
		//P. Wild 31.08.2007
		//'dontShowManufacturers'=>1, //Manufacturers selection menu on top
   		//'dontShowDatesSelection'=>1, //no date selection menu
		
		
		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		'subranks'=>array(
/*			1=>array('id'=>1,
				'name'=>'PG Sport',
				'localName'=>'PG Sport',
			),
			2=>array('id'=>2,
				'name'=>'PG Open',
				'localName'=>'PG Open',
			),
			3=>array('id'=>3,
				'name'=>'PG Tandem',
				'localName'=>'PG Tandem',
			),*/
			4=>array('id'=>4,
				'name'=>'Hangglider',
				'localName'=>'Drachenflieger',
			),
			5=>array('id'=>5,
				'name'=>'Rigid Wing',
				'localName'=>'Starrflügel',
			),
			/*6=>array('id'=>6,
				'name'=>'Junior PG',
				'localName'=>'Junior PG',
			),*/
			7=>array('id'=>7,
				'name'=>'Junior HG',
				'localName'=>'Junior HG',
			),
			/*8=>array('id'=>8,
				'name'=>'Womens PG',
				'localName'=>'Damen PG',
			),*/
			9=>array('id'=>9,
				'name'=>'Womens HG',
				'localName'=>'Damen HG',
			),
			/*10=>array('id'=>10,
				'name'=>'Newcomer PG',
				'localName'=>'Newcomer PG',
			),*/
			11=>array('id'=>11,
				'name'=>'Newcomer HG',
				'localName'=>'Newcomer HG',
			),
			
		),

	),

	2=>array(
		'id'=>2,
		'type'=>'national',
		'entity'=>'club',
		'name'=>'German Club Ranking',
		'localName'=>'Deutsche Vereinswertung',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>1, // NAC club selection menu on top
		'dontShowDatesSelection'=>1, //no date selection menu
		//P. Wild 31.08.2007
		'dontShowManufacturers'=>1, //Manufacturers selection menu on top

		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		'subranks'=>array(
			1=>array('id'=>1,
				'name'=>'Paraglider',
				'localName'=>'Paraglider',
			),
			2=>array('id'=>2,
				'name'=>'Hangglider',
				'localName'=>'Drachen',
			),

		),
	),

	3=>array('id'=>3,
		'type'=>'national',
		'entity'=>'pilot',
		'name'=>'Austrian Hangglider Ranking',
		'localName'=>'Österreichische Drachenwertung',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>0, // NAC club selection menu on top
		'forceNacId'=>2, // the only NAC ID to be used
		
		//P. Wild 31.08.2007
		'dontShowManufacturers'=>1, //Manufacturers selection menu on top
        'dontShowDatesSelection'=>1, //no date selection menu

		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		 'subranks'=>array(
/*			1=>array('id'=>1,
				'name'=>'PG Sport',
				'localName'=>'PG Sport',
			),
			2=>array('id'=>2,
				'name'=>'PG Open',
				'localName'=>'PG Open',
			),
			3=>array('id'=>3,
				'name'=>'PG Tandem',
				'localName'=>'PG Tandem',
			),*/
			4=>array('id'=>4,
				'name'=>'Hangglider',
				'localName'=>'Drachenflieger',
			),
			5=>array('id'=>5,
				'name'=>'Rigid Wing',
				'localName'=>'Starrflügel',
			),
			/*6=>array('id'=>6,
				'name'=>'Junior PG',
				'localName'=>'Junior PG',
			),
			7=>array('id'=>7,
				'name'=>'Junior HG',
				'localName'=>'Junior HG',
			),
			/*8=>array('id'=>8,
				'name'=>'Womens PG',
				'localName'=>'Damen PG',
			),
			9=>array('id'=>9,
				'name'=>'Womens HG',
				'localName'=>'Damen HG',
			),
			/*10=>array('id'=>10,
				'name'=>'Newcomer PG',
				'localName'=>'Newcomer PG',
			),
			11=>array('id'=>11,
				'name'=>'Newcomer HG',
				'localName'=>'Newcomer HG',
			), */
   ),
  ),
  
6=>array(
		'id'=>6,
		'type'=>'national',
		'entity'=>'club',
		'name'=>'Austrian Club Ranking',
		'localName'=>'Österreichische Vereinswertung',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>1, // NAC club selection menu on top
		'dontShowDatesSelection'=>1, //no date selection menu
		//P. Wild 31.08.2007
		'dontShowManufacturers'=>1, //Manufacturers selection menu on top

		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		'subranks'=>array(
			/*1=>array('id'=>1,
				'name'=>'Paraglider',
				'localName'=>'Paraglider',
			),*/
			2=>array('id'=>2,
				'name'=>'Hangglider',
				'localName'=>'Drachen & Starflügel',
			),

		),
	),
	
5=>array('id'=>5,
		'type'=>'national',
		'entity'=>'pilot',
		'name'=>'Odenwald Cup',
		'localName'=>'Odenwald Cup',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		'dontShowNacClubSelection'=>0, // NAC club selection menu on top
		'forceNacId'=>1, // the only NAC ID to be used
		
		//P. Wild 31.08.2007
		'dontShowManufacturers'=>1, //Manufacturers selection menu on top
        'dontShowDatesSelection'=>1, //no date selection menu
		
		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array ('use_calendar_years'=>0),
		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
			'use_season_years'=>1,	
			'use_defined_seasons'=>1,
			'seasons'=>array(
				2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
				2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
			)					 		 
		 ),
		 
		'subranks'=>array(
			1=>array('id'=>1,
				'name'=>'PG Sport',
				'localName'=>'PG Sport',
			),
			2=>array('id'=>2,
				'name'=>'PG Open',
				'localName'=>'PG Open',
			),
			3=>array('id'=>3,
				'name'=>'PG Tandem',
				'localName'=>'PG Tandem',
			),
			4=>array('id'=>4,
				'name'=>'Hangglider',
				'localName'=>'Drachenflieger',
			),
			5=>array('id'=>5,
				'name'=>'Rigid Wing',
				'localName'=>'Starrflügel',
			),
			6=>array('id'=>6,
				'name'=>'Jun.PG',
				'localName'=>'Jun.PG',
			),
			7=>array('id'=>7,
				'name'=>'Jun.HG',
				'localName'=>'Jun.HG',
			),
			8=>array('id'=>8,
				'name'=>'Womens PG',
				'localName'=>'Damen PG',
			),
			9=>array('id'=>9,
				'name'=>'Womens HG',
				'localName'=>'Damen HG',
			),
			10=>array('id'=>10,
				'name'=>'New.PG',
				'localName'=>'New.PG',
			),
			11=>array('id'=>11,
				'name'=>'New.HG',
				'localName'=>'New.HG',
			),
		),

  ),
);

require_once dirname(__FILE__)."/../CL_dates.php";

foreach ( $ranksList as $tmpRankID=>$tmpRank) {
	$foundCurrentSeason=0;
	if ( $ranksList[$tmpRankID]['seasons']['end_season']=='current' ) {
		$foundCurrentSeason=dates::getCurrentSeason($tmpRankID);		
		$ranksList[$tmpRankID]['seasons']['end_season']= $foundCurrentSeason;
	}

	if ( $ranksList[$tmpRankID]['datesMenu']=='seasons' && $ranksList[$tmpRankID]['menuYear']=='current') {
			if (!$foundCurrentSeason) 		$foundCurrentSeason=dates::getCurrentSeason($tmpRankID);
			$ranksList[$tmpRankID]['menuYear']=$foundCurrentSeason;
	}	

}
?>