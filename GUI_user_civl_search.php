<?php

$CONF['userdb']['users_temp_table']="leonardo_temp_users";
function _search($email,$civlid,$tb){
	global $db,$CONF,$pilotsTable,$userID;

	if($tb=='temp')
		$query="select * from ".$CONF['userdb']['users_temp_table']." where user_name ='$civlid' or user_civlid='$civlid' or user_email='$email'"; 
	if($tb=='pilots')
		$query="select * from $pilotsTable where pilotID<>$userID and CIVL_ID ='$civlid'"; 

	if($tb=='users')
		$query="select * from ".$CONF['userdb']['users_table']." where user_id<>$userID, username ='$civlid' or user_civlid='$civlid' or user_email='$email'"; 
		
	 if($query!=''){
		 $res=$db->sql_query($query);
		 $nr=$db->sql_numrows($res);
		 if($nr>0){
			 return mysql_fetch_assoc($res) ;
		 }else{
			 return false;
		 }
	 }
 }
 
if(!isset($_POST['registerForm'])){

?>
<script language="javascript"> 

var passwordMinLength='<?=$passwordMinLength?>';
var _PwdTooShort='<?=_PwdTooShort?>';
var _PwdAndConfDontMatch='<?=_PwdAndConfDontMatch?>';
var _MANDATORY_NAME='<?=_MANDATORY_NAME?>';
var _MANDATORY_FAI_NATION='<?=_MANDATORY_FAI_NATION?>';
var _MANDATORY_GENDER='<?=_MANDATORY_GENDER?>';
var _MANDATORY_BIRTH_DATE_INVALID='<?=_MANDATORY_BIRTH_DATE_INVALID?>';
var _EmailEmpty='<?=_EmailEmpty?>';
var _EmailInvalid='<?=_EmailInvalid?>';
var _MANDATORY_EMAIL_CONFIRM='<?=_MANDATORY_EMAIL_CONFIRM?>';
var _MANDATORY_CIVL_ID='<?=_MANDATORY_CIVL_ID?>';

function setCIVL_ID() {
	window.open('<?=getRelMainDir();?>/GUI_EXT_civl_name_search.php?CIVL_ID_field=CIVL_ID&gender_field=gender&nation_field=nation&name_field=name', '_blank',    'scrollbars=yes,resizable=yes,WIDTH=650,HEIGHT=150,LEFT=100,TOP=100',true);
}
</script>
<script language="javascript" src="<?=getRelMainDir();?>/js/civl_search.js"></script>
<?
  openMain(sprintf(_Attention_mandatory_to_have_civlid,$CONF['site']['name']),0,''); 
?>
<table width='500' cellspacing='2' cellpadding='2' align='center'>
<tr><th><?=sprintf(_Attention_mandatory_to_have_civlid,$CONF['site']['name']);?></th></tr> 

<tr><td><?=_If_you_agree?></td></tr>
<tr><td><?=sprintf(_Search_civl_by_name,"<a href='#' onclick='setCIVL_ID();return false;'>","</a>")?>
</td></tr><tr><td>
<?=sprintf(_Register_civl_as_new_pilot,"<a href='http://civlrankings.fai.org/FL.aspx?a=332' target='_civlrankings'>","</a>")?> 
</td></tr> 
<tr><td>&nbsp;</td></tr>
<tr><td align="center">
<form name='form2' method="post" action="?op=users&page=index&act=register">
<input name="registerForm" type="hidden" value="1">
<table width="600" cellspacing='2' cellpadding='2'  >
<tr><td colspan='2' bgcolor="#DFDFD0">&nbsp;</td></tr>
<tr><td bgcolor="#DFDFD0"><a href="#" onclick="setCIVL_ID();return false;"><?=_MENU_SEARCH_PILOTS;?> CIVLID:</a></td> <td bgcolor="#DFDFD0"> <input type='text' name='CIVL_ID' id='CIVL_ID' value='' readonly="" size='8'></td></tr>
<tr>
    <td width="250" bgcolor="#DFDFD0">CIVL <?=_PILOT_NAME;?></td>
    <td width="350" bgcolor="#DFDFD0"><input class="TextoVermelho" size="44" maxlength="50" type="text" name="name" value=""  readonly="readonly"/></td>
  </tr>
<tr>
    <td width="250" bgcolor="#DFDFD0">CIVL <?=_Sex;?></td>
    <td width="350" bgcolor="#DFDFD0">
      <select name="gender" id="gender" class="TextoVermelho" >
        <option value="M"><?=_Male;?></option>
        <option value="F"><?=_Female;?></option>
      </select></td>
</tr>

<tr>
     <td width="250" bgcolor="#DFDFD0" class="TextoP">CIVL <?=_SELECT_COUNTRY;?></td>
    <td width="350" bgcolor="#DFDFD0" class="TextoP">
    <select name="nation" id="nation" class="TextoVermelho" />
    <?php
		foreach ($countries as $key => $value) {						
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	?>
</select>
</td>
  </tr> 
  <tr>
    <td width="250" bgcolor="#DFDFD0">&nbsp;</td>
    <td width="350" bgcolor="#DFDFD0">&nbsp;</td>
  </tr>
 <td width="600" colspan="2"><div align="center">
 <input class="submit_button" type="button" name="Submit" value=" Submit " onclick="Submit_Form();"/>
 </div></td>
  </tr>
 
</table>

</form>
</td></tr>
</table>
<?php

	closeMain();
}
if($_POST['registerForm']==1){
    if(!$r=_search($_POST['email'],$_POST['civlid'],'temp'))
    {
        if(!$r=_search('',$_POST['civlid'],'pilots')) // in this particular $userID
        {
            if(!$r=_search($_POST['email'],$_POST['civlid'],'users')) // in this particular $userID
            { 
             // founded none in our database
             // update tables $pilotsTable $CONF['userdb']['users_table'] whith posted form
             $sql1="update ". $CONF['userdb']['users_table'] ."  set user_civlid='".$_POST['civlid']."', 
             user_email='".$_POST['email']."' where user_id=$userID";
             if($db->sql_query($sql1))
             {
                $civlID=$_POST['civlid'];
                $sql2="select pilotID from $pilotsTable where pilotID=$userID";
                $result = $db->sql_query($sql2);
                $user_exist = $db->sql_numrows($result);
                if($user_exist) {
                     $sql3="update $pilotsTable set CIVL_ID='".$_POST['civlid']."', CIVL_NAME='".addslashes($_POST['name'])."'WHERE  pilotID='$userID' ";
                     if($db->sql_query($sql3))
                     {                       
                        Print "<p align='center'>"._Success_login_civl_or_user."</p>";
                     }
                }
              }               
            }else{
                // user Found in the users table
                if($r['user_email']==$_POST['email'] && $r['user_civlid']==$_POST['civlid'])
                {
                    unset($header);
                    $msg="<p align='center'>"._User_already_registered."</p>";
                }
                else if($r['user_email']==$_POST['email'] || $r['user_civlid']!=$_POST['civlid'])
                {
                    unset($header);
                    $msg= "<p align ='center'>".sprintf(_Pilot_email_used_in_reg_dif_civlid,$r['user_name'])."</p>";
                }
                else if($r['user_email']!=$_POST['email'] || $r['user_civlid']==$_POST['civlid'])
                {
                    unset($header);
                    $msg= "<p align ='center'>".sprintf(_Pilot_email_used_in_reg_dif_civlid,$r['user_name'])."</p>";
                }
            }
        }else{
            // user found in the pilots table
            unset($header);
               $msg= "<p align ='center'>"._Civlid_already_in_use."</p>";
        }
     }else{ // user founded in the temp_table 
        if($r['user_email']==$_POST['email'] && $r['user_civlid']==$_POST['civlid'])
        {
            unset($header);
         $msg="<p align='center'>"._Pre_registration_founded."</p>";
         }
         else if($r['user_email']==$_POST['email'] || $r['user_civlid']!=$_POST['civlid'])
         {
             unset($header);
            $msg= "<p align ='center'>".sprintf(_Pilot_email_used_in_pre_reg_dif_civlid,$r['user_name'])."</p>";
         }
         else if($r['user_email']!=$_POST['email'] || $r['user_civlid']==$_POST['civlid'])
         {
             unset($header);
            $msg= "<p align ='center'>".sprintf(_Pilot_civlid_used_in_pre_reg_dif_email,$r['user_name'])."Olá " .$r['user_name']."</p>";
         }    
    }
    if(!isset($header)){
    print $msg;   
    }else{
    $url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : $header;
                                                
                        ?>
                        <script language="javascript">window.location="<?=$url?>"; </script>
                        <?
    }      
}
?>