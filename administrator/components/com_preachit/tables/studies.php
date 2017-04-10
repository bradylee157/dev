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
class TableStudies extends JTable
{
var $id = null;
var $study_date = null;
var $study_name = null;
var $study_alias = null;
var $study_description = null;
var $study_book = null;
var $ref_ch_beg = null;
var $ref_ch_end = null;
var $ref_vs_beg = null;
var $ref_vs_end = null;
var $study_book2 = null;
var $ref_ch_beg2 = null;
var $ref_ch_end2 = null;
var $ref_vs_beg2 = null;
var $ref_vs_end2 = null;
var $series = null;
var $ministry = null;
var $dur_hrs = null;
var $dur_mins = null;
var $dur_secs = null;
var $video = null;
var $video_type = null;
var $video_link = null;
var $video_download = null;
var $audio = null;
var $audio_type = null;
var $audio_link = null;
var $audio_download = 1;
var $published = 1;
var $comments = null;
var $study_text = null;
var $hits = null;
var $teacher = null;
var $audio_folder = null;
var $video_folder = null;
var $podcast_audio = null;
var $podcast_video = null;
var $text = 0;
var $asmedia = null;
var $studylist = null;
var $downloads = null;
var $publish_up = null;
var $publish_down = null;
var $image_folder = null;
var $image_foldermed = null;
var $image_folderlrg = null;
var $imagesm = null;
var $imagemed = null;
var $imagelrg = null;
var $notes_folder = null;
var $notes_link = null;
var $notes = null;
var $add_downloadvid = null;
var $downloadvid_folder = null;
var $downloadvid_link = null;
var $checked_out = null;
var $checked_out_time = null;
var $user = null;
var $access = null;
var $saccess = 0;
var $minaccess = 0;
var $audpurchase = null;
var $audpurchase_folder = null;
var $audpurchase_link = null;
var $vidpurchase = null;
var $vidpurchase_folder = null;
var $vidpurchase_link = null;
var $tags = null;
var $audiofs = null;
var $videofs = null;
var $advideofs = null;
var $notesfs = null;
var $language = null;
var $slides_folder = null;
var $slides_link = null;
var $slides = null;
var $slidesfs = null;
var $slides_type = null;
var $metakey = null;
var $metadesc = null;
var $podpublish_up = null;
var $podpublish_down = null;
var $audioprice = null;
var $videoprice = null;

	function __construct(& $db) {
		parent::__construct('#__pistudies', 'id', $db);
	}
}
