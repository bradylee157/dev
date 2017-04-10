<?php
/**
 * @package 	mod_bt_contentslider - BT ContentSlider Module
 * @version		1.1
 * @created		Oct 2011

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class JElementBtcategory extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'btategory';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();

		$section	= $node->attributes('section');
		$class		= $node->attributes('class');
		
		
		if (!$class) {
			$class = "inputbox";
		}
		$attr =  'class="'.$class.'" ';
		$attr .= $node->attributes('size') ? ' size="'.(int) $node->attributes('size').'"' : '';
		$attr .= $node->attributes('multiple') ? ' multiple="multiple"' : '';
		if (!isset ($section)) {
			// alias for section
			$section = $node->attributes('scope');
			if (!isset ($section)) {
				$section = 'content';
			}
		}

		if ($section == 'content') {
			// This might get a conflict with the dynamic translation - TODO: search for better solution
			$query = 'SELECT c.id, CONCAT_WS( "/",s.title, c.title ) AS title' .
				' FROM #__categories AS c' .
				' LEFT JOIN #__sections AS s ON s.id=c.section' .
				' WHERE c.published = 1' .
				' AND s.scope = '.$db->Quote($section).
				' ORDER BY s.title, c.title';
		} else {
			$query = 'SELECT c.id, c.title' .
				' FROM #__categories AS c' .
				' WHERE c.published = 1' .
				' AND c.section = '.$db->Quote($section).
				' ORDER BY c.title';
		}
		$db->setQuery($query);
		$options = $db->loadObjectList();
		array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'id', 'title'));

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]',  trim($attr) , 'id', 'title', $value, $control_name.$name );
	}
}