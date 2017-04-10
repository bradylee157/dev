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

//Main config check function
function configCheck()
{
	echo '<table class="configCheckTable">';
	checkConstants();
	checkPluginStatus();
	checkDefaults();
	checkNotifications();
	checkPHPSettings();
	checkFileUploads();
	checkLanguageStrings();
	checkIMAPSettings();
	checkUsers();
	
//	displayResult('good', 'Test');
//	displayResult('bad', 'Test');
	echo '</table>';
}

//output HTML code to display based on test result
function displayResult($goodbad, $resultMessage)
{
	echo '<tr class="configCheckResultRow">';
	
	if($goodbad == 'good')
	{
		echo '<td class="greenResult">&#x2713;</td>';
	}
	elseif($goodbad == 'bad')
	{
		echo '<td class="redResult">&#935;</td>';
	}
	else //'warn'
	{
		echo '<td class="warnResult">!</td>';
	}

	echo '<td class="configCheckResultText">'.$resultMessage.'</td>';
	
	echo '</tr>';
}

//cross checks the given value with the table/field to make sure it exists
function crossCheck($table, $field, $fieldtype, $value)
{
	//account for text or numeric fields
	if($fieldtype == 'text') $value = "'".$value."'";
	
	$query = "SELECT COUNT(*) FROM #__hoduma_".$table." WHERE ".$field." = ".$value;
	$db = JFactory::getDBO();
	$db->setQuery($query);
	$count = $db->loadRow();
	
	if($count[0]>0) return true;
	else return false;
}

//returns byte value (code from PHP manual for ini_get function)
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

//make sure that necessary default values are set and valid
function checkDefaults()
{
	$okay = true;
	
	$params = JComponentHelper::getParams('com_hoduma');
	
	if ($params->get('defaultpriority') < 0 || !crossCheck('priorities','id','int',$params->get('defaultpriority'))) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_DEFAULTPRIORITY').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		$okay = false;
	}
	
	if ($params->get('defaultstatus') < 0 || !crossCheck('statuses','id','int',$params->get('defaultstatus')))  
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_DEFAULTSTATUS').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		$okay = false;
	}
	
	if ($params->get('closedstatus') < 0 || !crossCheck('statuses','id','int',$params->get('closedstatus')))  
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_CLOSEDSTATUS').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		$okay = false;
	}
	
	if ($params->get('defaultdepartment') < 0 || !crossCheck('departments','id','int',$params->get('defaultdepartment')))  
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_DEFAULTDEPARTMENT').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		$okay = false;
	}
	
	if ($params->get('defaultcategory') < 0 || !crossCheck('categories','id','int',$params->get('defaultcategory')))  
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_DEFAULTCATEGORY').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		$okay = false;
	}
	
//	if ($params->get('defaultlang') < 0 || !crossCheck('language','id','int',$params->get('defaultlang')))  
//	{
//		displayResult('bad',lang('defaultlanguage').' '.lang('NotSet'));
//		$okay = false;
//	}
	
//	if ($params->get('defaultrep') < 0 || !crossCheck('users','id','int',$params->get('defaultrep')))  
//	{
//		displayResult('bad',lang('defaultrep').' '.lang('NotSet'));
//		$okay = false;
//	}

	if ($okay) displayResult('good',lang('COM_HODUMA_CONFIGCHECK_DEFAULTSSET'));

}

//make sure the notification stuff is setup okay
function checkNotifications()
{
	$params = JComponentHelper::getParams('com_hoduma');
	$validator = new EmailAddressValidator;
	if(!$validator->check_email_address($params->get('hdreply'))) displayResult('bad', lang('COM_HODUMA_CONFIGCHECK_REPLYADDRESSBAD'));
}

//make sure DEBUG mode is turned off
function checkConstants()
{
	if(DEBUG) displayResult('bad', lang('COM_HODUMA_CONFIGCHECK_DEBUGENABLED'));
//	else displayResult('good', lang('DebugDisabled')); //don't say anything about debug mode if it is turned off

	if(DEMO) displayResult('bad', lang('COM_HODUMA_CONFIGCHECK_DEMOENABLED'));
//	else displayResult('good', lang('DemoDisabled')); //don't say anything about demo mode if it is turned off
}

//check for common PHP problems
function checkPHPSettings()
{
	$okay = true;
	$params = JComponentHelper::getParams('com_hoduma');
	
	//check PHP version
	$version = explode('.', PHP_VERSION);
	if($version[0] < 5) 
	{
		displayResult('bad','PHP v'.PHP_VERSION);
		$okay = false;
	}
	
	//show value of file upload settings in php.ini
	if(return_bytes(ini_get('post_max_size')) < $params->get('fileattach_maxsize')) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_PHPPOSTMAXSIZE').' '.ini_get('post_max_size').' < Hoduma '.lang('COM_HODUMA_CONFIGCHECK_MAXIMUMATTACHMENTSIZE').' = '.$params->get('fileattach_maxsize'));
		$okay = false;
	}

	if(return_bytes(ini_get('upload_max_filesize')) < $params->get('fileattach_maxsize')) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_PHPUPLOADMAXSIZE').' '.ini_get('upload_max_filesize').' < Hoduma '.lang('COM_HODUMA_CONFIGCHECK_MAXIMUMATTACHMENTSIZE').' = '.$params->get('fileattach_maxsize'));
		$okay = false;
	}

	if(return_bytes(ini_get('memory_limit')) < $params->get('fileattach_maxsize')) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_PHPMEMORYLIMIT').' '.ini_get('memory_limit').' < Hoduma '.lang('COM_HODUMA_CONFIGCHECK_MAXIMUMATTACHMENTSIZE').' = '.$params->get('fileattach_maxsize'));
		$okay = false;
	}

	if(return_bytes(ini_get('file_uploads')) != 1) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_PHPFILEUPLOADSOFF'));
		$okay = false;
	}

	if ($okay) displayResult('good',lang('COM_HODUMA_CONFIGCHECK_PHPSETTINGS'));
}

//make sure user sync plugin is installed, enabled and right version
function checkPluginStatus()
{
	//the table we need to check is different for joomla 1.5 and 1.6+
	require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'head.php'; //sends us to the core helper files
	$query = 'SELECT enabled FROM #__extensions';
	
	//check that plugin is installed and enabled
	$query = $query." WHERE name = 'Hoduma - User Sync' AND element = 'hoduma_user_sync'";
	$db = JFactory::getDBO();
	$db->setQuery($query);
	$plugin = $db->loadRow();
	
	if($plugin[0]=='1') displayResult('good',lang('COM_HODUMA_CONFIGCHECK_USERSYNCPLUGIN').' '.lang('COM_HODUMA_CONFIGCHECK_ENABLED'));
	else displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_USERSYNCPLUGIN').' '.lang('COM_HODUMA_CONFIGCHECK_DISABLED'));
}

//checks file upload settings
function checkFileUploads()
{
	$params = JComponentHelper::getParams('com_hoduma');
	//if file uploading is disabled, then we don't need to check anything
	if($params->get('fileattach_allow') != 'diable') //disabled = 'disable', all other values mean *someone* is enabled for file uploads
	{
		$okay = true;
		
		//check attachment storage type - if it's database, we don't need to check the filesystem stuff
		if($params->get('fileattach_type') == 2) //filesystem storage
		{
			//check that path is set
			if(strlen($params->get('fileattach_path')) <= 0) 
			{
				displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_ATTACHMENTSTORAGEPATH').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
				$okay = false;
			}
			
			if($params->get('fileattach_path') == "/") 
			{
				displayResult('warn',lang('COM_HODUMA_CONFIGCHECK_ATTACHMENTSTORAGEPATH').' '.lang('COM_HODUMA_CONFIGCHECK_SETTOROOT'));
				$okay = false;
			}
			
			//check that path exists & we have necessary permissions
			if(!is_writeable($params->get('fileattach_path'))) 
			{
				displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_ATTACHMENTSTORAGEPATH').' '.lang('COM_HODUMA_CONFIGCHECK_DOESNOTEXIST'));
				$okay = false;
			}
		}

		//check that size is set
		if($params->get('fileattach_maxsize')<=0)
		{
			displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_MAXIMUMATTACHMENTSIZE').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
			$okay = false;
		}
		
		//check that size is not over MBLOB max if storage method is set to database
		if($params->get('fileattach_type')==1 && $params->get('fileattach_maxsize') > 16777215)
		{
			displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_MAXIMUMATTACHMENTSIZE').' '.lang('COM_HODUMA_CONFIGCHECK_TOOLARGE'));
			$okay = false;
		}
		
		//check that extensions are set and formatted correctly
		if(strlen($params->get('fileattach_allowedextensions'))<=0)
		{
			displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_ALLOWEDATTACHMENTEXTENSIONS').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
			$okay = false;
		}
		else //if the extentions are set, see if they are formatted correctly
		{
			$okay2 = true;
			
			$extentions = explode(',',$params->get('fileattach_allowedextensions'));
			foreach($extentions as $ext)
			{
				if(substr($ext, 0, 1)!= '.') $okay = false;
				if(DEBUG) echo $ext;
			}
			if(!$okay2) displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_ALLOWEDATTACHMENTEXTENSIONS').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		}

		if($okay) displayResult('good',lang('COM_HODUMA_CONFIGCHECK_FILEUPLOADSETTINGS'));
	}
}

//check to see if the system has strings in the langstrings table along with the .ini language files
function checkLanguageStrings()
{
/*
	$query = "SELECT COUNT(*) FROM #__hoduma_langstrings";
	$db = JFactory::getDBO();
	$db->setQuery($query);
	$strings = $db->loadRow();
	
	if($strings[0]>0) displayResult('warn',lang('LangStringsInTable'));
*/
}

function checkIMAPSettings()
{
	$params = JComponentHelper::getParams('com_hoduma');
	//don't worry about any of this is imap isn't enabled
	if($params->get('imap_enabled'))
	{
		//check server address username & password
		if(strlen($params->get('imap_server')) <= 0) displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_IMAPSERVER').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		if(strlen($params->get('imap_username')) <= 0) displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_IMAPUSERNAME').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		if(strlen($params->get('imap_password')) <= 0) displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_IMAPPASSWORD').' '.lang('COM_HODUMA_CONFIGCHECK_NOTSET'));
		
		//check to see if POP3 configured but not delete
		if($params->get('imap_connecttype==2') && !$params->get('imap_deletemessages')) displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_IMAPPOP3DELETENOTSET'));
	}
}


//checks to make sure there are users, reps, and admins defined
function checkUsers()
{
	$okay = true;
	
	if(!crossCheck('users', 'isuser', 'int', 1)) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_NOUSERS'));
		$okay = false;
	}

	if(!crossCheck('users', 'isrep', 'int', 1)) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_NOREPS'));
		$okay = false;
	}

	if(!crossCheck('users', 'isadmin', 'int', 1)) 
	{
		displayResult('bad',lang('COM_HODUMA_CONFIGCHECK_NOADMINS'));
		$okay = false;
	}
}

?>