

	function moveMarker(){
		var pt =  posMarker.getPoint();
		var newpos= new GLatLng(pt.lat() + .001, pt.lng() + .001)
		posMarker.setPoint(newpos);
		// if (followGlider) map.setCenter(newpos, null);
	}


	
	function sec2Time(secs){
	   secs=secs/60;
	   h=Math.floor(secs/60);
  	   if (h<10) h="0"+h;
	   m=Math.floor(secs % 60);
	   if (m<10) m="0"+m;
	   return h+":"+m;
	}
	
	function DisplayCrosshair(i){ // i=1 for the start , 2 end 	 
		var Temp = Math.floor( (ImgW-marginLeft-marginRight) * CurrTime[i] / EndTime) ;
		timeLine[i].left = marginLeft + Temp  + "px";		
		//	MWJ_changeContents('timeText'+i,sec2Time(StartTime + CurrTime[i]));
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
				map.addOverlay(taskLayer[i]);
			}
		} else {
			showTask=0;
			for (var i=0; i<taskLayer.length; i++) {
				map.removeOverlay(taskLayer[i]);
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

	function setValue(obj,target) {		
		//	var n = obj.selectedIndex;    // Which menu item is selected
		var val = obj.value;        // Return string value of menu item
		t=MWJ_findObj(target);
		t.value=val;	
	}


	function SetTimer(evt) {
	// function SetTimer(evt) {
		i=1; //getCheckedValue(document.forms[0].timeSel);
		/*if (typeof evt == "object") {
			if (evt.layerX > -1) {
				CurrTime[i] = (evt.layerX -marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
			} else if (evt.offsetX) {
				CurrTime[i] = (evt.offsetX-marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
			}
		}
		*/
		if ( CurrTime[1] <0 )  { CurrTime[1] =0; }
		if ( CurrTime[1] >= CurrTime[2]-4 )  { CurrTime[1] =CurrTime[2]-5; }

		DisplayCrosshair(i);
		
		// round up to 20secs..
		// tm=Math.floor(CurrTime[1]/20)*20;
		tm=Math.floor(CurrTime[1]/EndTime * flight.points_num);
		// MWJ_changeContents('timeText'+i,sec2Time(flight.time[tm]));
		MWJ_changeContents('timeText'+i,flight.time[tm]);

		// get the lat lon
		lat=flight.lat[tm];
		lon=flight.lon[tm];
		var newpos= new GLatLng(lat, lon);
		posMarker.setPoint(newpos);
		
		if (followGlider) map.setCenter(newpos, null);
		
		var speedStr=flight.speed[tm];
		var altStr=flight.elev[tm];
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
		
		if (metricSystem==2) {
			varioStr*=196.8;
			varioStr=Math.round(varioStr);
		} else {
			varioStr=Math.round(varioStr*10)/10;
		}
		varioStr=varioStr+varioUnits;
		
		//	speed=document.getElementById("speed");
		//  speed.value=speedStr;
		MWJ_changeContents('speed',speedStr);
		MWJ_changeContents('alt',altStr);
		MWJ_changeContents('vario',varioStr);	
	}


	function zoomToFlight() {		
			zoom=map.getBoundsZoomLevel(bounds);	
			map.setCenter(new GLatLng( center_lat,center_lon), zoom);
	}

	var taskicons=[];
	taskicons["s"]   = "img/icon_start.png";    
	taskicons["1"]   = "img/icon_1.png";
	taskicons["2"]   = "img/icon_2.png";
	taskicons["3"]   = "img/icon_3.png";
	taskicons["4"]   = "img/icon_4.png";
	taskicons["5"]   = "img/icon_5.png";
	taskicons["e"]   = "img/icon_end.png";

	function createTaskMarker(point,name,ba) {      
		var Icon = new GIcon(G_DEFAULT_ICON, taskicons[ba]);
		Icon.iconSize=new GSize(16,24);
		//Icon.shadow = "http://maps.google.com/mapfiles/kml/pal3/icon61s.png";
		//Icon.shadowSize=new GSize(16,24);
		Icon.iconAnchor=new GPoint(3,20);
		Icon.infoWindowAnchor=new GPoint(16,0);
		
		var marker = new GMarker(point,Icon,{title:name});
		
		posMarker=marker;
		return marker;
	}

    function displayTask(tp) {
		var tpPoints=[];
		if (tp.turnpoints.length>0) {
			for(j=0;j<tp.turnpoints.length;j++){							 
				tpPoints[j]=new GLatLng(tp.turnpoints[j].lat,tp.turnpoints[j].lon);
			}
			
			var polyline = new GPolyline(tpPoints , "#FFFFFF", 3,1); 
			map.addOverlay(polyline);
			taskLayer.push(polyline); 
			
			for(j=0;j<tp.turnpoints.length;j++){							 
				var marker = createTaskMarker(tpPoints[j],tp.turnpoints[j].name,tp.turnpoints[j].id ) ;
				taskLayer.push(marker); 
				map.addOverlay(marker);
			}
		}
	}
	
	