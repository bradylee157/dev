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
class PreachitViewMediaplayerslist extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

$rows =& $this->get('data');
$pagination =& $this->get('Pagination');
$this->assignRef('rows', $rows);
$this->assignRef('pagination',	$pagination);

//state list

		$filter_state = $app->getUserStateFromRequest( $option.'filter_statemp', 'filter_statemp'. '', 'int' );
$this->assignRef('filter_state',	$filter_state);
$selectstate = Tewebdetails::stateselector();
$this->assignRef('state_list', JHTML::_('select.genericList', $selectstate, 'filter_statemp', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_state ));

$this->addToolbar();
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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_TITLE_MEDIAPLAYERS' ), 'mediaplayer.png');
if ($user->authorise('core.create', 'com_preachit'))  {
JToolBarHelper::addNew();}
if ($user->authorise('core.edit', 'com_preachit'))  {
JToolBarHelper::editList();
}
JToolBarHelper::divider();
if ($user->authorise('core.edit.state', 'com_preachit')) 
{
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
}
JToolBarHelper::divider();
if ($this->filter_state == -2 && $user->authorise('core.delete', 'com_preachit')) {
            JToolBarHelper::deleteList('', 'remove','TE_TOOLBAR_EMPTY_TRASH');
        } else if ($user->authorise('core.edit.state', 'com_preachit')) {
            JToolBarHelper::trash('trash','TE_TOOLBAR_TRASH');
        }
JToolBarHelper::divider();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::help('pihelp', 'com_preachit');
}

}