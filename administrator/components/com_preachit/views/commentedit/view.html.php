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
class PreachitViewCommentedit extends JView
{
function display($tpl = null)
{
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
$id = $cid[0];
$this->assignRef('id', $id);

$row =& JTable::getInstance('Comment', 'Table');
$row->load($id);
$this->assignRef('row', $row);

// get the Form
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	

$user	= JFactory::getUser();
if ($id > 0)
{
if (!$user->authorize('core.edit', 'com_preachit')) 
{Tewebcheck::check403();}
}
else 
{
if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403();}
}

$this->form = $form;
$this->setLayout('form16');
$this->addToolbar();

//get study name
$db =& JFactory::getDBO();
$query1 = "
  SELECT ".$db->nameQuote('study_id')."
    FROM ".$db->nameQuote('#__picomments')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
$db->setQuery($query1);
$study_id = $db->loadResult();


$query = "
  SELECT ".$db->nameQuote('study_name')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($study_id).";
  ";
$db->setQuery($query);
$studyname = $db->loadResult();
$this->assignRef('studyname', $studyname);
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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_COMMENTS_TITLE_EDIT' ), 'comment.png' );
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::divider();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::preferences('com_preachit', '550', '900');
}
if ($this->id > 0)
{
JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
}
else
{
JToolBarHelper::cancel();
}
JToolBarHelper::divider();
JToolBarHelper::help('pihelp', 'com_preachit');
}

}