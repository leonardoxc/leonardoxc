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
// $Id: EXT_filter_functions.php,v 1.5 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************
	@session_start();
	
	if ($_GET['filter_op']=='reset') {
	 	$_SESSION["filter_clause"]='';
		$_SESSION["fltr"]='';

?>
<script type="text/javascript">
<!--
	// location.reload(true);
	filterPos=location.href.indexOf("fltr") 
	
	if (filterPos > -1) {
		newUrl=location.href.substring(0,filterPos-1);
	} else {
		newUrl=location.href;
	}
	location.href=newUrl;
//   -->
</script>
<a href=''>If the page doesnt refresh PRESS HERE</a>
<?

	}	
	
?>