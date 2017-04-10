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
class PreachitViewMinistrylist extends JView
{
function display($tpl = null)
{$app = JFactory::getApplication();
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

// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = ucfirst(JText::_('COM_PREACHIT_VIEW_MINISTRYLIST'));
$link = 'index.php?option=com_preachit&view=ministrylist';
$pathway->addItem($new_pathway_item, JRoute::_($link.'&Itemid='.$this->item));

// set listview variable

$this->listview = 'ministrylist';

//set layout and load template details
$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
$this->setLayout('ministrylist');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);

// set page title

$Mparams =& $app->getParams();
$title = null;
$title = $Mparams->get('page_title', '');
if (empty($title)) {
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
$document->setTitle( $title );
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

//get all info
$i = 0;
foreach ($rows as $row)
{
	$ministry[$i] = PIHelperinfobuilder::ministryinfo($row, $params);
    
    //assign study text to use plugins
    //Process the prepare content plugins

    $ministry[$i]->text = $ministry[$i]->description;
    $limitstart = 0;
    $dispatcher    =& JDispatcher::getInstance();
    JPluginHelper::importPlugin('content');
    $results = $dispatcher->trigger('onContentPrepare', array ('com_preachit.article', & $ministry[$i], & $params, $limitstart));
    $ministry[$i]->description = $ministry[$i]->text;
    unset($ministry[$i]->text);
    
	$i++;
}
$this->assignRef('ministry',	$ministry);

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}
}

