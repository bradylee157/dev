<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.filesystem.folder');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('joomla.application.component.controller');
class PreachitControllerPodcastlist extends JController
{

function cancel()
{
$app = JFactory::getApplication();
$this->checkin();
$abspath    = JPATH_SITE;
$tefolder = $abspath.DIRECTORY_SEPARATOR.'components/com_teadmin';
$te = JFolder::exists($tefolder);
if (!$te)
{JRequest::setVar('view', 'podcastlist');
$this->display();}
else 
{
    jimport('teweb.details.standard');
    $item = Tewebdetails::getitemid('index.php?option=com_teadmin&view=linklist');
    $link = JRoute::_('index.php?option=com_teadmin&view=linklist'.$item);
    $app->redirect(str_replace("&amp;","&",$link)); }
}

function publishxml()
{
	$app = JFactory::getApplication();	
JRequest::checktoken() or jexit( 'Invalid Token' );
$id = JRequest::getInt('id', 0);
$itemlink = JRequest::getInt('Itemid', 0);
if ($itemlink > 0) {$item = '&Itemid='.$itemlink;}
else {$item = '';}
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$option = JRequest::getCmd('option');
$detail =& JTable::getInstance('Podcast', 'Table');
if (!$detail->bind(JRequest::get('post')))
{
JError::raiseError(500, $detail->getError() );
}
$detail->description = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
if (!$detail->store())
{
JError::raiseError(500, $detail->getError() );
}
$result = PIHelperpodcast::publishsingle($id);

$app->redirect('index.php?option='.$option.'&controller=podcastlist&task=edit&id='.$id.$item, $result);

}

function publishxmlmodal()
{
	$app = JFactory::getApplication();
	
	// get Joomla version to decide which form of acl

$user =& JFactory::getUser();

	//check user can publish

if (!$user->authorize('core.create', 'com_preachit')) 
{return JError::raiseError('403', JText::_('COM_PREACHIT_403_ERROR'));}
$id = JRequest::getInt('id', 0);
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/publishxml.php');
$option = JRequest::getCmd('option');
$task = $this->getTask();
$result = PIHelperpodcast::publishsingle($id);

$app->redirect('index.php?option='.$option.'&tmpl=component&layout=modal&view=podcastlist&msg='.$result);

}

function display()
{
$view = JRequest::getVar('view');
if (!$view) {
JRequest::setVar('view', 'podcastlist');
}
parent::display();
}
}