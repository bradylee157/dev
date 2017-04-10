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
class PreachitViewTemplateedit extends JView
{
function display($tpl = null)
{
JRequest::setVar('hidemainmenu', 1);
$app = JFactory::getApplication();
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');


$user	= JFactory::getUser();
if (!$user->authorise('core.admin', 'com_preachit'))
{Tewebcheck::check403();}
$this->setLayout('form16');
$paramform = & $this->get('Paramform');
$paramdata = & $this->get('Data');
$registry = new JRegistry;
$registry->loadJSON($paramdata);
$paramdata = $registry->toArray();
$paramform->bind($paramdata);
$this->assignRef('paramform', $paramform);
$tform = & $this->get('Titleform');
// get the Data
$tdata = & $this->get('Titledata');
// Bind the Data
$tform->bind($tdata);	
$this->tform = $tform;
$this->assignRef('temp', $tdata['template']);

if ($tdata['template'] == 'custom')
{
// get the Form	
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Custdata');
// Bind the Data
$form->bind($data);	
$this->form = $form;	
$app->enqueueMessage ( JText::_('COM_PREACHIT_TEMPLATE_CUSTOM_CODE_WARNING'), 'notice' );
}
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
$user = JFactory::getUser();
JToolBarHelper::title( JText::_( 'COM_PREACHIT_TEMPLATEEDIT_TITLE' ), 'template.png' );
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::divider();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
JToolBarHelper::help('pihelp', 'com_preachit');
}

}