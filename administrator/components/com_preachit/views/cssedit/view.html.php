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
class PreachitViewCSSedit extends JView
{
function display($tpl = null)
{
$app = JFactory::getApplication();
 	$option = JRequest::getCmd('option');
$CSSfile =& $this->get('Data');
$this->assignRef('CSSfile', $CSSfile);
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

//get filename for save process

$temp = JRequest::getVar('template', '');
$cssfile = JRequest::getVar('file', '');
$mod = JRequest::getVar('module', '');
$plug = JRequest::getVar('plugin', '');
$override = JRequest::getVar('override', '');

$this->assignRef('temp', $temp);
$this->assignRef('cssfile', $cssfile);
$this->assignRef('override', $override);
$this->assignRef('mod', $mod);
$this->assignRef('plug', $plug);
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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_CSS_TITLE' ), 'css.png');
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::divider();
$user    = JFactory::getUser();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::cancel();
JToolBarHelper::divider();
JToolBarHelper::help('pihelp', 'com_preachit');    
}
}