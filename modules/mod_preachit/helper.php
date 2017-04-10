<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/additional.php');

class modpreachitHelper
{  
    /**
     * Method to get message info for message module
     * @param unknown_type $params module parameters
     * @return    array
     */
     
	function getStudy(&$params)
	{
		$items = $params->get('items', 2);
		$view = $params->get('linkdesc', 'video');
		$menuid = $params->get('menuid');
		$popup = $params->get('popup', 0);
		$sort = $params->get('orderby', 0);
		$seriessel = $params->get('seriessel', 0);
		$seriesselection = $params->get('seriesselect');
		$teachersel = $params->get('teachersel', 0);
		$teacherselection = $params->get('teacherselect');
		$ministrysel = $params->get('ministrysel', 0);
		$ministryselection = $params->get('ministryselect');
		$user	= JFactory::getUser();
		$language = JFactory::getLanguage()->getTag();
		$now = gmdate ( 'Y-m-d H:i:s' );
		$nullDate = '0000-00-00 00:00:00';
		$db=& JFactory::getDBO();
		
		if ($sort == '0') {$orderby = ' ORDER BY study_date desc';}
 		if ($sort == '1') {$orderby = ' ORDER BY id desc';}
 		if ($sort == '2') {$orderby = ' ORDER BY hits desc';}
 		if ($sort == '3') {$orderby = ' ORDER BY downloads desc';}
 		
 		// build where statement
 		
 		if ($teachersel == 1) {
			if (count($teacherselection) > 1)
			{foreach ($teacherselection AS $tl)
					{$tlist[] = 'teacher = '.$tl;}
				$where[] = '('. ( count( $tlist ) ? implode( ' OR ', $tlist ) : '' ) .')';}
			else
			{  $value = PIHelperadditional::getwherevalue($teacherselection);
				$where[] = 'teacher = '.$value;}
		}
		if ($seriessel == 1) {
			if (count($seriesselection) > 1)
			{foreach ($seriesselection AS $sl)
				{$slist[] = 'series = '.$sl;}
			$where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';}
			else
			{$value = PIHelperadditional::getwherevalue($seriesselection);
				$where[] = 'series = '.$value;}
		}
		if ($ministrysel == 1) {
			if (count($ministryselection) > 1)
			{foreach ($ministryselection AS $ml)
				{$mlist[] = 'ministry = '.$ml;}
			$where[] = '('. ( count( $mlist ) ? implode( ' OR ', $mlist ) : '' ) .')';}
			else
			{$value = PIHelperadditional::getwherevalue($ministryselection);
				$where[] = 'ministry = '.$value;}
		}
		$where[] = ' published = 1';
		$where[] = ' language IN ('.$db->quote($language).','.$db->quote('*').')';
		$where[] = '(publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).')';
		$where[] = '(publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).')';
		
        $groups = implode(',', $user->authorisedLevels());
		$where[] = ' (access IN ('.$groups.') OR access = 0)';
		$where[] = ' (saccess IN ('.$groups.') OR saccess = 0)';
		$where[] = ' (minaccess IN ('.$groups.') OR minaccess = 0)';

		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		
		$query = "SELECT * FROM #__pistudies "
		.$where
		.$orderby;
		$db->setQuery( $query, 0, $items );
		
		$rows = $db->loadObjectList();
		
		foreach ($rows as &$row) {
			
		$studyslug = $row->id.':'.$row->study_alias;
        
        $linkdesc = 'study';
			
		if ($popup == '1')
		{		$row->link = "<a href='index.php?option=com_preachit&tmpl=component&id=" .$studyslug . "&view=".$linkdesc."' onClick='showPopup(this.href);return(false);'>";}
		else {	
			$row->link = '<a href = "' .JRoute::_('index.php?option=com_preachit&view=' . $linkdesc . '&id=' . $studyslug . '&Itemid=' . $menuid). '" >';}
		}
		
		return $rows;
	}
	
}