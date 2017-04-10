<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$lang = & JFactory::getLanguage();
$lang->load('lib_teweb', JPATH_SITE);
JTable::addincludePath(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'tables');
$controller = JRequest::getCmd('controller', 'cpanel');
jimport('teweb.checks.standard');
jimport('teweb.details.standard');
switch ($controller)
{
default:
$controller = 'cpanel';

case 'cpanel':
case 'studylist':
case 'teacherlist':
case 'serieslist':
case 'filepathlist':
case 'booklist':
case 'taglist':
case 'biblevers':
case 'podcastlist':
case 'podcastpublish':
case 'mimelist':
case 'cssedit':
case 'ministrylist':
case 'mediaplayers':
case 'admin':
case 'comment':
case 'templates':
case 'sharelist':
require_once (JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php');
$controllerName = 'PreachitController'.$controller;
$controller = new $controllerName();
$controller->execute( JRequest::getCmd('task') );
$controller->redirect();
break;
}
