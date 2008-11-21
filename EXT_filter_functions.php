<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
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