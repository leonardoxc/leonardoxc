<?
require_once $LeoCodeBase."/CL_mail.php";
require_once $LeoCodeBase."/CL_NACclub.php";
require_once dirname(__FILE__)."/CL_user.php";
require_once dirname(__FILE__)."/lib/json/CL_json.php";

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
	
	$sql2="INSERT INTO $pilotsTable (pilotID, countryCode, CIVL_ID, CIVL_NAME,
	 NACid,NACmemberID,NACclubID,
	FirstName, LastName, NickName, Birthdate, BirthdateHideMask, Sex)
	values ('$id','".$user['user_nation']."','".$user['user_civlid']."','".addslashes($user['civlname'])."',

	'".addslashes($user['NACid'])."',
	'".addslashes($user['NACmemberID'])."',
	'".addslashes($user['NACclubID'])."',

	'".addslashes($user['user_firstname'])."','".addslashes($user['user_lastname'])."','".addslashes($user['user_nickname'])."',
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

    if( $CONF_use_NAC &&  $CONF['NAC']['id_mandatory'] ) {

        if (!$_POST['NACid'] || ! $_POST['NACmemberID'] ) {
            $msg= '<span class="alert">You must provide a valid NAC and NAC membership</span>';
            echo $msg; closeMain(); return;
        }


    }

	if($r=_search($_POST['email'],$civlid,$username,'pilots') && $civlid!=0 ){
	 	//  var_dump($r);
		$msg= "<p align ='center'>".sprintf(_Pilot_already_registered, $r['CIVL_ID'], $r['CIVL_NAME']) ."</p>";	 
		echo $msg; closeMain(); return;
	}


    if(!$r=_search($_POST['email'],$civlid,$username,'users')) {

        $NACid=$_POST['NACid']+0;
        $NACmemberID=$_POST['NACmemberID']+0;
        if ($NACmemberID<=0) $NACid=0;

        $NACclubID=$_POST['NACclubID']+0;
        if ($NACid==0) $NACclubID=0;


		 $actkey=md5(uniqid(rand(), true));
		 $session_time=time();
		 $sql="INSERT into ".$CONF['userdb']['users_temp_table']."(
		 user_civlid,user_civlname,
		 NACid,NACmemberID,NACclubID,
		 user_name,user_firstname,user_lastname,user_nickname,
		 user_password,user_nation,user_gender,user_birthdate,user_session_time,
		 user_regdate,user_email,user_actkey )
		 VALUES( 
		 '".$civlid."'
		 , '".addslashes($_POST['civlname'])."'

		 , '".addslashes($NACid)."'
		 , '".addslashes($NACmemberID)."'
		  , '".addslashes($NACclubID)."'

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

    var force_nac_id=<? echo $CONF['NAC']['id_mandatory'] +0 ; ?>;

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


    <?

    # Changes Martin Jursa 09.03.2007:
    # in case certain fields are set by an external tool, these fields will be set readonly
    # otherwise, they can be edited
    # $possible_readonly_fields contains all the fields for which this readonly mechanism is available
    $readonly_fields=$CONF['profile']['edit']['readonlyFields'];
    //$readonly_fields=array('LastName', 'FirstName');
    if ($CONF_use_NAC) {
        $readonly_fields=array();
        $list1=$list2=$list3='';
        $possible_readonly_fields=array('NACmemberID', 'LastName', 'FirstName', 'Birthdate', 'CIVL_ID');
        $list4="var all_readonly_fields  = '".implode(',', $possible_readonly_fields)."';\n";

        foreach  ($CONF_NAC_list as $NACid=>$NAC) {

            $NAC_input_url=$NAC['input_url'];
            if ( preg_match_all("/#([^#]+)#/",$NAC_input_url,$matches_tmp1) ) {
                //print_r($matches_tmp1);
                foreach($matches_tmp1[1] as $paramName) {
                    //echo "!!$NAC_input_url@@$paramName@@".$pilot[$paramName]."^^";
                    $NAC_input_url=str_replace('#'.$paramName.'#',$pilot[$paramName],$NAC_input_url);
                }
            }

            $list1.="NAC_input_url[$NACid]  = '".json::prepStr($NAC_input_url)."';\n";
            $ext_input=empty($NAC['external_input']) ? 0 : 1;
            $list2.="NAC_external_input[$NACid]  = $ext_input;\n";
            $use_clubs=$NAC['use_clubs']+0;
            $list2.="NAC_use_clubs[$NACid]  = $use_clubs;\n";

            $list2.="NAC_select_clubs[$NACid]  = ".( ( $NAC['club_change_period_active'] ||
                    ($NAC['add_to_club_period_active'] && !$pilot['NACclubID'] )||
                    L_auth::isAdmin($userID)|| L_auth::isModerator($userID) )? 1 : 0).";\n";

            $externalfields=!empty($NAC['external_fields']) ? $NAC['external_fields'] : '';
            if ($ext_input && !empty($NAC['external_fields'])) {
                $list3.="NAC_external_fields[$NACid] = '$externalfields';\n";
                if ($pilot['NACid']==$NACid) {
                    $tmp_fields=explode(',', $externalfields);
                    foreach ($tmp_fields as $fld) {
                        if (in_array($fld, $possible_readonly_fields)) $readonly_fields[]=$fld;
                    }
                }
            }
        }

    }
    ?>
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

          <? if ($CONF_use_NAC && $CONF['NAC']['id_mandatory']) {
              ?>
          <tr>
            <td width="250" align="right">
           <?

              echo _MEMBER_OF."</td><td>";

              /*foreach  ($CONF_NAC_list as $NACid=>$NAC) {
                  $list1.="NAC_input_url[$NACid]  = '".$NAC['input_url']."';\n";
                  $list2.="NAC_id_input_method[$NACid]  = '".$NAC['id_input_method']."';\n";
              }
              */
              ?>
              <script type="text/javascript" language="javascript">
                  var NAC_input_url= [];
                  var NAC_external_input= [];
                  var NAC_external_fields= [];
                  var NAC_use_clubs=[];
                  var NAC_select_clubs=[];
                  var NACid=0;
                  <?=$list1.$list2.$list3.$list4 ?>
                  var NAC_club_input_url="<? echo $moduleRelPath."/GUI_EXT_set_club.php"; ?>";

                  function changeNAC() {
                      var mid=MWJ_findObj("NACmemberID");
                      mid.value="";

                      var sl=MWJ_findObj("NACid");
                      NACid= sl.options[sl.selectedIndex].value ;    // Which menu item is selected
                      if (NACid==0) {
                          MWJ_changeDisplay("mID","none");
                      } else {
                          MWJ_changeDisplay("mID","inline");
                          if (NAC_external_input[NACid]) {
                              MWJ_changeDisplay("mIDselect","block");
                          }else {
                              MWJ_changeDisplay("mIDselect","none");
                          }
                      }

                      if (NAC_use_clubs[NACid]) {
                          MWJ_changeDisplay("mClubSelect","block");
                          if (NAC_select_clubs[NACid]) {
                              MWJ_changeDisplay("mClubLink","inline");
                          }
                      } else  {
                          MWJ_changeDisplay("mClubSelect","none");
                          MWJ_changeDisplay("mClubLink","none");
                      }

                      var flds=all_readonly_fields.split(',');
                      for (var i=0; i<flds.length; i++) {
                      //    document.forms[0].elements[flds[i]].readOnly=false;
                      }
                      if (NACid!=0 && NAC_external_fields[NACid]) {
                          flds=NAC_external_fields[NACid].split(',');
                          for (var i=0; i<flds.length; i++) {
                              document.forms[0].elements[flds[i]].readOnly=true;
                          }
                      }
                  }

                  function setID() {
                      if 	(NACid>0) {
                          window.open(NAC_input_url[NACid], '_blank',	'scrollbars=no,resizable=yes,WIDTH=700,HEIGHT=400,LEFT=100,TOP=100',false);
                      }
                  }

                  function setClub() {
                      if 	(NACid>0) {
                          var NACclubID_fld	=MWJ_findObj("NACclubID");
                          var NACclubID		=NACclubID_fld.value;
                          window.open(NAC_club_input_url+'?NAC_ID='+NACid+'&clubID='+NACclubID, '_blank',	'scrollbars=no,resizable=yes,WIDTH=500,HEIGHT=420,LEFT=100,TOP=100',false);
                      }
                  }
              </script>
              <?
              echo "<select name='NACid' id='NACid' onchange='changeNAC(this)'>";
              echo "<option value='0'></option>";
              foreach  ($CONF_NAC_list as $NACid=>$NAC) {
                  if ($pilot['NACid']==$NACid) $sel=" selected ";
                  else $sel="";
                  echo "<option $sel value='$NACid'>".
                      ( $NAC['localLanguage']!=$currentlang?$NAC['name']:$NAC['localName'])."</option>\n";

              }

              echo "</select>";
              echo '<font color="#FF2222">***</font>';
              foreach  ($CONF_NAC_list as $NACid=>$NAC) {
                  if ($NAC['description']) {
                      echo "<div style='background:#d0d0d0; padding:10px; ' >".$NAC['description']."</div> ";
                  }
              }

              echo "<div id='mID' style='display:".(($pilot['NACid']==0) ? "none" : "inline")."'> ";
              $memberid_readonly=in_array('NACmemberID', $readonly_fields) ? 'readonly' : '';
              echo "<span style='white-space:nowrap'>"._MemberID.": <input size='5' type='text' name='NACmemberID' value='".$pilot['NACmemberID']."' $memberid_readonly  /></span> ";

              echo '<font color="#FF2222">***</font>';
              echo "<div id='mIDselect' style='display:".($memberid_readonly ? "block" : "none")."'> ";
              echo "[&nbsp;<a href='#' onclick=\"setID();return false;\">"._EnterID."</a>&nbsp;]";
              echo "</div>";


              echo "<div align=left id='mClubSelect' style='display:".( $CONF_NAC_list[$pilot['NACid']]['use_clubs']?"block":"none" )."' >"._Club." ";
              $NACclub=NACclub::getClubName($pilot['NACid'],$pilot['NACclubID']);

              if ( $CONF_NAC_list[$pilot['NACid']]['club_change_period_active'] ||
                  ( $CONF_NAC_list[$pilot['NACid']]['add_to_club_period_active']  && !$pilot['NACclubID'] ) ||
                  L_auth::isAdmin($userID) || L_auth::isModerator($userID)
              ) $showChangeClubLink="inline";
              else $showChangeClubLink="none";
              echo "<div id=\"mClubLink\" style=\"display: $showChangeClubLink\">[ <a href='#' onclick=\"setClub();return false;\">"._Select_Club."</a> ]</div>";
              /*

                              echo "[ <a href='#' onclick=\"setClub();return false;\">"._Select_CLub."</a> ]";
                          } else {
                              echo "";
                          }
              */
              echo "<br><input  type='hidden' name='NACclubID' value='".$pilot['NACclubID']."' /> ";
              echo "<input  type='text' size='50' name='NACclub' value='".$NACclub."' readonly /></div> ";

              echo "</div>";

              echo "</td></tr>";

          } else { ?>
              <input type="hidden" name="NACid" value="<?=$pilot['NACid']?>" />
              <input type="hidden" name="NACmemberID" value="<?=$pilot['NACmemberID']?>" />
              <input type="hidden" name="NACclubID" value="<?=$pilot['NACclubID']?>" />
          <? }

          ?>


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