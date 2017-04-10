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
class PreachitModelPodcastlist extends JModel
{
var $_data = null;
var $_pagination = null;
var $_total = null;
var $_search = null;
var $_query = null;

function __construct()
  {
        parent::__construct();
  // Get pagination request variables
		$this->setState('limit', 10, 'limit', 10, 'int');
			$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	function _buildQuery()
	{
 		$sort = 3;
 		if ($sort == '1') {$order = 'id DESC';}
 		if ($sort == '2') {$order = 'id ASC';}
 		if ($sort == '3') {$order = 'ordering';}
 		if ($sort == '4') {$order = 'ordering DESC';}
		$query = "SELECT * FROM #__pipodcast WHERE published = '1' ORDER BY $order";
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
}