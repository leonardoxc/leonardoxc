


function checkdate(input){
	var validformat=/^\d{2}\.\d{2}\.\d{4}$/ ;//Basic check for format validity
    var dayfield=input.split(".")[0];
    var monthfield=input.split(".")[1];
    var yearfield=input.split(".")[2];
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
		if(msg.length==0 && trim(document.registrationForm.password.value).length==0){
			msg=_PwdTooShort;
			document.registrationForm.password.focus();
		}
		if(msg.length==0 && trim(document.registrationForm.password.value).length< passwordMinLength){
			msg=_PwdTooShort;
			document.registrationForm.password.focus();
		}
		if(MWJ_findObj('password2',null,window.document)){
			if(msg.length==0 && trim(document.registrationForm.password.value)!=trim(document.registrationForm.password2.value)){
				msg=_PwdAndConfDontMatch;
				document.registrationForm.password2.focus();
			}
		}
    }
    if(msg.length==0 && trim(document.registrationForm.username.value).length==0){
    	msg=_MANDATORY_USERNAME;
    	document.registrationForm.name.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.firstname.value).length==0){
    	msg=_MANDATORY_FIRSTNAME;
    	document.registrationForm.firstname.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.lastname.value).length==0){
    	msg=_MANDATORY_LASTNAME;
    	document.registrationForm.lastname.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.nation.value).length==0){
    	msg=_MANDATORY_FAI_NATION;
    	document.registrationForm.nation.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.gender.value).length==0){
    	msg=_MANDATORY_GENDER;
    	document.registrationForm.gender.focus();
    }
	
    if(msg.length==0 && !checkdate(document.registrationForm.birthdate.value )){
    	msg=_MANDATORY_BIRTH_DATE_INVALID;
    }
    if(msg.length==0 && trim(document.registrationForm.email.value).length==0){
    	msg=_EmailEmpty;
    }
    if (msg.length==0 && echeck(document.registrationForm.email.value)==false){
        msg=_EmailInvalid;
        document.registrationForm.email.value=""
        document.registrationForm.email.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.email.value)!=trim(document.registrationForm.email2.value)){
    	msg=_MANDATORY_EMAIL_CONFIRM;
    	document.registrationForm.email2.focus();
    }
    if(msg.length==0 && trim(document.registrationForm.civlid.value).length==0){
    	msg=_MANDATORY_CIVL_ID;
    }
    if(msg.length>0){
    	alert(msg);
    } else {
    	document.registrationForm.submit();
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

