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
// load language file
$lang = & JFactory::getLanguage();
$lang->load('com_preachit', JPATH_ADMINISTRATOR);
class PreachitViewPodcastlist extends JView
{
function display($tpl = null)
{	$app = JFactory::getApplication();
 	$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
$rows =& $this->get('data');
$this->assignRef('rows', $rows);
$pagination =& $this->get('Pagination');
$this->assignRef('pagination', $pagination);
$document =& JFactory::getDocument();
$document->addStyleSheet('components/' . $option . '/assets/css/preachit.css');
$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$this->assignRef('item', $item);

//powerby notice & Jversion

require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
$powered_by = PIHelperadditional::powered();

$this->assignRef('powered_by', $powered_by);

// get messages

$msg = JRequest::getVar('msg', '');
$err = JRequest::getVar('err', '');
if ($msg && !$err)
{
$msg = '<div class="alert">'.$msg.'</div>';
}
elseif ($msg && $err == 1)
{
$msg = '<div class="alert-neg">'.$msg.'</div>';
}
$this->assignRef('msg', $msg);

// get params

$params = PIHelperadditional::getPIparams();

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}
}

