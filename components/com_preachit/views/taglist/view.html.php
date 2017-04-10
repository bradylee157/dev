<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha, LLC
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
class PreachitViewTaglist extends JView
{
function display($tpl = null)
{
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db =& JFactory::getDBO();
$id = (int) JRequest::getVar('id', 0);
$tag = JRequest::getVar('tag', '');
$abspath    = JPATH_SITE;
$document =& JFactory::getDocument();
$uri=& JFactory::getURI();
$this->assignRef('request_url',	$uri->toString());
$user	= JFactory::getUser();
$this->assignRef('user', $user);
$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$this->assignRef('item', $item);

//get helpers

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');

$rows =& $this->get('taglist');
// get info for message list
//set layout and load template details

$this->listview = 'taglist';

$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
$this->setLayout('taglist');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);
$i = 0;
foreach ($rows as $row)
{
    $tags[$i] = PIHelperinfobuilder::taginfo($row);
    $i++;
}
$this->assignRef('tags',    $tags);

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

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set itemid for ajax

PIHelperadditional::ajaxitemid($item);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}
}