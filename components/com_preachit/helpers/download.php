<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.file.functions');
jimport('teweb.file.urlbuilder');
jimport('joomla.filesystem.file');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelperdownload{

/**
     * Method to file details so that a file can be downloaded
     * @return    null
     */

function download()
{
  	$app = JFactory::getApplication();
  	$params = PIHelperadditional::getPIparams();
  	$downloadmethod = $params->get('download_method', '0');
 	
  	$id = JRequest::getVar('study', '', 'GET', 'INT');
  	$mediatype = JRequest::getVar('media', '', 'GET', 'INT');
  	$row =& JTable::getInstance('Studies', 'Table');
	$row->load($id);
    $user    = JFactory::getUser();
    if (!$user->authorize('core.admin', 'com_preachit') && !Tewebcheck::is_bot())
	{$db =& JFactory::getDBO();
	$db->setQuery('UPDATE '.$db->nameQuote('#__pistudies').'SET '.$db->nameQuote('downloads').' = '.$db->nameQuote('downloads').' + 1 '.' WHERE id = '.$id);
	$db->query();}
  	
  	if ($mediatype == '0')
  	{$mediafolder = $row->audio_folder;}
  	else {
  		if ($row->video_download == 1 && $row->add_downloadvid == 1)
  		{$mediafolder = $row->downloadvid_folder;}
  		else { $mediafolder = $row->video_folder;}
  	}
  	
  	if ($mediatype == '0')
  	{$filename = $row->audio_link;
  	 $filesize = $row->audiofs;}
  	else {
  		if ($row->video_download == 1 && $row->add_downloadvid == 1)
  		{$filename = $row->downloadvid_link;
  		$filesize = $row->advideofs;}
  		else {
  		$filename = $row->video_link;
  		$filesize = $row->videofs;}
  	}
	//get file url
	
	$file = Tewebbuildurl::geturl($filename, $mediafolder, 'pifilepath');
	// if zip file redirect to download
	
	$mime_type = JFile::getExt($filename);
	if ($mime_type == 'zip')
	{$app->redirect($file);}
    
    $fileinfo = Tewebfile::buildfileinfo($file, $filesize);
    if (!$fileinfo->exists)
    {Tewebfile::error_msg ('file not found');}    
    
    Tewebfile::download($fileinfo, $downloadmethod);
}

}

?>