<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha, LLC
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
class PreachitViewStudy extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
$id = (int) JRequest::getVar('id', 0);
$study =& JTable::getInstance('Studies', 'Table');
$study->load($id);
$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$user    = JFactory::getUser();
$mode = JRequest::getVar('mode', '');
$this->assignRef('mode', $mode);
//check that study published
    
if ($study->published != 1) {
JError::raiseError(404, JText::_('COM_PREACHIT_404_ERROR_MESSAGE_NOT_AVAILABLE') );
}

//helpers

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');

// get params

$params = PIHelperadditional::getPIparams();

//set layout and load template details
$this->listview = 'study';
$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
$this->setLayout('studyview');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);

// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = $study->study_name;
$blink = PIHelperadditional::getmenulink($item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$item));

//get main info

$message = PIHelperinfobuilder::messageinfo($study, $params, 1, true);
$this->assignRef('message', $message);

//check user has access

$groups = $user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0 || !in_array($message->access->message, $groups) && $message->access->message != 0 || 
!in_array($message->access->series, $groups) && $message->access->series != 0 || !in_array($message->access->ministry, $groups) && $message->access->ministry != 0)
{Tewebcheck::check403($params);}

//get teacher info

$tinfo =& JTable::getInstance('Teachers', 'Table');
$tinfo->load($study->teacher);
$teacher = PIHelperinfobuilder::teacherinfo($tinfo);
$this->assignRef('teacher',$teacher);

// get series info

$sinfo =& JTable::getInstance('Series', 'Table');
$sinfo->load($study->series);
$series = PIHelperinfobuilder::seriesinfo($sinfo, $params);
$this->assignRef('series',    $series);

//get ministry info

$minfo =& JTable::getInstance('Ministry', 'Table');
$minfo->load($study->ministry);
$ministry = PIHelperinfobuilder::ministryinfo($minfo);
$this->assignRef('ministry',    $ministry);

//set metadate & title

$this->setmetadata($study, $params);

//set the hits counts
if (!$user->authorize('core.admin', 'com_preachit') && !Tewebcheck::is_bot())
{$study->hit($id);}

//backlink
$bcklinktext = JText::_($params->get('backlinkmaintext', 'COM_PREACHIT_BACK_BUTTON'));
if ($params->get('backlinkmain', '1') == '1')
{$backlink = PIHelperadditional::getbacklink($bcklinktext);}
else {$backlink = null;}

$this->assignRef('backlink', $backlink);

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}

function setmetadata($study, $params)
{
    $app = JFactory::getApplication();
    $document =& JFactory::getDocument();
    $Mparams =& $app->getParams();
    $id = (int) JRequest::getVar('id', 0);

    // Set MetaData
    if ($study->metadesc)
    {
        $metadescription = $study->metadesc;
    } 
    elseif ($Mparams->get('menu-meta_description')) 
    {
        $metadescription = $Mparams->get('menu-meta_description');
    } 
    else 
    {
        if ($this->message->scripture == '')
        {
            $metadescription = strip_tags($study->study_description);
        }
        else 
        {
            $metadescription = strip_tags($this->message->scripture.' - '.$study->study_description);
        }      
    }
    $document->setDescription( $metadescription); 
    
    if ($study->metakey)
    {
        $document->setMetadata('keywords', $study->metakey);
    } 
    elseif ($Mparams->get('menu-meta_keywords')) 
    {
        $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
    }
    
    $params->set('page_title', $study->study_name);
    if (strip_tags($this->message->teachername) != null)
    {$title = $study->study_name . ' - '. JText::_('COM_PREACHIT_BY').' '.strip_tags($this->message->teachername);}
    else {$title = $study->study_name;}
    // Check for empty title and add site name if param is set
    if (empty($title)) {
    $title = $app->getCfg('sitename');
    }
    elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
    $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
    }
    elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
    $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
    $document->setTitle( $title );
    if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }
    if ($app->getCfg('MetaAuthor')){
        $document->setMetaData('author', strip_tags($this->message->teachername));
    }

    //set facebook image if there is one

    $fbimg = $params->get('fbimg', '');
    if ($fbimg)
    {
        $facebookimg = PIHelperadditional::facebookimage($fbimg, $id);
        $document->addCustomTag('<link rel="image_src" href="'.$facebookimg.'" />');
    }
    
    // set facebook video & audio tags
    
    $document->addCustomTag('<meta property="og:title" content="'.$title.'"/>');
    $document->addCustomTag('<meta property="og:description" content="'.str_replace('"','',$metadescription).'"/>');         
    $document->addCustomTag('<meta property="og:site_name" content="'.$app->getCfg('sitename').'"/>');
    $document->addCustomTag('<meta property="og:type" content="sermon"/>');
    $document->addCustomTag('<meta property="og:url" content="'.JURI::getInstance()->toString().'"/>');
    $document->addCustomTag('<meta property="og:artist" content="'.strip_tags($this->message->teachername).'"/>');
    $document->addCustomTag('<meta property="og:album" content="'.strip_tags($this->message->seriesname).'"/>');
    
    // select media to include
    if  ($this->mode == 'listen')
    {$media = 1;}
    elseif ($this->mode == 'watch')
    {$media = 2;}
    elseif ($params->get('mediapriority', 1) == 2 && ($study->video_link && $study->video_type > 0))
    {$media = 2;}
    elseif ($params->get('mediapriority', 1) == 1 && ($study->audio_link && $study->audio_type > 0))
    {$media = 1;}
    elseif ($study->audio_link && $study->audio_type > 0)
    {$media = 1;}
    elseif ($study->video_link && $study->video_type > 0)
    {$media = 2;}
    else{$media = false;}
    
    if($media == 2){
    $mp =& JTable::getInstance('Mediaplayers', 'Table');
    $mp->load($study->video_type);
    if ($mp->facebook == 1)
    {   
        $width = $params->get('videoplayer_width', '400');
        $height = $params->get('videoplayer_height', '300');
        $playerurl  = str_replace("[fileid]",$study->video_link, $mp->playerurl );
        $playerurl  = str_replace("[root]",JURI::ROOT(), $mp->playerurl );
        $playerurl  = str_replace("[root]/",JURI::ROOT(), $mp->playerurl );
        $fileurl = Tewebbuildurl::geturl($study->video_link, $study->video_folder, 'pifilepath');
        if ($mp->image == 1)
        {
            $image = Tewebbuildurl::geturl($study->imagelrg, $study->image_folderlrg, 'pifilepath');
        }
        elseif ($mp->image == 2)
        {
            $series =& JTable::getInstance('Series', 'Table');
            $series->load($study->series);
            $image = Tewebbuildurl::geturl($series->series_image_lrg, $series->image_folderlrg, 'pifilepath');
        }
        else {$image = null;}
        if ($image)
        {$document->addCustomTag('<meta property="og:image" content="'.$image.'"/>');
        define('FBIMAGE', true);}  
        $document->addCustomTag('<meta property="og:video:height" content="'.$height.'" />');
        $document->addCustomTag('<meta property="og:video:width" content="'.$width.'" />');
        if (strpos($fileurl, 'http://') === 0)
        {$document->addCustomTag('<meta property="og:video" content="'.$fileurl.'"/>');}
        else
        {$document->addCustomTag('<meta property="og:video" content="'.$playerurl.'"/>');}
    }
    }
    elseif($media == 1){
    $mp =& JTable::getInstance('Mediaplayers', 'Table');
    $mp->load($study->audio_type);
    if ($mp->facebook == 1)
    {  
        $width = $params->get('audioplayer_width', '400');
        $height = $params->get('audioplayer_height', '300');
        $playerurl  = str_replace("[fileid]",$study->audio_link, $mp->playerurl );
        $fileurl = Tewebbuildurl::geturl($study->audio_link, $study->audio_folder, 'pifilepath');
        if ($mp->image == 1 && !defined('FBIMAGE'))
        {
            $image = Tewebbuildurl::geturl($study->imagelrg, $study->image_folderlrg, 'pifilepath');
        }
        elseif ($mp->image == 2 && !defined('FBIMAGE'))
        {
            $series =& JTable::getInstance('Series', 'Table');
            $series->load($study->series);
            $image = Tewebbuildurl::geturl($series->series_image_lrg, $series->image_folderlrg, 'pifilepath');
        }
        else {$image = null;}
        if ($image)
        {$document->addCustomTag('<meta property="og:image" content="'.$image.'"/>');}
        $document->addCustomTag('<meta property="og:audio:height" content="'.$height.'" />');
        $document->addCustomTag('<meta property="og:audio:width" content="'.$width.'" />');
        if (strpos($fileurl, 'http://') === 0)
        {$document->addCustomTag('<meta property="og:audio" content="'.$fileurl.'"/>');}
        else
        {$document->addCustomTag('<meta property="og:audio" content="'.$playerurl.'"/>');}
        $document->addCustomTag('<meta property="og:audio:artist" content="'.strip_tags($this->message->teachername).'"/>');
        $document->addCustomTag('<meta property="og:audio:album" content="'.strip_tags($this->message->seriesname).'"/>');
        $document->addCustomTag('<meta property="og:audio:title" content="'.$title.'"/>');
    }
    }
}
}