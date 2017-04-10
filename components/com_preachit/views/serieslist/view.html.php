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
class PreachitViewSerieslist extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
$app = JFactory::getApplication();
 $option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
$rows =& $this->get('data');
$pagination =& $this->get('Pagination');
$this->assignRef('pagination', $pagination);
$document =& JFactory::getDocument();
$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$this->assignRef('item', $item);
$uri=& JFactory::getURI();
$this->assignRef('request_url',	$uri->toString());
$user	= JFactory::getUser();
$this->assignRef('user', $user);

// load helpers

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');

// get params

$params = PIHelperadditional::getPIparams();

//check user has access

$groups = $user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0)
{Tewebcheck::check403($params);}

// set listview variable

$listview = JRequest::getVar('layout', 'serieslist');
$this->assignRef('listview', $listview);

//set layout and load template details
$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
$this->setLayout('serieslist');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);

//get all info
$i = 0;
foreach ($rows as $row)
{
	$series[$i] = PIHelperinfobuilder::seriesinfo($row, $params, true);
    $i++;
}
$this->assignRef('series',	$series);

// get additional layout based details
if ($listview == 'serieslist')
{$this->setserieslist($params);}
elseif ($listview == 'ministry')
{$this->setministryview($params);}

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}

/**
     * Method to set header and get any variables for straight series list
     * @param unknown_type $params template params
     * @return   none
     */
function setserieslist($params)
{
$document =& JFactory::getDocument();
$app = JFactory::getApplication();
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = ucfirst(JText::_('COM_PREACHIT_VIEW_SERIES'));
$link = 'index.php?option=com_preachit&view=serieslist';
$pathway->addItem($new_pathway_item, JRoute::_($link.'&Itemid='.$this->item));
// set page title
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
     * Method to set header and get any variables for straight ministry list
     * @param unknown_type $params template params
     * @return   none
     */
function setministryview($params)
{
$document =& JFactory::getDocument();
// set page title
$app = JFactory::getApplication();
// get ministry info
$id = (int) JRequest::getVar('ministry', 0);
$ministry =& JTable::getInstance('Ministry', 'Table');
$ministry->load($id);
if ($ministry->published != 1) {
JError::raiseError(404, JText::_('COM_PREACHIT_404_ERROR_MINISTRY_NOT_AVAILABLE') );
}
//set metadate & title
$Mparams =& $app->getParams();
// Set MetaData
    if ($ministry->metadesc)
    {
        $metadescription = $ministry->metadesc;
    } 
    elseif ($Mparams->get('menu-meta_description')) 
    {
        $metadescription = $Mparams->get('menu-meta_description');
    } 
    else 
    {
        $metadescription = strip_tags($ministry->ministry_description);  
    }
    $document->setDescription( $metadescription); 
    
    if ($ministry->metakey)
    {
        $document->setMetadata('keywords', $ministry->metakey);
    } 
    elseif ($Mparams->get('menu-meta_keywords')) 
    {
        $document->setMetadata('keywords', $Mparams->get('menu-meta_keywords'));
    }
    $params->set('page_title', $ministry->ministry_name);
    $title = $ministry->ministry_name;
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

// set breadcrumb
$pathway = & $app->getPathWay();
// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = ucfirst(JText::_('COM_PREACHIT_VIEW_MINISTRY'));
$link = 'index.php?option=com_preachit&view=ministrylist';
$pathway->addItem($new_pathway_item, JRoute::_($link.'&Itemid='.$this->item));
$new_pathway_item = $ministry->ministry_name;
$blink = PIHelperadditional::getmenulink($this->item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$this->item));

// get ministry info

$minfo = PIHelperinfobuilder::ministryinfo($ministry, true);
$this->assignRef('ministry',    $minfo);

//check user has access

$groups = $this->user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0 || !in_array($minfo->access, $groups) && $minfo->access != 0)
{Tewebcheck::check403($params);}

//backlink
$bcklinktext = JText::_($params->get('backlinkministrytext', 'COM_PREACHIT_BACK_BUTTON'));
if ($params->get('backlinkministry', '1') == '1')
{$backlink = PIHelperadditional::getbacklink($bcklinktext);}
else {$backlink = '';}

$this->assignRef('backlink', $backlink);
}

}

