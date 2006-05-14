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
?>

<br> 
<br> 
<table align="center" width="353"> 
<? if ($_GET['msg']) { ?>
  <tr> 
    <td width="345" bgcolor="#FFFFCC">
		<div align="center" class="styleRed"><? echo $_GET['msg'] ?></div>
  </td></tr>
<? } ?>
  <tr> 
    <td bgcolor="#E0E0D6"><font class=content> <div align="center"><strong><br>
      Please enter <br>
      your
    username and password</strong></div>    </td> 
  </tr>
  <tr>
    <td> <form method="post" action="?op=users&page=index&act=login"> <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
      <tr class=header>
        <td width="45%"> <div align="right"><b>Username:</b> </div></td>
        <td width="55%"><div align="right">
          <input type="text" name="uname">
        </div></td>
      </tr>
      <tr class=header>
        <td><div align="right"><b>Password:</b> </div></td>
        <td><div align="right">
          <input type="password" name="upass">
        </div></td>
      </tr>
      <tr>
        <td colspan="2">            <p align="right">
              <input name="submit" type="submit" value="Log In">
              <input name="loginForm" type="hidden" value="1">
          </td>
      </tr>
    </table>  
    </form></td>
  </tr> 
  <tr> 
    <td class=header>&nbsp;</td> 
  </tr> 
</table> 
