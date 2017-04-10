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
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

class PIHelperminimage{

/**
     * Method to get ministry image
     *
     * @param   int $id ministry id
     * @param   boolean $link determines whether the image needs to be wrapped in a link
     * @param   int $item the item id for the link
     * @param   string $imsize size of image small or large
     * @param   boolean $fb determines whether the image should be wrapped in img tags
     *
     * @return    array
     */    

function ministryimage($id, $link, $item, $imsize, $fb = '')
{
$app = JFactory::getApplication();    
$option = 'com_preachit';
$db =& JFactory::getDBO();
$id = intval($id);
$ministry =& JTable::getInstance('Ministry', 'Table');
$ministry->load($id);
$resize = PIHelperadditional::allowresize();
//get series picture
$mimagefile = Tewebbuildurl::geturl($ministry->ministry_image_lrg, $ministry->image_folderlrg, 'pifilepath');
if ($fb == 'fb')
{return $mimagefile;}

if ($ministry->ministry_image_lrg == '' || $ministry->published != 1) 
{
    $mimage = PIHelperminimage::getdefault($ministry, $imsize);
}
else 
{
    if ($resize == 1)
    {
        $image = PIHelperminimage::getimagepath($id, $imsize, $mimagefile);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        $image = JURI::ROOT().$image;
    
        if (!file_exists($imagefile))
        {
            if (Tewebfile::copyfile($mimagefile, $imagefile))
            {
                $size = PIHelperadditional::getimagesize('ministry', $imsize);
                if (Tewebcheck::checkgd())
                {Tewebmedia::imageresize($size->width, $size->height, $imagefile, $size->qual);}
            }
            else {$image = $mimagefile;}
        } 
    }
    else {$image = $mimagefile;}
    $mimage = '<img class="ministryimage" src="' . $image . '" alt="' . $ministry->ministry_name . '"/>' ;
}

if ($link == 1 && $mimage && $id > 0)
{
    $slug = $id.':'.$ministry->ministry_alias;
    $mimage = '<a href="'.JRoute::_('index.php?option=' . $option . '&ministry=' . $slug . '&view=serieslist&layout=ministry&Itemid='.$item).'">'.$mimage.'</a>';
}

return $mimage;
}

/**
     * Method to trigger the default image function
     *
     * @param   int $minsitry minsitry id
     * @param   strgin $imsize size of image small or large
     *
     * @return    array
     */

function getdefault($ministry, $size)
{
	$admin = & JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	$qual = $admin->imagequal;
	$params = PIHelperadditional::getPIparams();
	if  ($size == 'small')
	{$width = $admin->minimsmw; $height = $admin->minimsmh; $image = 'media/preachit/ministry/default_minsm.jpg';}
    if  ($size == 'medium')
    {$width = $admin->minimmedw; $height = $admin->minimmedh; $image = 'media/preachit/ministry/default_minmed.jpg';}
	if  ($size == 'large')
	{$width = $admin->minimlrgw; $height = $admin->minimlrgh; $image = 'media/preachit/ministry/default_minlrg.jpg';}
	if ($params->get('minimgdef', 1) == 1 && Tewebcheck::checkgd())
	{// create default image	
	$create = PIHelperadditional::createdefault($width, $height, $image, $qual, 'ministry');
	$minimage = '<img class="ministryimage" src="'.JURI::ROOT().$image.'" alt="' . $ministry->ministry_name . '"/>' ;}
	else {$minimage = '';}
	return $minimage;
}

/**
     * Method to get image path for ministry image
     *
     * @param   int $id ministry id
     * @param   strgin $imsize size of image small or large
     * @param    string $file image filename
     *
     * @return    array
     */

function getimagepath($id, $imsize, $file)
{
    $ext = JFile::getext($file);
    if ($imsize == 'small')
    {$filename = 'pmnis'.$id;}
    elseif ($imsize == 'medium')
    {$filename = 'pmnim'.$id;}
    else {$filename = 'pmnil'.$id;}
    $image = 'media/preachit/ministry/'.$filename.'.'.$ext;
    return $image;
}

}
?>