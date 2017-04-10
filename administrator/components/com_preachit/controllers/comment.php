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
class PreachitControllerComment extends JController
{
function edit()
{
JRequest::setVar('view', 'commentedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Comment');
$row = Tewebadmin::setstate($row, 'com_preachit'); 
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=comment&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=comment';}
$this->setRedirect($url);
}

function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Comment');	
$this->setRedirect('index.php?option=' . $option . '&view=commentlist');

}
function remove()

{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Comment');
$this->setRedirect('index.php?option=' . $option . '&view=commentlist');

}

function trash()

{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Comment', '#__picomments');
$this->setRedirect('index.php?option=' . $option.'&view=commentlist');

}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'commentlist');}
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
