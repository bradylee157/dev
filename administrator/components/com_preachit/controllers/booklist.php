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
class PreachitControllerBooklist extends JController
{
function add()
{
JRequest::setVar('view', 'bookedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function edit()
{
JRequest::setVar('view', 'bookedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Books'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=booklist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=booklist';}
$this->setRedirect($url);
}
function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Books');	
$this->setRedirect('index.php?option=' . $option . '&controller=booklist');

}
function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Books');
$this->setRedirect('index.php?option=' . $option . '&controller=booklist');
}
function trash()

{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Books', '#__pibooks');
$this->setRedirect('index.php?option=' . $option.'&view=booklist');
}
function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'booklist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}
function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
$this->registerTask('unpublish', 'publish');
}
}
