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

defined('_JEXEC') or die('Restricted Access');

// Access check
if(!JFactory::getUser()->authorise('core.manage', 'com_hoduma'))
{
	return JERROR::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once (JPATH_COMPONENT_ADMINISTRATOR.'/liveupdate/liveupdate.php');
if(JRequest::getCmd('view','') == 'liveupdate') {
	LiveUpdate::handleRequest();
	return;
}

// import joomla controller library
jimport('joomla.application.component.controller');

// require helper file
JLoader::register('HodumaHelper', dirname(__FILE__) . '/helpers/hoduma.php');

// Get an instance of the controller prefixed by Hoduma
$controller = JController::getInstance('Hoduma');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();