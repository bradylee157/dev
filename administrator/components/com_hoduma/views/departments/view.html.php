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
 
// import Joomla view library
jimport('joomla.application.component.view');

class HodumaViewDepartments extends JView
{
	function display($tpl = null) 
	{
		// Get data from the model
		$state			= $this->get('State');
		$items 			= $this->get('Items');
		$pagination 	= $this->get('Pagination');
		
		$user = JFactory::getUser();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->state = $state;
		$this->items = $items;
		$this->pagination = $pagination;
		$this->user = $user;
		
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	protected function addToolBar() 
	{
		$canDo = HodumaHelper::getActions();
		JToolBarHelper::title(JText::_('COM_HODUMA_MANAGER_DEPARTMENTS'), 'departments');
		JToolBarHelper::back('JTOOLBAR_BACK', 'index.php?option=com_hoduma');
		if ($canDo->get('core.create'))
		{
			JToolBarHelper::addNew('department.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit') || $canDo->get('core.edit.own')) 
		{
			JToolBarHelper::editList('department.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publish('departments.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('departments.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			//JToolBarHelper::divider();
			//JToolBarHelper::archiveList('departments.archive');
		}
		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'departments.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::trash('departments.trash');
		}
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_hoduma');
		}
	}

	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_HODUMA_DEPARTMENTS'));
	}
}