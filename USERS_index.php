<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: USERS_index.php,v 1.3 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

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