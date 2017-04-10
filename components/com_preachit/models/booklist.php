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
class PreachitModelBooklist extends JModel
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
		$where		= $this->_buildContentWhere('study_book');
		$orderby	= $this->_buildContentOrderBy();
		$query = " SELECT DISTINCT study_book AS id "
        . ' FROM #__pistudies'
			. $where
			. $orderby
			;
		return $query;
	}

function _buildQuery2()
    {
        $where        = $this->_buildContentWhere('study_book2');
        $orderby    = $this->_buildContentOrderBy();
        $query = " SELECT DISTINCT study_book2 AS id "
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
{           $booklist = array();
            $query = $this->_buildQuery();
            $query2 = $this->_buildQuery2();
            $book1 = $this->_getList($query); 
            $book2 = $this->_getList($query2); 
            foreach ($book1 AS $b1)
            {
                $booklist[] = $b1->id;
            }
            foreach ($book2 AS $b2)
            {
                $booklist[] = $b2->id;
            } 
            sort($booklist);
            $booklist = array_unique($booklist); 
            //$booklist = sort($booklist); print_r($booklist);
            $this->_data = $booklist;
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
  
      function _buildContentWhere($book)
    {
        $tag = JRequest::getVar('tag', '');
        $abspath = JPATH_SITE;
        require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/studylist.php');
        $where = PIHelperstudylist::wherevalue();
        $where .= " AND #__pistudies.".$book." > 0" ;
        return $where;
    }
	function _buildContentOrderBy()
	{
		$filter_order_Dir = 'ASC';
		$filter_order = 'id';
		
		$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
		
		return $orderby;
	}
}