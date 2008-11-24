<? 
	require_once dirname(__FILE__).'/../CL_dates.php';

 $clubsList=array(
 	1=>array(	"desc"=>"Broken Thermal Club",
				"id"=>1,
				"lang"=>"mexican",
				"areaID"=>0,
				"addManual"=>1,
				"adminID"=>76,
		    ) ,
	2=>array(	"desc"=>"Tea Club ",
				"id"=>2,
				"lang"=>"mexican",
				"areaID"=>0,
				"addManual"=>1,
				"adminID"=>76,
			) ,

	3=>array(	"desc"=>"Greece 2006 XC league",
				"id"=>3,
				"lang"=>"greek",
				"areaID"=>1,
				"addManual"=>0,
				"adminID"=>76,
				"flightsInLeague"=>3,
				// extra fields to expand club functionality
				"noSpecificMembers"=>1,

				"defaultDisplayLanguage"=>"greek",
				"defaultDisplayTheme"=>"basic",

				//"countryCodes"=>array("gr"),
				//"pilotNationality"=>array("gr"),
				"gliderCat"=>array(1,2),
				

				 'useCustomYears'=>1, 
				 'years'=>array ('use_calendar_years'=>0),
				 'useCustomSeasons'=>1, // definition must follow !		 

				 'seasons'=>array (
					'use_season_years'=>1,	
					'use_defined_seasons'=>0,
					'season_default_start'=>'4-1',
					'season_default_end'=>'3-31',

					// ONLY ONE of the 3 next varibles canbe set to TRUE !!!
					// if the season 2007 is 2006-10-1 till  2007-9-30
					//'season_start_year_diff'=>-1,
					//'season_end_year_diff'=>0,
				
					// else if season 2007 is 2007-4-1 till  2008-3-31
					'season_start_year_diff'=>0,
					'season_end_year_diff'=>1,
				
					// else if season 2007 is 2007-1-1 till  2007-12-31
					//'season_start_year_diff'=>0;
					//'season_end_year_diff'=>0;

					'start_season'=>2006,
					//'end_season' =>2006,
					'end_season' => dates::getCurrentSeason(0,3),
					'seasons'=>array(
						2008=>array('start'=>'2007-09-16','end'=>'2008-09-15'),	
						2007=>array('start'=>'2006-10-11','end'=>'2007-9-15'),
					)					 		 
				 ),

				"startYear"=>"2006",
				"startMonth"=>"0",
				"startDay"=>"0",

				"endYear"=>"2006",
				"endMonth"=>"0",
				"endDay"=>"0",

			) ,

	5=>array(	"desc"=>"Danish XC league",
				"id"=>5,
				"lang"=>"danish",
				"areaID"=>0,
				"addManual"=>0,
				"adminID"=>76,

				// extra fields to expand club functionality
				"noSpecificMembers"=>1,

				"defaultDisplayLanguage"=>"danish",
				"defaultDisplayTheme"=>"basic",

				"countryCodes"=>array("dk"),
				"pilotNationality"=>array("dk"),
				"gliderCat"=>array(1),
				
				"startYear"=>"2006",
				"startMonth"=>"0",
				"startDay"=>"0",

				"endYear"=>"2006",
				"endMonth"=>"0",
				"endDay"=>"0",

			) ,

        10=>array(       "desc"=>" XC Madeira Open",
                        "id"=>10,
                        "lang"=>"english",
                        "areaID"=>1,
                        "addManual"=>0,
                        "adminID"=>72,
                               
                        "noSpecificMembers"=>1,
                        "defaultDisplayLanguage"=>"basic",
                        "defaultDisplayTheme"=>"basic",
                        "gliderCat"=>array(1),

						'onlyLocalFlights'=>1,

                        ) ,
 );

foreach($clubsList as $i=>$clubInfo) {
	if ( is_array($clubsList[$i]['seasons']) ) {
		$clubsList[$i]['seasons']['end_season']=dates::getCurrentSeason(0,$i);
	}
}

// uncomment this to disable clubs
// $clubsList=array();
?>