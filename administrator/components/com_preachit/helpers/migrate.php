<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
jimport('teweb.admin.adjust');

class PIHelpermigrate
{

/**
     * Method to migrate sermon speaker folders
     *  
     * @return    boolean
     */
    
function migratessfolders()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_sermons';
if (in_array($table, $tables))
{
$fields = $db->getTableFields( array( $table ) );
$data = false;
$data    = isset( $fields[$table]['sermon_path'] );
$check = $data;   
if ($data)
{$index = 'sermon_path';} 
else {$index = 'audiofile'; $index2 = 'videofile';}
$query = "SELECT * FROM #__sermon_sermons";
$db->setQuery( $query );
$pathlist = $db->loadObjectList();
$i = 1;
foreach ($pathlist as $pl)
{      $row =& JTable::getInstance('filepath', 'Table');
       $bind = array();
       $bind['name'] = 'Sermon Speaker '.$i;
       $file = PIHelpermigrate::splitpath($pl->$index);
       $bind['folder'] = $file->path;
       $bind['published'] = 1;
       $bind['type'] = 0;

       $i = PIHelpermigrate::createfolders($row, $bind, $i);
       
       if (isset($index2))
       {$row =& JTable::getInstance('filepath', 'Table');
       $bind = array();
       $bind['name'] = 'Sermon Speaker '.$i;
       $file = PIHelpermigrate::splitpath($pl->$index2);
       $bind['folder'] = $file->path;
       $bind['published'] = 1;
       $bind['type'] = 0;

       $i = PIHelpermigrate::createfolders($row, $bind, $i);}
} 
return true;
}    
else {return false;}
}

/**
     * Method to migrate sermon speaker folders for pictures
     *  
     * @return    boolean
     */

function migratessfolderspics()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_speakers';
if (in_array($table, $tables))
{   
$query = "SELECT DISTINCT pic AS folder "
        . " FROM #__sermon_speakers";
$db->setQuery( $query );
$pathlist = $db->loadObjectList();
$i = 1;
foreach ($pathlist as $pl)
{      $bind = array();
       $row =& JTable::getInstance('filepath', 'Table');
       $bind['name'] = 'Sermon Speaker Pics'.$i;
       $file = PIHelpermigrate::splitpath($pl->folder);
       $bind['folder'] = $file->path;
       $bind['published'] = 1;
       $bind['type'] = 0;
         
       $i = PIHelpermigrate::createfolders($row, $bind, $i);
}
return true;   
}   
else {return false;}
}    

/**
     * Method to migrate sermon speaker series
     *  
     * @return    boolean
     */

function migratessseries()
{
$db    = & JFactory::getDBO();
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_series';
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__sermon_series";
$db->setQuery( $query );
$serieslist = $db->loadObjectList();   
foreach ($serieslist AS $sl)
{   $bind = array();
    $row =& JTable::getInstance('Series', 'Table');  
    $bind['series_name'] = $sl->series_title;
    $bind['published'] = $sl->published;
    $bind['user'] = $sl->created_by;
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitiseseriesrow($row);
    $row->series_description = $sl->series_description;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
return true;  
}  
else {return false;}
}

/**
     * Method to migrate sermon speaker teachers
     *  
     * @return    boolean
     */

function migratessteachers()
{ 
$db    = & JFactory::getDBO(); 
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_speakers';
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__sermon_speakers";
$db->setQuery( $query );
$teacherlist = $db->loadObjectList();   
foreach ($teacherlist AS $tl)
{   $bind = array();
    $row =& JTable::getInstance('Teachers', 'Table'); 
    $name = explode(' ', $tl->name);
    if (!isset($name[1]))
    {
        $bind['teacher_name'] = '';
        $bind['lastname'] = $name[0];
        $test = true;
    }
    else {
        $bind['lastname'] = str_replace($name[0].' ', '', $tl->name);
        $bind['teacher_name'] = $name[0];  
    }
    $bind['published'] = $tl->published;
    $bind['user'] = $tl->created_by;
    $bind['teacher_website'] = $tl->website;
    
    $file = PIHelpermigrate::splitpath($tl->pic);
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('folder')." = ".$db->quote($file->path).";
  ";
    $db->setQuery($query);
    $folder = $db->loadResult();  
    
    $bind['image_folder'] = $folder;
    $bind['image_folderlrg'] = $folder;
    $bind['teacher_image_sm'] = $file->name;
    $bind['teacher_image_lrg'] = $file->name;
  
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitiseteacherrow($row);
    $row->teacher_description = $tl->intro;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
return true;     
}   
else {return false;}
}

/**
     * Method to migrate sermon speaker messages
     *  
     * @return    boolean
     */

function migratessmessages()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_sermons';
if (in_array($table, $tables))
{
$fields = $db->getTableFields( array( $table ) );
$data = false;
$data    = isset( $fields[$table]['sermon_path'] );
$check = $data;   
if ($data)
{$index = 'sermon_path';} 
else {$index = 'audiofile'; $index2 = 'videofile';}
$query = " SELECT * FROM #__sermon_sermons";
$db->setQuery( $query );
$messagelist = $db->loadObjectList();   
foreach ($messagelist AS $ml)
{   $bind = array();
    $row =& JTable::getInstance('Studies', 'Table'); 
    $bind['study_name'] = $ml->sermon_title;
    $bind['published'] = $ml->published;
    $bind['user'] = $ml->created_by;
    $bind['study_date'] = Tewebadjust::adjustdate($ml->sermon_date, null);
    $bind['publish_up'] = Tewebadjust::adjustdate($ml->created_on, null);
    $bind['hits'] = $ml->hits;
    
    // get series
    
    $query = "
    SELECT ".$db->nameQuote('series_title')."
    FROM ".$db->nameQuote('#__sermon_series')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->series_id).";
  ";
    $db->setQuery($query);
    $name = $db->loadResult();  
    
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('series_name')." = ".$db->quote($name).";
  ";
    $db->setQuery($query);
    $series = $db->loadResult();  
    
    $bind['series'] = $series;
    
    // get teacher
    
    $query = "
    SELECT ".$db->nameQuote('name')."
    FROM ".$db->nameQuote('#__sermon_speakers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->speaker_id).";
  ";
    $db->setQuery($query);
    $name = $db->loadResult();  
    
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piteachers').PIHelpermigrate::getteachwhere($name);
    $db->setQuery($query);
    $teacher = $db->loadResult();         
    
    // get duration
    
    $duration = $ml->sermon_time;
    $duration = explode(':', $duration);
    $bind['dur_hrs'] = $duration[0];
    $bind['dur_mins'] = $duration[1];
    $bind['dur_secs'] = $duration[2];
    
    // get audio folder and file
    
    $file = PIHelpermigrate::splitpath($ml->$index);
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('folder')." = ".$db->quote($file->path).";
  ";
    $db->setQuery($query);
    $folder = $db->loadResult();  
    
    $bind['audio_folder'] = $folder;
    $bind['audio_link'] = $file->name;
    $bind['audio_type'] = 6;
    $bind['audio_download'] = 1;
    
    if ($file->name)
    {
        $bind['audio'] = 1;
    }
    else {$bind['audio'] = 0;}
    
    // get video if SS 4
    
    if (isset($index2))
    {$file = PIHelpermigrate::splitpath($ml->$index2);
    
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('folder')." = ".$db->quote($file->path).";
  ";
    $db->setQuery($query);
    $folder = $db->loadResult();  
    
    $bind['video_folder'] = $folder;
    $bind['video_link'] = $file->name;
    $bind['video_type'] = 1;
    $bind['video_download'] = 1;
    
    if ($file->name)
    {
        $bind['video'] = 1;
    }
    else {$bind['video'] = 0;}}
    
    $bind['studylist'] = 1;
    
    // get scripture
                      
    $scripture = PIHelpermigrate::getscripture($ml->sermon_scripture);                 
    $bind['study_book'] = $scripture->book;
    $bind['ref_ch_beg'] = $scripture->ref_ch_beg;
    if (!$scripture->ref_ch_end && $scripture->ref_vs_end)
    {$bind['ref_ch_end'] = $scripture->ref_ch_beg;}
    else {$bind['ref_ch_end'] = $scripture->ref_ch_end;}
    $bind['ref_vs_beg'] = $scripture->ref_vs_beg;
    $bind['ref_vs_end'] = $scripture->ref_vs_end;
    
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitisestudyrow($row);
    $row->study_description = $ml->notes;
    $row->teacher = $teacher;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
return true;    
}   
else {return false;}
}    

/**
     * Method to migrate JBS folders
     *  
     * @return    boolean
     */
 
function migratejbsfolders()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_servers';
if (in_array($table, $tables))
{
$query = "SELECT * FROM #__bsms_servers";
$db->setQuery( $query );
$pathlist = $db->loadObjectList();
$i = 1;
foreach ($pathlist as $pl)
{ 

$query = "SELECT * FROM #__bsms_folders";
$db->setQuery( $query );
$folderlist = $db->loadObjectList();
        
foreach ($folderlist as $fl)
{       $bind = array();
        $row =& JTable::getInstance('filepath', 'Table');
        $bind['name'] = 'Joomla Bible Study '.$i;
        $bind['folder'] = $fl->folderpath;
        $bind['server'] = $pl->server_path;
        $bind['published'] = 1;
        if ($pl->server_path != JURI::BASE())
        {$bind['type'] = 0;}
        else {$bind['type'] = 1;}

       // check doesn't already exist
        $server = null;
        $query = "
        SELECT ".$db->nameQuote('id')."
        FROM ".$db->nameQuote('#__pifilepath')."
        WHERE ".$db->nameQuote('folder')." = ".$db->quote($fl->folderpath).";
        ";
        $db->setQuery($query);
        $folder = $db->loadResult(); 
        
        if ($folder)
        {$query = "
        SELECT ".$db->nameQuote('server')."
        FROM ".$db->nameQuote('#__pifilepath')."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($folder).";
        ";
        $db->setQuery($query);
        $server = $db->loadResult();} 
        
       if (!$folder  && $server != $pl->server_path) 
       {
       if (!$row->bind($bind))
       {JError::raiseError(500, $row->getError() );}
       if (!$row->store())
       {JError::raiseError(500, $row->getError() );}
       $i++; }
}
} 
return true;
}    
else {return false;}
}

/**
     * Method to migrate JBS folders for pictures
     *  
     * @return    boolean
     */

function migratejbsfolderspics()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_teachers';
if (in_array($table, $tables))
{  
$query = "SELECT DISTINCT image AS folder "
        . " FROM #__bsms_teachers";
$db->setQuery( $query );
$pathlist = $db->loadObjectList();
$i = 1;

foreach ($pathlist as $pl)
{      $bind = array();
       $row =& JTable::getInstance('filepath', 'Table');
       $bind['name'] = 'Joomla Bible Study Teacher '.$i;
       $file = PIHelpermigrate::splitpath($pl->folder);
       $bind['folder'] = $file->path;
       $bind['published'] = 1;
       $bind['type'] = 0;
       $i = PIHelpermigrate::createfolders($row, $bind, $i);
}  

$query = "SELECT DISTINCT thumb AS folder "
        . " FROM #__bsms_teachers";
$db->setQuery( $query );
$pathlist = $db->loadObjectList();

foreach ($pathlist as $pl)
{      $bind = array();
       $row =& JTable::getInstance('filepath', 'Table');
       $bind['name'] = 'Joomla Bible Study Teacher '.$i;
       $file = PIHelpermigrate::splitpath($pl->folder);
       $bind['folder'] = $file->path;
       $bind['published'] = 1;
       $bind['type'] = 0;
       $i = PIHelpermigrate::createfolders($row, $bind, $i);
} 

return true;   
}    
else {return false;}
}    

/**
     * Method to migrate JBS series
     *  
     * @return    boolean
     */

function migratejbsseries()
{
$db    = & JFactory::getDBO();
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_series';
$user    = JFactory::getUser();
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__bsms_series";
$db->setQuery( $query );
$serieslist = $db->loadObjectList();   
foreach ($serieslist AS $sl)
{   $bind = array();
    $row =& JTable::getInstance('Series', 'Table');  
    $bind['series_name'] = $sl->series_text;
    $bind['published'] = $sl->published;
    $bind['user'] = $user->id;
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitiseseriesrow($row);
    $row->series_description = $sl->description;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
return true;  
}  
else {return false;}
}

/**
     * Method to migrate JBS teachers
     *  
     * @return    boolean
     */

function migratejbsteachers()
{ 
$db    = & JFactory::getDBO(); 
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_teachers';
$user    = JFactory::getUser();
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__bsms_teachers";
$db->setQuery( $query );
$teacherlist = $db->loadObjectList();   
foreach ($teacherlist AS $tl)
{   $bind = array();
    $row =& JTable::getInstance('Teachers', 'Table'); 
    $name = explode(' ', $tl->teachername);
    if (!isset($name[1]))
    {
        $bind['teacher_name'] = '';
        $bind['lastname'] = $name[0];
        $test = true;
    }
    else {
        $bind['lastname'] = str_replace($name[0].' ', '', $tl->teachername);
        $bind['teacher_name'] = $name[0];  
    }
    $bind['published'] = $tl->published;
    $bind['user'] = $user->id;
    $bind['teacher_website'] = $tl->website;
    
    $file = PIHelpermigrate::splitpath($tl->image);
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('folder')." = ".$db->quote($file->path).";
  ";
    $db->setQuery($query);
    $folder = $db->loadResult();  
    
    $bind['image_folderlrg'] = $folder;
    $bind['teacher_image_lrg'] = $file->name;
    
    $file = PIHelpermigrate::splitpath($tl->thumb);
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('folder')." = ".$db->quote($file->path).";
  ";
    $db->setQuery($query);
    $folder = $db->loadResult(); 
    
    $bind['image_folder'] = $folder;
    $bind['teacher_image_sm'] = $file->name;
  
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitiseteacherrow($row);
    $row->teacher_description = $tl->information;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}
return true;     
}   
else {return false;}
}

function getteachwhere($teachername)
{    $db    = & JFactory::getDBO();
    $name = explode(' ', $teachername);
    if (!isset($name[1]))
    {
        $where = "WHERE ".$db->nameQuote('lastname')." = ".$db->quote($name).";";
    }
    else {
        $where = "WHERE ".$db->nameQuote('lastname')." = ".$db->quote(str_replace($name[0].' ', '', $teachername))." AND ".$db->nameQuote('teacher_name')." = ".$db->quote($name[0]).";"; 
    }
    return $where;
}

/**
     * Method to migrate JBS messages
     *  
     * @return    boolean
     */

function migratejbsmessages()
{
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_studies';
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__bsms_studies";
$db->setQuery( $query );
$messagelist = $db->loadObjectList();   
foreach ($messagelist AS $ml)
{   $bind = array();
    $row =& JTable::getInstance('Studies', 'Table'); 
    $bind['study_name'] = $ml->studytitle;
    $bind['published'] = $ml->published;
    $bind['user'] = $ml->user_id;
    $bind['study_date'] = $ml->studydate;
    $bind['publish_up'] = $ml->studydate;
    $bind['hits'] = $ml->hits;
    
    // get series
    
    $query = "
    SELECT ".$db->nameQuote('series_text')."
    FROM ".$db->nameQuote('#__bsms_series')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->series_id).";
  ";
    $db->setQuery($query);
    $name = $db->loadResult();  
    
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('series_name')." = ".$db->quote($name).";
  ";
    $db->setQuery($query);
    $series = $db->loadResult();  
    
    $bind['series'] = $series;
    
    // get teacher
    
    $query = "
    SELECT ".$db->nameQuote('teachername')."
    FROM ".$db->nameQuote('#__bsms_teachers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->teacher_id).";
  ";
    $db->setQuery($query);
    $name = $db->loadResult();  
    
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piteachers').PIHelpermigrate::getteachwhere($name);   
    $db->setQuery($query);    
    $teacher = $db->loadResult();   
    
    // get duration
    
    $bind['dur_hrs'] = $ml->media_hours;
    $bind['dur_mins'] = $ml->media_minutes;
    $bind['dur_secs'] = $ml->media_seconds;
    
    // get audio folder and file
    
    $file = PIHelpermigrate::getjbsmedia($ml);
    
    $bind['audio_folder'] = $file['audio_folder'];
    $bind['audio_link'] = $file['audio_link'];
    $bind['audio_type'] = $file['audio_type'];
    $bind['audio_download'] = $file['audio_download'];
    $bind['audiofs'] = $file['audiofs'];
    
    if ($file['audio_link'])
    {
        $bind['audio'] = 1;
    }
    else {$bind['audio'] = 0;}
    
    $bind['video_folder'] = $file['video_folder'];
    $bind['video_link'] = $file['video_link'];
    $bind['video_type'] = $file['video_type'];
    $bind['video_download'] = $file['video_download'];
    $bind['videofs'] = $file['videofs'];
    
    if ($file['video_link'])
    {
        $bind['video'] = 1;
    }
    else {$bind['video'] = 0;}
    
    $bind['notes_folder'] = $file['notes_folder'];
    $bind['notes_link'] = $file['notes_link'];
    $bind['notesfs'] = $file['notesfs'];
    
    if ($file['notes_link'])
    {
        $bind['notes'] = 1;
    }
    else {$bind['notes'] = 0;}
    
    $bind['studylist'] = 1;
    
    // get scripture
    
    if ($ml->booknumber != 0 || $ml->booknumber != -1)                             
    {$bind['study_book'] = $ml->booknumber - 100;}
    else {$bind['study_book'] = 0;}
    $bind['ref_ch_beg'] = $ml->chapter_begin;
    $bind['ref_ch_end'] = $ml->chapter_end;
    $bind['ref_vs_beg'] = $ml->verse_begin;
    $bind['ref_vs_end'] = $ml->verse_end;
    
    if ($ml->booknumber2 != 0 || $ml->booknumber2 != -1)                             
    {$bind['study_book2'] = $ml->booknumber2 - 100;}
    else {$bind['study_book2'] = 0;}
    $bind['ref_ch_beg2'] = $ml->chapter_begin2;
    $bind['ref_ch_end2'] = $ml->chapter_end2;
    $bind['ref_vs_beg2'] = $ml->verse_begin2;
    $bind['ref_vs_end2'] = $ml->verse_end2;
    
    if (!$row->bind($bind))
    {JError::raiseError(500, $row->getError() );}
    // sanitise and allow raw entries
    $row = PIHelperadmin::sanitisestudyrow($row);
    $row->study_description = $ml->studyintro;
    $row->teacher = $teacher;
    if (!$row->store())
    {JError::raiseError(500, $row->getError() );}
}   
    return true;    
}   
else {return false;}
}       

/**
     * Method to attach jbs media to message record
     *  
     * @return    string
     */

function getjbsmedia ($row)
{
$db    = & JFactory::getDBO();
jimport('joomla.filesystem.file');
$file['audio_folder'] = null;
$file['audio_link'] = null;
$file['audio_type'] = null;
$file['audio_download'] = null;
$file['audiofs'] = null;
$file['video_folder'] = null;
$file['video_link'] = null;
$file['video_type'] = null;
$file['video_download'] = null;
$file['videofs'] = null;
$file['notes_folder'] = null;
$file['notes_link'] = null;
$file['notesfs'] = null;
$audio = 0;
$video = 0;
$notes = 0;

$audioext = array('mp3', 'aac', 'wma', 'wav', 'rpm', 'rm', 'ra', 'mp2');
$videoext = array('mp4', 'mpeg', 'm4v', 'mpg', 'avi', 'wmv', 'flv' );
$notesext = array('doc', 'pdf' );

$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_mediafiles';
if (in_array($table, $tables))
{
$query = " SELECT * FROM #__bsms_mediafiles WHERE study_id = ".$row->id;
$db->setQuery( $query );
$medialist = $db->loadObjectList();

foreach ($medialist AS $ml)
{
    if ($ml->filename)
    {
        $query = "
        SELECT ".$db->nameQuote('folderpath')."
        FROM ".$db->nameQuote('#__bsms_folders')."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->path).";
        ";
        $db->setQuery($query);
        $folder = $db->loadResult(); 
        
        $query = "
        SELECT ".$db->nameQuote('server_path')."
        FROM ".$db->nameQuote('#__bsms_servers')."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($ml->server).";
        ";
        $db->setQuery($query);
        $server = $db->loadResult(); 
        
        $query = "
        SELECT ".$db->nameQuote('id')."
        FROM ".$db->nameQuote('#__pifilepath')."
        WHERE ".$db->nameQuote('folder')." = ".$db->quote($folder)."
        AND ".$db->nameQuote('server')." = ".$db->quote($server).";
        ";
        $db->setQuery($query);
        $folderid = $db->loadResult(); 
        
        $ext =  JFile::getExt($ml->filename);
        
        if (in_array($ext, $audioext) && $audio == 0)
        {
            $file['audio_folder'] = $folderid;
            $file['audio_link'] = $ml->filename;
            $file['audio_type'] = 6; // what if real or wma
            if ($ml->link_type == 1 || $ml->link_type == 2)
            {$file['audio_download'] = 1;}
            else {$file['audio_download'] = 0;}
            $file['audiofs'] = $ml->size;
            $audio = 1;
        }
        
        elseif (in_array($ext, $videoext) && $video == 0)
        {
            $file['video_folder'] = $folderid;
            $file['video_link'] = $ml->filename;
            $file['video_type'] = 1;
            if ($ml->link_type == 1 || $ml->link_type == 2)
            {$file['video_download'] = 1;}
            else {$file['video_download'] = 0;}
            $file['videofs'] = $ml->size;
            $audio = 1;
        }
        
        elseif (in_array($ext, $notesext) && $notes == 0)
        {
            $file['notes_folder'] = $folderid;
            $file['notes_link'] = $ml->filename;
            $file['notesfs'] = $ml->size;
            $notes = 1;
        }
    }
    
    else
    {
        $vimeo = false;
        $youtube = false;
        $allvideocode = $ml->mediacode;
        
        // see what vimeo or Youtube tags
        
        $vimeo = substr_count($allvideocode,'{vimeo}');
        $youtube = substr_count($allvideocode,'{youtube}');
        
        if ($vimeo > 0  && $video == 0)
        {
        // get vimeo code
        
        $vimeocode = str_replace('{vimeo}', '', $allvideocode);
        $vimeocode = str_replace('{/vimeo}', '', $code);
        
        // set variables
        
        $file['video_link'] = $vimeocode;
        $file['video_type'] = 2;
        $file['video_download'] = 0;
        $video = 1;
        }
    
        if ($youtube > 0 && $video == 0)
        {
        // get youtube code
        
        $ytcode = str_replace('{youtube}', '', $allvideocode);
        $ytcode = str_replace('{/youtube}', '', $code);
        
        // set variables
        
        $file['video_link'] = $ytcode;
        $file['video_type'] = 3;
        $file['video_download'] = 0;
        $video = 1;
        }  
    }    
}    
}
return $file;
} 

/**
     * Method to migrate Sermon manager messages
     *  
     * @return    boolean
     */

function migratesm()
{
    //check tables are there
    $db    = & JFactory::getDBO();
    $tables = $db->getTableList();
    $prefix = $db->getPrefix();
    $table = $prefix.'submitsermon';
    $user    = JFactory::getUser();
    if (in_array($table, $tables))
    {
        // load records
        $query = "SELECT * FROM #__submitsermon";
        $db->setQuery( $query );
        $records = $db->loadObjectList();
        foreach ($records AS $record)
        {
            $row =& JTable::getInstance('Studies', 'Table');
            $bind = array();
            $bind['study_name'] = $record->sermontitle;
            $bind['study_date'] = $record->sermondate;
            $bind['publish_up'] = $record->sermondate;
            $bind['published'] = $record->published;
            $bind['series'] = PIHelpermigrate::getsmseries($record);
            $bind['imagesm'] = PIHelpermigrate::checkurl($record->image);
            $bind['imagemed'] = PIHelpermigrate::checkurl($record->image);
            $bind['imagelrg'] = PIHelpermigrate::checkurl($record->image);
            $bind['studylist'] = 1;
            $bind['hits'] = $record->hits;
            $bind['user'] = $user->id;
            if ($record->audio)
            {$bind['audio'] = 1;
            $bind['audio_link'] = PIHelpermigrate::checkurl($record->audio);
            $bind['audio_type'] = 6;
            $bind['audio_download'] = 1;}
            else {$bind['audio'] = 0;}
            if ($record->video)
            {$bind['video'] = 1;
            $bind['video_link'] = PIHelpermigrate::getsmvideo($record);
            $bind['video_type'] = PIHelpermigrate::getsmvplayer($record);
            $bind['video_download'] = PIHelpermigrate::getsmvdown($record);}
            else {$bind['video'] = 0;}
            if ($record->doc)
            {$bind['notes'] = 1;
            $bind['notes_link'] = PIHelpermigrate::checkurl($record->doc);}
            else {$bind['notes'] = 0;}
        
            // get scripture
            if ($record->passage)     
            {$refs = PIHelpermigrate::splitscripture($record->passage);
                   
            if (isset($refs[0]))
            {$scripture = PIHelpermigrate::getscripture($refs[0]);              
            $bind['study_book'] = $scripture->book;
            $bind['ref_ch_beg'] = $scripture->ref_ch_beg;
            if (!$scripture->ref_ch_end && $scripture->ref_vs_end)
            {$bind['ref_ch_end'] = $scripture->ref_ch_beg;}
            else {$bind['ref_ch_end'] = $scripture->ref_ch_end;}
            $bind['ref_vs_beg'] = $scripture->ref_vs_beg;
            $bind['ref_vs_end'] = $scripture->ref_vs_end;}
            
            if (isset($refs[1]))
            {$scripture2 = PIHelpermigrate::getscripture($refs[1]);                 
            $bind['study_book2'] = $scripture2->book;
            $bind['ref_ch_beg2'] = $scripture2->ref_ch_beg;
            if (!$scripture->ref_ch_end && $scripture->ref_vs_end)
            {$bind['ref_ch_end2'] = $scripture->ref_ch_beg;}
            else {$bind['ref_ch_end2'] = $scripture->ref_ch_end;}
            $bind['ref_vs_beg2'] = $scripture2->ref_vs_beg;
            $bind['ref_vs_end2'] = $scripture2->ref_vs_end;}
            }
            if (!$row->bind($bind))
            {JError::raiseError(500, $row->getError() );}
            // sanitise and allow raw entries
            $row = PIHelperadmin::sanitisestudyrow($row);
            // get study dates if needed
            $row = PIHelperadmin::getstudydates($row);    
            $row->study_description = $record->sermondescription;
            $row->teacher = PIHelpermigrate::getsmteacher($record);
            if (!$row->store())
            {JError::raiseError(500, $row->getError() );}
            
        }
    }
    return true;
}

/**
     * Method to migrate create folder record folders
     *  @param array $row table values
     * @param array $bind folder details to save
     * @param int $i numerical index value
     * @return    boolean
     */

function createfolders($row, $bind, $i)
{
$db    = & JFactory::getDBO();
// check doesn't already exist
        
$query = "
SELECT ".$db->nameQuote('id')."
FROM ".$db->nameQuote('#__pifilepath')."
WHERE ".$db->nameQuote('folder')." = ".$db->quote($bind['folder']).";
";
$db->setQuery($query);
$folder = $db->loadResult(); 
if (!$folder && $bind['folder']) 
{if (!$row->bind($bind))
{JError::raiseError(500, $row->getError() );}
if (!$row->store())
{JError::raiseError(500, $row->getError() );}
$i++; }      
return $i;     
}

/**
     * Method to split path up into parts that can be entered into folders table
     * @param string $path full path to split
     *  
     * @return    array path parts
     */
 
function splitpath($path)
{
    $parts = explode('/', $path);
    $no = count($parts);
    if ($no > 1)
    {
        $index = $no - 1;
        $file->name = $parts[$index];
        $file->path = str_replace($file->name, '', $path);
        $first = substr($file->path, 0, 1);
        if ($first == '/')
        {$file->path = substr_replace($file->path,'',0, 1);}
    }
    else {$file->name = $path; $file->path = '';}
    return $file;
}    

/**
     * Method to split scripture ref into Preachit compatible array
     *  @param string $sermon_scripture full scripture reference
     * @return    array
     */

 function getscripture ($sermon_scripture)
    {
        $db    = & JFactory::getDBO();
        $scripture->book = null;
        $scripture->book = null;
        $scripture->ref_ch_beg = null;
        $scripture->ref_ch_end = null;
        $scripture->ref_vs_beg = null;
        $scripture->ref_vs_end = null;
        
        preg_match("/\d/is", substr($sermon_scripture, 2), $mList, PREG_OFFSET_CAPTURE);
        if (isset($mList[0][1]))
        {$firstnumber = $mList[0][1];} else {$firstnumber = null;}
        if ($firstnumber)
        {$firstnumber = $firstnumber + 2;
        $book = substr($sermon_scripture, 0, $firstnumber); }
        else {$book = $sermon_scripture;}

        $query = "
         SELECT ".$db->nameQuote('id')."
          FROM ".$db->nameQuote('#__pibooks')."
           WHERE LOWER (".$db->nameQuote('display_name').") = LOWER (".$db->quote($book).");
           ";     
            $db->setQuery($query);
             $scripture->book = $db->loadResult();  
        
    if ($scripture->book)
        {
        $firstspace = strpos($sermon_scripture,' ',2);
        $firstcolon = strpos($sermon_scripture,':');
        $firstdash = strpos($sermon_scripture,'-');
        
        $issecondcolon = substr_count($sermon_scripture,':',$firstcolon + 1);
        if ($issecondcolon) {$secondcolon = strpos($sermon_scripture, ':', $firstcolon + 1);}
        $scripture->ref_ch_beg = substr($sermon_scripture,$firstspace + 1,($firstcolon - $firstspace) - 1);
        
        if (!$firstdash) {$scripture->ref_vs_beg = substr($sermon_scripture,$firstcolon + 1);}
        else {$scripture->ref_vs_beg = substr($sermon_scripture,$firstcolon + 1,$firstdash - ($firstcolon + 1));}
        if (!$issecondcolon) {$scripture->ref_ch_end = '';}
        else 
            {
            $scripture->ref_ch_end = substr($sermon_scripture, $firstdash + 1,($secondcolon - $firstdash) - 1);
            $scripture->ref_vs_end = substr($sermon_scripture,$secondcolon + 1);
            }
        if (!$issecondcolon && $firstdash)
        {
            $scripture->ref_vs_end = substr($sermon_scripture, $firstdash + 1);
        }    
    }
        return $scripture;
    }  
    
/**
     * Method to get series id and if needed create series record
     *  @param array $record sermon manager record details
     * @return    int
     */
     
function getsmseries($record)
{
    $user    = JFactory::getUser();
    $name = $record->sermonseries;
    $db    = & JFactory::getDBO(); 
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piseries')."
    WHERE ".$db->nameQuote('series_name')." = ".$db->quote($name).";
  ";
    $db->setQuery($query);
    $series = $db->loadResult();  
    
    if ($series > 0)
    {return $series;}
    else {
        if ($record->sermonseries && $record->sermonseries != '-')
        {
        $bind = array();
        $row =& JTable::getInstance('Series', 'Table');  
        $bind['series_name'] = $record->sermonseries;
        $bind['published'] = 1;
        $bind['user'] = $user->id;
        if (!$row->bind($bind))
        {JError::raiseError(500, $row->getError() );}
        // sanitise and allow raw entries
        $row = PIHelperadmin::sanitiseseriesrow($row);
        if (!$row->store())
        {JError::raiseError(500, $row->getError() );}
        return $row->id;
    }
    }
}     

/**
     * Method to get teacher id and if needed create teacher record
     *  @param array $record sermon manager record details
     * @return    int
     */

function getsmteacher($record)
{
    $user    = JFactory::getUser();
    $name = $record->speakername;
    $db    = & JFactory::getDBO(); 
    $query = "
    SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__piteachers')."
    WHERE ".$db->nameQuote('teacher_name')." = ".$db->quote($name).";
  ";
    $db->setQuery($query);
    $series = $db->loadResult();  
    
    if ($series > 0)
    {return $series;}
    else {
        if ($record->speakername && $record->speakername != '-')
        {
        $bind = array();
        $row =& JTable::getInstance('Teachers', 'Table');  
        $bind['teacher_name'] = $record->speakername;
        $bind['published'] = 1;
        $bind['user'] = $user->id;
        if (!$row->bind($bind))
        {JError::raiseError(500, $row->getError() );}
        // sanitise and allow raw entries
        $row = PIHelperadmin::sanitiseteacherrow($row);
        if (!$row->store())
        {JError::raiseError(500, $row->getError() );}
        return $row->id;
    }
    }
}  

/**
     * Method to get video entry
     *  @param array $record sermon manager record details
     * @return    string
     */

function getsmvideo($record)
{   $check = false;
    //find out if this is vimeo
    if ($record->youtubes)
    {$check = PIHelpermigrate::checkvimeo($record->youtubes);}
    if ($check == false)
    {$video = PIHelpermigrate::checkurl($record->video);}
    else {$video = PIHelpermigrate::getvimeocode($record->youtubes);}
    return $video;
} 

/**
     * Method to get video player
     *  @param array $record sermon manager record details
     * @return    int
     */

function getsmvplayer($record)
{
    $check = false;
    //find out if this is vimeo
    if ($record->youtubes)
    {$check = PIHelpermigrate::checkvimeo($record->youtubes);}
    if (!$check)
    {$player = 1;}
    else {$player = 2;}
    return $player;
} 

/**
     * Method to get video download entry
     *  @param array $record sermon manager record details
     * @return   int
     */

function getsmvdown($record)
{
    $check = false;
    //find out if this is vimeo
    if ($record->youtubes)
    {$check = PIHelpermigrate::checkvimeo($record->youtubes);}
    if (!$check)
    {$down = 1;}
    else {$down = 0;}
    return $down;
} 

/**
     * Method to check if full url and if not make up to full url
     *  @param string $url rul entry in record
     * @return   int
     */

function checkurl($url)
{
    if (strpos($url, 'ttp://') > 0 || strpos($url, 'ttps://') > 0 || strpos($url, 'tp://') > 0)
    {return $url;}
    else {
    //remove first / if present from audio
    $first = substr($url, 0, 1);
    if ($first == '/')
    {$url = substr_replace($url,'',0, 1);}
    return JURI::root().$url;}
}

/**
     * Method to check whether vimeo video
     *  @param string $string embed code
     * @return    boolean
     */
     
function checkvimeo($string)
{
    $pos = strpos($string, 'vimeo');
    if ($pos === false) {
   return false;} 
   else {return true;}
}

/**
     * Method to get video code from vimeo embed code
     * @param string $string embed code
     * @return    int
     */

function getvimeocode($string)
{
    $vimeo = null;
    $posnew = null;
    $posold = null;
    $newcode = 'http://player.vimeo.com/video/';
    $oldcode = 'http://vimeo.com/moogaloop.swf?clip_id=';
    $posnew = strpos($string, $newcode);
    $posold = strpos($string, $oldcode);
    if ($posnew > 0)
    {$start = $posnew + 30;
    //get from start to the end of string
    $code = substr($string, $start);
    //explode around ?
    $array = explode('?', $code);
    // make sure no /
    $finalarray = explode('\\', $array[0]);
    //get number from first of array
    $vimeo = $finalarray[0];
    } 
    elseif ($posold > 0)
    { $start = $posold + 39;
    //get from start to the end of string
    $code = substr($string, $start);
    //explode around &
    $array = explode('&', $code);
    //get number from first of array
    $vimeo = $array[0];}
    return $vimeo; 
}

/**
     * Method to split multiple scripture references
     * @param string $passage Sermon manager scripture ref entry
     * @return    array
     */

function splitscripture($passage)
{
    // get the first number of chapter & verse ref
    preg_match("/\d/is", substr($passage, 2), $mList, PREG_OFFSET_CAPTURE);
    if (isset($mList[0][1]))
    {$firstnumber = $mList[0][1] + 2;} else {$firstnumber = null;}
    // from first number look ahead to see if there is a second reference
    if ($firstnumber)
    {preg_match("/[a-zA-Z]/is", substr($passage, $firstnumber), $mlist, PREG_OFFSET_CAPTURE);
    if (isset($mlist[0][1]))
    {$secondref = $mlist[0][1] + $firstnumber;} else {$secondref = null;}
    } else {$secondref = null;}
    // if no second reference set refs[0] and if there is a second reference separate out
    if (!$secondref)
    {$refs[0] = trim($passage);}
    else
    {// set refs[0] as the first reference and trim
    $refs[0] = trim(substr($passage, 0, $secondref - 1));
    // remove first passage from the string
    $secondpassage = substr($passage, $secondref);
    // get the first number of this new reference
    preg_match("/\d/is", substr($secondpassage, 2), $mList, PREG_OFFSET_CAPTURE);
    if (isset($mList[0][1]))
    {$firstnumber = $mList[0][1] + 2;} else {$firstnumber = null;}
    // from first number look ahead to see if there is a third reference
    preg_match("/[a-zA-Z]/is", substr($secondpassage, $firstnumber), $mlist, PREG_OFFSET_CAPTURE);
    if (isset($mlist[0][1]))
    {$thirdref = $mlist[0][1] + $firstnumber;} else {$thirdref = null;}
    // if no third reference set refs[0] and if there is a third reference separate out
        if (!$thirdref)
        {$refs[1] = $secondpassage;}
        else
        {$refs[1] = trim(substr($passage, 0, $thirdref - 1));}
    }
    
  return $refs;
}
		

}
