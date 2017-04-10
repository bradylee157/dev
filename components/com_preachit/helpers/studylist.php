<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('teweb.details.standard');

class PIHelperstudylist{

/**
	 * Method to build standard where clause
	 *
	 * @param	int $filter_book book filter setting.
	 * @param	int $filter_year year filter setting.
	 * @param	int $filter_teacher teacher filter setting.
	 * @param	int $filter_series series filter setting.
	 * @param	int $filter_ministry ministry filter setting.
     * @param    int $filter_tag tag filter setting.
     * @param    int $filter_asmedia asmedia filter setting.
     * @param    int $filter_chapter chapter filter setting.
     * @param    unknown type $menuparams menuparams setting.
	 *
	 * @return	string
	 */

function wherevalue($filter_book = null, $filter_year = null, $filter_teacher = null, $filter_series = null, $filter_ministry = null, $filter_tag = null, $filter_asmedia = null, $filter_chapter = null, $menuparams = null)
{
$app = JFactory::getApplication();
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
$now = gmdate ( 'Y-m-d H:i:s' );
$nullDate = $db->getNullDate();
if (!$menuparams)
{$menuparams =& $app->getParams();}
$user    = JFactory::getUser();
$language = JFactory::getLanguage()->getTag();
$seriessel = $menuparams->get('seriessel', 0);        
$seriesselection = $menuparams->get('seriesselect');    
$teachersel = $menuparams->get('teachersel', 0);
$teacherselection = $menuparams->get('teacherselect');     
$ministrysel = $menuparams->get('ministrysel', 0);
$ministryselection = $menuparams->get('ministryselect'); 
$datesel = $menuparams->get('datesel', 0);
$dateselection = $menuparams->get('dateselect');
$where = array();
$tlist = array();
$slist = array();
$mlist = array();
        
if (strlen($filter_year) == 4)
{$datelist = 2;}
else {$datelist = 1;}

if ($filter_book > 0) {
    $where[] = ' (#__pistudies.study_book = '.(int) $filter_book.' OR #__pistudies.study_book2 = '.(int) $filter_book.')' ;
}
if ($filter_chapter > 0) {
    $where[] = ' (#__pistudies.ref_ch_beg = '.(int) $filter_chapter.' OR #__pistudies.ref_ch_beg2 = '.(int) $filter_chapter.' OR #__pistudies.ref_ch_end = '.(int) $filter_chapter.' OR #__pistudies.ref_ch_end2 = '.(int) $filter_chapter.')' ;
}
if ($filter_tag != null) {
    $where[] = " (LOWER(#__pistudies.tags) LIKE '%$filter_tag%')" ;
}
if ($filter_teacher > 0) {
    $where[] = ' #__pistudies.teacher REGEXP "[[:<:]]'.(int) $filter_teacher.'[[:>:]]"';
}
elseif ($teachersel == 1) {
    if (is_array($teacherselection))
    { 
        foreach ($teacherselection AS $tl)
        {
            if ($tl > 0)
            {$tlist[] = '#__pistudies.teacher REGEXP "[[:<:]]' .$tl .'[[:>:]]"';}
            else {$tlist[] = '#__pistudies.teacher REGEXP "[[:<:]]0[[:>:]]"';}
        }
    }
    else  {$tlist[] = '#__pistudies.teacher REGEXP "[[:<:]]0[[:>:]]"';}
    $where[] = '('. ( count( $tlist ) ? implode( ' OR ', $tlist ) : '' ) .')';
}
        
if ($filter_series > 0) {
    $where[] = ' #__pistudies.series = '.(int) $filter_series;
}
elseif ($seriessel == 1) {
    if (is_array($seriesselection))
    { 
        foreach ($seriesselection AS $sl)
        {
            if ($sl > 0)
            {$slist[] = '#__pistudies.series = '.$sl;}
            else {$slist[] = '#__pistudies.series = 0';}
        }
    }
    else {$slist[] = '#__pistudies.series = 0';}
    $where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';
}
        
if ($filter_ministry > 0) {
    $where[] = ' #__pistudies.ministry REGEXP "[[:<:]]' .(int) $filter_ministry .'[[:>:]]"';
}
elseif ($ministrysel == 1) {
    if (is_array($ministryselection))
    {
        foreach ($ministryselection AS $ml)
        {
            if ($ml > 0)
            {$mlist[] = '#__pistudies.ministry REGEXP "[[:<:]]' .$ml .'[[:>:]]"';}
            else {$mlist[]  = '#__pistudies.ministry REGEXP "[[:<:]]0[[:>:]]"'; }
        }
    }
    else {$mlist[] = '#__pistudies.ministry REGEXP "[[:<:]]0[[:>:]]"';}
    $where[] = '('. ( count( $mlist ) ? implode( ' OR ', $mlist ) : '' ) .')';
}
        
if ($filter_year > 0) {
    if ($datelist == 2)
        {
            $startdate = (int) $filter_year.'-01-01 00:00:00';
            $finishdate = (int) $filter_year.'-12-31 23:59:59';
            $config =& JFactory::getConfig();
            $siteOffset = $config->getValue('config.offset');
            // adjust study date by site offset
            $start = JFactory::getDate($startdate, $siteOffset); 
            $start = $start->toMySQL();
            $finish = JFactory::getDate($finishdate, $siteOffset); 
            $finish = $finish->toMySQL();
            $where[] = " (#__pistudies.study_date >= ".$db->quote($start)." AND #__pistudies.study_date <= ".$db->quote($finish).")";
        }
    if ($datelist == 1)
        {
            if (strlen((int) $filter_year) == 5)
            {$year = substr((int) $filter_year, 2, 5);
            $month = substr((int) $filter_year, 0, 1);}
            else 
            {$year = substr((int) $filter_year, 3, 6);
            $month = substr((int) $filter_year, 0, 2);}
            $thirtyone = array(1,3,5,7,8,10,12);
            $thirty = array(4,6,9,11);
            if (in_array($month, $thirtyone))
            {$endday = 31;}
            elseif (in_array($month, $thirty))
            {$endday = 30;}   
            else {
                //test if its a leap year
                $leap = date('L', strtotime($year.'-01-01 00:00:00'));
                if ($leap == 1)
                {$endday = 29;}
                else {$endday = 28;}
            }
            $startdate = $year.'-'.$month.'-01 00:00:00';
            $finishdate = $year.'-'.$month.'-'.$endday.' 23:59:59';
            $config =& JFactory::getConfig();
            $siteOffset = $config->getValue('config.offset');
            // adjust start finish date by site offset
            $start = JFactory::getDate($startdate, $siteOffset); 
            $start = $start->toMySQL();
            $finish = JFactory::getDate($finishdate, $siteOffset); 
            $finish = $finish->toMySQL();
            $where[] = " (#__pistudies.study_date >= ".$db->quote($start)." AND #__pistudies.study_date <= ".$db->quote($finish).")";
        }

    }
    elseif ($datesel == 1) 
    {
        if (count($dateselection) > 1)
            {
                $dopening = '(';
                $dclosing = ')';
            }
            else {
                $dopening = null; $dclosing = null;
            }
            if (is_array($dateselection))
            {
                foreach ($dateselection AS $dl)
                {
                    $startdate = (int) $dl.'-01-01 00:00:00';
                    $finishdate = (int) $dl.'-12-31 23:59:59';
                    $config =& JFactory::getConfig();
                    $siteOffset = $config->getValue('config.offset');
                    // adjust study date by site offset
                    $start = JFactory::getDate($startdate, $siteOffset); 
                    $start = $start->toMySQL();
                    $finish = JFactory::getDate($finishdate, $siteOffset); 
                    $finish = $finish->toMySQL();
                    $dlist[] = " ".$dopening."#__pistudies.study_date >= ".$db->quote($start)." AND #__pistudies.study_date <= ".$db->quote($finish).$dclosing;
                }
            }
            else {$dlist[] = "#__pistudies.study_date = ".$db->quote('0000-00-00 00:00:00');}
            $where[] = '('. ( count( $dlist ) ? implode( ' OR ', $dlist ) : '' ) .')';
    }
if ($filter_asmedia > 0)
{
    $where[] = ' #__pistudies.asmedia = '.$filter_asmedia;
}
$where[] = ' #__pistudies.published = 1';
$layout = JRequest::getVar('layout', '');
if ($layout != 'series' && $layout != 'teacher' && $layout != 'media')
{$where[] = ' #__pistudies.studylist = 1';}
$groups = implode(',', $user->authorisedLevels());
$where[] = ' (#__pistudies.access IN ('.$groups.') OR #__pistudies.access = 0)';
$where[] = ' (#__pistudies.saccess IN ('.$groups.') OR #__pistudies.saccess = 0)';
$where[] = ' (#__pistudies.minaccess IN ('.$groups.') OR #__pistudies.minaccess = 0)';
$where[] = ' #__pistudies.language IN ('.$db->quote($language).','.$db->quote('*').')';
$where[] = '(#__pistudies.publish_up = '.$db->Quote($nullDate).' OR #__pistudies.publish_up <= '.$db->Quote($now).')';
$where[] = '(#__pistudies.publish_down = '.$db->Quote($nullDate).' OR #__pistudies.publish_down >= '.$db->Quote($now).')';
$where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
return $where;
}

/**
	 * Method to filter values
	 *
	 * @return	array
	 */

function filtervalues()
{
    $app = JFactory::getApplication();
    $option = 'com_preachit';
    $checkvar = JRequest::getInt('checkvar', 0);
    $item = JRequest::getInt('Itemid', '');
    $ajax = JRequest::getVar('ajax', '');

    if ($checkvar && $checkvar == $item || $ajax)
    { 
    if (JRequest::getInt('book', 0) > 0)
    {
        $filter->book = JRequest::getInt('book', 0);
    }
    else {
        $filter->book = $app->getUserStateFromRequest( $option.'filter_book', 'filter_book',0, 'int' );
    }
    if (JRequest::getInt('teacher', 0) > 0)
    {
        $filter->teacher = JRequest::getInt('teacher', 0);
    }
    else {$filter->teacher = $app->getUserStateFromRequest( $option.'filter_teacher', 'filter_teacher',  0, 'int' );}
    if (JRequest::getInt('series', 0) > 0)
    {
        $filter->series = JRequest::getInt('series', 0);
    }
    else {$filter->series = $app->getUserStateFromRequest( $option.'filter_series', 'filter_series', 0, 'int' );}
    if (JRequest::getInt('ministry', 0) > 0)
    {
        $filter->ministry = JRequest::getInt('ministry', 0);
    }
    else {$filter->ministry = $app->getUserStateFromRequest( $option.'filter_ministry', 'filter_ministry', 0, 'int' );}
    if (JRequest::getInt('year', 0) > 0)
    {
        $filter->year = JRequest::getInt('year', 0);
        if (JRequest::getInt('month', 0) > 0 && JRequest::getInt('month', 0) <= 12)
        {
            $filter->year = JRequest::getInt('month', 0).$filter->year;
        }
    }
    else {
        $filter->year = $app->getUserStateFromRequest( $option.'filter_year', 'filter_year', 0, 'int' );
    }
    if (JRequest::getVar('tag', null) != null)
    {
        $filter->tag = JRequest::getVar('tag', null);
    }
    else {
        $filter->tag = $app->getUserStateFromRequest( $option.'filter_tag', 'filter_tag',null, 'string' );
    }
        $filter->orders = $app->getUserStateFromRequest( $option.'filter_orders', 'filter_orders', 'DESC', 'word' );
        $filter->asmedia = JRequest::getInt('asmedia', 0);
        $filter->chapter = JRequest::getInt('ch', 0);
    }
    else { 
            $filter->book = JRequest::getInt('book', 0);
            $filter->teacher = JRequest::getInt('teacher', 0);
            $filter->series = JRequest::getInt('series', 0);
            $filter->ministry = JRequest::getInt('ministry', 0);
            if (JRequest::getInt('year', 0) > 0)
            {
                $filter->year = JRequest::getInt('year', 0);
                if (JRequest::getInt('month', 0) > 0 && JRequest::getInt('month', 0) <= 12)
                {
                    $filter->year = JRequest::getInt('month', 0).$filter->year;
                }
            }
            else {$filter->year = 0;}
            $filter->tag = JRequest::getVar('tag', null);
            $filter->asmedia = JRequest::getInt('asmedia', 0);
            $filter->chapter = JRequest::getInt('ch', 0);
    }
    return $filter;
}

/**
     * Method to get book filter list
     * @param array $lists info to put in the list
     * @param array $filter filter settings
     * @param unknown_type $params component params
     * @return    string
     */
function getbooklist($lists, $filter, $params)
{
$db =& JFactory::getDBO();
$pionchange = PIHelperstudylist::listonchange($params);
//Book list
$selectbook = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_BOOK')),
);
$booklist         = array_merge( $selectbook, $lists );
return JHTML::_('select.genericList', $booklist, 'filter_book', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->book );
}

/**
     * Method to get teacher details for the filter list
     * @param unknown_type $params component params
     * @param unknown_type $params component menu params
     * @return    array
     */

function getteacherarray($params, $menuparams)
{
    $db =& JFactory::getDBO();
    $list = array();
    $tids = array();
    $language = JFactory::getLanguage()->getTag();
    $twhere = PIHelperstudylist::wherevalue(null, null, null, null, null, null, null, null, $menuparams);
    $query = 'SELECT DISTINCT #__pistudies.teacher AS teacher FROM #__pistudies '. $twhere;
    $db->setQuery($query);
    $teachers = $db->loadObjectList(); 
    
    foreach ($teachers AS $teach)
    {
        $tea = array();
        $tea = explode(',', $teach->teacher);
        foreach ($tea AS $t)
        {
            if (intVal($t) > 0)
            {$tids[] = 'id = '.intVal($t);}
        }
    }
    if (count($tids) > 0)
    {
        $teawhere =  ' WHERE ('. ( count( $tids ) ? implode( ' OR ', $tids ) : '' ) .') AND published = 1 AND language IN ('.$db->quote($language).','.$db->quote('*').')';
        $query = 'SELECT id AS value, teacher_name AS text, lastname AS text2 FROM #__piteachers'. $teawhere.' ORDER BY lastname, teacher_name';
        $db->setQuery($query);
        $list = $db->loadObjectList();
    }
    
    return $list;
}

/**
     * Method to get teacher filter list
     * @param array $lists info to put in the list
     * @param array $filter filter settings
     * @param unknown_type $params component params
     * @return    string
     */
function getteacherlist($lists, $filter, $params)
{
$pionchange = PIHelperstudylist::listonchange($params);
$i = 0;
$list = null;
foreach($lists as $tlist) 
 {
    if ($tlist->text != '')
    {$name = $tlist->text.' '.$tlist->text2;}
    else {$name = $tlist->text2;}
     $list[$i]->value = $tlist->value;
     $list[$i]->text = $name; $i++;}
// teacher list
$selectteach = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_TEACHER')),
);
if (is_array($list))
{$teacherlist         = array_merge( $selectteach, $list );}
else {$teacherlist = $selectteach;}
return JHTML::_('select.genericList', $teacherlist, 'filter_teacher', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->teacher );
}

/**
     * Method to get series details for the filter list
     * @param unknown_type $params component params
     * @param unknown_type $params component menu params
     * @return    array
     */

function getseriesarray($params, $menuparams)
{
    $db =& JFactory::getDBO();
    $swhere = PIHelperstudylist::wherevalue(null, null, null, null, null, null, null, null, $menuparams);
    $swhere .= ' AND #__pistudies.series != 0 AND #__piseries.published = 1 AND #__piseries.series_name != ""';
    $query = 'SELECT DISTINCT #__piseries.id AS value, #__piseries.series_name AS text FROM #__pistudies'
    .' LEFT JOIN #__piseries ON #__pistudies.series = #__piseries.id'
    .' '. $swhere.' ORDER BY #__piseries.series_name';
    $db->setQuery($query);
    $series = $db->loadObjectList();
    return $series;
}

/**
     * Method to get series filter list
     * @param array $lists info to put in the list
     * @param array $filter filter settings
     * @param unknown_type $params component params
     * @return    string
     */
function getserieslist($lists, $filter, $params)
{
$pionchange = PIHelperstudylist::listonchange($params);
//series list
$selectseries = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_SERIES')),
);
if (is_array($lists))
{$serieslist = array_merge( $selectseries, $lists );}
else {$serieslist = $selectseries;}
return JHTML::_('select.genericList', $serieslist, 'filter_series', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->series );
}

/**
     * Method to get ministry details for the filter list
     * @param unknown_type $params component params
     * @param unknown_type $params component menu params
     * @return    array
     */

function getministryarray($params, $menuparams)
{
    $db =& JFactory::getDBO();
    $list = array();
    $mids = array();
    $language = JFactory::getLanguage()->getTag();
    $mwhere = PIHelperstudylist::wherevalue(null, null, null, null, null, null, null, null, $menuparams);
    $query = 'SELECT DISTINCT #__pistudies.ministry AS ministry FROM #__pistudies '. $mwhere;
    $db->setQuery($query);
    $ministries = $db->loadObjectList(); 
    
    foreach ($ministries AS $minis)
    {
        $min = array();
        $min = explode(',', $minis->ministry);
        foreach ($min AS $m)
        {
            if (intVal($m) > 0)
            {$mids[] = 'id = '.intVal($m);}
        }
    }
    if (count($mids) > 0)
    {
        $minwhere =  ' WHERE ('. ( count( $mids ) ? implode( ' OR ', $mids ) : '' ) .') AND published = 1 AND language IN ('.$db->quote($language).','.$db->quote('*').')';
        $query = 'SELECT id AS value, ministry_name AS text FROM #__piministry'. $minwhere.' ORDER BY ministry_name';
        $db->setQuery($query);
        $list = $db->loadObjectList();
    }
    return $list;
    
}

/**
     * Method to get ministry filter list
     * @param array $lists info to put in the list
     * @param array $filter filter settings
     * @param unknown_type $params component params
     * @return    string
     */
function getministrylist($lists, $filter, $params)
{
$pionchange = PIHelperstudylist::listonchange($params);
$selectministry = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_MINISTRY')),
);
if (is_array($lists))
{$ministrylist = array_merge( $selectministry, $lists );}
else {$ministrylist = $selectministry;}
return JHTML::_('select.genericList', $ministrylist, 'filter_ministry', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->ministry );
}

/**
     * Method to get ministry details for the filter list
     * @param unknown_type $params component params
     * @param unknown_type $params component menu params
     * @return    array
     */

function getyeararray($params, $menuparams)
{
    $db =& JFactory::getDBO();
    $language = JFactory::getLanguage()->getTag();
    $datesel = $menuparams->get('datesel', 0);
    $dateselection = $menuparams->get('dateselect');
    $dwhere = PIHelperstudylist::wherevalue(null, null, null, null, null, null, null, null, $menuparams);
    $dwhere .= ' AND study_date != '. $db->quote("0000-00-00 00:00:00");
    $datelist = PIHelperstudylist::getdatelistsetting($params);
    if ($datelist == 2)
    {
        $query = " SELECT DISTINCT date_format(study_date, '%Y') AS value, date_format(study_date, '%Y') AS text "
        . ' FROM #__pistudies'
        . $dwhere
        . ' ORDER BY value DESC';
        $db->setQuery( $query );
        $studyyear = $db->loadObjectList();
    }
    else {
        $query = " SELECT DISTINCT date_format(study_date, '%m%Y') AS value, date_format(study_date, '%b, %Y') AS text "
        . ' FROM #__pistudies '
        . $dwhere
        . ' ORDER BY study_date DESC';
        $db->setQuery( $query );
        $studyyear = $db->loadObjectList();
    }
    return $studyyear;
}

/**
     * Method to get date filter list
     * @param array $lists info to put in the list
     * @param array $filter filter settings
     * @param unknown_type $params component params
     * @return    string
     */
function getyearlist($lists, $filter, $params)
{
$pionchange = PIHelperstudylist::listonchange($params);
$datelist = PIHelperstudylist::getdatelistsetting($params);
if ($datelist == 2)
{
    //year list
    $selectyears = array(
    array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_YEAR')),
    );
    $yearslist = array_merge( $selectyears, $lists );
    return JHTML::_('select.genericList', $yearslist, 'filter_year', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->year );
}
else
{
    $i=0;
    $dformat = 'F Y';
    $format = 'F, Y';
    $dddate = array();
    foreach ($lists AS $d)
    {
        $d->text = str_replace(',', '', $d->text);
        $month = date($dformat, strtotime($d->text) ); 
        $dddate[$i]->text = JHTML::Date('15th '.$month, $format );
        $dddate[$i]->value = $d->value;
        $i++;
    }
    $selectyears = array(
    array('value' => '', 'text' => JText::_('COM_PREACHIT_LIST_DATE')),
    );
    $yearslist = array_merge( $selectyears, $dddate );
    return JHTML::_('select.genericList', $yearslist, 'filter_year', 'class="inputbox pidropdown" size="1" onchange="'.$pionchange.'"', 'value', 'text', $filter->year );
}
}

/**
     * Method to get datelist setting
     * @param unknown_type @params template component params
     * @return    string
     */

function getdatelistsetting($params)
{
    $date = JRequest::getVar('year', 0);
    if ($date > 0 && strlen($date == 4))
    {$datelist = 2;}
    elseif ($date > 0 && strlen($date > 4))
    {$datelist = 1;}
    else {$datelist = $params->get('datelist', 1);}
    return $datelist;
}

/**
     * Method to get js onchange command for lists
     * @param unknown_type @params template component params
     * @return    string
     */
function listonchange($params)
{
if ($params->get('ajaxrefresh', 0) == 1)
{$pionchange = "pifajaxbuildurl()";}
else {$pionchange = "this.form.submit()";}
return $pionchange;
}

}
?>