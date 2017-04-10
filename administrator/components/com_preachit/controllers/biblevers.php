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
class PreachitControllerbiblevers extends JController
{
function add()
{
JRequest::setVar('view', 'bibleversedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function edit()
{
JRequest::setVar('view', 'bibleversedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Biblevers'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );}
if ($this->getTask() == 'apply')
{$url = 'index.php?option=' . $option . '&task=edit&controller=biblevers&cid[] =' . $row->id;}
else {
$url = 'index.php?option=' . $option . '&controller=biblevers';}
$this->setRedirect($url);
}
function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Biblevers');
$this->setRedirect('index.php?option=' . $option . '&controller=biblevers');
}
function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Biblevers');
$this->setRedirect('index.php?option=' . $option . '&controller=biblevers');
}

function trash()

{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Biblevers', '#__pibiblevers');
$this->setRedirect('index.php?option=' . $option.'&view=bibleverslist');
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'bibleverslist');}
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
