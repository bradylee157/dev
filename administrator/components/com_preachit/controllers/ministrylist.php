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
class PreachitControllerMinistrylist extends JController
{

function add()
{
JRequest::setVar('view', 'ministryedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'ministryedit');
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
$row =Tewebadmin::getformdetails('Ministry'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise row entries
$row = PIHelperadmin::sanitiseministryrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get temp file details
$temp = Tewebupload::gettempfile();
$temp_folder = Tewebupload::gettempfolder();
$tempfile = $temp_folder.$temp;	
// get path and abort if none
$url = 'index.php?option=' . $option . '&controller=ministrylist&task=edit&cid[] =' . $row->id;
$path = Tewebupload::getpath($url, $tempfile);
// get media type
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
// check file is allowed
$allow = Tewebupload::checkfile($temp);
if ($allow)
{
$filename = PIHelperadmin::buildpath($temp, 4, $media, $row->id, $path, 1);
// resize image if needed
$resize = PIHelperadmin::resizeminimage($tempfile, $media, $row->id);
// process file
$uploadmsg = Tewebupload::processflashfile($tempfile, $filename, '#__pimime');
if (!$uploadmsg) 
{ 
	// set file linka nd folder entries	
	$row = PIHelperadmin::setministrylist($row, '', $filename, $path, $media);	
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
$this->setRedirect('index.php?option=' . $option . '&controller=ministrylist&task=edit&cid[] =' . $row->id);
}
function upload()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$uploadmsg = '';
// get table, bind and store data
$row =Tewebadmin::getformdetails('Ministry'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise row entries
$row = PIHelperadmin::sanitiseministryrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
// get path and abort if none
$url = 'index.php?option=' . $option . '&controller=ministrylist&task=edit&cid[] =' . $row->id;
$path = PIHelperadmin::getpath($url, '');
//get media details
$media = JRequest::getVar ( 'mediaselector', '', 'POST', 'INT');
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );
// check filetype allowed
$allow = Tewebupload::checkfile($file['name']);
if ($allow)
{
$filename = Tewebupload::buildpath($file, 4, $media, $row->id, $path);
// process file
$uploadmsg = Tewebuploadn::processuploadfile($file, $filename, '#__pimime');
if (!$uploadmsg) 
{ // resize image if needed
	$resize = PIHelperadmin::resizeminimage($filename->path, $media, $row->id);
	// set file link and folder entries
	$row = PIHelperadmin::setministrylist($row, '', $filename, $path, $media);
	$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_UPLOADED'), 'message' );
}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT'), 'notice' );}
//set all minaccess in all related messages
$saccess = PIHelperadmin::setminaccess($row->id, $row->access);
$this->setRedirect('index.php?option=' . $option . '&controller=ministrylist&task=edit&cid[] =' . $row->id);
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Ministry'); 
$row = Tewebadmin::setstate($row, 'com_preachit');
// sanitise row entries
$row = PIHelperadmin::sanitiseministryrow($row);
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
//set all minaccess in all related messages
$saccess = PIHelperadmin::setminaccess($row->id, $row->access);
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option=' . $option . '&task=edit&controller=ministrylist&cid[] =' . $row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option=' . $option . '&controller=ministrylist';}
$this->setRedirect($url);
}

function publish()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::publish('Ministry');
$this->setRedirect('index.php?option=' . $option . '&controller=ministrylist');
}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::remove('Ministry');
$this->setRedirect('index.php?option=' . $option . '&controller=ministrylist');
}

function trash()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebadmin::trash('Ministry', '#__piministry');
$this->setRedirect('index.php?option=' . $option.'&view=ministrylist');

}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'ministrylist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}
function order()
	
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$move = PIAdminfunctions::order('Ministry', $this->getTask());	
$this->setRedirect('index.php?option=' . $option . '&view=ministrylist');
}

function saveorder()
{
// Check for request forgeries
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = PIAdminfunctions::saveorder('Ministry');	
$this->setRedirect('index.php?option=' . $option . '&view=ministrylist');
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
