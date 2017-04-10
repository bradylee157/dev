<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Teweblists {

/**
	 * Method to get statelist
	 *
	 * @return	string
	 */

function getstatelist($value, $name)
{
$selectstate = array(
array('value' => '5', 'text' => JTEXT::_('LIB_TEWEB_STATE_SELECT')),
array('value' => '1', 'text' => JText::_('LIB_TEWEB_STATE_JPUBLISHED')),
array('value' => '0', 'text' => JText::_('LIB_TEWEB_STATE_JUNPUBLISHED')),
array('value' => '-2', 'text' => JText::_('LIB_TEWEB_STATE_JTRASH')),
);
$statelist = JHTML::_('select.genericList', $selectstate, $name, 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $value );
return $statelist;
}

}
?>