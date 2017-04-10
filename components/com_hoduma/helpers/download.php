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

// real path depending on the type of server
if (stristr( $_SERVER['SERVER_SOFTWARE'], 'win32' )) 
{
	define( 'JPATH_BASE', realpath(dirname(__FILE__).'\..\..\..' ));
}
else define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ));

define( 'DS', DIRECTORY_SEPARATOR );

// loading framework of Joomla!
require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
/************************************************************************************************************
End Joomla framework load
*************************************************************************************************************/

//load the hoduma header file
require_once JPATH_BASE.DS.'components'.DS.'com_hoduma'.DS.'helpers'.DS.'head.php';

//get the attachment id
$attachment_id = JRequest::getInt('id', '-1');
$note_id = JRequest::getInt('note_id', '-1');
$name = JRequest::getVar('name', '');

//make sure we got valid attachment info to work with before proceeding
if($attachment_id != -1 && $note_id != -1 && strlen($name)>0) 
{
	$db =& JFactory::getDBO();
	
	//verify that attachment with given id, note_id and name exists
	//the name and note_id checks are so that people can't throw random numbers at this script and
	//thereby gain access to an attachment by guessing the id
	$query = "SELECT COUNT(*) FROM #__hoduma_attachments WHERE id = ".$attachment_id." AND note_id=".$note_id." AND name='".$name."'";
	$db->setQuery($query);
	$count = $db->loadResult();

	if($count > 0)
	{
		//get the attachment
		$query = "SELECT name, type, size, content, location FROM #__hoduma_attachments WHERE id = ".$attachment_id." AND note_id=".$note_id." AND name='".$name."'";
		$db->setQuery($query);
		$file = $db->loadAssoc();
		
		//send file header info to browser
		header("Content-length: ".$file['size']);
		header("Content-type: ".$file['type']);
		header("Content-Disposition: attachment; filename=".$file['name']);

		//check to see if the file was saved in the database or in the filesystem
		if(strlen($file['location']) > 0) //if there is location data, the file was saved in the filesystem
		{
			//open the file for reading
			$fp = fopen($file['location'], 'r');
			$content = fread($fp, filesize($file['location']));
			fclose($fp);
			
			//send the attachment file content to the browser
			echo $content;
		}
		else //if there is no location data, send the database record content
		{
			//send the attachment record data to the browser
			echo $file['content'];
		}
	}
	else echo lang('AttachmentFileNotFound');
}
?>