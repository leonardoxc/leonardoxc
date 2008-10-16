<?

// put here the server ids we dont want to put into log 
// i.e to save space
$CONF['servers']['syncLog']['dontLog']=array(); 


$CONF['servers']['list']=array( 
1=>array(
	'id'=>1,
	'name'=>"paraglidingforum.com", 
	'short_name'=>'PGF',

	'name_filter'=>"ParaglidingForum",

	'isLeo'=>1,
	'installation_type'=>2,
	'leonardo_version'=>"2.9.0",

	'url'=>"www.paraglidingforum.com/modules.php?name=leonardo",
	'url_base'=>"www.paraglidingforum.com/modules/leonardo",
	'url_op'=>"www.paraglidingforum.com/modules/leonardo/op.php",
	'admin_email'=>"andread@thenet.gr",	
	'site_pass'=>"",
	
	'serverPass'=>"",	// WE DONT GIVE TO PGF
	'clientPass'=>"27hgju3j2we20fha2ldofg46qhha18rc", // we GET FROM PGF

	'is_active'=>1,
	
	'treat_flights_as_local'=>0,
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
	
	'dont_give_servers'=>array(),	// DONT GIVE TO PGF : we dont give anyway
	'accept_also_servers'=>array(2,3,4,9,12),   // accept from PGF also flights from GR BR PT TR CA 

	'sync_format'=>"JSON",
	'sync_type'=>"2", // 1-> LINK 2->FULL IGC DATA
	'use_zip'=>"1", // ONLY USED WITH 	'sync_type'=>"2"
	
	'gives_waypoints'=>1,
	'waypoint_countries'=>"",
),
	
2=>array( // We dont pull directly, but VIA pgforum
	'id'=>2,
	'name'=>"sky.gr",
	'short_name'=>'GR',
	'is_active'=>1,
	
	'name_filter'=>"Leonardo XC Greece",

	'url'=>"www.sky.gr/modules.php?name=leonardo",
	'url_base'=>"www.sky.gr/modules/leonardo",
	'url_op'=>"www.sky.gr/modules/leonardo/op.php",

	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
),

3=>array(
	'id'=>3, // We dont pull directly, but VIA pgforum
	'name'=>"www.xcbrasil.org",
	'short_name'=>'BR',
	'is_active'=>1,
	'name_filter'=>"Leonardo XC Brazil",

	'url'=>"www.xcbrasil.org/modules.php?name=leonardo",
	'url_base'=>"www.xcbrasil.org/modules/leonardo",
	'url_op'=>"www.xcbrasil.org/modules/leonardo/op.php",
	
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
),

4=>array( // We dont pull directly, but VIA pgforum
	'id'=>4,
	'name'=>"xcportugal.com",
	'short_name'=>'PT',
	'is_active'=>1,
	'name_filter'=>"Leonardo XC Portugal",

	'url'=>"www.xcportugal.com/modules.php?name=leonardo",
	'url_base'=>"www.xcportugal.com/modules/leonardo",
	'url_op'=>"www.xcportugal.com/modules/leonardo/op.php",
	
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
),
	
9=>array(// We dont pull directly, but VIA pgforum
	'id'=>9,
	'name'=>"ypforum",
	'short_name'=>'TR',
	'name_filter'=>"Leonardo XC Turkey",

	'isLeo'=>1,

	'url'=>"www.ypforum.com/modules.php?name=leonardo",
	'url_base'=>"www.ypforum.com/modules/leonardo",
	'url_op'=>"www.ypforum.com/modules/leonardo/op.php",

	'is_active'=>1,
	
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
),

12=>array(// We dont pull directly, but VIA pgforum
	'id'=>12,
	'name'=>"HPAC",
	'short_name'=>'HPAC',
	'name_filter'=>"HPAC Canadian XC League",

	'isLeo'=>1,

	'url'=>"forums.dowsett.ca/modules.php?name=leonardo",
	'url_base'=>"forums.dowsett.ca/modules/leonardo",
	'url_op'=>"forums.dowsett.ca/modules/leonardo/op.php",
	
	'is_active'=>1,

	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
),


);


?>