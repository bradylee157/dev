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
 
class HodumaControllerImport extends JControllerAdmin
{

	protected $text_prefix = 'COM_HODUMA_IMPORT';
	
	public function getModel($name = 'Import', $prefix = 'HodumaModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
	
	public function transferusers()
	{
		$db	= JFactory::getDBO();
		//transfer users
		$query1 = $db->getQuery(true);
		$query1->select('u.id')
				->from('#__users AS u')
				->where('u.id NOT IN (SELECT joomla_id FROM #__hoduma_users)');
		$db->setQuery($query1);
		$db->query();
		if($db->getNumRows() > 0)
		{
			$husers = $db->loadObjectList();
			foreach($husers AS $huser)
			{
				$query2 = $db->getQuery(true);
				$query2->insert('#__hoduma_users')
						->set("joomla_id = " . $db->quote($huser->id) . ", isuser=1, isrep=0, isadmin=0, published=1");
				$db->setQuery($query2);
				$db->query();
			}
		}
		return true;
	}
}