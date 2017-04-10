<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.admin.records');
jimport('teweb.details.tags');
jimport('joomla.application.component.controller');
class PreachitControllerTaglist extends JController
{

function edit()
{
JRequest::setVar('view', 'tagedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get tag details
$original = JRequest::getVar('original', '');
$original = JString::trim($original);
$newtag = JRequest::getVar('tag', '');
$newtag = JString::trim($newtag);
// change tag
$msg = Tewebtags::changetag($original, $newtag, '#__pistudies');
if ($this->getTask() == 'apply')
{
$url = 'index.php?option=' . $option . '&task=edit&controller=taglist&cid[] =' . $newtag;}
else {
$url = 'index.php?option=' . $option . '&controller=taglist';}
$this->setRedirect($url);
}

function remove()
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$msg = Tewebtags::deletetag('#__pistudies');
$this->setRedirect('index.php?option=' . $option . '&controller=taglist');
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'taglist');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
}
}
