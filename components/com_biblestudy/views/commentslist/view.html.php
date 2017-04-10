<?php

/**
 * CommentsList JView
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;
require_once (JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'biblestudy.admin.class.php');
require_once (JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'biblestudy.php');



/**
 * Comment list view class
 * @package BibleStudy.Site
 * @since 7.0.0
 */
class biblestudyViewcommentslist extends JViewLegacy {

    /**
     * Items
     * @var array
     */
    protected $items;

    /**
     * Pagination
     * @var array
     */
    protected $pagination;

    /**
     * State
     * @var array
     */
    protected $state;

    /**
     * Display function
     * @param string $tpl
     * @return boolean
     */
    public function display($tpl = null) {
        $this->canDo = BibleStudyHelper::getActions('', 'commentsedit');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        //Check for errors
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::base() . 'administrator/templates/system/css/system.css');
        $document->addStyleSheet(JURI::base() . 'administrator/templates/bluestork/css/template.css');
        //Load the Admin settings
        $this->loadHelper('params');
        $this->admin = BsmHelper::getAdmin($issite = true);

        //check permissions to enter studies
        if (!$this->canDo->get('core.edit')) {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }
        $this->setLayout('form');

        parent::display($tpl);
    }

}