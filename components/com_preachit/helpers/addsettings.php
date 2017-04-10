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
jimport('teweb.media.functions');
jimport('teweb.file.functions');
jimport('teweb.checks.standard');
class PIHelperaddsettings {

/**
     * Get template id
     *
     * @return    int
     */
function templateid()
{
    $app = JFactory::getApplication();
    $website = JURI::BASE();
    $test = substr($website, -14);
    $temp = '';
    if ($test != 'administrator/')
    {
    $params =& $app->getParams();
    $temp = $params->get('template_override', '');
    }
    if (!$temp)
    {
        $db =& JFactory::getDBO();
        $query = "SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pitemplate')."
    WHERE ".$db->nameQuote('def')." = ".$db->quote('1').";
  ";
    $db->setQuery($query);
    $temp = $db->loadResult();
    }
    
    $mobtemp = Tewebcheck::checkmobile();
    
    if ($mobtemp)
    {
        $piparams = PIHelperadditional::getPIparams($temp);
        $tempswitch = $piparams->get('mobtemp', '');
        
        if ($tempswitch)
        {$temp = $tempswitch;}
    }
    
    return $temp;

}    
    
/**
	 * Get template folder
	 *
	 * @return	string
	 */

function template()
{
	$id = PIHelperadditional::templateid();
	$db =& JFactory::getDBO();
	$query = "SELECT ".$db->nameQuote('template')."
    FROM ".$db->nameQuote('#__pitemplate')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";             
	$db->setQuery($query);
	$temp = $db->loadResult();
	return $temp;

}

/**
	 * Method to get Preachit params
	 *
	 * @param	int $id  Send this if you want to force function to get params from a set template.
	 *
	 * @return	array
	 */

function getPIparams($id='')
{
	jimport( 'joomla.html.parameter' );	
    if (!$id)
    {
    $id = PIHelperadditional::templateid();}
	$db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('params')."
    FROM ".$db->nameQuote('#__pitemplate')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
    $db->setQuery($query);
    $piparams = $db->loadResult();
	
	$params = new JParameter($piparams);	
	return $params;
}

/**
	 * Method to set filter for the message list drop downs
	 *
	 * @param	array $rows The array to run through
	 * @param	int $value  The value to match in the array
	 *
	 * @return	string
	 */

function setfilter($rows, $value)
{
	$pif = 0;
	$i = 1;
	foreach ($rows AS $row)
	{
	if ($row->value == $value)
		{
			$pif = $i;
		}
	$i = $i + 1;
	}
	return $pif;
}

function ajaxitemid($item)
{
	echo '<div id="piitemid" style="display: none;">'.$item.'</div>';
}

/**
	 * Method to get right value from single line array
	 *
	 * @return	int
	 */

function getwherevalue($array)
{
if ($array[0]){$value = $array[0];}
else {$value = 0;}
return $value;
}

/**
     * Method to get image sizes
     * @param string $type sets the type of image - series, teacher, message, ministry
     * @param string $size sets the size of the image - small, medium, large
     * @return    array
     */

function getimagesize($type, $size)
{
    $admin = & JTable::getInstance('Piadmin', 'Table');
    $admin->load(1);
    $image->qual = $admin->imagequal;
    $image->width = null;
    $image->height = null;
    if  ($size == 'small' && $type == 'series')
    {$image->width = $admin->serimsmw; $image->height = $admin->serimsmh;}
    elseif  ($size == 'medium' && $type == 'series')
    {$image->width = $admin->serimmedw; $image->height = $admin->serimmedh;}
    elseif  ($size == 'large' && $type == 'series')
    {$image->width = $admin->serimlrgw; $image->height = $admin->serimlrgh;}
    elseif  ($size == 'small' && $type == 'teacher')
    {$image->width = $admin->teaimsmw; $image->height = $admin->teaimsmh;}
    elseif  ($size == 'medium' && $type == 'teacher')
    {$image->width = $admin->teaimmedw; $image->height = $admin->teaimmedh;}
    elseif  ($size == 'large' && $type == 'teacher')
    {$image->width = $admin->teaimlrgw; $image->height = $admin->teaimlrgh;}
    elseif  ($size == 'small' && $type == 'ministry')
    {$image->width = $admin->minimsmw; $image->height = $admin->minimsmh;}
    elseif  ($size == 'medium' && $type == 'ministry')
    {$image->width = $admin->minimmedw; $image->height = $admin->minimmedh;}
    elseif  ($size == 'large' && $type == 'ministry')
    {$image->width = $admin->minimlrgw; $image->height = $admin->minimlrgh;}
    elseif  ($size == 'small' && $type == 'message')
    {$image->width = $admin->msimsmw; $image->height = $admin->msimsmh;}
    elseif  ($size == 'medium' && $type == 'message')
    {$image->width = $admin->msimmedw; $image->height = $admin->msimmedh;}
    elseif  ($size == 'large' && $type == 'message')
    {$image->width = $admin->msimlrgw; $image->height = $admin->msimlrgh;}
    return $image;
}

/**
     * Method to get image resize value
     * @return    boolean
     */

function allowresize()
{
    return true;
}

/**
     * Method to create default teacher/series/ministry image
     * @param int $width set width for the default image
     * @param int $height set height for the default image
     * @param string $image path to the image file to create the default image from
     * @param int $qual quality of the default image
     * @param string $type defines the type of image - teacher, series or ministry
     * @return    string
     */

function createdefault($width, $height, $image, $qual, $type)
{
	// check that image doesn't already exist
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
    jimport('teweb.media.functions');
    $abspath = JPATH_SITE;
	if ($type == 'series' || $type == 'ministry')
	{$source = 'components/com_preachit/assets/images/default_gen.jpg';}
	if ($type == 'teacher')
	{$source = 'components/com_preachit/assets/images/default_portrait.jpg';}
    $imagefile = $abspath.DIRECTORY_SEPARATOR.$image;
    $ext = JFile::getext($source);
    if (!file_exists($imagefile))
    {
        Tewebfile::copyfile($source, $imagefile, true);
        if (!Tewebmedia::checksize($width, $height, $imagefile) && Tewebcheck::checkgd())
        {Tewebmedia::imageresize($width, $height, $imagefile, $qual);}
    } 

	return true;
}	

/**
     * Method to subsitute series, message or teacher image as the image url placed in the page metatags for facebook links
     * @param string $entry the facebook entry given in the template parameters
     * @param int $id message id
     * @return    string
     */

function facebookimage($entry, $id)
{	$abspath    = JPATH_SITE;
    $entry = trim($entry);
	if ($entry == '{series}' || $entry == '{teacher}' || $entry == '{message}'	)
	{
		if ($entry == '{series}')
		{$study =& JTable::getInstance('Studies', 'Table');
		$study->load($id);	
		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/seriesimage.php');
		$image = PIHelpersimage::seriesimage($study->series, '', '', 'large', 'fb');}
		elseif ($entry == '{teacher}')
		{$study =& JTable::getInstance('Studies', 'Table');
		$study->load($id);	
		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/teacherimage.php');
		$image = PIHelpertimage::teacherimage($study->teacher, '', '', 'large', 'fb');}
		elseif ($entry == '{message}')
		{$study =& JTable::getInstance('Studies', 'Table');
		$study->load($id);	
		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/messageimage.php');
		$image = PIHelpermimage::messageimage($study->id, '', '', '', 'large', 'fb');}
	return $image;	
	}
	else {return $entry;}
}

/**
     * Method to determine whether the site is set as multilanguage in the admin area
     * @return    string
     */

function translate()
{
	$db =& JFactory::getDBO();
	$query = "SELECT ".$db->nameQuote('multilanguage')."
    FROM ".$db->nameQuote('#__pibckadmin')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote(1).";
  ";
	$db->setQuery($query);
	$translate = $db->loadResult();
	return $translate;
}

/**
     * Method to get menu link from specific id
     * @param int $id menu id
     * @return    string
     */

function getmenulink($id)
{
    $db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('link')."
    FROM ".$db->nameQuote('#__menu')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
    $db->setQuery($query);
    $link = $db->loadResult();
    return $link;
}

}
?>