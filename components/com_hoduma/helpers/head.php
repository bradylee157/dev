<?php
/**
 * @package Hoduma
 * @copyright Copyright (c)2012 Hoduma.com, (c)2009-2011 Huru Helpdesk Developers
 * @license GNU General Public License version 3, or later
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
*/

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

//set to TRUE to enable internal debugging output on certain pages
define("DEBUG",false,true);

//set to TRUE to disable certain functions that shouldn't be available for demo
define("DEMO",false,true);

//this is here because we want to include the base functions of this feature 
//in our code but don't have the helpers done yet.  Putting in the code but disabling
//for now will allow us to publish the helper seperately at a later time.
//Setting to true will enable the feature
define("IMAP",true,true);

//set length of random string in file system attachments
define("FILESYSATTRANDOM",20,true);

//app-wide constants
define("USER_LEVEL_ADMIN",100,true);
define("USER_LEVEL_REP",50,true);
define("USER_LEVEL_USER",25,true);
define("USER_LEVEL_NONE",0,true);

define("KB_LEVEL_ADMIN",100,true);//##my201004071545 Added KB level admin
define("KB_LEVEL_ALL",3,true);
define("KB_LEVEL_USER",2,true);
define("KB_LEVEL_REP",1,true);
define("KB_LEVEL_DISABLE",0,true);

define("SEC_LEVEL_DISABLE",10000,true);
define("SEC_LEVEL_ADMIN",100,true);
define("SEC_LEVEL_REP",50,true);
define("SEC_LEVEL_USER",25,true);
define("SEC_LEVEL_ALL",0,true);

//some advanced options for very special cases.  In most cases, these should be left alone
define("SAFE_OUT", true, true); //if true, Hoduma will run its *output* through an HTML clean function (input is always cleaned)

//Joomla 1.6+ compatibility 
$mainframe = &JFactory::getApplication();

/*
Return Joomla version (release)
*/
function jVer()
{
	// Joomla 1.7 compatibility (class already exists)
	if (!class_exists('JVersion')) 
	{
		// Joomla 1.5 and 1.6 compatibility (jimport needed)
		jimport ( 'joomla.version' );
	}

	$version = new JVersion();
	$strVer = $version->RELEASE;
	
	return $strVer;
}

/*
Returns the output string based upon the requested string variable and the user's (or default) language
*/
function lang($name)
{
	//find user language
	$uid = currentuserinfo('hoduma_id');

	//if the user is a hoduma user, load their language
	//if the user is anonymous, load the config default language
	if($uid) $query = 'SELECT language FROM #__hoduma_users WHERE id = '.$uid;
	else $query = 'SELECT defaultlang FROM #__hoduma_config';
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$langrow = $db->loadRow();
	$language = $langrow[0];

	//set language to default if we didn't get a valid number for the current user's record
	//language = 1 should be the english strings that ship with the product
	if(!isset($language) || $language <= 0) $language = 1;  

	//setup query for finding named string for user language
	//$db =& JFactory::getDBO();
	//$query = "SELECT langtext FROM #__hoduma_langstrings WHERE lang_id=" . $language . " AND variable='".$name."'";
	//$db->setQuery($query);
	//$str = $db->loadRow();
	$str = array();
	
	//if there was not string found in the database, check the local language file
	if(count($str) <=0) 
	{
		//translate string
		$langString = JText::_($name);
		//return 'Language string \''.$name.'\' not found';
	}
	else 
	{
		$langString = $str[0];
	}
	
	//return the result
	return $langString;
}

/*
Returns the html code for a table of buttons. An arbitrary number of buttons can be requested
by listing each keyword as a separate function parameter string, e.g. toolbar('admin','home','refresh');.
*/
function toolbar($buttons)  
{
	$mainframe = &JFactory::getApplication();	
	
	$params = JComponentHelper::getParams( 'com_hoduma' );
	$closed = $params->get('closedstatus');
	
	$buttonlist = func_get_args();
	
	echo '<table class="toolbartable" width="100%">';
	echo '<tr>';
	echo '<td align="left" class="toolbarmessage">&nbsp;<span id="toolbarmessage"></span></td>';
	echo '<td align="right" class="problemlistbuttonarea" NOWRAP><div class="problemlistbuttonarea"><span id="toolbartools">';

	foreach($buttonlist as $btn)
	{
		switch ($btn)
		{
			case 'back':
				echo '<button class="toolbar" onclick="window.history.back();return false;"><img src="media/com_hoduma/images/arrow_left_24.png" class="toolbaricon"/><br>'.lang('Back').'</button>';
				break;
			case 'browse':
				echo '<button class="toolbar" onclick="document.searchForm.submit();"><img src="media/com_hoduma/images/table_24.png" class="toolbaricon"/><br>'.lang('Browse').'</button>';
				break;
			case 'close':
				//get vars from url so we know what screen to return to when we close
				$type = $mainframe->getUserStateFromRequest('hh_list.type','type','');
				$user = $mainframe->getUserStateFromRequest('hh_list.user','user','','int');
				$days = $mainframe->getUserStateFromRequest('hh_list.days','days','','int');
				$stype = $mainframe->getUserStateFromRequest('hh_list.stype','stype','');
				
				//build button onclick code
				$onclick = '';
				switch($type)
				{
					case 'submitted':
						$onclick = "window.location='index.php?option=com_hoduma&view=list&type=submitted&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						break;
					case 'assigned':
						$onclick = "window.location='index.php?option=com_hoduma&view=list&type=assigned&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						break;
					case 'all':
						if(strlen($user)<=0) 
						{
							$onclick = "window.location='index.php?option=com_hoduma&view=list&type=all&days=".$days."&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						}
						else 
						{
							$onclick = "window.location='index.php?option=com_hoduma&view=list&type=all&user=".$user."&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						}
						break;
					case 'search':
						//$onclick = "searchresults();document.problem_form.submit();";
						$onclick = "window.location='index.php?option=com_hoduma&view=list&type=search&stype=".$stype."&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						break;
					default:
						$onclick = "window.location='index.php?option=com_hoduma&view=cpanel&Itemid=".JRequest::getVar('Itemid','')."';return false;";
						break;
				}
				
				echo '<button class="toolbar" onclick="'.$onclick.'"><img src="media/com_hoduma/images/cross_24.png" class="toolbaricon"/><br>'.lang('Close').'</button>';
				break;
			case 'closeprint':
				echo '<button class="toolbar" onclick="window.close();"><img src="media/com_hoduma/images/cross_24.png" class="toolbaricon"/><br>'.lang('Close').'</button>';
				break;
			case 'closereport':
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=reports&Itemid='.JRequest::getVar('Itemid','').'\';return false;"><img src="media/com_hoduma/images/cross_24.png" class="toolbaricon"/><br>'.lang('Close').'</button>';
				break;
			case 'home':
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=cpanel&Itemid='.JRequest::getVar('Itemid','').'\';return false;"><img src="media/com_hoduma/images/home_24.png" class="toolbaricon"/><br>'.lang('Home').'</button>';
				break;
			case 'inoutall':
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=inout&type=all&Itemid='.JRequest::getVar('Itemid','').'\';return false;"><img src="media/com_hoduma/images/globe_24.png" class="toolbaricon"/><br>'.lang('ShowAll').'</button>';
				break;
			case 'inoutrep':
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=inout&type=rep&Itemid='.JRequest::getVar('Itemid','').'\';return false;"><img src="media/com_hoduma/images/users_two_24.png" class="toolbaricon"/><br>'.lang('ShowReps').'</button>';
				break;
			case 'print': //opens a print-friendly version of the case detail
				//build popup window string
				$type = trim($mainframe->getUserStateFromRequest('hh_list.type','type',''));
				$cid = JRequest::getVar('cid', array(0), '', 'array');
				$chk = safe(JRequest::getVar('chk','','','string',JREQUEST_ALLOWRAW)); //needs to be here so anons can print their cases
				$str = 'index.php?option=com_hoduma&tmpl=component&print=1&layout=default&page=&view=detail&type='.$type.'&task=edit&cid='.$cid[0].'&chk='.$chk.'&Itemid='.JRequest::getVar('Itemid','');
				echo '<button class="toolbar" onclick="window.open(\''.$str.'\',\'problemprint\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no\'); return false;"><img src="media/com_hoduma/images/printer_24.png" class="toolbaricon"/><br>'.lang('Print').'</button>';
				break;
			case 'printactivity': //opens a print-friendly version of the activity list
				//build popup window string
				$str = 'index.php?option=com_hoduma&tmpl=component&print=1&layout=default&page=&view=activity&Itemid='.JRequest::getVar('Itemid','').'&days='.JRequest::getVar('days','','','int');
				echo '<button class="toolbar" onclick="window.open(\''.$str.'\',\'problemprint\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no\'); return false;"><img src="media/com_hoduma/images/printer_24.png" class="toolbaricon"/><br>'.lang('Print').'</button>';
				break;
			case 'printlist': //opens a print-friendly version of the problem list
				//build popup window string
				$type = trim($mainframe->getUserStateFromRequest('hh_list.type','type',''));
				$str = 'index.php?option=com_hoduma&tmpl=component&print=1&layout=default&page=&view=list&type='.$type.'&Itemid='.JRequest::getVar('Itemid','').'&sort='.JRequest::getVar('sort','').'&order='.JRequest::getVar('order','');
				echo '<button class="toolbar" onclick="window.open(\''.$str.'\',\'problemprint\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no\'); return false;"><img src="media/com_hoduma/images/printer_24.png" class="toolbaricon"/><br>'.lang('Print').'</button>';
				break;
			case 'printout': //pops up the print dialog
				echo '<button class="toolbar" onclick="window.print();"><img src="media/com_hoduma/images/printer_24.png" class="toolbaricon"/><br>'.lang('Print').'</button>';
				break;
			case 'refresh':
				echo '<button class="toolbar" onclick="window.location.reload();return false;"><img src="media/com_hoduma/images/refresh_24.png" class="toolbaricon"/><br>'.lang('Refresh').'</button>';
				break;
			case 'reopen':
				echo '<button class="toolbar" onclick="document.getElementById(\'taskid\').value=\'reopen\';document.problem_form.submit();"><img src="media/com_hoduma/images/box_upload_24.png" class="toolbaricon"/><br>'.lang('ReopenProblem').'</button>';
				break;
			case 'reset':
				echo '<button class="toolbar" onclick="window.location.reload();return false;"><img src="media/com_hoduma/images/circle_red_24.png" class="toolbaricon"/><br>'.lang('Reset').'</button>';
				break;
			case 'saveproblem':
				//get closed status we need to check against it in the form check
				//$query = 'SELECT s.id AS sid FROM #__hoduma_config AS c JOIN #__hoduma_status AS s ON s.id=c.closestatus';
				//$db =& JFactory::getDBO();
				//$db->setQuery($query);
				//$closed = $db->loadRow();
				
				echo '<button class="toolbar" onclick="return processform('.$closed.','.config('require_solution').','.config('require_category').','.config('require_rep').','.config('require_timespent').');return false;"><img src="media/com_hoduma/images/floppy_disk_24.png" class="toolbaricon"/><br>'.lang('Save').'</button>';
				break;
			case 'submitproblem':
				echo '<button class="toolbar" onclick="return processform('.$closed.','.config('require_solution').','.config('require_category').','.config('require_rep').','.config('require_timespent').');return false;"><img src="media/com_hoduma/images/floppy_disk_24.png" class="toolbaricon"/><br>'.lang('Submit').'</button>';
				break;
			case 'saveprofile':
				echo '<button class="toolbar" onclick="if(validateform()) document.editInfoForm.submit();"><img src="media/com_hoduma/images/floppy_disk_24.png" class="toolbaricon"/><br>'.lang('Save').'</button>';
				break;
			case 'search':
				echo '<button class="toolbar" onclick="if(validateform()) document.searchForm.submit();"><img src="media/com_hoduma/images/search_24.png" class="toolbaricon"/><br>'.lang('Search').'</button>';
				break;
			case 'searchagain':
				//get vars from url so we know what screen to return to when we close
				$stype = $mainframe->getUserStateFromRequest('hh_list.stype','stype','');
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=search&stype='.$stype.'&Itemid='.JRequest::getVar('Itemid','').'\';"><img src="media/com_hoduma/images/search_24.png" class="toolbaricon"/><br>'.lang('NewSearch').'</button>';
				break;
			case 'submit':
				$type = $mainframe->getUserStateFromRequest('hh_list.type','type','');
				echo '<button class="toolbar" onclick="window.location=\'index.php?option=com_hoduma&view=detail&cid=-1&task=edit&type='.$type.'&Itemid='.JRequest::getVar('Itemid','').'\';"><img src="media/com_hoduma/images/add_24.png" class="toolbaricon"/><br>'.lang('Submit').'</button>';
				break;
			case 'viewreport':
				echo '<button class="toolbar" onclick="if(validateform()) document.reportForm.submit();"><img src="media/com_hoduma/images/paper_content_chart_24.png" class="toolbaricon"/><br>'.lang('View').'</button>';
				break;
		}
	}

	echo '</span></div></td>';
	echo '</tr>';
	echo '</table>';
}

/*
Returns the requested config data
Takes what config value to return as input (must match name of config table column)
*/
function config($whatToReturn)
{
	//$query = "SELECT ".$whatToReturn." FROM #__hoduma_config";
	//$db =& JFactory::getDBO();
	//$db->setQuery($query);
	//$config = $db->loadRow();
	//return $config[0];
	
	// Hoduma: config moved to component parameters
	
	if($whatToReturn == "closestatus") {
		$whatToReturn = "closedstatus";
	}
	
	$params = JComponentHelper::getParams( 'com_hoduma' );
	return $params->get($whatToReturn);
}

/*
Shortcut for the userinfo function when info desired is about the currently logged in user
Takes just the info desired as input and sends it along with the Huru id of the current user to
the userinfo function
*/
function currentuserinfo($whatToReturn)
{
	//get joomla id of current user
	$juser =& JFactory::getUser();
	$juid = $juser->id;
	
	//get hoduma id of current user
	$query = "SELECT id FROM #__hoduma_users WHERE joomla_id=".$juid;
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$hid = $db->loadRow();
	if (empty ($hid) ) { $hid[0]=null;}//##my201004071507. Remove warning. Added this
	return userinfo($hid[0],$whatToReturn);
}

/*
Returns the requested user information
Takes the Hoduma user id and which item to return as inputs
*/
function userinfo($usernumber, $whatToReturn)
{
	//hoduma user info
	//##my202004071517 { Added to fix unlogged user DB error
	if (!isset ($usernumber) || empty($usernumber)) {
		$usernumber = 0;
		$whatToReturn = 'nothing';
	}
	//##my202004071517 }
	$query = "SELECT ju.name, ju.username, ju.email, ju.id, hh.id, hh.phone, hh.phonemobile, hh.phonehome, hh.location1, hh.location2, hh.department, hh.pageraddress FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.id=".$usernumber;
	
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$userinfo = $db->loadRow();

	switch ($whatToReturn)
	{
		//##my202004071518 Added to handle situation for non-logged users {
		case 'nothing':
			return null;
			break;
		//##my202004071518 }
		case 'name':
			return $userinfo[0];
			break;
		case 'username':
			return $userinfo[1];
			break;
		case 'email':
			return $userinfo[2];
			break;
		case 'joomla_id':
			return $userinfo[3];
			break;
		case 'hoduma_id':
			return $userinfo[4];
			break;
		case 'phone':
			return $userinfo[5];
			break;
		case 'phonemobile':
			return $userinfo[6];
			break;
		case 'phonehome':
			return $userinfo[7];
			break;
		case 'location1':
			return $userinfo[8];
			break;
		case 'location2':
			return $userinfo[9];
			break;
		case 'department':
			return $userinfo[10];
			break;
		case 'pageraddress':
			return $userinfo[11];
			break;
		default:
			return "--?--";
			break;
	}
}

/*
Selects, formats and sends emails updating the users & reps about case status
Takes which message to send, the email address to send it to, and the case detail array as inputs
*/
function hh_sendmail($what, $to, $details, $useconfigurl)
{
	if(DEMO) return true; //bypass mailing functions if in demo mode
	
	$mainframe = &JFactory::getApplication();	
	
	//verify that we have a valid recipient address before going any further
	$validator = new EmailAddressValidator;
	if (!$validator->check_email_address($to)) return false; 

	//get the message subject and body
	$query = "SELECT subject, body FROM #__hoduma_emailmsg WHERE type = '".$what."'";
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$messagedetails = $db->loadRow();
	
	//get reply address 
	$sender = array(config('hdreply'),config('hdnotifyname'));
	if(DEBUG) $mainframe->enqueueMessage($sender[0]); //for debugging
	if(DEBUG) $mainframe->enqueueMessage($sender[1]); //for debugging
	
	//set URL
	if(config('allowanonymous') && !$useconfigurl) //only do this if anonymous access allowed since direct URL bypasses login & will error if anon is not allowed
	{
		$url = JURI::root(); //get site root from Joomla
		if(substr($url, -1) != '/') $url = $url.'/'; //first make sure base URL has '/' at the end
		$url = $url.'index.php?option=com_hoduma&view=detail';  //basic URL parms
		$url = $url.'&cid='.$details[0]; //problem number
		$url = $url.'&chk='.$details[4]; //uemail of problem
		$url = $url.'&Itemid='.JRequest::getVar('Itemid','','post','int',JREQUEST_ALLOWRAW); //menu item id of helpdesk so user will get right modules, etc.
	}
	else
	{
		$url = config('hdurl');
	}
	
	//substitute macro strings in message subject & body
	$subject = $messagedetails[0];
	$body = $messagedetails[1];
	
	$subject = str_replace('[url]',$url,$subject);
	$body = str_replace('[url]',$url,$body);

	$subject = str_replace('[problemid]',$details[0],$subject);
	$body = str_replace('[problemid]',$details[0],$body);

	$subject = str_replace('[title]',$details[1],$subject);
	$body = str_replace('[title]',$details[1],$body);

	$subject = str_replace('[description]',$details[2],$subject);
	$body = str_replace('[description]',$details[2],$body);

	$subject = str_replace('[uid]',$details[3],$subject);
	$body = str_replace('[uid]',$details[3],$body);

	$subject = str_replace('[uemail]',$details[4],$subject);
	$body = str_replace('[uemail]',$details[4],$body);

	$subject = str_replace('[phone]',$details[5],$subject);
	$body = str_replace('[phone]',$details[5],$body);

	$subject = str_replace('[location]',$details[6],$subject);
	$body = str_replace('[location]',$details[6],$body);

	//for the department, we need to find the name first
	$query = "SELECT dname FROM #__hoduma_departments WHERE id = ".$details[7];
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$department = $db->loadRow();
	$subject = str_replace('[department]',$department[0],$subject);
	$body = str_replace('[department]',$department[0],$body);

	//for the priority, we need to find the name first
	$query = "SELECT pname FROM #__hoduma_priorities WHERE id = ".$details[8];
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$priority = $db->loadRow();
	$subject = str_replace('[priority]',$priority[0],$subject);
	$body = str_replace('[priority]',$priority[0],$body);

	//for the category, we need to find the name first
	$query = "SELECT cname FROM #__hoduma_categories WHERE id = ".$details[9];
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$category = $db->loadRow();
	$subject = str_replace('[category]',$category[0],$subject);
	$body = str_replace('[category]',$category[0],$body);

	$subject = str_replace('[startdate]',$details[10],$subject);
	$body = str_replace('[startdate]',$details[10],$body);

	//for the repname, we need to find the name first
	$rep = userinfo($details[11],'name');
	$subject = str_replace('[repname]',$rep,$subject);
	$body = str_replace('[repname]',$rep,$body);

	//for the repemail, we need to find the email address first
	$rep = userinfo($details[11],'email');
	$subject = str_replace('[repemail]',$rep,$subject);
	$body = str_replace('[repemail]',$rep,$body);

	$subject = str_replace('[solution]',$details[12],$subject);
	$body = str_replace('[solution]',$details[12],$body);

	$subject = str_replace('[fullname]',userinfo($details[13],'name'),$subject);
	$body = str_replace('[fullname]',userinfo($details[13],'name'),$body);

	//get the latest note for case and include it in any update message
	$query = "SELECT note, adddate, uid FROM #__hoduma_notes WHERE priv<>1 AND problem_id = ".$details[0]." ORDER BY adddate DESC";
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$note = $db->loadRow();
	$subject = str_replace('[notes]',$note[0],$subject);
	$body = str_replace('[notes]',$note[0],$body);

	//add psn to subject for tracking imap messages
	if(config('imap_enabled')) $subject = $subject.'  [psn:'.$details[0].']';
	
	//setup the mailer & create message
	$mail =& JFactory::getMailer();
	 
	$config =& JFactory::getConfig();
	$mail->addRecipient($to);
	$mail->setSender($sender);
	$subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
	$mail->setSubject($subject);
	$body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
	$mail->setBody($body);
	 
	if ($mail->Send()) return true;
	else return false; //if there was trouble, return false for error checking in the caller
}

/*
Formats text that was input in a text area for readonly HTML display
This encodes HTML characters and calls another function  to convert line breaks and white space
*/
function formatROText($str)
{
//	$str = htmlspecialchars($str, ENT_QUOTES); //html characters so we can show html code in description & notes
	$str = formatWhitespace($str);
	$str = nl2br($str); //newlines

	return $str;
}

/*
Formats text that was input in a text area for readonly HTML display
This function converts line breaks and white space
*/
function formatWhitespace($str)
{
	$str = str_replace(chr(32).chr(32)," &nbsp;",$str); //space (to enable multiple spaces)
	$str = str_replace(chr(9),"&nbsp;&nbsp;&nbsp;&nbsp;",$str); //tab

	return $str;
}

/*
escapes form input to stop sql injection and XSS attacks
*/
function safe($str)
{
	return htmlentities($str, ENT_QUOTES, 'UTF-8', FALSE);  //use of ENT_QUOTES necessary to prevent injecton of single quotes
}

/*
escapes form output to stop XSS attacks

User input is cleaned, so cleaning output as well may result in double-encoding.  
To disable this function, set the SAFE_OUT constant in head.php to FALSE
*/
function safe_out($str)
{
	if(SAFE_OUT) 
	{
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8', FALSE);  //use of ENT_QUOTES necessary to prevent injecton of single quotes
	}
	
	return $str; 
}


/*
	EmailAddressValidator Class
	http://code.google.com/p/php-email-address-validation/

	Released under New BSD license
	http://www.opensource.org/licenses/bsd-license.php
	
	Sample Code
	----------------
	$validator = new EmailAddressValidator;
	if ($validator->check_email_address('test@example.org')) {
		// Email address is technically valid
	}
*/
class EmailAddressValidator {
	/**
	 * Check email address validity
	 * @param   strEmailAddress     Email address to be checked
	 * @return  True if email is valid, false if not
	 */
	public function check_email_address($strEmailAddress) {
		
		// If magic quotes is "on", email addresses with quote marks will
		// fail validation because of added escape characters. Uncommenting
		// the next three lines will allow for this issue.
		//if (get_magic_quotes_gpc()) { 
		//    $strEmailAddress = stripslashes($strEmailAddress); 
		//}

		// Control characters are not allowed
		if (preg_match('/[\x00-\x1F\x7F-\xFF]/', $strEmailAddress)) {
			return false;
		}

		// Check email length - min 3 (a@a), max 256
		if (!$this->check_text_length($strEmailAddress, 3, 256)) {
			return false;
		}

		// Split it into sections using last instance of "@"
		$intAtSymbol = strrpos($strEmailAddress, '@');
		if ($intAtSymbol === false) {
			// No "@" symbol in email.
			return false;
		}
		$arrEmailAddress[0] = substr($strEmailAddress, 0, $intAtSymbol);
		$arrEmailAddress[1] = substr($strEmailAddress, $intAtSymbol + 1);

		// Count the "@" symbols. Only one is allowed, except where 
		// contained in quote marks in the local part. Quickest way to
		// check this is to remove anything in quotes. We also remove
		// characters escaped with backslash, and the backslash
		// character.
		$arrTempAddress[0] = preg_replace('/\./'
										 ,''
										 ,$arrEmailAddress[0]);
		$arrTempAddress[0] = preg_replace('/"[^"]+"/'
										 ,''
										 ,$arrTempAddress[0]);
		$arrTempAddress[1] = $arrEmailAddress[1];
		$strTempAddress = $arrTempAddress[0] . $arrTempAddress[1];
		// Then check - should be no "@" symbols.
		if (strrpos($strTempAddress, '@') !== false) {
			// "@" symbol found
			return false;
		}

		// Check local portion
		if (!$this->check_local_portion($arrEmailAddress[0])) {
			return false;
		}

		// Check domain portion
		if (!$this->check_domain_portion($arrEmailAddress[1])) {
			return false;
		}

		// If we're still here, all checks above passed. Email is valid.
		return true;

	}

	/**
	 * Checks email section before "@" symbol for validity
	 * @param   strLocalPortion     Text to be checked
	 * @return  True if local portion is valid, false if not
	 */
	protected function check_local_portion($strLocalPortion) {
		// Local portion can only be from 1 to 64 characters, inclusive.
		// Please note that servers are encouraged to accept longer local
		// parts than 64 characters.
		if (!$this->check_text_length($strLocalPortion, 1, 64)) {
			return false;
		}
		// Local portion must be:
		// 1) a dot-atom (strings separated by periods)
		// 2) a quoted string
		// 3) an obsolete format string (combination of the above)
		$arrLocalPortion = explode('.', $strLocalPortion);
		for ($i = 0, $max = sizeof($arrLocalPortion); $i < $max; $i++) {
			 if (!preg_match('.^('
							.    '([A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]' 
							.    '[A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]{0,63})'
							.'|'
							.    '("[^\\\"]{0,62}")'
							.')$.'
							,$arrLocalPortion[$i])) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks email section after "@" symbol for validity
	 * @param   strDomainPortion     Text to be checked
	 * @return  True if domain portion is valid, false if not
	 */
	protected function check_domain_portion($strDomainPortion) {
		// Total domain can only be from 1 to 255 characters, inclusive
		if (!$this->check_text_length($strDomainPortion, 1, 255)) {
			return false;
		}
		// Check if domain is IP, possibly enclosed in square brackets.
		if (preg_match('/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
		   .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}$/'
		   ,$strDomainPortion) || 
			preg_match('/^\[(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
		   .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}\]$/'
		   ,$strDomainPortion)) {
			return true;
		} else {
			$arrDomainPortion = explode('.', $strDomainPortion);
			if (sizeof($arrDomainPortion) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0, $max = sizeof($arrDomainPortion); $i < $max; $i++) {
				// Each portion must be between 1 and 63 characters, inclusive
				if (!$this->check_text_length($arrDomainPortion[$i], 1, 63)) {
					return false;
				}
				if (!preg_match('/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|'
				   .'([A-Za-z0-9]+))$/', $arrDomainPortion[$i])) {
					return false;
				}
				if ($i == $max - 1) { // TLD cannot be only numbers
					if (strlen(preg_replace('/[0-9]/', '', $arrDomainPortion[$i])) <= 0) {
						return false;
					}
				}
			}
		}
		return true;
	}

	/**
	 * Check given text length is between defined bounds
	 * @param   strText     Text to be checked
	 * @param   intMinimum  Minimum acceptable length
	 * @param   intMaximum  Maximum acceptable length
	 * @return  True if string is within bounds (inclusive), false if not
	 */
	protected function check_text_length($strText, $intMinimum, $intMaximum) {
		// Minimum and maximum are both inclusive
		$intTextLength = strlen($strText);
		if (($intTextLength < $intMinimum) || ($intTextLength > $intMaximum)) {
			return false;
		} else {
			return true;
		}
	}
}

function cleanuserstatevars()
{
		$mainframe = &JFactory::getApplication();	
		
		//clean up the user state vars
		$mainframe->setUserState('hh_list.type','');
		$mainframe->setUserState('hh_list.user','');
		$mainframe->setUserState('hh_list.days','');
		$mainframe->setUserState('hh_list.stype','');
		$mainframe->setUserState('hh_list.task','');
		$mainframe->setUserState('hh_list.order','');
		$mainframe->setUserState('hh_list.sort','');
		$mainframe->setUserState('hh_list.searchuser','');
		$mainframe->setUserState('hh_list.searchdays','');
		$mainframe->setUserState('hh_list.searchtask','');
		$mainframe->setUserState('hh_list.searchusername','');
		$mainframe->setUserState('hh_list.searchproblemid','');
		$mainframe->setUserState('hh_list.searchrep','');
		$mainframe->setUserState('hh_list.searchcategory','');
		$mainframe->setUserState('hh_list.searchdepartment','');
		$mainframe->setUserState('hh_list.searchstatus','');
		$mainframe->setUserState('hh_list.searchpriority','');
		$mainframe->setUserState('hh_list.searchkeyword','');
		$mainframe->setUserState('hh_list.searchsubject','');
		$mainframe->setUserState('hh_list.searchdescription','');
		$mainframe->setUserState('hh_list.searchsolution','');
		$mainframe->setUserState('hh_list.searchstartdatefrom','');
		$mainframe->setUserState('hh_list.searchstartdateto','');
		$mainframe->setUserState('hh_list.count','');
}

/*
Dumps debug information to screen
*/
function dumpdebug($str = '')
{
	$mainframe = &JFactory::getApplication();	
	
	if(strlen($str)>0)
	{
		echo $str . '<br>';
	}
	else
	{
		echo '<br>userlevel: '.userlevel();
		echo '<br>view: '. $mainframe->getUserStateFromRequest('hh_list.view','view','');
		echo '<br>task: '. $mainframe->getUserStateFromRequest('hh_list.task','task','');
		echo '<br>type: '. $mainframe->getUserStateFromRequest('hh_list.type','type','');
		echo '<br>days: '. $mainframe->getUserStateFromRequest('hh_list.days','days','','int');
		echo '<br>hid: '.  $mainframe->getUserStateFromRequest('hh_list.user','user','','int');

		echo '<br>stype: '. $mainframe->getUserState('hh_list.stype','stype','');
		echo '<br>username: '. $mainframe->getUserState('hh_list.searchusername','');
		echo '<br>problemid: '. $mainframe->getUserState('hh_list.searchproblemid','');
		echo '<br>rep: '. $mainframe->getUserState('hh_list.searchrep','');
		echo '<br>category: '. $mainframe->getUserState('hh_list.searchcategory','');
		echo '<br>department: '. $mainframe->getUserState('hh_list.searchdepartment','');
		echo '<br>status: '. $mainframe->getUserState('hh_list.searchstatus','');
		echo '<br>priority: '. $mainframe->getUserState('hh_list.searchpriority','');
		echo '<br>keyword: '. $mainframe->getUserState('hh_list.searchkeyword','');
		echo '<br>subject: '. $mainframe->getUserState('hh_list.searchsubject','');
		echo '<br>description: '. $mainframe->getUserState('hh_list.searchdescription','');
		echo '<br>solution: '. $mainframe->getUserState('hh_list.searchsolution','');
		echo '<br>datefrom: '. $mainframe->getUserState('hh_list.searchstartdatefrom','');
		echo '<br>dateto: '. $mainframe->getUserState('hh_list.searchstartdateto','');
	}
	
	echo '<br>';
}

/*
Returns the id of the first attachment found for a given note id.
Takes the note_id to be queried as input
*/
function get_attachment_id($note_id)
{
	$db =& JFactory::getDBO();
	$query = "SELECT id FROM #__hoduma_attachments WHERE note_id = ".$note_id;
	$db->setQuery($query);
	$attachment_id = $db->loadResult();
	return $attachment_id;
}

/*
Returns the filename of the attachment
Takes the attachment id to be queried as input
*/
function get_attachment_name($attachment_id)
{
	//##my201004080307 Fix database error with joomfish{
	if (empty($attachment_id) ) {
		return null;
	}
	//##my201004080307 }
	$db =& JFactory::getDBO();
	$query = "SELECT name FROM #__hoduma_attachments WHERE id = ".$attachment_id;
	$db->setQuery($query);
	$attachment_name = $db->loadResult();
	return $attachment_name;
}

/*
Checks attachment file properties against configured restrictions
Takes attachment filename, extension, size, mime type, and tempfile name as inputs
Not all of these are used now, but they are passed for future functionality
Also takes a flag indicating whether it should enqueue an the error message if file fails testing
*/
function attachment_file_ok($filename, $ext, $filesize, $filetype, $tmpname, $setmsg)
{
	$mainframe = &JFactory::getApplication();	
	
	//normalize extension (make sure it is only the chars after the *last* period in the filename)
	$fixext = explode('.',$ext);
	$ext = '.'.$fixext[count($fixext)-1]; //be sure to put the leading '.' back

	//check the file against the allowed extensions
	if(!in_array(strtolower($ext),explode(',',strtolower(config('fileattach_allowedextensions')))))	
	{
		if($setmsg) $mainframe->enqueueMessage(lang('ErrorSavingAttachment').' - '.lang('FileTypeNotAllowed'), 'notice');
//		if($setmsg) $mainframe->enqueueMessage('AttachmentExt:'.strtolower($ext).' -- Allowed:'.strtolower(config('fileattach_allowedextensions')));
		if(DEBUG) JError::raiseError(500, lang('ErrorSavingAttachment').' - '.lang('FileTypeNotAllowed'.' - AttachmentExt:'.strtolower($ext).' -- Allowed:'.strtolower(config('fileattach_allowedextensions'))));
		return false;
	}

	//check the file size against the configured maximum
	if(filesize($tmpname) > config('fileattach_maxsize'))
	{
		if($setmsg) $mainframe->enqueueMessage(lang('ErrorSavingAttachment').' - '.lang('FileTooLarge'), 'notice');
		if(DEBUG) JError::raiseError(500, lang('ErrorSavingAttachment').' - '.lang('FileTooLarge'));
		return false;
	}
	
	//if everything checks out, return true
	return true;
}

/*
Deletes old attachments from system based maximum age
Will use the supplied maxage and will look up the config maxage if none was supplied
*/
function delete_old_attachments($maxage=-1)
{
	$mainframe = &JFactory::getApplication();	
	
	//if a maxage wasn't sent, then get maxage from config
	if($maxage<=0) $maxage = config('fileattach_maxage');
	
	if(DEBUG) $mainframe->enqueueMessage($maxage);
	
	//if maxage <= 0 then we have disabled this feature
	if($maxage > 0)
	{
		//check to see if any old attachment records point to attachments stored on the filesystem
		//if they do, delete the physical files before deleting the attachment table records
		$query = 'SELECT a.location FROM #__hoduma_attachments AS a LEFT OUTER JOIN #__hoduma_notes AS n ON a.note_id = n.id WHERE adddate < DATE_SUB(CURDATE(), INTERVAL '.$maxage.' DAY)';
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
		if($db->getNumRows() > 0)
		{
			$files = $db->loadResultArray();
		
			foreach($files as &$filepath)
			{
			if(file_exists($filepath) && !is_dir($filepath)) //don't delete folders, just files
				{
					if(DEBUG)$mainframe->enqueueMessage($filepath);
					unlink($filepath);
				}
			}
		}
		//delete empty subfolders
		//removeEmptySubFolders(config('fileattach_path'));
		
		//delete attachment table records
		//this will also delete any attachment sstored in the database
		$query = 'DELETE a.* FROM #__hoduma_attachments AS a LEFT OUTER JOIN #__hoduma_notes AS n ON a.note_id = n.id WHERE adddate < DATE_SUB(CURDATE(), INTERVAL '.$maxage.' DAY)';
		$db =& JFactory::getDBO();
		$db->setQuery($query);
		$result = $db->query($query);

		//queue up some messages if we are debugging
		if(DEBUG)
		{
			if($result) $mainframe->enqueueMessage('Deleted old attachments');
			else $mainframe->enqueueMessage('Error deleting old attachments');
		}
	}
}

//deletes empty folders
/*
function removeEmptySubFolders($path)
{
	$empty=true;
	foreach (glob($path."*") as $file)
	{
		$empty &= is_dir($file) && removeEmptySubFolders($file);
	}
	return $empty && rmdir($path);
}
*/

function randString($length=10) 
{
	//if(!isset($length) || $length<=0) $length = 10;
	
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$string = '';    

	for ($i = 0; $i < $length; $i++) 
	{
		$string .= $characters[mt_rand(0, strlen($characters))];
	}

	return $string;
}

// replace any single quote in strValue with two single quotes for SQL queries
function sqlQuote($str)
{
	$str = str_replace("'", "''", $str);
	return $str; 
}