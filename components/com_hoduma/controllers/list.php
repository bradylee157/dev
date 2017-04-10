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

//check user auth level
require_once JPATH_COMPONENT.DS.'helpers'.DS.'head.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'auth.php';

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
jimport('joomla.application.component.controller');

$mainframe = JFactory::getApplication();	
if(DEBUG) $mainframe->enqueueMessage('List controller');

class HodumaControllerList extends JController
{
	function display() 
	{
		$mainframe = JFactory::getApplication();	
		
		$view = $mainframe->getUserStateFromRequest('hh_list.view','view','');
		$type = $mainframe->getUserStateFromRequest('hh_list.type','type','');
		
		if(!$view)
		{
			JRequest::setVar('view', 'list');
		}
		if(!$type)
		{
			JRequest::setVar('type', 'assigned');
		}
		parent::display();
	}	

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view','cpanel');

		//call up the cpanel screen controller
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'cpanel.php');
	}
}

$controller = new HodumaControllerList();
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

