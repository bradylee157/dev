<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.file.urlbuilder');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelperlinks{

/**
     * Method to get download link
     * @param int $id id of study
     * @param boolean $download determines whether the message needs a download link
     * @param string $media media element in url
     * @param string $link audio or video link of file to use as a test
     * @param string $addlink add video link to use as a test
     * @param boolean $add whether the addlink is set in the video 
     * @return   string
     */     
    
function download($id, $download, $media, $link = null, $addlink = null, $add = false)
{

if ($download == 1 && $link != '' || $download == 1 && $addlink != '' && $add == 1)
{$link = '<a class="pilink" href ="'.JRoute::_('index.php?option=com_preachit&controller=studylist&task=download&study=' . $id . '&media='.$media).'"><span>'.JText::_('COM_PREACHIT_DOWNLOAD').'</span></a>';}
else {$link = '' ;}

return $link;
}

/**
     * Method to get audio link
     * @param int $id id of study
     * @param boolean $audio determines whether the message needs an audio link
     * @param string $studyslug url slug for the message
     * @param int $item Itemid for the url
     * @param boolean $popup detemines if the link is popup or not
     * @return   string
     */     

function audiolink($id, $audio, $studyslug, $item, $popup)
{
$option = 'com_preachit';
if (trim($audio) != null && $popup == 0)
{$link = '<a class="pilink" href = "' . JRoute::_('index.php?option=' . $option . '&id=' . $studyslug . '&view=study&mode=listen&Itemid='.$item) . '" ><span>'. JText::_('COM_PREACHIT_LISTEN').'</span></a>';}
elseif (trim($audio) != null && $popup == 1)
{$class = '"pilink"';
$link = "<a class=".$class." href='" . JRoute::_("index.php?option=com_preachit&tmpl=component&id=" .$studyslug . "&view=studypopup&mode=listen")."' onClick='showPopup(this.href);return(false);'><span>". JText::_("COM_PREACHIT_LISTEN")."</span></a>";}
else {$link = '';}

return $link;
}

/**
     * Method to get video link
     * @param int $id id of study
     * @param boolean $video determines whether the message needs an video link
     * @param string $studyslug url slug for the message
     * @param int $item Itemid for the url
     * @param boolean $popup detemines if the link is popup or not
     * @return   string
     */   

function videolink($id, $video, $studyslug, $item, $popup)
{
$option = 'com_preachit';
if (trim($video) != null && $popup == 0) 
{
$link = '<a class="pilink" href = "' . JRoute::_('index.php?option=' . $option . '&id=' . $studyslug . '&view=study&mode=watch&Itemid='.$item) . '" ><span>'. JText::_('COM_PREACHIT_WATCH').'</span></a>';}
elseif (trim($video) != null && $popup == 1)
{$class = '"pilink"';
$link = "<a class=".$class." href='". JRoute::_("index.php?option=com_preachit&tmpl=component&id=" .$studyslug . "&view=studypopup&mode=watch")."' onClick='showPopup(this.href);return(false);'><span>". JText::_("COM_PREACHIT_WATCH")."</span></a>";}
else {
$link = '';
}	

return $link;
}

/**
     * Method to get direct link to audio or video
     * @param string $file url entry for the purchase link
     * @param int $folder iid for the folder
     * @param int $type code to get right type
     * @return   string
     */   

function filelink($file, $folder, $type)
{
$ext = pathinfo($file, PATHINFO_EXTENSION);
if ($file != '' && $ext != '') {
$fileurl = Tewebbuildurl::geturl($file, $folder, 'pifilepath');
if ($type == 1)
{
    $msg = JText::_('COM_PREACHIT_WATCH');
    $class = ' piwatch';
}
else {
    $msg = JText::_('COM_PREACHIT_LISTEN');
    $class = ' pilisten';
}
$link = '<a class="pilink'.$class.'" href = "' . $fileurl . '" ><span>'. $msg.'</span></a>';}
else {
$link = '';
}
return $link;
}

/**
     * Method to get text link
     * @param int $id id of study
     * @param boolean $text determines whether the message needs an text link
     * @param string $studyslug url slug for the message
     * @param int $item Itemid for the url
     * @return   string
     */   

function textlink($id, $text, $studyslug, $item)
{
$option = 'com_preachit';
if (trim($text) != null) {
$link = '<a class="pilink piread" href = "' . JRoute::_('index.php?option=' . $option . '&id=' . $studyslug . '&view=study&mode=read&Itemid='.$item) . '" ><span>'. JText::_('COM_PREACHIT_READ').'</span></a>';}
else {
$link = '';
}	

return $link;
}

/**
     * Method to get notes link
     * @param string $file url entry for the purchase link
     * @param int $folder iid for the folder
     * @param boolean $notes determines if the message requires notes link
     * @return   string
     */   

function noteslink($file, $folder, $notes)
{
if ($notes == 1) {
$fileurl = Tewebbuildurl::geturl($file, $folder, 'pifilepath');
$link = '<a target="blank" class="pilink" href = "' . $fileurl . '" ><span>'. JText::_('COM_PREACHIT_NOTES').'</span></a>';}
else {
$link = '';
}

return $link;
}

/**
     * Method to get slides link
     * @param string $file url entry for the purchase link
     * @param int $folder iid for the folder
     * @param boolean $slides determines if the message requires slides link
     * @return   string
     */   

function slideslink($file, $folder, $slides, $type)
{
if ($slides == 1) {
$fileurl = Tewebbuildurl::geturl($file, $folder, 'pifilepath');
if ($type == 0)
{$text = JText::_('COM_PREACHIT_POWERPOINT');}
elseif ($type == 1)
{$text = JText::_('COM_PREACHIT_KEYNOTE');}
else
{$text = JText::_('COM_PREACHIT_SLIDES_OTHER');}

$link = '<a target="blank" class="pilink" href = "' . $fileurl . '" ><span>'. $text.'</span></a>';}
else {
$link = '';
}	

return $link;
}

/**
     * Method to get audiopopup link
     * @param int $id id of study
     * @param boolean $audio determines whether the message needs an audio link
     * @param string $studyslug url slug for the message
     * @return   string
     */   

function audiolinkpopup($id, $audio, $studyslug)
{
$option = 'com_preachit';
if ($audio == '1')
{
$link = '<a class="pilink" href="' . JRoute::_('index.php?option=' . $option . '&tmpl=component&id=' . $studyslug . '&view=studypopup&mode=listen').'"><span>'. JText::_('COM_PREACHIT_LISTEN').'</span></a>';}
else {$link = '';}


return $link;

}

/**
     * Method to get videopopup link
     * @param int $id id of study
     * @param boolean $video determines whether the message needs an video link
     * @param string $studyslug url slug for the message
     * @return   string
     */ 

function videolinkpopup($id, $video, $studyslug)
{
$option = 'com_preachit';
if ($video == '1')
{
$link = '<a class="pilink" href="' . JRoute::_('index.php?option=' . $option . '&tmpl=component&id=' . $studyslug . '&view=studypopup&mode=watch').'"><span>'. JText::_('COM_PREACHIT_WATCH').'</span></a>';}
else {$link = '';}	

	
return $link;

}

/**
     * Method to get associated media link
     * @param int $id id of study
     * @param int $item Itemid for the url
     * @return   string
     */ 

function amlink($id, $item)
{
$option = 'com_preachit';
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
$db =& JFactory::getDBO();
$row =& JTable::getInstance('Studies', 'Table');

$row->load($id);

	$asmediatext = $params->get('asmediatext', JText::_('COM_PREACHIT_MEDIA'));
	
	//get a list of studies associated with this one

$queryam=('SELECT COUNT(*) FROM #__pistudies WHERE asmedia ='.$row->id);
	$db->setQuery($queryam);
	$ams = intval($db->loadResult());

	if ($ams > 0 && $row->asmedia < 1)
	{$amlink = '<a class="pilink" href ="' . JRoute::_( 'index.php?option=' . $option . '&view=studylist&layout=media&asmedia='. $row->id .'&Itemid='.$item ).'"><span>' . $asmediatext.'</span></a>';}
	if ($ams > 0 && $row->asmedia >0)
	{$amlink = '<a class="pilink" href ="' . JRoute::_( 'index.php?option=' . $option . '&view=studylist&layout=media&asmedia='. $row->id .'&Itemid='.$item ).'"><span>' . $asmediatext.'</span></a>';}
	if ($row->asmedia > 0 && $ams < 1)
	{$amlink = '<a class="pilink" href ="' . JRoute::_( 'index.php?option=' . $option . '&view=studylist&layout=media&asmedia='. $row->asmedia .'&Itemid='.$item ).'"><span>' . $asmediatext.'</span></a>';}
	if ($ams < 1 && $row->asmedia < 1)
	{$amlink = '';}
	
return $amlink;
}

/**
     * Method to get purchase link
     * @param boolean $purchase determines if the message requires a purchase link
     * @param int $folder iid for the folder
     * @param string $file url entry for the purchase link
     * @param int $type determines wording of link - 1 = Audio, 2 = Video
     * @return   string
     */ 

function purchase($purchase, $folder, $file, $type)
{
	$msg = '';
	if ($type == 1)
	{$msg = 	JText::_('COM_PREACHIT_PURCHASE_AUDIO');}
	if ($type == 2)
	{$msg = 	JText::_('COM_PREACHIT_PURCHASE_VIDEO');}
	
	
	if ($purchase == 1)
	{
		$fileurl = Tewebbuildurl::geturl($file, $folder, 'pifilepath');
		$link = '<a target="blank" class="pilink" href = "' . $fileurl . '" ><span>'. $msg.'</span></a>';}
	else {
		$link = '';
	}	 
	return $link;
}

/**
     * Method to transform studyview link with extra js
     * @param string $link original link
     * @param string $class class to add
     * $param string $htmlid id to add
     * @param string $media media to call in js
     * @return   string
     */ 
function transformlink($link, $class, $media)
{
    $link = str_replace('class="pilink"', 'id="pi'.$media.'link" class="pilink '.$class.'" onclick="javascript: selectmedia(\''.$media.'\'); return false;"', $link);
    return $link;
}

}
?>