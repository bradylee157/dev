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
jimport('teweb.media.functions');
jimport('joomla.application.component.controller');
class PreachitControllerstudylist extends JController
{
function cancel()
{
	$row =Tewebadmin::getformdetails('Studies');
    $this->checkin($row->id);
    $this->display();
}
function add()
{
JRequest::setVar('view', 'studyedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'studyedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function uploadflash()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db		= & JFactory::getDBO();
jimport('joomla.filesystem.file');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
$uploadmsg = '';
// get table, bind and store data
$row =Tewebadmin::getformdetails('Studies'); 
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
$url = 'index.php?option=' . $option . '&controller=studylist&task=edit&cid[] =' . $row->id;
$path = Tewebupload::getpath($url, $tempfile);
// get media type
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
// check filetype is allowed
$allow = Tewebupload::checkfile($temp);
if ($allow)
{
$filename = PIHelperadmin::buildpath($temp, 1, $media, $row->id, $path, 1);
// resize image if needed
$resize = PIHelperadmin::resizemesimage($tempfile, $media, $row->id);
// get id3 info if available available before moving file
$data = Tewebmedia::getid3($tempfile, 1);	
// process file
$uploadmsg = Tewebupload::processflashfile($tempfile, $filename, '#__pimime');
if (!$uploadmsg) 
	{ 
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
$this->setRedirect('index.php?option=' . $option . '&controller=studylist&task=edit&cid[]=' . $row->id);	
}


function upload()
{
$db		= & JFactory::getDBO();
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
$uploadmsg = '';
// get table, bind and store data
$row =Tewebadmin::getformdetails('Studies'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise and allow raw entries
$row = PIHelperadmin::sanitisestudyrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get path and abort if none
$url = 'index.php?option=' . $option . '&controller=studylist&task=edit&cid[] =' . $row->id;
$path = Tewebupload::getpath($url, '');
//get media details
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );
// check filetype allowed
$allow = Tewebupload::checkfile($file['name']);
if ($allow)
{
$filename = PIHelperadmin::buildpath($file, 1, $media, $row->id, $path);
// get id3 info if available before moving file
$data = Tewebmedia::getid3($file, 2);	
// process file
$uploadmsg = Tewebupload::processuploadfile($file, $filename, '#__pimime');
if (!$uploadmsg) 
{ 	
	// resize image if needed
	$resize = PIHelperadmin::resizemesimage($filename->path, $media, $row->id);
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
$this->setRedirect('index.php?option=' . $option . '&controller=studylist&task=edit&cid[]=' . $row->id);	
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
$row =Tewebadmin::getformdetails('Studies'); 	
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise and allow raw entries	
$row = PIHelperadmin::sanitisestudyrow($row);
// get study dates if needed
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
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );}
if ($this->getTask() == 'apply')
{$this->setRedirect('index.php?option=' . $option . '&controller=studylist&task=edit&cid[]=' . $row->id);}
else if ($this->getTask() == 'save2new')
{$this->setRedirect('index.php?option=' . $option . '&controller=studylist&task=edit');}
else{$this->setRedirect('index.php?option=' . $option. '&view=studylist');}
}

function reset()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Studies'); 
// sanitise and allow raw entries	
$row = PIHelperadmin::sanitisestudyrow($row);
// set hits = 0
$row->hits = 0;
// get study dates if needed
$row = PIHelperadmin::getstudydates($row);
//set saccess
$row = PIHelperadmin::getsaccess($row);
// set minaccess
$row = PIHelperadmin::getminaccess($row);
// get filesizes if needed
$row = PIHelperadmin::getfilesize($row);	
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_HITS_RESET'), 'message' );
$app->Redirect('index.php?option=' . $option . '&controller=studylist&task=edit&cid[] =' . $row->id);
}
function resetall()

{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$msg = Tewebadmin::resethits('#__pistudies');		
$app->Redirect('index.php?option=' . $option . '&view=studylist');
}

function resetdownloads()

{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$msg = Tewebadmin::resetdownloads('#__pistudies');	
$app->Redirect('index.php?option=' . $option . '&view=studylist');

}
function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Studies', 'com_preachit.message');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
if ($admin->autopodcast == 1)
{
PIHelperpodcast::publishall();
}
$this->setRedirect('index.php?option=' . $option .'&view=studylist');
}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Studies', 'com_preachit.message');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$admin =& JTable::getInstance('Piadmin', 'Table');
$adminid = '1';
$admin->load($adminid);
if ($admin->autopodcast == 1)
{
$result = PIHelperpodcast::publishall();
}
$this->setRedirect('index.php?option=' . $option.'&view=studylist');
}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Studies', '#__pistudies', 'com_preachit.message');
$this->setRedirect('index.php?option=' . $option.'&view=studylist');

}
function checkin($id)
{
$row =& JTable::getInstance('Studies', 'Table');
$row->checkin($id);	
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'studylist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('unpublish', 'publish');
$this->registerTask('apply', 'save');
$this->registerTask('save2new', 'save');
$this->registerTask('upload_audio', 'upload');
$this->registerTask('upload_video', 'upload');
$this->registerTask('upload_notes', 'upload');
$this->registerTask('upload_image', 'upload');
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
