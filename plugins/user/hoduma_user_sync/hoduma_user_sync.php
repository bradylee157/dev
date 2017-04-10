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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.event.plugin');
 
class plgUserHoduma_User_Sync extends JPlugin
{
	function onUserAfterSave($user, $isnew, $success, $msg)
	{
		//if this is a new user and was stored successfully, then import it into Huru
		if($isnew && $success)
		{
			//check plugin parameters to see if we should default things
			$isUser = $this->params->get('isUser');
			$publishUser = $this->params->get('publishUser');
			
			$userid = JArrayHelper::getValue($user, 'id', 0, 'int');

			//import new Joomla user into hoduma user table
			$db = JFactory::getDbo();
			$query = "INSERT INTO #__hoduma_users (joomla_id, isuser, published) VALUES (".$userid.", ".$isUser.", ".$publishUser.")";
			$db->setQuery($query);
			$db->query();
		}
		
		return true;
	}

	function onUserAfterDelete($user, $success, $msg)
	{

		//if user was deleted from Joomla successfully, then delete it from Huru
		if($success)
		{
			$userid = JArrayHelper::getValue($user, 'id', 0, 'int');
			
			$db = JFactory::getDbo();
			$query = "DELETE FROM #__hoduma_users WHERE joomla_id = ".$userid;
			$db->setQuery($query);
			$db->query();
		}
		
		return true;	
	}
}
?>