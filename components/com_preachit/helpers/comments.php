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
jimport('teweb.messages.comments');

class PIHelpercomments{

/**
     * Method to get comments html - use in conjunction with the Te-comments plugin
     *
     * @param    int $id The message id.
     * @param    bolean $localcomment  determines whether comments are on for this message.
     * @param    unknown_type $params  Component parameters
     *
     * @return    string
     */
     
function getcomments($id, $localcomment, $params)
{
// get details
$commenttype = $params->get('display_comments', '0');
 $output = null;

//choose comments function

if ($localcomment == '1' && $commenttype == '1')
{
    $row =& JTable::getInstance('Studies', 'Table');
    $row->load($id);
    $option = 'com_preachit';
    $view = 'study';
    $row->slug = $row->id.':'.$row->study_alias;
    $row->alias = $row->study_alias;
    $app = JFactory::getApplication();
    $document       =& JFactory::getDocument();
    $pluginParams =& $app->getParams();
    $user             =& JFactory::getUser();
    
    // get details
    $catid = $row->series;
    $sectid = $row->ministry;
    $system = $pluginParams->get('picom', 'inbuilt');
    $catids = $pluginParams->get('tecomseries','');
    $sectids = $pluginParams->get('tecomministries','');
    $catall = $pluginParams->get('tecomseriessel', 0);
    $sectall = $pluginParams->get('tecomministrysel', 0);
    $tagmode        = $pluginParams->get('tagmode',0);
    $showcount      = $pluginParams->get('showcount',1);
    $account        = $pluginParams->get('id-account');
    $subdomain      = $pluginParams->get('d-subdomain');
    $devmode        = $pluginParams->get('d-devmode',0);
    $commenticon    = " ".$pluginParams->get('showicon','te-icon');
    $commentpage    = false;
    
    //get devmode for Disqus
    $devcode = "";
    if ($devmode == 1) $devcode = "var disqus_developer = \"1\";";
    
    // load css
    
    $document->addStyleSheet(JURI::base()."libraries/teweb/messages/css/tecomments.css");
    
    // build link
    $baseurl = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];
    if ($_SERVER['SERVER_PORT']!="80") $baseurl .= ":".$_SERVER['SERVER_PORT'];
    $path = JRoute::_('index.php?option='.$option.'&view='.$view.'&id='.$row->slug);
    $url = $baseurl.$path;
    
    // handle tag style
    if ($tagmode == 1) 
    {
        $postid = $row->slug.'_pi';  
    }
    else 
    {
        $postid = $row->alias.'_pi';    
    }
        
    
    //sepcial case for ID
    if ($system == "intensedebate") {
        $postid = str_replace(array("-",":"),array("_","_"),$postid);
    }
    
    // get array of series/album ids
    if ($catall == 0)
    {$categories[] = $catid;}
    elseif (is_array($catids)){
        $categories = $catids;
    } elseif ($catids==''){
        $categories[] = $catid;
    } else {
        $categories[] = $catids;
    }
    
    // get array of ministry ids
    if ($sectall == 0)
    {$sections[] = $sectid;}
    elseif (is_array($sectids)){
        $sections = $sectids;
    } elseif ($sectids==''){
        $sections[] = $sectid;
    } else {
        $sections[] = $sectids;
    }

        if( !( in_array($catid,$categories) && in_array($sectid,$sections))) {
           return;
        }
    
    // check to make sure commentcount should be shown
    if ($showcount==0) 
    {
        return;
    }
    
    if ($system == 'inbuilt')
    {$output = Tewebcomments::getteinbuilt($row, $option, $pluginParams);}
    if ($system == 'jcomment')
    {$output = Tewebcomments::gettejcomments($row, $option);}
    if ($system == 'jomcomment')
    {$output = Tewebcomments::gettejomcomments($row, $option);}
    if ($system == 'intensedebate')
    {$output = Tewebcomments::getteintensedebate($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage);}
    if ($system == 'disqus')
    {$output = Tewebcomments::gettedisqus($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage);}
    if ($system == 'facebook')
    {$output = Tewebcomments::gettefacebookcomments($row, $params, $option);}
    
    
    
}
	return $output;
}

/**
     * Method to get comments html - use in conjunction with the Te-comments plugin
     *
     * @param    array $row The message details array.
     * @param    bolean $localcomment  determines whether comments are on for this message.
     * @param    unknown_type $params  Component parameters
     *
     * @return    string
     */

function getcommentcount($row, $localcomment, $params)
{
// get details
$commenttype = $params->get('display_comments', '0');
$count = null;
$output = null;
//choose comments function

if ($localcomment == '1' && $commenttype == '1')
{
    $option = 'com_preachit';
    $view = 'study';
    $itemid         = JRequest::getInt('Itemid');
    $row->slug = $row->id.':'.$row->study_alias;
    $row->alias = $row->study_alias;
    $app = JFactory::getApplication();
    $document       =& JFactory::getDocument();
    $pluginParams =& $app->getParams();
    $user             =& JFactory::getUser();
    
    // get details
    $catid = $row->series;
    $sectid = $row->ministry;
    $system = $pluginParams->get('picom', 'inbuilt');
    $catids = $pluginParams->get('tecomseries','');
    $sectids = $pluginParams->get('tecomministries','');
    $catall = $pluginParams->get('tecomseriessel', 0);
    $sectall = $pluginParams->get('tecomministrysel', 0);
    $tagmode        = $pluginParams->get('tagmode',0);
    $showcount      = $pluginParams->get('showcount',1);
    $account        = $pluginParams->get('id-account');
    $subdomain      = $pluginParams->get('d-subdomain');
    $devmode        = $pluginParams->get('d-devmode',0);
    $commenticon    = " ".$pluginParams->get('showicon','te-icon');
    $commentpage    = false;
    
    //get devmode for Disqus
    $devcode = "";
    if ($devmode == 1) $devcode = "var disqus_developer = \"1\";";
    
    // load css
    
    $document->addStyleSheet(JURI::base()."libraries/teweb/messages/css/tecomments.css");
    
    // build link
    $baseurl = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];
    if ($_SERVER['SERVER_PORT']!="80") $baseurl .= ":".$_SERVER['SERVER_PORT'];
    $path = JRoute::_('index.php?option=com_preachit&view='.$view.'&id=' . $row->slug . '&Itemid='.$itemid);
    $url = $baseurl.$path;
    
    // handle tag style
    if ($tagmode == 1) 
    {
        $postid = $row->slug.'_pi';  
    }
    else 
    {
        $postid = $row->alias.'_pi';    
    }
        
    
    //sepcial case for ID
    if ($system == "intensedebate") {
        $postid = str_replace(array("-",":"),array("_","_"),$postid);
    }
    
    // get array of series/album ids
    if ($catall == 0)
    {$categories[] = $catid;}
    elseif (is_array($catids)){
        $categories = $catids;
    } elseif ($catids==''){
        $categories[] = $catid;
    } else {
        $categories[] = $catids;
    }
    
    // get array of ministry ids
    if ($sectall == 0)
    {$sections[] = $sectid;}
    elseif (is_array($sectids)){
        $sections = $sectids;
    } elseif ($sectids==''){
        $sections[] = $sectid;
    } else {
        $sections[] = $sectids;
    }

        if( !( in_array($catid,$categories) && in_array($sectid,$sections))) {
           return;
        }
    
    // check to make sure commentcount should be shown
    if ($showcount==0) 
    {
        return;
    }
    
    if ($system == 'inbuilt')
    {$output = Tewebcomments::getteinbuiltcount($row, $option, $path);}
    if ($system == 'jcomment')
    {$output = Tewebcomments::gettejcommentscount($row, $option, $path);}
    if ($system == 'jomcomment')
    {$output = Tewebcomments::gettejomcommentscount($row, $option, $path);}
    if ($system == 'intensedebate')
    {$output = Tewebcomments::getteintensedebatecount($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage);}
    if ($system == 'disqus')
    {$output = Tewebcomments::gettedisquscount($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage);}
    if ($system == 'facebook')
    {$output = Tewebcomments::gettefacebookcommentscount($row, $path, $option);}
}
    return $output;
}

}

?>