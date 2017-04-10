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
jimport('joomla.filesystem.folder');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('joomla.application.component.controller');
class PreachitControllerTeacheredit extends JController
{

function cancel()
{
$app = JFactory::getApplication();
$this->checkin();
$abspath    = JPATH_SITE;
$tefolder = $abspath.DIRECTORY_SEPARATOR.'components/com_teadmin';
$te = JFolder::exists($tefolder);
if (!$te)
{JRequest::setVar('view', 'teacherlist');
$this->display();}
else 
{
    jimport('teweb.details.standard');
    $item = Tewebdetails::getitemid('index.php?option=com_teadmin&view=linklist');
    $link = JRoute::_('index.php?option=com_teadmin&view=linklist'.$item);
    $app->redirect(str_replace("&amp;","&",$link)); }
}

function uploadflash()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$uploadmsg = '';
// get table, bind and store data
$row = Tewebadmin::getformdetails('Teachers'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise entries
$row = PIHelperadmin::sanitiseteacherrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get temp file details
$temp = Tewebupload::gettempfile();
$temp_folder = Tewebupload::gettempfolder();
$tempfile = $temp_folder.$temp;	
// get path and abort if none
$url = 'index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit&id=' . $row->id;
$path = Tewebupload::getpath($url, $tempfile, 1);
// get media type
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
// check filetype allowed
$allow = Tewebupload::checkfile($temp);
if ($allow)
{
$filename = PIHelperadmin::buildpath($temp, 2, $media, $row->id, $path, 1);
// resize image if needed
$resize = PIHelperadmin::resizeteaimage($tempfile, $media, $row->id);
// process file
$uploadmsg = Tewebupload::processflashfile($tempfile, $filename, '#__pimime');
$err = '';
if (!$uploadmsg) 
{ 
// set the row variables for the uploaded file	   
$row = PIHelperadmin::setteacherlist($row, '', $filename, $path, $media);	
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}		
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
// delete temp file
Tewebupload::deletetempfile($tempfile);
$link = JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit&id=' . $row->id);
$this->setRedirect(str_replace("&amp;","&",$link));
}
function upload()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$uploadmsg = '';
// get table, bind and store data
$row = Tewebadmin::getformdetails('Teachers');
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise entries
$row = PIHelperadmin::sanitiseteacherrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get path and abort if none
$url = 'index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit&id=' . $row->id;
$path = Tewebupload::getpath($url, '', 1);
//get media details
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );
// check filetype allowed
$allow = Tewebupload::checkfile($file['name']);
if ($allow)
{
$filename = PIHelperadmin::buildpath($file, 2, $media, $row->id, $path);
// process file
$uploadmsg = Tewebupload::processuploadfile($file, $filename, '#__pimime');
$err = '';
if (!$uploadmsg) 
{ 
// resize image if needed
$resize = PIHelperadmin::resizeteaimage($filename->path, $media, $row->id);
// set the row variables for the uploaded file   
$row = PIHelperadmin::setteacherlist($row, '', $filename, $path, $media);
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}	
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
$link = JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit&id=' . $row->id);
$this->setRedirect(str_replace("&amp;","&",$link));
}
function applymodal()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row = Tewebadmin::getformdetails('Teachers');
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise entries
$row = PIHelperadmin::sanitiseteacherrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
$this->checkin($row->id);	
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$link = JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit&id=' . $row->id);
$this->setRedirect(str_replace("&amp;","&",$link));
}

function checkin()
{
	$id = JRequest::getInt('id', 0);
    if ($id > 0)
    {$row =& JTable::getInstance('Teachers', 'Table');}
    else 
    {$row =Tewebadmin::getformdetails('Teachers');
    $id = $row->id;}
    $row->checkin($id);    
}
function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
}
}