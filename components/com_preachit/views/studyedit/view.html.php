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
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('teweb.details.standard');
// load language file
$lang = & JFactory::getLanguage();
$lang->load('com_preachit', JPATH_ADMINISTRATOR);
class PreachitViewStudyedit extends JView
{
function display($tpl = null)
{
JHTML::_( 'behavior.mootools' );
JHTML::_('behavior.modal');
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db =& JFactory::getDBO();

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/forms.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/messageimage.php');

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
$document->addStyleSheet($host.'administrator/templates/bluestork/css/template.css');
$document->addStylesheet($host.'components/com_preachit/assets/css/preachit.css');
$document->addStyleSheet($host.'libraries/teweb/file/swfupload/default.css');
$document->addStyleSheet($host.'libraries/teweb/scripts/autocomplete/Autocompleter.css');

// get params

$params = PIHelperadditional::getPIparams();
 
$db =& JFactory::getDBO();
 
$id = (int) JRequest::getVar('id', 0); 
$this->assignRef('id', $id); 

$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$this->assignRef('item', $item);

$layout = JRequest::getVar('layout', '');
if ($layout != 'modal')
{$layout = 'form';}
$this->assignRef('layout', $layout);

$user	= JFactory::getUser();
$this->assignRef('user', $user);

$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
$checkin = $admin->checkin;
$this->assignRef('admin', $admin);

$row =& JTable::getInstance('Studies', 'Table');
$row->load($id);
if ($row->checked_out > 0 && $checkin == 1 && $user->id != $row->checked_out)
{
$errmes = JText::_('COM_PREACHIT_RECORD_CHECKED_OUT');
die($errmes);
}
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

// upload type selector

$mselector = PIHelperforms::getmessagesel(1);
$this->assignRef('mediaselector', JHTML::_('select.genericList', $mselector, 'mediaselector', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', $admin->upload_selector ));

// hide elements if chosen in admin

$hide = PIHelperforms::hidemessageedit();
$this->assignRef('hide', $hide);

// get the Form
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	

if ($id > 0)
{
if (!$user->authorize('core.edit', 'com_preachit') && !$user->authorize('core.edit.own', 'com_preachit')) 
{Tewebcheck::check403($params);}
elseif (!$user->authorize('core.edit', 'com_preachit') && $user->id != $row->user)
{Tewebcheck::check403($params);}
}	
else 
{
if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403($params);}
}
$this->form = $form;
$this->setLayout('form16');


// image selector list

$iselector = array(
array('value' => 1, 'text' => JText::_('Small')),
array('value' => 2, 'text' => JText::_('Medium')),
array('value' => 3, 'text' => JText::_('Large')),
);

$this->assignRef('imageselector', JHTML::_('select.genericList', $iselector, 'imageselector', 'class="inputbox" '. '', 'value', 'text', 1 ));

if ($admin->uploadtype == 1)
{
    // flash uploader head js
    $swfUploadHeadJs = Tewebdetails::uploadjs($host, 'com_preachit', 'studyedit', 'upflash');
    //add the javascript to the head of the html document
    $document->addScriptDeclaration($swfUploadHeadJs);
}

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

//get preview images
$image = PIHelpermimage::messageimage($id, 0, '', 0, 'large');
$this->assignRef('image', $image);

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

parent::display($tpl);
}
}