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
// $Id: GUI_rss_conf.php,v 1.10 2010/11/21 14:26:01 manolis Exp $                                                                 
//
//************************************************************************

 list($countriesCodes,$countriesNames)=getCountriesList();
 $rss_url_base="http://".$_SERVER['SERVER_NAME'].getRelMainDir()."rss.php";
 $rss_url_base_comments.= $rss_url_base."?op=comments";
 
 openMain("Configure RSS Feed",0,"icons1/rss.gif"); 
 
?>
<script language="javascript">

function updateRssURL() {
	var	a1="country="+$("#country_select").val();
	var	a2="&olcScore="+$("#olc_score_select").val();
	var	a3="&c=".concat($("#item_num_select").val());

	var base='<?=$rss_url_base?>?';
	var rss_url= base.concat(a1,a2,a3);
	var rss_url_comments= base.concat('op=comments',a3);
	var rss_link="<a href='"+rss_url+"' target='_blank'>"+rss_url+"</a>";
	var rss_link_comments="<a href='"+rss_url_comments+"' target='_blank'>"+rss_url_comments+"</a>";

   $("#rss_url").html(rss_link);
   $("#rss_url_comments").html(rss_link_comments);
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
        <select name="item_num_select" id="item_num_select" onChange="updateRssURL()">
          <option value="0"></option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
          <option value="50">50</option>
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
          <?=leoHtml::img("rss.gif",0,0,'','','icons1')?> <?=_RSS_feed_for_flights ?>
       (copy paste this url to your RSS reader) 
      </div>
	<div align="center" id='rss_url'><a href='<?= $rss_url_base ?>' target='_blank'><?= $rss_url_base ?></a></div></p></td>
    </tr>
    <tr> 
	 <tr> 
      <td colspan=2><div align="right">
        <p align="center"><br>
          <?=leoHtml::img("rss.gif",0,0,'','','icons1')?> <?=_RSS_feed_for_comments ?>
          (copy paste this url to your RSS reader) 
      </div>
	<div align="center" id='rss_url_comments'><a href='<?= $rss_url_base_comments ?>' target='_blank'><?= $rss_url_base_comments ?></a></div></p></td>
    </tr>
      <td colspan="2"><div align="center"> 
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<? 
  closeMain();  

?>
