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

class HodumaControllerSearch extends JController
{
	function display()
	{
		$mainframe = JFactory::getApplication();	
		
		//clean up the user state vars that may have been set during a previous search
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

		$view = JRequest::getVar('view');
		$stype = $mainframe->getUserStateFromRequest('hh_list.stype','stype','');
		if(!$view)
		{
			JRequest::setVar('view', 'search');
		}
		if(!$stype)
		{
			JRequest::setVar('stype', 'kb');
		}
		parent::display();
	}	

	function find()
	{
		JRequest::setVar('stype',JRequest::getVar('stype','','','string',JREQUEST_ALLOWRAW));
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'list.php');
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

$controller = new HodumaControllerSearch();
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

