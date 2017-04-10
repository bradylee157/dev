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
require_once JPATH_COMPONENT.DS.'helpers'.DS.'auth.php';

jimport('joomla.application.component.view');

class HodumaViewCPanel extends JView
{
	function display($tpl = null)
	{
		$doc = JFactory::getDocument();
		$doc->addStyleSheet( JURI::base() . 'media/com_hoduma/css/hoduma.css' );
		$doc->addScript( JURI::base() . 'media/com_hoduma/js/head.js' );
		
		$app = JFactory::getApplication('site');
		$cparams = $app->getParams( 'com_hoduma' );
		
		$this->cparams = $cparams;
		
		parent::display($tpl);
	}
	
}