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
class PreachitViewTeacheredit extends JView
{
function display($tpl = null)
{
//get the hosts name
jimport('joomla.environment.uri' );
$host = JURI::root();
$document =& JFactory::getDocument();
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.js');
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.queue.js');
$document->addScript($host.'libraries/teweb/file/swfupload/fileprogress.js');
$document->addScript($host.'libraries/teweb/file/swfupload/handlers.js');
$document->addStyleSheet($host.'libraries/teweb/file/swfupload/default.css');
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
jimport('teweb.details.standard');

$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
$id = $cid[0];
$this->assignRef('id', $id);

$user	= JFactory::getUser();
$this->assignRef('user', $user);

$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
$this->assignRef('admin', $admin);

$row =& JTable::getInstance('Teachers', 'Table');
$row->load($id);
$row->checkout($user->id);
$this->assignRef('row', $row);

$db =& JFactory::getDBO();
$db->setQuery('SELECT id AS value, name AS text FROM #__pifilepath WHERE published = 1 ORDER by name');
$teacherimagefolder = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_FOLDER_SELECT')),
);
$imagefolderlist = array_merge( $teacherimagefolder, $db->loadObjectList() );

$idsel = "'SWFUpload_0'";
$this->assignRef('upload_folder', JHTML::_('select.genericList', $imagefolderlist, 'upload_folder', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', '' ));

// upload type selector

$mselector = array(array('value' => '', 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA')),
array('value' => 1, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_IMGLRG')),
);
$this->assignRef('mediaselector', JHTML::_('select.genericList', $mselector, 'mediaselector', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', '' ));

// get the Form
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	

if ($id > 0)
{
if (!$user->authorize('core.edit', 'com_preachit') && !$user->authorize('core.edit.own', 'com_preachit')) 
{Tewebcheck::check403();}
elseif (!$user->authorize('core.edit', 'com_preachit') && $user->id != $row->user)
{Tewebcheck::check403();}
}	
else 
{
if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403();}
}

$this->form = $form;
$this->setLayout('form16');
//get preview images

$image = PIHelpertimage::teacherimage($id, 0, '', 'large');

$this->assignRef('image', $image);
if ($admin->uploadtype == 1)
{
    // flash uploader head js
    $swfUploadHeadJs = Tewebdetails::uploadjs($host, 'com_preachit', 'studyedit', 'upflash');
    //add the javascript to the head of the html document
    $document->addScriptDeclaration($swfUploadHeadJs);
}
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
if ($this->id > 0)
{
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_TEACHERS_EDIT' ), 'teacher.png' );
}
else
{
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_TEACHERS_DETAILS' ), 'teacher.png' );
}
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::divider();
$user    = JFactory::getUser();
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