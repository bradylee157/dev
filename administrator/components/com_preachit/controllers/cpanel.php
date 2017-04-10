<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.admin.records');
jimport('joomla.application.component.controller');
class PreachitControllerCpanel extends JController
{
function resethits()

{
	JRequest::checktoken() or jexit( 'Invalid Token' );
	$app = JFactory::getApplication();
	$option = JRequest::getCmd('option');
	$msg = Tewebadmin::resethits('#__pistudies');
	$app->Redirect('index.php?option=' . $option . '&view=cpanel');

}

function resetdownloads()

{
	JRequest::checktoken() or jexit( 'Invalid Token' );
	$app = JFactory::getApplication();
	$option = JRequest::getCmd('option');
	$msg = Tewebadmin::resetdownloads('#__pistudies');	
	$app->Redirect('index.php?option=' . $option . '&view=cpanel');

}
function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'cpanel');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}
}
