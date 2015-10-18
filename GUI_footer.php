<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_footer.php,v 1.6 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/CL_template.php';

$Ltemplate=new LTemplate(dirname(__FILE__).'/templates/'.$PREFS->themeName);

$Ltemplate->set_filenames(array(
		'overall_footer' => 'tpl/overall_footer.html')
);

global $banner_rechts;
$Ltemplate->assign_vars(array(
	//Silke 25.05.2007
	'BANNER_RECHTS_1' => $banner_rechts[0],
	'BANNER_RECHTS_2' => $banner_rechts[1],
	'BANNER_RECHTS_3' => $banner_rechts[2],
	'BANNER_RECHTS_4' => $banner_rechts[3],
	'BANNER_RECHTS_5' => $banner_rechts[4],
	)
);

$Ltemplate->pparse('overall_footer');

?>
