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
// load language file
$lang = & JFactory::getLanguage();
$lang->load('com_preachit', JPATH_ADMINISTRATOR);
class PreachitViewAddrecord extends JView
{
function display($tpl = null)
{
$user	= JFactory::getUser();
// get Joomla version
JHTML::_( 'behavior.mootools' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403();}


$host = JURI::root();
$document =& JFactory::getDocument();
$document->addStylesheet($host.'components/com_preachit/assets/css/preachit.css');

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
$this->setLayout('default');	
parent::display($tpl);
}
}