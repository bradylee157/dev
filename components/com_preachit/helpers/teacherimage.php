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

class PIHelpertimage{

/**
     * Method to get teacher image
     *
     * @param   int $id teacher id
     * @param   boolean $link determines whether the image needs to be wrapped in a link
     * @param   int $item the item id for the link
     * @param   string $imsize size of image small or large
     * @param   boolean $fb determines whether the image should be wrapped in img tags
     *
     * @return    array
     */
    
function teacherimage($id, $link, $item, $imsize, $fb = '')
{
$app = JFactory::getApplication();    
$option = 'com_preachit';
$db =& JFactory::getDBO();
$id = intval($id);
$teacher =& JTable::getInstance('Teachers', 'Table');
$teacher->load($id);
$resize = PIHelperadditional::allowresize();
if ($teacher->teacher_name)
{$name = $teacher->teacher_name.' '.$teacher->lastname;}
else {$name = $teacher->lastname;}
//get series picture
$timagefile = Tewebbuildurl::geturl($teacher->teacher_image_lrg, $teacher->image_folderlrg, 'pifilepath');
if ($fb == 'fb')
{return $timagefile;}

if ($teacher->teacher_image_lrg == '' || $teacher->published != 1) 
{
    $timage = PIHelpertimage::getdefault($teacher, $imsize);
}
else 
{
    if ($resize == 1)
    {
        $image = PIHelpertimage::getimagepath($id, $imsize, $timagefile);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        $image = JURI::ROOT().$image;
            
        if (!file_exists($imagefile))
        {
            if (Tewebfile::copyfile($timagefile, $imagefile))
            {
                $size = PIHelperadditional::getimagesize('teacher', $imsize);
                if (Tewebcheck::checkgd())
                {Tewebmedia::imageresize($size->width, $size->height, $imagefile, $size->qual);}
            }
            else {$image = $timagefile;}
        } 
    }
    else {$image = $timagefile;}
    
    $timage = '<img class="teacherimage" src="' . $image . '" alt="' . $name . '"/>' ;
}

if ($link == 1 && $timage && $id > 0)
{
    $slug = $id.':'.$teacher->teacher_alias;
    $timage = '<a href="'.JRoute::_('index.php?option=' . $option . '&teacher=' . $slug . '&view=studylist&layout=teacher&Itemid='.$item).'">'.$timage.'</a>';
}

return $timage;
}

/**
     * Method to trigger the default image function
     *
     * @param   int $teacher teacher id
     * @param   strgin $imsize size of image small or large
     *
     * @return    array
     */

function getdefault($teacher, $size)
{
	$admin = & JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	$qual = $admin->imagequal;
	$params = PIHelperadditional::getPIparams();
	if  ($size == 'small')
	{$width = $admin->teaimsmw; $height = $admin->teaimsmh; $image = 'media/preachit/teachers/default_teasm.jpg';}
    if  ($size == 'medium')
    {$width = $admin->teaimmedw; $height = $admin->teaimmedh; $image = 'media/preachit/teachers/default_teamed.jpg';}
	if  ($size == 'large')
	{$width = $admin->teaimlrgw; $height = $admin->teaimlrgh; $image = 'media/preachit/teachers/default_tealrg.jpg';}
	if ($params->get('teaimgdef', 1) == 1 && Tewebcheck::checkgd())
	{// create default image	
	$create = PIHelperadditional::createdefault($width, $height, $image, $qual, 'teacher');
    if ($teacher->teacher_name)
    {$name = $teacher->teacher_name.' '.$teacher->lastname;}
    else {$name = $teacher->lastname;}
	$teaimage = '<img class="teacherimage" src="'.JURI::ROOT().$image.'" alt="' . $name . '"/>' ;}
	else {$teaimage = '';}
	return $teaimage;
}

/**
     * Method to get image path for teacher image
     *
     * @param   int $id teacher id
     * @param   strgin $imsize size of image small or large
     * @param    string $file image filename
     *
     * @return    array
     */

function getimagepath($id, $imsize, $file)
{
    $ext = JFile::getext($file);
    if ($imsize == 'small')
    {$filename = 'ptis'.$id;}
    elseif ($imsize == 'medium')
    {$filename = 'ptim'.$id;}
    else {$filename = 'ptil'.$id;}
    $image = 'media/preachit/teachers/'.$filename.'.'.$ext;
    return $image;
}

}
?>