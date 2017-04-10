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
require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'auth.php'; //sends us to the core helper files
$mainframe = JFactory::getApplication();
if(!checkuser('admin')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

jimport('joomla.application.component.view');

class HodumaViewAbout extends JView
{
	function display($tpl = null)
	{
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
		JToolBarHelper::title(JText::_('COM_HODUMA_ABOUT'), 'about');
		JToolBarHelper::back('JTOOLBAR_BACK', 'index.php?option=com_hoduma');
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_hoduma');
		}
	}

	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_HODUMA_ABOUT'));
		$document->addStyleSheet( JURI::base() . 'media/com_hoduma/css/hoduma.css' );
	}
}