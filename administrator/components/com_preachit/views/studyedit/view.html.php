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
class PreachitViewStudyedit extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
JHTML::_('behavior.modal');

//get the hosts name
jimport('joomla.environment.uri' );
$host = JURI::root();
 
$document =& JFactory::getDocument();
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.js');
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.queue.js');
$document->addScript($host.'libraries/teweb/file/swfupload/fileprogress.js');
$document->addScript($host.'libraries/teweb/file/swfupload/handlers.js');
$document->addScript($host.'libraries/teweb/scripts/autocomplete/Autocompleter.js');
$document->addScript($host.'libraries/teweb/scripts/autocomplete/Autocompleter.Local.js');
$document->addScript($host.'libraries/teweb/scripts/autocomplete/Observer.js');
$document->addStyleSheet($host.'libraries/teweb/file/swfupload/default.css');
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');
$document->addStyleSheet($host.'libraries/teweb/scripts/autocomplete/Autocompleter.css');
$db =& JFactory::getDBO();

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/messageimage.php');
jimport('teweb.details.standard');

$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
$id = $cid[0];
$this->assignRef('id', $id);

$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
$this->assignRef('admin', $admin);

$user	= JFactory::getUser();
$this->assignRef('user', $user);

$row =& JTable::getInstance('Studies', 'Table');
$row->load($id);
$row->checkout($user->id);
$this->assignRef('row', $row);

//folder lists
$db->setQuery('SELECT id AS value, name AS text FROM #__pifilepath WHERE published = 1 ORDER by name');
$folder = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_FOLDER_SELECT')),
);
$folderlist = array_merge( $folder, $db->loadObjectList() );
$idsel = "'SWFUpload_0'";
$this->assignRef('upload_folder', JHTML::_('select.genericList', $folderlist, 'upload_folder', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', $admin->upload_folder ));

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


// image selector list

$iselector = array(
array('value' => 1, 'text' => JText::_('Small')),
array('value' => 2, 'text' => JText::_('Medium')),
array('value' => 3, 'text' => JText::_('Large')),
);

$this->assignRef('imageselector', JHTML::_('select.genericList', $iselector, 'imageselector', 'class="inputbox"'. '', 'value', 'text', 1 ));


// upload type selector

$mselector = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA')),
array('value' => 1, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_AUDIO')),
array('value' => 2, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_VIDEO')),
array('value' => 7, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_ADD_DOWN')),
array('value' => 3, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_NOTES')),
array('value' => 8, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_SLIDES')),
array('value' => 4, 'text' => JText::_('COM_PREACHIT_UPLOAD_SEL_IMGLRG')),
);
$this->assignRef('mediaselector', JHTML::_('select.genericList', $mselector, 'mediaselector', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', $admin->upload_selector ));
//get preview images
$image = PIHelpermimage::messageimage($id, 0, '', 0, 'large');
$this->assignRef('image', $image);

if ($admin->uploadtype == 1)
{
    // flash uploader head js
    $swfUploadHeadJs = Tewebdetails::uploadjs($host, 'com_preachit', 'studyedit', 'upflash');
    //add the javascript to the head of the html document
    $document->addScriptDeclaration($swfUploadHeadJs);
}
// get tag list for auto complete
jimport ('teweb.details.tags');
$tags = Tewebtags::gettags('#__pistudies', 'ASC', 'name');
$taglist = null;
$i = 0;
foreach ($tags AS $tag)
{
    if ($i != 0)
    {$comma = ',';} else {$comma = null;}
    $taglist .= $comma."'".addslashes($tag->name)."'";
    $i++;
}
$this->assignRef('taglist', $taglist);
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
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_MESSAGES_EDIT' ), 'message.png' );
}
else
{
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_MESSAGES_DETAILS' ), 'message.png' );
}
JToolBarHelper::apply('apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('save', 'JTOOLBAR_SAVE');
JToolBarHelper::custom('save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
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
JToolBarHelper::cancel('cancel','JTOOLBAR_CANCEL');
}
JToolBarHelper::divider();
JToolBarHelper::help('pihelp', 'com_preachit');
}

}