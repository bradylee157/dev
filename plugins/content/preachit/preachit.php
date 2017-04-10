<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentPreachit extends JPlugin {

 function plgContentPreachit( &$subject, $params )
        {
                parent::__construct( $subject, $params );
        }

// J 1.6

public function onContentPrepare($context, $article, $params, $limitstart)
  {
  if ($context != 'com_preachit.mediaplayer' && $context != 'com_preachit.study')
  {$html = $this->_processplugin($article, $params, $limitstart);}
  return true;
  }
 
// all versions

protected function _processplugin(&$row, &$params, $limitstart)
{
  $app = JFactory::getApplication();
  if (!$app->isSite())
  {return;}
  $plugin =& JPluginHelper::getPlugin('content', 'Preachit');
  $lang = & JFactory::getLanguage();
  $lang->load('com_preachit');
  $pluginParams = $this->params ;
  preg_match_all('/\{preachit (.*)\}/U', 
                       $row->text, $matches); 
  $aw =     $pluginParams->get('audioplayer_width', '500'); 
  $vw = $pluginParams->get('videoplayer_width', '400');
  $ah =     $pluginParams->get('audioplayer_height', '20');  
  $vh = $pluginParams->get('videoplayer_height', '300');                       
                       
  foreach( $matches[1] as $name )
  {
      $det = trim($name);
    $details = explode( ',', $det );  
    $no = count($details);    
    $id = $details[0];
    $view = $details[1];
    
    if ($no > 2)
    {
    if ($details[2])
    {$w = $details[2];
        $width = str_replace    (" ", "", $w);
        $aw = $width;
        $vw = $width;}
    
    if ($details[3])
    {$h = $details[3];
        $height = str_replace    (" ", "", $h);
        $ah = $height;
        $vh = $height;}
    }
        
    $view = str_replace    (" ", "", $view);
                                       
    $message = $this->_getMessageinfo($id);
    if (count($message) == 1)
    {$html = $this->_createHTML($message, $pluginParams, $view, $aw, $vw, $ah, $vh);}
    else {$html = null;}
    $row->text = str_replace("{preachit $name}", $html, $row->text);
  }
  return true;
}

/**
     * Method to get message info for message module
     * @param int $name id of the message
     * @return    array
     */

protected function _getMessageinfo ($name)
{
  $db =& JFactory::getDBO();
  $name = $db->getEscaped($name);
  $query = "SELECT * FROM #__pistudies WHERE id = '$name' AND published = 1";
  $db->setQuery($query);
  $message = $db->loadObject();
  return $message;
}

/**
     * Method to get html to insert in record
     * @param array $row message infor
     * $param unknown_type $pluginParams plugin parameters
     * $param string $view view to link to
     * $param int $aw width of the audio
     * $param int $vw width of the video
     * $param int $ah height of the audio
     * $param int $vh height of the video
     * @return    array
     */

protected function _createHTML (&$row, &$pluginParams, $view, $aw, $vw, $ah, $vh)
{
$html = null;
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/contentplugin.php');
//get the html from the view functions

if ($view == "list")
{
    $html = PIHelperplugin::viewlist($row, $pluginParams);
}

if ($view == "video")
{
    $html = PIHelperplugin::viewvideo($row, $pluginParams, $vw, $vh);
}

if ($view == "audio")
{
    $html = PIHelperplugin::viewaudio($row, $pluginParams, $aw, $ah);
}

  return $html;
}

}