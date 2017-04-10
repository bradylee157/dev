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
if(!checkuser('admin')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

jimport('joomla.application.component.model');

class HodumaModelActivity extends JModel
{
	var $data = null;
	
	function getData()
	{
		$mainframe = &JFactory::getApplication();	
		
		//build query clause
		$select = "SELECT p.title AS title, p.start_date AS start_date, p.close_date AS close_date, s.sname AS sname, maxresults.maxdate AS maxdate FROM #__hoduma_problems AS p LEFT OUTER JOIN #__hoduma_statuses AS s ON p.status = s.id LEFT OUTER JOIN (SELECT max(addDate) as maxdate, id FROM #__hoduma_notes GROUP BY id) maxresults ON p.id = maxresults.id";

		//build where clause
		$days = safe(JRequest::getVar('days','','','int'));
		if($days) 
		{
			$where = ' WHERE ';
			$where = $where.' maxresults.maxdate >= DATE_SUB(CURDATE(), INTERVAL '.$days.' DAY)';
			$where = $where.' OR (maxresults.maxdate IS NULL AND p.start_date >= DATE_SUB(CURDATE(), INTERVAL '.$days.' DAY))';
		}
		else {
			$where = null;
		}
	
		$order = ' ORDER BY s.status_id DESC, maxresults.maxdate ASC';

		$query = $select.$where.$order;
		
		if(DEBUG) dumpdebug($query);

		$this->data = $this->_getList($query);

		return $this->data;
	}	
}
