$('#detailsPage').live('pageshow', function(event) {
	var id = getUrlVars()["id"];
	$.getJSON(serviceURL + 'AJAX_flight.php?op=list_flights_json&flightID='+id, displayTrack);
});

function displayTrack(data) {
	var track = data.flights[0];
	//console.log(track);

	//$('#fullName').html(track.pilotName);
	//$('#employeeTitle').text(track.date);
	//$('#city').text(track.DURATION);


    $('#info').append('<li>' +
        '<h4>' + track.takeoff + '</h4>' +
        '<h4>' + track.pilotName +'</h4>' +
        '<p>Duration: ' + track.DURATION +  ' Score: '+track.olcScore +  '&nbsp;'+track.olcScoreType +' - '+track.olcDistance+'</p>' +

        '<p>Max Vario: ' + track.MAX_VARIO +  ' Min Vario: '+track.MIN_VARIO +  '</p>' +

        '<p>Glider: ' + track.gliderCat +  ' '+track.gliderBrandImg +  ' '+track.glider+ '</p>' +

        // categoryImg



        '<span class="ui-li-count">' + track.date+ '</span></li>');

    $('#info').listview('refresh');


    $('#g1').attr('src', track.g1);
    $('#g2').attr('src', track.g2);
    $('#g3').attr('src', track.g3);
    $('#g4').attr('src', track.g4);


    $('#map').attr('src', track.map);


    //console.log(track.pilotName);
	if (track.managerId>0) {
		$('#actionList').append('<li><a href="employeedetails.html?id=' + track.managerId + '"><h3>View Manager</h3>' +
				'<p>' + track.managerFirstName + ' ' + track.managerLastName + '</p></a></li>');
	}
	if (track.reportCount>0) {
		$('#actionList').append('<li><a href="reportlist.html?id=' + employee.id + '"><h3>View Direct Reports</h3>' +
				'<p>' + track.reportCount + '</p></a></li>');
	}
	if (track.email) {
		$('#actionList').append('<li><a href="mailto:' + track.email + '"><h3>Email</h3>' +
				'<p>' + track.email + '</p></a></li>');
	}
	if (track.officePhone) {
		$('#actionList').append('<li><a href="tel:' + track.officePhone + '"><h3>Call Office</h3>' +
				'<p>' + track.officePhone + '</p></a></li>');
	}
	if (track.cellPhone) {
		$('#actionList').append('<li><a href="tel:' + track.cellPhone + '"><h3>Call Cell</h3>' +
				'<p>' + track.cellPhone + '</p></a></li>');
		$('#actionList').append('<li><a href="sms:' + track.cellPhone + '"><h3>SMS</h3>' +
				'<p>' + track.cellPhone + '</p></a></li>');
	}
	$('#actionList').listview('refresh');
	
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
