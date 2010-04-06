<? 
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_admin_list_users.php,v 1.5 2010/04/06 13:45:39 manolis Exp $                                                                 
//
//************************************************************************
	if (! L_auth::isAdmin($userID)  ) {
		return;
	}
	
?>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/users/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/users/css/jquery-ui.css"/>


<script src="<?=$moduleRelPath?>/users/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/users/js/jquery.jqGrid.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/users/js/jquery-ui.js" type="text/javascript"></script>


<script language='javascript'>

var imgpath='<?=$moduleRelPath?>/users/css/themes/start/images';

jQuery(document).ready(function(){ 

	makeUsersGrid();

});

function makeUsersGrid() {


  jQuery("#listUsers").jqGrid({
    url:'<?=$moduleRelPath?>/EXT_users_db_helper.php',
    datatype: 'xml',
    mtype: 'GET',
    colNames:['#','username','user_email', 'Country','CIVL_ID','CIVL_NAME','FirstName','LastName','Sex','Birthdate'],
    colModel :[ 
      {name:'user_id', index:'user_id', width:50, search:true, editable:false}, 
      {name:'username', index:'username', width:120, editable:true,search:true }, 
	  {name:'user_email', index:'user_email', width:190, editable:true, search:true },
	  {name:'countryCode', index:'countryCode', width:50, editable:true, search:true },
	  {name:'CIVL_ID', index:'CIVL_ID', width:50, editable:true, search:true }, 
	  {name:'CIVL_NAME', index:'CIVL_NAME', width:120, editable:true, hidden:true,search:true }, 
	  {name:'FirstName', index:'FirstName', width:80, editable:true, search:true }, 
  	  {name:'LastName', index:'LastName', width:100, editable:true, search:true }, 
	  {name:'Sex', index:'Sex', width:30, editable:true, search:true }, 
	  {name:'Birthdate', index:'Birthdate', width:90, editable:true, search:true ,
			editoptions:{size:12,
				dataInit:function(el){
					$(el).datepicker({dateFormat:'yy-mm-dd'});
				}
			}
	  }, 	 
	],
    pager: jQuery('#pagerUsers'),
    rowNum:10,
    rowList:[10,20,30,50,100],
    sortname: 'user_id',
    sortorder: "asc",
    viewrecords: true,

    imgpath: imgpath,
	caption: 'Users',

	editurl: "<?=$moduleRelPath?>/EXT_users_db_helper.php",
	height: 'auto'

  });
  
var sgrid = $("#listUsers")[0];


	jQuery("#listUsers").jqGrid('navGrid','#pagerUsers',{edit:true,add:true,del:true,search:true,refresh:false}); 
	
	jQuery("#listUsers").jqGrid('navButtonAdd',"#pagerUsers",
			{caption:"Toggle",title:"Toggle Search Toolbar", buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ sgrid.toggleToolbar() } }); 
	
	jQuery("#listUsers").jqGrid('navButtonAdd',"#pagerUsers",
		{	caption:"Clear",title:"Clear Search",buttonicon :'ui-icon-refresh', 
			onClickButton:function(){sgrid.clearToolbar() } }); 

	jQuery("#listUsers").jqGrid('filterToolbar'); 

}

</script>

<table id="listUsers"  width="500" class="scroll" style="width:500px;"></table>
<div id="pagerUsers" class="scroll" style="text-align:center;"></div>

<BR><BR>
