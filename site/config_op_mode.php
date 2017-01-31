<?
// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module only phpBB2 NOT phpBB3
// 3 = standalone -- still work in progress
// 4 = discuz
// 5 = joomla  1.0 and 1.5
// 6 = phpbb3
$opMode= 3; 

// override the operation mode via a define
if ( defined('Leonardo_op_mode') ) $opMode= Leonardo_op_mode; 

/* You can overider these settings:
$CONF_use_own_template
1-> Use the leonardo template so the leonardo pages will appear on their own with no connection with the CMS, 
    except of course for the user db connection
$CONF_use_own_login 
1-> Should be set to 1 when using $CONF_use_own_template=1, this will set the login/logout/register url to a custom
    provided url that is set in the site/predefined/.../config.php files
0-> No login/logout/register links will be generated on the leonardo menus, since the CMS template will 
    have these somehwere on the page
*/
if ($opMode==1) { // phpnuke -> always used with phpnuke template only
	$CONF_use_own_template=0;
	$CONF_use_own_login=0;
} else if ($opMode==2  ) { // phpbb2 -> recomended to be used with leonardo template 
	$CONF_use_own_template=1;
	$CONF_use_own_login=1;
} else if ($opMode==3  ) { // standalone -> always used with leonardo template only
	$CONF_use_own_template=1;
	$CONF_use_own_login=1;
} else if ($opMode==4  ) { // discuss -> recomended to be used with leonardo template 
	$CONF_use_own_template=1;
	$CONF_use_own_login=1;
} else if ($opMode==5) { // joomla 1.5 -> recomended to be used with leonardo template 
  /*  SEO urls settings for intergrated joomla apearance
	File & params of running Leonardo
		/joomla_path/index.php?option=com_leonardo&Itemid=53
	The path to Leonardo files
		/leo
	The virtual path that will be used
		/leonardo
	Also set
		$CONF_use_own_template=0;
		$CONF_use_own_login=0;
   */
	$CONF_use_own_template=1;
	$CONF_use_own_login=1;
		
	// this must the the real path to the root joomla dir!
	// EXAMPLE 
	// joomla  is installed on /
	// leonardo is installed on /leo
	define( 'JPATH_BASE', realpath( dirname(__FILE__).'/../..' )   );
	// echo "JPATH_BASE=".JPATH_BASE;
} else if ($opMode==6  ) { // phpbb3 -> STRONGLY recomended to be used with leonardo template 
	$CONF_use_own_template=1;
	$CONF_use_own_login=1;
	
	// replace this with the absolute path of phpbb3 
	// EXAMPLES 
	// phpbb3 is installed on /
	// leonardo is installed on /leo
	$phpbb3AbsPath=realpath( dirname(__FILE__).'/../..' );
	
	// phpbb3 is installed on /
	// leonardo/ is installed on /other/leonardo
	// $phpbb3AbsPath=realpath( dirname(__FILE__).'/../../..' );
	
	// phpbb3 is installed on /phpbb3 
	// leonardo/ is installed on /other/leonardo
	// $phpbb3AbsPath=realpath( dirname(__FILE__).'/../../../phpbb3' );
	$phpbb_root_path=$phpbb3AbsPath.'/';
}


// the method to use for links in the menu and other parts of leonardo
// 1 -> current old way, using &name=value args + session variables
// 2 -> same as 1 but all sessions vars are in the url, this means that the url 
// 3 -> SEO urls

//  NOTE , THESE ARE THE DEFAULT VALUES , DONT CHANGE THEM ,
//  INSTEAD EDIT THE FILE config_mod_rewrite.php either manually
//  or from "admin"->"SEO Urls"
$CONF['links']['type']=1;
$CONF['links']['baseURL']='/leonardo';
if ( in_array($opMode,array(2,3,5,6)) ) { 
        //  NOTE !!!!!! SEO URLS are only compatible with opmodes 2,6  (phpbb) 3 (standalone) and 5 (joomla , but not inside the joomla template)
        @include dirname(__FILE__).'/config_mod_rewrite.php';
}


$CONF_isMasterServer=0; 

?>
