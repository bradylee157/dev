<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PreachitViewExtensionlist extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$rows =& $this->get('modules');
$this->assignRef('rows', $rows);
$this->addToolbar();
$this->addlang();
parent::display($tpl);
}

/**
     * Add the page title and toolbar.
     *
     * @since    1.6
     */
protected function addToolbar()
{
$user    = JFactory::getUser();
JToolBarHelper::title( JText::_( 'COM_PREACHIT_EXTENSION_MANAGER_TITLE' ), 'extension.png');
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::help('pihelp', 'com_preachit');
}

/**
     * Add language files
     *
     * @since    1.6
     */
protected function addlang()
{
$lang = & JFactory::getLanguage();
$lang->load('plg_finder_preachit.sys', JPATH_ADMINISTRATOR);
$lang->load('plg_search_preachit.sys', JPATH_ADMINISTRATOR);
$lang->load('plg_content_preachit.sys', JPATH_ADMINISTRATOR);
$lang->load('plg_editors-xtd_preachit.sys', JPATH_ADMINISTRATOR);
$lang->load('plg_system_pipodupdater.sys', JPATH_ADMINISTRATOR);
$lang->load('mod_preachit.sys', JPATH_SITE);
$lang->load('mod_piadmin.sys', JPATH_SITE);
$lang->load('mod_piseries.sys', JPATH_SITE);
$lang->load('mod_piteachers.sys', JPATH_SITE);
$lang->load('mod_pisidebar.sys', JPATH_SITE);
$lang->load('mod_pitags.sys', JPATH_SITE);
$lang->load('mod_pimediaplayer.sys', JPATH_SITE);
}

}