<?

$CONF['servers']['syncLog']['dontLog']=array(1,2,3,4,9 ); // we dont log PGF,GR, BR,PT,TR

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
	
	'serverPass'=>"4285372987592345425",	// WE GIVE
	'clientPass'=>"fdsdfg343hwero250235423", // we GET

	'is_active'=>1,
	
	'treat_flights_as_local'=>0,
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
	
	'dont_give_servers'=>array(8),	// DONT GIVE TO PGF flights from xcontest
	'accept_also_servers'=>array(2,3,4,9),   // accept from PGF also flights from GR BR PT TR

	'sync_format'=>"JSON",
	'sync_type'=>"1", // ONLY BASIC FLIGHT INFO
	'use_zip'=>"0",
	
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
	'exclude_from_league'=>1,
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
	
5=>array(
	'id'=>5,
	'name'=>"DHV",
	'short_name'=>'DHV',
	'name_filter'=>"Leonardo XC DHV",

	'isLeo'=>1,
	'installation_type'=>2,
	'leonardo_version'=>"2.9.0",
	'url'=>"xc.dhv.de/xc/modules?name=leonardo",
	'url_base'=>"xc.dhv.de/xc/modules/leonardo",
	'url_op'=>"xc.dhv.de/xc/modules/leonardo/op.php",
	'admin_email'=>"Admin@dhv.de",
	'site_pass'=>"af5uk04l2ftjd5jzsekgt31ko",

	'serverPass'=>"",
	'clientPass'=>"823jvusaq91otdjng482l6vb893", // WE GET 

	'sync_format'=>"JSON",
	'sync_type'=>"2", // FULL SYNC
	'use_zip'=>"1",
	'rescore_if_missing'=>1, // if sync_type=LOCAL and the EXTENTED scoring INFO is missing rescore flight

	'is_active'=>1,
	
	'treat_flights_as_local'=>1,
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,

	//'dont_give_servers'=>array(8,10002),	
	'accept_also_servers'=>'',

	'gives_waypoints'=>1,
	'waypoint_countries'=>"DE",
),

8=>array(
	'id'=>8,
	'name'=>"xcontest",
	'short_name'=>'XC',
	'name_filter'=>"XC Contest",
	
	'isLeo'=>0,
	'installation_type'=>1, // 1-> xcontest
	'leonardo_version'=>"0",
	'url'=>"www.xcontest.org",
	'url_base'=>"www.xcontest.org",
	'url_sync'=>"sync.xcontest.org/v1.rbx?", // startID=1&count=5	
	'url_op'=>"www.xcontest.org",
	'admin_email'=>"petr@pgweb.cz",

	'site_pass'=>"",
	'serverPass'=>"rgerg934983hg323ggbb44", // we GIVE to xccontest
	'clientPass'=>"",

	'sync_format'=>"JSON",
	'sync_type'=>"1",
	'use_zip'=>"0",

	'treat_flights_as_local'=>0,
	'exclude_from_list'=>0,
	'exclude_from_league'=>1,
	'allow_duplicate_flights'=>1,

	'dont_give_servers'=>array(1,2,3,4,9),	// DONT GIVE TO xcontest flights from PGF ,GR,BR,PT,TR
	'accept_also_servers'=>'',  // ACCPET ONLY flifghts origianlly submitted to XContest
	
	'is_active'=>1,

	'gives_waypoints'=>0,
	'waypoint_countries'=>"",
),

9=>array(
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

99=>array(
	'id'=>99,
	'name'=>"pgforum.thenet.gr",
	'short_name'=>'PG2',

	'isLeo'=>1,
	'installation_type'=>2,
	'leonardo_version'=>"2.9.0",
	'url'=>"pgforum.thenet.gr/modules.php?name=leonardo",
	'url_base'=>"pgforum.thenet.gr/modules/leonardo",
	'url_op'=>"pgforum.thenet.gr/modules/leonardo/op.php",
	'admin_email'=>"andread@thenet.gr",
	
	'site_pass'=>"",
	'serverPass'=>"jj3f3249g33asa348914", // WE GIVE ( fot TESTING )
	'clientPass'=>"",
	'sync_format'=>"JSON",
	'sync_type'=>"1", // ONLY BASIC FLIGHT INFO
	'use_zip'=>"0",

	'is_active'=>0,

	'dont_give_servers'=>array(8),	// DONT GIVE TO PGF flights from xcontest
	'accept_also_servers'=>array(2,3,4,9),   // accept from PGF also flights from GR BR PT TR

	'gives_waypoints'=>1,
	'waypoint_countries'=>"",
),

);


?>