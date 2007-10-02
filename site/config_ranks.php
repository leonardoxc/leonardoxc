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

		 'useCustomSeasons'=>1, // definition must follow !
		 'seasons'=>array (
		 	'use_calendar_years'=>1,	
			'use_season_years'=>1,	
	
			// IF this is set then all info on which sesons to display in the menu
			//     will be taken forh the $CONF['seasons']
			// ELSE 
			//    the menu will display season starting from $CONF['start_season'] to $CONF['end_season']
			//    BOTH VALUES MUST BE defined
			//    In this case also the season start/end will be defined from 
			//    $CONF['season_default_start'] and $CONF['season_default_end']	
			'use_defined_seasons'=>0,

			// The next 4 values will be used in case of 	$CONF['show_only_defined_seasons']=0
			'season_default_start'=>'10-1',
			'season_default_end'=>'9-31',
			
			// ONLY ONE of the 3 next varibles canbe set to TRUE !!!
			// if the season 2007 is 2006-10-1 till  2007-9-30
			'season_default_starts_in_previous_year'=>1,
			// else if season 2007 is 2007-4-1 till  2008-3-31
			'season_default_ends_in_next_year'=>0,
			// else if season 2007 is 2007-1-1 till  2007-12-31
			'season_default_ends_in_same_year'=>0,
		
		
			'start_season'=>2004,
			'end_season'=>2008,
		
			// The next array will be used in case of 	$CONF['show_only_defined_seasons']=1
			'seasons'=>array(
				2007=>array('start'=>'2006-10-1','end'=>'2007-9-30',
							'subseasons'=>array(
								'winter'=>array('start'=>'2006-10-1','end'=>'2007-3-31','localName'=>'winterInLocalLanguage'),
								'summer'=>array('start'=>'2007-3-1','end'=>'2007-9-30','localName'=>'summerInLocalLanguage'),
							)					
						),
				2008=>array('start'=>'2007-10-1','end'=>'2008-09-30'),			
			)					 
		 
		 ),
		 
		 
		 
		 'datesMenu'=>'seasons',
		 'startYear'=>2007,
		 'menuYear'=>2007, // either force the menu item to point to this year or put zero  
		 
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
		 
 		 'useCustomSeasons'=>0, // we use the seasons/years of the main server
		 
		 'datesMenu'=>'years',
		 'startYear'=>2007,
		 'menuYear'=>2007, // either force the menu item to point to this year or put zero  
		 
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

?>