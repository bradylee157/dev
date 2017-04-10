<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PIHelpertooltips{

/**
     * Method to build correct tooltip image url
     * @param boolean sets whether admin or site area
     * @return   string
     */        
    
function image($admin)
{
	if ($admin == 0)
		
		{
			$image = '<img border="0" alt="Tooltip" src="components/com_preachit/assets/images/tooltip.png">';
		}
		
	if ($admin == 1)
	
		{
			$image = '<img border="0" alt="Tooltip" src="../components/com_preachit/assets/images/tooltip.png">';
		}
		
	return $image;

}

/**
     * Method for tooltip for sort list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function sortltemp($admin = 1)
{

$image = PIHelpertooltips::image($admin);
$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[booklist] = '.JText::_('COM_PREACHIT_TEMP_BOOK_LIST').'<br />
[teacherlist] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_LIST').'<br />
[serieslist] = '.JText::_('COM_PREACHIT_TEMP_SERIES_LIST').'<br />
[ministrylist] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_LIST').'<br />
[yearlist] = '.JText::_('COM_PREACHIT_TEMP_YEAR_LIST').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for message list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function mltemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[date] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_DATE').'<br />
[name] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_TITLE').'<br />
[description] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_DESCRIPTION').'<br />
[scripture] ='.JText::_('COM_PREACHIT_TEMP_MAIN_SCRIPTURE_REFERENCE').'<br />
[scripture2] ='.JText::_('COM_PREACHIT_TEMP_SECONDARY_SCRIPTURE_REFERENCE_PRECEDED').'<br />
[scripture2noand] ='.JText::_('COM_PREACHIT_TEMP_SECONDARY_SCRIPTURE_REFERENCE_NOT_PRECEDED').'<br />
[imagesm] = '. JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGESM').'<br />
[imagemed] = '.JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGEMED').'<br />
[imagelrg] = '.JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGELRG').'<br />
[series] = '.JText::_('COM_PREACHIT_TEMP_SERIES_THAT_THE_MESSAGE_IS_PART_OF').'<br />
[simagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_SERIES_IMAGE').'<br />
[simagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_SERIES_IMAGE').'<br />
[teacher] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_FOR_THIS_MESSAGE').'<br />
[timagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_TEACHER_IMAGE').'<br />
[timagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_TEACHER_IMAGE').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_THAT_THE_MESSAGE_IS_PART_OF').'<br />
[mimagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_MINISTRY_IMAGE').'<br />
[mimagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_MINISTRY_IMAGE').'<br />
[duration] = '.JText::_('COM_PREACHIT_TEMP_DURATION_OF_THE_MESSAGE').'<br />
[tags] = '.JText::_('COM_PREACHIT_TEMP_TAGS').'<br />
[videolink] = '.JText::_('COM_PREACHIT_TEMP_VIDEOLINK').'<br />
[audiolink] = '.JText::_('COM_PREACHIT_TEMP_AUDIOLINK').'<br />
[textlink] = '.JText::_('COM_PREACHIT_TEMP_TEXTLINK').'<br />
[noteslink] = '.JText::_('COM_PREACHIT_TEMPLATE_CUSTOM_NOTESLINK').'<br />
[slideslink] = '.JText::_('COM_PREACHIT_TEMP_SLIDESLINK').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK').'<br />
[downloadvideo] = '.JText::_('COM_PREACHIT_TEMP_DOWNVID').'<br />
[downloadaudio] = '.JText::_('COM_PREACHIT_TEMP_DOWNAUD').'<br />
[purchasevid] = '.JText::_('COM_PREACHIT_TEMP_PURVID').'<br />
[purchaseaud] = '.JText::_('COM_PREACHIT_TEMP_PURAUD').'<br />
[amlink] = '.JText::_('COM_PREACHIT_TEMP_ASMEDIA').'<br />
[audiofs] = '.JText::_('COM_PREACHIT_TEMP_AUDIOFS').'<br />
[videofs] = '.JText::_('COM_PREACHIT_TEMP_VIDEOFS').'<br />
[notesfs] = '.JText::_('COM_PREACHIT_TEMP_NOTESFS').'<br />
[slidesfs] = '.JText::_('COM_PREACHIT_TEMP_SLIDESFS').'<br />
[share] = '.JText::_('COM_PREACHIT_TEMP_SOCIAL_BOOK_MARK_LINK').'<br />
[hits] = '.JText::_('COM_PREACHIT_TEMP_HITS').'<br />
[downloads] = '.JText::_('COM_PREACHIT_TEMP_DOWNLOADS').'<br />
[commentno] = '. JText::_('COM_PREACHIT_TEMP_MESSAGE_COMMENTNO').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for media page temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function mediatemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[date] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_DATE').'<br />
[name] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_TITLE').'<br />
[video] = '. JText::_('COM_PREACHIT_TEMP_VIDEO').'<br />
[audio] = '.JText::_('COM_PREACHIT_TEMP_AUDIO').'<br />
[text] = '. JText::_('COM_PREACHIT_TEMP_TEXT').'<br />
[description] ='.JText::_('COM_PREACHIT_TEMP_MESSAGE_DESCRIPTION').'<br />
[scripture] ='.JText::_('COM_PREACHIT_TEMP_MAIN_SCRIPTURE_REFERENCE').'<br />
[scripture2] ='.JText::_('COM_PREACHIT_TEMP_SECONDARY_SCRIPTURE_REFERENCE_PRECEDED').'<br />
[scripture2noand] ='.JText::_('COM_PREACHIT_TEMP_SECONDARY_SCRIPTURE_REFERENCE_NOT_PRECEDED').'<br />
[imagesm] = '. JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGESM').'<br />
[imagemed] = '.JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGEMED').'<br />
[imagelrg] = '.JText::_('COM_PREACHIT_TEMPLATES_CUSTOM_IMAGELRG').'<br />
[series] = '.JText::_('COM_PREACHIT_TEMP_SERIES_THAT_THE_MESSAGE_IS_PART_OF').'<br />
[simagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_SERIES_IMAGE').'<br />
[simagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_SERIES_IMAGE').'<br />
[seriesdescription] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DESCRIPTION').'<br />
[teacher] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_FOR_THIS_MESSAGE').'<br />
[timagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_TEACHER_IMAGE').'<br />
[timagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_TEACHER_IMAGE').'<br />
[teacherdescription] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_DESCRIPTION').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_THAT_THE_MESSAGE_IS_PART_OF').'<br />
[mimagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_MINISTRY_IMAGE').'<br />
[mimagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_MINISTRY_IMAGE').'<br />
[duration] = '.JText::_('COM_PREACHIT_TEMP_DURATION_OF_THE_MESSAGE').'<br />
[tags] = '.JText::_('COM_PREACHIT_TEMP_TAGS').'<br />
[videolink] = '.JText::_('COM_PREACHIT_TEMP_VIDEOLINK').'<br />
[audiolink] = '.JText::_('COM_PREACHIT_TEMP_AUDIOLINK').'<br />
[textlink] = '.JText::_('COM_PREACHIT_TEMP_TEXTLINK').'<br />
[noteslink] = '.JText::_('COM_PREACHIT_TEMPLATE_CUSTOM_NOTESLINK').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK').'<br />
[downloadvideo] = '.JText::_('COM_PREACHIT_TEMP_DOWNVID').'<br />
[downloadaudio] = '.JText::_('COM_PREACHIT_TEMP_DOWNAUD').'<br />
[purchasevid] = '.JText::_('COM_PREACHIT_TEMP_PURVID').'<br />
[purchaseaud] = '.JText::_('COM_PREACHIT_TEMP_PURAUD').'<br />
[audiofs] = '.JText::_('COM_PREACHIT_TEMP_AUDIOFS').'<br />
[videofs] = '.JText::_('COM_PREACHIT_TEMP_VIDEOFS').'<br />
[notesfs] = '.JText::_('COM_PREACHIT_TEMP_NOTESFS').'<br />
[amlink] = '.JText::_('COM_PREACHIT_TEMP_ASMEDIA').'<br />
[share] = '.JText::_('COM_PREACHIT_TEMP_SOCIAL_BOOK_MARK_LINK').'<br />
[commentno] = '. JText::_('COM_PREACHIT_TEMP_MESSAGE_COMMENTNO').'<br />
[backlink] = '.JText::_('COM_PREACHIT_TEMP_LINK_BACK_TO_MESSAGE_LIST').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for series list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function sltemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[series] = '.JText::_('COM_PREACHIT_TEMP_SERIES_NAME').'<br />
[simagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_SERIES_IMAGE').'<br />
[simagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_SERIES_IMAGE').'<br />
[seriesdescription] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DESCRIPTION').'<br />
[daterange] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DATERANGE').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_SERIES_IS_ASSOCIATED_WITH').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK_SERIES').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for series header temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function svheadtemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[series] = '.JText::_('COM_PREACHIT_TEMP_SERIES_NAME').'<br />
[simagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_SERIES_IMAGE').'<br />
[simagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_SERIES_IMAGE').'<br />
[seriesdescription] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DESCRIPTION').'<br />
[daterange] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DATERANGE').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_SERIES_IS_ASSOCIATED_WITH').'<br />
[video] = '.JText::_('COM_PREACHIT_TEMP_CUSTOM_DEF_SERIES_VIDEO').'<br />
[backlink] = '.JText::_('COM_PREACHIT_TEMP_LINK_BACK_TO_SERIES_LIST').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK_SERIES').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for teacher list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function tltemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[teacher] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_NAME').'<br />
[role] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_ROLE').'<br />
[timagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_TEACHER_IMAGE').'<br />
[timagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_TEACHER_IMAGE').'<br />
[teacherdescription] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_DESCRIPTION').'<br />
[email] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_E_MAIL').'<br />
[web] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_WEBSITE').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK_TEACHER').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for teacher header temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function tvheadtemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[teacher] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_NAME').'<br />
[role] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_ROLE').'<br />
[timagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_TEACHER_IMAGE').'<br />
[timagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_TEACHER_IMAGE').'<br />
[teacherdescription] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_DESCRIPTION').'<br />
[email] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_E_MAIL').'<br />
[web] = '.JText::_('COM_PREACHIT_TEMP_TEACHER_WEBSITE').'<br />
[backlink] = '.JText::_('COM_PREACHIT_TEMP_LINK_BACK_TO_TEACER_LIST').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK_TEACHER').'">'.$image.'</span>';

return $tip;
}
/**
     * Method for tooltip for minsitry list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function minltemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_NAME').'<br />
[mimagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_MINISTRY_IMAGE').'<br />
[mimagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_MINISTRY_IMAGE').'<br />
[ministrydescription] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_DESCRIPTION').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for ministry header temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function minvheadtemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[ministry] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_NAME').'<br />
[mimagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_MINISTRY_IMAGE').'<br />
[mimagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_MINISTRY_IMAGE').'<br />
[ministrydescription] = '.JText::_('COM_PREACHIT_TEMP_MINISTRY_DESCRIPTION').'<br />
[backlink] = '.JText::_('COM_PREACHIT_TEMP_LINK_BACK_TO_MINISTRY_LIST').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for minsitry series list temp code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function minsertemp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[series] = '.JText::_('COM_PREACHIT_TEMP_SERIES_NAME').'<br />
[simagesm] = '.JText::_('COM_PREACHIT_TEMP_SMALL_SERIES_IMAGE').'<br />
[simagelrg] = '.JText::_('COM_PREACHIT_TEMP_LARGE_SERIES_IMAGE').'<br />
[seriesdescription] = '.JText::_('COM_PREACHIT_TEMP_SERIES_DESCRIPTION').'<br />
[editlink] = '.JText::_('COM_PREACHIT_TEMP_EDITLINK_SERIES').'">'.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for upload folder
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function uploadfolder($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
. JText::_('COM_PREACHIT_ADMIN_TIPS_UPLOADFOLDER').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for puttin extension message
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function putext($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_PUTEXT')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for video folder
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function vidfolder($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_VIDFOLDER').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for video type
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function vidtype($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_ADMIN_TIPS_VIDEOLINK_1').'
	<br />'.JText::_('COM_PREACHIT_ADMIN_TIPS_VIDEOLINK_2').'
	<br />'.JText::_('COM_PREACHIT_ADMIN_TIPS_VIDEOLINK_3').'
	<br />'.JText::_('COM_PREACHIT_ADMIN_TIPS_VIDEOLINK_4').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for put extension on image
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function putextimg($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_PUTEXTIMG')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for upload image
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function uploadimage($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_UPLOADIMAGE')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for mediaplayer code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function mediaplayerdef($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[playerurl] = '.JText::_('COM_PREACHIT_CUST_PLAYERURL').'<br />
[fileurl] = '.JText::_('COM_PREACHIT_CUST_FILEURL').'<br />
[fileid] = '.JText::_('COM_PREACHIT_CUST_FILEID').'<br />
[root] = '.JText::_('COM_PREACHIT_CUST_ROOT').'<br />
[skin] = '.JText::_('COM_PREACHIT_CUST_SKIN').'<br />
[height] = '.JText::_('COM_PREACHIT_CUST_HEIGHT').'<br />
[width] = '.JText::_('COM_PREACHIT_CUST_WIDTH').'<br />
[unique_id] = '.JText::_('COM_PREACHIT_MEDIAPLAYER_CUSTOMISE_UNIQUE_ID').'<br />
[thumbnail] = '.JText::_('COM_PREACHIT_MEDIAPLAYER_CUSTOMISE_THUMBNAIL').'<br />
{ccconsent}{/ccconsent} = '.JText::_('LIB_TEWEB_CCCONSENT_TAGS').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for media player script
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function mediaplayerscript($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_ADMIN_TIPS_MEDIA_PLAYER_SCRIPT').'<br />
{ccconsent}{/ccconsent} = '.JText::_('LIB_TEWEB_CCCONSENT_TAGS').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for server
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function server($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_SERVER')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for folder
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function folder($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_FOLDER')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for podcast menu item
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function podmenuitem($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_PODMENUITEM')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for podcast filename
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function podfilename($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_PODFILENAME')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for filesize
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function filesize($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_FILESIZE')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for book display name
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function bkdispname($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_BKDISPNAME')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for book name
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function bkname($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_BKNAME')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for book short name
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function bkshort($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_BKSHORT')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for no http
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function nohttp($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_NO_HTTP')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for podcast description
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function poddescription($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_DESCRIPTION_MAX')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for separate by comma
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function separate($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_SEPARATE')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for language
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function lang($admin = 1)
{
	
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_ADMIN_TIPS_LANG')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for backup
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function backup($admin = 1)
{
    
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_BCKADMIN_BACKUP_DESC')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for restore
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function restore($admin = 1)
{
    
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'
.JText::_('COM_PREACHIT_BCKADMIN_RESTORE_DESC')
.'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for share code
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function sharedef($admin = 1)
{
    
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_TEMP_KEY').'<br />
[sharedescription] = '.JText::_('COM_PREACHIT_CUST_SHARE_DESC').'<br />
[pagetitle] = '.JText::_('COM_PREACHIT_CUST_SHARE_TITLE').'<br />
[shareurl] = '.JText::_('COM_PREACHIT_CUST_SHARE_URL').'<br />
[sharetext] = '.JText::_('COM_PREACHIT_CUST_SHARE_TEXT').'<br />
{ccconsent}{/ccconsent} = '.JText::_('LIB_TEWEB_CCCONSENT_TAGS').'">'
.$image.'</span>';

return $tip;
}

/**
     * Method for tooltip for share script
     * @param boolean sets whether admin or site area
     * @return   string
     */  

function sharescript($admin = 1)
{
    
$image = PIHelpertooltips::image($admin);

$tip = '<span class="hasTip" title="'.JText::_('COM_PREACHIT_ADMIN_TIPS_SHARE_SCRIPT').'<br />
{ccconsent}{/ccconsent} = '.JText::_('LIB_TEWEB_CCCONSENT_TAGS').'">'
.$image.'</span>';

return $tip;
}

}
?>