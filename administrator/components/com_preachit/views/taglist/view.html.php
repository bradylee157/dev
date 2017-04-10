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
jimport ('teweb.details.tags');
class PreachitViewTaglist extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');

// get data
$rows =& $this->get('data');
$pagination =& $this->get('Pagination');
$this->assignRef('rows', $rows);
$this->assignRef('pagination',    $pagination);

// get order filters

$filter_order = $app->getUserStateFromRequest( $option.'filter_order',        'filter_order',        'count',    'cmd' );
$filter_order_Dir = $app->getUserStateFromRequest( $option.'filter_order_Dir',    'filter_order_Dir',    'DESC' );
$lists['order_Dir'] = $filter_order_Dir;
$lists['order'] = $filter_order;
$this->assignRef('lists', $lists);

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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_TITLE_TAGS' ), 'tag.png');
if ($user->authorise('core.edit', 'com_preachit'))  {
JToolBarHelper::editList();
}
JToolBarHelper::divider();
if ($user->authorise('core.delete', 'com_preachit')) {
JToolBarHelper::deleteList('', 'remove','TE_TOOLBAR_DELETE');
}
JToolBarHelper::divider();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::help('pihelp', 'com_preachit');
}

}