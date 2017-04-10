<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// load language file
$lang = & JFactory::getLanguage();
$lang->load('lib_teweb', JPATH_SITE);
jimport('teweb.checks.standard');
jimport('teweb.details.standard');
$view = JRequest::getVar('view');
if ($view == 'video') 
{
    JRequest::setVar('view', 'study');
    JRequest::setVar('mode', 'watch');
}
if ($view == 'audio') 
{
    JRequest::setVar('view', 'study');
    JRequest::setVar('mode', 'listen');
}
if ($view == 'text') 
{
    if (JRequest::getVar('layout') == 'print')
    {
        JRequest::setVar('view', 'text');
    }
    else
    {
        JRequest::setVar('view', 'study');
        JRequest::setVar('mode', 'read');
    }
}
if ($view == 'videopopup') 
{
    JRequest::setVar('view', 'studypopup');
    JRequest::setVar('mode', 'watch');
}
if ($view == 'audiopopup') 
{
    JRequest::setVar('view', 'studypopup');
    JRequest::setVar('mode', 'listen');
}
$controller = JRequest::getCmd('controller', 'studylist');
switch ($controller)
{
default:
$controller = 'studylist';
case 'studylist':
case 'studyedit':
case 'podcastlist':
case 'seriesedit':
case 'teacheredit':
require_once (JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php');
$controllerName = 'PreachitController'.$controller;
$controller = new $controllerName();
$controller->execute( JRequest::getCmd('task') );
$controller->redirect();
break;
}
