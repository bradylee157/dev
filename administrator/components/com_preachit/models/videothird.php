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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');
jimport('teweb.media.functions');
class PreachitModelVideothird extends JModel
{
var $_data = null;
var $_pagination = null;
var $_total = null;
var $_search = null;
var $_query = null;

function __construct()
  {
        parent::__construct();
 
        $app = JFactory::getApplication();
        $option = JRequest::getCmd('option');
 
	}


function getData() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) 
			{
				$url = JRequest::getVar('url', '');
				// ascertain which 3rd party this is from

				$type = '';
				$info = '';
				if ($url)
				{
				$test = strtolower($url);
				$vimeo = 'vimeo.com';
				$youtube = 'youtube.com';
				$bliptv = 'blip.tv';
				if (strlen(strstr($url,$vimeo))>0)
				{
				$type = 'vimeo';
				$info = Tewebmedia::vimeoinfo($url);
				}

				if (strlen(strstr($url,$youtube))>0)
				{$type = 'youtube';
				$info = Tewebmedia::youtubeinfo($url);
				}
				if (strlen(strstr($url,$bliptv))>0)
				{$type = 'bliptv';
				$info = Tewebmedia::bliptvinfo($url);
				}	
				}
            $this->_data = $info;
        }
        return $this->_data;
  }

}