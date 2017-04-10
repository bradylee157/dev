<?php
/**
 * @Module- Preachit Side Bar
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname( __FILE__ ).DS.'helper.php');
$document =& JFactory::getDocument();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$db=& JFactory::getDBO();
$id = JRequest::getInt('id', 0);
$view = JRequest::getString('view');
$menuid = $params->get('menuid', 0);
$css = $params->get('css', 1);
if ($css == 1)
{$document->addStyleSheet('modules/mod_pisidebar/assets/modstyle.css');}
if ($menuid > 0)
{$itemid = $menuid;}
else {
$itemid = JRequest::getInt('Itemid', 0);}

$query = "SELECT ".$db->nameQuote('series')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
$db->setQuery($query);
$series = $db->loadResult();


if ($view == 'video' && $series > 0 || $view == 'audio' && $series > 0 || $view == 'text' && $series > 0 || $view == 'study' && $series > 0)
{
	$html = modpisidebarHelper::buildsidebar($id, $view, $series, $itemid, $params);
}
else {
	$html = modpisidebarHelper::buildmodules($itemid, $params);
	}


$layout = 'default';
$path = JModuleHelper::getLayoutPath('mod_pisidebar', $layout);

if (file_exists($path)) {
	require($path);
}
