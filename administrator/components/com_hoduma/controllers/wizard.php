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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
class HodumaControllerWizard extends JControllerAdmin
{

	protected $text_prefix = 'COM_HODUMA_WIZARD';
	
	public function getModel($name = 'Wizard', $prefix = 'HodumaModel') 
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
	
	public function checkHuru()
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('COUNT(*) AS rowcount')
				->from('#__extensions')
				->where("name = 'huruhelpdesk' AND type = 'component'");
		$db->setQuery((string)$query);
		$result = $db->loadObject();
		
		if($result->rowcount != 1) {
			return false;
		}
		return true;
	}
	
	public function transferattachments()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer attachments
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_attachments';
		$query2 = 'INSERT INTO #__hoduma_attachments (id, note_id, name, type, size, content, location)'
				.' SELECT id, note_id, name, type, size, content, location'
				.' FROM #__huruhelpdesk_attachments';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		return true;
	}
	
	public function transfercategories()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer categories
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_categories';
		$query2 = 'INSERT INTO #__hoduma_categories (id, cname, rep_id)'
				.' SELECT category_id, cname, rep_id'
				.' FROM #__huruhelpdesk_categories';
		$query3 = 'UPDATE #__hoduma_categories SET published = 1';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		$db->setQuery($query3);
		$db->query();
		return true;
	}
	
	public function transferdepartments()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer departments
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_departments';
		$query2 = 'INSERT INTO #__hoduma_departments (id, dname)'
				.' SELECT department_id, dname'
				.' FROM #__huruhelpdesk_departments';
		$query3 = 'UPDATE #__hoduma_departments SET published = 1';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		$db->setQuery($query3);
		$db->query();
		return true;
	}
	
	public function transferemailmsg()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer emailmsg
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_emailmsg';
		$query2 = 'INSERT INTO #__hoduma_emailmsg (id, type, subject, body)'
				.' SELECT id, type, subject, body'
				.' FROM #__huruhelpdesk_emailmsg';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		return true;
	}
	
	public function transfernotes()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer notes
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_notes';
		$query2 = 'INSERT INTO #__hoduma_notes (id, problem_id, note, adddate, uid, priv)'
				.' SELECT note_id, id, note, adddate, uid, priv'
				.' FROM #__huruhelpdesk_notes';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		return true;
	}
	
	public function transferpriorities()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer priorities
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_priorities';
		$query2 = 'INSERT INTO #__hoduma_priorities (id, pname)'
				.' SELECT priority_id, pname'
				.' FROM #__huruhelpdesk_priority';
		$query3 = 'UPDATE #__hoduma_priorities SET published = 1';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		$db->setQuery($query3);
		$db->query();
		return true;
	}
	
	public function transferproblems()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer problems
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_problems';
		$query2 = 'INSERT INTO #__hoduma_problems (id, uid, uemail, ulocation, uphone, rep, status, time_spent, category, close_date, department, title, description, solution, start_date, priority, entered_by, kb)'
				.' SELECT id, uid, uemail, ulocation, uphone, rep, status, time_spent, category, close_date, department, title, description, solution, start_date, priority, entered_by, kb'
				.' FROM #__huruhelpdesk_problems';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		return true;
	}
	
	public function transferstatuses()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer statuses
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_statuses';
		$query2 = 'INSERT INTO #__hoduma_statuses (id, status_id, sname)'
				.' SELECT id, status_id, sname'
				.' FROM #__huruhelpdesk_status';
		$query3 = 'UPDATE #__hoduma_statuses SET published = 1';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		$db->setQuery($query3);
		$db->query();
		return true;
	}
	
	public function transferusers()
	{
		if($this->checkHuru() == false) {
			return false;
		}
		$db	= JFactory::getDbo();
		//transfer users
		$query1 = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		$query1 = 'DELETE FROM #__hoduma_users';
		$query2 = 'INSERT INTO #__hoduma_users (id, joomla_id, isuser, isrep, isadmin, phone, pageraddress, phonemobile, phonehome, location1, location2, department, language, viewreports)'
				.' SELECT id, joomla_id, isuser, isrep, isadmin, phone, pageraddress, phonemobile, phonehome, location1, location2, department, language, viewreports'
				.' FROM #__huruhelpdesk_users';
		$query3 = 'UPDATE #__hoduma_users SET published = 1';
		$db->setQuery($query1);
		$db->query();
		$db->setQuery($query2);
		$db->query();
		$db->setQuery($query3);
		$db->query();
		return true;
	}
}