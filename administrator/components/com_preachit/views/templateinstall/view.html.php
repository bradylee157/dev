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
class PreachitViewTemplateinstall extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_TEMPLATE_MANAGER_TITLE' ), 'template.png');
JToolBarHelper::preferences('com_preachit', '600', '640');
JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
JToolBarHelper::help('pihelp', 'com_preachit');
}
}