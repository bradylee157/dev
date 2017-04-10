<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('teweb.effects.standard');

class PIHelperinfobuilder{

/**
	 * Method to get message info
	 *
	 * @param	array $row The details for the message.
	 * @param	array $params The template params.
	 * @param	bolean $view	The view integer variable that differentiates between message list or message details view.
	 * @param	array	$plgparams	Plugin params if called from content plugin.
	 *
	 * @return	array
	 */

function messageinfo($row, $params, $view, $runplugin = false, $plgparams = null, $width = null, $height = null)
{
	// load helpers
	$abspath    = JPATH_SITE;
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/links.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/editlinks.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/messageimage.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/seriesimage.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/ministryimage.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
    require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/comments.php');
    require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');

	
	//get params & other things
	
	$format = $params->get('date_format', '');
	
	// check to see if call from content plugin and if so get certain params from there - if not get all from template params 
	if ($plgparams)
		{
			$item = $plgparams->get('menuitem', '');
			if (!$item)
			{
				$item = JRequest::getInt('Itemid', '');
			}
			$popup = $plgparams->get('popup', 0);
            $mediaaudio = 'pluginaudio';
            $mediavideo = 'pluginvideo';
		}
	
	else 
		{
			$item = JRequest::getInt('Itemid', '');	
			$popup = $params->get('popup', '0');
            $mediaaudio = 'audio';
            $mediavideo = 'video';
		}
		
	$studyslug = $row->id.':'.$row->study_alias;
	$asmedia = $params->get('asmedia', 1);
	
	//build message array	
	
	$message->id = $row->id;	
	$message->name = PIHelpermessageinfo::messagename($row->study_name, $studyslug, $view, $row->audio, $row->video, $row->text, $popup, $item);
	$message->date = JHTML::Date($row->study_date, $format);
    $message->originaldate = $row->study_date;
	$message->description = $row->study_description;
    if (trim($row->study_text) != null && $runplugin)
    {
        $message->text = Tewebeffects::runcontentplugins('onContentPrepare', 'com_preachit.study', $row->study_text, $params);
    }
	else {$message->text = $row->study_text;}
	$message->scripture = PIHelperscripture::scripture($row->id);
	$message->scripture1 = PIHelperscripture::ref1($row->id);
	$message->scripture2 = PIHelperscripture::ref2and($row->id);
	$message->scripture2noand = PIHelperscripture::ref2($row->id);
    $message->chbeg = $row->ref_ch_beg;
	$message->seriesname = PIHelpermessageinfo::series($row->series, $item);
	$message->teachername = PIHelpermessageinfo::teacher($row->teacher, $item);
	$message->ministryname = PIHelpermessageinfo::ministry($row->ministry, $item);
	$message->duration = PIHelpermessageinfo::duration($row->id);
	$message->linklisten = PIHelperlinks::audiolink($row->id, $row->audio_link, $studyslug, $item, $popup);
	$message->linkwatch = PIHelperlinks::videolink($row->id, $row->video_link, $studyslug, $item, $popup);
	$message->linktext = PIHelperlinks::textlink($row->id, $row->study_text, $studyslug, $item);
	$message->linknotes = PIHelperlinks::noteslink($row->notes_link, $row->notes_folder, $row->notes);
    $message->linkslides = PIHelperlinks::slideslink($row->slides_link, $row->slides_folder, $row->slides, $row->slides_type);
	$message->downloadaud = PIHelperlinks::download($row->id, $row->audio_download, 0, $row->audio_link);
	$message->downloadvid = PIHelperlinks::download($row->id, $row->video_download, 1, $row->video_link, $row->downloadvid_link, $row->add_downloadvid);
	$message->editlink = PIHelpereditlinks::editlink($row->id, $row->user);
	$message->purchaseaud = PIHelperlinks::purchase($row->audpurchase, $row->audpurchase_folder, $row->audpurchase_link, 1);
	$message->purchasevid = PIHelperlinks::purchase($row->vidpurchase, $row->vidpurchase_folder, $row->vidpurchase_link, 2);
	$message->afilesize = PIHelpermessageinfo::getfilesize($row->audiofs);
	$message->vfilesize = PIHelpermessageinfo::getfilesize($row->videofs);
	$message->altvfilesize = PIHelpermessageinfo::getfilesize($row->advideofs);
	$message->nfilesize = PIHelpermessageinfo::getfilesize($row->notesfs);
    $message->sfilesize = PIHelpermessageinfo::getfilesize($row->slidesfs);
	$message->comments = $row->comments;
    $message->audioprice = $row->audioprice;
    $message->videoprice = $row->videoprice;
	
	if ($asmedia == 1)

	{
	$message->amlink = PIHelperlinks::amlink($row->id, $item);
	}

	else {$message->amlink = '';}
	
	$message->share = PIHelperadditional::sharecode($row->id, $studyslug, $row->study_name, $row->study_description, $row->video, $row->audio, $row->text, 1, $item);
	$message->hits = $row->hits;
	$message->downloads = $row->downloads;
	$message->mimagesm = PIHelpermimage::messageimage($row->id, $view, $item, $popup, 'small');
	$message->mimagemed = PIHelpermimage::messageimage($row->id, $view, $item, $popup, 'medium');
	$message->mimagelrg = PIHelpermimage::messageimage($row->id, $view, $item, $popup, 'large');
	$message->timagesm = PIHelpertimage::teacherimage($row->teacher, 1, $item, 'small');
    $message->timagemed = PIHelpertimage::teacherimage($row->teacher, 1, $item, 'medium');
	$message->timagelrg = PIHelpertimage::teacherimage($row->teacher, 1, $item, 'large');
	$message->simagesm = PIHelpersimage::seriesimage($row->series, 1, $item, 'small');
    $message->simagemed = PIHelpersimage::seriesimage($row->series, 1, $item, 'medium');
	$message->simagelrg = PIHelpersimage::seriesimage($row->series, 1, $item, 'large');
	$message->minimagesm = PIHelperminimage::ministryimage($row->ministry, 1, $item, 'small');
    $message->minimagemed = PIHelperminimage::ministryimage($row->ministry, 1, $item, 'medium');
	$message->minimagelrg = PIHelperminimage::ministryimage($row->ministry, 1, $item, 'large');
	$message->tags = PIHelpermessageinfo::gettags($row->tags);
	$message->access = PIHelpermessageinfo::access($row->access, $row->series, $row->ministry);
	$message->mobilelink = PIHelpermessageinfo::messagelink($studyslug, $row->audio, $row->video, $row->text, $popup, $item);
    $message->partno = PIHelpermessageinfo::getpartno($row->id, $row->series);
    
    // get comment count
    $message->commentno = PIHelpercomments::getcommentcount($row, $row->comments, $params);
    
    // get media players
    
    //set audioplayer code to standard JW player for studies pre the mediaplayer custom engine feature on preachit

    if ($row->audio_type > 0)
    {
    $aplayer = $row->audio_type;}
    else {$aplayer = 6;}
    $message->videoplayer = PIHelpermediaplayer::mediaplayer($row->video_type, $row->video_link, $row->video_folder, $mediavideo, $row->id, '', $row, $width, $height);
    $message->audioplayer = PIHelpermediaplayer::mediaplayer($aplayer, $row->audio_link, $row->audio_folder, $mediaaudio, $row->id, '', $row, $width, $height);
    $message->audiofilelink = PIHelperlinks::filelink($row->audio_link, $row->audio_folder, 0);
    $message->videofilelink = PIHelperlinks::filelink($row->video_link, $row->video_folder, 1);
    
return $message;
}

/**
	 * Method to get series info
	 *
	 * @param	array $row The details for the series.
	 *
	 * @return	array
	 */

function seriesinfo($row, $params, $runplugin = false)
{
	// load helpers
	$abspath    = JPATH_SITE;
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/editlinks.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/seriesimage.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');	
	
	//get params & other things
	
	$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
    $format = $params->get('seriesdate_format', 'M Y');	
	
	// build series info
	
	$series->name = PIHelpermessageinfo::series($row->id, $item, 1);
    $series->daterange = PIHelpermessageinfo::getseriesdaterange($row->id, $format);
    $series->datestart = PIHelpermessageinfo::getseriesdate($row->id, 'ASC', null);
    $series->dateend = PIHelpermessageinfo::getseriesdate($row->id, 'DESC', null);
	$series->mobilelink = PIHelpermessageinfo::serieslink($row->id, $item);
    $series->count = PIHelpermessageinfo::seriescount($row->id);
	$series->imagesm = PIHelpersimage::seriesimage($row->id, 1, $item, 'small');
    $series->imagemed = PIHelpersimage::seriesimage($row->id, 1, $item, 'medium');
	$series->imagelrg = PIHelpersimage::seriesimage($row->id, 1, $item, 'large');
    if (trim($row->series_description) != null && $runplugin)
    {
        $series->description = Tewebeffects::runcontentplugins('onContentPrepare', 'com_preachit.series', $row->series_description, $params);
    }
	else {$series->description = $row->series_description;}
	$series->ministryname = PIHelpermessageinfo::ministry($row->ministry, $item);
	$series->editlink = 	PIHelpereditlinks::seriesedit($row->id, $row->user);
	if ($row->videolink)
	{
	$series->video = PIHelpermediaplayer::mediaplayer($row->videoplayer, $row->videolink, $row->videofolder, 'series', '', $row->id, $row);}
	else {$series->video = '';}
	$series->access = $row->access;
	
return $series;
}

/**
	 * Method to get teacher info
	 *
	 * @param	array $row The details for the teacher.
	 *
	 * @return	array
	 */

function teacherinfo($row, $runplugin = false)
{
	// load helpers
	$abspath    = JPATH_SITE;
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/editlinks.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
    jimport('teweb.file.urlbuilder');
	
	//get params & other things
	
	$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
	
	// build series info
	
	$teacher->name = PIHelpermessageinfo::teacher($row->id, $item, 1);
    $teacher->lastname = $row->lastname;
	$teacher->mobilelink = PIHelpermessageinfo::teacherlink($row->id, $item);
    $teacher->count = PIHelpermessageinfo::teachercount($row->id);
	$teacher->imagesm = PIHelpertimage::teacherimage($row->id, 1, $item, 'small');
    $teacher->imagemed = PIHelpertimage::teacherimage($row->id, 1, $item, 'medium');
	$teacher->imagelrg = PIHelpertimage::teacherimage($row->id, 1, $item, 'large');
    if (trim($row->teacher_description) != null && $runplugin)
    {
        $teacher->description = Tewebeffects::runcontentplugins('onContentPrepare', 'com_preachit.teacher', $row->teacher_description, null);
    }
    else {$teacher->description = $row->teacher_description;}
	$teacher->editlink = 	PIHelpereditlinks::teacheredit($row->id, $row->user);
	$teacher->role = htmlspecialchars($row->teacher_role);
	$teacher->email = JHTML::_('content.prepare', $row->teacher_email);
	if ($row->teacher_website)
	{
    $weblink = Tewebbuildurl::cleanserver($row->teacher_website);
	$teacher->web = '<a href="'.$weblink.'" title="'.JText::sprintf('COM_PREACHIT_TEACHER_LINK_TITLE', $row->teacher_name).'">'.$row->teacher_website.'</a>';}
	else {$teacher->web = '';}

return $teacher;
}

/**
	 * Method to get ministry info
	 *
	 * @param	array $row The details for the ministry.
	 * @return	array
	 */

function ministryinfo($row, $runplugin = false)
{
		// load helpers
	$abspath    = JPATH_SITE;
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/ministryimage.php');
	
	//get params & other things
	
	$item = JRequest::getVar('Itemid', '', 'GET', 'INT');	
	
	// build series info
	
	$ministry->name = PIHelpermessageinfo::ministry($row->id, $item, 1);
	$ministry->mobilelink = PIHelpermessageinfo::ministrylink($row->id, $item);
    $ministry->count = PIHelpermessageinfo::ministrycount($row->id);
    $ministry->countseries = PIHelpermessageinfo::ministryseriescount($row->id);
	$ministry->imagesm = PIHelperminimage::ministryimage($row->id, 1, $item, 'small');
    $ministry->imagemed = PIHelperminimage::ministryimage($row->id, 1, $item, 'medium');
	$ministry->imagelrg = PIHelperminimage::ministryimage($row->id, 1, $item, 'large');
    if (trim($row->ministry_description) != null && $runplugin)
    {
        $ministry->description = Tewebeffects::runcontentplugins('onContentPrepare', 'com_preachit.ministry', $row->ministry_description, null);
    }
    else {$ministry->description = $row->ministry_description;}
	$ministry->access = $row->access;

return $ministry;
}

/**
     * Method to get book info
     *
     * @param    array $row The details for the book.
     * @return    array
     */

function bookinfo($row)
{
    // load helpers
    $abspath    = JPATH_SITE;
    require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');

    //get params & other things
    $name = PIHelperscripture::getbookname($row, 'display_name');
    $item = JRequest::getVar('Itemid', '', 'GET', 'INT');  
    $slug = $row.':'.str_replace(' ','_',$name);
    
    // build series info
    $book->id = $row;
    $book->name = '<a class="pilink" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=book&book='.$slug.'&Itemid='.$item).'" title="'.PIHelperscripture::getdisplayname($name).'">'.PIHelperscripture::getdisplayname($name).'</a>';
    if ($book->id > 39 && $book->id < 67)
    {$book->testament = 'nt';}
    elseif ($book->id < 40)
    {$book->testament = 'ot';}
    else {$book->testament = 'other';}

return $book;
}

/**
     * Method to get date info
     *
     * @param    array $row The details for the date.
     * @return    array
     */

function dateinfo($row)
{
    $item = JRequest::getVar('Itemid', '', 'GET', 'INT'); 
    // build series info
    $date->name = '<a class="pilink" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=date&year='.$row->value.'&Itemid='.$item).'" title="'.$row->text.'">'.$row->text.'</a>';

    return $date;
    
}

/**
     * Method to get tag info
     *
     * @param    array $row The details for the date.
     * @return    array
     */

function taginfo($row)
{
    $item = JRequest::getVar('Itemid', '', 'GET', 'INT'); 
    // build series info
    $tag->name = '<a class="pilink" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=tag&tag='.$row->name.'&Itemid='.$item).'" title="'.$row->name.'">'.$row->name.'</a>';
    $tag->plainname = $row->name;
    return $tag;
}

}

?>