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
class PreachitViewCpanel extends JView
{
function display($tpl = null)
{
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$latests =& $this->get('datalat');
$pops =& $this->get('datapop');
$pods=& $this->get('datapod');

$this->assignRef('latests', $latests);
$this->assignRef('pops', $pops);
$this->assignRef('pods', $pods);

$user	= JFactory::getUser();
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_CPANEL_TITLE' ), 'picpanel.png');
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
$dateformat = 'd F, Y';
$this->assignRef('dateformat', $dateformat);

parent::display($tpl);
}
}