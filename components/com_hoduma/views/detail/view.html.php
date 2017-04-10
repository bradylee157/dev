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
$mainframe = &JFactory::getApplication();	
if(!checkusermin('user') && !config('allowanonymous')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

jimport('joomla.application.component.view');

class HodumaViewDetail extends JView
{
	function display($tpl = null)
	{
		$mainframe = &JFactory::getApplication();	
		$option = JRequest::getCmd('option');
		
		$doc = JFactory::getDocument();
		$doc->addStyleSheet( JURI::base() . 'media/com_hoduma/css/hoduma.css' );
		$doc->addScript( JURI::base() . 'media/com_hoduma/js/head.js' );
		$doc->addScript( JURI::base() . 'media/com_hoduma/js/validation.js' );
		$doc->addScript( JURI::base() . 'media/com_hoduma/js/problem.js' );
		$doc->addScript( JURI::base() . 'media/com_hoduma/js/bbeditor/ed.js' );
	
		$app = JFactory::getApplication('site');
		$cparams = $app->getParams( 'com_hoduma' );
		
		$this->cparams = $cparams;
		
		//page variables
		$task = JRequest::getVar('task', '');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$type = JRequest::getVar('type','','post','string',JREQUEST_ALLOWRAW);
		$Itemid = JRequest::getVar('Itemid');
		$this->assignRef('task',$task);
		$this->assignRef('cid[]',$cid);
		$this->assignRef('type',$type);
		$this->assignRef('Itemid',$Itemid);

		//record detail
		$row =& JTable::getInstance('Detail','HodumaTable');
		$id = safe($cid[0]);

		if(!is_numeric($id)) $id = -1; //stops SQL injection that can occur with cid[] var passed in URL
		
		if(($id != -1 && $row->load($id)) || $id == -1) //load will be true only if a record is found, $id will be -1 or new cases
		{
			$this->assignRef('row',$row);
			$this->assignRef('id',$id);
			$this->assignRef('uid',$uid);
			$this->assignRef('uemail',$uemail);
			$this->assignRef('ulocation',$ulocation);
			$this->assignRef('uphone',$uphone);
			$this->assignRef('rep',$rep);
			$this->assignRef('status',$status);
			$this->assignRef('time_spent',$time_spent);
			$this->assignRef('category',$category);
			$this->assignRef('close_date',$close_date);
			$this->assignRef('department',$department);
			$this->assignRef('title',$title);
			$this->assignRef('description',$description);
			$this->assignRef('solution',$solution);
			$this->assignRef('start_date',$start_date);
			$this->assignRef('priority',$priority);
			$this->assignRef('entered_by',$entered_by);
			$this->assignRef('kb',$kb);
		}
		else
		{
			$mainframe->redirect('index.php?option='.JRequest::getCmd('option').'&Itemid='.$Itemid, JText::_(lang('NotFound')));
		}

		parent::display($tpl);
	}
}