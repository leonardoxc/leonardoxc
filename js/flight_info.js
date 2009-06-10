	
function changeTandem() {
	if  ( $("#tandem").attr('checked') ) {
		$("#category").val(3);
		$("#categoryDesc").html(gliderClassList[3]);
	} else {
		selectGliderCertCategory();
	}
}

function selectGliderCertCategory() {		
	var gCert=$("#gliderCertCategorySelect").val();
	
	$("#gliderCertCategory").val(gCert);
	
	if  ( $("#tandem").attr('checked') ) {
	
	} else {
		if ( gCert ==0) {
			category=0;	
		} else if ( gCert & 0x0067 ) {
			category=1;	
		} else {
			category=2;
		}
		
		$("#category").val(category);
		$("#categoryDesc").html(gliderClassList[category]);
	}
	
}


function selectGliderCategoryOther() {	
	var category=$("#categoryOther").val();

	$("#category").val(category);	
	$("#categoryDesc").html(gliderClassList[category]);
	
}

function selectGliderCat() {		
	var gCat=$("#gliderCat").val();
	
	if (gCat==1) {
		$("#categoryPg").show();
		$("#categoryOtherDiv").hide();	
	} else {
		$("#categoryPg").hide();
		$("#categoryOtherDiv").show();
	}	
}

function setValue(obj) {		
	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj[n].value;        // Return string value of menu item
	var valParts= val.split("_");

	$("#glider").val(valParts[1]);
	$("#gliderBrandID").val(valParts[0]);
}
