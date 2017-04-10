<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/* +RNJS+ */
/*
// if user hasn't permission, redirect to index.php
$user = &JFactory::getUser();
if(!$user->get('id') || $user->usertype == 'Registered') {
	header('location: index.php');
}
*/
/* -RNJS- */

// Require the base controller
jimport('joomla.application.component.controller');

$controller = JController::getInstance('UAM');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>