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
class PreachitModelMimelist extends JModel
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
 
        // Get pagination request variables
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
       $limitstart = $app->getUserStateFromRequest( $option.'&view=mimelist.limitstart', 'limitstart', 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

function _buildQuery()
	{
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
		$query = "SELECT * FROM #__pimime" 
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
		 	$option = JRequest::getCmd('option');
		$app = JFactory::getApplication();

		$filter_state		= $app->getUserStateFromRequest( $option.'filter_statemm',		'filter_statemm', 5, 'int' );

		$where = array();

		if ($filter_state < 5) {
			$where[] = " #__pimime.published =".(int) $filter_state;
		}
		if ($filter_state == 5) {
			$where[] = " #__pimime.published = 1 OR #__pimime.published = 0";
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		
		return $where;
	}
	function _buildContentOrderBy()
	{
		$filter_order_Dir = 'ASC';
		$filter_order = 'extension';
		
		$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
		
		return $orderby;
	}
}