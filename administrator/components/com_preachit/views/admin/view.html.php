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

class PreachitViewAdmin extends JView

{

function display($tpl = null)

{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$db =& JFactory::getDBO();

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/forms.php');
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.version.php');

$row =& JTable::getInstance('Piadmin', 'Table');
$id = '1';
$this->assignRef('row', $row);

$row->load($id);

// get the Form
	
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	
      
$id = 1;
$this->assignRef('id', $id);
$user	= JFactory::getUser();
$this->form = $form;
$this->setLayout('form16');	

//codeset list

$codeset = array(
array('value' => 'general', 'text' => JText::_('general')),
array('value' => 'unicode', 'text' => JText::_('unicode')),
array('value' => 'czech', 'text' => JText::_('czech')),
array('value' => 'danish', 'text' => JText::_('danish')),
array('value' => 'esperato', 'text' => JText::_('esperato')),
array('value' => 'estonian', 'text' => JText::_('estonian')),
array('value' => 'icelandic', 'text' => JText::_('icelandic')),
array('value' => 'latvian', 'text' => JText::_('latvian')),
array('value' => 'lithuanian', 'text' => JText::_('lithuanian')),
array('value' => 'persian', 'text' => JText::_('persian')),
array('value' => 'polish', 'text' => JText::_('polish')),
array('value' => 'roman', 'text' => JText::_('roman')),
array('value' => 'romanian', 'text' => JText::_('romanian')),
array('value' => 'slovak', 'text' => JText::_('slovak')),
array('value' => 'slovenian', 'text' => JText::_('slovenian')),
array('value' => 'spanish2', 'text' => JText::_('spanish2')),
array('value' => 'spanish', 'text' => JText::_('spanish')),
array('value' => 'swedish', 'text' => JText::_('swedish')),
array('value' => 'turkish', 'text' => JText::_('turkish')),
array('value' => 'bin', 'text' => JText::_('bin')),
);

$this->assignRef('codeset', JHTML::_('select.genericList', $codeset, 'codeset', 'class="inputbox" '. '', 'value', 'text', 'general' ));

// get table version

$ad = '#__pibckadmin';
$fields = $db->getTableFields( array( $ad ) );
$entry = false;
$entry	= isset( $fields[$ad]['tableversion'] );
$check = $entry;	
if ($entry)
{
$query = "
  SELECT ".$db->nameQuote('tableversion')."
    FROM ".$db->nameQuote('#__pibckadmin')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
$db->setQuery($query);
$currentversion = $db->loadResult();

}
else $currentversion = '';
$tableversion = '('.JText::_('COM_PREACHIT_ADMIN_BCKADMIN_TABLE_VERSION').': '.$currentversion.')';
$latestversion = PIVersion::versionXML();
if ($currentversion != $latestversion)
{
    $tableversion .= '<span style="display: block; margin: 0 0 0 10px;" class="piupgrade">['.JText::_('Upgrade').': '.$latestversion.']</span>';
}
$this->assignRef('tableversion', $tableversion);

// get permission for certain admin tasks
$allow = false;
$user =& JFactory::getUser();
if ($user->authorize('core.admin', 'com_preachit'))
{$allow = true;}

$this->assignRef('allow', $allow);

$this->addToolbar();

parent::display($tpl);

}

/**
     * Add the page title and toolbar.
     *
     * @since    1.6
     */
protected function addToolbar()
{
$user    = JFactory::getUser();   
JToolBarHelper::title( JText::_( 'COM_PREACHIT_BCKADMIN_TITLE' ), 'admin.png' );
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::apply();
JToolBarHelper::divider();
JToolBarHelper::preferences('com_preachit', '550', '900');
JToolBarHelper::divider();
JToolBarHelper::help('pihelp', 'com_preachit');
}
}
}