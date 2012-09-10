
/********************************************* 
custom button
**********************************************/
 function EarthButton(controlDiv, map) {

        // Set CSS styles for the DIV containing the control
        // Setting padding to 5 px will offset the control
        // from the edge of the map
        controlDiv.style.padding = '5px';
        controlDiv.style.paddingRight = '2px';
        
        // Set CSS for the control border
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = 'white';
        controlUI.style.borderStyle = 'solid';
        controlUI.style.borderWidth = '1px';
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Click for 3D view';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior
        var controlText = document.createElement('div');
        controlText.style.fontFamily = 'Arial,sans-serif';
        controlText.style.fontSize = '12px';
        controlText.style.paddingLeft = '7px';
        controlText.style.paddingRight = '7px';
        controlText.style.paddingTop = '2px';
        controlText.style.paddingBottom= '2px';
        controlText.innerHTML = '<b>3D Earth</b>';
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to
        // Chicago
        google.maps.event.addDomListener(controlUI, 'click', function() {
        	window.location.href="EXT_google_maps_track_3d.php?id="+flightID;
        });

      }
/********************************************* 
Utils
**********************************************/

	function toogleGmapsFullScreen () {
		window.parent.toogleGmapsFullScreen() ;
	}

	
	function sec2Time(secs){
	   secs=secs/60;
	   h=Math.floor(secs/60);
  	   if (h<10) h="0"+h;
	   m=Math.floor(secs % 60);
	   if (m<10) m="0"+m;
	   return h+":"+m;
	}

	function refreshMap() {	
	   // map.setMapType(G_NORMAL_MAP); 
	   // map.setMapType(G_HYBRID_MAP);
	}
	
	function toggleFollow(radioObj) {
		if(!radioObj) return "";	
		if(radioObj.checked) followGlider=1;
		else followGlider=0;
	}

	function toggleTask(radioObj) {
		if(!radioObj) return "";	
		if(radioObj.checked) { 
			showTask=1;
			for (var i=0; i<taskLayer.length; i++) {
				//map.addOverlay(taskLayer[i]);
				taskLayer[i].setMap(map);
			}
		} else {
			showTask=0;
			for (var i=0; i<taskLayer.length; i++) {
				taskLayer[i].setMap(null);
				// map.removeOverlay(taskLayer[i]);
			}
		}
		refreshMap();	
	}

	function getCheckedValue(radioObj) {
		if(!radioObj)
			return "";
		var radioLength = radioObj.length;
		for(var ii = 0; ii < radioLength; ii++) {
			if(radioObj[ii].checked) {
				return radioObj[ii].value;
			}
		}
		return "";
	}

	function SetTimer(evt) {

		if ( CurrTime[1] <0 )  { CurrTime[1] =0; }
		if ( CurrTime[1] >= CurrTime[2]-4 )  { CurrTime[1] =CurrTime[2]-5; }

		DisplayCrosshair(1);
		
		// round up to 20secs..
		// tm=Math.floor(CurrTime[1]/20)*20;
		tm=Math.floor(CurrTime[1]/EndTime * flight.points_num);
		
		$('#timeText1').html(flight.time[tm]);
	
		// get the lat lon
		lat=flight.lat[tm];
		lon=flight.lon[tm];
		var newpos= new google.maps.LatLng(lat, lon);
		posMarker.setPosition(newpos);
		
		if (followGlider) map.setCenter(newpos, null);
		
		var speedStr=flight.speed[tm];
		var altStr=flight.elev[tm];
		var altVStr=flight.elevV[tm];
		var varioStr=flight.vario[tm];
		
		if (metricSystem==2) {
			speedStr*=0.62;
		}
		speedStr=Math.round(speedStr*10)/10;
		speedStr=speedStr+speedUnits;
		
		//if (metricSystem==2) {
		//	altStr*=3.28;
		//}
		altStr=Math.round(altStr);
		altStr=altStr+altUnits;
		
		altVStr=Math.round(altVStr);
		altVStr=altVStr+altUnits;
		
		if (metricSystem==2) {
			varioStr*=196.8;
			varioStr=Math.round(varioStr);
		} else {
			varioStr=Math.round(varioStr*10)/10;
		}
		varioStr=varioStr+varioUnits;
		
		//	speed=document.getElementById("speed");
		//  speed.value=speedStr;
		$("#speed").html(speedStr);
		$("#alt").html(altStr);
		$("#vario").html(varioStr);
		if (userAccessPriv) $("#altV").html(altVStr);
		
	}

	
	function showInfoWindow(html,marker) {
		infowindow.setContent(html); 
	    infowindow.open(map,marker);     
	}

	function zoomToFlight() {	
		map.fitBounds(bounds);
	}

/********************************************* 
Task
**********************************************/

	var taskicons=[];
	taskicons["s"]   = "img/icon_start.png";    
	taskicons["1"]   = "img/icon_1.png";
	taskicons["2"]   = "img/icon_2.png";
	taskicons["3"]   = "img/icon_3.png";
	taskicons["4"]   = "img/icon_4.png";
	taskicons["5"]   = "img/icon_5.png";
	taskicons["e"]   = "img/icon_end.png";

	function createTaskMarker(point,name,ba) {      		
		var marker = new google.maps.Marker({
			position: point,       
			map: map,
			icon: taskicons[ba],
			title:name
		});
		return marker;
	}

    function displayTask(tp) {
		var tpPoints=[];
		if (tp.turnpoints.length>0) {
			for(j=0;j<tp.turnpoints.length;j++){					
				tpPoints[j]=new google.maps.LatLng(tp.turnpoints[j].lat,tp.turnpoints[j].lon);
			}
			
			var polyline = new google.maps.Polyline(
					//position: new google.maps.LatLng(9.099761549253056,76.5246167373657),
					//title: "Hello Testing",
					//clickable: true,
					//map: map
				{
					path: tpPoints , 
					strokeColor: "#FFFFFF", 
					strokeWeight:3,
					visible:true,
					map: map
				}
			); 
			// map.addOverlay(polyline);
			taskLayer.push(polyline); 
			
			for(j=0;j<tp.turnpoints.length;j++){							 
				var marker = createTaskMarker(tpPoints[j],tp.turnpoints[j].name,tp.turnpoints[j].id ) ;
				taskLayer.push(marker); 
				// map.addOverlay(marker);
			}
		}
	}
	
    
    
/********************************************* 
	Photos
**********************************************/

	var photoMarkers=[];

	function showPhoto(img,img2num,thw,thh){		
		infowindow.setContent('<img src="'+img+'" border="0" width="'+thw+'" height="'+thh+'">');
	}
	
	
	function createPhotoMarker(photoPoint,num,imgIcon,imgBig,width,height){
			var imgStr="<img id='photo$num' src='"+imgIcon+"' class=\"photos\" border=\"0\">";
			var html="<a class='shadowBox imgBox' href='javascript:showPhoto(\""+imgBig+"\","+num+","+width+","+height+");' >"+imgStr+"</a>";			
			var marker = new google.maps.Marker({
				position: photoPoint,       
				map: map,
				icon: 'img/icon_photo_pinned.png'
			});
			google.maps.event.addListener(marker, 'click', function() {				
		        infowindow.setContent(html); 
		        infowindow.open(map,marker);
			});
			return marker;
	}
	
	function drawPhotos(photos){
		  for (var p = 0; p < photos.length; p++) {
			  drawPhoto( photos[p].lat,photos[p].lon,
					  	 photos[p].num,photos[p].icon,photos[p].photo,
					  	 photos[p].width,photos[p].height);
		  }	  
	} 	
	
	function drawPhoto(lat,lon,num,imgIcon,imgBig,width,height){ 	
			var photoPoint= new google.maps.LatLng(lat, lon) ;			
			var photoMarker = createPhotoMarker(photoPoint,num,imgIcon,imgBig,width,height);
			photoMarkers[num] = photoMarker ;
	}

/********************************************* 
	Flight Finder
**********************************************/
	
function addFlightsToList(results) {
	var tnum=0;
	for(i=0;i<results.flights.length;i++) {	
		// is it the current flight ?
		if (results.flights[i].flightID == flightList[0]  ) continue;
		
		var f=results.flights[i];
		// var takeoffPoint= new google.maps.LatLng(results.flights[i].firstLat, results.flights[i].firstLon) ;
		
		$('#trackFinderTplMulti').clone().attr('id', 'trackFinderInfo'+(tnum)  ).appendTo("#trackCompareFinderList");
		// name of track
		//'"DURATION 		'"START_TIME 		'"END_TIME 		'"MAX_ALT 	
		//'"MAX_VARIO 		'"linearDistance 	'"olcDistance 		'"olcScore 		'"scoreSpeed 
		//'"gliderBrandImg 		'"gliderCat
		
		$("#trackFinderInfo"+tnum+" .date").html(f.date+' '+f.START_TIME);
		$("#trackFinderInfo"+tnum+" .score").html(f.olcScore+'<br>'+f.DURATION+' '+f.olcScoreType);
		$("#trackFinderInfo"+tnum+" .info").html(f.gliderCat+'<br>'+f.categoryImg);
		$("#trackFinderInfo"+tnum+" .glider").html(f.gliderBrandImg);
		$("#trackFinderInfo"+tnum+" .name").html(f.pilotName);
		
		 // var text='<label class="label_check" for="checkbox-01"><input name="sample-checkbox-01" id="checkbox-01" value="1" type="checkbox" checked />';
		 
		$("#trackFinderInfo"+tnum+" .tick").html("<input type='checkbox' class='flightTick' value='"+f.flightID+"' id='trackFinderInfoSelect"+tnum+"'></input>");
		
		// color
		//$("#trackFinderInfo"+tnum+" .color").css('background-color',trackColor);
		tnum++;
		if (tnum==5) break;
	}

	
	$("#trackCompareFinderList").slideDown(800);
	$('#trackCompareFinderHeader').hide();
	$('#trackCompareFinderHeaderExpand').fadeIn(300);
	
	searchDone=1;
}

var searchDone=0;

$(document).ready(function(){

	$(".flightTick").live("click", function(){
		var url=$(location).attr('href');

		$(".flightTick").each(function() {
			if ( $(this).is(':checked') ) {
				 url+=','+$(this).val();
			}		    
		});
		compareUrl=url;
		// $("#msg").html("###"+url);
	});

	$("#trackCompareFinderHeaderAct").click(function(f) {	
		window.location.href =compareUrl;
	});

	$("#trackCompareFinderHeaderClose").click(function(f) {
		$('#trackCompareFinderHeaderExpand').hide();
		$("#trackCompareFinderList").slideToggle(500);				
		$('#trackCompareFinderHeader').fadeIn(500);
		
	});
	
	
	$("#trackCompareFinderHeader").click(function(f) {
		if (searchDone) {
			$("#trackCompareFinderList").slideDown(500);
			$('#trackCompareFinderHeader').hide();
			$('#trackCompareFinderHeaderExpand').fadeIn(500);
		} else {
			for( var i in flights) {
				$.getJSON('EXT_flight.php?op=list_flights_json&lat='+flights[i].data.firstLat+'&lon='+flights[i].data.firstLon+'&distance='+radiusKm+queryString,null,addFlightsToList);
				break;
			}
		}
		
	});
	

	 
});