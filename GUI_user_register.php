<?
require_once $LeoCodeBase."/CL_mail.php";


$CONF['userdb']['users_temp_table']="leonardo_temp_users";

$sql="delete from ".$CONF['userdb']['users_temp_table']." where user_regdate <= '".(time()-(3*60*60))."'";
$db->sql_query($sql); 

if( isset($_GET['rkey']) && !($_POST) ){ 

	$sql="select * from ".$CONF['userdb']['users_temp_table']." where user_actkey ='".$_GET['rkey']."'";
	$result = $db->sql_query($sql);
	$user_exist = $db->sql_numrows($result);

	if($user_exist!=1){
		echo "<p align='center'>."._Server_did_not_found_registration."</p>";
		return;	
	}
		
	$user=$db->sql_fetchrow($result);

	$sql1="insert into ". $CONF['userdb']['users_table'] .
			" ( user_active, username, user_civlid, user_password, user_session_time, user_regdate, user_email, user_actkey )
			values  ( '1', '".$user['user_civlid']."' , '".$user['user_civlid']."' , '".md5($user['user_password'])."',
			'".$user['user_session_time']."', '".time()."', '".$user['user_email']."',  '".$user['user_actkey']."' )"; 
	// echo $sql1;
	$res=$db->sql_query($sql1);
	
	if (!$res) {
		echo "Problem in inserting user into DB: $sql1<BR>";
		return;	
	}
	
	$id=$db->sql_nextid();

	if (!$id) {
		echo "Could not get next ID from DB<BR>";
		return;	
	}
	
	$sql2="insert into $pilotsTable (pilotID, countryCode, CIVL_ID, CIVL_NAME, FirstName, LastName, NickName, Birthdate, BirthdateHideMask, Sex) values ('$id','".$user['user_nation']."','".$user['user_civlid']."','".addslashes($user['user_name'])."','".addslashes($user['user_firstname'])."','".addslashes($user['user_lastname'])."','".addslashes($user['user_nickname'])."',
 '". substr($user['user_birthdate'],6,2)."-".substr($user['user_birthdate'],4,2)."-".substr($user['user_birthdate'],0,4)."','xx.xx.xxxx','".( $user['user_gender']==1?'F':'M') ."') "; 
 
	if(! $res=$db->sql_query($sql2)){
		echo "Problem in inserting pilot into DB: $sql2<BR>";
		return;	
	}
	
	// all ok , delete from temp table!
	$sql3="delete from ".$CONF['userdb']['users_temp_table']." where  user_actkey ='".$user['user_actkey']."'";
	$in=$db->sql_query($sql3);
?>

<br>
<br>
<table align="center" width="50%">
  <tr>
    <td><br>
      <font class=content>
      <center>
        <b>
        <?=_Email_confirm_success;?>
        </b>
      </center>
      <br>
      <table align="center" width="70%">
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
          <td><?=$user['user_civlid'];?></td>
        </tr>
        <tr class=header>
          <td><u>
            <?=_PILOT_NAME;?>
            </u> </td>
          <td><?=$user['user_name'];?></td>
        </tr>
      </table>
      <div align="center"><br>
        <br>
        <center>
        <a href="?op=login">
        <?=_MENU_LOGIN;?>
        </a><br>
        <br>
      </div></td>
  </tr>
  <tr>
    <td class=header>&nbsp;</td>
  </tr>
</table>
<?		

	return;
}  // $_GET['rkey'];





if(!isset($_POST['registerForm'])&& !isset($_GET['rkey'])){

?>
<br>
<br>
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
	window.open('<?=getRelMainDir();?>GUI_EXT_civl_name_search.php?id=check_membership&CIVL_ID_field=civlid&name_field=name', '_blank',    'scrollbars=yes,resizable=yes,WIDTH=650,HEIGHT=150,LEFT=100,TOP=100',true);
}
</script>
<script language="javascript" src="<?=getRelMainDir();?>/js/civl_search.js"></script>
<table width='500' cellspacing='2' cellpadding='2' align='center'>
  <tr>
    <th><?=sprintf(_Registration_Form,$CONF['site']['name'] );?></th>
  </tr>
  <tr>
    <td align='left'><br>
      <ul>
        <li>
          <?=_Requirements?>
          :</li>
        <ul>
          <li>
            <?=_Mandatory_CIVLID;?>
          </li>
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
    <td align="center"><form name='form2' method="post" action="">
        <input name="registerForm" type="hidden" value="1">
        <table width="600" cellspacing='2' cellpadding='2'  >
          <tr>
            <td colspan='2' bgcolor="#DFDFD0">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DFDFD0"><a href="#" onclick="setCIVL_ID();return false;">
              <?=_MENU_SEARCH_PILOTS;?>
              CIVLID:</a></td>
            <td bgcolor="#DFDFD0"><input type='text' name='civlid' id='civlid' value='' readonly="" size='8'></td>
          </tr>
          <tr>
            <td width="250" bgcolor="#DFDFD0">CIVL
              <?=_PILOT_NAME;?></td>
            <td width="350" bgcolor="#DFDFD0"><input class="TextoVermelho" size="44" maxlength="50" type="text" name="name" value=""  readonly="readonly"/>
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td width="250" bgcolor="#DFDFD0"><?=_NICK_NAME;?></td>
            <td width="350" bgcolor="#DFDFD0"><input class="TextoVermelho" maxlength="50" type="text" name="nickname" value=""/>
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td width="250" bgcolor="#DFDFD0"><?=_First_Name;?>
              ,
              <?=_Last_Name;?></td>
            <td width="350" bgcolor="#DFDFD0"><input class="TextoVermelho" size="30" maxlength="50" type="text" name="firstname" value="">
              <input class="TextoVermelho" size="10" maxlength="50" type="text" name="lastname" value="">
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
          <tr>
            <td width="250" bgcolor="#DFDFD0" class="TextoP"><?=_LOCAL_PWD;?></td>
            <td width="350" bgcolor="#DFDFD0" class="TextoP"><input class="TextoVermelho" maxlength="50" type="text" name="password" value="">
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td width="250" bgcolor="#DFDFD0"><?=_LOCAL_PWD_2;?></td>
            <td width="350" bgcolor="#DFDFD0"><input class="TextoVermelho" maxlength="50" type="text" name="password2" value="">
              <font color="#FF2222">***</font></td>
          </tr>
          <td width="250" bgcolor="#DFDFD0"><?=_Sex;?></td>
            <td width="350" bgcolor="#DFDFD0"><select name="gender" class="TextoVermelho">
                <option value="M">
                <?=_Male;?>
                </option>
                <option value="F">
                <?=_Female;?>
                </option>
              </select>
              <font color="#FF2222">***</font></td>
          </tr>
          <td width="250" bgcolor="#DFDFD0" class="TextoP"><?=_Birthdate;?></td>
            <td width="350" bgcolor="#DFDFD0" class="TextoP"><select name="birthday_year" class="TextoVermelho">
                <option value="" selected></option>
                <option value="1930">1930</option>
                <option value="1931">1931</option>
                <option value="1932">1932</option>
                <option value="1933">1933</option>
                <option value="1934">1934</option>
                <option value="1935">1935</option>
                <option value="1936">1936</option>
                <option value="1937">1937</option>
                <option value="1938">1938</option>
                <option value="1939">1939</option>
                <option value="1940">1940</option>
                <option value="1941">1941</option>
                <option value="1942">1942</option>
                <option value="1943">1943</option>
                <option value="1944">1944</option>
                <option value="1945">1945</option>
                <option value="1946">1946</option>
                <option value="1947">1947</option>
                <option value="1948">1948</option>
                <option value="1949">1949</option>
                <option value="1950">1950</option>
                <option value="1951">1951</option>
                <option value="1952">1952</option>
                <option value="1953">1953</option>
                <option value="1954">1954</option>
                <option value="1955">1955</option>
                <option value="1956">1956</option>
                <option value="1957">1957</option>
                <option value="1958">1958</option>
                <option value="1959">1959</option>
                <option value="1960">1960</option>
                <option value="1961">1961</option>
                <option value="1962">1962</option>
                <option value="1963">1963</option>
                <option value="1964">1964</option>
                <option value="1965">1965</option>
                <option value="1966">1966</option>
                <option value="1967">1967</option>
                <option value="1968">1968</option>
                <option value="1969">1969</option>
                <option value="1970">1970</option>
                <option value="1971">1971</option>
                <option value="1972">1972</option>
                <option value="1973">1973</option>
                <option value="1974">1974</option>
                <option value="1975">1975</option>
                <option value="1976">1976</option>
                <option value="1977">1977</option>
                <option value="1978">1978</option>
                <option value="1979">1979</option>
                <option value="1980">1980</option>
                <option value="1981">1981</option>
                <option value="1982">1982</option>
                <option value="1983">1983</option>
                <option value="1984">1984</option>
                <option value="1985">1985</option>
                <option value="1986">1986</option>
                <option value="1987">1987</option>
                <option value="1988">1988</option>
                <option value="1989">1989</option>
                <option value="1990">1990</option>
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
              </select>
              <select name="birthday_month" class="TextoVermelho">
                <option value="" selected></option>
                <option value="01">
                <?=$monthListShort[0]?>
                </option>
                <option value="02">
                <?=$monthListShort[1]?>
                </option>
                <option value="03">
                <?=$monthListShort[2]?>
                </option>
                <option value="04">
                <?=$monthListShort[3]?>
                </option>
                <option value="05">
                <?=$monthListShort[4]?>
                </option>
                <option value="06">
                <?=$monthListShort[5]?>
                </option>
                <option value="07">
                <?=$monthListShort[6]?>
                </option>
                <option value="08">
                <?=$monthListShort[7]?>
                </option>
                <option value="09">
                <?=$monthListShort[8]?>
                </option>
                <option value="10">
                <?=$monthListShort[9]?>
                </option>
                <option value="11">
                <?=$monthListShort[10]?>
                </option>
                <option value="12">
                <?=$monthListShort[11]?>
                </option>
              </select>
              <select name="birthday_day" class="TextoVermelho">
                <option value="" selected></option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select>
              <font color="#FF2222">***</font> </td>
          </tr>
          <tr>
            <td bgcolor="#DFDFD0"><?=_pilot_email;?></td>
            <td bgcolor="#DFDFD0"><input class="TextoVermelho" size="40" maxlength="50" type="text" name="email" value="" />
              <font color="#FF2222">***</font></td>
          </tr>
          <tr>
            <td bgcolor="#DFDFD0"><?=_CONFIRM;?>
              <?=_pilot_email;?></td>
            <td bgcolor="#DFDFD0" class="TextoP"><input class="TextoVermelho" size="40" maxlength="50" type="text" name="email2" value="" />
              <font color="#FF2222">***</font></td>
          </tr>
          <td width="250" bgcolor="#DFDFD0" class="TextoP"><?=_SELECT_COUNTRY;?></td>
            <td width="350" bgcolor="#DFDFD0" class="TextoP"><select name="nation" id="nation" class="TextoVermelho" readonly="readonly"/>
              
              <?php
					foreach ($countries as $key => $value) {						
						echo '<option value="'.$key.'">'.$value.'</option>';
					}
								
/*
 print "<option value='".F322('',1). $sel ."'>".F322('',3)."</option>\n"; 
while(list($k,$e)=each($countries)){
    print "<option value='".F322($k,1). $sel ."'>".$e."</option>\n";
} 
*/   
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
          <tr>
            <td width="100%" bgcolor="#DFDFD0"  colspan="2"><font color="#FF2222">***</font>
              <?=_REQUIRED_FIELD ;?></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?    
}
if($_POST['registerForm']==1){
 // various queries in order of searching civlid, email through all database to avoid doubles;
 if(!$r=_search($_POST['email'],$_POST['civlid'],'temp')){
 
     if(!$r=_search($_POST['email'],$_POST['civlid'],'pilots')){
 
         if(!$r=_search($_POST['email'],$_POST['civlid'],'users')) {
		 
             $actkey=md5(uniqid(rand(), true));
             $session_time=time();
             $sql="INSERT into ".$CONF['userdb']['users_temp_table']."(
             user_civlid,
             user_name,
             user_firstname,
             user_lastname,
             user_nickname,
             user_password,
             user_nation,
             user_gender,
             user_birthdate,
             user_session_time,
             user_regdate,
             user_email,
             user_actkey)
             VALUES( 
             '".$_POST['civlid']."'
             , '".addslashes($_POST['name'])."'
             , '".addslashes($_POST['firstname'])."'
             , '".addslashes($_POST['lastname'])."'
             , '".addslashes($_POST['nickname'])."'
             , '".addslashes($_POST['password'])."'
             , '".addslashes($_POST['nation'])."'			 
             , '".addslashes($_POST['gender'])."'
             , '".$_POST['birthday_year'].$_POST['birthday_month'].$_POST['birthday_day']."'
             , '".$session_time."'
             , '".time()."'
             , '".addslashes($_POST['email'])."'
             , '".$actkey."'
             )";
             if( $db->sql_query($sql))
             {
				$email_body=sprintf(_Pilot_confirm_subscription,$CONF['site']['name'],$r['user_name'],$_SERVER['HTTP_HOST'],$_SERVER['HTTP_HOST'].$PHP_SELF,$actkey );
				LeonardoMail::sendMail('[Leonardo] - Confirmation email',utf8_decode($email_body),$_POST['email'],addslashes($_POST['name']));
				
				$msg="<p align='center'>".sprintf(_Server_send_conf_email,$_POST['email'])."</p>";
             }
         } else {
		     // var_dump($r); 
             $msg="<p align ='center'>". _User_already_registered."</p>"; 
         }    
     } else{
		 //  var_dump($r);
		 $msg= "<p align ='center'>".sprintf(_Pilot_already_registered, $r['CIVL_ID'], $r['CIVL_NAME']) ."</p>";
     }  
	 
	 
} else {

    if ($r['user_civlid']==$_POST['civlid'] && $r['user_email']==$_POST['email'] ){
		$actkey=$r[$actkey] ;       
		$msg= "<p align ='center'>".sprintf(_Pilot_civlid_email_pre_registration,$r['user_name'])."</p>";
		print "<p align ='center'>"._Pilot_have_pre_registration."</p>";
		$email_body=sprintf(_Pilot_confirm_subscription,$CONF['site']['name'],$r['user_name'],$_SERVER['HTTP_HOST'],$_SERVER['HTTP_HOST'].$PHP_SELF,$actkey );
		LeonardoMail::sendMail('[Leonardo] - Confirmation email',utf8_decode($email_body),$r['user_email'],addslashes($_POST['name']));
		unset($actkey);
    } else if($r['user_email']==$_POST['email'] || $r['user_civlid']!=$_POST['civlid']){
		$msg= "<p align ='center'>".sprintf(_Pilot_email_used_in_pre_reg_dif_civlid,$r['user_name'])." </p>";
    } else if($r['user_email']!=$_POST['email'] || $r['user_civlid']==$_POST['civlid']){
	    $msg= "<p align ='center'>".sprintf(_Pilot_civlid_used_in_pre_reg_dif_email,$r['user_name'])."</p>";
    }
  
}
 print $msg; 
}

function _search($email,$civlid,$tb){
	global $db,$CONF,$pilotsTable;

	// return false;
	
	if($tb=='temp')
		$query="select * from ".$CONF['userdb']['users_temp_table']." where user_name ='$civlid' or user_civlid='$civlid' or user_email='$email'"; 
	if($tb=='pilots')
		$query="select * from $pilotsTable where CIVL_ID ='$civlid'"; 
		
	if($tb=='users')
		$query="select * from ".$CONF['userdb']['users_table']." where username ='$civlid' or user_civlid='$civlid' or user_email='$email'"; 
		
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