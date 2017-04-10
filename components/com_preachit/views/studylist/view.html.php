<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PreachitViewStudylist extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
$rows =& $this->get('data');
$pagination =& $this->get('Pagination');
$this->assignRef('pagination',	$pagination);
$uri=& JFactory::getURI();
$this->assignRef('request_url',	$uri->toString());
$user	= JFactory::getUser();
$this->assignRef('user', $user);
$item = JRequest::getInt('Itemid', '');
$this->assignRef('item', $item);
$db =& JFactory::getDBO();

// load helpers

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/studylist.php');

// get params

$params = PIHelperadditional::getPIparams();

//check user has access

$groups = $user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0)
{Tewebcheck::check403($params);}

// do we need popup script

$popup = $params->get('popup', '0');
if ($popup == '1')
{$document->addScript('components/com_preachit/assets/js/popup.js');}

//set layout and load template details

$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
if ($params->get('jsdropdowns', 0) == 1 && $params->get('ajaxrefresh', 0) == 1)
{
$document->addScript('components/com_preachit/assets/js/piselectajax.js');}
elseif ($params->get('jsdropdowns', 0) == 1 && $params->get('ajaxrefresh', 0) == 0)
{
$document->addScript('components/com_preachit/assets/js/piselect.js');}
if ($params->get('ajaxrefresh', 0) == 1)
{
$document->addScript('components/com_preachit/assets/js/pimessageajax16.js');
$extrajs = PIHelperadditional::getajaxjs();
$document->addScriptDeclaration($extrajs);
}

// set the view and ajax variable for the studylist to know which header to draw in. 
// Ajax variable is for future ajax load of message details

$listview = JRequest::getVar('layout', 'messagelist');
$ajax = JRequest::getVar('ajax', '');
$this->assignRef('listview', $listview);
$this->assignRef('ajax', $ajax);

$this->setLayout('messagelist');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);


//get all info
$i = 0;
foreach ($rows as $row)
{
	$messages[$i] = PIHelperinfobuilder::messageinfo($row, $params, 0);
	$i++;
}
$this->assignRef('messages', $messages);

//assign filter options

$db		=& JFactory::getDBO();
$uri	=& JFactory::getURI();
$filter = PIHelperstudylist::filtervalues();

// get view params to determin lists

$menuparams =& $app->getParams();

// get info for filter lists from database

$books = PIHelperscripture::getbooklist();
$teachers = PIHelperstudylist::getteacherarray($params, $menuparams);
$series = PIHelperstudylist::getseriesarray($params, $menuparams);
$ministry = PIHelperstudylist::getministryarray($params, $menuparams);
$studyyear = PIHelperstudylist::getyeararray($params, $menuparams);

// get filter lists

$study_book = PIHelperstudylist::getbooklist($books, $filter, $params);
$teacher_list = PIHelperstudylist::getteacherlist($teachers, $filter, $params);
$series_list = PIHelperstudylist::getserieslist($series, $filter, $params);
$ministry_list = PIHelperstudylist::getministrylist($ministry, $filter, $params);
$years_list = PIHelperstudylist::getyearlist($studyyear, $filter, $params);
$this->assignRef('study_book', $study_book);
$this->assignRef('teacher_list', $teacher_list);
$this->assignRef('series_list', $series_list);
$this->assignRef('ministry_list', $ministry_list);
$this->assignRef('years_list', $years_list);
			
// set hidden value for javascript dropdown list

$pifbook = PIHelperadditional::setfilter($books, $filter->book);
$pifteach = PIHelperadditional::setfilter($teachers, $filter->teacher);
$pifseries = PIHelperadditional::setfilter($series, $filter->series);
$pifministry = PIHelperadditional::setfilter($ministry, $filter->ministry);
$pifyear = PIHelperadditional::setfilter($studyyear, $filter->year);

$this->assignRef('pifbook', $pifbook);
$this->assignRef('pifteach', $pifteach);
$this->assignRef('pifseries', $pifseries);
$this->assignRef('pifministry', $pifministry);
$this->assignRef('pifyear', $pifyear);

$this->assignRef('filter_book', $filter->book);
$this->assignRef('filter_teacher', $filter->teacher);
$this->assignRef('filter_series', $filter->series);
$this->assignRef('filter_ministry', $filter->ministry);
$this->assignRef('filter_year', substr($filter->year, -4));
$this->assignRef('filter_tag', $filter->tag);
$this->assignRef('filter_media', $filter->asmedia);
$this->assignRef('filter_chapter', $filter->chapter);

// get additional layout based details
if ($listview == 'messagelist')
{$this->setmessagelist($params);}
elseif ($listview == 'teacher')
{$this->setteacherview($params);}
elseif ($listview == 'series')
{$this->setseriesview($params);}
elseif ($listview == 'tag')
{$this->settaglist($params);}
elseif ($listview == 'date')
{$this->setdatelist($params);}
elseif ($listview == 'book')
{$this->setbooklist($params);}
elseif ($listview == 'media')
{$this->setmedialist($params);}

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set itemid for ajax

PIHelperadditional::ajaxitemid($item);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}

/**
     * Method to set header and get any variables for straight message list
     * @param unknown_type $params template params
     * @return   none
     */
function setmessagelist($params)
{
$document =& JFactory::getDocument();
// set page title
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
$title = null;
$title = $Mparams->get('page_title', '');
{if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
if (empty($title)) {
$title = $app->getCfg('sitename');
}
$document->setTitle( $title );}
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }
if ($Mparams->get('menu-meta_description')) 
{
    $document->setDescription($Mparams->get('menu-meta_description'));
} 
if ($Mparams->get('menu-meta_keywords')) 
{
    $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
}
}

/**
     * Method to set header and get any variables for messagelist for single teacher
     * @param unknown_type $params template params
     * @return   none
     */
function setteacherview($params)
{
$document =& JFactory::getDocument();
// get teacher info
$app = JFactory::getApplication();
$id = (int) JRequest::getVar('id', 0);
$teacher =& JTable::getInstance('Teachers', 'Table');
$teacher->load($this->filter_teacher);
$abspath    = JPATH_SITE;
if ($teacher->published != 1) {
JError::raiseError(404, JText::_('COM_PREACHIT_404_ERROR_TEACHER_NOT_AVAILABLE') );
}
    
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = ucfirst(JText::_('COM_PREACHIT_VIEW_TEACHER'));
$tlink = 'index.php?option=com_preachit&view=teacherlist';
$pathway->addItem($new_pathway_item, JRoute::_($tlink.'&Itemid='.$this->item));
$new_pathway_item = $teacher->teacher_name;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));

//set metadate & title
$Mparams =& $app->getParams();
    if ($teacher->metadesc)
    {
        $metadescription = $teacher->metadesc;
    } 
    elseif ($Mparams->get('menu-meta_description')) 
    {
        $metadescription = $Mparams->get('menu-meta_description');
    } 
    else 
    {
        $metadescription = strip_tags($teacher->teacher_description);
    }
    $document->setDescription( $metadescription); 
    
    if ($teacher->metakey)
    {
        $document->setMetadata('keywords', $teacher->metakey);
    } 
    elseif ($Mparams->get('menu-meta_keywords')) 
    {
        $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
    }
$params->set('page_title', $teacher->teacher_name);
$title = $teacher->teacher_name;
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }

//get teacher info 

$tinfo = PIHelperinfobuilder::teacherinfo($teacher, true);
$this->assignRef('teacher', $tinfo);

//backlink

$bcklinktext = JText::_($params->get('backlinkteachertext', 'COM_PREACHIT_BACK_BUTTON'));
if ($params->get('backlinkteacher', '1') == '1')
{$backlink = PIHelperadditional::getbacklink($bcklinktext);}
else {$backlink = '';}

$this->assignRef('backlink', $backlink);
}

/**
     * Method to set header and get any variables for message lsit for single series
     * @param unknown_type $params template params
     * @return   none
     */
function setseriesview($params)
{
$document =& JFactory::getDocument();
// get teacher info
$app = JFactory::getApplication();
$id = (int) JRequest::getVar('id', 0);
$series =& JTable::getInstance('Series', 'Table');
$series->load($this->filter_series);
$abspath    = JPATH_SITE;
if ($series->published != 1) {
JError::raiseError(404, JText::_('COM_PREACHIT_404_ERROR_SERIES_NOT_AVAILABLE') );
}
    
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = ucfirst(JText::_('COM_PREACHIT_VIEW_SERIES'));
$link = 'index.php?option=com_preachit&view=serieslist';
$pathway->addItem($new_pathway_item, JRoute::_($link.'&Itemid='.$this->item));
$new_pathway_item = $series->series_name;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));

//set metadate & title
$Mparams =& $app->getParams();
if ($series->metadesc)
    {
        $metadescription = $series->metadesc;
    } 
    elseif ($Mparams->get('menu-meta_description')) 
    {
        $metadescription = $Mparams->get('menu-meta_description');
    } 
    else 
    {
        $metadescription = strip_tags($series->series_description);
    }
    $document->setDescription( $metadescription); 
    
    if ($series->metakey)
    {
        $document->setMetadata('keywords', $series->metakey);
    } 
    elseif ($Mparams->get('menu-meta_keywords')) 
    {
        $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
    }
$params->set('page_title', $series->series_name);
$title = $series->series_name;
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }

//get series info

$sinfo = PIHelperinfobuilder::seriesinfo($series, $params, true);
$this->assignRef('series',    $sinfo);

//check user has access
$groups = $this->user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0 || !in_array($sinfo->access, $groups) && $sinfo->access != 0)
{Tewebcheck::check403($params);}

//backlink

$bcklinktext = JText::_($params->get('backlinkseriestext', 'COM_PREACHIT_BACK_BUTTON'));
if ($params->get('backlinkseries', '1') == '1')
{$backlink = PIHelperadditional::getbacklink($bcklinktext);}
else {$backlink = '';}

$this->assignRef('backlink', $backlink);
}

/**
     * Method to set header and get any variables for tag based message list
     * @param unknown_type $params template params
     * @return   none
     */
function settaglist($params)
{
$document =& JFactory::getDocument();
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = JText::_('COM_PREACHIT_TAG').' - '.$this->filter_tag;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));    

//set metadate & title

$params->set('page_title', JText::_('COM_PREACHIT_TAG').' - '.$this->filter_tag);
$title = JText::_('COM_PREACHIT_TAG').' - '.$this->filter_tag;
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
$metadescription = $this->filter_tag;
$document->setDescription($metadescription);
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }
if ($Mparams->get('menu-meta_description')) 
{
    $document->setDescription($Mparams->get('menu-meta_description'));
} 
if ($Mparams->get('menu-meta_keywords')) 
{
    $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
}
}

/**
     * Method to set header and get any variables for straight message list
     * @param unknown_type $params template params
     * @return   none
     */
function setbooklist($params)
{
$document =& JFactory::getDocument();
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
$book = PIHelperscripture::getbookname($this->filter_book, 'display_name');
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = JText::_('COM_PREACHIT_BOOK').' - '.$book;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));    

//set metadate & title

$params->set('page_title', JText::_('COM_PREACHIT_BOOK').' - '.$book);
$title = JText::_('COM_PREACHIT_BOOK').' - '.$book;
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
$metadescription = $book;
$document->setDescription($metadescription);
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }
if ($Mparams->get('menu-meta_description')) 
{
    $document->setDescription($Mparams->get('menu-meta_description'));
} 
if ($Mparams->get('menu-meta_keywords')) 
{
    $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
}
}

/**
     * Method to set header and get any variables for straight message list
     * @param unknown_type $params template params
     * @return   none
     */
function setdatelist($params)
{
$document =& JFactory::getDocument();
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = JText::_('COM_PREACHIT_DATE').' - '.$this->filter_year;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));    

//set metadate & title

$params->set('page_title', JText::_('COM_PREACHIT_DATE').' - '.$this->filter_year);
$title = JText::_('COM_PREACHIT_DATE').' - '.$this->filter_year;
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
$metadescription = $this->filter_year;
$document->setDescription($metadescription);
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }
if ($Mparams->get('menu-meta_description')) 
{
    $document->setDescription($Mparams->get('menu-meta_description'));
} 
if ($Mparams->get('menu-meta_keywords')) 
{
    $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
}
}

/**
     * Method to set header and get any variables for the associated media message list
     * @param unknown_type $params template params
     * @return   none
     */
function setmedialist($params)
{
$document =& JFactory::getDocument();
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
// get media info
$id = (int) JRequest::getVar('asmedia', 0);
$study =& JTable::getInstance('Studies', 'Table');
$study->load($id);
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = $study->study_name;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item)); 

//set metadate & title
  if ($study->metadesc)
    {
        $metadescription = $study->metadesc;
    } 
    elseif ($Mparams->get('menu-meta_description')) 
    {
        $metadescription = $Mparams->get('menu-meta_description');
    } 
    else 
    {
        $metadescription = strip_tags($study->study_description);    
    }
    $document->setDescription( $metadescription); 
    
    if ($study->metakey)
    {
        $document->setMetadata('keywords', $study->metakey);
    } 
    elseif ($Mparams->get('menu-meta_keywords')) 
    {
        $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
    }
$params->set('page_title', $study->study_name.' - Assoc Media');
$title = $study->study_name.' - Assoc Media';
// Check for empty title and add site name if param is set
if (empty($title)) {
$title = $app->getCfg('sitename');
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
}
elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));}
$document->setTitle( $title );
if ($app->getCfg('MetaTitle')){
        $document->setMetaData('title', $title);
    }

//get main info

$messagemain = PIHelperinfobuilder::messageinfo($study, $params, 1);
$this->assignRef('messagemain', $messagemain);

//get teacher info

$tinfo =& JTable::getInstance('Teachers', 'Table');
$tinfo->load($study->teacher);
$teacher = PIHelperinfobuilder::teacherinfo($tinfo);
$this->assignRef('teacher', $teacher);

// get series info

$sinfo =& JTable::getInstance('Series', 'Table');
$sinfo->load($study->series);
$series = PIHelperinfobuilder::seriesinfo($sinfo, $params);
$this->assignRef('series',    $series);

//get ministry info

$minfo =& JTable::getInstance('Ministry', 'Table');
$minfo->load($study->ministry);
$ministry = PIHelperinfobuilder::ministryinfo($minfo);
$this->assignRef('ministry',    $ministry);
}

}

