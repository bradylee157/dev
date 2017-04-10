<?php
/**
 * @Component - Preachit
 * @version 1.0.0 May, 2010
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class TablePiadmin extends JTable
{
var $id = null;
var $autopodcast = null;
var $droptables = null;
var $study_descriptioneditor = null;
var $studyedit_temp = null;
var $getupdate = null;
var $series = null;
var $ministry = null;
var $video = null;
var $video_type = null;
var $video_download = null;
var $audio = null;
var $audio_type = null;
var $audio_download = null;
var $comments = null;
var $text = null;
var $teacher = null;
var $audio_folder = null;
var $video_folder = null;
var $studylist = null;
var $powered = null;
var $image_folder = null;
var $image_foldermed = null;
var $image_folderlrg = null;
var $notes_folder = null;
var $notes = null;
var $add_downloadvid = null;
var $downloadvid_folder = null;
var $uploadtype = null;
var $checkin = null;
var $access = null;
var $audpurchase = null;
var $audpurchase_folder = null;
var $vidpurchase = null;
var $vidpurchase_folder = null;
var $mfhide = null;
var $sfhide = null;
var $tfhide = null;
var $mfupsel = null;
var $tfupsel = null;
var $sfupsel = null;
var $msimsmw = null;
var $msimsmh = null;
var $msimmedw = null;
var $msimmedh = null;
var $msimlrgw = null;
var $msimlrgh = null;
var $teaimsmw = null;
var $teaimsmh = null;
var $teaimmedw = null;
var $teaimmedh = null;
var $teaimlrgw = null;
var $teaimlrgh = null;
var $serimsmw = null;
var $serimsmh = null;
var $serimmedw = null;
var $serimmedh = null;
var $serimlrgw = null;
var $serimlrgh = null;
var $minimsmw = null;
var $minimsmh = null;
var $minimmedw = null;
var $minimmedh = null;
var $minimlrgw = null;
var $minimlrgh = null;
var $imagequal = null;
var $imageresize = null;
var $language = null;
var $multilanguage = null;
var $prefixi = null;
var $prefixm = null;
var $upload_selector = null;
var $upload_folder = null;
var $slides_folder = null;
var $slides = null;
var $slides_type = null;
	function __construct(& $db) {
		parent::__construct('#__pibckadmin', 'id', $db);
	}
}
