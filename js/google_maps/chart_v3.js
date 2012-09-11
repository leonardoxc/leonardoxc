


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

function drawChart(data) {
	var d0 = [];
	var d1 = [];
	
	var dataArray=[];
	var optionsArray=[];
	
	var flightsNum=flights.length;
	
	chartDataSeries=[];
	chartDataSeriesNum=0;

	for(var fnum in flights) {
		var data=flights[fnum].data;
	
		var flightID=data.flightID;
		var StartTm=data.startTm;
		
		if (firstStartTm==null) {
			firstStartTm=StartTm;
		}
	
		dataArray[fnum]=[];
		
		
		for(i=0;i<data.points.time.length;i++) {
			
			var tm=+firstStartTm+(data.points.time[i]*1000);
			if (flightsTotNum==1) {
			 	// ground 
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
	 		optionsArray.push( { data:d0,label: "ground", lines: { 
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
			colors: trackColors ,
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
			}
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
		
	var newpos= new google.maps.LatLng(lat, lon);
	posMarker[num].setPosition(newpos);
	posMarker2[num].setPosition(newpos);
	
	if (followGlider) map.setCenter(newpos, null);
	

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

