<?php

/**
 * JView html
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;



/**
 * View class for Podcast
 * @package BibleStudy.Admin
 * @since 7.0.0
 */
class BiblestudyViewPodcast extends JViewLegacy {

    /**
     * Form
     * @var array
     */
    protected $form;

    /**
     * Item
     * @var array
     */
    protected $item;

    /**
     * State
     * @var array
     */
    protected $state;

    /**
     * Defaults
     * @var array
     */
    protected $defaults;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise a JError object.
     *
     * @see     fetch()
     * @since   11.1
     */
    public function display($tpl = null) {
        $this->form = $this->get("Form");
        $this->item = $this->get("Item");
        $this->state = $this->get("State");
        $this->canDo = BibleStudyHelper::getActions($this->item->id, 'podcast');
        $this->setLayout("form");
        $this->addToolbar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    /**
     * Add Toolbar
     * @since 7.0.0
     */
    protected function addToolbar() {
        JRequest::setVar('hidemainmenu', true);
        $isNew = ($this->item->id == 0);
        $title = $isNew ? JText::_('JBS_CMN_NEW') : JText::_('JBS_CMN_EDIT');
        JToolBarHelper::title(JText::_('JBS_CMN_PODCASTS') . ': <small><small>[' . $title . ']</small></small>', 'podcast.png');

        if ($isNew && $this->canDo->get('core.create', 'com_biblestudy')) {
            JToolBarHelper::save('podcast.save');
            JToolBarHelper::apply('podcast.apply');
            JToolBarHelper::save2new('podcast.save2new');
            JToolBarHelper::cancel('podcast.cancel');
        } else {
            if ($this->canDo->get('core.edit', 'com_biblestudy')) {
                JToolBarHelper::apply('podcast.apply');
                JToolBarHelper::save('podcast.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($this->canDo->get('core.create', 'com_biblestudy')) {
                    JToolbarHelper::save2new('podcast.save2new');
                }
            }
            // If checked out, we can still save
            if ($this->canDo->get('core.create', 'com_biblestudy')) {
                JToolBarHelper::save2copy('podcast.save2copy');
            }
            JToolBarHelper::cancel('podcast.cancel', 'JTOOLBAR_CLOSE');
        }
        JToolBarHelper::divider();
        JToolBarHelper::help('biblestudy', true);
    }

    /**
     * Add the page title to browser.
     *
     * @since	7.1.0
     */
    protected function setDocument() {
        $isNew = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('JBS_TITLE_PODCAST_CREATING') : JText::sprintf('JBS_TITLE_PODCAST_EDITING', $this->item->title));
    }

}