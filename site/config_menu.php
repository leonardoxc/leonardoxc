<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 											*/
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
 
// menu custom entries
/*
the menu that can have added entries are
'home'  (the first menu item with the home icon )
'main_menu' (the main menu)

For each menu there are many slots were one or more entries can be added
FOR home->
'top' top most 
'before_personal' before the logged in user menu 
'before_settings'
'bottom' after all items


*/

$CONF_MENU['main_menu']['bottom']=array(
		array('type'=>'spacer',
				///'extra_class'=>'long'
		),
		array('name'=>'Instructions',
			'linkType'=>'leonardo', // leonardo or external
			'link'=>array('op'=>'instructions'),
			'target'=>'_blank',
		),
		array('name'=>_PROJECT_HELP,
			'linkType'=>'external', // leonardo or external
			'link'=>'http://www.dhv.de/typo/Kurzanleitung_zur_Re.4339.0.html',
			'target'=>'_blank',
		),
		array('name'=>_PROJECT_NEWS,
			'linkType'=>'external', // leonardo or external
			'link'=>'http://www.dhv.de/typo/Technische_News_zum.4348.0.html',
			'target'=>'_blank',
		),		
		array('name'=>_PROJECT_RULES,
			'linkType'=>'external', // leonardo or external
			'link'=>'http://www.dhv.de/typo/fileadmin/user_upload/monatsordner/2007-02/OLC_Regel/xcausschreibung0307.pdf',
			'target'=>'_blank',
		)


);

?>