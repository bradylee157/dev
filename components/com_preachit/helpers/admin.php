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
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/adminmedia.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/forms.php');
jimport('teweb.admin.adjust');
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
class PIHelperadmin extends PIHelperadminmedia {

/**
	 * Method to get message dates with time zone adjustments
	 *
	 * @param	array $row  Message details.
	 *
	 * @return	array
	 */

function getstudydates($row)
{
	
$db=& JFactory::getDBO();
	
	//get existing dates from database

$query = "
  SELECT ".$db->nameQuote('study_date')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
$db->setQuery($query);
$date = $db->loadResult();

$query2 = "
  SELECT ".$db->nameQuote('publish_up')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
$db->setQuery($query2);
$publish_up = $db->loadResult();

$query3 = "
  SELECT ".$db->nameQuote('publish_down')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
$db->setQuery($query3);
$publish_down = $db->loadResult();

$query4 = "
  SELECT ".$db->nameQuote('podpublish_up')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
$db->setQuery($query4);
$podpublish_up = $db->loadResult();

$query5 = "
  SELECT ".$db->nameQuote('podpublish_down')."
    FROM ".$db->nameQuote('#__pistudies')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->id).";
  ";
$db->setQuery($query5);
$podpublish_down = $db->loadResult();

// RBC : if study_date is left blank, get current date and time (adjusted for site offset)
if(!$row->study_date)

	{
// RBC : if offset is not specified, getDate() adjusts using configured site offset
		$row->study_date = JFactory::getDate()->toMySQL();
	}

else 

{
// PIK : Check to see if the date has changed been changed or new date added - 
//if not return adjusted date from last entry and don't offset again

$row->study_date = Tewebadjust::adjustdate($row->study_date, $date);

}

if (!$row->publish_up || $row->publish_up == '0000-00-00 00:00:00')

	{
		$row->publish_up = JFactory::getDate()->toMySQL();
	}

else 

	{
		$row->publish_up = Tewebadjust::adjustdate($row->publish_up, $publish_up);
	}
    
if (!$row->podpublish_up || $row->podpublish_up == '0000-00-00 00:00:00')

    {
        $row->podpublish_up = JFactory::getDate()->toMySQL();
    }

else 

    {
        $row->podpublish_up = Tewebadjust::adjustdate($row->podpublish_up, $podpublish_up);
    }

if (!$row->publish_down || $row->publish_down == '0000-00-00 00:00:00' || $row->publish_down == 'never' || $row->publish_down == 'Never')

	{
		$row->publish_down = '';
	}
	
else

	{
		$row->publish_down = Tewebadjust::adjustdate($row->publish_down, $publish_down);
	}

if (!$row->podpublish_down || $row->podpublish_down == '0000-00-00 00:00:00' || $row->podpublish_down == 'never' || $row->podpublish_down == 'Never')

    {
        $row->podpublish_down = '';
    }
    
else

    {
        $row->podpublish_down = Tewebadjust::adjustdate($row->podpublish_down, $podpublish_down);
    }
	
	return $row;
	
}

/**
	 * Method to set the saccess database entry for each message
	 *
	 * @param	int $sid  Series id
	 * @param	int $saccess  Access level
	 *
	 * @return	bolean
	 */

function setsaccess($sid, $saccess)
{
$db=& JFactory::getDBO();	
$query = "SELECT id, study_name FROM #__pistudies WHERE series = ".$sid; 
	$db->setQuery($query);
	$messages = $db->loadObjectList();
	
	if (is_array($messages))
	{	
	
	foreach ($messages as $message)
	
		{
			$db->setQuery ("UPDATE #__pistudies SET saccess = '".$saccess."' WHERE id = '{$message->id}' ;"); 
					$db->query();
		}
	}
		return true;
}

/**
	 * Method to set the minaccess database entry for each message
	 *
	 * @param	int $mid  Ministry id
	 * @param	int $minaccess  Access level
	 *
	 * @return	bolean
	 */

function setminaccess($mid, $minaccess)
{
$db=& JFactory::getDBO();	
$query = "SELECT id, study_name FROM #__pistudies WHERE ministry = ".$mid; 
	$db->setQuery($query);
	$messages = $db->loadObjectList();
	
	if (is_array($messages))
	{	
	
	foreach ($messages as $message)
	
		{
			$db->setQuery ("UPDATE #__pistudies SET minaccess = '".$minaccess."' WHERE id = '{$message->id}' ;"); 
					$db->query();
		}
	}	
		return true;	

}

/**
	 * Method to get the saccess database entry for each message
	 *
	 * @param	array $row Message details
	 *
	 * @return	array
	 */

function getsaccess($row)
{
$db=& JFactory::getDBO();
$query = "SELECT ".$db->nameQuote('access')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->series).";
  ";
$db->setQuery($query);
$access = $db->loadResult();	
	
$row->saccess = $access;

return $row;
}

/**
	 * Method to get the minaccess database entry for each message
	 *
	 * @param	array $row Message details
	 *
	 * @return	array
	 */

function getminaccess($row)
{
	
$db=& JFactory::getDBO();
$query = "SELECT ".$db->nameQuote('access')."
    FROM ".$db->nameQuote('#__piministry')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($row->ministry).";
  ";
$db->setQuery($query);
$access = $db->loadResult();	
	
$row->minaccess = $access;	
	
	
return $row;
}

/**
	 * Method to sanitise message entries
	 *
	 * @param	array $row Message details
	 * @param	string $Jversion version of Joomla
	 *
	 * @return	array
	 */	

function sanitisestudyrow($row, $button = false)
{
		if (isset($row->teacher))
		{$row->teacher = implode(',', $row->teacher);}
		if (isset($row->ministry))
		{$row->ministry = implode(',', $row->ministry);}
	
	$app =& JFactory::getApplication();
	if ($app->isSite() && !$button)  
	{// get hidden fields
	$admin =& JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	
	$row = PIHelperforms::checkentries($row, 'Studies', $admin->mfhide);}
    
    // add 3rd party overrides if present
    $video_link = JRequest::getVar('videooverride', null);
    $video_type = JRequest::getInt('videotypeoverride', 0);
    if ($video_link && $video_type > 0)
    {
        $row->video_link = $video_link;
        $row->video_type = $video_type;
    }

	// deal with alias

	if(empty($row->study_alias)) 
	{$row->study_alias = $row->study_name;}
    $row->study_alias = Tewebadmin::uniquealias('#__pistudies',$row->study_alias, $row->id, 'study_alias');
    $row = PIHelperadmin::getcreator($row);
	
	return $row;
}

/**
	 * Method to set folder and link settings for message details after upload
	 *
	 * @param	array $row Message details
	 * @param	array $data Id3 data
	 * @param	array $filename file details
	 * @param	int $path Preachit folder id
	 * @param	int $media media type
	 *
	 * @return	array
	 */	

function setstudylist($row, $data, $filename, $path, $media)
{
	if ($media == 1)

	{
		$row->audio_link = $filename->file;
		$row->audio_folder = $path;
		
		// fill in id3 data if needed & if local file
		
		$row = PIhelperadmin::filltags($row, $data);   
		
	}
	
	if ($media == 2)

	{
		$row->video_link = $filename->file;
		$row->video_folder = $path;
        
        // fill in id3 data if needed & if local file
        
        $row = PIhelperadmin::filltags($row, $data); 
 
	}
	
	if ($media == 3)

	{
		$row->notes_link = $filename->file;
		$row->notes_folder = $path;
	}
	
	if ($media == 4)

	{
		$row->imagelrg = $filename->file;
		$row->image_folderlrg = $path;
	}
	
	if ($media == 7)

	{
		$row->downloadvid_link = $filename->file;
		$row->downloadvid_folder = $path;
        
         // fill in id3 data if needed & if local file
        
        $row = PIhelperadmin::filltags($row, $data);   
	}

    if ($media == 8)

    {
        $row->slides_link = $filename->file;
        $row->slides_folder = $path;
    }
    
    // deal with alias

    if(empty($row->study_alias)) 
    {$row->study_alias = $row->study_name;
    $row->study_alias = Tewebadmin::uniquealias('#__pistudies',$row->study_alias, $row->id, 'study_alias');}
    
	return $row;
}

/**
     * Method to auto fill study entries from i3 tags
     *
     * @param    array $row study details
     * @param    array $data id3 tag details
     *
     * @return    array
     */    

function filltags($row, $data)
{
    // fill in id3 data if needed & if local file
        
        if (!$row->study_name && $data["song"])
        {$row->study_name = $data["song"];}    
        
        if (!$row->dur_hrs && !$row->dur_mins && !$row->dur_secs)
        {
            $row->dur_hrs = $data["hrs"];
            $row->dur_mins = $data["mins"];
            $row->dur_secs = $data["secs"];
        }
        
        if (!$row->series && $data["album"])
        {$row->series = PIHelperadmin::autofillseries($data["album"]);}
        
        if (!$row->teacher && $data["artist"])
        {$row->teacher = PIHelperadmin::autofillteacher($data["artist"]);}
        
        if (trim($row->study_description) == '' && $data["comment"])
        {$row->study_description = $data["comment"];}  
        
        return $row;
}


/**
	 * Method to auto fill series entry
	 *
	 * @param	string series name from id3 tags
	 *
	 * @return	integer
	 */	
	
function autofillseries($series) 
{
	$db=& JFactory::getDBO();
	$series = strtolower($series);
	$query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE LOWER(series_name) = ".$db->quote($series).";
 	 ";
	$db->setQuery($query);
	$value = $db->loadResult();
	
	return $value;
}

/**
	 * Method to auto fill teacher entry
	 *
	 * @param	string teacher name from id3 tags
	 *
	 * @return	integer
	 */	
	
function autofillteacher($teacher) 
{
	$db=& JFactory::getDBO();
	$teacher = strtolower($teacher);
	$query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE LOWER(teacher_name) = ".$db->quote($teacher).";
 	 ";
	$db->setQuery($query);
	$value = $db->loadResult();
	
	return $value;	
}


/**
	 * Method to sanitise series entries
	 *
	 * @param	array $row series details
	 * @param	string $Jversion version of Joomla
	 *
	 * @return	array
	 */	

function sanitiseseriesrow($row, $button = false)
{
    if (isset($row->ministry))
    {$row->ministry = implode(',', $row->ministry);}
	
	$app =& JFactory::getApplication();
	if ($app->isSite() && !$button)  
	{// get hidden fields
	$admin =& JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	
	$row = PIHelperforms::checkentries($row, 'Series', $admin->sfhide);}
    
	if(empty($row->series_alias)) 
    {$row->series_alias = $row->series_name;}
    $row->series_alias = Tewebadmin::uniquealias('#__piseries',$row->series_alias, $row->id, 'series_alias'); 
    $row = PIHelperadmin::getcreator($row);
	
	return $row;
}

/**
	 * Method to set folder and link settings for series after upload
	 *
	 * @param	array $row Series details
	 * @param	array $data Id3 data
	 * @param	array $filename file details
	 * @param	int $path Preachit folder id
	 * @param	int $media media type
	 *
	 * @return	array
	 */	

function setserieslist($row, $data, $filename, $path, $media)
{
	if ($media == 1)

	{
		$row->series_image_lrg = $filename->file;
		$row->image_folderlrg = $path;
	}
	
	if ($media == 3)

	{
		$row->videolink = $filename->file;
		$row->videofolder = $path;
	}

	return $row;
}

/**
	 * Method to sanitise teacher entries
	 *
	 * @param	array $row Teacher details
	 * @param	string $Jversion version of Joomla
	 *
	 * @return	array
	 */	

function sanitiseteacherrow($row, $button = false)
{
	$app =& JFactory::getApplication();
	if ($app->isSite() && !$button)  
	{// get hidden fields
	$admin =& JTable::getInstance('Piadmin', 'Table');
	$admin->load(1);
	
	$row = PIHelperforms::checkentries($row, 'Teachers', $admin->tfhide);}

	if(empty($row->teacher_alias)) 
	{
        if ($row->teacher_name)
        {$name = $row->teacher_name.' '.$row->lastname;}
        else {$name = $row->lastname;}
        $row->teacher_alias = $name;
    }
    $row->teacher_alias = Tewebadmin::uniquealias('#__piteachers',$row->teacher_alias, $row->id, 'teacher_alias');
    
    $row = PIHelperadmin::getcreator($row);
	
	return $row;
}

/**
	 * Method to set folder and link settings for teacher details after upload
	 *
	 * @param	array $row Teacher details
	 * @param	array $data Id3 data
	 * @param	array $filename file details
	 * @param	int $path Preachit folder id
	 * @param	int $media media type
	 *
	 * @return	array
	 */	

function setteacherlist($row, $data, $filename, $path, $media)
{
	if ($media == 1)

	{
		$row->teacher_image_lrg = $filename->file;
		$row->image_folderlrg = $path;
	}

	return $row;
}

/**
	 * Method to sanitise ministry entries
	 *
	 * @param	array $row Ministry details
	 * @param	string $Jversion version of Joomla
	 *
	 * @return	array
	 */	

function sanitiseministryrow($row, $button = false)
{
	$row->ministry_alias = Tewebadmin::uniquealias('#__piministry',$row->ministry_alias, $row->id, 'ministry_alias');
	
	return $row;
}

/**
	 * Method to set folder and link settings for ministry details after upload
	 *
	 * @param	array $row Ministry details
	 * @param	array $data Id3 data
	 * @param	array $filename file details
	 * @param	int $path Preachit folder id
	 * @param	int $media media type
	 *
	 * @return	array
	 */	

function setministrylist($row, $data, $filename, $path, $media)
{
	if ($media == 1)

	{
		$row->ministry_image_lrg = $filename->file;
		$row->image_folderlrg = $path;
	}

	return $row;
}

function createnewseries($name)
{
if ($name)
{
	$series = PIHelperadmin::setnewrecord('Series', 'series', $name);
	return $series;
}
else {return 'error';}		
}

function createnewteacher($name, $tview)
{
if ($name)
{
	$teacher = PIHelperadmin::setnewrecord('Teachers', 'teacher', $name, $tview);
	return $teacher;
}
else {return 'error';}			

}

function createnewministry($name)
{
if ($name)
{
	$ministry = PIHelperadmin::setnewrecord('Ministry', 'ministry', $name);
	return $ministry;
}
else {return 'error';}			
}

function setnewrecord($table, $type, $name, $tview = null)
{
	$user =& JFactory::getUser();
	$row =& JTable::getInstance($table, 'Table');
	$decoder = $type.'_name';
	$bind[$decoder] = $name;
	if ($type == 'teacher')
	{
        $bind['teacher_view'] = $tview;
        $name = explode(' ', $bind[$decoder]);
        if (!isset($name[1]))
        {
            $bind['teacher_name'] = '';
            $bind['lastname'] = $name[0];
            $test = true;
        }
        else {
            $bind['lastname'] = str_replace($name[0].' ', '', $bind['teacher_name']);
            $bind['teacher_name'] = $name[0];  
        } 
    }
	if (!$row->bind($bind))
	{JError::raiseError(500, $row->getError() );}
	if ($type == 'series')
	{$row = PIHelperadmin::sanitiseseriesrow($row, 1);}
	if ($type == 'teacher')
	{$row = PIHelperadmin::sanitiseteacherrow($row, 1);}
	if ($type == 'ministry')
	{$row = PIHelperadmin::sanitiseministryrow($row, 1);}
	if (!$user->authorize('core.edit.state', 'com_preachit'))
	   { $row->published = 0;}
	if (!$row->store()){JError::raiseError(500, $row->getError() );}
	$record->id = $row->id;
    if ($type == 'teacher')
    {
        if ($row->teacher_name != '')
        {
            $record->name = $row->teacher_name.' '.$row->lastname;
        }
        else {$record->name = $row->lastname;}
    }
    else {
	    $record->name = $row->$decoder;
    }
	return $record;
}

/**
     * Method to get creator
     *
     * @param    array $row record details
     * @param    string $define definition of user cell
     *
     * @return    array
     */    

function getcreator($row, $define = 'user')
{
$user    = JFactory::getUser();
if ($row->$define >! 0)
{$row->user = $user->id;}
return $row;
}
	
}
?>