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
class PreachitModelTeacherlist extends JModel
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
			$this->setState('limit', $params->get('teacherlist_no'), 'limit', $params->get('teacherlist_no'), 'int');
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	function _buildQuery()
	{
		$abspath    = JPATH_SITE;
  		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
  		$params = PIHelperadditional::getPIparams();
  		$where = $this->_buildContentWhere();
 		$sort = $params->get('teachersort', '1');
 		if ($sort == '1') {$order = 'lastname DESC';}
 		if ($sort == '2') {$order = 'lastname ASC';}
 		if ($sort == '3') {$order = 'ordering';}
 		if ($sort == '4') {$order = 'ordering DESC';}
 		$orderby = ' ORDER BY '.$order;
		$query = "SELECT * FROM #__piteachers"
		. $where
		. $orderby;
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
			$app = JFactory::getApplication();			
			$user	= JFactory::getUser();
			$abspath    = JPATH_SITE;
  			require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');			
			$language = JFactory::getLanguage()->getTag();
			$menuparams =& $app->getParams();
			$teachersel = $menuparams->get('teachersel', 0);
			$teacherselection = $menuparams->get('teacherselect');
            $letter = JRequest::getVar('alpha', '');
			$tlist = array();	
		
			$where = array();
			$where[] = ' #__piteachers.published = 1'; 
			$where[] = ' #__piteachers.teacher_view = 1'; 
            
            if ($letter)
            {
               $where[] = ' SUBSTRING(#__piteachers.lastname, 1, 1) = '.$this->_db->quote($letter); 
            }
			
			if ($teachersel == 1) {
			if (count($teacherselection) > 1)
			{
			foreach ($teacherselection AS $tl)
				{
					$tlist[] = '#__piteachers.id = '.$tl;
				}
			$where[] = '('. ( count( $tlist ) ? implode( ' OR ', $tlist ) : '' ) .')';
			}
			else
			{
				$where[] = '#__piteachers.id = '.PIHelperadditional::getwherevalue($teacherselection);
			}
		}
			$where[] = ' #__piteachers.language IN ('.$this->_db->quote($language).','.$this->_db->quote('*').')';
			
			$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
			
		return $where;
		
		} 
  
}