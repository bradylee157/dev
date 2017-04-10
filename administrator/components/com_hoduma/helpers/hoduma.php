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
 
abstract class HodumaHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_CPANEL'), 'index.php?option=com_hoduma', $submenu == 'cpanel');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_CATEGORIES'), 'index.php?option=com_hoduma&view=categories', $submenu == 'categories');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_DEPARTMENTS'), 'index.php?option=com_hoduma&view=departments', $submenu == 'departments');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_PRIORITIES'), 'index.php?option=com_hoduma&view=priorities', $submenu == 'priorities');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_STATUSES'), 'index.php?option=com_hoduma&view=statuses', $submenu == 'statuses');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_USERS'), 'index.php?option=com_hoduma&view=users', $submenu == 'users');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_EMAILS'), 'index.php?option=com_hoduma&view=emails', $submenu == 'emails');
		JSubMenuHelper::addEntry(JText::_('COM_HODUMA_SUBMENU_ABOUT'), 'index.php?option=com_hoduma&view=about', $submenu == 'about');
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-cpanel {background-image: url(../media/com_hoduma/images/hoduma-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-hoduma {background-image: url(../media/com_hoduma/images/hoduma-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-categories {background-image: url(../media/com_hoduma/images/categories-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-category {background-image: url(../media/com_hoduma/images/categories-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-departments {background-image: url(../media/com_hoduma/images/departments-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-department {background-image: url(../media/com_hoduma/images/departments-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-priorities {background-image: url(../media/com_hoduma/images/priorities-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-priority {background-image: url(../media/com_hoduma/images/priorities-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-statuses {background-image: url(../media/com_hoduma/images/statuses-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-status {background-image: url(../media/com_hoduma/images/statuses-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-users {background-image: url(../media/com_hoduma/images/users-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-user {background-image: url(../media/com_hoduma/images/users-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-about {background-image: url(../media/com_hoduma/images/about-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-wizard {background-image: url(../media/com_hoduma/images/wizard-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-mails {background-image: url(../media/com_hoduma/images/mails-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-mail {background-image: url(../media/com_hoduma/images/mails-48x48.png);}');
	}
	
	public static function getActions($Id = 0, $Asset = NULL)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
 
		if($Asset == NULL)
		{
			$assetName = 'com_hoduma';
		 
			$actions = array(
				'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete', 'core.edit.state', 'core.edit.state'
			);
		} else
		{
			$assetName = 'com_hoduma.'. $Asset . '.' . (int) $Id;
			
			$actions = array(
				'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.edit.own', 'core.delete'
			);
		}
 
		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}
 
		return $result;
	}
}