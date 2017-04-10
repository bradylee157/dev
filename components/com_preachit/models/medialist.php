<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');
class PreachitModelMedialist extends JModel
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
			$this->setState('limit', $params->get('studies_media'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

function _buildQuery()
	{
		$id = JRequest::getInt('id', 0);
		$abspath = JPATH_SITE;
  		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
  		$params = PIHelperadditional::getPIparams();
  		$where = $this->_buildContentWhere();
 		$sort = $params->get('mmessagesort', '1');
 		if ($sort == '1') {$order = 'study_date desc';}
 		if ($sort == '2') {$order = 'study_date asc';}
 		if ($sort == '3') {$order = 'name asc';}
 		if ($sort == '4') {$order = 'name DESC';}
 		if ($sort == '5') {$order = 'id asc';}
 		if ($sort == '6') {$order = 'id DESC';}
		$orderby = ' ORDER BY '.$order;
		$query = "SELECT * FROM #__pistudies"
		. $where		
		. $orderby
			;
		return $query;
	}


function getData() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) 
{
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
        return $this->_data;
  }

function getTotal()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  }

  function getPagination()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  }
  
function _buildContentWhere()
	{		
        $id = JRequest::getInt('id', 0);
        $abspath = JPATH_SITE;
        require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/studylist.php');
        $where = PIHelperstudylist::wherevalue();
        $where .= ' AND #__pistudies.asmedia = '.$id;
        return $where;
	}
}