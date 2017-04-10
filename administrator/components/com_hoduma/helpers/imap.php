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
/************************************************************************************************************
Because we are not loading this file via the site template or MVC architecture, 
we need to load the Joomla framework on our own so we can use the database functions below
*************************************************************************************************************/
define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ));
define( 'DS', DIRECTORY_SEPARATOR );

// loading framework of Joomla!
require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
/************************************************************************************************************
End Joomla framework load
*************************************************************************************************************/

define ('SSLPORT',993,true); //some IMAP SSL happens over 993, some over 995 - this lets the admin set if necessary

define ('DEBUGIMAP',false,true);

//load the hoduma header file
require_once JPATH_BASE.DS.'..'.DS.'components'.DS.'com_hoduma'.DS.'helpers'.DS.'head.php';

/*
we have to put the notes and detail table class definitions in here 
because it errors if we tray to grab the table files from outside of the Joomla server
any changes to the actual table files must be reflected here
*/
class TableNotes extends JTable
{
	var $id = null;
	var $problem_id = null;
	var $eventcode = null;
	var $note = null;
	var $adddate = null;
	var $uid = null;
	var $ip = null;
	var $private = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__hoduma_notes','id',$db);
	}
}

class TableDetail extends JTable
{
	var $id = null;
	var $problem_id = null;
	var $uid = null;
	var $uemail = null;
	var $ulocation = null;
	var $uphone = null;
	var $rep = null;
	var $status = null;
	var $time_spent = null;
	var $category = null;
	var $close_date = null;
	var $department = null;
	var $title = null;
	var $description = null;
	var $solution = null;
	var $start_date = null;
	var $priority = null;
	var $entered_by = null;
	var $kb = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__hoduma_problems','id',$db);
	}
}


/*
Now we can get on with checking the email
*/

//first thing to do is check to see if imap is enabled
if(config('imap_enabled'))
{
	//check the mailbox for new messages
	
	//get connection parameters
	$server = config('imap_server');
	$username = config('imap_username');
	$password = config('imap_password');
	$connecttype = config('imap_connecttype');
	$ssl = config('imap_ssl');
	$connect = null;
	
	//configure connection port/type substring based on connection type and ssl parameter
	if($connecttype == 1) //imap
	{
		if($ssl) $connect = SSLPORT.'/novalidate-cert/imap/ssl';  //novalidate-cert will stop cert errors of self-signed certs
		else $connect = '143';
	}
	elseif($connecttype == 2) //pop3
	{
		if($ssl) $connect = SSLPORT.'/novalidate-cert/pop3/ssl';  //novalidate-cert will stop cert errors of self-signed certs
		else $connect = '110/pop3';
	}
	else exit('Invalid connection type');

	if(DEBUGIMAP) 
	{
		echo 'Server: '.$server."\n";
		echo '  Username: '.$username."\n";
		echo '  Password: '.$password."\n";
		echo '  Connecttype: '.$connecttype."\n";
		echo '  SSL: '.$ssl."\n";
		echo '  ports: '.$connect."\n";
	}
	
	//open connection to mail server
	$mail = imap_open('{'.$server.':'.$connect.'}', $username, $password);
	if($mail)
	{
		if(DEBUGIMAP) echo 'Server connection opened'."\n\n";
	}
	else exit('Cannot connect to server: '.'{'.$server.':'.$connect.'}'); //if we can't connect, just exit
	//get the UNSEEN messages
	$emails = imap_search($mail, 'UNSEEN');

	if(!$emails) //no emails returned
	{
		echo 'New new messages found'."\n";
		imap_close($mail);
		exit();
	}
	else //emails were returned
	{
		$totalmessages = 0;
		$newcases = 0;
		$existingcases = 0;
		
		foreach($emails as $message) //process each message
		{
			if(DEBUGIMAP) echo "\nMessage: ".$message."\n";
			//does the message have the string [psn:###] in the subject line?
			//if so, then it is in response to an existing case and we should just add the message as a note
			$overview = imap_fetch_overview($mail, $message, 0);
			if(DEBUGIMAP) echo '  Subject:'.$overview[0]->subject."\n";
			
			$pos = strpos($overview[0]->subject, '[psn:'); //checking this way prevent confusion between not found (false) and found at pos=0

			if(DEBUGIMAP && $pos===false) echo '  New case'."\n";
			if(DEBUGIMAP && $pos!==false) echo '  Existing case'."\n";
			
			if($pos === false) //our needle was not found - this is a new case
			{
				//create new case using configured imap_defaults

				//get sender email address
				$sender = getSenderAddress($mail, $message);

				//get sender name
				$senderName = getSenderName($mail, $message);
				
				if(DEBUGIMAP) echo '    Sender:'.$sender."\n";
				if(DEBUGIMAP) echo '    SenderName:'.$senderName."\n";
				
				//sender must be user/rep/admin or anonymous must be turned on 
				$okay = true;
				
				//query for Huru rep/admin with Joomla email address matching our sender
				$query = 'SELECT COUNT(*) as count FROM #__hoduma_users AS hu LEFT OUTER JOIN #__users AS ju ON ju.id = hu.joomla_id WHERE ju.email=\''.$sender.'\'';
				$db =& JFactory::getDBO();
				$db->setQuery($query);
				$count = $db->loadRow();
				
				if($count[0] <=0 )
				{
					if(DEBUGIMAP) echo("  Sender is not user/rep/admin\n"); 
					//if anonymous is not turned on, then we are not okay
					if(config('allowanonymous')) 
					{
						if(DEBUGIMAP) echo("  Anonymous entry enabled\n"); 
					}
					else
					{
						if(DEBUGIMAP) echo("  Anonymous entry not allowed\n"); 
						$okay = false;
					}
				}
				
				if($okay)
				{
					//start building our case
					$row =& JTable::getInstance('Detail', 'Table');
					if(!isset($row)) exit('Cannot open problem table for writing'); //we can kill the whole thing here if we can't open the table
					
					$row->id = ""; //auto-assigned by system
					$row->department = config('imap_default_department');
					$row->priority = config('imap_default_priority');
					$row->status = config('imap_default_status');
					$row->category = config('imap_default_category');
					$row->rep = config('imap_default_rep');
					$row->uid = safe($senderName);
					$row->uemail = safe($sender);
					$row->entered_by = safe($sender);
					$row->start_date = date("Y/m/d H:i:s");
					$row->title = safe($overview[0]->subject);

					//set just the plain text of the message body as the case description
					$body = getBody($mail, $message);
					
					$row->description = safe($body);

					if($row->store()) //store the case					
					{
						//get the case details for the creation note and messages
						$query = "SELECT id, title, description, uid, uemail, uphone, ulocation, department, priority, category, start_date, rep, solution, entered_by FROM #__hoduma_problems ";
//						$query = $query." WHERE uid = '".$row->uid."' AND DATE_FORMAT(start_date,'%Y-%m-%d-%H-%i-%s')='".date('Y-m-d-H-i-s',strtotime($row->start_date))."' AND title='".$row->title."'";
						$query = $query." WHERE uid = '".$row->uid."' AND DATE_FORMAT(start_date,'%Y-%m-%d-%H-%i-%s')='".date('Y-m-d-H-i-s',strtotime($row->start_date))."' AND title='".sqlQuote($row->title)."'";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						do
						{
							$case = $db->loadRow();
						} while (!isset($case[0]) || $case[0] <= 0);  //Make sure we got the case id before proceeding
						
						//get rep details 
						$query = "SELECT ju.email as email, ju.name as name, hh.pageraddress FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.id=".$case[11]." ORDER BY ju.username";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						$rep = $db->loadRow();
						
						//create note that case was created
						if(createNote($case[0], 1, safe($sender), safe($senderName), 'Problem Created', 1))
						{
							//notify the sender that the case was received
							hh_sendmail('usernew',$case[4],$case, true); //send new message

							//notify rep of new case 
							hh_sendmail('repnew',$rep[0],$case, true); //send new message
						}

						if(config('imap_deletemessages')) imap_delete($mail, $message);
					}
					else
					{
						echo("Error saving case\n");
					} //end if row->store
				}
				
				$newcases += 1;
			}
			else //our needle was found - this is an existing case
			{
				$okay = true;
				
				//find the case id from the subject line
				if(DEBUGIMAP) echo '    Subject:'.$overview[0]->subject."\n";

				$start = strpos($overview[0]->subject, '[psn:');
				if(DEBUGIMAP) echo '    IDStart:'.$start."\n";
				
				$end = strpos($overview[0]->subject, ']', $start+1);
				if(DEBUGIMAP) echo '    IDEnd:'.$end."\n";

				$id = substr($overview[0]->subject, $start+5 , $end - ($start+5));
				if(DEBUGIMAP) echo '    SubjectID:'.$id."\n";
				
				//query for case data
				$query = 'SELECT id, uemail FROM #__hoduma_problems WHERE id='.$id;
				$db =& JFactory::getDBO();
				$db->setQuery($query);
				$case = $db->loadRow();
				
				//make sure we got a case back
				if(!isset($case[0]) || count($case)<=0) 
				{
					if(DEBUGIMAP) echo('No matching case found');
					$okay = false;
				}
				else //we got a case back, so process it
				{
					if(DEBUGIMAP) echo '    CaseID:'.$case[0]."\n";
					
					//get sender email address
					$sender = getSenderAddress($mail, $message);
					
					//get sender name
					$senderName = getSenderName($mail, $message);

					if(DEBUGIMAP) echo '    Sender:'.$sender."\n";
					if(DEBUGIMAP) echo '    SenderName:'.$senderName."\n";
					if(DEBUGIMAP) echo '    Author:'.$case[1]."\n";
					
					//for security reasons, check to see if the sender is either the case author, or a rep/admin in the system
					if(strtoupper($sender) != strtoupper($case[1])) //if the send is not the case author, check to see if they are a rep
					{
						//query for Huru rep/admin with Joomla email address matching our sender
						$query = 'SELECT COUNT(*) as count FROM #__hoduma_users AS hu LEFT OUTER JOIN #__users AS ju ON ju.id = hu.joomla_id WHERE ju.email=\''.$sender.'\'';
						$query = $query.' AND (hu.isrep = 1 OR hu.isadmin = 1)';
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						$count = $db->loadRow();
						
						if($count[0] <=0 )
						{
							if(DEBUGIMAP) echo("  Sender is not author/rep/admin\n"); //exit if the sender is not authorized to attach notes to this case
							$okay = false;
						}
					}
				}
				
				if($okay)
				{
					//if user is okay, create new note for case using info in message

					//get username of sender by querying Huru rep/admin with Joomla email address matching our sender
					$query = 'SELECT username FROM #__users WHERE email=\''.$sender.'\'';
					if(DEBUGIMAP) echo '    Query:'.$query."\n";
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$username = $db->loadRow();
					
					//if we didn't get a returned uid, then set it to the sendername
					if(!isset($username[0]) || strlen($username[0]) <=0) $u = $senderName;
					else $u = $username[0];
					if(DEBUGIMAP) echo '    SenderUsername:'.$u."\n";

					//set just the plain text of the message body text as the note text
					$body = getBody($mail, $message);

					if(createNote($case[0], 0, $sender, $u, $body, 5))
					{
						//get the case details for messages
						$query = "SELECT id, title, description, uid, uemail, uphone, ulocation, department, priority, category, start_date, rep, solution, entered_by FROM #__hoduma_problems ";
						$query = $query." WHERE id = ".$case[0]; 
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						$case = $db->loadRow();

						//get rep details 
						$query = "SELECT ju.email as email, ju.name as name, hh.pageraddress FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.id=".$case[11]." ORDER BY ju.username";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						$rep = $db->loadRow();

						//on update, only notify user if config is set to do so 
						if(config('notifyuser') == 1)
						{
							hh_sendmail('userupdate',$case[4],$case, true); //send update message
						}

						//notify rep of updates unless the rep is the one doing the changes
						hh_sendmail('repupdate',$rep[0],$case, true); //send update message

						if(config('imap_deletemessages')) imap_delete($mail, $message);
					}
					else
					{
						echo("Error saving note\n");
					} //end if note->store
				} //end if($okay)
				
				$existingcases += 1;
			
			} //end if($pos === false)
			
			if(DEBUGIMAP) echo "\n\n";
			
			$totalmessages += 1;
			
		} //end foreach($email...)
	} //end if($emails)
	
	//close the mailbox
	if(config('imap_deletemessages') && $emails) imap_close($mail, CL_EXPUNGE);
	else imap_close($mail);
	
	echo $totalmessages." messages processed: ".$newcases." new case(s), ".$existingcases." existing case(s).\n";
} //end if(config'imap_enabled'))


/*
Extracts the sender's email address from the message 'fromaddress'
*/
function getSenderAddress($mail, $message)
{
	$sender = imap_headerinfo($mail, $message)->fromaddress;
	if(DEBUGIMAP) echo '    Fromaddress:'.$sender."\n";

	$start = strpos($sender, '<');
	if(DEBUGIMAP) echo '    AddrStart:'.$start."\n";
	
	$end = strrpos($sender, '>');
	if(DEBUGIMAP) echo '    AddrEnd:'.$end."\n";

	$sender = substr($sender, $start+1 , $end-$start-1);
	
	return $sender;
}


/*
Extracts the sender's email address from the message 'fromaddress'
*/
function getSenderName($mail, $message)
{
	$sender = imap_headerinfo($mail, $message)->fromaddress;
	if(DEBUGIMAP) echo '    Fromaddress:'.$sender."\n";

	$start = strpos($sender, '<');
	if(DEBUGIMAP) echo '    AddrStart:'.$start."\n";
	
	$sender = trim(substr($sender, 0 , $start)); //get trimmed sender name
	
	if(strlen($sender)<=0) $sender = getSenderAddress($mail, $message); //if there is no name, just get the address
	
	$sender = str_replace('"','',$sender); //remove any quotes around name
	
	return $sender;
}


/*
finds the body part of the message, gets its decoded text and returns it
*/
function getBody($mail, $message)
{
	$body = get_part($mail, $message, "TEXT/PLAIN");
	if(DEBUGIMAP) echo "\n".$body."\n\n";

	return $body;
}


/*
creates and stores the note in the database
*/
function createNote($casenumber, $priv, $ip, $uid, $note, $eventcode)
{
	//create note that case was created
	$notesrow =& JTable::getInstance('Notes', 'Table');
	if(isset($notesrow))
	{
		$notesrow->id = ""; //auto increment set by database
		$notesrow->problem_id = $casenumber;
		$notesrow->eventcode = $eventcode;
		$notesrow->priv = $priv; 
		$notesrow->ip = $ip; //email sender won't have an IP so we'll use the email address instead
		$notesrow->adddate = date("Y/m/d H:i:s");
		$notesrow->uid = $uid;
		$notesrow->note = $note;

		if(DEBUGIMAP) echo '    CaseAddDate:'.$notesrow->adddate."\n";
		if(DEBUGIMAP) echo '    NoteUID:'.$notesrow->adddate."\n";

		if($notesrow->store())
		{
			return true;
		}
		else
		{
			if(DEBUGIMAP) echo "    Problem creating note for new case\n";
			return false;
		}
	}
	else
	{
		if(DEBUGIMAP) echo "    Problem opening note table note for new case\n";
		return false;
	}
}


/*
The following functions (get_mim_type and get_part) recursively get the parts of the email 
and return them correctly decoded message.  The functions come from 
http://www.linuxscope.net/articles/mailAttachmentsPHP.html
with just minor tweeking and formattting to help them fit in here
*/

function get_mime_type(&$structure) 
{
	$primary_mime_type = array("TEXT", "MULTIPART","MESSAGE", "APPLICATION", "AUDIO","IMAGE", "VIDEO", "OTHER");
	if($structure->subtype) return $primary_mime_type[(int) $structure->type] . '/' .$structure->subtype;
	
	return "TEXT/PLAIN";
}

function get_part($stream, $msg_number, $mime_type, $structure = false,$part_number    = false) 
{
	if(!$structure)	$structure = imap_fetchstructure($stream, $msg_number);
	
	if($structure) 
	{
		if($mime_type == get_mime_type($structure)) 
		{
			if(!$part_number) $part_number = "1";

			$text = imap_fetchbody($stream, $msg_number, $part_number);
			
//			if($structure->encoding == 3) return imap_base64($text); 
//			elseif($structure->encoding == 4) return imap_qprint($text);
//			else return $text;

			switch($structure->encoding)
			{
				case 1:
					return imap_utf8($text);
					break;
				case 3:
					return imap_base64($text);
					break;
				case 4:
					return imap_qprint($text);
					break;
				default:
					return $text;
					break;
			}
		}

		if($structure->type == 1) /* multipart */ 
		{
			while(list($index, $sub_structure) = each($structure->parts)) 
			{
				if($part_number) $prefix = $part_number.'.';
				else $prefix = null;
				
				$data = get_part($stream, $msg_number, $mime_type, $sub_structure,$prefix.($index + 1));

				if($data) return $data;
			} 
		} 
	} 
	return false;
} 





?>