<?php

/**
 * Media Helper
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;
require_once (JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'biblestudy.images.class.php');

/**
 * Get Media
 * @param int $id
 * @return object
 */
function getMedia($id) {
    $database = JFactory::getDBO();

    $query_media = 'SELECT #__bsms_mediafiles.*,'
            . ' #__bsms_servers.id AS ssid, #__bsms_servers.server_path AS spath,'
            . ' #__bsms_folders.id AS fid, #__bsms_folders.folderpath AS fpath,'
            . ' #__bsms_media.id AS mid, #__bsms_media.media_image_path AS impath, #__bsms_media.media_image_name AS imname, #__bsms_media.path2 AS path2,'
            . ' #__bsms_media.media_alttext AS malttext,'
            . ' #__bsms_mimetype.id AS mtid, #__bsms_mimetype.mimetext'
            . ' FROM #__bsms_mediafiles'
            . ' LEFT JOIN #__bsms_media ON (#__bsms_media.id = #__bsms_mediafiles.media_image)'
            . ' LEFT JOIN #__bsms_servers ON (#__bsms_servers.id = #__bsms_mediafiles.server)'
            . ' LEFT JOIN #__bsms_folders ON (#__bsms_folders.id = #__bsms_mediafiles.path)'
            . ' LEFT JOIN #__bsms_mimetype ON (#__bsms_mimetype.id = #__bsms_mediafiles.mime_type)'
            . ' WHERE #__bsms_mediafiles.study_id = ' . $id . ' AND #__bsms_mediafiles.published = 1 ORDER BY ordering ASC, #__bsms_mediafiles.mime_type ASC';

    $database->setQuery($query_media);
    $media = $database->loadObjectList('id');

    return $media;
}

/**
 * Get Internal Player
 * @param object $media
 * @param object $params
 * @param object $admin_params
 * @return string
 */
function getInternalPlayer($media, $params, $admin_params) {

    $JView = new JView();
    $JView->loadHelper('image');
    $JView->loadHelper('filesize.php');
    $JView->loadHelper('filepath.php');
    $JView->loadHelper('duration.php');

    // Convert parameter fields to objects.
    $registry = new JRegistry;
    $registry->loadJSON($media->params);
    $itemparams = $registry;

    $Itemid = $params->get('detailstemplateid', 1);
    $images = new jbsImages();
    $image = $images->getMediaImage($media->path2, $media->impath);


    $idfield = '#__bsms_mediafiles.id';
    $filesize = getFilesize($media->size);
    $duration = getDuration($params, $row);
    $mimetype = $media->mimetext;
    $src = JURI::base() . $image->path;
    $height = $image->height;
    $width = $image->width;
    $ispath = 0;
    $mime = '';
    $path1 = getFilepath($media->id, $idfield, $mime);

    $player_width = $params->get('player_width', 290);
    $media1_link =
            '<script language="javascript" type="text/javascript" src="' . JURI::base() . 'media/com_biblestudy/player/jwplayer.js"></script>
		    <object type="application/x-shockwave-flash" data="' . JURI::base() . 'media/com_biblestudy/player/player.swf" id="audioplayer' . $row_count . '" height="24" width="' . $params->get('player_width', 290) . '">
		    <param name="movie" value="' . JURI::base() . 'media/com_biblestudy/player/player.swf" />
		    <param name="FlashVars" value="playerID=audioplayer' . $row_count . '&soundFile=' . $path1 . '" />
		    <param name="quality" value="high" />
		    <param name="menu" value="false" />
		    <param name="wmode" value="transparent" />
		    </object> ';

    return $media1_link;
}

/**
 * Get Download Link
 * @param object $media
 * @param object $params
 * @param object $admin_params
 * @return string
 */
function getDownloadLink($media, $params, $admin_params) {
    $path1 = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
    include_once($path1 . 'filesize.php');
    include_once($path1 . 'filepath.php');
    include_once($path1 . 'duration.php');
    $JView = new JView();
    $JView->loadHelper('image');

    // Convert parameter fields to objects.
    $registry = new JRegistry;
    $registry->loadJSON($media->params);
    $itemparams = $registry;
    $Itemid = $params->get('detailstemplateid', 1);
    $images = new jbsImages();
    $image = $images->getMediaImage($media->path2, $media->impath);


    $database = JFactory::getDBO();

    $database->setQuery('SELECT * FROM #__bsms_admin WHERE id = 1');
    $database->query();
    $admin = $database->loadObjectList();


    $d_image = ($admin[0]->params->default_download_image);
    $images = new jbsImages();
    $download_image = $images->getMediaImage($admin[0]->params->default_download_image, $media = NULL);

    $download_image = $download_tmp->path;

    $idfield = '#__bsms_mediafiles.id';
    $filesize = getFilesize($media->size);
    $duration = getDuration($params, $row);
    $mimetype = $media->mimetext;
    $src = JURI::base() . $image->path;
    $height = $image->height;
    $width = $image->width;
    $ispath = 0;
    $mime = '';
    $path1 = getFilepath($media->id, $idfield, $mime);

    $link_type = $media->link_type;
    if ($link_type > 0) {
        $width = $download_tmp->width;
        $height = $download_tmp->height;

        $out = '';
        if ($compat_mode == 0) {
            $out .='<a href="index.php?option=com_biblestudy&amp;id=' . $media->id . '&amp;view=sermons&amp;controller=sermons&amp;task=download">';
        } else {
            $out .='<a href="http://joomlabiblestudy.org/router.php?file=' . $media->spath . $media->fpath . $media->filename . '&amp;size=' . $media->size . '">';
        }

        $out .= '<img src="' . $d_path . '" alt="' . JText::_('JBS_MED_DOWNLOAD') . '" height="' . $height . '" width="' . $width . '" title="' . JText::_('JBS_MED_DOWNLOAD') . '" /></a>';

        return $out;
    }
}

/**
 * Get Media File
 * @param object $media
 * @param object $params
 * @param Object $admin_params
 * @return string
 */
function getMediaFile($media, $params, $admin_params) {

    $path1 = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
    include_once($path1 . 'filesize.php');
    include_once($path1 . 'filepath.php');
    include_once($path1 . 'duration.php');
    $JView = new JView();
    $JView->loadHelper('image');
    $images = new jbsImages();
    $image = $images->getMediaImage($media->path2, $media->impath);

    // Convert parameter fields to objects.
    $registry = new JRegistry;
    $registry->loadJSON($media->params);
    $itemparams = $registry;
    $Itemid = $params->get('detailstemplateid', 1);


    $database = JFactory::getDBO();

    $database->setQuery('SELECT * FROM #__bsms_admin WHERE id = 1');
    $database->query();
    $admin = $database->loadObjectList();


    $d_image = ($admin[0]->params->default_download_image);
    $images = new jbsImages();

    $download_image = $images->getMediaImage($admin[0]->params->default_download_image, $media = NULL);

    $download_image = $download_tmp->path;

    $idfield = '#__bsms_mediafiles.id';
    $filesize = getFilesize($media->size);
    $duration = getDuration($params, $row);
    $mimetype = $media->mimetext;
    $src = JURI::base() . $image->path;
    $height = $image->height;
    $width = $image->width;
    $ispath = 0;
    $mime = '';
    $path1 = getFilepath($media->id, $idfield, $mime);

    $media_link = '<div class="bsms_mediafile"><a href="' . $path1 . '" title="' . $media->malttext . ' - ' . $media->comment . ' ' . $duration . ' '
            . $filesize . '" target="' . $media->special . '"><img src="' . $d_path
            . '" alt="' . $media->malttext . ' - ' . $media->comment . ' - ' . $duration . ' ' . $filesize . '" width="' . $width
            . '" height="' . $height . '" border="0" /></a></div>';

    return $media_link;
}

/**
 * Get Type Icon
 * @param object $media
 * @param object $params
 * @param object $admin_params
 * @return string
 */
function getTypeIcon($media, $params, $admin_params) {

    $path1 = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
    include_once($path1 . 'filesize.php');
    include_once($path1 . 'filepath.php');
    include_once($path1 . 'duration.php');
    $JView = new JView();
    $JView->loadHelper('image');

    // Convert parameter fields to objects.
    $registry = new JRegistry;
    $registry->loadJSON($media->params);
    $itemparams = $registry;

    $Itemid = $params->get('detailstemplateid', 1);
    $images = new jbsImages();
    $image = $images->getMediaImage($media->path2, $media->impath);

    $idfield = '#__bsms_mediafiles.id';
    $filesize = getFilesize($media->size);
    $duration = getDuration($params, $row);
    $mimetype = $media->mimetext;
    $src = JURI::base() . $image->path;
    $height = $image->height;
    $width = $image->width;
    $ispath = 0;
    $mime = '';
    $path1 = getFilepath($media->id, $idfield, $mime);

    $media_link = '<img src="' . $src
            . '" alt="' . $media->malttext . ' - ' . $media->comment . ' - ' . $duration . ' ' . $filesize . '" width="' . $width
            . '" height="' . $height . '" border="0" />';

    return $media_link;
}

/**
 * Get PDF
 * @param objcet $row
 * @param object $params
 * @param object $admin_params
 * @return string
 */
function getPDF($row, $params, $admin_params) {
    //PDF View
    $url = 'index.php?option=com_biblestudy&amp;view=sermon&amp;id=' . $row->id . '&amp;format=pdf';
    $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
    $text = JHTML::_('image.site', 'pdf24.png', '/media/com_biblestudy/images/', NULL, NULL, JText::_('JBS_MED_PDF'), 'border=0');
    $attribs['title'] = JText::_('JBS_MED_PDF');
    $attribs['onclick'] = "window.open(this.href,'win2','" . $status . "'); return false;";
    $attribs['rel'] = 'nofollow';
    $link = JHTML::_('link', JRoute::_($url), $text, $attribs);

    return $link;
}

/**
 * Get Media For List
 * @param object $row
 * @param object $params
 * @param object $admin_params
 * @deprecated since version 7.0.4
 */
function getMediaForList($row, $params, $admin_params) {

}