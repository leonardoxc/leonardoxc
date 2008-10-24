<?php

/************************************************************************/
/* Leonardo: Gliding XC Server											*/
/* ============================================							*/
/*																		*/
/* Copyright (c) 2004-5 by Andreadakis Manolis							*/
/* http://sourceforge.net/projects/leonardoserver						*/
/*																		*/
/* This program is free software. You can redistribute it and/or modify	*/
/* it under the terms of the GNU General Public License as published by	*/
/* the Free Software Foundation; either version 2 of the License.		*/
/************************************************************************/

require_once dirname(__FILE__).'/CL_template.php';

$Ltemplate=new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

$Ltemplate->set_filenames(array(
	'body' => 'footer.html')
);

$Ltemplate->pparse('body');

?>