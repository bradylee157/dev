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
if(!checkuser('reports')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

jimport('joomla.application.component.model');

class HodumaModelReport extends JModel
{
	var $data = null;
	
	function getData()
	{
		$mainframe = JFactory::getApplication();	
		$rtype = JRequest::getVar('rtype');
		
		//stub for where clause
		$where = ' WHERE TRUE';
		
		//setup for date restrictions
		$startdate = safe(trim(JRequest::getVar('startdate','','','string',JREQUEST_ALLOWRAW)));
		$enddate = safe(trim(JRequest::getVar('enddate','','','string',JREQUEST_ALLOWRAW)));
		if(strlen($startdate)>0 && strlen($enddate)>0) $where = $where.' AND DATE_FORMAT(p.start_date,\'%Y-%m-%d\') >= \''.$startdate.'\' AND DATE_FORMAT(p.start_date,\'%Y-%m-%d\') <= \''.$enddate.'\'';
		
		if(DEBUG) dumpdebug($rtype);
		
		//build query clause based on type
		switch ($rtype)
		{
			case 'department':
				$select = "SELECT d.dname AS name, Count(*) AS total, sum(p.time_spent) AS total_time  FROM #__hoduma_problems AS p INNER JOIN #__hoduma_departments AS d ON p.department = d.id";
				$group = " GROUP BY dname ORDER BY dname ASC";
				break;
			case 'category':
				$select = "SELECT c.cname AS name, Count(*) AS total, sum(p.time_spent) AS total_time FROM #__hoduma_problems AS p INNER JOIN #__hoduma_categories AS c ON p.category = c.id ";
				$group = " GROUP BY cname ORDER BY cname ASC";
				break;
			case 'rep':
				$select = "SELECT ju.name AS name, Count(*) AS total, sum(p.time_spent) AS total_time FROM  #__hoduma_problems AS p LEFT OUTER JOIN  #__hoduma_users AS hh ON p.rep = hh.id LEFT OUTER JOIN  #__users AS ju ON ju.id = hh.joomla_id";
				$group = " GROUP BY ju.name ORDER BY ju.name ASC";
				break;
		}
		
		$query = $select.$where.$group;
		if(DEBUG) dumpdebug($query);

		$this->data = $this->_getList($query);

		return $this->data;
	}	
}
