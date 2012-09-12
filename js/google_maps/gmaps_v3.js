
/********************************************* 
Utils
**********************************************/

 var fullScreen=0;
 function toogleFullScreen() {
 	if (fullScreen==0) {
 		$("html, body",top.document).animate({ scrollTop: 0 }, 1);
 	
 		$('html, body', top.document).css(
 			 {
 				 "position": "relative",
 				  "width": "100%",
 				  "height": "100%",
 				  "z-index": "10",
 				  "margin": "0",
 				  "padding": "0",			
 				  "overflow":"hidden"
 				});	 

 	
 	 	
 	 $('#gmaps_iframe', top.document).css(
 		{
 		 "display": "block",
 		  "position": "absolute",
 		  "top": "0px",
 		  "left": "0",
 		  "width": "100%",
 		  "height": "100%",
 		  "z-index": "9999",
 		  "margin": "0",
 		  "padding": "0"
 		});
 	  fullScreen=1;
 	  
 	}else {
 		$('html, body', top.document).css(
 				 {
 					 "position": "relative",
 					  "width": "auto",
 					  "height": "auto%",
 					  "z-index": "10",
 					  "margin": "0",
 					  "padding": "0",			
 					  "overflow":"visible"
 					});	 

 		
 		 	
 		 $('#gmaps_iframe', top.document).css(
 			{
 			 "display": "block",
 			  "position": "relative",
 			  "top": "0px",
 			  "left": "0",
 			  "width": "100%",
 			  "height": "100%",
 			  "z-index": "9999",
 			  "margin": "0",
 			  "padding": "0"
 			});
 		 fullScreen=0;
 	}

 }
 
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
	
function addFlightsToList(results,limit) {
	var tnum=0;
	$('#trackCompareFinderHeader').hide();
		
	$("#trackCompareFinderList").slideDown(700);
	$('#trackCompareFinderHeaderExpand').fadeIn(800,function(){
		$('#trackCompareFinderHeaderMore').fadeIn(100);
	});
	
	
	//$("#trackCompareFinderList").append("<div>asdasdasdasad</div>");
	//return;
		
	for(i=0;i<results.flights.length;i++) {	
		
		// is it the current flight or in the current list ?
		var f= $.inArray( parseInt(results.flights[i].flightID) , flightList);
		if (f  >=0  )  continue; 
		
		
		
		var f=results.flights[i];
		
		foundTracksList[f.flightID]=f;
		// var takeoffPoint= new google.maps.LatLng(results.flights[i].firstLat, results.flights[i].firstLon) ;
		
		
		$('#trackFinderTplMulti').clone().attr('id', 'trackFinderInfo'+(tnum)  ).addClass('foundTrackItem').appendTo("#trackCompareFinderList");
		// name of track
		//'"DURATION 		'"START_TIME 		'"END_TIME 		'"MAX_ALT 	
		//'"MAX_VARIO 		'"linearDistance 	'"olcDistance 		'"olcScore 		'"scoreSpeed 
		//'"gliderBrandImg 		'"gliderCat
		
		
		
		$("#trackFinderInfo"+tnum+" .date").html(f.date+' '+f.START_TIME);
		$("#trackFinderInfo"+tnum+" .score").html(f.olcScore+'<br>'+f.DURATION+' '+f.olcScoreType);
		$("#trackFinderInfo"+tnum+" .info").html(f.gliderCat+' '+f.categoryImg);
		$("#trackFinderInfo"+tnum+" .glider").html(f.gliderBrandImg);
		$("#trackFinderInfo"+tnum+" .name").html(f.pilotName);
		
		 // var text='<label class="label_check" for="checkbox-01"><input name="sample-checkbox-01" id="checkbox-01" value="1" type="checkbox" checked />';
		 
		$("#trackFinderInfo"+tnum+" .tick").html("<input type='checkbox' class='flightTick' value='"+f.flightID+"' id='trackFinderInfoSelect"+tnum+"'></input>");
		
		// color
		//$("#trackFinderInfo"+tnum+" .color").css('background-color',trackColor);
		tnum++;
		if (tnum==limit) break;
	}

	resultsloaded=tnum;
	
	searchDone=1;
}
var foundTracksList=[];

var searchDone=0;
var resultsloaded=0;


var compareTrackLine=null;
function showLine(lat1,lon1,lat2,lon2) {
	if (compareTrackLine==null) {
		
		compareTrackLine=new  google.maps.Polyline(
		{
			strokeColor:"#3F48CC",
			strokeOpacity:1,
			strokeWeight:4
		});
	} 	
	compareTrackLine.setPath([new google.maps.LatLng(lat1,lon1),new google.maps.LatLng(lat2,lon2) ]);
	compareTrackLine.setMap(map);
}

function hideLine() {	
	compareTrackLine.setMap(null);
}

$(document).ready(function(){

	
	$(".flightTick").live('mouseenter',function () {	  
		var flightID=$(this).val();
		
		var lat1=foundTracksList[flightID].firstLat;
		var lon1=foundTracksList[flightID].firstLon;
		var lat2=foundTracksList[flightID].lastLat;
		var lon2=foundTracksList[flightID].lastLon;
		showLine(lat1,lon1,lat2,lon2);		
		// $("#msg").html("enter:"+flightID);					
	});
	
	$(".flightTick").live('mouseleave',function () {	  
		var flightID=$(this).val();		
		hideLine();		
	});
	

	
	$(".flightTick").live("click", function(){
		// var url=$(location).attr('href');
		var url=compareUrlBase;
		var i=0;
		$(".flightTick").each(function() {
			if ( $(this).is(':checked') ) {
				 url+=','+$(this).val();
				 i++;
			}		    
		});
		if (i>0) {
			compareUrl=url;
		} else {
			compareUrl='';
		}
		// $("#msg").html("###"+url);
	});

	$("#trackCompareFinderHeaderAct").click(function(f) {	
		// window.location.href =compareUrl;
		if (compareUrl)
			window.parent.location.href =compareUrl;
		
	});

	$("#trackCompareFinderHeaderClose").click(function(f) {
		$('#trackCompareFinderHeaderExpand').hide();
		$('#trackCompareFinderHeaderMore').hide();		
		$("#trackCompareFinderList").slideToggle(500);				
		$('#trackCompareFinderHeader').fadeIn(500);
		
	});
	
	$("#trackCompareFinderHeaderMore").click(function(f) {
		$("#trackCompareFinderList .foundTrackItem").remove();		
		$("#trackCompareFinderHeaderMore").remove();
		
		for( var i in flights) {
			var fl=flights[i].data;
			$.getJSON('EXT_flight.php?op=list_flights_json&lat='+
					fl.firstLat+'&lon='+fl.firstLon+
					'&date='+fl.date+
					'&startTime='+fl.START_TIME+
					'&endTime='+fl.END_TIME+
					'&takeoffID='+fl.takeoffID+
					'&count=110'+
					'&distance='+radiusKm+queryString,null,
				function(results){
					addFlightsToList(results,100);
					$("#trackCompareFinderList").css({
						height:'300px',
						'overflow-y': 'scroll'
					});	
				}	
			);
			
			break;
		}	
	});
		
	
	$("#trackCompareFinderHeader").click(function(f) {
		if (searchDone) {
			$('#trackCompareFinderHeader').hide();
			
			$('#trackCompareFinderHeaderMore').fadeIn(300);
			$('#trackCompareFinderHeaderExpand').fadeIn(300);
			$("#trackCompareFinderList").slideDown(700);
		
		} else {
			
			for( var i in flights) {
				var fl=flights[i].data;
				$.getJSON('EXT_flight.php?op=list_flights_json&lat='+
						fl.firstLat+'&lon='+fl.firstLon+
						'&date='+fl.date+
						'&startTime='+fl.START_TIME+
						'&endTime='+fl.END_TIME+
						'&takeoffID='+fl.takeoffID+
						'&count=10'+
						'&distance='+radiusKm+queryString,null,
						function(results){addFlightsToList(results,5)});
				break;
			}
		}
		
	});
	

	 
});