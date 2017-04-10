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
class PreachitModelTaglist extends JModel
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
       $limitstart = $app->getUserStateFromRequest( $option.'&view=taglist.limitstart', 'limitstart', 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

function getData() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) 
        {
            $app = JFactory::getApplication();
            $option = JRequest::getCmd('option');
            $order = $app->getUserStateFromRequest( $option.'filter_order',        'filter_order',        'count',    'cmd' );
            $sort = $app->getUserStateFromRequest( $option.'filter_order_Dir',    'filter_order_Dir',    'DESC' );
            $this->_data = array_slice(Tewebtags::gettags('#__pistudies', $sort, $order), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_data;
  }

function getTotal()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $this->_total = count(Tewebtags::gettags('#__pistudies'));    
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