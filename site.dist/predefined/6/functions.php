<?php

// added at phpBB 2.0.11 to properly format the username
function phpbb_clean_username($username)
{
	$username = htmlspecialchars(rtrim(trim($username), "\\"));
	$username = substr(str_replace("\\'", "'", $username), 0, 25);
	$username = str_replace("'", "\\'", $username);

	return $username;
}

function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//
// Create date/time from format and timezone
//
function create_date($format, $gmepoch, $tz)
{
	global $board_config, $lang;
	static $translate;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}


//
// This does exactly what preg_quote() does in PHP 4-ish
// If you just need the 1-parameter preg_quote call, then don't bother using this.
//
function phpbb_preg_quote($str, $delimiter)
{
	$text = preg_quote($str);
	$text = str_replace($delimiter, '\\' . $delimiter, $text);
	
	return $text;
}


//
// This is general replacement for die(), allows templated
// output in users (or default) language, etc.
//
// $msg_code can be one of these constants:
//
// GENERAL_MESSAGE : Use for any simple text message, eg. results 
// of an operation, authorisation failures, etc.
//
// GENERAL ERROR : Use for any error which occurs _AFTER_ the 
// common.php include and session code, ie. most errors in 
// pages/functions
//
// CRITICAL_MESSAGE : Used when basic config data is available but 
// a session may not exist, eg. banned users
//
// CRITICAL_ERROR : Used when config data cannot be obtained, eg
// no database connection. Should _not_ be used in 99.5% of cases
//
function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
	global $userdata, $user_ip, $session_length;
	global $starttime;

	if(defined('HAS_DIED'))
	{
		die("message_die() was called multiple times. This isn't supposed to happen. Was message_die() used in page_tail.php?");
	}

	define(HAS_DIED, 1);
	

	$sql_store = $sql;
	
	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent 
	// subsequent queries from overwriting the status of sql_error()
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		$sql_error = $db->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( $err_line != '' && $err_file != '' )
		{
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )	$msg_title = 'Information';
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )	$msg_title = 'Critical_Information';
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )	$msg_text = $lang['An_error_occured'];
			if ( $msg_title == '' )	$msg_title = $lang['General_Error'];
			break;

		case CRITICAL_ERROR:
			//
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			//
			if ( $msg_text == '' )	$msg_text = 'A_critical_error';
			if ( $msg_title == '' )	$msg_title = 'phpBB : <b>' . 'Critical_Error' . '</b>';
			break;
	}

	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}

		echo "<div><b>$msg_title</b></div><br><BR>$msg_text";
	}
	else
	{
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}

	exit;
}

require_once dirname(__FILE__).'/helper.php';

// this is for joomla / when phpbb3 is bridged to joomla!
function leonardo_check_password($password,$hash) {

	return leonardo_check_hash($password, $hash);
	
	// this is the joomla way 
	/*
	$parts	= explode( ':', $hash );
	$crypt	= $parts[0];
	$salt	= @$parts[1];
	

	$testcrypt = JUserHelper::getCryptedPassword($password, $salt);


	if ($crypt == $testcrypt) {
		return true;
	} else {
		return false;
	}
	*/
}

/**
*
* @version Version 0.1 / $Id: functions.php,v 1.6 2010/04/06 21:21:23 manolis Exp $
*
* Portable PHP password hashing framework.
*
* Written by Solar Designer <solar at openwall.com> in 2004-2006 and placed in
* the public domain.
*
* There's absolutely no warranty.
*
* The homepage URL for this framework is:
*
*   http://www.openwall.com/phpass/
*
* Please be sure to update the Version line if you edit this file in any way.
* It is suggested that you leave the main version number intact, but indicate
* your project name (after the slash) and add your own revision information.
*
* Please do not change the "private" password hashing method implemented in
* here, thereby making your hashes incompatible.  However, if you must, please
* change the hash type identifier (the "$P$") to something different.
*
* Obviously, since this code is in the public domain, the above are not
* requirements (there can be none), but merely suggestions.
*
*
* Hash the password
*/

function leonardo_hash($password)
{
   $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

   $random_state = uniqid();
   $random = '';
   $count = 6;

   if (($fh = @fopen('/dev/urandom', 'rb')))
   {
      $random = fread($fh, $count);
      fclose($fh);
   }

   if (strlen($random) < $count)
   {
      $random = '';

      for ($i = 0; $i < $count; $i += 16)
      {
         $random_state = md5(uniqid() . $random_state);
         $random .= pack('H*', md5($random_state));
      }
      $random = substr($random, 0, $count);
   }

   $hash = _leonardo_hash_crypt_private($password, _leonardo_hash_gensalt_private($random, $itoa64), $itoa64);

   if (strlen($hash) == 34)
   {
      return $hash;
   }

   return md5($password);
}

/**
* Check for correct password
*/
function leonardo_check_hash($password, $hash)
{
   $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
   if (strlen($hash) == 34)
   {
      return (_leonardo_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
   }

   return (md5($password) === $hash) ? true : false;
}

/**
* Generate salt for hash generation
*/
function _leonardo_hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
{
   if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
   {
      $iteration_count_log2 = 8;
   }

   $output = '$H$';
   $output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
   $output .= _leonardo_hash_encode64($input, 6, $itoa64);

   return $output;
}

/**
* Encode hash
*/
function _leonardo_hash_encode64($input, $count, &$itoa64)
{
   $output = '';
   $i = 0;

   do
   {
      $value = ord($input[$i++]);
      $output .= $itoa64[$value & 0x3f];

      if ($i < $count)
      {
         $value |= ord($input[$i]) << 8;
      }

      $output .= $itoa64[($value >> 6) & 0x3f];

      if ($i++ >= $count)
      {
         break;
      }

      if ($i < $count)
      {
         $value |= ord($input[$i]) << 16;
      }

      $output .= $itoa64[($value >> 12) & 0x3f];

      if ($i++ >= $count)
      {
         break;
      }

      $output .= $itoa64[($value >> 18) & 0x3f];
   }
   while ($i < $count);

   return $output;
}

/**
* The crypt function/replacement
*/
function _leonardo_hash_crypt_private($password, $setting, &$itoa64)
{
   $output = '*';

   // Check for correct hash
   if (substr($setting, 0, 3) != '$H$')
   {
      return $output;
   }

   $count_log2 = strpos($itoa64, $setting[3]);

   if ($count_log2 < 7 || $count_log2 > 30)
   {
      return $output;
   }

   $count = 1 << $count_log2;
   $salt = substr($setting, 4, 8);

   if (strlen($salt) != 8)
   {
      return $output;
   }

   /**
   * We're kind of forced to use MD5 here since it's the only
   * cryptographic primitive available in all versions of PHP
   * currently in use.  To implement our own low-level crypto
   * in PHP would result in much worse performance and
   * consequently in lower iteration counts and hashes that are
   * quicker to crack (by non-PHP code).
   */
   if (PHP_VERSION >= 5)
   {
      $hash = md5($salt . $password, true);
      do
      {
         $hash = md5($hash . $password, true);
      }
      while (--$count);
   }
   else
   {
      $hash = pack('H*', md5($salt . $password));
      do
      {
         $hash = pack('H*', md5($hash . $password));
      }
      while (--$count);
   }

   $output = substr($setting, 0, 12);
   $output .= _leonardo_hash_encode64($hash, 16, $itoa64);

   return $output;
}
?>