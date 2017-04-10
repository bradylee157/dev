<?php
/**
 * @Component - Melody
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');
class PreachitModelTaglist extends JModel
{
var $_data = null;
var $_pagination = null;
var $_total = null;
var $_search = null;
var $_query = null;

function __construct()
  {
        parent::__construct();
 	$abspath    = JPATH_SITE;
  	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
  	$params = PIHelperadditional::getPIparams();
  // Get pagination request variables
			$this->setState('limit', $params->get('messageno_tags'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}
    
function gettaglist() 
  {
      jimport('teweb.details.tags');
        // if data hasn't already been obtained, load it
        if (empty($this->_taglist)) 
        {
            $app = JFactory::getApplication();
            $option = JRequest::getCmd('option');
            $order = 'name';
            $sort = 'asc';
            $this->_taglist = Tewebtags::gettags('#__pistudies', $sort, $order);
        }
        return $this->_taglist;
  }
}