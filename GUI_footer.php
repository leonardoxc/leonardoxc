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
// $Id: GUI_footer.php,v 1.5 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/CL_template.php';

$Ltemplate=new LTemplate(dirname(__FILE__).'/templates/'.$PREFS->themeName);

$Ltemplate->set_filenames(array(
	'body' => 'footer.html')
);

$Ltemplate->pparse('body');

?>