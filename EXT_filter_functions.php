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
// $Id: EXT_filter_functions.php,v 1.3 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************
	@session_start();
	
	if ($_GET['filter_op']=='reset') {
	 	$_SESSION["filter_clause"]='';
?>
<script type="text/javascript">
<!--
 location.reload(true);
//   -->
</script>
<a href=''>If the page doesnt refresh PRESS HERE</a>
<?

	}	
	
?>