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

jimport('joomla.application.component.view');

class HodumaViewCPanel extends JView
{
	function display($tpl = null) 
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('version')
				->from('#__hoduma')
				->where('id=1');
		$db->setQuery($query);
		$version = $db->loadResult();
		
		// assign to the view
		$this->version = $version;
		
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
		JToolBarHelper::title(JText::_('COM_HODUMA_MANAGER'), 'hoduma');
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_hoduma');
		}
	}

	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_HODUMA'));
		$document->addStyleSheet( JURI::root() . 'media/com_hoduma/css/hoduma.css' );
	}
}