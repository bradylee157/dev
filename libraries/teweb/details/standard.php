<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebdetails {

/**
	 * Method to get powered link
	 *
	 * @return	string
	 */

function powered()
{
$poweredlink = '<a href="http://te-webdesign.org.uk" alt="Te webdesign">truthengaged</a>';
$powered = '<div style="text-align: center; padding-top: 15px; font-size: 10px;">'.JText::_('LIB_TEWEB_POWERED_BY').' '.$poweredlink.'</div>';
return $powered;
}


/**
     * Method to get itemid for url
     * @param string $urlstring url string to search for
     * @return    string
     */

function getitemid($urlstring)
{
    $item = null;
    $db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__menu')."
    WHERE ".$db->nameQuote('link')." LIKE ".$db->Quote('%'.$db->getEscaped($urlstring, true).'%', false)." AND client_id = 0 AND access = 1;";
    $db->setQuery($query);
    $itemid = $db->loadResult();
    if (empty($itemid))
    {
        $query = "SELECT ".$db->nameQuote('id')."
        FROM ".$db->nameQuote('#__menu')."
        WHERE ".$db->nameQuote('link')." LIKE ".$db->Quote('%'.$db->getEscaped($urlstring, true).'%', false)." AND client_id = 0;";
        $db->setQuery($query);
        $itemid = $db->loadResult();
    }  
    if (empty($itemid))
    {  
        $itemid = JRequest::getVar('Itemid', '', 'GET', 'INT');
    }
    if ($itemid)
    {$item = '&Itemid='.$itemid;}
    return $item;
}

/**
     * Method to get max php upload from upload_max_filesize and post_max_size in php.ini
     *
     * @return    string
     */

function maxupload()
{
    $max = (int)get_cfg_var('upload_max_filesize');
    $post = (int)get_cfg_var('post_max_size'); 
    if ($post < $max)
    {$maxupload = get_cfg_var('post_max_size');}
    elseif ($max < $post)
    {$maxupload = get_cfg_var('upload_max_filesize');}
    else {$maxupload = get_cfg_var('upload_max_filesize');}
    return $maxupload;
}

/**
     * Method to get component parameters in administrator or in the site side
     * @param string $component name of the component without com_
     * @param boolean $nomenu allows you to get the core parameters on hte site side
     * @return    string
     */

function getparams($component, $nomenu = false)
{
    $app = JFactory::getApplication();
    if ($app->isSite() && !$nomenu)
    {$params =& $app->getParams();}
    else {jimport( 'joomla.html.parameter' );
        $component = JComponentHelper::getComponent( $component );
        $params = new JParameter( $component->params );}
    return $params;
}

/**
     * Method to get user name from user id
     * @param int $id id of the record
     * @return    array
     */   

function getuser($id)
{
    $db = JFactory::getDBO();
    $query = "
    SELECT ".$db->nameQuote('name')."
    FROM ".$db->nameQuote('#__users')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
     ";
     $db->setQuery($query);
     $user = $db->loadResult();
    
    return $user;
}

/**
     * Method to get pagination html
     *
     * @return    string
     */

function pagination($ajax = '', $function = null)
{
$pagination = '';
$pagclass = 'rt-pagination pagination';
if ($this->pagination->getPagesCounter())
{
    
if ($ajax)
{
    $pageno = str_replace('title="', 'onclick="'.$function.'(this.href); return false;" title="', $this->pagination->getPagesLinks());
}
else    {$pageno = $this->pagination->getPagesLinks();}
    
$pagination = '<div class="'.$pagclass.'">'
                    .$pageno
                    .$this->pagination->getPagesCounter()
                    .'</div>';
}        
    return $pagination;
}

/**
     * Method to load javascript for squeezebox modal
     *
     * @param string $host the site base url
     * @param string $component - component name without com_
     * @param string $controller controller name for url
     * $param string $task task name for url
     *
     * @return    string
     */

function uploadjs($host, $component, $controller, $task)
{
//when we send the files for upload, we have to tell Joomla our session, or we will get logged out 
$session = & JFactory::getSession();

$val = Tewebdetails::maxupload();
$val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
$valk = $val/1024;
$valm = $valk/1024;
$maxupload = $valm. ' MB';

$swfUploadHeadJs ='
var swfu;
 
window.onload = function()
{
 
var settings = 
{
        //this is the path to the flash file, you need to put your components name into it
        flash_url : "'.$host.'libraries/teweb/file/swfupload/swfupload.swf",
 
        //we can not put any vars into the url for complicated reasons, but we can put them into the post...
        upload_url: "'.$host.'index.php",
        post_params: {
                "option" : "'.$component.'",
               "controller" : "'.$controller.'",
                "task" : "'.$task.'",
                "'.$session->getName().'" : "'.$session->getId().'",
               "format" : "raw"
           },
        //you need to put the session and the "format raw" in there, the other ones are what you would normally put in the url
        file_size_limit : "'.$maxupload.'",
        //client side file checking is for usability only, you need to check server side for security
        file_types : "",
        file_types_description : "All Files",
        file_upload_limit : 100,
        file_queue_limit : 10,
        custom_settings : 
        {
                progressTarget : "fsUploadProgress",
                cancelButtonId : "btnCancel"
        },
        debug: false,
 
        // Button settings
        button_image_url: "'.$host.'libraries/teweb/file/swfupload/images/uploadbutton.png",
        button_width: "86",
        button_height: "33",
        button_placeholder_id: "spanButtonPlaceHolder",
        button_text: \'<span class="upbutton">'.JText::_('LIB_TEWEB_BUTTON_BROWSE').'</span>\',
        button_text_style: ".upbutton { font-size: 14px; margin-left: 15px;}",
        button_text_left_padding: 5,
        button_text_top_padding: 5,
 
        // The event handler functions are defined in handlers.js
        file_queued_handler : fileQueued,
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_start_handler : uploadStart,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,
        queue_complete_handler : queueComplete     // Queue plugin event
};
swfu = new SWFUpload(settings);
};
 
';
 
return $swfUploadHeadJs;
}

/**
     * Method to get date array between 2 date values
     *
     * @param    datetime $start start date
     * @param    datetime $finish finish date
     *
     * @return    array
     */   

function getdatearray($start, $finish)
{

    $dates = array();

    $fromDateTS = strtotime($start);
    $toDateTS = strtotime($finish);

    for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
    // use date() and $currentDateTS to format the dates in between
    $currentDateStr = date('Y-m-d',$currentDateTS);
    $dates[] = $currentDateStr;}
    
    return $dates;
}

/**
     * Method to get page title to display (J1.6 onwards)
     *
     * @param    array $params menu params that include the heading and title setting
     *
     * @return    string
     */ 

function pagetitle($params)
{
    $enttitle = $this->params->get('page_heading', '');
    $pgtitle = $this->params->get('page_title', '');
    if ($enttitle)
    {$pgheader = $enttitle;}
    else {$pgheader = $pgtitle;}
    return $pgheader;
}

/**
     * Method to get yes or no from boolean
     *
     * @param    boolean $yes 
     * @return    string
     */

function getyesno($yes)
{
    if ($yes == 1)
    {$yesno = JText::_('TEYES');}
    else {$yesno = JText::_('TENO');}
    return $yesno;
}

/**
     * Method to get state selector list
     *
     * @return    array
     */

function stateselector()
{
    $selector = array(
                array('value' => '5', 'text' => JTEXT::_('LIB_TEWEB_STATE_SELECT')),
                array('value' => '1', 'text' => JText::_('LIB_TEWEB_STATE_JPUBLISHED')),
                array('value' => '0', 'text' => JText::_('LIB_TEWEB_STATE_JUNPUBLISHED')),
                array('value' => '-2', 'text' => JText::_('LIB_TEWEB_STATE_JTRASH')),
                );
    return $selector;
}

/**
     * Method to get string from slug
     * @param $string $slug id and alias slug
     * @return    string
     */
function getslugstring($slug)
{
    $parts = explode(':', $slug);
    if (isset($parts[1]) && trim($parts[1]) != null)
    {
        $string = $parts[1];
    }
    else {$string = intval($slug);}
    return $string;
}

/**
     * Method to get slug from slug string
     * @param string $alias string to search for
     * @param string $dtable database table to search
     * @param string $column column to search default alias
     * @return    string
     */
function getslugid($string, $dtable, $column = 'alias')
{
    $string = str_replace(':', '-', $string);
    
    if (!is_numeric($string))
    {
        $db = JFactory::getDBO();
        $query = "
        SELECT ".$db->nameQuote('id')."
        FROM ".$db->nameQuote($dtable)."
        WHERE ".$db->nameQuote($column)." = ".$db->quote($string).";
        ";
        $db->setQuery($query);
        $id = $db->loadResult();
     
        $slug = $id.':'.$string;

    }
    else $slug = $string;
    return $slug;

}

}
?>