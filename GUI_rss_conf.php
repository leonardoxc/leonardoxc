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

 list($countriesCodes,$countriesNames)=getCountriesList();
 $rss_url_base="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/rss.php";
echo "<BR>";
 open_inner_table("Configure RSS Feed",700,"rss.gif"); echo "<tr><td>";
?>
<script language="javascript">

function updateRssURL() {
	cCode=MWJ_findObj("country_select").value;
	olcScore=MWJ_findObj("olc_score_select").value;
	itemNum=MWJ_findObj("item_num").value;

	a1="country="+cCode;
	a2="&olcScore="+olcScore;
	a3="&c="+itemNum;

	rss_url="<?=$rss_url_base?>?"+a1+a2+a3;
	rss_link="<a href='"+rss_url+"' target='_blank'>"+rss_url+"</a>";
	MWJ_changeContents('rss_url',rss_link);
}

</script>
<form name="rssConf" method="post" action="">
  <br>
  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
  <td colspan="2"><div align="center">By subscribing to this RSS feed you can be informed for all
      new flights<br>
      <br>
  </div></td>
  </tr>
<tr> 
      <td width="262"><div align="right"><strong><? echo _SELECT_COUNTRY ?></strong></div></td>
      <td width="295">
        <select name="country_select" id="country_select" onChange="updateRssURL()">
          <option></option>
          <? 
					for($k=0;$k<count($countriesCodes);$k++) {
						echo "<option value='".$countriesCodes[$k]."' >".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
        </select></td>
    </tr>
    <tr> 
      <td><div align="right"><strong><? echo _OLC_SCORE_SHOULD_BE ?> >=</strong></div></td>
      <td>      <input name="olc_score_select" type="text" id="olc_score_select" value="0" size="5"  onKeyUp="updateRssURL()"></td>
    </tr>
    <tr>
      <td><div align="right"><strong>#
              of items </strong></div></td>
      <td>
        <select name="item_num" id="item_num" onChange="updateRssURL()">
          <option></option>
          <option>10</option>
          <option>20</option>
          <option>30</option>
          <option>40</option>
          <option>50</option>
      </select></td>
    </tr>
    <tr>
      <td colspan=2><div align="center">
        <p>or leave them blank to get all new flights in the RSS feed </p>
        <p>
          <input type="button" name="SubmitButton" value="Update the RSS Feed URL" onClick="updateRssURL()">
            </p>
      </div></td>
    </tr>
    <tr> 
      <td colspan=2><div align="right">
        <p align="center"><br>
          <img src="<?=$moduleRelPath?>/img/rss.gif" width="31" height="15"> 
          (copy paste this url to your RSS reader) 
      </div>
	<div align="center" id='rss_url'><a href='<?= $rss_url_base ?>' target='_blank'><?= $rss_url_base ?></a></div></p></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"> 
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<? 
  close_inner_table();  

?>
