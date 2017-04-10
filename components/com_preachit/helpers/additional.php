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
jimport('teweb.details.standard');
jimport('teweb.checks.standard');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/addsettings.php');

class PIHelperadditional extends PIHelperaddsettings{

/**
	 * Method to build share html
	 *
	 * @param	int $id The id for the message.
	 * @param	string $name The name for the message.
	 * @param	string	$description	The description for the message.
	 * @param	bolean	$video	Whether this message has a video link.
	 * @param	bolean	$audio	Whether this message has a audio link.
	 * @param	bolean	$type		Type of share request, whether it needs an additional url in the code.
	 * @param	int	$item 	Itemid for the link.
	 *
	 * @return	string
	 */

function sharecode($id, $slug, $name, $description, $video, $audio, $text, $type, $item)
{
$option = 'com_preachit';
$params = PIHelperadditional::getPIparams();
$sharecode = null;
	
if ($type == 1)
{
if (JURI::base(true))
{$base = str_replace(JURI::base(true).'/', '', JURI::base());}
else {$base = JURI::base();}
if ($video != 0 || $audio != 0 || $text != 0)
{
    $row->video = $video;
    $row->audio = $audio;
    $row->text = $text;
    $view = 'study';
    $sharelink = $base.JRoute::_('index.php?option=' . $option . '&id=' . $slug . '&view='.$view.'&Itemid='.$item);
}
else 
{
    $uri=& JFactory::getURI();
    $sharelink = $uri->toString();
}

if ($sharelink)
{$sharelink = str_replace("//","/", $sharelink );
$sharelink = str_replace("http:/","http://", $sharelink );}
}
else {
    $uri=& JFactory::getURI();
    $sharelink = $uri->toString();}

if ($params->get('sharecode', ''))
{
    $shareoptions = $params->get('sharecode', '');
    
    foreach ($shareoptions AS $shareoption)
    {
        if ($shareoption > 0) 
        {
            $code = null;
            $share = & JTable::getInstance('Share', 'Table');
            $share->load($shareoption);
            if ($share->published == 1)
            {
                if (Tewebcheck::checkccneeded('pibckadmin', 1) == 1)
                {
                    if (!Tewebcheck::checkccconsent('social'))
                    {  
                        $share->code = Tewebcheck::removeccconsent($share->code, true);
                        $share->script = Tewebcheck::removeccconsent($share->script, true);
                    }
                }
                $share->code = Tewebcheck::removeccconsent($share->code, false);
                $share->script = Tewebcheck::removeccconsent($share->script, false);
                $code = $share->code;
                $code = str_replace('[sharedescription]', htmlspecialchars($description), $code);
                $code = str_replace('[pagetitle]', htmlspecialchars($name), $code);
                $code = str_replace('[shareurl]', $sharelink, $code);
                $code = str_replace('[sharetext]', JText::_('COM_PREACHIT_SHARE'), $code);
                $sharecode .= $code;
                // load script if necessary
                $script = $share->script;
                if ($script)
                {
                    $document =& JFactory::getDocument();
                    $document->addScript($script);
                }
                
            }
        }
        
    }
    if ($sharecode != null)
    {
        $sharecode = $sharecode;
    }
}
return $sharecode;
}

/**
	 * Method to get powered link
	 *
	 * @return	string
	 */

function powered()
{
$params = PIHelperadditional::getPIparams();
$willpower = $params->get('powered_by', '1');
if ($willpower == '0')
{$powered = '';}
else
{ 
$powered = Tewebdetails::powered();
}
return $powered;
}

/**
     * Method to build back button to js and no-js browsers
     * @param string $text backlink button text
     * @return    string
     */
function getbacklink($text)
{
    $backlink = '<div class="backlink"><a href="previous.html" onClick="history.back();return false;">'.$text.'</a></div>';
    return $backlink;
}


/**
	 * Method to get pagination html
	 *
	 * @return	string
	 */

function pagination($ajax = '')
{
$pagination = Tewebdetails::pagination($ajax, 'piajaxpage');
return $pagination;
}

/**
	 * Method to load javascript for squeezebox modal
	 *
	 * @return	bolean
	 */
function loadsqueeze()
{
$document =& JFactory::getDocument();
$document->addScript('libraries/teweb/scripts/modal/tesqueeze.js');
return true;	
}

function resizescript($width, $height)
{
echo '<script>window.resizeTo('.$width.', '.$height.');</script>';
}

/**
     * Method to load css override for the template
     *
     * @return    bolean
     */
function loadtempcssoverride()
{
$id = PIHelperadditional::templateid();
$db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('cssoverride')."
    FROM ".$db->nameQuote('#__pitemplate')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";             
    $db->setQuery($query);
    $style = $db->loadResult();
    $query = "SELECT ".$db->nameQuote('client_id')."
    FROM ".$db->nameQuote('#__pitemplate')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";             
    $db->setQuery($query);
    $client = $db->loadResult();
if ($style != '' && $client > 0)
{                           
    echo '<style>'.$style.'</style>';
}
return true;    
}


/**
     * Method to enter 2 js functions for running ajax refresh - need here because needs JURI ROOT
     *
     * @return    string
     */
function getajaxjs()
{
    $js = 'function piajaxpage(href) {
    var start = getParameterByName(\'start\', href);
    if (start)
    {var addurl = \'&start=\'+start;}
    else {
        var limitstart = getParameterByName(\'limitstart\', href);
        if (limitstart)
        {var addurl = \'&limitstart=\'+limitstart;}
        else {addurl = \'&limitstart=0\';}
    }
    var url = \''.JURI::ROOT().'index.php?option=com_preachit&view=studylist\'+addurl;
    pirefresh(url);
                        
    return false;
    }

    function pifajaxbuildurl()
    {
        var url = \''.JURI::ROOT().'index.php?option=com_preachit&view=studylist\';
        pirefresh(url);
                        
        return false;
    }';
    return $js;
}

/**
     * Method to add mediaplayer code to a page and import js if needed
     *
     * @param  array $mediaplayer mediaplayer array built in mediaplayer helper and part of message array
     * @return    boolean
     */
function showmediaplayer($mediaplayer)
{
    if ($mediaplayer)
    {
        $document =& JFactory::getDocument();
        echo $mediaplayer->code; 
        if ($mediaplayer->script && $mediaplayer->script != '')
        {
            $document->addScript($mediaplayer->script);
        } 
    }
    return;
}

/**
     * Method to add mediaplayer code to a plugin page and import js if needed
     *
     * @param  array $mediaplayer mediaplayer array built in mediaplayer helper and part of message array
     * @return    boolean
     */
function showpluginmediaplayer($mediaplayer)
{
    if ($mediaplayer)
    {
        $document =& JFactory::getDocument();
        if ($mediaplayer->script && $mediaplayer->script != '')
        {
                $document->addScript($mediaplayer->script);
        } 
        return $mediaplayer->code; ;
    }
    else {return null;}
}

}
?>