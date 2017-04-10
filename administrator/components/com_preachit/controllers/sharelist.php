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
class PreachitControllerSharelist extends JController
{
function add()
{
JRequest::setVar('view', 'shareedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function edit()
{
JRequest::setVar('view', 'shareedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Share'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=sharelist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=sharelist';}
$this->setRedirect($url);
}


function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Share');
$this->setRedirect('index.php?option=' . $option . '&view=sharelist');

}
function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Share');
$this->setRedirect('index.php?option=' . $option . '&view=sharelist');
}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Share', '#__pishare');
$this->setRedirect('index.php?option=' . $option.'&view=sharelist');
}

function order()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$move = Tewebadmin::order('Share', $this->getTask());    
$this->setRedirect('index.php?option=' . $option . '&view=sharelist');
}

function saveorder()
{
// Check for request forgeries
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::saveorder('Share');    
$this->setRedirect('index.php?option=' . $option . '&view=sharelist');
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'sharelist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
$this->registerTask('unpublish', 'publish');
$this->registerTask('orderup', 'order');
$this->registerTask('orderdown', 'order');
}
}
