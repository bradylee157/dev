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
class PreachitViewTemplatelist extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$rows =& $this->get('data');

$dateformat = 'F, Y';
$this->assignRef('dateformat', $dateformat);

// get default template

$db =& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('default_template')."
    FROM ".$db->nameQuote('#__pibckadmin')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote(1).";
  ";
$db->setQuery($query);
$default_template = $db->loadResult();

$this->assignRef('default_template',	$default_template);
$pagination =& $this->get('Pagination');
$this->assignRef('rows', $rows);
$this->assignRef('pagination',	$pagination);

		
		jimport('joomla.html.pagination');
		$rowcount = count($rows);
		$pageOrd = new JPagination($rowcount , 0, $rowcount );
		
		$this->assignRef('pageOrd', $pageOrd);
		$this->assign('rowcount', $rowcount);

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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_TEMPLATE_MANAGER_TITLE' ), 'template.png');
if ($user->authorise('core.admin', 'com_preachit')) {
 JToolBarHelper::addNew('addPITemplate', JText::_('COM_PREACHIT_TOOLBAR_ADD'));
JToolBarHelper::makeDefault('deftemp', 'Default');
JToolBarHelper::divider();
JToolBarHelper::custom('copy', 'copy', '', JText::_('Copy'));
JToolBarHelper::deleteList('LIB_TEWEB_TEMPLATE_MANAGER_DELETE_WARNING');
JToolBarHelper::divider();
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::help('pihelp', 'com_preachit');
}
}