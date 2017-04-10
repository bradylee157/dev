<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PIHelpermessageinfo{

/**
     * Method to get messagename with link
     * @param string $name name of message
     * @param string $slug slug for message url
     * @param boolean $audio audio link on/off
     * @param boolean $video video link on/off
     * @param boolean $text text link on/off
     * @param boolean $popup popup window link on/off
     * @param int $item Itemid for url
     * @return   string
     */   
    
function messagename($name, $slug, $view, $audio, $video, $text, $popup, $item)
{
if ($view == 1)
{$studyname = htmlspecialchars($name);	}
elseif ($view == 0 && $popup == 1)
{$studyname = "<a href='index.php?option=com_preachit&tmpl=component&id=" .$slug . "&view=studypopup' onClick='showPopup(this.href);return(false);'>" . htmlspecialchars($name) . "</a>";}
else
{$studyname = '<a href = "' . JRoute::_('index.php?option=com_preachit&id=' . $slug . '&view=study&Itemid='.$item) . '" >' . htmlspecialchars($name) . '</a>';}

return $studyname;
}

/**
     * Method to get message link only
     * @param string $slug slug for message url
     * @param boolean $audio audio link on/off
     * @param boolean $video video link on/off
     * @param boolean $text text link on/off
     * @param boolean $popup popup window link on/off
     * @param int $item Itemid for url
     * @return   string
     */

function messagelink($slug, $audio, $video, $text, $popup, $item)
{
	if ($popup == 0)
	{$link = JRoute::_('index.php?option=com_preachit&id=' . $slug . '&view=study&Itemid='.$item);}
	elseif ($popup == 1)
	{$link = JRoute::_('index.php?option=com_preachit&id=' . $slug . '&view=study&template=component&Itemid='.$item).'" target="blank';}
	else {$link = '';}
	
	return $link;
}

/**
     * Method to get teacher name
     * @param array $rows teacher entry from message form
     * @param int $item Itemid for url
     * @param int $link links setting
     * @return   string
     */

function teacher($rows, $item, $link = 0)
{
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
if ($link == 0)
{
$link = $params->get('teacher_link', 1);}

$i = 1;
$string = '';
$comma = '';
$rows = explode(',', $rows);
$no = count($rows);
if ($no > 0)
{
foreach ($rows AS $teacher)
{

//get info
$db =& JFactory::getDBO();
//get teacher name
$query = "
  SELECT ".$db->nameQuote('teacher_name')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($teacher).";
  ";
$db->setQuery($query);
$firstname = $db->loadResult();

$query = "
  SELECT ".$db->nameQuote('lastname')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($teacher).";
  ";
$db->setQuery($query);
$lastname = $db->loadResult();

if ($firstname)
{$name = $firstname.' '.$lastname;}
else {$name = $lastname;}

//get teacher alias

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('teacher_alias')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($teacher).";
  ";
$db->setQuery($query);
$alias = $db->loadResult();	

// get teacher published

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('published')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($teacher).";
  ";
$db->setQuery($query);
$published = $db->loadResult();	

if ($published == 1)
{

//build slug

$slug = $teacher.':'.$alias;
	
	
if ($teacher == '0' || $teacher == '')
{$entry = '';}
elseif ($link == 0  || $link == 2)
{$entry = htmlspecialchars($name);}
else {
$entry = '<a href="'. JRoute:: _('index.php?option=com_preachit&teacher=' . $slug. '&view=studylist&layout=teacher&Itemid='.$item). '">'.htmlspecialchars($name).'</a>';
}

if ($i > 1 && $i < $no)
{$comma = JText::_('COM_PREACHIT_COMMA_SYMBOL').' ';}
elseif ($i == $no && $no > 1)
{$comma = ' '.JText::_('COM_PREACHIT_AND_SYMBOL').' ';}

$string = $string.$comma.$entry;
$i = $i + 1;
}
else {$no = $no - 1;}
}
}

return $string;
}

/**
     * Method to get series name with link
     * @param int $series id of series
     * @param int $item Itemid for url
     * @param int $link links setting
     * @return   string
     */

function series($series, $item, $link = 0)
{
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
if ($link == 0)
{
$link = $params->get('series_link', 1);}
//get info
$db =& JFactory::getDBO();
//get seriesname
$query = "
  SELECT ".$db->nameQuote('series_name')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
$db->setQuery($query);
$name = $db->loadResult();

//get series alias
$db =& JFactory::getDBO();
$query2 = "
  SELECT ".$db->nameQuote('series_alias')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
$db->setQuery($query2);
$alias = $db->loadResult();	

// get series published

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('published')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
$db->setQuery($query);
$published = $db->loadResult();    

//build slug

$slug = $series.':'.$alias;
	
if ($series == '0' || $published != 1)
{$series = '';}
elseif ($link == 0 || $link == 2)
{$series = htmlspecialchars($name);}
else {
$series = '<a href="'. JRoute:: _('index.php?option=com_preachit&series=' . $slug. '&view=studylist&layout=series&Itemid='.$item). '">'.htmlspecialchars($name).'</a>';
}
return $series;
}

/**
     * Method to get teacher link
     * @param int $teacher id of teacher
     * @param int $item Itemid for url
     * @return   string
     */

function teacherlink($teacher, $item)
{
	//get info
$db =& JFactory::getDBO();

//get teacher alias

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('teacher_alias')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($teacher).";
  ";
$db->setQuery($query);
$alias = $db->loadResult();

$slug = $teacher.':'.$alias;	

$link = JRoute:: _('index.php?option=com_preachit&teacher=' . $slug. '&view=studylist&layout=teacher&Itemid='.$item);

return $link;
}

/**
     * Method to get series link
     * @param int $series id of series
     * @param int $item Itemid for url
     * @return   string
     */

function serieslink($series, $item)
{
	//get info
$db =& JFactory::getDBO();

//get series alias
$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('series_alias')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
$db->setQuery($query);
$alias = $db->loadResult();	

$slug = $series.':'.$alias;

$link = JRoute:: _('index.php?option=com_preachit&series=' . $slug. '&view=studylist&layout=series&Itemid='.$item);

return $link;
}

/**
     * Method to get ministry link
     * @param int $ministry id of ministry
     * @param int $item Itemid for url
     * @return   string
     */

function ministrylink($ministry, $item)
{
	//get info
$db =& JFactory::getDBO();

//get ministry alias
$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('ministry_alias')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ministry).";
  ";
$db->setQuery($query);
$alias = $db->loadResult();	

$slug = $ministry.':'.$alias;

$link = JRoute:: _('index.php?option=com_preachit&ministry=' . $slug. '&view=serieslist&layout=ministry&Itemid='.$item);

return $link;
}

/**
     * Method to get minsitry name
     * @param array $rows ministry entry from message form
     * @param int $item Itemid for url
     * @param int $link links setting
     * @return   string
     */

function ministry($rows, $item, $link = 0)
{
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
if ($link == 0)
{
$link = $params->get('ministry_link', 1);}
//get info
$db =& JFactory::getDBO();	
$i = 1;
$string = '';
$comma = '';
$rows = explode(',', $rows);
$no = count($rows);
if ($no > 0)
{
foreach ($rows AS $ministry)
{
//get ministry name
$query = "
  SELECT ".$db->nameQuote('ministry_name')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ministry).";
  ";
$db->setQuery($query);
$name = $db->loadResult();

//get ministry alias
$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('ministry_alias')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ministry).";
  ";
$db->setQuery($query);
$alias = $db->loadResult();

// get ministry published

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('published')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ministry).";
  ";
$db->setQuery($query);
$published = $db->loadResult();  

$slug = $ministry.':'.$alias;

if ($ministry == '0' || $published != 1)
{$ministry = '';}
elseif ($link == 0)
{$ministry = htmlspecialchars($name);}
else {
$ministry = '<a href="'. JRoute:: _('index.php?option=com_preachit&ministry=' . $slug. '&view=serieslist&layout=ministry&Itemid='.$item). '">'.htmlspecialchars($name).'</a>';
}
if ($i > 1 && $i < $no)
{$comma = JText::_('COM_PREACHIT_COMMA_SYMBOL').' ';}
elseif ($i == $no && $no > 1)
{$comma = ' '.JText::_('COM_PREACHIT_AND_SYMBOL').' ';}

$string = $string.$comma.$ministry;
$i = $i + 1;
}
}
return $string;
}

/**
     * Method to get duration from form enries
     * @param int $id id of message
     * @return   string
     */

function duration($id)
{
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

$format = ($params->get('dur_format', 1));

if ($format == 1)

{

if ($study->dur_hrs > 1)
{$hr = JText::_('COM_PREACHIT_HRS');}
else {$hr = JText::_('COM_PREACHIT_HR');}

if ($study->dur_hrs == 0)
{$h = '';}
else
{$h = $study->dur_hrs . ' '.$hr;}

if ($study->dur_mins == 1)
{$min = JText::_('COM_PREACHIT_MINS');}
else {$min = JText::_('COM_PREACHIT_MINS');}

if ($study->dur_mins == 0 && $study->dur_hrs == 0)
{$m = '';}
elseif ($study->dur_hrs == 0)
{$m = $study->dur_mins . ' '.$min;}
else
{$m = ' ' . $study->dur_mins . ' '.$min;}

if ($study->dur_secs == 1)
{$sec = JText::_('COM_PREACHIT_SEC');}
else {$sec = JText::_('COM_PREACHIT_SECS');}

if ($study->dur_secs == 0)
{$s = '';}
elseif ($study->dur_mins == 0 && $study->dur_hrs == 0)
{$s = $study->dur_secs . ' '.$sec;}
else
{$s = ' ' . $study->dur_secs . ' '.$sec;}

$duration = $h.$m.$s;}


elseif ($format == 2)

{

if ($study->dur_hrs > 1)
{$hr = JText::_('COM_PREACHIT_HRS');}
else {$hr = JText::_('COM_PREACHIT_HR');}

if ($study->dur_hrs == 0)
{$h = '';}
else
{$h = $study->dur_hrs . ' '.$hr;}

if ($study->dur_mins == 1)
{$min = JText::_('COM_PREACHIT_MIN');}
else {$min = JText::_('COM_PREACHIT_MINS');}

if ($study->dur_mins == 0 && $study->dur_hrs == 0)
{$m = '';}
elseif ($study->dur_hrs == 0)
{$m = $study->dur_mins . ' '.$min;}
else
{$m = ' ' . $study->dur_mins . ' '.$min;}

$duration = $h.$m;}


elseif ($format == 3)
{
if ($study->dur_hrs == 0)
{$h = '';}
else
{$h = $study->dur_hrs.':';}

if ($study->dur_mins == 0 && $study->dur_hrs == 0 && $study->dur_secs == 0)
{$m = '';}
elseif ($study->dur_mins == 0 && $study->dur_hrs == 0 && $study->dur_secs > 0)
{$m = '0';}
elseif ($study->dur_mins == 0 && $study->dur_hrs > 0)
{$m = '00';}
elseif ($study->dur_mins > -1 && $study->dur_mins < 10 && $study->dur_hrs > 0)
{$m = '0'.$study->dur_mins;}
else
{$m = $study->dur_mins;}

if ($study->dur_mins == 0 && $study->dur_hrs == 0 && $study->dur_secs == 0)
{$s = '';}
elseif ($study->dur_secs > 0 && $study->dur_secs < 10)
{$s = ':0' . $study->dur_secs;}
elseif ($study->dur_mins == 0 && $study->dur_hrs == 0 && $study->dur_secs > 0 && $study->dur_secs < 10)
{$s = ':0'.$study->dur_secs;}
elseif ($study->dur_mins == 0 && $study->dur_hrs == 0 && $study->dur_secs > 9)
{$s = ':'.$study->dur_secs;}
elseif ($study->dur_secs == 0 && $study->dur_hrs > 0)
{$s = ':00';}
elseif ($study->dur_secs == 0 && $study->dur_mins > 0)
{$s = ':00';}
else
{$s = ':'.$study->dur_secs;}

$duration = $h.$m.$s;}

return $duration;
}

/**
     * Method to get access setting
     * @param int $maccess message access setting
     * @param int $series series id
     * @param int $ministry ministry id
     * @return   string
     */

function access($maccess, $series, $ministry)
{
	
$db =& JFactory::getDBO();	
//get ministry & series access

if ($ministry > 0)
{
$query = "
  SELECT ".$db->nameQuote('access')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ministry).";
  ";
$db->setQuery($query);
$minaccess = $db->loadResult();	
}
else {$minaccess = 0;}	

if ($series > 0)
{
$query1 = "
  SELECT ".$db->nameQuote('access')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
  ";
$db->setQuery($query1);
$saccess = $db->loadResult();
}
else {$saccess = 0;}	

$access->message = $maccess;
$access->ministry = $minaccess;
$access->series = $saccess;
$access->main = max($maccess, $saccess, $minaccess);	
return $access;
	
}

/**
     * Method to get tags with links
     * @param string $tags tag entry in message records
     * @return   string
     */

function gettags($tags)
{
	
	//get rid of whitespace and turn tags into array
	$tagstring = '';
	$tags = trim($tags);
	if ($tags)
	{
	$tagarray = explode(',', $tags);
	
	$no = count($tagarray);
	$i = 0;
	$comma = '';
	
	if ($no > 0)
	{
		foreach ($tagarray AS $tag)
		{
            $tag = trim($tag);
            if ($tag=='') {continue;}
			$taglink = '<a class="taglink" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=tag&tag='.$tag).'">'.$tag.'</a>';

			if ($i > 0)
			{$comma = ', ';}			
			
			$tagstring = $tagstring.$comma.$taglink;
			$i = $i + 1;
		}
	}
	}
	
	return $tagstring;	
}

/**
     * Method to process filesize
     * @param int $filesize filesize in bytes
     * @return   string
     */

function getfilesize($filesize)
{
	$html = '';
	if ($filesize > 0)
	{
	$size = ($filesize / 1024) / 1024;
	$size = number_format($size, 1);

	$html = '<div class="pifilesize">'.$size.' MB</div>';
	}
	
	return $html;
}

/**
     * Method to get series date range
     *
     * @param     int $id index value for the series
     * @param     string $format date format for the JHTM::Date function
     * @return    date
     */

function getseriesdaterange($id, $format)
{
    $date = null;
    $startdate = PIHelpermessageinfo::getseriesdate($id, 'ASC', $format);
    $enddate = PIHelpermessageinfo::getseriesdate($id, 'DESC', $format);
    if ($startdate == $enddate)
    {$date = $startdate;}
    else {$date = $startdate.' - '.$enddate;}
    return $date;
}

/**
     * Method to get start date of series
     *
     * @param     int $id index value for the series
     * @param     string $order order to sort the list
     * @param     string $format date format for the JHTM::Date function
     * @return    date
     */

function getseriesdate($id, $order, $format)
{
    $db = JFactory::getDBO();
    $query = $db->getQuery(true); 
    $query = 'SELECT study_date'
    .' FROM #__pistudies'
    .' WHERE published = 1 AND series = '.$id
    .' ORDER BY study_date '.$order.' LIMIT 1';
    $db->setQuery($query);
    $result = $db->loadObjectList();
    if (is_array($result) && count($result) > 0)
    {
        if ($format != null)
        {$date = JHTML::Date($result[0]->study_date, $format);}
        else {$date = $result[0]->study_date;}
    }
    else {$date = null;}
    return $date;
}

/**
     * Method to get part no in relation to other series sermons
     *
     * @param     int $id index value for the message
     * @param     int $series index value for the series
     * @return    int
     */

function getpartno($id, $series)
{
    $partno = null;
    $db = JFactory::getDBO();
    $query = "
    SELECT ".$db->nameQuote('part')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($series).";
    ";
    $db->setQuery($query);
    $getpart = $db->loadResult(); 
    if ($series > 0 && $getpart == 1)
    {
    $now = gmdate ( 'Y-m-d H:i:s' );
    $nullDate = $db->getNullDate();
    $query = $db->getQuery(true); 
    $query->select('id');
    $query->from('`#__pistudies`');
    $query->where('series = '.$series.' AND published = 1 AND (#__pistudies.publish_up = '.$db->Quote($nullDate).' OR #__pistudies.publish_up <= '.$db->Quote($now).') AND (#__pistudies.publish_down = '.$db->Quote($nullDate).' OR #__pistudies.publish_down >= '.$db->Quote($now).')');
    $query->order('study_date ASC');
    $db->setQuery($query);
    $result = $db->loadResultArray();
    if (is_array($result) && count($result) > 0)
    {$partno = array_search($id, $result) + 1;}
    }
    return $partno;
}

/**
     * Method to get no of sermons in a series
     *
     * @param     int $series index value for the series
     * @return    int
     */

function seriescount($series)
{
    $db = JFactory::getDBO();
    $query='SELECT COUNT(*) FROM #__pistudies WHERE published = "1" AND series = '.$series;
    $db->setQuery($query);
    return intval($db->loadResult());
}

/**
     * Method to get no of sermons in a series
     *
     * @param     int $teacer index value for the teacer
     * @return    int
     */

function teachercount($teacher)
{
    $db = JFactory::getDBO();
    $query='SELECT COUNT(*) FROM #__pistudies WHERE published = "1" AND teacher REGEXP "[[:<:]]' .$teacher .'[[:>:]]"';
    $db->setQuery($query);
    return intval($db->loadResult());
}

/**
     * Method to get no of sermons in a ministry
     *
     * @param     int $series index value for the series
     * @return    int
     */

function ministrycount($ministry)
{
    $db = JFactory::getDBO();
    $query='SELECT COUNT(*) FROM #__pistudies WHERE published = "1" AND ministry REGEXP "[[:<:]]' .$ministry .'[[:>:]]"';
    $db->setQuery($query);
    return intval($db->loadResult());
}

/**
     * Method to get no of series in ministry
     *
     * @param     int $series index value for the series
     * @return    int
     */

function ministryseriescount($ministry)
{
    $db = JFactory::getDBO();
    $query='SELECT COUNT(*) FROM #__piseries WHERE published = "1" AND ministry REGEXP "[[:<:]]' .$ministry .'[[:>:]]"';
    $db->setQuery($query);
    return intval($db->loadResult());
}

}
?>