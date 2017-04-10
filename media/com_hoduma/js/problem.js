function checkform(closedstatus, require_solution, require_category, require_rep, require_timespent)
{
	//if this is a new problem and if userselect is set, then we don't have to check the uid or email fields - otherwise we do need to validate them
	if(document.getElementById('userselectid') !=null && document.getElementById('userselectid').options[document.getElementById('userselectid').selectedIndex].value < 0)
	{
		//check the uid field
		if(!verifystring(document.getElementById('uidid').value,1,255)){alert('Please enter a username for this problem.');return false;}
		
		//check that the email field looks like an email address
		//note that we need to override the allowance of zero length addresses in the validation function
		var email=document.getElementById('uemailid').value;
		if(email.length<=0 || !isEmail(document.getElementById('uemailid').value)){alert('Please enter a valid email address in the E-Mail field.');return false;}
		
		//check that phone field is either blank or looks like a phone Number
		var phone=document.getElementById('uphoneid').value;
		if(phone.length>0 && !isPhone(phone)){alert('Please enter a valid phone number in the Phone field.');return false;}
	}
	
	//check that, if we are closing the case, that required fields were filled in
	if(document.getElementById('statusid') != null && document.getElementById('statusid').value == closedstatus)
	{
		if(require_solution && document.getElementById('solutiontext').value.length<=0){alert('You must enter a solution before closing a problem.');return false;}
		if(require_timespent && document.getElementById('time_spentid').value <= 0){alert('You must enter a time spent before closing a problem.');return false;}
	}

	//if category or rep should be set, check them
	if(require_category && document.getElementById('categoryid') != null && document.getElementById('categoryid').value == "-1"){alert('You must select a non-default category for new problems.');return false;}
	if(require_rep && document.getElementById('repid') != null && document.getElementById('repid').value == "-1"){alert('You must select a non-default rep for new problems.');return false;}
	
	//now make sure there is a title and description
	if(document.getElementById('titleid') != null && document.getElementById('titleid').value.length<=0){alert('Please enter a title for this problem.');return false;}
	if(document.getElementById('descriptiontext') != null && document.getElementById('descriptiontext').value.length <=0){alert('Please enter a description of the problem.');return false;}

	return true;
}

function setform()
{
	document.getElementById('taskid').value = 'save';
}

function processform(closedstatus, require_solution, require_category, require_rep, require_timespent)
{
	//if we are dealing with a new case, we will have to set some fields first
	if(!checkform(closedstatus, require_solution, require_category, require_rep, require_timespent))
	{
		return false;
	}
	
	//now that we're past our checks, continue processing the form
	setform();
	document.getElementById('problem_formid').submit();
	
	//return true;
}

function searchresults()
{
	document.getElementById('viewid').value='list';
	document.getElementById('taskid').value='results';
}

function deleteattachment(attachmentid)
{
	if(confirm('Are you sure?'))
	{
		//alert('ok');
		document.getElementById('taskid').value = 'deleteattachment';
		document.getElementById('attachment_idid').value = attachmentid;
		document.getElementById('problem_formid').submit();
	}
	else return false;
}
