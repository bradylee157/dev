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
class PreachitModelMinistrylist extends JModel
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
		$this->setState('limit', $params->get('ministrylist_no'), 'limit', $params->get('ministrylist_no'), 'int');
			$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	function _buildQuery()
	{
		$abspath    = JPATH_SITE;
  		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
  		$params = PIHelperadditional::getPIparams();
  		$user	= JFactory::getUser();
  		$where = $this->_buildContentWhere();
 		$sort = $params->get('ministrysort', '1');
 		if ($sort == '1') {$order = 'ministry_name DESC';}
 		if ($sort == '2') {$order = 'ministry_name ASC';}
 		if ($sort == '3') {$order = 'ordering';}
 		if ($sort == '4') {$order = 'ordering DESC';}
 		$orderby = ' ORDER BY '.$order;
		$query = "SELECT * FROM #__piministry"
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
			$user	= JFactory::getUser();
			$app = JFactory::getApplication();
			$abspath    = JPATH_SITE;
  			require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');			
			$language = JFactory::getLanguage()->getTag();
			$menuparams =& $app->getParams();
			$ministrysel = $menuparams->get('ministrysel', 0);
			$ministryselection = $menuparams->get('ministryselect');		
			$mlist = array();
		
			$where = array();
			$where[] = ' #__piministry.published = 1';
			
				$groups = implode(',', $user->authorisedLevels());
				$where[] = ' (#__piministry.access IN ('.$groups.') OR #__piministry.access = 0)';
			
			if ($ministrysel == 1) {
			if (count($ministryselection) > 1)
			{
			foreach ($ministryselection AS $ml)
				{
					$mlist[] = '#__piministry.id = '.$ml;
				}
			$where[] = '('. ( count( $mlist ) ? implode( ' OR ', $mlist ) : '' ) .')';
			}
			else
			{
				$where[] = '#__piministry.id = '.PIHelperadditional::getwherevalue($ministryselection);
			}
		}
			$where[] = ' #__piministry.language IN ('.$this->_db->quote($language).','.$this->_db->quote('*').')';
			
			$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
			
		return $where;
		
		}
  
}