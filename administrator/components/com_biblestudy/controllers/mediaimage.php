<?php

/**
 * Controller for MediaImage
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Controller for MediaImage
 * @package BibleStudy.Admin
 * @since 7.0.0
 */
class BiblestudyControllerMediaimage extends JControllerForm {

    /**
     * Class constructor.
     *
     * @param   array  $config  A named array of configuration variables.
     *
     * @since	7.0.0
     */
    function __construct($config = array()) {
        parent::__construct($config);
    }

}