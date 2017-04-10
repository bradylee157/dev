<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelpereditlinks{

/**
     * Method check if user can have access to edit links
     * @param int $userid id for the user
     * @return    boolean
     */    

function checkuser($userid)
{

	$user =& JFactory::getUser();
	$allow = false;
	if ($user->authorize('core.edit', 'com_preachit'))
		{ $allow = true;}
	if ($user->authorize('core.edit.own', 'com_preachit') && $user->id == $userid)
	   { $allow = true;}

return $allow;
}

/**
     * Method to get message edit link
     * @param int $id message id
     * @param int $userid id for the user
     * @return    string
     */  

function editlink($id, $userid)
{	
$option = 'com_preachit';
$params = PIHelperadditional::getPIparams();
$link = $params->get('edit_link', 1);
$allow = PIHelpereditlinks::checkuser($userid);

if ($allow && $link == 1)
{
$href = JRoute::_( 'index.php?option=' . $option . '&tmpl=component&layout=modal&view=studyedit&id='. $id);
$js = "SqueezeBox.setContent( 'iframe', this.href );";
$editlink = '<a  class="pilink" href="' . $href . '" onclick="'.$js.' return false;">'.JText::_('COM_PREACHIT_EDIT').'</a>';
}
else {$editlink = '';}

return $editlink;
}

/**
     * Method to get teacher edit link
     * @param int $id teacher id
     * @param int $userid id for the user
     * @return    string
     */ 

function teacheredit($id, $userid)
{
$option = 'com_preachit';
$params = PIHelperadditional::getPIparams();
$link = $params->get('edit_link', 1);
$allow = PIHelpereditlinks::checkuser($userid);

if ($allow && $link == 1)
{
$href = JRoute::_( 'index.php?option=' . $option . '&tmpl=component&layout=modal&view=teacheredit&id='. $id);
$js = "SqueezeBox.setContent( 'iframe', this.href );";
$editlink = '<a  class="pilink" href="' . $href . '" onclick="'.$js.' return false;">'.JText::_('COM_PREACHIT_EDIT').'</a>';
}
else {$editlink = '';}

return $editlink;
}

/**
     * Method to get series edit link
     * @param int $id series id
     * @param int $userid id for the user
     * @return    string
     */ 

function seriesedit($id, $userid)
{
$option = 'com_preachit';
$params = PIHelperadditional::getPIparams();
$link = $params->get('edit_link', 1);
$allow = PIHelpereditlinks::checkuser($userid);

if ($allow && $link == 1)
{
$href = JRoute::_( 'index.php?option=' . $option . '&tmpl=component&layout=modal&view=seriesedit&id='. $id);
$js = "SqueezeBox.setContent( 'iframe', this.href );";
$editlink = '<a  class="pilink" href="' . $href . '" onclick="'.$js.' return false;">'.JText::_('COM_PREACHIT_EDIT').'</a>';
}
else {$editlink = '';}

return $editlink;
}


}
?>