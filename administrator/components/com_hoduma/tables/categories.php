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
 
// import Joomla table library
jimport('joomla.database.table');
 
class HodumaTableCategories extends JTable
{
	function __construct(&$db) 
	{
		parent::__construct('#__hoduma_categories', 'id', $db);
	}

	public function bind($array, $ignore = '') 
	{
		if (isset($array['params']) && is_array($array['params'])) 
		{
			// Convert the params field to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string)$parameter;
		}
 
		// Bind the rules.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}
 
		return parent::bind($array, $ignore);
	}

	
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;
		return 'com_hoduma.category.'.(int) $this->$k;
	}
 
	protected function _getAssetTitle()
	{
		return $this->cname;
	}

	protected function _getAssetParentId()
	{
		$asset = JTable::getInstance('Asset');
		$asset->loadByName('com_hoduma');
		return $asset->id;
	}
}