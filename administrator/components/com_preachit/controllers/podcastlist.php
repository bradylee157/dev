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
class PreachitControllerPodcastlist extends JController
{

function add()
{
JRequest::setVar('view', 'podcastedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'podcastedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function publishxml()
{
$app = JFactory::getApplication();	
JRequest::checktoken() or jexit( 'Invalid Token' );
$abspath = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Podcast'); 
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
$result = PIHelperpodcast::publishsingle($row->id);
$app->redirect('index.php?option='.$option.'&controller=podcastlist&task=edit&cid[]='.$row->id);

}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Podcast');
$row = Tewebadmin::setstate($row, 'com_preachit');

if (isset($row->teacher_list))
{$row->teacher_list = implode(',', $row->teacher_list);} else {$row->teacher_list = '';}
if (isset($row->ministry_list))
{$row->ministry_list = implode(',', $row->ministry_list);} else {$row->ministry_list = '';}
if (isset($row->series_list))
{$row->series_list = implode(',', $row->series_list);} else {$row->series_list = '';}
if (isset($row->media_list))
{$row->media_list = implode(',', $row->media_list);} else {$row->media_list = '';}

if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=podcastlist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=podcastlist';}
$this->setRedirect($url);
}

function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Podcast');
$this->setRedirect('index.php?option=' . $option . '&controller=podcastlist');

}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Podcast');
$this->setRedirect('index.php?option=' . $option . '&controller=podcastlist');

}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Podcast', '#__pipodcast');
$this->setRedirect('index.php?option=' . $option.'&view=podcastlist');

}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'podcastlist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function order()

{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$move = Tewebadmin::order('Podcast', $this->getTask());	
$this->setRedirect('index.php?option=' . $option . '&view=podcastlist');
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('unpublish', 'publish');
$this->registerTask('apply', 'save');
$this->registerTask('orderup', 'order');
$this->registerTask('orderdown', 'order');
}
}