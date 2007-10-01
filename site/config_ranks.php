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