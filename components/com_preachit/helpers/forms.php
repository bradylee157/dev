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
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelperforms{

/**
     * Method to get list of message form items
     * @return    array
     */     
    
function messageformitems()
{
$disable = false;
$enable = true;
$options[] = JHTML::_('select.option','#pimform_hits:hits', JText::_('COM_PREACHIT_ADMIN_HITS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_alias:study_alias', JText::_('COM_PREACHIT_ADMIN_ALIAS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_desc:study_description', JText::_('COM_PREACHIT_ADMIN_DESCRIPTION'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_bibleref:study_book', JText::_('COM_PREACHIT_ADMIN_BIBLE_REF'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_bibleref2:study_book2', JText::_('COM_PREACHIT_ADMIN_BIBLE_REF2'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_dur:dur_hrs', JText::_('COM_PREACHIT_ADMIN_DURATION'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_teacher:teacher', JText::_('COM_PREACHIT_ADMIN_TEACHER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_teacher:newteacherbutton', JText::_('COM_PREACHIT_ADMIN_TEACHER_BUTTON'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_series:series', JText::_('COM_PREACHIT_ADMIN_SERIES'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_teacher:newseriesbutton', JText::_('COM_PREACHIT_ADMIN_SERIES_BUTTON'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_ministry:ministry', JText::_('COM_PREACHIT_ADMIN_MINISTRY'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_teacher:newministrybutton', JText::_('COM_PREACHIT_ADMIN_MINISTRY_BUTTON'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_asmedia:asmedia', JText::_('COM_PREACHIT_ADMIN_ASMEDIA'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_tags:tags', JText::_('COM_PREACHIT_ADMIN_TAGS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_state:published', JText::_('COM_PREACHIT_ADMIN_STATE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_mesdate:study_date', JText::_('COM_PREACHIT_ADMIN_MESDATE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_pubup:publish_up', JText::_('COM_PREACHIT_ADMIN_PUBLISHUP'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_pubdown:publish_down', JText::_('COM_PREACHIT_ADMIN_PUBLISHDOWN'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_podpubup:podpublish_up', JText::_('COM_PREACHIT_SUB_PODPUBLISH_OPTIONS').' - '.JText::_('COM_PREACHIT_ADMIN_PUBLISHUP'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_podpubdown:podpublish_down', JText::_('COM_PREACHIT_SUB_PODPUBLISH_OPTIONS').' - '.JText::_('COM_PREACHIT_ADMIN_PUBLISHDOWN'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_comments:comments', JText::_('COM_PREACHIT_ADMIN_COMMENTS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_studylist:studylist', JText::_('COM_PREACHIT_ADMIN_STUDYLIST'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_access:access', JText::_('COM_PREACHIT_ADMIN_ACCESS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_language:language', JText::_('JFIELD_LANGUAGE_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_metadesc:metadesc', JText::_('JFIELD_META_DESCRIPTION_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_metakey:metakey', JText::_('JFIELD_META_KEYWORDS_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_AUDIOHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_aplayer:audio_type', ' - '.JText::_('COM_PREACHIT_ADMIN_AUDIO_PLAYER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_afolder:audio_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_AUDIO_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_afile:audio_link', ' - '.JText::_('COM_PREACHIT_ADMIN_AUDIO_FILE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_afs:audiofs', ' - '.JText::_('COM_PREACHIT_ADMIN_FILESIZE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_adownload:audio_download', ' - '.JText::_('COM_PREACHIT_ADMIN_AUDIO_DOWNLOAD'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_apur:audpurchase', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_apurf:audpurchase_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE_BASE_URL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_apurl:audpurchase_link', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE_LINK'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_aprice:audioprice', ' - '.JText::_('COM_PREACHIT_ADMIN_AUDIOPRICE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_VIDEOHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_vplayer:video_type', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEO_PLAYER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vfolder:video_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEO_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vfile:video_link', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEOFILE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vfs:videofs', ' - '.JText::_('COM_PREACHIT_ADMIN_FILESIZE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vdownload:video_download', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEO_DOWNLOAD'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_dvid:add_downloadvid', ' - '.JText::_('COM_PREACHIT_ADMIN_ALT_DOWNLOAD_VID'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_dvidfolder:downloadvid_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_ALT_DOWNLOAD_VID_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_dvidlink:downloadvid_link', ' - '.JText::_('COM_PREACHIT_ADMIN_ALT_DOWNLOAD_VID_LINK'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_advfs:advideofs', ' - '.JText::_('COM_PREACHIT_ADMIN_FILESIZE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vpur:vidpurchase', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vpurf:vidpurchase_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE_BASE_URL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vpurl:vidpurchase_link', ' - '.JText::_('COM_PREACHIT_ADMIN_PURCHASE_LINK'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_vprice:videoprice', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEOPRICE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_TEXTHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_mtext:study_text', ' - '.JText::_('COM_PREACHIT_ADMIN_STUDY_TEXT'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_NOTESHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_notes:notes', ' - '.JText::_('COM_PREACHIT_ADMIN_NOTES'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_nfolder:notes_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_NOTES_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_nfile:notes_link', ' - '.JText::_('COM_PREACHIT_ADMIN_NOTES_FILE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_nfs:notesfs', ' - '.JText::_('COM_PREACHIT_ADMIN_FILESIZE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_SLIDESHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_slides:slides', ' - '.JText::_('COM_PREACHIT_ADMIN_SLIDES'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_slides_folder:slides_folder', ' - '.JText::_('COM_PREACHIT_ADMIN_SLIDES_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_slides_link:slides_link', ' - '.JText::_('COM_PREACHIT_ADMIN_SLIDES_FILE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_slides_type:slides_type', ' - '.JText::_('COM_PREACHIT_ADMIN_SLIDES_TYPE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_slidesfs:slidesfs', ' - '.JText::_('COM_PREACHIT_ADMIN_FILESIZE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_IMAGEHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pimform_imlf:image_folderlrg', ' - '.JText::_('COM_PREACHIT_ADMIN_IMAGE_FOLDERLRG'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pimform_iml:imagelrg', ' - '.JText::_('COM_PREACHIT_ADMIN_IMAGE_LARGE'), 'value', 'text', $disable );


return $options;
}

/**
     * Method to get list of series form items
     * @return    array
     */   

function seriesformitems()
{
$disable = false;
$enable  = true;

$options[] = JHTML::_('select.option','#pisform_alias:series_alias', JText::_('COM_PREACHIT_ADMIN_ALIAS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_ministry:ministry', JText::_('COM_PREACHIT_ADMIN_MINISTRY'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_state:published', JText::_('COM_PREACHIT_ADMIN_STATE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_access:access', JText::_('COM_PREACHIT_ADMIN_ACCESS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_language:language', JText::_('JFIELD_LANGUAGE_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_metadesc:metadesc', JText::_('JFIELD_META_DESCRIPTION_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_metakey:metakey', JText::_('JFIELD_META_KEYWORDS_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_imlf:image_folderlrg', JText::_('COM_PREACHIT_ADMIN_IMAGE_FOLDERLRG'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_iml:series_image_lrg', JText::_('COM_PREACHIT_ADMIN_IMAGE_LARGE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_imlp', JText::_('COM_PREACHIT_ADMIN_LRGIMAGE_PREVIEW'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_VIDEOHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pisform_vplayer:videoplayer', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEO_PLAYER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_vfolder:videofolder', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEO_FOLDER'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_vfile:videolink', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEOFILE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_vwidth:vwidth', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEOWDTH'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pisform_vheight:vheight', ' - '.JText::_('COM_PREACHIT_ADMIN_VIDEOHGT'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_DESCHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pisform_sdesc:series_description', ' - '.JText::_('COM_PREACHIT_ADMIN_DESCRIPTION'), 'value', 'text', $disable );

return $options;
}

/**
     * Method to get list of teacher form items
     * @return    array
     */   

function teacherformitems()
{
$disable = false;
$enable  = true;

$options[] = JHTML::_('select.option','#pitform_alias:teacher_alias', JText::_('COM_PREACHIT_ADMIN_ALIAS'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_role:teacher_role', JText::_('COM_PREACHIT_ADMIN_ROLE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_email:teacher_email', JText::_('COM_PREACHIT_ADMIN_EMAIL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_web:teacher_website', JText::_('COM_PREACHIT_ADMIN_WEBSITE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_state:published', JText::_('COM_PREACHIT_ADMIN_STATE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_tpage:teacher_view', JText::_('COM_PREACHIT_ADMIN_TEACHER_PAGE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_language:language', JText::_('JFIELD_LANGUAGE_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_metadesc:metadesc', JText::_('JFIELD_META_DESCRIPTION_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_metakey:metakey', JText::_('JFIELD_META_KEYWORDS_LABEL'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_imlf:image_folderlrg', JText::_('COM_PREACHIT_ADMIN_IMAGE_FOLDERLRG'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_iml:teacher_image_lrg', JText::_('COM_PREACHIT_ADMIN_IMAGE_LARGE'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','#pitform_imlp', JText::_('COM_PREACHIT_ADMIN_LRGIMAGE_PREVIEW'), 'value', 'text', $disable );
$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_ADMIN_DESCHEAD'), 'value', 'text', $enable );
$options[] = JHTML::_('select.option','#pitform_tdesc:teacher_description', ' - '.JText::_('COM_PREACHIT_ADMIN_DESCRIPTION'), 'value', 'text', $disable );

return $options;
}

/**
     * Method to get message form select list
     * @param boolean $front determines whether to use the front sort values
     * @return    array
     */   

function getmessagesel($front = 0)
{
$disable = false;
$enable  = true;

$row =& JTable::getInstance('Piadmin', 'Table');
$row->load(1);
$array = explode(',', $row->mfupsel);
if ($front != 0)
{$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(1, $array))
{$options[] = JHTML::_('select.option',1, JText::_('COM_PREACHIT_UPLOAD_SEL_AUDIO'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(2, $array))
{
$options[] = JHTML::_('select.option',2, JText::_('COM_PREACHIT_UPLOAD_SEL_VIDEO'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(7, $array))
{
$options[] = JHTML::_('select.option',7, JText::_('COM_PREACHIT_UPLOAD_SEL_ADD_DOWN'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(3, $array))
{
$options[] = JHTML::_('select.option',3, JText::_('COM_PREACHIT_UPLOAD_SEL_NOTES'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(8, $array))
{
$options[] = JHTML::_('select.option',8, JText::_('COM_PREACHIT_UPLOAD_SEL_SLIDES'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(4, $array))
{
$options[] = JHTML::_('select.option',4, JText::_('COM_PREACHIT_UPLOAD_SEL_IMGLRG'), 'value', 'text', $disable );}

return $options;
}

/**
     * Method to hide items in message form selected in admin area
     * @return    string
     */ 

function hidemessageedit()
{
	// get hidden fields
	$row =& JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
	$hide = array();
	if ($row->mfhide)
	{$hide = PIHelperforms::getstyleform($row->mfhide);}
	return $hide;
}

/**
     * Method to get series form select list
     * @param boolean $front determines whether to use the front sort values
     * @return    array
     */ 

function getseriessel($front = 0)
{
	
$disable = false;
$enable  = true;

$row =& JTable::getInstance('Piadmin', 'Table');
$row->load(1);
$array = explode(',', $row->sfupsel);	
if ($front != 0)
{$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(1, $array))
{
$options[] = JHTML::_('select.option',1, JText::_('COM_PREACHIT_UPLOAD_SEL_IMGLRG'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(3, $array))
{
$options[] = JHTML::_('select.option',3, JText::_('COM_PREACHIT_UPLOAD_SEL_VIDEO'), 'value', 'text', $disable );}

return $options;
}

/**
     * Method to hide items in series form selected in admin area
     * @return    string
     */ 

function hideseriesedit()
{
	// get hidden fields
	$row =& JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
	$hide = array();
	if ($row->sfhide)
	{$hide = PIHelperforms::getstyleform($row->sfhide);}
	return $hide;
}

/**
     * Method to get teacher form select list
     * @param boolean $front determines whether to use the front sort values
     * @return    array
     */ 

function getteachersel()
{
$disable = false;
$enable  = true;
$app = JFactory::getApplication();
if ($app->isSite())
{$front = 1;} else {$front = 0;}

$row =& JTable::getInstance('Piadmin', 'Table');
$row->load(1);
$array = explode(',', $row->tfupsel);		

if ($front != 0)
{$options[] = JHTML::_('select.option','', JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA'), 'value', 'text', $disable );}
if ($front == 0 || !in_array(1, $array))
{
$options[] = JHTML::_('select.option',1, JText::_('COM_PREACHIT_UPLOAD_SEL_IMGLRG'), 'value', 'text', $disable );}

return $options;
}

/**
     * Method to hide items in teacher form selected in admin area
     * @return    string
     */ 

function hideteacheredit()
{
	// get hidden fields
	$row =& JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
	$hide = array();
	if ($row->tfhide)
	{$hide = PIHelperforms::getstyleform($row->tfhide);}
	return $hide;
}

/**
     * Method to proces the form entries to hide
     * @return    array
     */ 

function getstyleform($field)
{
	$fields = explode(',', $field);
	$rules = '';
	$i = 1;
	foreach ($fields AS $f)
	{
		$id = explode(':', $f);
        if (isset($id[1]))
        {
		    $f = $id[1];
		    if ($i != 1)
		    {$pre = ',';} else {$pre = '';}
		    $rules = $rules.$pre.$f;
		    $i++;
        }
	}
	$hide = explode(',', $rules);
	return $hide;
}

/**
     * Method to check form entries on saving the form to make sure nothing hacked
     * @param array $row form details
     * @param string $table table to check
     * @param array $hide elements hidden
     * @return    array
     */ 

function checkentries ($row, $table, $hide)
{
	$check=& JTable::getInstance($table, 'Table');
	$check->load($row->id);
    $admin=& JTable::getInstance('Piadmin', 'Table');
    $admin->load(1);
	if ($hide)
	{
		$fields = explode(',', $hide);
		foreach ($fields AS $f)
		{
			$f = explode(':', $f);
			if (isset($f[1]))
			{ 
            if ($table == 'Studies' && !$row->id && isset($admin->$f[1]))
            {$row->$f[1] = $admin->$f[1];}
			elseif ($f[1] == 'study_book' && $table == 'Studies')
			{$row->study_book = $check->study_book;
			$row->ref_ch_beg = $check->ref_ch_beg;
			$row->ref_ch_end = $check->ref_ch_end;
			$row->ref_vs_beg = $check->ref_vs_beg;
			$row->ref_vs_end = $check->ref_vs_end;}
			elseif ($f[1] == 'study_book2' && $table == 'Studies')
			{$row->study_book2 = $check->study_book2;
			$row->ref_ch_beg2 = $check->ref_ch_beg2;
			$row->ref_ch_end2 = $check->ref_ch_end2;
			$row->ref_vs_beg2 = $check->ref_vs_beg2;
			$row->ref_vs_end2 = $check->ref_vs_end2;}		
			elseif ($f[1] == 'dur_hrs' && $table == 'Studies')
			{$row->dur_hrs = $check->dur_hrs;
			$row->dur_mins = $check->dur_mins;
			$row->dur_secs = $check->dur_secs;}	
            elseif (!$row->id && $f[1] == 'teacher_view')
            {$row->$f[1] = 1;}
			else {$row->$f[1] = $check->$f[1];} 
			}	
		} 
	}
	
	return $row;
}			

}
?>