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
jimport('teweb.file.urlbuilder');
jimport('teweb.checks.standard');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');

class PIHelpermediaplayer{
    
/**
     * Method to build mediaplayer code
     * @param int $id mediaplayer record if
     * @param string $fileid file entry in form
     * @param int $folderid id for the folder
     * @param string $type type of mediaplyer
     * @param int $mesid id of message
     * @param int $sid id of series
     * @param array $study study or series details
     * @params int $plgwidth width override
     * @params int $plgheight height override
     * @return   string
     */   
    
public function mediaplayer($id, $fileid, $folderid, $type = 'video', $mesid, $sid, $study, $plgwidth = null, $plgheight = null)
{
$params = PIHelperadditional::getPIparams();
$mp =& JTable::getInstance('Mediaplayers', 'Table');
$mp->load($id);
$db =& JFactory::getDBO();
$mep = false;
$player = false;

//collect details

$fileurl = Tewebbuildurl::geturl($fileid, $folderid, 'pifilepath');
$playerurl = $mp->playerurl;
$root = JURI::base();
if ($type == 'audio')
{$width = $params->get('audioplayer_width', '500');
$height = $params->get('audioplayer_height', '20');
$skin = $params->get('audioskin', '');
if (trim($study->audio_link) != null)
{$mep = true;}}
if ($type == 'video')
{$width = $params->get('videoplayer_width', '400');
$height = $params->get('videoplayer_height', '300');
$skin = $params->get('videoskin', '');
if (trim($study->video_link) != null)
{$mep = true;}}
if ($type == 'series')
{$height = PIHelpermediaplayer::getheight($sid);
$width = PIHelpermediaplayer::getwidth($sid);
$skin = $params->get('videoskin', '');
if (trim($album->videolink) != null)
{$mep = true;}}
if ($type == 'pluginaudio')
{$height = $plgheight;
$width = $plgwidth;
$skin = $params->get('audioskin', '');
if (trim($study->audio_link) != null)
{$mep = true;}}
if ($type == 'pluginvideo')
{$height = $plgheight;
$width = $plgwidth;
$skin = $params->get('videoskin', '');
if (trim($study->video_link) != null)
{$mep = true;}}

if (!$mep)
{return $player;}

$skinurl = JURI::base() . 'components/com_preachit/assets/mediaplayers/jwskins/' . $skin;

$html5only = Tewebcheck::checkhtml5();
$html5 = $mp->html5;

if ($html5only && $html5 == 1 )
{
 $mediaplayer = PIHelpermediaplayer::gethtml5code($fileurl, $width, $height, $type);
 $player->script = '';
}
else {
    
// run ccconsent check on the code

if (Tewebcheck::checkccneeded('pibckadmin', 1) == 1)
{
    if (!Tewebcheck::checkccconsent('analytics'))
    {  
        $mp->playercode = Tewebcheck::removeccconsent($mp->playercode, true);
        $mp->playerscript = Tewebcheck::removeccconsent($mp->playerscript, true);
    }
}
$mp->playercode = Tewebcheck::removeccconsent($mp->playercode, false);
$mp->playerscript = Tewebcheck::removeccconsent($mp->playerscript, false);

// load any javascript and get mp code

$player->script = $mp->playerscript;
$mediaplayer = $mp->playercode;

//get the 2 pictures that can be used to thumbnails

if ($mp->image == 1 && $mesid)
{
    $study =& JTable::getInstance('Studies', 'Table');
    $study->load($mesid);
    $image = Tewebbuildurl::geturl($study->imagelrg, $study->image_folderlrg, 'pifilepath');
}
elseif ($mp->image == 2 && $mesid)
{
    $study =& JTable::getInstance('Studies', 'Table');
    $study->load($mesid);
    $series =& JTable::getInstance('Series', 'Table');
    $series->load($study->series);
    $image = Tewebbuildurl::geturl($series->series_image_lrg, $series->image_folderlrg, 'pifilepath');
}
elseif ($sid && $mp->image > 0)
{
    $series =& JTable::getInstance('Series', 'Table');
    $series->load($sid);
    $image = Tewebbuildurl::geturl($series->series_image_lrg, $series->image_folderlrg, 'pifilepath');
}
else {$image = null;}

if ($mesid != null)
{$unique_id = $mesid.$type;}
elseif ($sid != null)
{$unique_id = $sid.$type;}
else {$unique_id = null;}

//personalise the code

$mediaplayer  = str_replace("[height]",$height, $mediaplayer );
$mediaplayer  = str_replace("[width]",$width, $mediaplayer );
$mediaplayer  = str_replace("[fileid]",$fileid, $mediaplayer );
$mediaplayer  = str_replace("[fileurl]",$fileurl, $mediaplayer );
$mediaplayer  = str_replace("[playerurl]",$playerurl, $mediaplayer );
$mediaplayer  = str_replace("[root]",$root, $mediaplayer );
$mediaplayer  = str_replace("[skin]",$skinurl, $mediaplayer );
$mediaplayer = str_replace("[thumbnail]",$image, $mediaplayer );
$mediaplayer = str_replace("[unique_id]",$unique_id, $mediaplayer );
}

if ($mp->runplugins)
{
    jimport('teweb.effects.standard');
    $mediaplayer = Tewebeffects::runcontentplugins('onContentPrepare', 'com_preachit.mediaplayer', $mediaplayer, $params);
}

$player->code = $mediaplayer;
return $player;

}

/**
     * Method to get heigth of series video
     * @param int $id series id
     * @return   int
     */   

private function getheight($id)
{
$db =& JFactory::getDBO();

$query = "SELECT ".$db->nameQuote('vheight')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
$db->setQuery($query);

$height = $db->loadResult();

return $height;
	
}

/**
     * Method to get width of series video
     * @param int $id series id
     * @return   int
     */   

private function getwidth($id)
{
$db =& JFactory::getDBO();

$query = "SELECT ".$db->nameQuote('vwidth')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
$db->setQuery($query);

$width = $db->loadResult();

return $width;
	
}

/**
     * Method to get html5 mediaplayer code
     * @param string $fileurl media file url
     * @params int $width mediaplayer width
     * @params int $height mediaplayer height
     * @params string $type media type
     * @return   string
     */   

private function gethtml5code($fileurl, $width, $height, $type)
{
	$mediaplayer = '<video id="player-div" class="localaudioplayer" src="'.$fileurl.'" width='.$width.' height='.$height.' controls></video>';
	
	return $mediaplayer;
}

}
?>