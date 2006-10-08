<?php

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

$tmpDir			=dirname(__FILE__);
$tmpParts		=split('/',str_replace("\\",'/',$tmpDir));
$module_name	=$tmpParts[count($tmpParts)-1];
$moduleAbsPath	=dirname(__FILE__);
$moduleRelPath	='.';

?>