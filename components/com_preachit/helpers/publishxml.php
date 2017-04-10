<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
jimport('teweb.file.urlbuilder');
jimport('teweb.file.functions');

class PIHelperpodcast{

/**
     * Method to publish single podcast
     * @param int $id id of podcast
     * @return   boolean
     */    
    
function publishsingle($id)
{
// get info
	
$app = JFactory::getApplication();	
$option = JRequest::getCmd('option');
$config =& JFactory::getConfig();
$pod =& JTable::getInstance('Podcast', 'Table');
$pod->load($id);
$pod->website = JURI::ROOT();
$pod->website = Tewebbuildurl::cleanserver($pod->website);
$pod->item = $pod->menu_item;
if ($pod->item > 0) {$pod->itemid = '&Itemid='.$pod->item;}
else {$pod->itemid = '';}
$records = $pod->records;
$selections = PIHelperpodcast::getselection($id, $pod, $records);

// build header

$podcast1 = PIHelperpodcast::podcast1($pod);

// get episodes

$podcast2 = PIHelperpodcast::getepisodes($pod, $selections, $id);       
$e = $podcast2->e;

$podcast3 = '</channel></rss>';

$filecontent = $podcast1.$podcast2->html.$podcast3;

$writefile = Tewebfile::writefile($pod->filename, $filecontent);

if ($writefile)
		{
		$today = JFactory::getDate()->toMySQL();
		$db =& JFactory::getDBO();
		$db->setQuery("UPDATE #__pipodcast SET podpub = '{$today}' WHERE id = '{$id}' ;");
		$db->query();

		if ($e>0)
		{ $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_XML_WRITTEN').':: '.$e.' '.JText::_('LIB_TEWEB_MESSAGE_MEDIA_FILE_NOT_FOUND'), 'notice');}
		else {
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_XML_WRITTEN'), 'message'); }
		}		
		
		else {	
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_OPERATION_FAILED').': '.JText::sprintf('LIB_TEWEB_MESSAGE_FAILED_OPEN', $file), 'warning');
		}		
		return true;
}

/**
     * Method to publish all podcasts
     * @return   boolean
     */ 

function publishall()
{
$app = JFactory::getApplication();	
$option = JRequest::getCmd('option');
$config =& JFactory::getConfig();
$task = JRequest::getString('task');
$db=& JFactory::getDBO();
$query7 = "SELECT * FROM #__pipodcast WHERE published = 1";
$db->setQuery($query7);
$pods = $db->loadObjectList();

foreach ($pods as $pod)
{
$id = $pod->id;
$pod->item = $pod->menu_item;
$pod->website = JURI::ROOT();
$pod->website = Tewebbuildurl::cleanserver($pod->website);
if ($pod->item > 0) {$pod->item = '&Itemid='.$pod->item;}
else {$pod->item = '';}
$records = $pod->records;
$selections = PIHelperpodcast::getselection($id, $pod, $records);

// build header

$podcast1 = PIHelperpodcast::podcast1($pod);

// get episodes

$podcast2 = PIHelperpodcast::getepisodes($pod, $selections, $id);   

$e = $podcast2->e;

$podcast3 = '</channel></rss>';

$filecontent = $podcast1.$podcast2->html.$podcast3;

$writefile = Tewebfile::writefile ($pod->filename, $filecontent);

if (!$writefile)
{
		$app->Redirect('index.php?option='.$option.'&view=studylist'.$item, JText::_('LIB_TEWEB_MESSAGE_OPERATION_FAILED').': '.JText::sprintf('LIB_TEWEB_MESSAGE_FAILED_OPEN', $file));
}
		$today = JFactory::getDate()->toMySQL();
			$db =& JFactory::getDBO();
		$db->setQuery("UPDATE #__pipodcast SET podpub = '{$today}' WHERE id = '{$id}' ;");
		$db->query();
}
	
if ($task == 'apply' || $task == 'applymodal')
{
	if ($e>0)	
		{
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_AND_PODCASTS').'::'.$e.' '.JText::_('LIB_TEWEB_MESSAGE_MEDIA_FILE_NOT_FOUND'), 'notice');}
    else {
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_AND_PODCASTS'), 'message'); }
            
}
else
{
	$link = JRoute::_('index.php?option=com_preachit&view=studylist'.$item);
    if ($e>0)    
        {
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_AND_PODCASTS').'::'.$e.' '.JText::_('LIB_TEWEB_MESSAGE_MEDIA_FILE_NOT_FOUND'), 'notice');}
    else {
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_AND_PODCASTS'), 'message'); }
}

return $true;
}

// builder functions

/**
     * Method to get relevant data for podcast
     * @param int $id id of podcast
     * @param array $pod details of podcast
     * @param int $records no of records to get
     * @return   array
     */ 
	
function getselection($id, $pod, $records)
{
jimport( 'joomla.database.database' );
$now = gmdate ( 'Y-m-d H:i:s' );
$nullDate = '0000-00-00 00:00:00';
$db=& JFactory::getDBO();

$teacher_list = explode(',', $pod->teacher_list);
$series_list = explode(',', $pod->series_list);
$ministry_list = explode(',', $pod->ministry_list);

// build where statement
         
         if ($pod->teacher == 1) {
            if (count($teacher_list) > 1)
            {foreach ($teacher_list AS $tl)
                    {$tlist[] = 'teacher REGEXP "[[:<:]]'.$tl.'[[:>:]]"';}
                $where[] = '('. ( count( $tlist ) ? implode( ' OR ', $tlist ) : '' ) .')';}
            else
            {  $value = PIHelperadditional::getwherevalue($teacher_list);
                $where[] = ' teacher REGEXP "[[:<:]]'.(int) $value.'[[:>:]]"';}
        }
        if ($pod->series == 1) {
            if (count($series_list) > 1)
            {foreach ($series_list AS $sl)
                {$slist[] = 'series = '.$sl;}
            $where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';}
            else
            {$value = PIHelperadditional::getwherevalue($series_list);
                $where[] = 'series = '.$value;}
        }
        if ($pod->ministry == 1) {
            if (count($ministry_list) > 1)
            {foreach ($ministry_list AS $ml)
                    {$mlist[] = 'ministry REGEXP "[[:<:]]'.$ml.'[[:>:]]"';}
                $where[] = '('. ( count( $mlist ) ? implode( ' OR ', $mlist ) : '' ) .')';}
            else
            {  $value = PIHelperadditional::getwherevalue($ministry_list);
                $where[] = ' ministry REGEXP "[[:<:]]'.(int) $value.'[[:>:]]"';}
        }
        $where[] = ' published = 1';
        $where[] = ' language IN ('.$db->quote($pod->languagesel).','.$db->quote('*').')';
        $where[] = '(publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).')';
        $where[] = '(publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).')';
        $where[] = '(podpublish_up = '.$db->Quote($nullDate).' OR podpublish_up <= '.$db->Quote($now).')';
        $where[] = '(podpublish_down = '.$db->Quote($nullDate).' OR podpublish_down >= '.$db->Quote($now).')';
        
        $where         = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

        $query = "SELECT * FROM #__pistudies "
        .$where
        ." ORDER BY study_date DESC";
        $db->setQuery( $query, 0, $records );
        $selections = $db->loadObjectList();    
   
        return $selections;
}

/**
     * Method to form podcast head
     * @param array $pod details of podcast
     * @return   string
     */ 

function podcast1($pod)
{

$podcast1 = '<?xml version="1.0" encoding="utf-8"?> 
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0"> 
<channel> <title>' . $pod->name . '</title>
<link>' . $pod->website . '</link> 
<description>' . $pod->description . '</description><itunes:summary>' . $pod->description . '</itunes:summary> <itunes:subtitle>' . $pod->name . '</itunes:subtitle> 
<image> <link>' . $pod->website . '</link> 
<url>http://' . $pod->image . '</url> 		
<title>' . $pod->name . '</title> 		
<height>' . $pod->imagehgt . '</height> 		
<width>' . $pod->imagewth . '</width> 	</image> 	
<itunes:image href="http://' . $pod->image . '" />
	<category>'.JText::_('COM_PREACHIT_PODCAST_CATEGORY').'</category>
	<itunes:category text="'.JText::_('COM_PREACHIT_PODCAST_CATEGORY').'">
<itunes:category text="'.JText::_('COM_PREACHIT_PODCAST_SUBCATEGORY').'" /></itunes:category> <language>' . $pod->language . '</language> 	
<copyright>(2010) All rights reserved.</copyright> 	
<pubDate>' . JFactory::getDate()->toRFC822()  . '</pubDate> <lastBuildDate>' . JFactory::getDate()->toRFC822()  . '</lastBuildDate> <generator>Preach it</generator> 	
<managingEditor>' . $pod->email . '('.$pod->author.')</managingEditor> <webMaster>' . $pod->email . '('.$pod->author.')</webMaster> 	<itunes:owner> <itunes:name>' . $pod->editor . '</itunes:name> 	
<itunes:email>' . $pod->email . '</itunes:email> 	</itunes:owner> <itunes:author>' . $pod->author . '</itunes:author> <itunes:explicit>no</itunes:explicit> 	<ttl>1</ttl> 	
<atom:link href="' . $pod->website . '/' . $pod->filename . '" rel="self" type="application/rss+xml" />';

return $podcast1;
}

/**
     * Method to build episodes for the podcast
     * @param array $pod details of podcast
     * @param array $selections message details from podcast
     * @param int $id id of podcast
     * @return   string
     */ 

function getepisodes($pod, $selections, $id)
{
//set variable e to 0 - this tells the user how many media files were not found
$podcast = '';
$podcast->e=0;
$podcast->html = '';
if (trim($pod->media_list) == null)
{
    $media_list = array('audio','video','notes','slides');
}
else {
    $media_list = explode(',', $pod->media_list);
}
foreach ($selections as $selection)
{
$podcastepisode = '';
$podcastepisode2->sub = '';
$podcastepisode3 = '';
$podcastepisode4->sub = '';
$podcastepisode5 = '';
$podcastepisode6->sub = '';
$podcastepisode7 = '';
$podcastepisode8->sub = '';
            
// get info for podcast

$itunes = PIHelperpodcast::getstudyinfo($selection->id, $pod);

if (in_array('video', $media_list) && $itunes->video_link)	

{
           
$podcastepisode = PIHelperpodcast::getepisode($itunes, $pod, 0);

//get fileinfo

$vidfile = Tewebbuildurl::geturl($itunes->video_link, $itunes->video_folder, 'pifilepath');
$fileinfo = Tewebfile::buildfileinfo($vidfile, $itunes->videofs, 'pod');

$podcastepisode2 = PIHelperpodcast::getepisode2($fileinfo, $itunes, $podcast->e, 0);

$podcast->e = $podcastepisode2->e;
                    
}

if (in_array('audio', $media_list) && $itunes->audio_link)    
{
	            
$podcastepisode3 = PIHelperpodcast::getepisode($itunes, $pod, 1);

//get fileinfo

$audfile = Tewebbuildurl::geturl($itunes->audio_link, $itunes->audio_folder, 'pifilepath');
$fileinfo2 = Tewebfile::buildfileinfo($audfile, $itunes->audiofs, 'pod');

$podcastepisode4 = PIHelperpodcast::getepisode2($fileinfo2, $itunes, $podcast->e, 1);

$podcast->e = $podcastepisode4->e;

}

if (in_array('notes', $media_list)&& $itunes->notes_link)    
{

//get fileinfo
    
$notesfile = Tewebbuildurl::geturl($itunes->notes_link, $itunes->notes_folder, 'pifilepath');
$fileinfo3 = Tewebfile::buildfileinfo($notesfile, $itunes->notesfs, 'pod');
$itunes->linkn = $fileinfo3->file;
    
$podcastepisode5 = PIHelperpodcast::getepisode($itunes, $pod, 2);

$podcastepisode6 = PIHelperpodcast::getepisode2($fileinfo3, $itunes, $podcast->e, 2);

$podcast->e = $podcastepisode6->e;
            
}

if (in_array('slides', $media_list)&& $itunes->slides_link)    
{

//get fileinfo
    
$slidesfile = Tewebbuildurl::geturl($itunes->slides_link, $itunes->slides_folder, 'pifilepath');
$fileinfo3 = Tewebfile::buildfileinfo($slidesfile, $itunes->slidesfs, 'pod');
$itunes->linksl = $fileinfo3->file;
    
$podcastepisode7 = PIHelperpodcast::getepisode($itunes, $pod, 3);

$podcastepisode8 = PIHelperpodcast::getepisode2($fileinfo3, $itunes, $podcast->e, 3);

$podcast->e = $podcastepisode6->e;
                        
}

$podcast->html = $podcast->html.$podcastepisode.$podcastepisode2->sub.$podcastepisode3.$podcastepisode4->sub.$podcastepisode5.$podcastepisode6->sub.$podcastepisode7.$podcastepisode8->sub;
}                
return $podcast;
}

/**
     * Method to get studyinfo for podcast episode
     * @param int $id id of study
     * @param array $pod details of podcast
     * 
     * @return   string
     */ 


function getstudyinfo($id, $pod)
{
$db=& JFactory::getDBO();
$row =& JTable::getInstance('Studies', 'Table');
$row->load($id);	
$itunes->date = PIHelperpodcast::studydate($row->study_date);
$option = 'com_preachit';

$slug = $row->id.':'.$row->study_alias;

//build scripture reference

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');

$itunes->scripture = PIHelperscripture::podscripture($row->id);

//get audio folder details

$itunes->audio_folder = $row->audio_folder;
$itunes->audio_link = $row->audio_link;

$itunes->notes_folder = $row->notes_folder;
$itunes->notes_link = $row->notes_link;

$itunes->slides_folder = $row->slides_folder;
$itunes->slides_link = $row->slides_link;

if ($row->add_downloadvid == 1)
{
	$itunes->video_folder = $row->downloadvid_folder;
	$itunes->video_link = $row->downloadvid_link;
}
else 
{
$itunes->video_folder = $row->video_folder;
$itunes->video_link = $row->video_link;
}

$itunes->linkv = $pod->website . '/index.php?'.htmlentities('option=' . $option . '&view=study&mode=watch&id=' . $slug . $pod->itemid);
$itunes->linka = $pod->website . '/index.php?'.htmlentities('option=' . $option . '&view=study&mode=listen&id=' . $slug . $pod->itemid);

//logic for ampreplace

$studyname = htmlspecialchars($row->study_name);
$study_description = '<![CDATA['.strip_tags($row->study_description).']]>';		

//create title

$itunestitle = $pod->itunestitle;

if ($itunestitle == 0)
{$itunes->title = $itunes->scripture . ' - ' . $studyname;}
If ($itunestitle == 1)
{$itunes->title = $studyname;}

//create subtitle

$itunessub = $pod->itunessub;

if ($itunessub == 0)
{$itunes->subtitle = $study_description;}
if ($itunessub == 1)
{$itunes->subtitle = $itunes->scripture . ' - ' . $study_description;}
if ($itunessub == 2)
{$itunes->subtitle = $itunes->scripture . ' - ' . $studyname;}

//create description

$itunesdesc = $pod->itunesdesc;

if ($itunesdesc == 0)
{$itunes->description = $study_description;}
if ($itunesdesc == 1)
{$itunes->description = $itunes->scripture . ' - ' . $study_description;}

//make duration right if single digit

if ($row->dur_hrs < 10)
{$itunes->hrs = '0'.$row->dur_hrs;}
else {$itunes->hrs = $row->dur_hrs;}	
	
if ($row->dur_mins < 10)
{$itunes->mins = '0'.$row->dur_mins;}
else {$itunes->mins = $row->dur_mins;}
	
if ($row->dur_secs < 10)
{$itunes->secs = '0'.$row->dur_secs;}
else {$itunes->secs = $row->dur_secs;}

// assign filesizes

$itunes->audiofs = $row->audiofs;
$itunes->videofs = $row->videofs;
$itunes->notesfs = $row->notesfs;
$itunes->slidesfs = $row->slidesfs;

// get teacher name

$itunes->teachername =  PIHelpermessageinfo::teacher($row->teacher, '', 2);
$itunes->teachername = htmlspecialchars ($itunes->teachername);

return $itunes;
}

/**
     * Method to process date into xml format
     * @param datetime $date study date
     * 
     * @return   date
     */ 

function studydate($date)
{
$adjustdate = date('D, d M Y H:i:s',strtotime($date)).' +0000';
return $adjustdate;
}

/**
     * Method to process main episode string
     * @param array $itunes message info for episodes
     * @param array $pod details of podcast
     * @param int $type set the type of link
     * @return   string
     */ 

function getepisode($itunes, $pod, $type)
{
if ($type == 0)
{$link = $itunes->linkv;}
elseif ($type == 1)
{$link = $itunes->linka;}
elseif ($type == 2)
{$link = $itunes->linkn;}
elseif ($type == 3)
{$link = $itunes->linksl;}
	
$podcastepisode = '';
$podcastepisode = '<item>
<title>' . $itunes->title . '</title>
<link>' . $link . '</link>		
<itunes:author>' . $itunes->teachername . '</itunes:author><dc:creator>' . $itunes->teachername . '</dc:creator>	
<description>' . $itunes->description . '</description>
<content:encoded>' . $itunes->description . '</content:encoded>
<pubDate>' . $itunes->date . '</pubDate><itunes:subtitle>' . $itunes->subtitle . '</itunes:subtitle>
<itunes:summary>' . $itunes->description . '</itunes:summary>
<itunes:keywords>' . $pod->search . '</itunes:keywords>
<itunes:duration>' . $itunes->hrs . ':' . $itunes->mins . ':' . $itunes->secs . '</itunes:duration>';

return $podcastepisode;
}

/**
     * Method to process main episode string
     * @param array $fileinfo data on the file for the episode
     * @param array $itunes message info for episodes
     * @param int $e no of missing files
     * @param int $type set the type of link
     * @return   string
     */ 

function getepisode2($fileinfo, $itunes, $e, $type)
{
	
if ($type == 0)
{$link = $itunes->linkv;}
elseif ($type == 1)
{$link = $itunes->linka;}
elseif ($type == 2)
{$link = $itunes->linkn;}
elseif ($type == 3)
{$link = $itunes->linksl;}
	
$db=& JFactory::getDBO();	
$query = "SELECT ".$db->nameQuote('mediatype')."
    FROM ".$db->nameQuote('#__pimime')."
    WHERE ".$db->nameQuote('extension')." = ".$db->quote($fileinfo->ext).";
  ";
$db->setQuery($query);
$mediatype = $db->loadResult();
$episode->e = $e;
if (!$fileinfo->ext)
{
        $episode->sub = '<guid>' .  $link . '</guid><itunes:explicit>no</itunes:explicit> 
</item>
';
    }
    else {
	if ($fileinfo->exists == false)
 {
        $episode->sub = '<guid>' .  $link . '</guid><itunes:explicit>no</itunes:explicit> 
</item>'; $episode->e=$e+1;
    } else {
    	

$episode->sub = '
<enclosure url="' . $fileinfo->file . '" length="' . $fileinfo->size . '" type="' . $mediatype . '" />
<guid>' .  $link . '</guid>
<itunes:explicit>no</itunes:explicit> 
</item>'; 
}

}

return $episode;

}

}
?>