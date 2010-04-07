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
// $Id: GUI_admin_users_list.php,v 1.3 2010/04/07 13:08:54 manolis Exp $                                                                 
//
//************************************************************************
	if (! L_auth::isAdmin($userID)  ) {
		return;
	}
	
	$userAction=$_GET['act'];
	if (!$userAction) $userAction = "list";
	
	openMain("User Admin Panel",0,'');
	
?>
<link rel="stylesheet" type="text/css" href="<?=$themeRelPath?>/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="<?=$themeRelPath?>/css/jquery-ui.css"/>
<style type="text/css">
.ui-widget-content {
	font-size:11px;
}
</style>

<script src="<?=$moduleRelPath?>/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/jquery.jqGrid.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/jquery-ui.js" type="text/javascript"></script>


<script language='javascript'>

// var imgpath='<?=$moduleRelPath?>/users/css/themes/start/images';

jQuery(document).ready(function(){ 

	makeUsersGrid();

});


function processAddEdit(response, postdata) {
	var msg=response.responseText; 
	if (msg!='') alert(msg);	
	return [true,msg,null]; 
}

function makeUsersGrid() {


  jQuery("#listUsers").jqGrid({
    url:'<?=$moduleRelPath?>/EXT_users_db_helper.php',
    datatype: 'xml',
    mtype: 'GET',
    colNames:['#','username','Password','Email', 'Country','CIVL_ID','CIVL_NAME','First Name','Last Name','Sex','Birthdate'],
    colModel :[ 
      {name:'user_id', index:'user_id', width:50, search:true, editable:false, editrules:{edithidden:true, required:true} }, 
      {name:'username', index:'username', width:120, editable:true,search:true,editrules:{ required:true} }, 
  	  {name:'user_password', index:'user_password', width:10, hidden:true,editable:true, search:false,edittype:"text",
	  		formoptions:{label:'New Password',elmsuffix:'<br>(only fill if you want to change it)'},	  
	  		editoptions:{}, 
			editrules:{ edithidden:true,required:false} 
	  }, 

	  {name:'user_email', index:'user_email', width:190, editable:true, search:true,
	  	  	formoptions:{label:'Email'},	  
	  		editoptions:{size:"30",maxlength:"60"},editrules:{ required:true,email:true} },
	  {name:'countryCode', index:'countryCode', width:50, editable:true, search:true,edittype:"select",
	  		formoptions:{label:'Country'},	  
	  		editoptions:{dataUrl:'<?=$moduleRelPath?>/EXT_ajax_functions.php?op=getCountriesSelect'}, editrules:{ required:true} },
	  {name:'CIVL_ID', index:'CIVL_ID', width:50, editable:true, search:true,editrules:{ required:true,integer:true} }, 
	  {name:'CIVL_NAME', index:'CIVL_NAME', width:120, editable:true, hidden:true,search:true,editrules:{ edithidden:true,required:false} }, 
	  {name:'FirstName', index:'FirstName', width:80, editable:true, search:true,editrules:{ required:true} }, 
  	  {name:'LastName', index:'LastName', width:100, editable:true, search:true,editrules:{ required:true} }, 
	  {name:'Sex', index:'Sex', width:30, editable:true, search:true,edittype:"select",editoptions:{value:"M:Male;F:Female"} }, 
	  {name:'Birthdate', index:'Birthdate', width:90, editable:true, search:true ,datefmt:'dd.mm.Y',
			formoptions:{elmsuffix:'(use dd.mm.yyyy)'},
	  		editrules:{ required:true,date:true},
			editoptions:{size:12,
				dataInit:function(el){
					$(el).datepicker({dateFormat:'dd.mm.yy'});
				}
			}
	  }
	],
    pager: jQuery('#pagerUsers'),
    rowNum:10,
    rowList:[10,20,30,50,100],
    sortname: 'user_id',
    sortorder: "asc",
    viewrecords: true,

   // imgpath: imgpath,
	caption: 'Users',

	editurl: "<?=$moduleRelPath?>/EXT_users_db_helper.php",
	height: 'auto'

  });
  
var sgrid = $("#listUsers")[0];


	jQuery("#listUsers").jqGrid('navGrid','#pagerUsers',{edit:true,add:true,del:true,search:false,refresh:true},
	
	    {              
                afterSubmit:processAddEdit,               
                closeAfterAdd: true,
                closeAfterEdit: true
        }, 
        {
                afterSubmit:processAddEdit,               
                closeAfterAdd: true,
                closeAfterEdit: true
        } 
	
	); 
	
	//jQuery("#listUsers").jqGrid('navGrid',"#pagerUsers").jqGrid('navButtonAdd',"#pagerUsers",
	//	{caption:"", buttonicon:"ui-icon-locked", position: "last", title:"Change Password",onClickButton:function(){ 
	// 			sgrid.toggleToolbar() 
	//		}
	//  	}
	//);


	jQuery("#listUsers").jqGrid('navButtonAdd',"#pagerUsers",
			{caption:"",title:"Toggle Search Toolbar", buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ sgrid.toggleToolbar() } }); 
	
	jQuery("#listUsers").jqGrid('navButtonAdd',"#pagerUsers",
		{	caption:"",title:"Clear Search",buttonicon :'ui-icon-refresh', 
			onClickButton:function(){sgrid.clearToolbar() } }); 

	jQuery("#listUsers").jqGrid('filterToolbar'); 

}

</script>

<table id="listUsers"  width="500" class="scroll" style="width:500px;"></table>
<div id="pagerUsers" class="scroll" style="text-align:center;"></div>

<BR><BR>

<?  closeMain(); ?>