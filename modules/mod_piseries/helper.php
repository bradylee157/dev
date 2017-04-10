<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class modpiseriesHelper
{  
    /**
     * Method to get series info for message module
     * @param unknown_type $params module parameters
     * @return    array
     */
     
	function getSeries(&$params)
	{
		$items = $params->get('items', 2);
		$menuid = $params->get('menuid');
		$sort = $params->get('orderby');
		$selection = $params->get('selection', 0);
		$language = JFactory::getLanguage()->getTag();
		$db =& JFactory::getDBO();
		
		if ($sort == '0') {$orderby = ' ORDER BY ordering ASC';}
 		if ($sort == '1') {$orderby = ' ORDER BY ordering DESC';}
 		if ($sort == '2') {$orderby = ' ORDER BY series_name';}
 		if ($sort == '3') {$orderby = ' ORDER BY id DESC';}
 		if ($sort == '4') {$orderby = ' ORDER BY id ASC';}
 		if ($sort == '5') {$orderby = '';}
 		$selcondition = '';
 		if ($selection == '1')
 		{
 			$selids = $params->get('selids');
            if (count($selids) > 0)
            {
                $selcondition = ' AND (id=' . implode( ' OR id=', $selids ) . ')';
            }
            else {$selcondition = ' AND id=0';}
		}
		
		$where[] = ' language IN ('.$db->quote($language).','.$db->quote('*').')';
		$where[] = ' published = 1';
		
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		
		$query = "SELECT * FROM #__piseries ".$where
		.$selcondition
		.$orderby;
		
		if ($sort == '5')
		{$db->setQuery( $query );}
		else {		
		$db->setQuery( $query, 0, $items );}
		
		$rows = $db->loadObjectList();
		
		if ($sort == '5')
		{shuffle($rows);
		$rows = array_slice($rows, 0, $items );}
		
		foreach ($rows as &$row) {
			
		$seriesslug = $row->id.':'.$row->series_alias;			
			
		
			$row->link = '<a href = "' .JRoute::_('index.php?option=com_preachit&view=studylist&layout=series&series=' . $seriesslug . '&Itemid=' . $menuid). '" >';}
		
		return $rows;
	}
	
}