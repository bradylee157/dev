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

class piStats {

    /**
     * Total plays of media files per study
     * return int
	*/
    function totalhits()
    {
        $db = JFactory::getDBO();
        $query = 'SELECT sum(hits) FROM #__pistudies';
        $db->setQuery($query);
        $db->query();
        $hits = $db->loadResult();
        return (int)$hits;
    }
    
    /**
     * Total downloads per study
     * return int
    */
    function totaldownloads()
    {
        $db = JFactory::getDBO();
        $query = 'SELECT sum(downloads) FROM #__pistudies';
        $db->setQuery($query);
        $db->query();
        $hits = $db->loadResult();
        return (int)$hits;
    }
    
    /**
     * Total number of published messages
     * return int
    */
	function get_no_messages() {
		$db = JFactory::getDBO();
		$query='SELECT COUNT(*) FROM #__pistudies WHERE published = "1"';
		$db->setQuery($query);
		return intval($db->loadResult());
	}

    /**
     * Total number of published series
     * return int
    */
	function get_no_series() {
		$db = JFactory::getDBO();
		$query='SELECT COUNT(*) FROM #__piseries WHERE published = "1"';
		$db->setQuery($query);
		return intval($db->loadResult());
	}
	
    /**
     * Total number of published teachers
     * return int
    */
	function get_no_teachers() {
		$db = JFactory::getDBO();
		$query='SELECT COUNT(*) FROM #__piteachers WHERE published = "1"';
		$db->setQuery($query);
		return intval($db->loadResult());
	}
	
    /**
     * Total number of published ministries
     * return int
    */
	function get_no_ministry() {
		$db = JFactory::getDBO();
		$query='SELECT COUNT(*) FROM #__piministry WHERE published = "1"';
		$db->setQuery($query);
		return intval($db->loadResult());
	}
	
    /**
     * Total number of published podcasts
     * return int
    */
	function get_no_podcast() {
		$db = JFactory::getDBO();
		$query='SELECT COUNT(*) FROM #__pipodcast WHERE published = "1"';
		$db->setQuery($query);
		return intval($db->loadResult());
	}
	

}

?>