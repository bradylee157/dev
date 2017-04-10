<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
jimport('teweb.admin.records');
class PIHelperrestore
{
    
/**
     * Method to restore mediaplayer records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoremp($tables, $overwrite)
{
$db = & JFactory::getDBO();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__pimediaplayers');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'mptable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__pimediaplayers` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();}
    $row =& JTable::getInstance('Mediaplayers', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->playername))
    {$bind['playername'] = strval($entry->playername);}
    if (isset($entry->playertype))
    {$bind['playertype'] = strval($entry->playertype);}
    if (isset($entry->playercode))
    {$bind['playercode'] = strval($entry->playercode);}
    if (isset($entry->playerscript))
    {$bind['playerscript'] = strval($entry->playerscript);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->html5))
    {$bind['html5'] = strval($entry->html5);}
    if (isset($entry->playerurl))
    {$bind['playerurl'] = strval($entry->playerurl);}
    if (isset($entry->image))
    {$bind['image'] = strval($entry->image);}
    if (isset($entry->facebook))
    {$bind['facebook'] = strval($entry->facebook);}
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
} 

/**
     * Method to restore mediaplayer records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoreshare($tables, $overwrite)
{
$db = & JFactory::getDBO();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__pishare');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'sharetable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__pishare` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();}
    $row =& JTable::getInstance('Share', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->name))
    {$bind['name'] = strval($entry->name);}
    if (isset($entry->code))
    {$bind['code'] = strval($entry->code);}
    if (isset($entry->script))
    {$bind['script'] = strval($entry->script);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->ordering))
    {$bind['ordering'] = strval($entry->ordering);}
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
} 

/**
     * Method to restore folder records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restorefp($tables, $overwrite)
{
$db = & JFactory::getDBO();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__pifilepath');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'filepathtable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__pifilepath` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();}
    $row =& JTable::getInstance('Filepath', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->name))
    {$bind['name'] = strval($entry->name);}
    if (isset($entry->server))
    {$bind['server'] = strval($entry->server);}
    if (isset($entry->folder))
    {$bind['folder'] = strval($entry->folder);}
    if (isset($entry->description))
    {$bind['description'] = strval($entry->description);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->ftphost))
    {$bind['ftphost'] = strval($entry->ftphost);}
    if (isset($entry->ftpuser))
    {$bind['ftpuser'] = strval($entry->ftpuser);}
    if (isset($entry->ftppassword))
    {$bind['ftppassword'] = strval($entry->ftppassword);}
    if (isset($entry->ftpport))
    {$bind['ftpport'] = strval($entry->ftpport);}
    if (isset($entry->type))
    {$bind['type'] = strval($entry->type);}
    if (isset($entry->aws_key))
    {$bind['aws_key'] = strval($entry->aws_key);}
    if (isset($entry->aws_secret))
    {$bind['aws_secret'] = strval($entry->aws_secret);}
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
}  

/**
     * Method to restore podcast records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restorepod($tables, $overwrite)
{
$db = & JFactory::getDBO();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__pipodcast');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'podtable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__pipodcast` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();}
    $row =& JTable::getInstance('Podcast', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->name))
    {$bind['name'] = strval($entry->name);}
    if (isset($entry->image))
    {$bind['image'] = strval($entry->image);}
    if (isset($entry->records))
    {$bind['records'] = strval($entry->records);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->description))
    {$bind['description'] = strval($entry->description);}
    if (isset($entry->imagehgt))
    {$bind['imagehgt'] = strval($entry->imagehgt);}
    if (isset($entry->imagewth))
    {$bind['imagewth'] = strval($entry->imagewth);}
    if (isset($entry->author))
    {$bind['author'] = strval($entry->author);}
    if (isset($entry->search))
    {$bind['search'] = strval($entry->search);}
    if (isset($entry->filename))
    {$bind['filename'] = strval($entry->filename);}
    if (isset($entry->menuitem))
    {$bind['menuitem'] = strval($entry->menuitem);}
    if (isset($entry->language))
    {$bind['language'] = strval($entry->language);}
    if (isset($entry->editor))
    {$bind['editor'] = strval($entry->editor);}
    if (isset($entry->email))
    {$bind['email'] = strval($entry->email);}
    if (isset($entry->ordering))
    {$bind['ordering'] = strval($entry->ordering);}
    if (isset($entry->itunestitle))
    {$bind['itunestitle'] = strval($entry->itunestitle);}
    if (isset($entry->itunessub))
    {$bind['itunessub'] = strval($entry->itunessub);}
    if (isset($entry->itunesdesc))
    {$bind['itunesdesc'] = strval($entry->itunesdesc);}
    if (isset($entry->series))
    {$bind['series'] = strval($entry->series);}
    if (isset($entry->series_list))
    {$bind['series_list'] = strval($entry->series_list);}
    if (isset($entry->ministry))
    {$bind['ministry'] = strval($entry->ministry);}
    if (isset($entry->ministry_list))
    {$bind['ministry_list'] = strval($entry->ministry_list);}
    if (isset($entry->teacher))
    {$bind['teacher'] = strval($entry->teacher);}
    if (isset($entry->teacher_list))
    {$bind['teacher_list'] = strval($entry->teacher_list);}
    if (isset($entry->media))
    {$bind['media'] = strval($entry->media);}
    if (isset($entry->media_list))
    {$bind['media_list'] = strval($entry->media_list);}
    if (isset($entry->languagesel))
    {$bind['languagesel'] = strval($entry->languagesel);}
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
} 

/**
     * Method to restore ministry records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoremin($tables, $overwrite)
{
$db = & JFactory::getDBO();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__piministry');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'mintable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__piministry` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();
    if (isset($entry->image_folder))
    {$bind['image_folder'] = strval($entry->image_folder);}
    if (isset($entry->image_folderlrg))
    {$bind['image_folderlrg'] = strval($entry->image_folderlrg);}
    }
    else {
    if (isset($entry->image_folder_text))
    {$bind['image_folder'] = strval(PIHelperrestore::getfolder($entry->image_folder_text));}
    if (isset($entry->image_folderlrg_text))
    {$bind['image_folderlrg'] = strval(PIHelperrestore::getfolder($entry->image_folderlrg_text));}
    }
    $row =& JTable::getInstance('Ministry', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->ministry_name))
    {$bind['ministry_name'] = strval($entry->ministry_name);}
    if (isset($entry->ministry_alias))
    {$bind['ministry_alias'] = strval($entry->ministry_alias);}
    if (isset($entry->ministry_image_sm))
    {$bind['ministry_image_sm'] = strval($entry->ministry_image_sm);}
    if (isset($entry->ministry_image_lrg))
    {$bind['ministry_image_lrg'] = strval($entry->ministry_image_lrg);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->ministry_description))
    {$bind['ministry_description'] = strval($entry->ministry_description);}
    if (isset($entry->ordering))
    {$bind['ordering'] = strval($entry->ordering);}
    if (isset($entry->access))
    {$bind['access'] = strval($entry->access);}
    if (isset($entry->language))
    {$bind['language'] = strval($entry->language);}
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
}  

/**
     * Method to restore series records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoreser($tables, $overwrite)
{
$db = & JFactory::getDBO();
$user =& JFactory::getUser();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__piseries');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'sertable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__piseries` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();
    if (isset($entry->image_folder))
    {$bind['image_folder'] = strval($entry->image_folder);}
    if (isset($entry->image_folderlrg))
    {$bind['image_folderlrg'] = strval($entry->image_folderlrg);}
    if (isset($entry->videofolder))
    {$bind['videofolder'] = strval($entry->videofolder);}
    if (isset($entry->ministry))
    {$bind['ministry'] = strval($entry->ministry);}
    }
    else {
    if (isset($entry->image_folder_text))
    {$bind['image_folder'] = strval(PIHelperrestore::getfolder($entry->image_folder_text));}
    if (isset($entry->image_folderlrg_text))
    {$bind['image_folderlrg'] = strval(PIHelperrestore::getfolder($entry->image_folderlrg_text));}
    if (isset($entry->videofolder_text))
    {$bind['videofolder'] = strval(PIHelperrestore::getfolder($entry->videofolder_text));}
    if (isset($entry->ministry_text))
    {$bind['ministry'] = strval(PIHelperrestore::getvalues('#__piministry', 'ministry_name', $entry->ministry_text));}
    }
    $row =& JTable::getInstance('Series', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->series_name))
    {$bind['series_name'] = strval($entry->series_name);}
    if (isset($entry->series_alias))
    {$bind['series_alias'] = strval($entry->series_alias);}
    if (isset($entry->series_image_sm))
    {$bind['series_image_sm'] = strval($entry->series_image_sm);}
    if (isset($entry->series_image_lrg))
    {$bind['series_image_lrg'] = strval($entry->series_image_lrg);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->series_description))
    {$bind['series_description'] = strval($entry->series_description);}
    if (isset($entry->ordering))
    {$bind['ordering'] = strval($entry->ordering);}
    if (isset($entry->access))
    {$bind['access'] = strval($entry->access);}
    if (isset($entry->language))
    {$bind['language'] = strval($entry->language);}
    if (isset($entry->introvideo))
    {$bind['introvideo'] = strval($entry->introvideo);}
    if (isset($entry->videolink))
    {$bind['videolink'] = strval($entry->videolink);}
    if (isset($entry->vheight))
    {$bind['vheight'] = strval($entry->vheight);}
    if (isset($entry->vwidth))
    {$bind['vwidth'] = strval($entry->vwidth);}
    // set user to the one importing
    $bind['user'] = $user->id;
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
} 

/**
     * Method to restore teachers records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoreteach($tables, $overwrite)
{
$db = & JFactory::getDBO();
$user =& JFactory::getUser();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__piteachers');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'teachtable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__piteachers` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();
    if (isset($entry->image_folder))
    {$bind['image_folder'] = strval($entry->image_folder);}
    if (isset($entry->image_folderlrg))
    {$bind['image_folderlrg'] = strval($entry->image_folderlrg);}
    }
    else {
    if (isset($entry->image_folder_text))
    {$bind['image_folder'] = strval(PIHelperrestore::getfolder($entry->image_folder_text));}
    if (isset($entry->image_folderlrg_text))
    {$bind['image_folderlrg'] = strval(PIHelperrestore::getfolder($entry->image_folderlrg_text));}
    }
    $row =& JTable::getInstance('Teachers', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->teacher_name))
    {$bind['teacher_name'] = strval($entry->teacher_name);}
    if (isset($entry->lastname))
    {$bind['lastname'] = strval($entry->lastname);}
    if (isset($entry->teacher_name) && !isset($entry->lastname))
    {$name = explode(' ', $entry->teacher_name);
        if (!isset($name[1]))
        {
            $bind['teacher_name'] = null;
            $bind['lastname'] = strval($name[0]);
            $test = true;
        }
        else {
            $bind['lastname'] = strval(str_replace($name[0].' ', '', $entry->teacher_name));
            $bind['teacher_name'] = strval($name[0]); 
        }
    }
    if (isset($entry->teacher_alias))
    {$bind['teacher_alias'] = strval($entry->teacher_alias);}
    if (isset($entry->teacher_image_sm))
    {$bind['teacher_image_sm'] = strval($entry->teacher_image_sm);}
    if (isset($entry->teacher_image_lrg))
    {$bind['teacher_image_lrg'] = strval($entry->teacher_image_lrg);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->teacher_description))
    {$bind['teacher_description'] = strval($entry->teacher_description);}
    if (isset($entry->ordering))
    {$bind['ordering'] = strval($entry->ordering);}
    if (isset($entry->access))
    {$bind['access'] = strval($entry->access);}
    if (isset($entry->language))
    {$bind['language'] = strval($entry->language);}
    if (isset($entry->teacher_email))
    {$bind['teacher_email'] = strval($entry->teacher_email);}
    if (isset($entry->teacher_website))
    {$bind['teacher_website'] = strval($entry->teacher_website);}
    if (isset($entry->teacher_view))
    {$bind['teacher_view'] = strval($entry->teacher_view);}
    if (isset($entry->teacher_role))
    {$bind['teacher_role'] = strval($entry->teacher_role);}
    // set user to the one importing
    $bind['user'] = $user->id;
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
}

/**
     * Method to restore message records from backup xml file.
     *
     * @param    array $tables XML data
     * @param    bolean $overwrite Determine whether existing data overwritten or not
     *  
     * @return  success boleen
     */

function restoremes($tables, $overwrite)
{
$db = & JFactory::getDBO();
$user =& JFactory::getUser();
if ($overwrite == 1)
{PIHelperrestore::truncate('#__pistudies');}
foreach ($tables AS $entry)
{
if ($entry->getName() == 'mestable')
{   $bind = array();
    if ($overwrite == 1 && isset($entry->id)) 
    {$query = "INSERT IGNORE INTO `#__pistudies` (`id`) VALUES ('".strval($entry->id)."');";
    $db->setQuery( $query );
    $db->query();
    if (isset($entry->image_folder))
    {$bind['image_folder'] = strval($entry->image_folder);}
    if (isset($entry->image_foldermed))
    {$bind['image_foldermed'] = strval($entry->image_foldermed);}
    if (isset($entry->image_folderlrg))
    {$bind['image_folderlrg'] = strval($entry->image_folderlrg);}
    if (isset($entry->video_folder))
    {$bind['video_folder'] = strval($entry->video_folder);}
    if (isset($entry->audio_folder))
    {$bind['audio_folder'] = strval($entry->audio_folder);}
    if (isset($entry->notes_folder))
    {$bind['notes_folder'] = strval($entry->notes_folder);}
    if (isset($entry->downloadvid_folder))
    {$bind['downloadvid_folder'] = strval($entry->downloadvid_folder);}
    if (isset($entry->vidpurchase_folder))
    {$bind['vidpurchase_folder'] = strval($entry->vidpurchase_folder);}
    if (isset($entry->audpurchase_folder))
    {$bind['audpurchase_folder'] = strval($entry->audpurchase_folder);}
    if (isset($entry->ministry))
    {$bind['ministry'] = strval($entry->ministry);}
    if (isset($entry->series))
    {$bind['series'] = strval($entry->series);}
    if (isset($entry->teacher))
    {$bind['teacher'] = strval($entry->teacher);}
    }
    else {
    if (isset($entry->image_folder_text))
    {$bind['image_folder'] = strval(PIHelperrestore::getfolder($entry->image_folder_text));}
    if (isset($entry->image_foldermed_text))
    {$bind['image_foldermed'] = strval(PIHelperrestore::getfolder($entry->image_foldermed_text));}
    if (isset($entry->image_folderlrg_text))
    {$bind['image_folderlrg'] = strval(PIHelperrestore::getfolder($entry->image_folderlrg_text));}
    if (isset($entry->video_folder_text))
    {$bind['video_folder'] = strval(PIHelperrestore::getfolder($entry->video_folder_text));}
    if (isset($entry->audio_folder_text))
    {$bind['audio_folder'] = strval(PIHelperrestore::getfolder($entry->audio_folder_text));}
    if (isset($entry->notes_folder_text))
    {$bind['notes_folder'] = strval(PIHelperrestore::getfolder($entry->notes_folder_text));}
    if (isset($entry->downloadvid_folder_text))
    {$bind['downloadvid_folder'] = strval(PIHelperrestore::getfolder($entry->downloadvid_folder_text));}
    if (isset($entry->vidpurchase_folder_text))
    {$bind['vidpurchase_folder'] = strval(PIHelperrestore::getfolder($entry->vidpurchase_folder_text));}
    if (isset($entry->audpurchase_folder_text))
    {$bind['audpurchase_folder'] = strval(PIHelperrestore::getfolder($entry->audpurchase_folder_text));}
    if (isset($entry->ministry_text))
    {$bind['ministry'] = strval(PIHelperrestore::getvalues('#__piministry', 'ministry_name', $entry->ministry_text));}
    if (isset($entry->series_text))
    {$bind['series'] = strval(PIHelperrestore::getvalues('#__piseries', 'series_name', $entry->series_text));}
    if (isset($entry->teacher_text))
    {$bind['teacher'] = strval(PIHelperrestore::getvalues('#__piteachers', 'teacher_name', $entry->teacher_text));}
    }
    $row =& JTable::getInstance('Studies', 'Table');
    if ($overwrite == 1 && isset($entry->id)) 
    {$bind['id'] = strval($entry->id);}
    if (isset($entry->study_date))
    {$bind['study_date'] = strval($entry->study_date);}
    if (isset($entry->study_name))
    {$bind['study_name'] = strval($entry->study_name);}
    if (isset($entry->study_alias))
    {$bind['study_alias'] = strval($entry->study_alias);}
    if (isset($entry->published))
    {$bind['published'] = strval($entry->published);}
    if (isset($entry->study_description))
    {$bind['study_description'] = strval($entry->study_description);}
    if (isset($entry->study_book))
    {$bind['study_book'] = strval($entry->study_book);}
    if (isset($entry->ref_ch_beg))
    {$bind['ref_ch_beg'] = strval($entry->ref_ch_beg);}
    if (isset($entry->ref_ch_end))
    {$bind['ref_ch_end'] = strval($entry->ref_ch_end);}
    if (isset($entry->ref_vs_beg))
    {$bind['ref_vs_beg'] = strval($entry->ref_vs_beg);}
    if (isset($entry->ref_vs_end))
    {$bind['ref_vs_end'] = strval($entry->ref_vs_end);}
    if (isset($entry->study_book2))
    {$bind['study_book2'] = strval($entry->study_book2);}
    if (isset($entry->ref_ch_beg2))
    {$bind['ref_ch_beg2'] = strval($entry->ref_ch_beg2);}
    if (isset($entry->ref_ch_end2))
    {$bind['ref_ch_end2'] = strval($entry->ref_ch_end2);}
    if (isset($entry->ref_vs_beg2))
    {$bind['ref_vs_beg2'] = strval($entry->ref_vs_beg2);}
    if (isset($entry->ref_vs_end2))
    {$bind['ref_vs_end2'] = strval($entry->ref_vs_end2);}
    if (isset($entry->dur_hrs))
    {$bind['dur_hrs'] = strval($entry->dur_hrs);}
    if (isset($entry->dur_mins))
    {$bind['dur_mins'] = strval($entry->dur_mins);}
    if (isset($entry->dur_secs))
    {$bind['dur_secs'] = strval($entry->dur_secs);}
    if (isset($entry->video))
    {$bind['video'] = strval($entry->video);}
    if (isset($entry->video_type))
    {$bind['video_type'] = strval($entry->video_type);}
    if (isset($entry->video_download))
    {$bind['video_download'] = strval($entry->video_download);}
    if (isset($entry->video_link))
    {$bind['video_link'] = strval($entry->video_link);}
    if (isset($entry->audio))
    {$bind['audio'] = strval($entry->audio);}
    if (isset($entry->audio_type))
    {$bind['audio_type'] = strval($entry->audio_type);}
    if (isset($entry->audio_download))
    {$bind['audio_download'] = strval($entry->audio_download);}
    if (isset($entry->audio_link))
    {$bind['audio_link'] = strval($entry->audio_link);}
    if (isset($entry->comments))
    {$bind['comments'] = strval($entry->comments);}
    if (isset($entry->study_text))
    {$bind['study_text'] = strval($entry->study_text);}
    if (isset($entry->text))
    {$bind['text'] = strval($entry->text);}
    if (isset($entry->studylist))
    {$bind['studylist'] = strval($entry->studylist);}
    if (isset($entry->hits))
    {$bind['hits'] = strval($entry->hits);}
    if (isset($entry->downloads))
    {$bind['downloads'] = strval($entry->downloads);}
    if (isset($entry->publish_up))
    {$bind['publish_up'] = strval($entry->publish_up);}
    if (isset($entry->publish_down))
    {$bind['publish_down'] = strval($entry->publish_down);}
    if (isset($entry->imagesm))
    {$bind['imagesm'] = strval($entry->imagesm);}
    if (isset($entry->imagemed))
    {$bind['imagemed'] = strval($entry->imagemed);}
    if (isset($entry->imagelrg))
    {$bind['imagelrg'] = strval($entry->imagelrg);}
    if (isset($entry->notes))
    {$bind['notes'] = strval($entry->notes);}
    if (isset($entry->notes_link))
    {$bind['notes_link'] = strval($entry->notes_link);}
    if (isset($entry->downloadvid_link))
    {$bind['downloadvid_link'] = strval($entry->downloadvid_link);}
    if (isset($entry->notes_link))
    {$bind['add_downloadvid'] = strval($entry->add_downloadvid);}
    if (isset($entry->minaccess))
    {$bind['minaccess'] = strval($entry->minaccess);}
    if (isset($entry->saccess))
    {$bind['saccess'] = strval($entry->saccess);}
    if (isset($entry->access))
    {$bind['access'] = strval($entry->access);}
    if (isset($entry->language))
    {$bind['language'] = strval($entry->language);}
    if (isset($entry->audpurchase_link))
    {$bind['audpurchase_link'] = strval($entry->audpurchase_link);}
    if (isset($entry->audpurchase))
    {$bind['audpurchase'] = strval($entry->audpurchase);}
    if (isset($entry->vidpurchase_link))
    {$bind['vidpurchase_link'] = strval($entry->vidpurchase_link);}
    if (isset($entry->vidpurchase))
    {$bind['vidpurchase'] = strval($entry->vidpurchase);}
    if (isset($entry->tags))
    {$bind['tags'] = strval($entry->tags);}
    if (isset($entry->audiofs))
    {$bind['audiofs'] = strval($entry->audiofs);}
    if (isset($entry->videofs))
    {$bind['videofs'] = strval($entry->videofs);}
    if (isset($entry->notesfs))
    {$bind['notesfs'] = strval($entry->notesfs);}
    if (isset($entry->advideofs))
    {$bind['advideofs'] = strval($entry->advideofs);}
    // set user to the one importing
    $bind['user'] = $user->id;
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
}
return true;
}

/**
     * Method to empty table.
     *
     * @param    string $table Mysql table name
     *  
     * @return  success boleen
     */

function truncate($table)
{
    $db = & JFactory::getDBO();
    $query = "TRUNCATE ".$table;
    $db->setQuery( $query );
    $db->query();
}

/**
     * Method to get folders from server and folder value string in xml file.
     *
     * @param    string $filepath server and folder value string in xml file
     *  
     * @return  folderid or null
     */

function getfolder($filepath)
{
    $db = & JFactory::getDBO();
    $folderparts = explode('||', $filepath);
    
    if (isset($folderparts[0]) && isset($folderparts[1]))
    {
        $query = " SELECT id FROM #__pifilepath WHERE server = ".$db->quote($folderparts[0])." AND folder = ".$db->quote($folderparts[1]).";";
        $db->setQuery( $query );
        $list = $db->loadObjectList();
        $no = count($list);
        if ($no > 0)
        {return $list[0]->id;} else {return null;}
    }
    else {return null;}
}

/**
     * Method to get folders from server and folder value string in xml file.
     *
     * @param    string $filepath server and folder value string in xml file
     *  
     * @return  folderid or null
     */

function getvalues($table, $entry, $string)
{
    $db = & JFactory::getDBO(); 
    $value = '';
    $i = 1;
    $array = array();
    if ($string)
    {
        $rows = explode(',', $string);
        $no = count($rows);
        if ($no > 0)
        {
            foreach ($rows AS $row)
            {
               //get teacher name
                $query = "
                 SELECT ".$db->nameQuote('id')."
                  FROM ".$db->nameQuote($table)."
                  WHERE ".$db->nameQuote($entry)." = ".$db->quote($row).";
                  ";
                  $db->setQuery($query);
                  $id = $db->loadResult(); 
                  
                  $array[] = $id;
            }
        }
    }
    $value = implode(',', $array);
    return $value;
}
  
}