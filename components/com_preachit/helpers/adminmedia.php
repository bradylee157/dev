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
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/adminupload.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/seriesimage.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/messageimage.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/ministryimage.php');
jimport('teweb.file.urlbuilder');
jimport('teweb.file.functions');
jimport('teweb.media.functions');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
class PIHelperadminmedia extends PIHelperadminupload
{


/**
	 * Method to get the filesize of a file in bytes
	 *
	 * @param	array $row Message details
	 *
	 * @return	array
	 */

function getfilesize($row)
{
	
	// get check values to use to skip filesize check if not necessary
	
	$check = PIHelperadmin::checkfilevalues($row);
	
	// get audio file
	
	if ($check->af != $row->audio_folder || $check->al != $row->audio_link || !$row->audiofs || $row->audiofs == 0)
	{
		$afile = Tewebbuildurl::geturl($row->audio_link, $row->audio_folder, 'pifilepath');
		$afileinfo = PIHelperadmin::fileinfo($afile);
		if ($afileinfo->exists)
		{$row->audiofs = $afileinfo->size;}
	}
	
	// get video file
	
	if ($check->vf != $row->video_folder || $check->vl != $row->video_link || !$row->videofs || $row->videofs == 0)
	{
		$vfile = Tewebbuildurl::geturl($row->video_link, $row->video_folder, 'pifilepath');
		$vfileinfo = PIHelperadmin::fileinfo($vfile);
		if ($vfileinfo->exists)
		{$row->videofs = $vfileinfo->size;}
	}
	
	// get notes file
	
	if ($check->nf != $row->notes_folder || $check->nl != $row->notes_link || !$row->notesfs || $row->notesfs == 0)
	{
		$nfile = Tewebbuildurl::geturl($row->notes_link, $row->notes_folder, 'pifilepath');
		$nfileinfo = PIHelperadmin::fileinfo($nfile);
		if ($nfileinfo->exists)
		{$row->notesfs = $nfileinfo->size;}
	}
    
    // get notes file
    
    if ($check->sf != $row->slides_folder || $check->sl != $row->slides_link || !$row->slidesfs || $row->slidesfs == 0)
    {
        $sfile = Tewebbuildurl::geturl($row->slides_link, $row->slides_folder, 'pifilepath');
        $sfileinfo = PIHelperadmin::fileinfo($sfile);
        if ($sfileinfo->exists)
        {$row->slidesfs = $sfileinfo->size;}
    }
	
	// get add downlod file
	
	if ($check->avf != $row->downloadvid_folder || $check->avl != $row->downloadvid_link || !$row->advideofs || $row->advideofs == 0)
	{
		$avfile = Tewebbuildurl::geturl($row->downloadvid_link, $row->downloadvid_folder, 'pifilepath');
		$avfileinfo = PIHelperadmin::fileinfo($avfile);
		if ($avfileinfo->exists)
		{$row->advideofs = $avfileinfo->size;}
	}
	
	return $row;
	
}

/**
	 * Method to get all the folder and link values for all message meda
	 *
	 * @param	array $row Message details
	 *
	 * @return	array
	 */

function checkfilevalues($row)
{
	$db=& JFactory::getDBO();
	$query = "SELECT ".$db->nameQuote('audio_folder')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->af = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('audio_link')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->al = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('video_folder')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->vf = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('video_link')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->vl = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('notes_folder')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->nf = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('notes_link')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->nl = $db->loadResult();	
    
    $query = "SELECT ".$db->nameQuote('slides_folder')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
    $db->setQuery($query);
    $check->sf = $db->loadResult();    
    
    $query = "SELECT ".$db->nameQuote('slides_link')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
    $db->setQuery($query);
    $check->sl = $db->loadResult();    
	
	$query = "SELECT ".$db->nameQuote('downloadvid_folder')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->avf = $db->loadResult();	
	
	$query = "SELECT ".$db->nameQuote('downloadvid_link')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
	$db->setQuery($query);
	$check->avl = $db->loadResult();	
	
	return $check;
}

/**
	 * Method to get file info
	 *
	 * @param	string $file filepath as absolute url or server path
	 *
	 * @return	array
	 */

function fileinfo($file)
{
	$fileinfo->exists = false;	
	$fileinfo->size = '';

	$fileinfo = Tewebfile::buildfileinfo($file);
	
	return $fileinfo;
}

/**
     * Method to resize teacher images on upload or when triggered in the admin area
     *
     * @param    string $file image filename
     * @param   int $media upload media type - 1 = image
     * @param   int $id teacher id
     *
     * @return    array
     */

function resizeteaimage($file, $media, $id, $resize = false)
{
	$row = & JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
	if ($media == 1 && PIHelperadditional::allowresize())
	{
        // create small image
        $image = PIHelpertimage::getimagepath($id, 'small', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->teaimsmw; $height = $row->teaimsmh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create medium image
        $image = PIHelpertimage::getimagepath($id, 'medium', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->teaimmedw; $height = $row->teaimmedh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create large image
        $image = PIHelpertimage::getimagepath($id, 'large', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->teaimlrgw; $height = $height = $row->teaimlrgh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);  
        
        if ($resize)
        {
            $series = & JTable::getInstance('Teachers', 'Table');
            $series->load($id);
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/teachers/default_teasm.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/teachers/default_teamed.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/teachers/default_tealrg.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            PIHelpertimage::getdefault($series, 'small');
            PIHelpertimage::getdefault($series, 'medium');
            PIHelpertimage::getdefault($series, 'large');
        }
    }

	return true;
}

/**
     * Method to resize ministry images on upload or when triggered in the admin area
     *
     * @param    string $file image filename
     * @param   int $media upload media type - 1 = image
     * @param   int $id ministry id
     *
     * @return    array
     */

function resizeminimage($file, $media, $id, $resize = false)
{
	$row = & JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
    if ($media == 1 && PIHelperadditional::allowresize())
    {
        // create small image
        $image = PIHelperminimage::getimagepath($id, 'small', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->minimsmw; $height = $row->minimsmh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create medium image
        $image = PIHelperminimage::getimagepath($id, 'medium', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->minimmedw; $height = $row->minimmedh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create large image
        $image = PIHelperminimage::getimagepath($id, 'large', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->minimlrgw; $height = $height = $row->minimlrgh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);  
        
        if ($resize)
        {
            $ministry = & JTable::getInstance('Ministry', 'Table');
            $ministry->load($id);
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/ministry/default_minsm.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/ministry/default_minmed.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/ministry/default_minlrg.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            PIHelperminimage::getdefault($ministry, 'small');
            PIHelperminimage::getdefault($ministry, 'medium');
            PIHelperminimage::getdefault($ministry, 'large');
        }
    }
    
	return true;
}

/**
     * Method to resize series images on upload or when triggered in the admin area
     *
     * @param    string $file image filename
     * @param   int $media upload media type - 1 = image
     * @param   int $id series id
     *
     * @return    array
     */

function resizeserimage($file, $media, $id, $resize = false)
{
	if ($media != 3)
	{
	$row = & JTable::getInstance('Piadmin', 'Table');
	$row->load(1);
    if ($media == 1 && PIHelperadditional::allowresize())
    {
        // create small image
        $image = PIHelpersimage::getimagepath($id, 'small', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->serimsmw; $height = $row->serimsmh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create medium image
        $image = PIHelpersimage::getimagepath($id, 'medium', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->serimmedw; $height = $row->serimmedh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create large image
        $image = PIHelpersimage::getimagepath($id, 'large', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->serimlrgw; $height = $height = $row->serimlrgh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);  
        
        if ($resize)
        {
            $series = & JTable::getInstance('Series', 'Table');
            $series->load($id);
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/series/default_sersm.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/series/default_sermed.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.'media/preachit/series/default_serlrg.jpg';
            if (file_exists($imagefile))
            {JFILE::delete($imagefile);}
            PIHelpersimage::getdefault($series, 'small');
            PIHelpersimage::getdefault($series, 'medium');
            PIHelpersimage::getdefault($series, 'large');
        }
    }
	}
	return true;
}

/**
     * Method to resize message images on upload or when triggered in the admin area
     *
     * @param    string $file image filename
     * @param   int $media upload media type - 4 = image
     * @param   int $id message id
     *
     * @return    array
     */

function resizemesimage($file, $media, $id)
{	
	if ($media == 4 && PIHelperadditional::allowresize())
	{
        $row = & JTable::getInstance('Piadmin', 'Table');
        $row->load(1);

        // create small image
        $image = PIHelpermimage::getimagepath($id, 'small', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->msimsmw; $height = $row->msimsmh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
            
        // create medium image
        $image = PIHelpermimage::getimagepath($id, 'medium', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->msimmedw; $height = $row->msimmedh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);
        
        // create large image
        $image = PIHelpermimage::getimagepath($id, 'large', $file);
        $imagefile = JPATH_SITE.DIRECTORY_SEPARATOR.$image;
        if (file_exists($imagefile))
        {JFILE::delete($imagefile);}
        $width = $row->msimlrgw; $height = $height = $row->msimlrgh;
        Tewebfile::copyfile($file, $imagefile);
        Tewebmedia::imageresize($width, $height, $imagefile, $row->imagequal);  
	}
	return true;
}

}
?>