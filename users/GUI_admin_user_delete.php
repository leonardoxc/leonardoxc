<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

	if (! L_auth::isAdmin($userID)  ) {
		return;
	}
	
$query_us = "DELETE from cscp_mojt_users WHERE username = '$user'";

$p_body = "<br><br><table align=\"center\" width=\"50%\"><tr><td class=header><font class=\"bigfont\"><center>MoJT Login System [ADMIN]</center></font>
</td></tr><tr><td class=header><center><font class=content><font color=\"005177\">ADCPanel :: [ <a href=\"?op=users&page=admin&act=users\">Users</a> ] - [ <a href=\"?op=users&page=admin&act=settings\">Settings</a> ] - [ <a href=\"?op=users&page=admin&act=logout\">Logout</a> ] :: </font></center></td></tr><tr><td><table width=\"100%\" align=\"center\" bgcolor=\"cccccc\" cellpadding=\"2\" cellspacing=\"1\" class=\"header_logo\"><tr><td bgcolor=\"dcdcdc\"><br><br><br>";

$p_question_body= "<center>Are you sure you want to delete user: <b>$user</b>?<br><form method=\"get\"><input type=\"hidden\" name=\"cmd\" value=\"delete_it\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"submit\" value=\"YES\" name=\"value\"> &nbsp; <input type=\"submit\" value=\"NO\" name=\"value\"></form></center>";

$p_succes_body = "<br><br><center>User <b>$user</b> was deleted from the database!</center>";

$p_failed_body = "<br><br><center>User <b>$user</b> wasn't deleted from the database!<br><br><a href=\"?op=users&page=admin&act=users\"><< Back</a></center>";

$p_fus_body = "<br><br></td></tr></table></td></tr><tr><td class=header>&nbsp;</td></tr></table>";

$p_footer = "<br><font class=content><center>Powered by CsCPortal :: <a href=\"http://cscp.cs-centar.net\" target=_blank>http://cscp.cs-centar.net</a></center></body></html>";


		if ($_GET['cmd'] == "delete_it" && $_GET['value'] == "YES") {

		echo $p_header;

		$delete_it = mysql_query($query_us);

		echo $p_body;
		echo $p_succes_body;
		echo $p_fus_body;
		echo $p_footer;

		exit;

		}

		if ($_GET['cmd'] == "delete_it" && $_GET['value'] == "NO") {

		echo $p_header;
		echo $p_body;
		echo $p_failed_body;
		echo $p_fus_body;
		echo $p_footer;

		exit;

		}


echo $p_header;
echo $p_body;
echo $p_question_body;
echo $p_fus_body;
echo $p_footer;



?> 