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
$mainframe = JFactory::getApplication();	
if(!checkusermin('user')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
jimport('joomla.application.component.controller');

class HodumaControllerEditInfo extends JController
{
	function save()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		$option = JRequest::getCmd('option');

		$row = JTable::getInstance('EditInfo', 'HodumaTable');
		if (!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError());
		}
		$row->id = currentuserinfo('hoduma_id'); //makes sure we are editing the current user only - no hacks
		$row->phone = safe(JRequest::getVar('phone','','post','string',JREQUEST_ALLOWRAW));
		$row->phonehome = safe(JRequest::getVar('phonehome','','post','string',JREQUEST_ALLOWRAW));
		$row->phonemobile = safe(JRequest::getVar('phonemobile','','post','string',JREQUEST_ALLOWRAW));
		$row->pageraddress = safe(JRequest::getVar('pageraddress','','post','string',JREQUEST_ALLOWRAW));
		$row->location1 = safe(JRequest::getVar('location1','','post','string',JREQUEST_ALLOWRAW));
		$row->location2 = safe(JRequest::getVar('location2','','post','string',JREQUEST_ALLOWRAW));
		$row->department = safe(JRequest::getVar('department','','post','int',JREQUEST_ALLOWRAW));
		$row->language = safe(JRequest::getVar('language','','post','int',JREQUEST_ALLOWRAW));
		
		if(!$row->store())
		{
			JError::raiseError(500, $row->getError());
		}
		
		$this->setRedirect('index.php?option=' . JRequest::getCmd('option') . '&view=editinfo&Itemid='.JRequest::getVar('Itemid'), 'Profile Saved');
	}
	
	function edit()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		JRequest::setVar('view','editinfo');
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
	
$controller = new HodumaControllerEditInfo();
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
