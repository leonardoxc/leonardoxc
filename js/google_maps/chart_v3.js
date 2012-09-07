


var chartObj;
var ImgW = 745;

function updateChartWidth() {
	ImgW=$("#chart").width();	
}

function drawChart() {
	var d1 = [];
	   
	for(i=0;i<flightArray.time.length;i++) {	
		 d1.push([flightArray.time[i],flightArray.elev[i]]);
		 	
	}
	
	$.plot($("#chart"), [
	   {
	       data: d1,
	       lines: { show: true, fill: false }
	   }
	]);

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
