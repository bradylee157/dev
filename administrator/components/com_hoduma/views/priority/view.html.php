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

class HodumaViewPriority extends JView
{
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		// Script not needed at the moment
		//$script = $this->get('Script');
 
		// Check for errors
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form 	= $form;
		$this->item 	= $item;
		// Script not needed at the moment
		//$this->script = $script;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->item->id == 0;
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo = HodumaHelper::getActions($this->item->id, 'priority');
		$this->canDo = $canDo;
		JToolBarHelper::title($isNew ? JText::_('COM_HODUMA_MANAGER_PRIORITY_NEW') : JText::_('COM_HODUMA_MANAGER_PRIORITY_EDIT'), 'priority');
		// Built the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('priority.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('priority.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('priority.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
		}
		else
		{
			if ($canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('priority.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('priority.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) 
				{
					JToolBarHelper::custom('priority.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::custom('priority.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}
		}
		JToolBarHelper::cancel('priority.cancel', 'JTOOLBAR_CANCEL');
	}

	protected function setDocument() 
	{
		$isNew = $this->item->id == 0;
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_HODUMA_PRIORITY_CREATING') : JText::_('COM_HODUMA_PRIORITY_EDITING'));
		// Script not needed at the moment
		//$document->addScript(JURI::root() . $this->script);
		//$document->addScript(JURI::root() . "/administrator/components/com_hoduma/views/priority/submitbutton.js");
		JText::script('COM_HODUMA_PRIORITY_ERROR_UNACCEPTABLE');
	}
}