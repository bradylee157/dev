<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PreachitViewPlginsert extends JView
{
function display($tpl = null)
{

$db =& JFactory::getDBO();

//message list

$db->setQuery('SELECT id AS value, CONCAT(id," - ",study_name) AS text FROM #__pistudies ORDER by id DESC');
$message = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_MESSAGE_SELECT')),
);
$messagelist = array_merge( $message, $db->loadObjectList() );

$this->assignRef('piid', JHTML::_('select.genericList', $messagelist, 'piid', 'class="inputbox" '. '', 'value', 'text', '' ));

$view = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_EDITOR_BUTTON_SELECT_VIEW')),
array('value' => 'list', 'text' => JText::_('COM_PREACHIT_EDITOR_BUTTON_LIST')),
array('value' => 'video', 'text' => JText::_('COM_PREACHIT_EDITOR_BUTTON_VIDEO')),
array('value' => 'audio', 'text' => JText::_('COM_PREACHIT_EDITOR_BUTTON_AUDIO')),
);

$this->assignRef('piview', JHTML::_('select.genericList', $view, 'piview', 'class="inputbox" '. '', 'value', 'text', '' ));

	
parent::display($tpl);
}
}