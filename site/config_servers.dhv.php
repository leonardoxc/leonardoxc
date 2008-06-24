<?

$CONF['servers']['syncLog']['dontLog']=array(1,2,3,4,9,12 ); // we dont log PGF,GR, BR,PT,TR,CA

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
	
	'serverPass'=>"oi309gqqng38285729verfgkw25",	// WE GIVE
	'clientPass'=>"", // WE DONT GET

	'is_active'=>1,
	
	'treat_flights_as_local'=>0,
	'exclude_from_list'=>0,
	'exclude_from_league'=>0,
	'allow_duplicate_flights'=>1,
	
	'dont_give_servers'=>array(8),	// DONT GIVE TO PGF flights from xcontest
	'accept_also_servers'=>array(2,3,4,9,12),   // accept from PGF also flights from GR BR PT TR CA

	'sync_format'=>"JSON",
	'sync_type'=>1, // ONLY BASIC FLIGHT INFO
	'use_zip'=>0,
	
	'gives_waypoints'=>1,
	'waypoint_countries'=>"",
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
	'serverPass'=>"jger0300345ujgegwerg2348gbh32g", // we GIVE to xccontest
	'clientPass'=>"", // WE DONT GET

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
	'serverPass'=>"hdfjer6u63jytjwe54uwgjw", // WE GIVE ( fot TESTING )
	'clientPass'=>"", // WE DONT GET
	'sync_format'=>"JSON",
	'sync_type'=>"1", // ONLY BASIC FLIGHT INFO
	'use_zip'=>"0",

	'is_active'=>0,

	'dont_give_servers'=>array(8),	// DONT GIVE TO PGF flights from xcontest
	'accept_also_servers'=>array(2,3,4,9),   // accept from PGF also flights from GR BR PT TR

	'gives_waypoints'=>1,
	'waypoint_countries'=>"",
),


10002=>array(
	'id'=>10002,
	'name'=>"Leonardo XC DHV2",

	'isLeo'=>1,
	'installation_type'=>2,
	'leonardo_version'=>"2.9.99a",
	'url'=>"dhvxc.dhv1.de/phpBB/modules?name=leonardo",
	'url_base'=>"dhvxc.dhv1.de/phpBB/modules/leonardo",
	'url_op'=>"dhvxc.dhv1.de/phpBB/modules/leonardo/op.php",
	'admin_email'=>"Admin@dhv.de",
	'site_pass'=>"", 

	'serverPass'=>"823jvusaq91otdjng482l6vb893",  // WE GIVE 

	'clientPass'=>"",        // WE DONT GET
	'sync_format'=>"JSON",
	'sync_type'=>2, // LOCAL
	'use_zip'=>1,

	'is_active'=>1,

	'treat_flights_as_local'=>0,
	'exclude_from_list'=>1,
	'exclude_from_league'=>1,
	'allow_duplicate_flights'=>1,

	'dont_give_servers'=>array(5,8),	
	'accept_also_servers'=>array(5),
	
	'gives_waypoints'=>1,
	'waypoint_countries'=>"DE",
),

);


?>