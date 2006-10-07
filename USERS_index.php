<?php

/************************************************************************/
/* Leonardo: Gliding XC Server											*/
/* ============================================							*/
/*																		*/
/* Copyright (c) 2004-5 by Andreadakis Manolis							*/
/* http://leonardo.thenet.gr											*/
/* http://sourceforge.net/projects/leonardoserver						*/
/*																		*/
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.		*/
/************************************************************************/

require_once dirname(__FILE__).'/users/users.css';

$userAction=$_GET['act'];

switch ($opPage=$_GET['page'])
{
case 'admin':
	require_once dirname(__FILE__).'/users/admin.php';
	break;

case 'index':
	require_once dirname(__FILE__).'/users/index.php';
	break;

case 'sendmail':
	require_once dirname(__FILE__).'/users/sendmail.php';
	break;
}

?>