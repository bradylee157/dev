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
class PreachitModelStudylist extends JModel
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
		$this->setState('limit', $params->get('studylist_no'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		// In case we are on more than page 1 of results and the total changes in one of the drop downs to a selection that has fewer in its total, we change limitstart
		if ($this->getTotal() < $this->getState('limitstart')) {$this->setState('limitstart', 0,'','int');}
	}

	function _buildQuery()
	{
		$where = $this->_buildContentWhere();
        $order = $this->_buildContentOrder();
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
    $abspath = JPATH_SITE;
  	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/studylist.php');
  	$filter = PIHelperstudylist::filtervalues();
    $where = PIHelperstudylist::wherevalue($filter->book, $filter->year, $filter->teacher, $filter->series, $filter->ministry, $filter->tag, $filter->asmedia, $filter->chapter);
	return $where;
}
    
function _buildContentOrder()
    {    
        $abspath    = JPATH_SITE;
        require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
        $params = PIHelperadditional::getPIparams();
        $sort = $params->get('messagesort', '1');
        if (JRequest::getInt('year', 0) > 0)
        {$order = 'study_date asc';}
        elseif (JRequest::getInt('book', 0) > 0)
        {$order = 'ref_ch_beg, ref_vs_beg asc';}
        elseif ($sort == '1') {$order = 'study_date desc';}
        elseif ($sort == '2') {$order = 'study_date asc';}
        elseif ($sort == '3') {$order = 'id asc';}
        elseif ($sort == '4') {$order = 'id DESC';}
        return $order;
    }
}