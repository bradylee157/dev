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
 
        $app = JFactory::getApplication();
 			$option = JRequest::getCmd('option');
 			
        // Get pagination request variables
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
       $limitstart = $app->getUserStateFromRequest( $option.'&view=studylist.limitstart', 'limitstart', 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	function _buildQuery()
	{
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
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
		 	$option = JRequest::getCmd('option');
		$app = JFactory::getApplication();

		$filter_book		= $app->getUserStateFromRequest( $option.'filter_book',		'filter_book',		0,				'int' );
		$filter_teacher		= $app->getUserStateFromRequest( $option.'filter_teacher',	'filter_teacher',		0,				'int' );
		$filter_series		= $app->getUserStateFromRequest( $option.'filter_series',		'filter_series',		0,				'int' );
		$filter_ministry		= $app->getUserStateFromRequest( $option.'filter_ministry',		'filter_ministry',		0,				'int' );
		$filter_year		= $app->getUserStateFromRequest( $option.'filter_year',		'filter_year',		0,				'int' );
		$filter_lang		= $app->getUserStateFromRequest( $option.'filter_lang',		'filter_lang',		'',				'string' );
		$filter_orders		= $app->getUserStateFromRequest( $option.'filter_orders',		'filter_orders',		'DESC',				'word' );
		$filter_state		= $app->getUserStateFromRequest( $option.'filter_statemes',		'filter_statemes', 5, 'int' );

		$where = array();


		if ($filter_book > 0) {
			$where[] = ' #__pistudies.study_book = '.(int) $filter_book;
		}
		if ($filter_teacher > 0) {
			$where[] = ' #__pistudies.teacher REGEXP "[[:<:]]'.(int) $filter_teacher.'[[:>:]]"';
		}
		if ($filter_series > 0) {
			$where[] = ' #__pistudies.series = '.(int) $filter_series;
		}
		if ($filter_ministry > 0) {
			$where[] = ' #__pistudies.ministry REGEXP "[[:<:]]'.(int) $filter_ministry.'[[:>:]]"';
		}
		if ($filter_year > 0) {
			$where[] = " date_format(#__pistudies.study_date, '%Y')= ".(int) $filter_year;
		}
		
		if ($filter_state < 5) {
			$where[] = " #__pistudies.published =".(int) $filter_state;
		}
		if ($filter_state == 5) {
			$where[] = " #__pistudies.published != -2";
		}
		if ($filter_lang) {
			$where[] = ' #__pistudies.language = '.$this->_db->quote($filter_lang);
		}
		
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

		return $where;
	}
	
function _buildContentOrderBy()
	{
		$app = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		
		$orders = array('id','published','study_date','study_name','study_book','teacher','series','language','hits','downloads');
		$filter_order = $app->getUserStateFromRequest($option.'filter_order','filter_order','ordering','cmd' );
		$filter_order_Dir = strtoupper($app->getUserStateFromRequest($option.'filter_order_Dir','filter_order_Dir','DESC'));
		if($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC'){$filter_order_Dir = 'DESC';}
		if(!in_array($filter_order,$orders)){$filter_order = 'study_date';}
		
		$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , id';
		
		return $orderby;
	}
}