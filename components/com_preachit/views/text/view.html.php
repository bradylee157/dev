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
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
class PreachitViewtext extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$document =& JFactory::getDocument();
$abspath    = JPATH_SITE;
$id = (int) JRequest::getVar('id', 0);
$study =& JTable::getInstance('Studies', 'Table');
$study->load($id);
$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$layout = JRequest::getVar('layout', '', 'GET', 'STRING');
$user	= JFactory::getUser();

//check that study published
	
if ($study->published != 1) {
JError::raiseError(404, JText::_('COM_PREACHIT_404_ERROR_MESSAGE_NOT_AVAILABLE') );
}

//helpers

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/info-builder.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/mediaplayer.php');

// get params

$params = PIHelperadditional::getPIparams();

//set layout and load template details

$temp = PIHelperadditional::template();
$override = PIHelperadditional::loadtempcssoverride();
$document->addStyleSheet('components/' . $option . '/templates/'.$temp.'/css/preachit.css');
$this->setLayout('print');
$this->_addPath('template', JPATH_COMPONENT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp);

// set breadcrumb
$pathway = & $app->getPathWay();
$new_pathway_item = $study->study_name;
$blink = PIHelperadditional::getmenulink($item);
$pathway->addItem($new_pathway_item, JRoute::_($blink.'&Itemid='.$item));

//get main info

$message = PIHelperinfobuilder::messageinfo($study, $params, 1);
$this->assignRef('message',	$message);

//check user has access

$groups = $user->authorisedLevels();
if (!in_array($params->get('access', 0), $groups) && $params->get('access', 0) != 0 || !in_array($message->access->message, $groups) && $message->access->message != 0 || 
!in_array($message->access->series, $groups) && $message->access->series != 0 || !in_array($message->access->ministry, $groups) && $message->access->ministry != 0)
{Tewebcheck::check403($params);}

//get teacher info

$tinfo =& JTable::getInstance('Teachers', 'Table');
$tinfo->load($study->teacher);
$teacher = PIHelperinfobuilder::teacherinfo($tinfo);
$this->assignRef('teacher',$teacher);

// get series info

$sinfo =& JTable::getInstance('Series', 'Table');
$sinfo->load($study->series);
$series = PIHelperinfobuilder::seriesinfo($sinfo, $params);
$this->assignRef('series',	$series);

//get ministry info

$minfo =& JTable::getInstance('Ministry', 'Table');
$minfo->load($study->ministry);
$ministry = PIHelperinfobuilder::ministryinfo($minfo);
$this->assignRef('ministry',	$ministry);

//set metadate & title

$this->setmetadata($study, $params);

//set facebook image if there is one

$fbimg = $params->get('fbimg', '');
if ($fbimg)
{
$facebookimg = PIHelperadditional::facebookimage($fbimg, $id);
$document->addCustomTag('<link rel="image_src" href="'.$facebookimg.'" />');
}

//set the hits counts

$study->hit($id);

//backlink

$bcklinktext = JText::_($params->get('backlinkmaintext', 'COM_PREACHIT_BACK_BUTTON'));
if ($params->get('backlinkmain', '1') == '1')
{$backlink = PIHelperadditional::getbacklink($bcklinktext);}
else {$backlink = '';}

$this->assignRef('backlink', $backlink);

//powerby notice

$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}

function setmetadata($study, $params)
{
    $app = JFactory::getApplication();
    $document =& JFactory::getDocument();
    $Mparams =& $app->getParams();

    // Set MetaData
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
        if ($this->message->scripture == '')
        {
            $metadescription = strip_tags($study->study_description);
        }
        else 
        {
            $metadescription = strip_tags($this->message->scripture.' - '.$study->study_description);
        }      
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
    
    $params->set('page_title', $study->study_name);
    $title = $study->study_name . ' - '.JText::_('COM_PREACHIT_VIEW_AUDIO') .' '. JText::_('COM_PREACHIT_BY').' '.strip_tags($this->message->teachername);
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
    if ($app->getCfg('MetaAuthor')){
        $document->setMetaData('author', strip_tags($this->message->teachername));
    }

    //set facebook image if there is one

    $fbimg = $params->get('fbimg', '');
    if ($fbimg)
    {
        $facebookimg = PIHelperadditional::facebookimage($fbimg, $id);
        $document->addCustomTag('<link rel="image_src" href="'.$facebookimg.'" />');
    }
}
}