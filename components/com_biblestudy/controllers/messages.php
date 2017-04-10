<?php

/**
 * Controller Messages
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Controller class for Messages
 * @package BibleStudy.Site
 * @since 7.0.0
 */
class biblestudyControllerMessages extends JControllerAdmin {

    /**
     * Proxy for getModel
     *
     * @param string $name    The name of the model
     * @param string $prefix  The prefix for the PHP class name
     * @return JModel
     *
     * @since 7.0.0
     */
    public function &getModel($name = 'message', $prefix = 'biblestudyModel') {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

}