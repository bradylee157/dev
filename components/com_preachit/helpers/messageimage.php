<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('joomla.filesystem.file');
jimport('teweb.file.urlbuilder');
jimport('teweb.file.functions');
jimport('teweb.media.functions');
jimport('teweb.checks.standard');
class PIHelpermimage{	

/**
     * Method to get series image
     *
     * @param   int $id series id
     * @param   boolean $type determines whether the image needs to be wrapped in a link
     * @param   int $item the item id for the link
     * @param   boolean $popup determines whether the link is to a popup window or not
     * @param   string $imsize size of image small or large
     * @param   boolean $fb determines whether the image should be wrapped in img tags
     *
     * @return    array
     */
     
function messageimage($id, $type, $item, $popup, $imsize, $fb = '')
{
$app = JFactory::getApplication();    
$option = 'com_preachit';
$db =& JFactory::getDBO();
$id = intval($id);
$message =& JTable::getInstance('Studies', 'Table');
$message->load($id);
$resize = PIHelperadditional::allowresize();
//get series picture
$mimagefile = Tewebbuildurl::geturl($message->imagelrg, $message->image_folderlrg, 'pifilepath');
if ($fb == 'fb')
{return $mimagefile;}

if ($message->imagelrg && $message->published == 1) 
{
    if ($resize == 1)
    {
        $image = PIHelpermimage::getimagepath($id, $imsize, $mimagefile);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        $image = JURI::ROOT().$image;
    
        if (!file_exists($imagefile))
        {
            if (Tewebfile::copyfile($mimagefile, $imagefile))
            {
                $size = PIHelperadditional::getimagesize('message', $imsize);
                if (Tewebcheck::checkgd())
                {Tewebmedia::imageresize($size->width, $size->height, $imagefile, $size->qual);}
            }
            else {$image = $mimagefile;} 
            
        }
    }
    else {$image = $mimagefile;} 
    
    $mimage = '<img class="messageimage" src="' . $image . '" alt="' . $message->study_name . '"/>' ;
}
else {$mimage = null;}

if ($type == 0 && $mimage && $id > 0)
{
    $slug = $id.':'.$message->study_alias;
    if ($popup == 1)
    {
    $mimage = "<a href='index.php?option=" . $option . "&tmpl=component&id=" .$slug . "&view=studypopup' onClick='showPopup(this.href);return(false);'>" . $mimage . "</a>";}
    else {
    $mimage = '<a href="'.JRoute::_('index.php?option=' . $option . '&id=' . $slug . '&view=study&Itemid='.$item).'">'.$mimage.'</a>';}
}

return $mimage;
}

/**
     * Method to get image path for message image
     *
     * @param   int $id message id
     * @param   strgin $imsize size of image small or large
     * @param    string $file image filename
     *
     * @return    array
     */

function getimagepath($id, $imsize, $file)
{
    $ext = JFile::getext($file);
    if ($imsize == 'small')
    {$filename = 'pims'.$id;}
    elseif ($imsize == 'medium')
    {$filename = 'pimm'.$id;}
    else {$filename = 'piml'.$id;}
    $image = 'media/preachit/messages/'.$filename.'.'.$ext;
    return $image;
}

}
?>