<style type="text/css">
<!--
table{
	text-align:right;
	vertical-align: top;
}
td {
	vertical-align: top;
}
.takeoff {
	color: #884400;
	text-align: right;
}
-->
</style>
<center>
<table class="main_text" border="0" cellpadding="0" cellspacing="0" width="750">
  <tbody>
    <tr>
      <td  width="17">{IMG_CAT}</td>
      <td width="721" valign="top" height="20">
	  <b><table class="main_text" width="100%"><tbody><tr>
	    <td> <div align="left"><b>{L_LEGEND}</b></div></td>
	  <td valign="top" width="400" align="right"><strong>{L_LEGEND_RIGHT}</strong></td>
	  </tr></tbody></table></b></td>
	  <td width="12"></td>
    </tr>
  </tbody>
</table>
<table width="750" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="11"></td>
      <td class="main_text" bgcolor="#edeef1" width="724">
        <table class="main_text" width="100%" align="right">
          <tbody>
            <tr>
              <td width="25" bgcolor="#6a8aca"><div align="left">#</div></td>
              <td width="80" bgcolor="#f2bc66">
                <div align="left">{IMG_S1}</div></td>
              <td width="300" bgcolor="#c5d0e1">
                <div align="left">{IMG_S2}</a></div></td>
              <td bgcolor="#6a8aca">
                <div align="left">{IMG_S3}</a></div></td>
              <td width="40" bgcolor="#f8e880">
                <div align="left">{IMG_S4}</a></div></td>
              <td width="50" bgcolor="#74d476">
                <div align="left">{IMG_S5}</a></div></td>
              <td width="45" bgcolor="#74d476">
                <div align="left">{IMG_S6}</a></div></td>
              <td width="40" bgcolor="#74d476">
                <div align="left">{IMG_S7}</a></div></td>
              <td width="18" bgcolor="#fdad2f"> </td>
              <td width="72" bgcolor="#fdad2f"><div align="left">{#_SHOW}</div></td>
            </tr>

            <!-- BEGIN flightrow -->
            <tr bgcolor="{flightrow.BGCOLOR}" align="right">
              <td><div align="left">{flightrow.NUM}</div></td>
              <td>{flightrow.IMG_NEW}{flightrow.DATE}</td>
              <td width="300" colspan="2">
					<div align="left"><a href="{flightrow.U_PILOT_PROFILE_VIEW}">{IMG_LOOK}</a><a href="{flightrow.U_PILOT_PROFILE_STATS}">{IMG_STATS}</a>
						<a href="{flightrow.U_PILOT_FLIGHTS}">{flightrow.PILOT_NAME}</a></div>
                  	<div class="takeoff"><a href="{flightrow.U_WPT_FLIGHTS}">{flightrow.TAKEOFF}</a>
						<a href="{flightrow.U_WPT_SHOW}">{IMG_LOOK}</a><a href="{flightrow.U_WPT_KML}">{IMG_GEARTH}</a></div>
			  </td>
              <td>{flightrow.DURATION}</td>
              <td>{flightrow.OPEN_DISTANCE}</td>
              <td>{flightrow.OLC_DISTANCE}</td>
              <td>{flightrow.OLC_SCORE}</td>
              <td>{flightrow.IMG_CAT}</td>
              <td align="left"><a href="{flightrow.U_FLIGHT_SHOW}">{IMG_LOOK}</a><a href="{flightrow.U_FLIGHT_KML}">{IMG_GEARTH}</a>{flightrow.IMG_PHOTO}{flightrow.U_OP_1}{flightrow.U_OP_2}</td>
            </tr>
            <!-- END flightrow -->

          </tbody>
      </table></td>
      <td width="15"></td>
    </tr>
  </tbody>
</table>
<p><br>
</p>
</center>