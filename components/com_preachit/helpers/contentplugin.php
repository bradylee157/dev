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
JHTML::_( 'behavior.mootools' );
JHTML::_('behavior.modal');
jimport('teweb.file.functions');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
PIHelperadditional::loadsqueeze();
class PIHelperplugin{

/**
     * Method to get data and form html for a list item in the content plugin
     *
     * @param array $row message deatils
     * @param array $pluginParams array containing the plugin parameters
     * @return   string
     */      

function viewlist(&$row, &$pluginParams)
{
$html = null;
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');
$params = PIHelperadditional::getPIparams();
$message = PIHelperinfobuilder::messageinfo($row, $params, 0, false, $pluginParams);

// get default template

$temp = PIHelperadditional::template();
$document->addStyleSheet('components/com_preachit/templates/'.$temp.'/css/preachit.css');
// check file exists
$file = JPATH_SITE.DIRECTORY_SEPARATOR.'components/com_preachit/templates/'.$temp.'/plugin/pluginhtml.php';
if (Tewebfile::checkfile($file, 1))
{
    require_once($file);
    $html = PIpluginhtml::getlisthtml($message, $params, $pluginParams);
}

return $html;
}

/**
     * Method to get data and form html for a video item in the content plugin
     *
     * @param array $row message deatils
     * @param array $pluginParams array containing the plugin parameters
     * @param int $vw media width
     * @param int $vh media height
     * @return   string
     */  
    
function viewvideo(&$row, &$pluginParams, $vw, $vh)
{
$html = null;
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');
$params = PIHelperadditional::getPIparams();
$message = PIHelperinfobuilder::messageinfo($row, $params, 0, false, $pluginParams, $vw, $vh);
if ($row->audio_type > 0)
{
$aplayer = $row->audio_type;}
else {$aplayer = 6;}
$media = PIHelpermediaplayer::mediaplayer($row->video_type, $row->video_link, $row->video_folder, 'pluginvideo', $row->id, '', $row, $vw, $vh); 

// get default template

$temp = PIHelperadditional::template();
$document->addStyleSheet('components/com_preachit/templates/'.$temp.'/css/preachit.css');
// check file exists
$file = JPATH_SITE.DIRECTORY_SEPARATOR.'components/com_preachit/templates/'.$temp.'/plugin/pluginhtml.php';
if (Tewebfile::checkfile($file, 1))
{
    require_once($file);
    $html = PIpluginhtml::getvideohtml($message, $media, $params, $pluginParams);
}

return $html;
}

/**
     * Method to get data and form html for a audio item in the content plugin
     *
     * @param array $row message deatils
     * @param array $pluginParams array containing the plugin parameters
     * @param int $aw media width
     * @param int $ah media height
     * @return   string
     */  
 
function viewaudio(&$row, &$pluginParams, $aw, $ah)
{
$html = null;
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');
$params = PIHelperadditional::getPIparams();
$message = PIHelperinfobuilder::messageinfo($row, $params, 0, false, $pluginParams, $aw, $ah);
if ($row->audio_type > 0)
{
$aplayer = $row->audio_type;}
else {$aplayer = 6;}
$media = PIHelpermediaplayer::mediaplayer($aplayer, $row->audio_link, $row->audio_folder, 'pluginaudio', $row->id, '', $row, $aw, $ah); 

// get default template

$temp = PIHelperadditional::template();
$document->addStyleSheet('components/com_preachit/templates/'.$temp.'/css/preachit.css');
// check file exists
$file = JPATH_SITE.DIRECTORY_SEPARATOR.'components/com_preachit/templates/'.$temp.'/plugin/pluginhtml.php';
if (Tewebfile::checkfile($file, 1))
{
    require_once($file);
    $html = PIpluginhtml::getaudiohtml($message, $media, $params, $pluginParams);
}

return $html;
}

}

?>