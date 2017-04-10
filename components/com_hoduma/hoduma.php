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

jimport('joomla.application.component.controller');

$params = JComponentHelper::getParams( 'com_hoduma' );
if($params->get('set_maxjoinsize') == 1 AND $params->get('maxjoinsize') > 0)
{
	$db = JFactory::getDbo();
	$db->setQuery('SET max_join_size=' . $params->get('maxjoinsize'));
	$db->query();
}

// Get the view and controller from the request, or set to default if they weren't set
JRequest::setVar('view', JRequest::getCmd('view','cpanel'));
JRequest::setVar('cont', JRequest::getCmd('view','cpanel')); // Get controller based on the selected view

jimport('joomla.filesystem.file');

// Load the appropriate controller
$cont = JRequest::getCmd('cont','cpanel');
$path = JPATH_COMPONENT.DS.'controllers'.DS.$cont.'.php';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
else
{
	// Invalid controller was passed
	JError::raiseError('500',JText::_('Unknown controller' . $path));
}