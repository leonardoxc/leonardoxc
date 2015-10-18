


var chartObj;
var plot=null;
var Timer=null;
var updateLegendTimeout = null;
var latestPosition = null;
var latestPositionClicked=null;

var chartDataSeries=[];
var chartDataSeriesNum=0;

var trackStartIndex=0;

var chartInit=0;

var firstStartTm=null;

var syncTimeToFirst=0;
var syncTimezoneToFirst=0;
var firstTrackTMoffset=0;
var tmOffset=0;

var firstTrackTZoffset=0;
var tzOffset=0;

function toggleSyncStarts(cotrol){	
	if (syncTimeToFirst==0) {
		syncTimezoneToFirst=0;
		syncTimeToFirst=1;
		drawChart();
	} else {
		syncTimeToFirst=0;
		drawChart();
	}
}

function toggleSyncStartsTimezone(cotrol){	
	if (syncTimezoneToFirst==0) {
		syncTimeToFirst=0;
		syncTimezoneToFirst=1;
		drawChart();
	} else {
		syncTimezoneToFirst=0;
		drawChart();
	}
}

var trackColorList=[];

function drawChart() {
	var d0 = [];
	var d1 = [];
	
	var dataArray=[];
	var optionsArray=[];

    var cnum=0;


	var flightsNum=flights.length;
	
	chartDataSeries=[];
	chartDataSeriesNum=0;

	MIN_START=86000;
	MAX_END=0;
	
	
	for(var ii in flightsList) {
        var fnum=flightsList[ii];

		var data=flights[fnum].data;
	
		var flightID=data.flightID;
		var StartTm=data.startTm;

        var trackColor=flights[fnum]['data']['color'];
        trackColorList[cnum]=trackColor;
        cnum++;

		if (firstStartTm==null) { 
			// this is the first track
			firstStartTm=StartTm;
		}
	
		if (syncTimeToFirst) {
			if (chartDataSeriesNum==0)  {
				firstTrackTMoffset=data.points.time[0];			
			}
			tmOffset=firstTrackTMoffset-data.points.time[0];
		} else if (syncTimezoneToFirst || 1) {
			if (chartDataSeriesNum==0)  {	
				firstTrackTZoffset=data.TZoffset *3600;
			}
			tmOffset=firstTrackTZoffset-data.TZoffset * 3600;
			
		} else {
			tmOffset=0;			
		}
		
		
		dataArray[fnum]=[];
		
		if (+data.START_TIME+tmOffset < MIN_START)	MIN_START=+data.START_TIME+tmOffset ;
		if (+data.END_TIME+tmOffset  > MAX_END) 	MAX_END=+data.END_TIME+tmOffset ;
				
		for(i=0;i<data.points.time.length;i++) {
			// the + is important, dont remove
			var tm=+firstStartTm + ( (data.points.time[i]+tmOffset) *1000);
			if (flightsTotNum==1) {
			 	// ground 
				if ( data.points.elevGnd[i] == 0 && i>0) {
		 			data.points.elevGnd[i] = (data.points.elevGnd[i-1] *0.95 ) + (data.points.elevGnd[i-1]* 0.1* (Math.random()));
		 		}
			 	d0.push([tm,data.points.elevGnd[i]*multMetric ]);
			 
				// atlitude varo
			 	if (baroGraph) {

			 		d1.push([tm,data.points.elevV[i]*multMetric ]);
			 	}
			}
		
			// altitude  gps
			dataArray[fnum].push([tm,data.points.elev[i]*multMetric]);
			 
		}
	
		if (flightsTotNum==1) {
	 		// ground 	 		
	 		optionsArray.push( { data:d0,label: "", lines: {
   			   		fill: true,			  
   			   		fillColor: "#AB7224"
  		   		}
	 		} );
	 	
	 		// atlitude varo
	 		if (baroGraph) {	 			
	 			optionsArray.push( { data:d1,label: AltitudeStrBaro } );
	 		}
	 		optionsArray.push( { data:dataArray[fnum],label:AltitudeStr } );
	 		
		} else {
			optionsArray.push( { data:dataArray[fnum] } );
		}
		
		chartDataSeries[chartDataSeriesNum]=data.flightID;
		chartDataSeriesNum++;
	}
	
	plot=$.plot($("#chart"),
		optionsArray, 
		{
			series: {
				lines: { 
					show: true, 
					lineWidth: 1,
					fill: false 
				},
				shadowSize: 0
			},
			colors: trackColorList,
			xaxis: { mode: "time",  show: true } ,
			yaxis: { min: 0 },
			crosshair: { mode: "x" },
	        grid: {	        	 
	        	margin:8,
	        	hoverable: true, 
	        	clickable: true,
	        	borderWidth: 0,
	            borderColor: "#454545",
				autoHighlight: false 
			},
            legend: { show: true,  noColumns:3 }
		}	
	);
	
	// plot.setupGrid();

    $("#chart").bind("plothover",  function (event, pos, item) {
    	if (animIsRunning) return;
    	
        latestPosition = pos;       
        if (!updateLegendTimeout)
            updateLegendTimeout = setTimeout(updateLegend, 50);
    });

    $("#chart").bind("plotclick",  function (event, pos, item) {
    	latestPositionClicked = pos;
    });
}

function updateLegend() {
    updateLegendTimeout = null;

    var pos = latestPosition;
    
    var axes = plot.getAxes();
    if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
        pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
        return;
	}
    
    var i, j, dataset = plot.getData();
      
    for (i = 0; i < dataset.length; ++i) {
    	
         var series = dataset[i];

        // find the nearest points, x-wise
        for (j = 0; j < series.data.length; ++j) {
            if (series.data[j][0] > pos.x) 
                break;
        }
        
        // now interpolate
        var y, p1 = series.data[j - 1], p2 = series.data[j];
        if (p1 == null)
            y = p2[1];
        else if (p2 == null)
            y = p1[1];
        else
            y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);
      
        // legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
        var flightID=chartDataSeries[i];
        
        if (flightID) {
        	updateVisuals(flightID,i,j);
    	}
		
    }
}


function updateVisuals(flightID,num,j) {
	var displayBoxName="#trackInfo"+num;
	// get the lat lon
	var lat=flights[flightID].data.points.lat[j];
	var lon=flights[flightID].data.points.lon[j];
	var speedStr=flights[flightID].data.points.speed[j];
	var altStr=flights[flightID].data.points.elev[j];
	var altVStr=flights[flightID].data.points.elevV[j];
	var varioStr=flights[flightID].data.points.vario[j];
	var timeStr=flights[flightID].data.points.time[j];
	var altGround=flights[flightID].data.points.elevGnd[j];
	
	
	var altAboveGround=+altStr-altGround;
	
	
	if (is3D) {
		if (posMarker[num] && j<=flights[flightID].data.points.lat.length && +lat && +lon ) {
			
			posMarker[num].getGeometry().setLatLngAlt(+lat,+lon,+altStr);
			
			if (followGlider) {
				var lookAt = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);			
				lookAt.setLatitude(+lat);
				lookAt.setLongitude(+lon);
				lookAt.setRange(lookAt.getRange() * 0.9);
	
				ge.getView().setAbstractView(lookAt);
			}
		}
	} else {
		
		var newpos= new google.maps.LatLng(lat, lon);
		var point=latlngToPoint(map,newpos);
		var varioPoint=latlngToPoint(map,newpos);
		var varioPoint2=latlngToPoint(map,newpos);
		
		var varioHeight=Math.round(+varioStr * 7);
		var altFactor=1;		
		// max line height is 50 pixels
		// max altitude above ground is 2000m
		// 0 - 500 m -> 50 pix
		// 500 - 1000 -> 25 px
		// 1000 - 2000 -> 25 px
		// 2000  -.... xxx
		var pxOffset=0;
		
		if (altAboveGround > 2000 ) {
			pxOffset =100;
		} else {
			if ( altAboveGround > 1000 ) {
				pxOffset=75 + ( ( altAboveGround -1000 ) *25  )/ 1000 ; 
			}  else if ( altGround > 500 ) {
				pxOffset=50 + ( ( altAboveGround - 500 ) *25  )/ 500 ; 
			}  else {
				pxOffset=0 + ( ( altAboveGround - 0  ) *50  )/ 500 ;
			}			
		}
		point.y-=Math.round( Math.exp(altAboveGround / 1000  * 2.5  ) );
					
		var newpos2= pointToLatlng(map,point);		
		altMarker[num].setPath( [ newpos, newpos2 ] );		
		
		if (varioHeight>=0) {
			varioColor='#00ff00';
		} else {
			// varioHeight=-varioHeight;
			varioColor='#ff0000';
		}
		varioPoint.x+=5;	
		varioPoint.y=point.y;
		
		varioPoint2.x+=5;						
		varioPoint2.y= point.y - varioHeight;
		var p1=pointToLatlng(map,varioPoint);
		var p2=pointToLatlng(map,varioPoint2);
		varioMarker[num].setOptions({'strokeColor': varioColor });
		varioMarker[num].setPath( [ p2,p1 ] );
	
		
		posMarker[num].setPosition(newpos2);	
		posMarker2[num].setPosition(newpos);
		if (followGlider) map.setCenter(newpos, null);
	}

	if ( isNaN(speedStr)) { 
		speedStr='-';
	} else {
		if (metricSystem==2) {
			speedStr*=0.62;
		}
		speedStr=Math.round(speedStr*10)/10;
		speedStr=speedStr+speedUnits;
	}
	
	if ( isNaN(altStr)) { 
		altStr='-'; 
	} else {
		altStr=Math.round(altStr*multMetric);
		altStr=altStr+altUnits;
	}
	
	if ( isNaN(altVStr)) { 
		altVStr='-'; 
	} else {
		altVStr=Math.round(altVStr*multMetric);
		altVStr=altVStr+altUnits;
	}
		
	if ( isNaN(timeStr)  ) { 
		timeStr='-'; 
	} else {
		timeStr=sec2Time(timeStr);		
	}
	
	if ( isNaN(varioStr)) { 
		varioStr='-'; 
	} else {
		if (metricSystem==2) {
			varioStr*=196.8;
			varioStr=Math.round(varioStr);
		} else {
			varioStr=Math.round(varioStr*10)/10;
		}
		varioStr=varioStr+varioUnits;
	}
	
	
	if (flightsTotNum==1) {
		$(displayBoxName+' .time').html(timeStr);
	} else {
		if (timeStr!='-')  {
			$('#timeDiv').html(timeStr);
		}
	}
	$(displayBoxName+' .speed').html(speedStr);
	$(displayBoxName+' .alt').html(altStr);
	$(displayBoxName+' .vario').html(varioStr);
	if (userAccessPriv && flightsTotNum==1) $(displayBoxName+' .altV').html(altVStr);
	
}

var initAnim=0;
var animIsRunning=0;
function resetTimer() {	
	CurrTime=parseInt(firstStartTm) + parseInt(MIN_START)*1000;
	initAnim=1;
	StopTimer();
	
	latestPosition= { x:  CurrTime, y: 0 } ;
	plot.setCrosshair( latestPosition);
	updateLegend();
}

function IncTime() {
	if (latestPositionClicked!=null) {
		CurrTime=latestPositionClicked.x;
	} else{
		CurrTime+=parseInt(TimeStep);	
	}
	latestPositionClicked=null;
	
	
	if (CurrTime>=parseInt(firstStartTm) + parseInt(MAX_END)*1000) {
		resetTimer();
	}
		
	latestPosition= { x:  CurrTime, y: 0 } ;
	plot.setCrosshair( latestPosition);
	updateLegend();
}
  
function StartTimer() {
	if (!initAnim) {
		resetTimer();
	}
	if (latestPositionClicked!=null) {
		CurrTime=latestPositionClicked.x;
	}
	if (!Timer) {
		animIsRunning=1;
		Timer= setInterval("IncTime()", 100)
	} 
}
  
function StopTimer() {
   if (Timer) {
    clearInterval(Timer)
    Timer = 0
    animIsRunning=0;
   }
}
  
function ToggleTimer() {
   if (Timer) 
    StopTimer();
   else
    StartTimer();
}

