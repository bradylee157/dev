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
class PreachitControllerFilepathlist extends JController
{

function add()
{
JRequest::setVar('view', 'filepathedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'filepathedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Filepath'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=filepathlist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=filepathlist';}
$this->setRedirect($url);
}

function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Filepath');	
$this->setRedirect('index.php?option=' . $option . '&controller=filepathlist');
}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Filepath');
$this->setRedirect('index.php?option=' . $option . '&controller=filepathlist');
}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Filepath', '#__pifilepath');
$this->setRedirect('index.php?option=' . $option.'&view=filepathlist');

}
function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'filepathlist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('unpublish', 'publish');
$this->registerTask('apply', 'save');
}
}
