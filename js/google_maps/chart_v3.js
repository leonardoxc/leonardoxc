


var chartObj;
var plot=null;
var updateLegendTimeout = null;
var latestPosition = null;

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
	// $("#msg").html(flightsNum);
	
	
	chartDataSeries=[];
	chartDataSeriesNum=0;

	for(var fnum in flights) {
		var data=flights[fnum].data;
	
		var flightID=data.flightID;
		var StartTm=data.startTm;
		
		if (firstStartTm==null) {
			firstStartTm=StartTm;
		}
	
		// $("#msg").append("StartTm:"+StartTm);
		
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
	        	borderWidth: 0,
	            borderColor: "#454545",
				autoHighlight: false 
			}
		}	
	);
	
	// plot.setupGrid();

    $("#chart").bind("plothover",  function (event, pos, item) {
        latestPosition = pos;
        if (!updateLegendTimeout)
            updateLegendTimeout = setTimeout(updateLegend, 50);
    });

}

function updateLegend() {
    updateLegendTimeout = null;

    var pos = latestPosition;
    
    var axes = plot.getAxes();
    if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
        pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
    	
    	// alert("return");
        return;
	}
    
  
    
    var i, j, dataset = plot.getData();
    
  // $("#msg").html("#dalaten="+dataset.length);
    
    for (i = 0; i < dataset.length; ++i) {
    	
    	//$("#msg").append("#"+i);
    	
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

        
        //  $("#msg").html(y.toFixed(2)+"#"+series.data.length+"#"+j);
        
        // legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
        var flightID=chartDataSeries[i];
        
       // $("#msg").append("flightID"+flightID);
        if (flightID) {
        	// $("#msg").html("@@@"+i);
        	updateVisuals(flightID,i,j);
    	}
		
    }
}


function updateVisuals(flightID,num,j) {
	
	// num=num+trackStartIndex;
	
	var displayBoxName="#trackInfo"+num;
	// $("#msg").append("#displayBoxName:"+displayBoxName);
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

function drawChart0() {
	// draw all flights
	// for(f=0;f<flights.length;f++) {
	// trim off points before start / after end
	var j=0;
	flight.points_num=0;
	flight.max_alt=0;
	flight.min_alt=100000;
	
	for(i=0;i<flightArray.time.length;i++) {		
			if (flightArray.time[i]>=StartTime && flightArray.time[i]<= StartTime + Duration) {
				flight.time[j]=sec2Time(flightArray.time[i]);
				flight.elev[j]=flightArray.elev[i];
				flight.elevV[j]=flightArray.elevV[i];
				flight.elevGnd[j]=flightArray.elevGnd[i];
				flight.lat[j]=flightArray.lat[i];
				flight.lon[j]=flightArray.lon[i];
				flight.speed[j]=flightArray.speed[i];
				flight.vario[j]=flightArray.vario[i];
				flight.distance[j]=flightArray.distance[i];

				// for testing
				// flight.elevGnd[j]=800;
				if (j==0) {
						lat=flight.lat[j]=flightArray.lat[i];
						lon=flight.lon[j]=flightArray.lon[i];
				}else {
                  	//P.Wild ground height hack  3.4.08
                	if ( flight.elevGnd[j] == 0) flight.elevGnd[j] = (flight.elevGnd[j-1] *0.95 ) + (flight.elevGnd[j-1]* 0.1* (Math.random()));

				}

				if ( flight.elev[j] > flight.max_alt ) flight.max_alt=flight.elev[j];
				if ( flight.elevGnd[j] > flight.max_alt ) flight.max_alt=flight.elevGnd[j];
				if ( flight.elev[j] < flight.min_alt ) flight.min_alt=flight.elev[j];
				if ( flight.elevGnd[j] < flight.min_alt ) flight.min_alt=flight.elevGnd[j];
				flight.points_num++;
				j++;
			}
	}
	flight.label_num=flightArray.label_num;

	var nbPts=flight.time.length;
	var label_num=flight.label_num;
	var idx = 0;
	var step = Math.floor( (nbPts - 1) / (label_num - 1) );
	
	for (i = 0 ; i < label_num; i++) {
		flight.labels[i] = flight.time[idx];
		idx += step;
	}
	
	// flight.labels=flightArray.labels;
	
	// var flightArray = eval("(" + jsonString + ")");		

	// add some spaces to the last legend
	flight.labels[flight.labels.length-1]+='   ___';
	
	if (metricSystem==2) {
		for(i=0;i<flight.elev.length;i++) {
			flight.elev[i]*=3.28;
			flight.elevGnd[i]*=3.28;
		}
		flight.max_alt*=3.28;
		flight.min_alt*=3.28;
	}
	
	var min_alt=Math.floor( (flight.min_alt/100.0) )  * 100 ;
	var max_alt=Math.ceil( (flight.max_alt/100.0) ) * 100  ;
	
	var ver_label_num=5;
	// smart code to  compute vertival label num so to be mulitple of 100
	//if ( ( (max_alt-min_alt)/ver_label_num) != Math.floor((max_alt-min_alt)/  ver_label_num ) ) 
	//		ver_label_num++;

	var c = new Chart(document.getElementById('chart'));
	c.setDefaultType(CHART_LINE );

	c.setGridDensity(flight.label_num,ver_label_num);
	c.setVerticalRange( min_alt ,max_alt  );
	c.setShowLegend(false);
	c.setLabelPrecision(0);
	c.setHorizontalLabels(flight.labels);
	
	if (baroGraph) {
		c.add('Altitude Baro',  '#6EC9E0', flight.elevV);
	}
	
	c.add('Altitude',     '#FF3333', flight.elev);
	c.add('Ground Elev',  '#C0AF9C', flight.elevGnd,CHART_AREA);
	c.draw();

	chartObj=c;
	
	updateChartWidth();
}
