<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
if  ($this->mode == 'listen')
    {
        echo $this->loadTemplate('audiopopup');
        //popup resize

        $height = $params->get('popupaud_height', '650');
        $width = $params->get('popupaud_width', '600');

        PIHelperadditional::resizescript($width, $height);
    }
elseif ($this->mode == 'watch')
    {
        echo $this->loadTemplate('videopopup');
        $height = $params->get('popupvid_height', '650');
        $width = $params->get('popupvid_width', '600');

        PIHelperadditional::resizescript($width, $height);
    }
elseif ($this->message->audioplayer && !$this->message->videoplayer)
    {
        echo $this->loadTemplate('audiopopup');
        //popup resize

        $height = $params->get('popupaud_height', '650');
        $width = $params->get('popupaud_width', '600');

        PIHelperadditional::resizescript($width, $height);
    }
elseif (!$this->message->audioplayer && $this->message->videoplayer)
    {
        echo $this->loadTemplate('videopopup');
        $height = $params->get('popupvid_height', '650');
        $width = $params->get('popupvid_width', '600');

        PIHelperadditional::resizescript($width, $height);
    }
else
    {
        if ($params->get('mediapriority', 1) == 1)
        {echo $this->loadTemplate('audiopopup');
        //popup resize

        $height = $params->get('popupaud_height', '650');
        $width = $params->get('popupaud_width', '600');}
        elseif ($params->get('mediapriority', 1) == 2)
        {echo $this->loadTemplate('videopopup');
        $height = $params->get('popupvid_height', '650');
        $width = $params->get('popupvid_width', '600');}  

        PIHelperadditional::resizescript($width, $height);
    }