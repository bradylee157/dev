<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('teweb.admin.records');
jimport('teweb.file.upload');
jimport('teweb.media.functions');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('joomla.application.component.controller');

class PreachitControllerstudyedit extends JController
{

function edit()
{
JRequest::setVar('view', 'studyedit');
$this->display();
}

function upflash()
{
//import joomla filesystem functions, we will do all the filewriting with joomlas functions,
//so if the ftp layer is on, joomla will write with that, not the apache user, which might
//not have the correct permissions
$abspath    = JPATH_SITE;
//this is the name of the field in the html form, filedata is the default name for swfupload
//so we will leave it as that
$fieldName = 'Filedata';
//any errors the server registered on uploading
$fileError = $_FILES[$fieldName]['error'];
if ($fileError > 0) 
{
        switch ($fileError) 
        {
        case 1:
        echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_TOO_LARGE_THAN_PHP_INI_ALLOWS' );
        return;
 
        case 2:
        echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_TO_LARGE_THAN_HTML_FORM_ALLOWS' );
        return;
 
        case 3:
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_PARTIAL_UPLOAD' );
        return;
 
        case 4:
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_NO_FILE' );
        return;
        }
}
 
//check for filesize
$fileSize = $_FILES[$fieldName]['size'];
if($fileSize > 500000000)
{
    echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_BIGGER_THAN').' 500MB';
}

//check the file extension is ok
$fileName = $_FILES[$fieldName]['name'];
$extOk = Tewebupload::checkfile($fileName);
 
if ($extOk == false) 
{
        echo JText::_( 'LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT' );
        return;
}
 
//the name of the file in PHP's temp directory that we are going to move to our folder
$fileTemp = $_FILES[$fieldName]['tmp_name'];
 
//always use constants when making file paths, to avoid the possibilty of remote file inclusion
$uploadPath = Tewebupload::gettempfolder().$fileName;
 
if(!JFile::upload($fileTemp, $uploadPath)) 
{
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_MOVING_FILE' );
        return;
}
else
{
	$id = 1;
	$db =& JFactory::getDBO();
	$db->setQuery ("UPDATE #__pibckadmin SET uploadfile = '".$fileName."' WHERE id = '{$id}' ;"); 
	$db->query();
   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
   exit(0);
}
}

function uploadflash()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$layout = JRequest::getVar ( 'layout', '', 'post', 'string' );
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
$uploadmsg = '';
// get table, bind and store data
$row = Tewebadmin::getformdetails('Studies'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise and allow raw entries
$row = PIHelperadmin::sanitisestudyrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get temp file details
$temp = Tewebupload::gettempfile();
$temp_folder = Tewebupload::gettempfolder();
$tempfile = $temp_folder.$temp;	
// get path and abort if none
if ($layout == 'modal')
{$url = 'index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit&id=' . $row->id;
$path = Tewebupload::getpath($url, $tempfile, 1);}
else 
{$url = 'index.php?option=com_preachit&view=studyedit&id=' . $row->id;
$path = Tewebupload::getpath($url, $tempfile);}
// get media type
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
// check filetype allowed
$allow = Tewebupload::checkfile($temp);
if ($allow)
{
$filename = PIHelperadmin::buildpath($temp, 1, $media, $row->id,$path, 1);
// get id3 info if available available before moving file
$data = Tewebmedia::getid3($tempfile, 1);	
$err = '';
// process file
$uploadmsg = Tewebupload::processflashfile($tempfile, $filename, '#__pimime');
if (!$uploadmsg) 
{ 
    // resize image if needed
    $resize = PIHelperadmin::resizemesimage($tempfile, $media, $row->id);
	// set folder and link entries
	$row = PIHelperadmin::setstudylist($row, $data, $filename, $path, $media);
	$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}	
// get filesizes if needed
$row = PIHelperadmin::getstudydates($row);	
//set saccess
$row = PIHelperadmin::getsaccess($row);
// set minaccess
$row = PIHelperadmin::getminaccess($row);
// get filesizes if needed
$row = PIHelperadmin::getfilesize($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
// delete temp file
Tewebupload::deletetempfile($tempfile);
if ($layout == 'modal')
{$this->setRedirect(JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit&id=' . $row->id));}
else 
{$this->setRedirect(JRoute::_('index.php?option=com_preachit&view=studyedit&id=' . $row->id));}
}

function upload()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$layout = JRequest::getVar ( 'layout', '', 'post', 'string' );
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
$uploadmsg = '';
// get table, bind and store data
$row = Tewebadmin::getformdetails('Studies'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise and allow raw entries
$row = PIHelperadmin::sanitisestudyrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get path and abort if none
if ($layout == 'modal')
{$url = 'index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit&id=' . $row->id;
$path = Tewebupload::getpath($url, '', 1);}
else 
{$url = 'index.php?option=com_preachit&view=studyedit&id=' . $row->id;
$path = Tewebupload::getpath($url, '');}
//get media details
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );
// check filetype allowed
$allow = Tewebupload::checkfile($file['name']);
// get id3 info if available before moving file
$data = Tewebmedia::getid3($file, 2);
if ($allow)
{
$filename = PIHelperadmin::buildpath($file, 1, $media, $row->id, $path);
// process file
$uploadmsg = Tewebupload::processuploadfile($file, $filename, '#__pimime');
$err = '';
if (!$uploadmsg) 
{ 
// resize image if needed
$resize = PIHelperadmin::resizemesimage($filename->path, $media, $row->id);
	// set folder and link entries	
	$row = PIHelperadmin::setstudylist($row, $data, $filename, $path, $media);
	$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}	
else 
{$app->enqueueMessage ( $uploadmsg, 'warning' );}
// get filesizes if needed
$row = PIHelperadmin::getstudydates($row);	
//set saccess
$row = PIHelperadmin::getsaccess($row);
// set minaccess
$row = PIHelperadmin::getminaccess($row);
// get filesizes if needed
$row = PIHelperadmin::getfilesize($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
if ($layout == 'modal')
{$this->setRedirect(JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit&id=' . $row->id));	}
else 
{$this->setRedirect(JRoute::_('index.php?option=com_preachit&view=studyedit&id=' . $row->id));}
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db		= & JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
// get table, bind and store data
$row = Tewebadmin::getformdetails('Studies'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise and allow raw entries
$row = PIHelperadmin::sanitisestudyrow($row);
// get dates if needed
$row = PIHelperadmin::getstudydates($row);		
//set saccess
$row = PIHelperadmin::getsaccess($row);
// set minaccess
$row = PIHelperadmin::getminaccess($row);	
// get filesizes if needed
$row = PIHelperadmin::getfilesize($row);	
if ($row->id > 0)
{$isNew = false;} else {$isNew = true;}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// run finder plugin if needed
$finder = Tewebadmin::runfinderplugins('onContentAfterSave', 'com_preachit.message', $row, $isNew);
$this->checkin($row->id);
if ($admin->autopodcast == 1)
{$result = PIHelperpodcast::publishall();}
if ($this->getTask() == 'apply' || $this->getTask() == 'applymodal')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );}
if ($this->getTask() == 'apply')
{$link = JRoute::_('index.php?option=com_preachit&view=studyedit&id=' . $row->id);
$app->redirect(str_replace("&amp;","&",$link));}
elseif ($this->getTask() == 'applymodal')
{$link = JRoute::_('index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit&id=' . $row->id);
$app->redirect(str_replace("&amp;","&",$link));}
else 
{$item = Tewebdetails::getitemid('option=com_preachit&view=studylist');
$link = JRoute::_('index.php?option=com_preachit&view=studylist'.$item);
$app->redirect(str_replace("&amp;","&",$link));}
}

function cancel()
{
$app = JFactory::getApplication();
$this->checkin();
$abspath    = JPATH_SITE;
$tefolder = $abspath.DIRECTORY_SEPARATOR.'components/com_teadmin';
$te = JFolder::exists($tefolder);
if (!$te)
{JRequest::setVar('view', 'studylist');
$this->display();}
else 
{
    jimport('teweb.details.standard');
    $item = Tewebdetails::getitemid('index.php?option=com_teadmin&view=linklist');
    $link = JRoute::_('index.php?option=com_teadmin&view=linklist'.$item);
    $app->redirect(str_replace("&amp;","&",$link)); }
}

function cancelmodal()
{
	$id = JRequest::getInt('id', 0);
	$this->checkin($id);
	$this->setRedirect(JRoute::_('index.php?option=com_teadmin&tmpl=component&view=linklist'));	
}

function checkin()

{
	$id = JRequest::getInt('id', 0);
    if ($id > 0)
    {$row =& JTable::getInstance('Studies', 'Table');}
    else 
    {$row =Tewebadmin::getformdetails('Studies');
    $id = $row->id;}
    $row->checkin($id);    

}

function display()
{
$view = JRequest::getVar('view');
if (!$view) {
JRequest::setVar('view', 'studylist');
}
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('applymodal', 'save');
$this->registerTask('apply', 'save');
}

function createrecord()
{
	JRequest::checktoken('get') or jexit ( 'error' );
	// check user
	$user	= JFactory::getUser();
	$record = JRequest::getVar('record', '');
	$name = JRequest::getVar('name', '');
	$tview = JRequest::getVar('tview', '');
	if ($user->id > 0)
	{
		// check right to add in J 1.6 and beyond
		if ($user->authorize('core.create', 'com_preachit')) 
		{$userauth = true;}
		else {$userauth = false;}
		
		if ($userauth)
		{
			if ($record == 'teacher')
			{$newrecord = PIHelperadmin::createnewteacher($name, $tview);}
			elseif ($record == 'series')
			{$newrecord = PIHelperadmin::createnewseries($name);}
			elseif ($record == 'ministry')
			{$newrecord = PIHelperadmin::createnewministry($name);}
	}
	
	else {echo 'error'; die();}
	
	}
	
	else {echo 'error'; die();}
	
	if ($newrecord != 'error')
	{$response = '<option selected="selected" value="'.$newrecord->id.'">'.$newrecord->name.'</option>';}
	else {$response = 'error';}
	echo $response;
	
}

}