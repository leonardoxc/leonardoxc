<?
 	//require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	//require_once "EXT_config.php";

	//require_once "CL_flightData.php";
	//require_once "FN_functions.php";	
	//require_once "FN_UTM.php";
	//require_once "FN_waypoint.php";	
	//require_once "FN_output.php";
	//require_once "FN_pilot.php";
	//require_once "CL_server.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Carte du Vol</title>

    <style type="text/css">
    v\:* { behavior:url(#default#VML);}
    html, body {width: 100%; height: 100%}
    body {margin: 0px;}
    #map {width: 100%; height: 80%}

    #load2 {width: 100%; height: 100%; top:0px; left:0px; position:absolute; z-index:3000;
           background: #4682b4 url("img/loading.gif") no-repeat center center;
           text-align: center; font:15px Verdana, Arial, sans-serif; color:black; font-weight:bold;}

    </style>

    <link rel='stylesheet' type='text/css' href='lib/visugps/css/visugps.css' />
    <link rel='stylesheet' type='text/css' href='js/chart/canvaschart.css' />
    <script src='js/mootools/mootools.v1.11.js'></script>
    <script src='lib/visugps/php/vg_script.php'></script>
    <script src='http://www.google.com/jsapi?key=<?=$CONF_google_maps_api_key?>'></script>
    <script>
        google.load('maps', '2');
    </script>


    <script>

        var kMap = null;

        window.addEvent('unload', cleanMap);

        window.addEvent('domready', function() {
	    kMap = new VisuGps(		);
/*
{elevTileUrl: ['pgforum.thenet.gr/modules/leonardo/_visugps/visugps/visugps/php'] }
            kMap = new VisuGps({elevTileUrl: ['ts0.victorb.fr',
                                              'ts1.victorb.fr',
                                              'ts2.victorb.fr',
                                              'ts3.victorb.fr'],
                                weatherTileUrl: ['ts0.victorb.fr',
                                                 'ts1.victorb.fr',
                                                 'ts2.victorb.fr',
                                                 'ts3.victorb.fr']});
*/
           var trackName = decodeURIComponent(location.search) || 'noparam';

            if (m = /^\?track=(.*)$/i.exec(trackName)) {
                kMap.downloadTrack(m[1]);
            } else {
                kMap.downloadTrack(location.href.replace(/[\w\.]*$/, 'lib/visugps/test.igc'));
            }
        });

        function cleanMap() {
            kMap.clean();
            kMap = null;
        }

    </script>

  </head>
  <body>
    <div id='map'></div>
    <div id='vgps-chartcont'></div>
    <div id='load'></div>
  </body>
</html>
