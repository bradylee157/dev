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
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
class PreachitModelSerieslist extends JModel
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
		$this->setState('limit', $params->get('serieslist_no'), 'limit', $params->get('serieslist_no'), 'int');
			$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	function _buildQuery()
	{
  		$params = PIHelperadditional::getPIparams();
  		$where = $this->_buildContentWhere();
 		$sort = $params->get('seriessort', '1');
 		if ($sort == '1') {$order = 'id DESC';}
 		if ($sort == '2') {$order = 'id ASC';}
 		if ($sort == '3') {$order = 'ordering';}
 		if ($sort == '4') {$order = 'ordering DESC';}
        if ($sort == '5') {$order = 'series_name DESC';}
         if ($sort == '6') {$order = 'series_name ASC';}
 		$orderby = ' ORDER BY '.$order;
		$query = "SELECT * FROM #__piseries"
		. $where
		. $orderby;
		return $query;
	}


function getData() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) 
        {
            $params = PIHelperadditional::getPIparams();
            $sort = $params->get('seriessort', '1');
            $query = $this->_buildQuery();
            if ($sort != 1 && $sort != 2)
            {$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));}
            else {
                if ($sort == 1)
                {$order = 'DESC';}
                else {$order = 'ASC';}
                $column = $params->get('seriessort_column', 'enddate');
                $items = $this->_getList($query);
                $this->_data = array_slice($this->_sortlistbydate($items, $column, $order), $this->getState('limitstart'), $this->getState('limit'));
            }
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
			$app = JFactory::getApplication();			
			$user	= JFactory::getUser();
			$language = JFactory::getLanguage()->getTag();
			$menuparams =& $app->getParams();
			$seriessel = $menuparams->get('seriessel', 0);
			$seriesselection = $menuparams->get('seriesselect');
            $letter = JRequest::getVar('alpha', '');
            $layout = JRequest::getVar('layout', '');
            if ($layout == 'ministry')
            {$ministry = JRequest::getInt('ministry', 0);}
            else {$ministry = 0;}
			$slist = array();	
		             
			$where = array();
			$where[] = ' #__piseries.published = 1';
            
            if ($letter)
            {
               $where[] = ' SUBSTRING(#__piseries.series_name, 1, 1) = '.$this->_db->quote($letter); 
            }
			
			$groups = implode(',', $user->authorisedLevels());
			$where[] = ' (#__piseries.access IN ('.$groups.') OR #__piseries.access = 0)';

			if ($seriessel == 1 && $ministry == 0) { 
			if (count($seriesselection) > 1)
			{
			foreach ($seriesselection AS $sl)
				{
					$slist[] = '#__piseries.id = '.$sl;
				}
			$where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';
			}
			else
			{
				$where[] = '#__piseries.id = '.PIHelperadditional::getwherevalue($seriesselection);
			}
		}
        elseif ($ministry > 0)
        {$where[] = '#__piseries.ministry REGEXP "[[:<:]]' .$ministry .'[[:>:]]"';}
			$where[] = ' #__piseries.language IN ('.$this->_db->quote($language).','.$this->_db->quote('*').')';
			
			$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
		
		}
        
    function _sortlistbydate($items, $column, $order)
    {
        foreach ($items AS $key => $item)        
        {
            if ($column == 'startdate')
            {
                $items[$key]->date = PIHelpermessageinfo::getseriesdate($item->id, 'ASC', null);
            }
            else {
                $items[$key]->date = PIHelpermessageinfo::getseriesdate($item->id, 'DESC', null);
            }
        }
        $order = strtolower($order);
        if ($order == 'asc')
        {
            uasort($items, array('self', 'cmpSeriesDateAsc'));
        }
        elseif ($order == 'desc')
        {
            uasort($items, array('self', 'cmpSeriesDateDesc'));
        }
        
        return $items;
        
    }
    
    /**
     * Compare function for series array. Sort criteria: date reverse
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return -1, if lesser; 0, if equal; +1 if greater.
     */
     public function cmpSeriesDateDesc(&$a, &$b)
    {
        $va = $a->date;
        $vb = $b->date;
        if ($va == $vb)
        {
            return 0;
        }
        return ($va < $vb) ? +1 : -1;
    }
    
/**
     * Compare function for series array. Sort criteria: date ascending
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return +1, if lesser; 0, if equal; -1 if greater.
     */
   public function cmpSeriesDateAsc(&$a, &$b)
    {
        $va = $a->date;
        $vb = $b->date;
        if ($va == $vb)
        {
            return 0;
        }
        return ($va < $vb) ? -1 : +1;
    }
}