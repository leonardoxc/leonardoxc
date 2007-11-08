<?

$ranksList=array(

	1=>array(
		'id'=>1,
		'type'=>'national',
		'entity'=>'pilot',
		'name'=>'German PG Ranking',
		'localName'=>'Deutsche Gleitschirm Wertung',
		'localLanguage'=>'german',
		'dontShowCatSelection'=>1, // no glider type selection menu on top
		'dontShowCountriesSelection'=>1, // no glider type selection menu on top

		/* Martin Jursa 22.05.2007: Support for NAC club filtering */
		'dontShowNacClubSelection'=>0, // NAC club selection menu on top
		'forceNacId'=>1, // the only NAC ID to be used

		'datesMenu'=>'years',
		'startYear'=>2007,
		'menuYear'=>2007, // either force the menu item to point to this year or put zero
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

		'datesMenu'=>'years',
		'startYear'=>2007,
		'menuYear'=>2007, // either force the menu item to point to this year or put zero
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

		'datesMenu'=>'years',
		'startYear'=>2007,
		'menuYear'=>2007, // either force the menu item to point to this year or put zero
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

		'datesMenu'=>'years',
		'startYear'=>2007,
		'menuYear'=>2007, // either force the menu item to point to this year or put zero
		'subranks'=>array(
			4=>array('id'=>4,
				'name'=>'Hangglider (FAI 1)',
				'localName'=>'Drachenflieger (FAI 1)',
			),
			5=>array('id'=>5,
				'name'=>'Rigid Wing (FAI 5)',
				'localName'=>'Starrflügel (FAI 5)',
			),
		),
	),

);

?>