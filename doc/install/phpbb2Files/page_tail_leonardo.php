<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_tail_leonardo.php,v 1.4 2008/05/05 14:05:22 manolis Exp $
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
	die('Hacking attempt');
}

$Ltemplate->set_filenames(array('overall_footer' => 'tpl/overall_footer.html'));
$Ltemplate->assign_vars(array(
	'SIDE_BLOCKS_HTML' => $side_blocks_html,
	'CUSTOM_FOOTER_CODE'=> 	$CONF['footer']['custom_code'],
) );
$Ltemplate->pparse('overall_footer');

// Close our DB connection.
$db->sql_close();

//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress && 0)
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

exit;

?>