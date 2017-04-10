<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');
$popup = $params->get('popup');
$document =& JFactory::getDocument();

$document->addStyleSheet('modules/mod_preachit/assets/modstyle.css');
if ($popup == '1')
{$document->addScript('components/com_preachit/assets/js/popup.js');}
$list = modPreachitHelper::getStudy($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$path = JModuleHelper::getLayoutPath('mod_preachit', $params->get('layout', 'default'));

if (file_exists($path)) {
	require($path);
}