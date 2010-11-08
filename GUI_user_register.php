<?
require_once $LeoCodeBase."/CL_mail.php";

// echo "http://".str_replace('//','/',$_SERVER['SERVER_NAME'].getRelMainDir().'/'.$CONF_mainfile).'?op=ref';

openMain(sprintf(_Registration_Form,$CONF['site']['name'] ),0,'');

// now defined in site/predefined/3/config.php
//$CONF['userdb']['users_temp_table']="leonardo_temp_users";

$sql="delete from ".$CONF['userdb']['users_temp_table']." where user_regdate <= '".(time()-(3*60*60))."'";
$db->sql_query($sql); 

// Activate the user account
if( isset($_GET['rkey']) && !($_POST) ){ 

	$sql="select * from ".$CONF['userdb']['users_temp_table']." where user_actkey ='".$_GET['rkey']."'";
	$result = $db->sql_query($sql);
	$user_exist = $db->sql_numrows($result);

	if($user_exist!=1){
		echo "<p align='center'>."._Server_did_not_found_registration."</p>";
		closeMain();return;	
	}
		
	$user=$db->sql_fetchrow($result);

	$sql1="insert into ". $CONF['userdb']['users_table'] .
			" ( user_active, username,  user_password, user_session_time, user_regdate, user_email, user_actkey )
			values  ( '1', '".$user['user_name']."' , '".leonardo_hash($user['user_password'])."',
			'".$user['user_session_time']."', '".time()."', '".$user['user_email']."',  '".$user['user_actkey']."' )"; 
	// echo $sql1;
	$res=$db->sql_query($sql1);
	
	if (!$res) {
		echo "Problem in inserting user into DB: $sql1<BR>";
		closeMain();return;	
	}
	
	$id=$db->sql_nextid();

	if (!$id) {
		echo "Could not get next ID from DB<BR>";
		closeMain();return;	
	}
	
	$sql2="INSERT INTO $pilotsTable (pilotID, countryCode, CIVL_ID, CIVL_NAME, FirstName, LastName, NickName, Birthdate, BirthdateHideMask, Sex) values ('$id','".$user['user_nation']."','".$user['user_civlid']."','".addslashes($user['civlname'])."','".addslashes($user['user_firstname'])."','".addslashes($user['user_lastname'])."','".addslashes($user['user_nickname'])."',
 '". addslashes($user['user_birthdate'])."','xx.xx.xxxx','".( $user['user_gender']==1?'F':'M') ."') "; 
 
	if(! $res=$db->sql_query($sql2)){
		echo "Problem in inserting pilot into DB: $sql2<BR>";
		closeMain();return;	
	}
	
	$sql2="INSERT INTO $pilotsInfoTable (pilotID) values ('$id') "; 
	if(! $res=$db->sql_query($sql2)){
		echo "Problem in inserting pilot into DB: $sql2<BR>";
		closeMain();return;	
	}
	
	// all ok , delete from temp table!
	$sql3="delete from ".$CONF['userdb']['users_temp_table']." where  user_actkey ='".$user['user_actkey']."'";
	$in=$db->sql_query($sql3);
?>

<br>
<table align="center" width="500">
  <tr>
    <td><br>
      <center>
        <strong><?=_Email_confirm_success;?></strong>
      </center>
      <br>
      <table align="center" width="80%">
        <tr class=header>
          <td><u>
            <?=_pilot_email;?>
            </u> </td>
          <td><?=$user['user_email'];?></td>
        </tr>
        <tr class=header>
          <td><u>
            <?=_USERNAME;?>
            </u> </td>
          <td><?=$user['user_name'];?></td>
        </tr>
        <tr class=header>
          <td><u>
            <?=_PILOT_NAME;?>
            </u> </td>
          <td><?=$user['user_lastname'].' '.$user['user_firstname'];?></td>
        </tr>
      </table>
	  
      <div align="center">
	    <br><br>        
        <a href="<?=getLeonardoLink(array('op'=>'login') )?>"><?=_MENU_LOGIN;?></a>
		<br><br>
      </div>
     </td>
  </tr>

</table>
<?		

	closeMain();return;	
}  // $_GET['rkey'];

if($_POST['registerForm']==1){
	$civlid=$_POST['civlid']+0;
	$username=makeSane($_POST['username']);
	
	// various queries in order of searching civlid, email through all database to avoid doubles;
	if($r=_search($_POST['email'],$civlid,$username,'temp')) { 
 
		if ( ($r['user_civlid']==$civlid || $civlid==0) && $r['user_email']==$_POST['email'] ){
			$actkey=$r['user_actkey'] ;       
			$msg= "<p align ='center'>".sprintf(_Pilot_civlid_email_pre_registration,$r['user_name'])."</p>";
			print "<p align ='center'>"._Pilot_have_pre_registration."</p>";
			$email_body=sprintf(_Pilot_confirm_subscription,$CONF['site']['name'],$r['user_name'],
			$_SERVER['SERVER_NAME'],
			str_replace('//','/',$_SERVER['SERVER_NAME'].getRelMainDir().'/'.$CONF_mainfile),
			$actkey );
			LeonardoMail::sendMail('[Leonardo] - Confirmation email',utf8_decode($email_body),$r['user_email'],addslashes($_POST['firstname']));
			unset($actkey);
		} else if($r['user_email']==$_POST['email']  ){
			$msg= "<p align ='center'>".sprintf(_Pilot_email_used_in_pre_reg_dif_civlid,$r['user_name'])." </p>";
		} else if($r['user_civlid']==$civlid && $civlid ){
			$msg= "<p align ='center'>".sprintf(_Pilot_civlid_used_in_pre_reg_dif_email,$r['user_name'])."</p>";
		} else {
			$msg="<p align ='center'>"._Pilot_have_pre_registration."</p>";
		}	
		echo $msg; closeMain(); return;	
	}
		
	if($r=_search($_POST['email'],$civlid,$username,'pilots') && $civlid!=0 ){
	 	//  var_dump($r);
		$msg= "<p align ='center'>".sprintf(_Pilot_already_registered, $r['CIVL_ID'], $r['CIVL_NAME']) ."</p>";	 
		echo $msg; closeMain(); return;
	}
	
    if(!$r=_search($_POST['email'],$civlid,$username,'users')) {
		 
		 $actkey=md5(uniqid(rand(), true));
		 $session_time=time();
		 $sql="INSERT into ".$CONF['userdb']['users_temp_table']."(
		 user_civlid,user_civlname,user_name,user_firstname,user_lastname,user_nickname,
		 user_password,user_nation,user_gender,user_birthdate,user_session_time,
		 user_regdate,user_email,user_actkey )
		 VALUES( 
		 '".$civlid."'
		 , '".addslashes($_POST['civlname'])."'
		 , '".addslashes($_POST['username'])."'
		 , '".addslashes($_POST['firstname'])."'
		 , '".addslashes($_POST['lastname'])."'
		 , '".addslashes($_POST['nickname'])."'
		 , '".addslashes($_POST['password'])."'
		 , '".addslashes($_POST['nation'])."'			 
		 , '".addslashes($_POST['gender'])."'
		 , '".addslashes($_POST['birthdate'])."'
		 , '".$session_time."'
		 , '".time()."'
		 , '".addslashes($_POST['email'])."'
		 , '".$actkey."'
		 )";
		 if( $db->sql_query($sql)) {
			$email_body=sprintf(_Pilot_confirm_subscription,$CONF['site']['name'],$r['user_name'],
				$_SERVER['SERVER_NAME'],
				str_replace('//','/',$_SERVER['SERVER_NAME'].getRelMainDir().'/'.$CONF_mainfile),$actkey );
			LeonardoMail::sendMail('[Leonardo] - Confirmation email',utf8_decode($email_body),$_POST['email'],addslashes($_POST['firstname']));
			
			$msg="<p align='center'>".sprintf(_Server_send_conf_email,$_POST['email'])."</p>";
		 }
    } else {
		 // var_dump($r); 
         $msg="<p align ='center'>". _User_already_registered."</p>"; 
    }  
	      
	echo $msg; closeMain();return;	
	
}



if( !isset($_POST['registerForm'])&& !isset($_GET['rkey'])){

$calLang=$lang2iso[$currentlang];
?>
<script language="javascript"> 

var passwordMinLength='<?=$passwordMinLength?>';
var _PwdTooShort='<?=_PwdTooShort?>';
var _PwdAndConfDontMatch='<?=_PwdAndConfDontMatch?>';
var _MANDATORY_NAME='<?=_MANDATORY_NAME?>';
var _MANDATORY_FIRSTNAME='<?=_MANDATORY_NAME?>';
var _MANDATORY_LASTNAME='<?=_MANDATORY_NAME?>';
var _MANDATORY_FAI_NATION='<?=_MANDATORY_FAI_NATION?>';
var _MANDATORY_GENDER='<?=_MANDATORY_GENDER?>';
var _MANDATORY_BIRTH_DATE_INVALID='<?=_MANDATORY_BIRTH_DATE_INVALID?>';
var _EmailEmpty='<?=_EmailEmpty?>';
var _EmailInvalid='<?=_EmailInvalid?>';
var _MANDATORY_EMAIL_CONFIRM='<?=_MANDATORY_EMAIL_CONFIRM?>';
var _MANDATORY_CIVL_ID='<?=_MANDATORY_CIVL_ID?>';

function setCIVL_ID() {
	window.open('<?=getRelMainDir();?>GUI_EXT_civl_name_search.php?id=check_membership&CIVL_ID_field=civlid&name_field=civlname', '_blank',    'scrollbars=yes,resizable=yes,WIDTH=650,HEIGHT=150,LEFT=100,TOP=100',true);
}


	var imgDir = '<?=moduleRelPath(); ?>/js/cal/';
	var language = '<?=$calLang?>';
	var startAt = 1;		// 0 - sunday ; 1 - monday
	var visibleOnLoad=0;
	var showWeekNumber = 1;	// 0 - don't show; 1 - show
	var hideCloseButton=0;
	var gotoString 		= {<?=$calLang?> : '<?=_Go_To_Current_Month?>'};
	var todayString 	= {<?=$calLang?> : '<?=_Today_is?>'};
	var weekString 		= {<?=$calLang?> : '<?=_Wk?>'};
	var scrollLeftMessage 	= {<?=$calLang?> : '<?=_Click_to_scroll_to_previous_month?>'};
	var scrollRightMessage 	= {<?=$calLang?>: '<?=_Click_to_scroll_to_next_month?>'};
	var selectMonthMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_month?>'};
	var selectYearMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_year?>'};
	var selectDateMessage 	= {<?=$calLang?> : '<?=_Select_date_as_date?>' };
	var	monthName 		= {<?=$calLang?> : new Array(<? foreach ($monthList as $m) echo "'$m',";?>'') };
	var	monthName2 		= {<?=$calLang?> : new Array(<? foreach ($monthListShort as $m) echo "'$m',";?>'')};
	var dayName = {<?=$calLang?> : new Array(<? foreach ($weekdaysList as $m) echo "'$m',";?>'') };

</script>
<script language="javascript" src='<?=getRelMainDir()?>js/civl_search.js'></script>
<script language='javascript' src='<?=getRelMainDir()?>js/cal/popcalendar.js'></script>

<table width='500' cellspacing='2' cellpadding='2' align='center'>
  <tr>
    <td align='left'>
      <ul>
        <li>
          <?=_Requirements?>
          :</li>
        <ul>
        <? if ($CONF['profile']['edit']['force_civl_id']) {?>
          <li>
            <?=_Mandatory_CIVLID;?>
          </li>
        <? } ?>  
          <li>
            <?=_Mandatory_valid_EMAIL;?>
          </li>
          <li>
            <?=_Email_asking_conf;?>
          </li>
          <li>
            <?=_Email_time_conf;?>
          </li>
          <li>
            <?=_After_conf_time;?>
          </li>
          <li>
            <?=_Only_after_time;?>
          </li>
          <li>
            <?=sprintf(_Disable_Anti_Spam,$CONF_admin_email);?>
            </b> </li>
        </ul>
        </li>
      </ul></td>
  </tr>
  <tr>
    <td><?=sprintf(_Search_civl_by_name,"<a href='#' onclick='setCIVL_ID();return false;'>","</a>")?> </td>
  </tr>
  <tr>
    <td><?=sprintf(_Register_civl_as_new_pilot,"<a href='http://civlrankings.fai.org/FL.aspx?a=332' target='_civlrankings'>","</a>");?>  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><form name='registrationForm' method="post" action="">
        <input name="registerForm" type="hidden" value="1">
        <table width="600" cellspacing='2' cellpadding='4'  >
          <tr>
            <td align="right" bgcolor="#FCFCF2"><a href="#" onclick="setCIVL_ID();return false;">
              <?=_MENU_SEARCH_PILOTS;?>
              CIVLID:</a></td>
            <td bgcolor="#FCFCF2"><input type='text' name='civlid' id='civlid' value='' readonly="" size='8'>
            <? if ($CONF['profile']['edit']['force_civl_id']) { ?>
            <font color="#FF2222">***</font>
            <? } ?>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">CIVL
              <?=_PILOT_NAME;?></td>
            <td width="350"><input class="TextoVermelho" size="44" maxlength="50" type="text" name="civlname" value=""  readonly="readonly"/>
            <? if ($CONF['profile']['edit']['force_civl_id']) { ?>
            <font color="#FF2222">***</font>
            <? } ?>
            </td>
          </tr>
          <tr>
            <td width="250" align="right" bgcolor="#FCFCF2"><?=_NICK_NAME;?></td>
            <td width="350" bgcolor="#FCFCF2"><input class="TextoVermelho" maxlength="50" type="text" name="nickname" value=""/>
            </td>
          </tr>
          <tr>
            <td width="250" align="right"><?=_USERNAME;?></td>
            <td width="350"><input class="TextoVermelho" maxlength="50" type="text" name="username" value=""/>
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
          <tr>
            <td width="250" align="right" bgcolor="#FCFCF2" class="TextoP"><?=_LOCAL_PWD;?></td>
            <td width="350" bgcolor="#FCFCF2" class="TextoP"><input class="TextoVermelho" maxlength="50" type="text" name="password" value="">
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td width="250" align="right"><?=_LOCAL_PWD_2;?></td>
            <td width="350"><input class="TextoVermelho" maxlength="50" type="text" name="password2" value="">
              <font color="#FF2222">***</font></td>
          </tr>
		  <tr>
            <td width="250" align="right" bgcolor="#FCFCF2"><?=_First_Name;?>
              ,
              <?=_Last_Name;?></td>
            <td width="350" bgcolor="#FCFCF2"><input class="TextoVermelho" size="20" maxlength="50" type="text" name="firstname" value="">
              <input class="TextoVermelho" size="20" maxlength="50" type="text" name="lastname" value="">
              <font color="#FF2222">***</font></td>
          </tr>
		  <tr>
            <td width="250" align="right"><?=_Sex;?></td>
            <td width="350"><select name="gender" class="TextoVermelho">
                <option value="M">
                <?=_Male;?>
                </option>
                <option value="F">
                <?=_Female;?>
                </option>
              </select>
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#FCFCF2"><?=_Birthdate?></td>
            <td bgcolor="#FCFCF2"><input class="TextoVermelho" size="12" maxlength="12" type="text" name="birthdate" id="birthdate" value="" />
			<a href="javascript:showCalendar(document.registrationForm.cal_button, document.registrationForm.birthdate, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)"> <img src="<? echo $moduleRelPath ?>/img/cal.gif" name='cal_button' width="16" height="16" border="0" id="cal_button" /></a> 
              <font color="#FF2222">***</font></td>
          </tr>
		  <tr>
            <td align="right"><?=_pilot_email;?></td>
            <td><input class="TextoVermelho" size="40" maxlength="50" type="text" name="email" value="" />
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#FCFCF2"><?=_CONFIRM;?>
              <?=_pilot_email;?></td>
            <td bgcolor="#FCFCF2" class="TextoP"><input class="TextoVermelho" size="40" maxlength="50" type="text" name="email2" value="" />
              <font color="#FF2222">***</font></td>
          </tr>
		  <tr>
          <td width="250" align="right" class="TextoP"><?=_SELECT_COUNTRY;?></td>
            <td width="350" class="TextoP"><select name="nation" id="nation" class="TextoVermelho" readonly="readonly"/>
              <option value=""></option>
              <?php
	 			asort($countries);
				foreach ($countries as $key => $value) {						
						echo '<option value="'.$key.'">'.$value.'</option>';
				}
				?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="250">&nbsp;</td>
            <td width="350">&nbsp;</td>
          </tr>
          <td width="600" colspan="2"><div align="center">
                <input class="submit_button" type="button" name="Submit" value=" Submit " onclick="Submit_Form(<?=$CONF['profile']['edit']['force_civl_id']+0?>);"/>
              </div></td>
          </tr>
          <tr>
            <td width="100%"  colspan="2" align="right"><font color="#FF2222">***</font>
              <?=_REQUIRED_FIELD ;?></td>
          </tr>
        </table>
      </form>
	  </td>
  </tr>
</table>
<?  
 
}


function _search($email,$civlid,$username,$tb){
	global $db,$CONF,$pilotsTable;

	// return false;
	
	if($tb=='temp') {
		if ($CONF['profile']['edit']['force_civl_id'] || $civlid) {
			$query="select * from ".$CONF['userdb']['users_temp_table']." where 
					user_name ='$civlid' or user_civlid='$civlid' or user_email='$email' OR user_name='$username' "; 	
		} else {
			$query="select * from ".$CONF['userdb']['users_temp_table']." where user_email='$email' OR user_name='$username' "; 			
		}
	}
			
	if($tb=='pilots') {
		if ($CONF['profile']['edit']['force_civl_id'] || $civlid) {
			$query="select * from $pilotsTable where CIVL_ID ='$civlid'"; 
		} else {
			$query="select * from $pilotsTable where user_name='$username' "; 
		}
	}
		
	if($tb=='users') {
		if ($CONF['profile']['edit']['force_civl_id'] || $civlid) {
			$query="select * from ".$CONF['userdb']['users_table']." where 
				username ='$civlid' or user_civlid='$civlid' or user_email='$email' OR user_name='$username'"; 
		} else {
			$query="select * from ".$CONF['userdb']['users_table']." where user_email='$email' OR user_name='$username'"; 
		}
	}
		
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

?>