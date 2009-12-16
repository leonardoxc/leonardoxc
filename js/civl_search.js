


function checkdate(input){
var validformat=/^\d{2}\/\d{2}\/\d{4}$/ ;//Basic check for format validity
    var monthfield=input.value.split("/")[0];
    var dayfield=input.value.split("/")[1];
    var yearfield=input.value.split("/")[2];
    var dayobj = new Date(yearfield, monthfield-1, dayfield);
    if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)){
    return false;
}else{
        return true;
    }
}
function trim(str){
    if(undefined == str){
    var ax='';
    return ax;
     }else{
    var ax=str.replace(/^\s+|\s+$/g,"")
    return ax;
    }
}
function Submit_Form(){
    var msg='';
    if(MWJ_findObj('password',null,window.document)){
		if(msg.length==0 && trim(document.form2.password.value).length==0){
			msg=_PwdTooShort;
			document.form2.password.focus();
		}
		if(msg.length==0 && trim(document.form2.password.value).length< passwordMinLength){
			msg=_PwdTooShort;
			document.form2.password.focus();
		}
		if(MWJ_findObj('password2',null,window.document)){
			if(msg.length==0 && trim(document.form2.password.value)!=trim(document.form2.password2.value)){
				msg=_PwdAndConfDontMatch;
				document.form2.password2.focus();
			}
		}
    }
    if(msg.length==0 && trim(document.form2.name.value).length==0){
    	msg=_MANDATORY_USERNAME;
    	document.form2.name.focus();
    }
    if(msg.length==0 && trim(document.form2.firstname.value).length==0){
    	msg=_MANDATORY_FIRSTNAME;
    	document.form2.firstname.focus();
    }
    if(msg.length==0 && trim(document.form2.lastname.value).length==0){
    	msg=_MANDATORY_LASTNAME;
    	document.form2.lastname.focus();
    }
    if(msg.length==0 && trim(document.form2.nation.value).length==0){
    	msg=_MANDATORY_FAI_NATION;
    	document.form2.nation.focus();
    }
    if(msg.length==0 && trim(document.form2.gender.value).length==0){
    	msg=_MANDATORY_GENDER;
    	document.form2.gender.focus();
    }
    dta=new Object();
    dta.value =document.form2.birthday_month.value +"/"+ document.form2.birthday_day.value +"/"+ document.form2.birthday_year.value;
    if(msg.length==0 && !checkdate(dta)){
    	msg=_MANDATORY_BIRTH_DATE_INVALID;
    }
    if(msg.length==0 && trim(document.form2.email.value).length==0){
    	msg=_EmailEmpty;
    }
    if (msg.length==0 && echeck(document.form2.email.value)==false){
        msg=_EmailInvalid;
        document.form2.email.value=""
        document.form2.email.focus();
    }
    if(msg.length==0 && trim(document.form2.email.value)!=trim(document.form2.email2.value)){
    	msg=_MANDATORY_EMAIL_CONFIRM;
    	document.form2.email2.focus();
    }
    if(msg.length==0 && trim(document.form2.civlid.value).length==0){
    	msg=_MANDATORY_CIVL_ID;
    }
    if(msg.length>0){
    	alert(msg);
    } else {
    	document.form2.submit();
    }
}


function echeck(str) {

        var at="@"
        var dot="."
        var lat=str.indexOf(at)
        var lstr=str.length
        var ldot=str.indexOf(dot)
        if (str.indexOf(at)==-1){
           return false
        }

        if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
           return false
        }

        if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
            return false
        }

         if (str.indexOf(at,(lat+1))!=-1){
            return false
         }

         if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
            return false
         }

         if (str.indexOf(dot,(lat+2))==-1){
            return false
         }

         if (str.indexOf(" ")!=-1){
            return false
         }

          return true
    }

/*function ValidateForm(){
    var emailID=document.frmSample.txtEmail

    if ((emailID.value==null)||(emailID.value=="")){
        alert("Please Enter your Email ID")
        emailID.focus()
        return false
    }
    if (echeck(emailID.value)==false){
        emailID.value=""
        emailID.focus()
        return false
    }
    return true
 } */

