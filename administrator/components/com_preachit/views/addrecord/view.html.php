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
class PreachitViewAddrecord extends JView
{
function display($tpl = null)
{
// get Joomla version
JHTML::_( 'behavior.mootools' );

$record = JRequest::getVar('record', '');
$this->assignRef('record', $record);

if ($record == 'teacher')
{$heading = JText::_('COM_PREACHIT_ADMIN_TEACHERS_DETAILS');}
elseif ($record == 'series')
{$heading = JText::_('COM_PREACHIT_ADMIN_SERIES_DETAILS');}
elseif ($record == 'ministry')
{$heading = JText::_('COM_PREACHIT_ADMIN_MINISTRY_DETAILS');}
else {$heading = '';}
$this->assignRef('heading', $heading);

//various yes no selectors
$this->assignRef('tview', JHTML::_('select.booleanlist', 'tview', 'class="inputbox"', 1));
	
parent::display($tpl);
}
}