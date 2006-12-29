<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_header_leonardo.php,v 1.4 2006/12/29 00:18:38 manolis Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

define('HEADER_INC', TRUE);

	
//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] && 0 )
{
	$phpver = phpversion();

	$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

//
// Parse and show the overall header.
//

$Ltemplate = new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

$Ltemplate->set_filenames(array(
	'overall_header' => 'tpl/overall_header.html' )
);

//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	if (empty($leonardo_header)) 
		$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	else 
		$u_login_logout = 'modules.php?name=leonardo&op=login&logout=true&amp;sid=' . $userdata['session_id'];		
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	if (empty($leonardo_header)) 
		$u_login_logout = 'login.'.$phpEx;
	else
		$u_login_logout = 'modules.php?name=leonardo&op=login';			
	$l_login_logout = $lang['Login']; 
}


$tplPath=$moduleRelPath.'/templates/'.$PREFS->themeName.'/tpl';
/*
if ($ap) { // a league
	$topCustomLogo=$apList[$ap]['desc'];
} else {
	$topCustomLogo='';
}
*/
if ($clubID) { // a league
	$topCustomLogo=$clubsList[$clubID]['desc'];
} else {
	$topCustomLogo='';
}

$s_last_visit = ( $userdata['session_logged_in'] ) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$Ltemplate->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'],
'META_HTTP_EQUIV_TAGS' => '
<meta http-equiv="refresh" content="' . $board_config['meta_redirect_url_time'] . '; URL=' . $board_config['meta_redirect_url_adress'] . '">
<meta http-equiv="refresh" content="' . $board_config['meta_refresh'] .'">
<meta http-equiv="pragma" content="' . $board_config['meta_pragma'] .'">
<meta http-equiv="content-language" content="' . $board_config['meta_language'] .'">',
'META_TAGS' => '
<meta name="keywords" content="' . $board_config['meta_keywords'] .'">
<meta name="description" content="' . $board_config['meta_description'] .'">
<meta name="author" content="' . $board_config['meta_author'] .'">
<meta name="identifier-url" content="' . $board_config['meta_identifier_url'] .'">
<meta name="reply-to" content="' . $board_config['meta_reply_to'] .'">
<meta name="revisit-after" content="' . $board_config['meta_revisit_after'] .'">
<meta name="category" content="' . $board_config['meta_category'] .'">
<meta name="copyright" content="' . $board_config['meta_copyright'] .'">
<meta name="generator" content="' . $board_config['meta_generator'] .'">
<meta name="robots" content="' . $board_config['meta_robots'] .'">
<meta name="distribution" content="' . $board_config['meta_distribution'] .'">
<meta name="date-creation-yyyymmdd" content="' . $board_config['meta_date_creation_year'] . '' . $board_config['meta_date_creation_month'] . '' . $board_config['meta_date_creation_day'] . '">
<meta name="date-revision-yyyymmdd" content="' . $board_config['meta_date_revision_year'] . '' . $board_config['meta_date_revision_month'] . '' . $board_config['meta_date_revision_day'] . '">',

	'PAGE_TITLE' => $page_title,
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),

	'T_PATH' => $tplPath.'/',
	'TOP_CUSTOM_LOGO'=>$topCustomLogo,
	
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'U_INDEX' => append_sid('index.'.$phpEx),
	
	'T_HEAD_STYLESHEET' => $tplPath.'/style.css',
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	
	)
);

//
// Login box?
//
if ( !$userdata['session_logged_in'] )
{
	$Ltemplate->assign_block_vars('switch_user_logged_out', array());
}
else
{
	$Ltemplate->assign_block_vars('switch_user_logged_in', array());

	if ( !empty($userdata['user_popup_pm']) )
	{
		$Ltemplate->assign_block_vars('switch_enable_pm_popup', array());
	}
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting

/*
if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');
*/

$Ltemplate->pparse('overall_header');

?>
