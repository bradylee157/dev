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
class PreachitViewPodcastedit extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
$id = $cid[0];
$this->assignRef('id', $id);

$row =& JTable::getInstance('Podcast', 'Table');
$row->load($id);
$this->assignRef('row', $row);

// get the Form
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	

$user	= JFactory::getUser();
if ($id > 0)
{
if (!$user->authorize('core.edit', 'com_preachit')) 
{Tewebcheck::check403();}
}
else 
{
if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403();}
}

$this->form = $form;
$this->setLayout('form16');
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
if ($this->id > 0)
{
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_PODCASTS_EDIT' ), 'podcast.png' );
}
else
{
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_PODCASTS_DETAILS' ), 'podcast.png' );
}
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::divider();
JToolBarHelper::custom('publishxml', 'publishxml.png', 'publishxml.png', 'COM_PREACHIT_ADMIN_BUTTON_WRITE_XML', false);
JToolBarHelper::divider();
$user    = JFactory::getUser();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
if ($this->id > 0)
{
JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
}
else
{
JToolBarHelper::cancel();
}
JToolBarHelper::divider();
JToolBarHelper::help('pihelp', 'com_preachit');
}

}