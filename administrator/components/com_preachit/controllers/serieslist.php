<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
jimport('teweb.admin.records');
jimport('teweb.file.upload');
jimport('joomla.application.component.controller');
class PreachitControllerSerieslist extends JController
{
function cancel()

{
	$row =Tewebadmin::getformdetails('Series');
    $this->checkin($row->id);
    $this->display();
}

function add()
{
JRequest::setVar('view', 'seriesedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'seriesedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}
function uploadflash()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db = & JFactory::getDBO();
jimport('joomla.filesystem.file');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
$uploadmsg = '';
// get table, bind and store data
$row =Tewebadmin::getformdetails('Series'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
$row = PIHelperadmin::sanitiseseriesrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get temp file details
$temp = Tewebupload::gettempfile();
$temp_folder = Tewebupload::gettempfolder();
$tempfile = $temp_folder.$temp;	
// get path and abort if none
$url = 'index.php?option=' . $option . '&controller=serieslist&task=edit&cid[] =' . $row->id;
$path = Tewebupload::getpath($url, $tempfile);
// get media type
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
// check file type is allowed	
$allow = Tewebupload::checkfile($temp);
if ($allow)
{
$filename = PIHelperadmin::buildpath($temp, 3, $media, $row->id, $path, 1);
// resize image if needed
$resize = PIHelperadmin::resizeserimage($tempfile, $media, $row->id);
// process file
$uploadmsg = Tewebupload::processflashfile($tempfile, $filename, '#__pimime');
if (!$uploadmsg) 
{ 
	// set the row variables for the uploaded file   
	$row = PIHelperadmin::setserieslist($row, '', $filename, $path, $media);
	$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
//set all saccess in all related messages
$saccess = PIHelperadmin::setsaccess($row->id, $row->access);
// delete temp file
Tewebupload::deletetempfile($tempfile);
$this->setRedirect('index.php?option=' . $option . '&controller=serieslist&task=edit&cid[] =' . $row->id);
}

function upload()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$uploadmsg = '';
// get table, bind and store data
$row =Tewebadmin::getformdetails('Series'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise entries
$row = PIHelperadmin::sanitiseseriesrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get path and abort if none
$url = 'index.php?option=' . $option . '&controller=serieslist&task=edit&cid[] =' . $row->id;
$path = Tewebupload::getpath($url, '');
//get media details
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );
// check file is allowed
$allow = Tewebupload::checkfile($file['name']);
if ($allow)
{
$filename = PIHelperadmin::buildpath($file, 3, $media, $row->id, $path);
// process file
$uploadmsg = Tewebupload::processuploadfile($file, $filename, '#__pimime');
if (!$uploadmsg) 
{ 
	// resize image if needed
	$resize = PIHelperadmin::resizeserimage($filename->path, $media, $row->id);
	// set the row variables for the uploaded file   
	$row = PIHelperadmin::setserieslist($row, '', $filename, $path, $media);
	$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
//set all saccess in all related messages
$saccess = PIHelperadmin::setsaccess($row->id, $row->access);
$this->setRedirect('index.php?option=' . $option . '&controller=serieslist&task=edit&cid[] =' . $row->id);
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );

$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Series'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise entries	
$row = PIHelperadmin::sanitiseseriesrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
//set all saccess in all related messages
$saccess = PIHelperadmin::setsaccess($row->id, $row->access);
$this->checkin($row->id);
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=serieslist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=serieslist';}
$this->setRedirect($url);
}

function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Series');
$this->setRedirect('index.php?option=' . $option . '&controller=serieslist');
}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Series');
$this->setRedirect('index.php?option=' . $option . '&controller=serieslist');
}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Series', '#__piseries');
$this->setRedirect('index.php?option=' . $option.'&view=serieslist');

}

function checkin($id)
{
$row =& JTable::getInstance('Series', 'Table');
$row->checkin($id);	
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'serieslist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function order()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$move = Tewebadmin::order('Series', $this->getTask());	
$this->setRedirect('index.php?option=' . $option . '&view=serieslist');
}

function saveorder()
{
// Check for request forgeries
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::saveorder('Series');	
$this->setRedirect('index.php?option=' . $option . '&view=serieslist');
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
