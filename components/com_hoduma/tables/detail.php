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

defined('_JEXEC') or die('Restricted access');
//check user auth level
require_once JPATH_COMPONENT.DS.'helpers'.DS.'head.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'auth.php';
$mainframe = JFactory::getApplication();	
if(!checkusermin('user') && !config('allowanonymous')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

/*
NOTE: If we make any changes to this class, we need to make similar changes to helpers/imap.php
because the class is duplicated there.
*/

class HodumaTableDetail extends JTable
{
	var $id = null;
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
