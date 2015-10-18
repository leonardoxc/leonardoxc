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
// $Id: GUI_program_info.php,v 1.19 2010/03/26 13:16:50 manolis Exp $                                                                 
//
//************************************************************************

 
  openMain("Leonardo XC Server",0,"icon_help.png");
?>
  
<div align="center"> 
  <p> 
  <table class=main_text width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr> 
      <td width="164">
<div align="right"><? echo _DEVELOPMENT ?>: </div></td>
      <td width="259"><? echo _ANDREADAKIS_MANOLIS ?> </td>
      <td width="257" rowspan="10" valign="top"><div align="left">
      
        <p align="left"><strong>Leonardo Installations </strong></p>
        <ul>
        
          <li><a href="http://www.paraglidingforum.com/leonardo" target="_blank">International XC database</a></li>
          <li><a href="http://xc.dhv.de/xc/modules.php?name=leonardo" target="_blank">DHV XC Contest</a></li>
          <li><a href="http://www.xcbrasil.org" target="_blank">Brazilian Leonardo</a></li>
          <li><a href="http://www.portaldovoo.com.br/leonardo" target="_blank">Brazilian ABVL</a></li>
          <li><a href="http://cnd.favl.info/leonardo/" target="_blank">FAVL - Argentine XC</a> </li>
          <li><a href="http://www.xcportugal.com/modules.php?name=leonardo" target="_blank">Liga XC Portugal</a></li>
          <li><a href="http://www.sky.gr/leonardo" target="_blank">Greek XC League</a></li>
          <li><a href="http://hang-gliding.eu" target="_blank">Greek HG League</a></li>   
          <li><a href="http://www.paraplanoff.net/leonardo">Russian XC Leonardo</a></li>       
          <li><a href="http://www.xc-lux.org" target="_blank">Luxemburg XC League</a></li>  
          <li><a href="http://www.fbvl.be/leo/index.php?name=leo&lng=french&op=list_flights" target="_blank">Belgian XC Leonardo</a></li>  
          <li><a href="http://forum.skynomad.net/leonardo" target="_blank">Bulgarian - Skynomad Leonardo</a></li>
          <li><a href="http://www.xcolombia.co" target="_blank">Colombian  XC Leonardo</a></li>
          <li><a href="http://www.xcaustralia.org/">Australian Leonardo</a></li>          
          <li><a href="http://www.ypforum.com/leonardo" target="_blank">Turkish   Leonardo</a></li>
          <li><a href="http://www.pg-leonardo.cz/leonardo" target="_blank">Czech Leonardo</a></li>
          <li><a href="http://www.holywind.net/index.php?option=leonardo" target="_blank">Isreali Leonardo</a></li>          
          <li><a href="http://forums.dowsett.ca/modules.php?name=leonardo" target="_blank">HPAC/ACVL Canadian League</a></li>
          <li><a href="http://www.argentinaxc.com.ar" target="_blank">Argentine Leonardo</a></li>
          <li><a href="http://www.vololibero.net/modules.php?name=leonardo&amp;op=list_flights" target="_blank">Italian Leonardo</a></li>
          <li><a href="http://www.foroparapente.com/leonardo" target="_blank">Chilian Leonardo</a></li>
          <li><a href="http://xc.aerospara.com/modules.php?name=leonardo" target="_blank">Ukrainian Leonardo</a></li>          
          <li><a href="http://xc.fly.kg">Kyrgyzstan XC Leonardo</a></li>
          
          <li><a href="http://www.nhpc.org.uk/nhpc/modules.php?name=leonardo" target="_blank">NHPC Leonardo</a></li>          
          <li><a href="http://xc.rmhpa.org" target="_blank">Rocky Mountain Hang gliding & Paragliding Association</a></li>
          <li><a href="http://www.coloradoflyweek.com" target="_blank">Colorado Flying Week Server</a></li>
          <li><a href="http://www.xcweb.cz">El Speedo XC Leonardo(Czech)</a></li>
        </ul>
      </div></td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _VERSION ?>: </div></td>
      <td><? echo "$CONF_version (released $CONF_releaseDate)"; ?> </td>
    </tr>
    <tr> 
      <td><div align="right">Licence: </div></td>
      <td>GPL</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _PROJECT_URL ?>: </div></td>
      <td><a href="http://www.leonardoxc.net" target="_blank">http://www.leonardoxc.net</a></td>
    </tr>
    <tr>
      <td><div align="right">Scoring Optimization</div></td>
      <td><a href="http://freenet-homepage.de/streckenflug/optigc.html" target="_blank">Thomas Kuhlmann</a></td>
    </tr>
    <tr>
      <td><div align="right">GE extended Info Module </div></td>
      <td><a href="http://www.parawing.net" target="_blank">Emmanuel Chabani aka Man's</a></td>
    </tr>
    <tr>
      <td><div align="right">igc2kmz</div></td>
      <td><a href="http://wiki.github.com/twpayne/igc2kmz/" target="_blank">Tom Payne's igc2kmz</a></td>
    </tr>
    <tr>
      <td><div align="right">Airspace Checking </div></td>
      <td>Some code adapted from <a href="http://xcsoar.sourceforge.net/" target="_blank">xcsoar</a> project </td>
    </tr>
    <tr>
      <td><div align="right">Skyways Layer </div></td>
      <td>Big thanks to Michael Vonkaenel  and his project 
      <a  target="_blank" href='http://thermal.kk7.ch'>Paragliding Thermal Maps</a>
      </td>
    </tr>
    <tr>
      <td><div align="right">Js Libraries</div></td>
      <td>
      <ul>
      	 <li><a href="http://www.jquery.com" target="_blank">jQuery (jQuery the +8m/ec equivelant of the web :-)</a>
      	 <li><a href="http://www.twinhelix.com" target="_blank">Tipster</a>
      	 <li><a href="http://www.aditus.nu/jpgraph/index.php" target="_blank">Jpgraph</a>
      	 <li><a href="http://www.flotcharts.org/" target="_blank">Flot graphs</a>
       </ul>
      </td>
    </tr>

    <tr>
      <td><div align="right">Design:</div></td>
      <td>Alexander Caravitis,<br />
      <? echo _ANDREADAKIS_MANOLIS ?></td>
    </tr>
    <tr> 
      <td colspan="3"><hr>        <p>Many <em>many</em> thanks to: </p>                
        <ul>
          <li>        <strong>Hannes Krueger</strong>, for his GPLIGC and openGLIGCexplorer
            that gave me the initial idea            <a href="http://pc12-c714.uibk.ac.at/GPLIGC/GPLIGC.php" target="_blank">http://pc12-c714.uibk.ac.at/GPLIGC/GPLIGC.php</a></li>
          <li><strong>Kostas 'GUS' Proitsakis</strong> - Greece, for Beta testing
            and Map creation</li>
          <li><strong>Alexander Caravitis</strong> - Greece, for Beta testing and
            Map creation</li>
          <li><strong>Stein-Tore Erdal</strong> - Norway, for his excellent fightbook,
            another inspiration            <a href="http://www.flightlog.org" target="_blank">http://www.flightlog.org</a></li>
          <li><strong>Emmanuel Chabani aka Man's </strong>for his Google Earth
            extended info Module.</li>
          <li><strong><a href="http://www.dhv.de" target="_blank">DHV</a></strong> for  sponsoring the development of <br />
            a) Custom rankings / National custom rankings / Club rankings <br />
            b) Airspace infrigments checking <br />
            c) Comments for flights<br>
            d) Compare flights and rewrite to Gmaps api v3<br>
          </li>
          <li><strong>Peter Wild (DHV) , Martin Jursa (DHV)</strong> for believing in the power of open source and their valuable contributions and assistance.</li>
          <li><strong>Tom Payne</strong> for his <a href="http://wiki.github.com/twpayne/igc2kmz/" target="_blank">igc2kmz</a> a great visualisation tool for google earth</li>
          <li><strong>Durval Henke</strong> <strong>(<a href="http://www.xcbrasil.org/" target="_blank">xcbrasil.org</a>)</strong> for many bug fixes and the developing the code for standalone operation</li>
        </ul>
        <p>Also many thanks to the following for providing translations, valuable 
          feedback and beta testing:</p>
        <ul>
          <li><strong>Lucio Mazzi &amp; Benedetto Lo Tufo</strong> - Italy <br>
            <a href="http://www.vololibero.net/modules.php?name=leonardo&op=list_flights" target="_blank">http://www.vololibero.net/modules.php?name=leonardo&amp;op=list_flights</a></li>
          <li><strong>Mark Graham</strong> - UK<br>
            <a href="http://www.pgcomps.org.uk/?page=/xcleague/xc/view.php" target="_blank">http://www.pgcomps.org.uk/?page=/xcleague/xc/view.php</a></li>
          <li><strong>Ali
            Yucer</strong> - Turkey<br>
            <a href="http://www.ypforum.com/modules.php?name=leonardo&op=list_flights" target="_blank">http://www.ypforum.com/modules.php?name=leonardo&amp;op=list_flights</a></li>
          <li><strong>Ale Spitznagel</strong> - Argentine<br>
            <a href="http://www.argentinaxc.com.ar" target="_blank">http://www.argentinaxc.com.ar</a></li>
        </ul>
        <p><em>I need to <strong>specially</strong> thank the following people 
          for their spontaneous answer to my call for translators.</em></p>
        <ul>
          <li><strong><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=202">Paulo Reis</a></strong> for the <strong>Portuguese</strong> translation</li>
          <li> <strong><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=1142">Ardy Brouwer</a></strong> for the <strong>Dutch</strong> translation <a href="http://www.ardybrouwer.com" target="_blank">http://www.ardybrouwer.com</a></li>
          <li><strong><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=3178">Etienne Prade</a></strong> for the <strong>French</strong> translation <a href="http://www.prade.net%20" target="_blank">http://www.prade.net          </a></li>
          <li><strong>Torsten</strong> for the <strong>German</strong> translation <a href="http://www.paragliding365.com" target="_blank">http://www.paragliding365.com</a></li>
          <li><strong><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=1067">Jonas Svedberg</a></strong> for the <strong>Swedish</strong> translation</li>
          <li> <strong><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=2336">Andrei Orehov</a></strong> for the <strong>Russian</strong> translation</li>
          <li><a href="http://www.paraglidingforum.com/modules.php?name=leonardo&op=pilot_profile&pilotIDview=2747"><strong>Olympio
            Faissol</strong></a> for the <strong>Brazilian</strong> translation <a href="http://ofaissol.blogspot.com" target="_blank">http://ofaissol.blogspot.com</a></li>
          <li>  <strong>Zeljko Vranic</strong> for the <strong>Croatian</strong> translation</li>
          <li>          <strong>Karolina Kociecka</strong> for the <strong>Polish</strong> translation</li>
          <li><a href="http://www.felhout.hu/erd/egyeb/introduction.html" target="_blank"><strong>Zsolt Rohberg</strong></a> for the <strong>Hungarian</strong> translation</li>
          <li><a href="http://www.paraglidingforum.com/profile.php?mode=viewprofile&u=5393" target="_blank"><strong>Rado
            Voglar</strong></a> for the <strong>Slovenian</strong> translation </li>
          <li> <a href="http://www.pgnord.dk/" target="_blank"><strong>Morten Fabricius Olesen</strong></a> for the <strong>Danish</strong> translation </li>
          <li> <a href="http://www.paranimbus.com" target="_blank"><strong>Ciprian
            Chis</strong></a> for the <strong>Romanian</strong> translation</li>
          <li> <a href="http://www.volfik.com/" target="_blank"><strong>Peter Volf</strong></a> for the <strong>Czech</strong> translation </li>
          <li> <strong>Xiaozhong</strong> for the <strong>Chinese</strong> translation</li>
          <li><strong>Dmitry Korogodin</strong> for the <strong>Hebrew</strong> translation</li>
          <li> <strong>Juha Niinimaki</strong>  for the <strong>Finnish</strong> translation<br>
          </li>
        </ul>        
        <hr></td>
    </tr>
  </table>
  <p> 
  <p> 
  <p>
</div>
<?
	closeMain();
?>