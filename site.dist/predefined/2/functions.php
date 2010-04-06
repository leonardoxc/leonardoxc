<?php



function leonardo_check_password($password,$hash) {
	// this is for phpb2 but with phpbb3 hashing
	// return leonardo_check_hash($password, $hash);
	
	// this is the original phpb2 hash
	return (md5($password)==$hash);
}

/**
*
* @version Version 0.1 / $Id: functions.php,v 1.2 2010/04/06 21:21:23 manolis Exp $
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

   return md5($password);
  
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