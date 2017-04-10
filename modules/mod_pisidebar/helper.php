<?php
/**
 * @Module- Preachit Side Bar
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('teweb.checks.standard');
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/scripture.php');
require_once($abspath.DS.'components/com_preachit/helpers/additional.php');

class modpisidebarHelper
{  

/**
     * Method to organise the building of the sidebar content
     * @param int $id id of the message
     * @param sting $view current view
     * @param int $series id of the series
     * @param int $Itemid itemid for the links
     * @param unknown_type $params module params
     * @return    string
     */

public function buildsidebar($id, $view, $series, $itemid, $params) 
{
		$db=& JFactory::getDBO();
		
		$sort = $params->get('orderby', 0);
		$items = $params->get('items', 'all');
		
		if ($sort == '0') {$orderby = 'ORDER BY study_date desc';}
 		if ($sort == '1') {$orderby = 'ORDER BY id desc';}
 		if ($sort == '2') {$orderby = 'ORDER BY hits desc';}
 		if ($sort == '3') {$orderby = 'ORDER BY downloads desc';}		
		
		$query = "SELECT * from #__pistudies WHERE series = '".$series."'".$orderby;
		
		
		$now = gmdate ( 'Y-m-d H:i:s' );
		$nullDate = '0000-00-00 00:00:00';
		
		$query = "SELECT * FROM #__pistudies WHERE series = '".$series."'"
					." AND published = '1' AND (publish_up = '"
					.$nullDate."' OR publish_up <= '".$now."')"
					." AND (publish_down = '".$nullDate."'"
					."OR publish_down >= '".$now."')"
		.$orderby;
		
		if ($items == 'all')		
		{
		$db->setQuery($query);}
		else {$db->setQuery( $query, 0, $items );}
		$rows = $db->loadObjectList();
		
		$sect1 = modpisidebarHelper::buildseriesinfo($series, $params);
		$sect2 = modpisidebarHelper::buildsermonbox($rows, $view, $itemid, $id, $params);
		
		$htmltitle = '<div class="pi-block"><div class="module-title"><h2 class="title">'.JText::_('MOD_PISIDEBAR_ABOUT_SERIES').'</h2></div>';
		
		$html = $htmltitle.$sect1.$sect2;
		
		return $html;		
		
	}

/**
     * Method to get series info html
     * @param int $series id of the series
     * @param unknown_type $params module params
     * @return    string
     */
	
private function buildseriesinfo($series, $params)
{
		
	if ($params->get('stitle', 0) == 1)
	{$title = modpisidebarHelper::getstitle($series, $params);}
	else {$title = '';}
	if ($params->get('sdesc', 0) == 1)
	{$desc = modpisidebarHelper::getsdesc($series, $params);}
	else {$desc = '';}
	if ($params ->get ('simage', 0) == 1)
	{	$abspath    = JPATH_SITE;
		require_once($abspath.DS.'components/com_preachit/helpers/seriesimage.php');
		$simagesm = PIHelpersimage::seriesimage($series, 0, '', 'small');
		$simagelrg = PIHelpersimage::seriesimage($series, 0, '', 'large');
		
		$imagesize = $params ->get('simagesize', 0);	
		
		if ($imagesize == 0)
		{
		$image = $simagesm;
		}

		if ($imagesize == 1)
		{
		$image = $simagelrg;
		}
	}
	else {$image = '';}
		
		
	
	
	$html = $title.$image.$desc;
	
	return $html;
	
	}

/**
     * Method to build sermon box html
     * @param array $rows message info
     * @param sting $view current view
     * @param int $Itemid itemid for the links
     * @param int $id id of the message
     * @param unknown_type $params module params
     * @return    string
     */
	
private function buildsermonbox($rows, $view, $itemid, $id, $params)
	
    {
		$db=& JFactory::getDBO();
		$dateformat = $params->get('date_format', '');
		$html = '';
		foreach ($rows as $study)
		{
			$html1 = '';
			$nowplaying = '';
            if ($params->get('namelength', '') > 0)
            {$study->study_name = Tewebeffects::shortentext($study->study_name, $params->get('namelength', ''));}
            
			$view = 'study';
			
			if ($study->id == $id)
			{$nowplaying = '<div class="nowplaying">'.JText::_('MOD_PISIDEBAR_NOW_PLAYING').'</div>';}
			
			$query = "SELECT ".$db->nameQuote('teacher_name')."
    		FROM ".$db->nameQuote('#__piteachers')."
    		WHERE ".$db->nameQuote('id')." = ".$db->quote($study->teacher).";
 			 ";
			$db->setQuery($query);
			if ($params->get('teacher', 1) == 1)
			{
			$teacher = '<div class="teacher">'.JText::_('MOD_PISIDEBAR_SPEAKER').': '.$db->loadResult().'</div>';}
			else {$teacher = '';}
			if ($params->get('date', 1) == 1)
			{
			$date = '<div class="date">'.JHTML::Date($study->study_date, $dateformat).'</div>';}
			else {$date = '';}
			if ($params->get('scripture', 1) == 1)
			{
			$scripture = '<div class="scripture">'.JText::_('MOD_PISIDEBAR_TEXT').': '.PIHelperscripture::podscripture($study->id).'</div>';}
			else {$scripture = '';}
			if ($view && $study->id != $id)
			{$studyslug = $study->id.':'.$study->study_alias;
			$name = '<div class="name"><a href="'.JRoute::_('index.php?option=com_preachit&view='.$view.'&id='.$studyslug.'&Itemid='.$itemid).'" alt="'.JText::_('MOD_PISIDEBAR_LINKALT').'">'.$study->study_name.'</a></div>';}
			else {$name = '<div class="name">'.$study->study_name.'</div>';}
			
			$html1 = '<div class="pisidelist">'.$nowplaying.$name.$scripture.$teacher.$date.'</div>';
			$html = $html.$html1;
			
			}
			
			$html = '<div class="piside-cont">'.$html.'</div></div>';
			
			return $html;
			
			}

/**
     * Method to get series title
     * @param int $series series id
     * @param unknown_type $params module params
     * @return    string
     */
	
private function getstitle($series, $params)
{
    $db=& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('series_name')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
	$db->setQuery($query);
	$text = $db->loadResult();
	
	$title = '<div class="pi-side-name">'.$text.'</div>';
	return $title;
  }

/**
     * Method to get series description
     * @param int $series series id
     * @param unknown_type $params module params
     * @return    string
     */
	
private function getsdesc($series, $params)
{
    $db=& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('series_description')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
	$db->setQuery($query);
	$text = $db->loadResult();
	
	$desc = '<div class="pi-side-desc">'.$text.'</div>';
	return $desc;
}

/**
     * Method to build module content for sidebar if needed
     * @param int $Itemid itemid for the links
     * @param unknown_type $params module params
     * @return    string
     */
	
public function buildmodules($itemid, $params)
{ 
    $position = $params->get('piposition', 'pisidebar');
    $style = $params->get('style', 'xhtml');
	$styles		= array('style'=>$style);
	$document	= &JFactory::getDocument();
	$renderer	= $document->loadRenderer('module');
	$html = '';
	foreach (JModuleHelper::getModules($position) as $mod)  {	
	$html .= $renderer->render($mod, $styles);
    }
	return$html;
}

}