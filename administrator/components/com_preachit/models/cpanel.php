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
class PreachitModelCpanel extends JModel
{
var $_datalat = null;
var $_datapop = null;
var $_datapod = null;
var $_query = null;



	function _buildQuerylat()
	{
		$query = "SELECT * FROM #__pistudies WHERE published = 1 ORDER by id DESC LIMIT 10"; 
			;
		return $query;
	}

function getDatalat() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_datalat)) 
{
            $query = $this->_buildQuerylat();
            $this->_datalat = $this->_getList($query); 
        }
        return $this->_datalat;
  }

function _buildQuerypop()
	{
		$query = "SELECT * FROM #__pistudies WHERE published = 1 ORDER by hits DESC LIMIT 10"; 
			;
		return $query;
	}

function getDatapop() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_datapop)) 
{
            $query = $this->_buildQuerypop();
            $this->_datapop = $this->_getList($query); 
        }
        return $this->_datapop;
  }
  
  	function _buildQuerypod()
	{
		$query = "SELECT * FROM #__pipodcast WHERE published = 1 ORDER by podpub DESC LIMIT 10"; 
			;
		return $query;
	}

function getDatapod() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_datapod)) 
{
            $query = $this->_buildQuerypod();
            $this->_datapod = $this->_getList($query); 
        }
        return $this->_datapod;
  }
}