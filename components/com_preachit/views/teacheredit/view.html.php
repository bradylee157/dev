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
class PreachitViewTeacheredit extends JView
{
function display($tpl = null)
{
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
//get the hosts name
jimport('joomla.environment.uri' );
$host = JURI::root();$document =& JFactory::getDocument();
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.js');
$document->addScript($host.'libraries/teweb/file/swfupload/swfupload.queue.js');
$document->addScript($host.'libraries/teweb/file/swfupload/fileprogress.js');
$document->addScript($host.'libraries/teweb/file/swfupload/handlers.js');
$document->addStyleSheet($host.'libraries/teweb/file/swfupload/default.css');
$document->addStyleSheet($host.'administrator/templates/bluestork/css/template.css');
$document->addStylesheet($host.'components/com_preachit/assets/css/preachit.css');

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/forms.php');

// get params

$params = PIHelperadditional::getPIparams();

$id = (int) JRequest::getVar('id', 0);
$this->assignRef('id', $id);

$item = JRequest::getVar('Itemid', '', 'GET', 'INT');
$this->assignRef('item', $item);

$user	= JFactory::getUser();
$this->assignRef('user', $user);

$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
$checkin = $admin->checkin;
$this->assignRef('admin', $admin);

$row =& JTable::getInstance('Teachers', 'Table');
$row->load($id);
if ($row->checked_out > 0 && $checkin == 1 && $user->id != $row->checked_out)
{
$errmes = JText::_('COM_PREACHIT_RECORD_CHECKED_OUT');
die($errmes);
}
$row->checkout($user->id);
$this->assignRef('row', $row);

$layout = JRequest::getVar('layout', '');
if ($layout != 'modal')
{$layout = 'form';}
$this->assignRef('layout', $layout);

$db =& JFactory::getDBO();
$db->setQuery('SELECT id AS value, name AS text FROM #__pifilepath WHERE published = 1 ORDER by name');
$teacherimagefolder = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_FOLDER_SELECT')),
);
$imagefolderlist = array_merge( $teacherimagefolder, $db->loadObjectList() );

$idsel = "'SWFUpload_0'";
$this->assignRef('upload_folder', JHTML::_('select.genericList', $imagefolderlist, 'upload_folder', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', '' ));

// upload type selector

$mselector = PIHelperforms::getteachersel(1);
$this->assignRef('mediaselector', JHTML::_('select.genericList', $mselector, 'mediaselector', 'class="inputbox" onchange="showupload('.$idsel.')"'. '', 'value', 'text', '' ));

// hide elements if chosen in admin

$hide = PIHelperforms::hideteacheredit();
$this->assignRef('hide', $hide);

// get the Form
$form = & $this->get('Form');
// get the Data
$data = & $this->get('Data');
// Bind the Data
$form->bind($data);	
      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/teacheredit/tmpl/submitbutton.js');

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
$this->setLayout('modal16');

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

// set Jversion variable to 1.6 for older versions of templates

$this->Jversion = '1.6';

parent::display($tpl);
}
}