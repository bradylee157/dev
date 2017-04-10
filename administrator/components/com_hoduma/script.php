<?php
/**
 * @package Hoduma
 * @copyright Copyright (c)2012 Hoduma.com
 * @license GNU General Public License version 3, or later
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
*/

defined('_JEXEC') or die('Restricted access');

class com_HodumaInstallerScript
{
	protected $_release = '1.0.12';
	
	function install($parent) 
	{
		echo '<p>' . JText::_('COM_HODUMA_INSTALL_TEXT') . '</p>';
		//$parent->getParent()->setRedirectURL('index.php?option=com_hoduma');
	}
 
	function uninstall($parent) 
	{
		echo '<p>' . JText::_('COM_HODUMA_UNINSTALL_TEXT') . '</p>';
	}
 
	function update($parent) 
	{
		echo '<p>' . JText::_('COM_HODUMA_UPDATE_TEXT') . '</p>';
	}
 
	function preflight($type, $parent) 
	{
		// $type is the type of change (install, update or discover_install)
		
		// this release does not work with Joomla prior to version 2.5
		$jversion = new JVersion();
		if(version_compare($jversion->getShortVersion(), '2.5', 'lt'))
		{
			JError::raiseWarning(null, 'Hoduma needs at least Joomla! 2.5 to run - please upgrade to Joomla! 2.5 or newer in order to use it.');
			return false;
		}
		?>
		
		<div style="width: 100%; background-color: lightgrey;">
		<div style="float: left; margin: 10px;">
			<h1>Hoduma</h1>
			<h2>Helpdesk for Joomla!&reg;</h2>
		</div>
		
		<?php
		if($type == 'update')
		{	
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('version')
					->from('#__hoduma')
					->where('id = 1');
			$db->setQuery((string)$query);
			$jitconfig = $db->loadObject();
			
			$oldRelease = $jitconfig->version;
			
			if(version_compare($this->_release, $oldRelease, 'le'))
			{
				JError::raiseWarning(null, 'Update from '. $oldRelease .' to '. $this->_release .' is not possible!');
				return false;
			}
			else
			{
				echo '<p>Update from '. $oldRelease .' to '. $this->_release .' successfull!</p>';
			}
		} else {
			echo '<p>' . JText::_('COM_HODUMA_PREFLIGHT_' . JString::strtoupper($type) . '_TEXT') . ' ' . $this->_release . '</p>';
		}
	}
 
	function postflight($type, $parent)
	{
		// $type is the type of change (install, update or discover_install)
		
		//Import filesystem libraries.
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.path');

		echo '<b>Update attachments folder:</b><br />';
		if(is_writable(JPATH_SITE . "/")) {
			if(!file_exists(JPATH_SITE . "/hoduma/")){
				if(mkdir(JPATH_SITE . "/hoduma/")) {
					print '<font color="green">'.JPATH_SITE . '/hoduma/ Successfully added!</font><br />';
				} else {
					print '<font color="red">'.JPATH_SITE . '/hoduma/ Failed to be to be created, please do so manually!</font><br />';
				}
			}  else {
				echo '<font color="green">'.JPATH_SITE . '/hoduma/ already exists!</font><br />';
			}
		} else {
			echo '<font color="red">ERROR! Root Folder is not writeable!<font><br />
			Please create the folder /hoduma manually!<br />';
		}
		
		if(!is_writable(JPATH_SITE . "/hoduma/")){
			if(!chmod(JPATH_SITE . "/hoduma/", 0755)) {
				echo "<font color=red>".JPATH_SITE . "/hoduma/ Failed to be chmod'd to 755 please do so manually!</font><br />";
			}
		}
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('version')
				->from('#__hoduma')
				->where('id = 1');
		$db->setQuery((string)$query);
		$jitconfig = $db->loadObject();
		$oldRelease = $jitconfig->version;
		
		//Update to version 1.0.0
		if(version_compare($oldRelease, '1.0.0', 'lt'))
		{
			// nothing to do
		}
		
		$query = $db->getQuery(true);
		$query->update('#__hoduma')
				->set('version = '.$db->quote($this->_release))
				->where('id = 1');
		$db->setQuery((string)$query);
		$db->query();
		
		echo '<p>' . JText::_('COM_HODUMA_POSTFLIGHT_' . JString::strtoupper($type) . '_TEXT') . '</p>';
		?>
		<div style="clear: both;">&nbsp;</div>
		</div>
		<?php
	}
}