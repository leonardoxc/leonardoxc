$('#reportListPage').live('pageshow', function(event) {
	var id = getUrlVars()["id"];
	console.log("reports for " + id);
	$.getJSON(serviceURL + 'getreports.php?id='+id, function (data) {
		var reports = data.items;
		$.each(reports, function(index, employee) {
			$('#reportList').append('<li><a href="employeedetails.html?id=' + employee.id + '">' +
					'<h4>' + employee.firstName + ' ' + employee.lastName + '</h4>' +
					'<p>' + employee.title + '</p>' +
					'<span class="ui-li-count">' + employee.reportCount + '</span></a></li>');
		});
		$('#reportList').listview('refresh');
	});
});
