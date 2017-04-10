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
class PreachitModelDatelist extends JModel
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

function _buildQuery()
	{
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
		$query = " SELECT DISTINCT date_format(study_date, '%Y') AS value, date_format(study_date, '%Y') AS text "
        . ' FROM #__pistudies'
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
            $this->_data = $this->_getList($query); 
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
        $where = PIHelperstudylist::wherevalue();
        return $where;
	}
	function _buildContentOrderBy()
	{
		$filter_order_Dir = 'ASC';
		$filter_order = 'value';
		
		$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
		
		return $orderby;
	}
}