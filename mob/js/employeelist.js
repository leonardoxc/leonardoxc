var serviceURL = "";
//serviceURL = "../../";

serviceURL ="http://xc.dhv.de/xc/modules/leonardo/";

//serviceURL ="http://www.paraglidingforum.com/leonardo/";

var lat=49;
var lon=10;
var count=20;

var employees;

$('#employeeListPage').bind('pageinit', function(event) {
	getEmployeeList();
});

function getEmployeeList() {
	$.getJSON(serviceURL + 'AJAX_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&count='+count+'&distance=1000', function(data) {
		$('#employeeList li').remove();
		employees = data.flights;
		$.each(employees, function(index, flight) {
			$('#employeeList').append('<li><a href="trackdetails.html?id=' + flight.flightID + '">' +
				//	'<img src="pics/' + flight.picture + '"/>' +
					'<h4>' + flight.takeoff + '</h4>' +
                    '<p>' + flight.pilotName +'</p>' +
					'<p>Duration: ' + flight.DURATION +  ' Score: '+flight.olcScore +  '&nbsp;'+flight.olcScoreType +' - '+flight.olcDistance+'</p>' +
					'<span class="ui-li-count">' + flight.date+ '</span></a></li>');
		});
		$('#employeeList').listview('refresh');
	});
}