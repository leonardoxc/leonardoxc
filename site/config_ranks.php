<?


$ranksList=array(

1=>array('id'=>1,
		 'type'=>'national',
		 'entity'=>'pilot',
		 'name'=>'German National Ranking',
		 'localName'=>'German National Ranking (in german)',
		 'localLanguage'=>'german',
		 'dontShowCatSelection'=>1, // no glider type selection menu on top
 		 'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current', // either force the menu item to point to this year or put zero  
		 
		 'useCustomYears'=>1, 
		 'years'=>array (
				'use_calendar_years'=>0,
				'start_year'=>2005,
				'end_year'=>date("Y"),
		 ),

		 'useCustomSeasons'=>1, // definition must follow !		 
		 'seasons'=>array (
	
			'use_season_years'=>1,	
		
			
			// IF this is set then all info on which sesons to display in the menu
			//     will be taken from the $CONF['dates']
			// ELSE 
			//    the menu will display season starting from $CONF['start_season'] to $CONF['end_season']
			//    BOTH VALUES MUST BE defined
			//    In this case also the season start/end will be defined from 
			//    $CONF['season_default_start'] and $CONF['season_default_end']	
			'use_defined_seasons'=>0,

			// The next 4 values will be used in case of 	$CONF['use_defined_seasons']=0
			'season_default_start'=>'10-1',
			'season_default_end'=>'9-31',
			
			// UNCOMMENT ONLY ONE of the 3 next cases

			// if the season 2007 is 2006-10-1 till  2007-9-30
			'season_start_year_diff'=>-1,
			'season_end_year_diff'=>0,

			// else if season 2007 is 2007-4-1 till  2008-3-31
			//'season_start_year_diff'=>0,
			//'season_end_year_diff'=>1,

			// else if season 2007 is 2007-1-1 till  2007-12-31
			//'season_start_year_diff'=>0,
			//'season_end_year_diff'=>0,

				
			'start_season'=>2007,
			'end_season'=>'current',
		
		
			// The next array will be used in case of 	$CONF['use_defined_seasons']=1
			'seasons'=>array(
				2008=>array('start'=>'2007-10-1','end'=>'2008-09-30'),		
				2007=>array('start'=>'2006-10-1','end'=>'2007-9-30',
							'subseasons'=>array(
								'winter'=>array('start'=>'2006-10-1','end'=>'2007-3-31','localName'=>'winterInLocalLanguage'),
								'summer'=>array('start'=>'2007-3-1','end'=>'2007-9-30','localName'=>'summerInLocalLanguage'),
							)					
						),					
			)					 
		 
		 ),
		 
		 'subranks'=>array(
		 		1=>array('id'=>1, 
						'name'=>'Paraglider (FAI 3) Sport',
						'localName'=>'Paraglider (FAI 3) Sport (in german)',
						),
		 		2=>array('id'=>2, 
						'name'=>'Paraglider (FAI 3) Open',
						'localName'=>'Paraglider (FAI 3) Open (in german)',
						),
		 		3=>array('id'=>3, 
						'name'=>'Paraglider (FAI 3) Tandem',
						'localName'=>'Paraglider (FAI 3) Tandem (in german)',
						),
		 		4=>array('id'=>4, 
						'name'=>'Hangglider (FAI 1)',
						'localName'=>'Hangglider (FAI 1) (in german)',
						),
		 		5=>array('id'=>5, 
						'name'=>'Rigid Wing (FAI 5)',
						'localName'=>'Rigid Wing (FAI 5) (in german)',
						),
		 
			),
		),

2=>array('id'=>2,
		 'type'=>'national',
		 'entity'=>'club',
		 'name'=>'German Club Ranking',
		 'localName'=>'German Club Ranking (in german)',
		 'localLanguage'=>'german',
		 'dontShowCatSelection'=>1, // no glider type selection menu on top
 		 'dontShowCountriesSelection'=>1, // no glider type selection menu on top
		 
 		  // Ths configures the top menu links to point to a specific year/season
		 'datesMenu'=>'seasons',	
		 'menuYear'=>'current' ,
		 
		 'useCustomYears'=>1, 
		 'years'=>array (
				'use_calendar_years'=>0,
				'start_year'=>2003,
				'end_year'=>date("Y"),
		 ),


		 'useCustomSeasons'=>1, 
		 'seasons'=>array (	
			'use_season_years'=>1,	
			'use_defined_seasons'=>0,
			// The next 4 values will be used in case of 	$CONF['use_defined_seasons']=0
			'season_default_start'=>'10-1',
			'season_default_end'=>'9-31',
			// if the season 2007 is 2006-10-1 till  2007-9-30
			'season_start_year_diff'=>-1,
			'season_end_year_diff'=>0,				
			'start_season'=>2007,
			'end_season'=>'current',
		 ),
		 
		 'subranks'=>array(
		 		1=>array('id'=>1, 
						'name'=>'Paraglider',
						'localName'=>'Paraglider (in german)',
						),
		 		2=>array('id'=>2, 
						'name'=>'Hangglider',
						'localName'=>'Hangglider (in german)',
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