	


function updateClassDropDown(gliderCertID,showAll,gliderClass) {
	var gCat=$("#gliderCat").val();

	$("#category").removeOption(/./);
	
	$.ajax( { url: moduleRelPath+"/EXT_ajax_functions.php",
		  	data: {op:"getCategoriesForCertID",showAll:showAll,gliderCertID:gliderCertID,gliderCat:gCat} ,
			success: function(jsonString) {	
				var optionsArray = eval(jsonString);
				if (optionsArray!=null) {
					for(var i=0;i<optionsArray.length;i++) {	
						$("#category").addOption(optionsArray[i][0],optionsArray[i][1]);
					}	
				} else {
					$("#category").addOption("0","-");	
				}
				
				if (gliderClass>0 || true) {
					$("#category").val(gliderClass);
				}
			}
	});	
	
}


function selectGliderCertCategory(gliderClass) {		
	var gCert=$("#gliderCertCategorySelect").val();	
	$("#gliderCertCategory").val(gCert);	
	updateClassDropDown(gCert,0,gliderClass);
}

function selectGliderCat() {		
	var gCat=$("#gliderCat").val();
	
	if (gCat==1) {
		$("#categoryPg").show();
		$("#gCertDescription").show();
		$("#category").removeOption(/./);
		$("#category").addOption("0","-");
	} else {
		$("#categoryPg").hide();
		$("#gCertDescription").hide();
		$("#gliderCertCategorySelect").val(0);
		updateClassDropDown(0,1,0);
	}	
}



function selectBrand2(gliderID) {
    var  gliderBrandID= $("#gliderBrandID").val();
    $.getJSON(moduleRelPath+'/AJAX_gliders.php?op=gliders_list&brandID='+gliderBrandID, function(resJson) {
        var options = '<option value=0></option>';
        gliderCerts=[];
        $.each(resJson.Records,function(k,v){
            var gID= v.gliderID;
            var gName= v.gliderName;
            options+= '<option value="'+gID+'">'+gName+'</option>';
            gliderCerts[gID]=v.gliderCert;
        });
        $("#gliderID").html(options);
        $("#gliderID").val(gliderID);
        selectGlider();
    });

}


function setValue(obj) {		
	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj[n].value;        // Return string value of menu item
	var valParts= val.split("_");

	//gliderBrandID,glider,gliderCertCategory,cat,category	
	$("#glider").val(valParts[1]);
	$("#gliderBrandID").val(valParts[0]);

	$("#gliderCat").val(valParts[3]);
	selectGliderCat();
		
//	$("#gliderCertCategory").val(valParts[2]);
	$("#gliderCertCategorySelect").val(valParts[2]);
	selectGliderCertCategory(valParts[4]);
	
//	$("#category").val(valParts[4]);
//	selectGliderCategory();
}
