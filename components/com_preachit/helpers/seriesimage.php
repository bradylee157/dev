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

class PIHelpersimage{	

/**
     * Method to get series image
     *
     * @param   int $id series id
     * @param   boolean $link determines whether the image needs to be wrapped in a link
     * @param   int $item the item id for the link
     * @param   string $imsize size of image small or large
     * @param   boolean $fb determines whether the image should be wrapped in img tags
     *
     * @return    array
     */
    
function seriesimage($id, $link, $item, $imsize, $fb = '')
{
$app = JFactory::getApplication();	
$option = 'com_preachit';
$db =& JFactory::getDBO();
$id = intval($id);
$series =& JTable::getInstance('Series', 'Table');
$series->load($id);
$resize = PIHelperadditional::allowresize();
//get series picture
$simagefile = Tewebbuildurl::geturl($series->series_image_lrg, $series->image_folderlrg, 'pifilepath');
if ($fb == 'fb')
{return $simagefile;}

if ($series->series_image_lrg == '' || $series->published != 1) 
{
    $simage = PIHelpersimage::getdefault($series, $imsize);
}
else 
{
    if ($resize == 1)
    {
        $image = PIHelpersimage::getimagepath($id, $imsize, $simagefile);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        $image = JURI::ROOT().$image;
    
        if (!file_exists($imagefile))
        {
            if (Tewebfile::copyfile($simagefile, $imagefile))
            {
                $size = PIHelperadditional::getimagesize('series', $imsize);
                if (Tewebcheck::checkgd())
                {Tewebmedia::imageresize($size->width, $size->height, $imagefile, $size->qual);}
            }
            else {$image = $simagefile;}
        } 
    }
    else {$image = $simagefile;}
    
    $simage = '<img class="seriesimage" src="' . $image . '" alt="' . $series->series_name . '"/>' ;
}

if ($link == 1 && $simage && $id > 0)
{
	$slug = $id.':'.$series->series_alias;
	$simage = '<a href="'.JRoute::_('index.php?option=' . $option . '&series=' . $slug . '&view=studylist&layout=series&Itemid='.$item).'">'.$simage.'</a>';
}

return $simage;
}

/**
     * Method to trigger the default image function
     *
     * @param   int $series series id
     * @param   strgin $imsize size of image small or large
     *
     * @return    array
     */

function getdefault($series, $size)
{
	$admin = & JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	$qual = $admin->imagequal;
	$params = PIHelperadditional::getPIparams();
	if  ($size == 'small')
	{$width = $admin->serimsmw; $height = $admin->serimsmh; $image = 'media/preachit/series/default_sersm.jpg';}
    if  ($size == 'medium')
    {$width = $admin->serimmedw; $height = $admin->serimmedh; $image = 'media/preachit/series/default_sermed.jpg';}
	if  ($size == 'large')
	{$width = $admin->serimlrgw; $height = $admin->serimlrgh; $image = 'media/preachit/series/default_serlrg.jpg';}
	if ($params->get('serimgdef', 1) == 1 && Tewebcheck::checkgd())
	{// create default image	
	$create = PIHelperadditional::createdefault($width, $height, $image, $qual, 'series');
	$serimage = '<img class="seriesimage" src="'.JURI::ROOT().$image.'" alt="' . $series->series_name . '"/>' ;}
	else {$serimage = '';}
	return $serimage;
}

/**
     * Method to get image path for series image
     *
     * @param   int $id series id
     * @param   strgin $imsize size of image small or large
     * @param    string $file image filename
     *
     * @return    array
     */

function getimagepath($id, $imsize, $file)
{
    $ext = JFile::getext($file);
    if ($imsize == 'small')
    {$filename = 'psis'.$id;}
    elseif ($imsize == 'medium')
    {$filename = 'psim'.$id;}
    else {$filename = 'psil'.$id;}
    $image = 'media/preachit/series/'.$filename.'.'.$ext;
    return $image;
}

}
?>