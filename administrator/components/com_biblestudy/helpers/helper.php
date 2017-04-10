<?php

/**
 * Core Bible Study Helper
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

/**
 * Get Admin Settings
 * @return \JRegistry
 */
function getAdminsettings() {
    $db = JFactory::getDBO();
    $db->setQuery("SELECT params FROM #__bsms_admin WHERE id = 1");
    $db->query();
    $compat = $db->loadObject();
    // Convert parameter fields to objects.
    $registry = new JRegistry;
    $registry->loadJSON($compat->params);
    return $registry;
}

/**
 * Get tooltip.
 *
 * @param int $rowid
 * @param string $row
 * @param array $params
 * @param array $admin_params
 * @param string $template
 * @return string
 */
function getTooltip($rowid, $row, $params, $admin_params, $template) {
    $path1 = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
    include_once($path1 . 'elements.php');

    //Tom added the below because tooltip wasn't working as of 6.1.1
    $toolTipArray = array('className' => 'custom', 'showDelay' => '500',
        'hideDelay' => '500', 'fixed' => true,
        'onShow' => "function(tip) {tip.effect('opacity',
 		{duration: 500, wait: false}).start(0,1)}",
        'onHide' => "function(tip) {tip.effect('opacity',
		{duration: 500, wait: false}).start(1,0)}");
    JHTML::_('behavior.tooltip', '.hasTip', $toolTipArray);

    $linktext = '<span class="zoomTip" title="<strong>' . $params->get('tip_title') . '  :: ';
    $tip1 = getElementid($params->get('tip_item1'), $row, $params, $admin_params, $template);
    $tip2 = getElementid($params->get('tip_item2'), $row, $params, $admin_params, $template);
    $tip3 = getElementid($params->get('tip_item3'), $row, $params, $admin_params, $template);
    $tip4 = getElementid($params->get('tip_item4'), $row, $params, $admin_params, $template);
    $tip5 = getElementid($params->get('tip_item5'), $row, $params, $admin_params, $template);
    $test = $params->get('tip_item1');
    $linktext .= '<strong>' . $params->get('tip_item1_title') . '</strong>: ' . $tip1->element . '<br />';
    $linktext .= '<strong>' . $params->get('tip_item2_title') . '</strong>: ' . $tip2->element . '<br /><br />';
    $linktext .= '<strong>' . $params->get('tip_item3_title') . '</strong>: ' . $tip3->element . '<br />';
    $linktext .= '<strong>' . $params->get('tip_item4_title') . '</strong>: ' . $tip4->element . '<br />';
    $linktext .= '<strong>' . $params->get('tip_item5_title') . '</strong>: ' . $tip5->element;
    $linktext .= '">';
    return $linktext;
}

/**
 * Get ShowHide.
 *
 * @return string
 */
function getShowhide() {
    $showhide = '
        function HideContent(d) {
        document.getElementById(d).style.display = "none";
        }
        function ShowContent(d) {
        document.getElementById(d).style.display = "block";
        }
        function ReverseDisplay(d) {
        if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
        else { document.getElementById(d).style.display = "none"; }
        }
        ';

    return $showhide;
}

