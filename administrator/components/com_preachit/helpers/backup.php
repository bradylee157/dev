<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

class PIHelperbackup
{

/**
     * Method to backup preachit records
     * return boolean
    */
    
function backup()
{
// build xml
$xml = null;
$xml = '<?xml version="1.0"?><tables type="pibackup">';
$xml .= PIHelperbackup::getmediaplayers();
$xml .= PIHelperbackup::getsharecode();
$xml .= PIHelperbackup::getfolders();
$xml .= PIHelperbackup::getministries();
$xml .= PIHelperbackup::getseries();
$xml .= PIHelperbackup::getteachers();
$xml .= PIHelperbackup::getmessages();
$xml .= PIHelperbackup::getpodcasts();
$xml .= '</tables>';  

// set download
$dateformat = 'Hi_Y-m-d';
$filename = 'pibackup_'.JHTML::Date('now', $dateformat);
$sizeofheader = "Content-Length: ";
$user_agent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
while (@ob_end_clean());
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: text/xml");
header("Content-Transfer-Encoding: binary");
//header($sizeofheader); 

echo $xml;
}  

/**
     * Method to get mediaplayer records
     * return boolean
    */ 

function getmediaplayers()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__pimediaplayers";
$db->setQuery( $query );
$mplist = $db->loadObjectList();  
foreach ($mplist AS $mp)
{
    $entry = null;
    $entry .= '<mptable>';
    $entry .= '<id>'.$mp->id.'</id>';
    if ($mp->playername)
    {$entry .= '<playername><![CDATA['.$mp->playername.']]></playername>';}
    $entry .= '<playertype>'.$mp->playertype.'</playertype>';
    if ($mp->playercode)
    {$entry .= '<playercode><![CDATA['.$mp->playercode.']]></playercode>';}
    if ($mp->playerscript)
    {$entry .= '<playerscript><![CDATA['.$mp->playerscript.']]></playerscript>';}
    if ($mp->playerurl)
    {$entry .= '<playerurl><![CDATA['.$mp->playerurl.']]></playerurl>';}
    $entry .= '<published>'.$mp->published.'</published>';
    $entry .= '<html5>'.$mp->html5.'</html5>';
    $entry .= '<image>'.$mp->image.'</image>';
    $entry .= '<facebook>'.$mp->facebook.'</facebook>';
    $entry .= '</mptable>';
    $xml .= $entry;
}   
return $xml;    
}

/**
     * Method to get mediaplayer records
     * return boolean
    */ 

function getsharecode()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__pishare";
$db->setQuery( $query );
$sharelist = $db->loadObjectList();  
foreach ($sharelist AS $share)
{
    $entry = null;
    $entry .= '<sharetable>';
    $entry .= '<id>'.$share->id.'</id>';
    if ($share->name)
    {$entry .= '<name><![CDATA['.$share->name.']]></name>';}
    if ($share->code)
    {$entry .= '<code><![CDATA['.$share->code.']]></code>';}
    if ($share->script)
    {$entry .= '<script><![CDATA['.$share->script.']]></script>';}
    $entry .= '<published>'.$share->published.'</published>';
    $entry .= '<ordering>'.$share->ordering.'</ordering>';
    $entry .= '</sharetable>';
    $xml .= $entry;
}   
return $xml;    
}


/**
     * Method to get folder records
     * return boolean
    */ 

function getfolders()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__pifilepath";
$db->setQuery( $query );
$filelist = $db->loadObjectList();  
foreach ($filelist AS $file)
{
    $entry = null;
    $entry .= '<filepathtable>';
    $entry .= '<id>'.$file->id.'</id>';
    if ($file->name)
    {$entry .= '<name><![CDATA['.$file->name.']]></name>';}
    if ($file->server)
    {$entry .= '<server><![CDATA['.$file->server.']]></server>';}
    if ($file->folder)
    {$entry .= '<folder><![CDATA['.$file->folder.']]></folder>';}
    if ($file->description)
    {$entry .= '<description><![CDATA['.$file->description.']]></description>';}
    $entry .= '<published>'.$file->published.'</published>';
    if ($file->ftphost)
    {$entry .= '<ftphost><![CDATA['.$file->ftphost.']]></ftphost>';}
    if ($file->ftpuser)
    {$entry .= '<ftpuser><![CDATA['.$file->ftpuser.']]></ftpuser>';}
    if ($file->ftppassword)
    {$entry .= '<ftppassword><![CDATA['.$file->ftppassword.']]></ftppassword>';}
    $entry .= '<ftpport>'.$file->ftpport.'</ftpport>';
    $entry .= '<type>'.$file->type.'</type>';
    if ($file->aws_key)
    {$entry .= '<aws_key><![CDATA['.$file->aws_key.']]></aws_key>';}
    if ($file->aws_secret)
    {$entry .= '<aws_secret><![CDATA['.$file->aws_secret.']]></aws_secret>';}
    $entry .= '</filepathtable>';
    $xml .= $entry;
}   
return $xml;    
}

/**
     * Method to get ministry records
     * return boolean
    */ 

function getministries()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__piministry";
$db->setQuery( $query );
$list = $db->loadObjectList();  
foreach ($list AS $e)
{
    // get folder names
    
    $image_folder = PIHelperbackup::getfolderinfo($e->image_folder);
    $image_folderlrg = PIHelperbackup::getfolderinfo($e->image_folderlrg);
    
    
    $entry = null;
    $entry .= '<mintable>';
    $entry .= '<id>'.$e->id.'</id>';
    if ($e->ministry_name)
    {$entry .= '<ministry_name><![CDATA['.$e->ministry_name.']]></ministry_name>';}
    $entry .= '<ministry_alias>'.$e->ministry_alias.'</ministry_alias>';
    $entry .= '<image_folder>'.$e->image_folder.'</image_folder>';
    $entry .= '<image_folderlrg>'.$e->image_folderlrg.'</image_folderlrg>';
    if ($image_folder)
    {$entry .= '<image_folder_text><![CDATA['.$image_folder.']]></image_folder_text>';}
    if ($image_folderlrg)
    {$entry .= '<image_folderlrg_text><![CDATA['.$image_folderlrg.']]></image_folderlrg_text>';}
    $entry .= '<ministry_image_sm>'.$e->ministry_image_sm.'</ministry_image_sm>';
    $entry .= '<ministry_image_lrg>'.$e->ministry_image_lrg.'</ministry_image_lrg>';
    $entry .= '<published>'.$e->published.'</published>';
    if ($e->ministry_description)
    {$entry .= '<ministry_description><![CDATA['.$e->ministry_description.']]></ministry_description>';}
    $entry .= '<ordering>'.$e->ordering.'</ordering>';
    $entry .= '<access>'.$e->access.'</access>';
    $entry .= '<language>'.$e->language.'</language>';
    $entry .= '</mintable>';
    $xml .= $entry;
}   
return $xml;    
}

/**
     * Method to get series records
     * return boolean
    */ 
    
function getseries()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__piseries";
$db->setQuery( $query );
$list = $db->loadObjectList();  
foreach ($list AS $e)
{
    // get folder names
    
    $image_folder = PIHelperbackup::getfolderinfo($e->image_folder);
    $image_folderlrg = PIHelperbackup::getfolderinfo($e->image_folderlrg);
    $videofolder = PIHelperbackup::getfolderinfo($e->videofolder);
    
    // get other values
    
    $ministry = PIHelperbackup::explodevalue('#__piministry', 'ministry_name', $e->ministry);
    
    $entry = null;
    $entry .= '<sertable>';
    $entry .= '<id>'.$e->id.'</id>';
    if ($e->series_name)
    {$entry .= '<series_name><![CDATA['.$e->series_name.']]></series_name>';}
    $entry .= '<series_alias>'.$e->series_alias.'</series_alias>';
    $entry .= '<image_folder>'.$e->image_folder.'</image_folder>';
    $entry .= '<image_folderlrg>'.$e->image_folderlrg.'</image_folderlrg>';
    if ($image_folder)
    {$entry .= '<image_folder_text><![CDATA['.$image_folder.']]></image_folder_text>';}
    if ($image_folderlrg)
    {$entry .= '<image_folderlrg_text><![CDATA['.$image_folderlrg.']]></image_folderlrg_text>';}
    $entry .= '<series_image_sm>'.$e->series_image_sm.'</series_image_sm>';
    $entry .= '<series_image_lrg>'.$e->series_image_lrg.'</series_image_lrg>';
    $entry .= '<published>'.$e->published.'</published>';
    if ($e->series_description)
    {$entry .= '<series_description><![CDATA['.$e->series_description.']]></series_description>';}
    $entry .= '<ministry>'.$e->ministry.'</ministry>';
    if ($ministry)
    {$entry .= '<ministry_text><![CDATA['.$ministry.']]></ministry_text>';}
    $entry .= '<ordering>'.$e->ordering.'</ordering>';
    $entry .= '<access>'.$e->access.'</access>';
    $entry .= '<language>'.$e->language.'</language>';
    $entry .= '<introvideo>'.$e->introvideo.'</introvideo>';
    $entry .= '<videofolder>'.$e->videofolder.'</videofolder>';
    $entry .= '<videofolder_text>'.$videofolder.'</videofolder_text>';
    if ($e->videolink)
    {$entry .= '<videolink><![CDATA['.$e->videolink.']]></videolink>';}
    $entry .= '<vheight>'.$e->vheight.'</vheight>';
    $entry .= '<vwidth>'.$e->vwidth.'</vwidth>';
    $entry .= '</sertable>';
    $xml .= $entry;
}   
return $xml;    
}

/**
     * Method to get teacher records
     * return boolean
    */ 

function getteachers()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__piteachers";
$db->setQuery( $query );
$list = $db->loadObjectList();  
foreach ($list AS $e)
{
    // get folder names
    
    $image_folder = PIHelperbackup::getfolderinfo($e->image_folder);
    $image_folderlrg = PIHelperbackup::getfolderinfo($e->image_folderlrg);
    
    $entry = null;
    $entry .= '<teachtable>';
    $entry .= '<id>'.$e->id.'</id>';
    if ($e->teacher_name)
    {$entry .= '<teacher_name><![CDATA['.$e->teacher_name.']]></teacher_name>';}
    if ($e->lastname)
    {$entry .= '<lastname><![CDATA['.$e->lastname.']]></lastname>';}
    $entry .= '<teacher_alias>'.$e->teacher_alias.'</teacher_alias>';
    if ($e->teacher_role)
    {$entry .= '<teacher_role><![CDATA['.$e->teacher_role.']]></teacher_role>';}
    $entry .= '<image_folder>'.$e->image_folder.'</image_folder>';
    $entry .= '<image_folderlrg>'.$e->image_folderlrg.'</image_folderlrg>';
    if ($image_folder)
    {$entry .= '<image_folder_text><![CDATA['.$image_folder.']]></image_folder_text>';}
    if ($image_folderlrg)
    {$entry .= '<image_folderlrg_text><![CDATA['.$image_folderlrg.']]></image_folderlrg_text>';}
    $entry .= '<teacher_image_sm>'.$e->teacher_image_sm.'</teacher_image_sm>';
    $entry .= '<teacher_image_lrg>'.$e->teacher_image_lrg.'</teacher_image_lrg>';
    $entry .= '<published>'.$e->published.'</published>';
    if ($e->teacher_description)
    {$entry .= '<teacher_description><![CDATA['.$e->teacher_description.']]></teacher_description>';}
    if ($e->teacher_email)
    {$entry .= '<teacher_email><![CDATA['.$e->teacher_email.']]></teacher_email>';}
    if ($e->teacher_website)
    {$entry .= '<teacher_website><![CDATA['.$e->teacher_website.']]></teacher_website>';}
    $entry .= '<ordering>'.$e->ordering.'</ordering>';
    $entry .= '<teacher_view>'.$e->teacher_view.'</teacher_view>';
    $entry .= '<language>'.$e->language.'</language>';
    $entry .= '</teachtable>';
    $xml .= $entry;
}   
return $xml;    
}

/**
     * Method to get message records
     * return boolean
    */ 

function getmessages()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__pistudies";
$db->setQuery( $query );
$list = $db->loadObjectList();  
foreach ($list AS $e)
{
    // get folder names
    
    $image_folder = PIHelperbackup::getfolderinfo($e->image_folder);
    $image_foldermed = PIHelperbackup::getfolderinfo($e->image_foldermed);
    $image_folderlrg = PIHelperbackup::getfolderinfo($e->image_folderlrg);
    $video_folder = PIHelperbackup::getfolderinfo($e->video_folder);
    $audio_folder = PIHelperbackup::getfolderinfo($e->audio_folder);
    $notes_folder = PIHelperbackup::getfolderinfo($e->notes_folder);
    $downloadvid_folder = PIHelperbackup::getfolderinfo($e->downloadvid_folder);
    $vidpurchase_folder = PIHelperbackup::getfolderinfo($e->vidpurchase_folder);
    $audpurchase_folder = PIHelperbackup::getfolderinfo($e->audpurchase_folder);
    
    // get other values
    
    $ministry = PIHelperbackup::explodevalue('#__piministry', 'ministry_name', $e->ministry);
    $teacher = PIHelperbackup::explodevalue('#__piteachers', 'teacher_name', $e->teacher);
    $series = PIHelperbackup::explodevalue('#__piseries', 'series_name', $e->series);
    
    $entry = null;
    $entry .= '<mestable>';
    $entry .= '<id>'.$e->id.'</id>';
    $entry .= '<study_date>'.$e->study_date.'</study_date>';
    if ($e->study_name)
    {$entry .= '<study_name><![CDATA['.$e->study_name.']]></study_name>';}
    $entry .= '<study_alias>'.$e->study_alias.'</study_alias>';
    if ($e->study_description)
    {$entry .= '<study_description><![CDATA['.$e->study_description.']]></study_description>';}
    $entry .= '<study_book>'.$e->study_book.'</study_book>';
    $entry .= '<ref_ch_beg>'.$e->ref_ch_beg.'</ref_ch_beg>';
    $entry .= '<ref_ch_end>'.$e->ref_ch_end.'</ref_ch_end>';
    $entry .= '<ref_vs_beg>'.$e->ref_vs_beg.'</ref_vs_beg>';
    $entry .= '<ref_vs_end>'.$e->ref_vs_end.'</ref_vs_end>';
    $entry .= '<study_book2>'.$e->study_book2.'</study_book2>';
    $entry .= '<ref_ch_beg2>'.$e->ref_ch_beg2.'</ref_ch_beg2>';
    $entry .= '<ref_ch_end2>'.$e->ref_ch_end2.'</ref_ch_end2>';
    $entry .= '<ref_vs_beg2>'.$e->ref_vs_beg2.'</ref_vs_beg2>';
    $entry .= '<ref_vs_end2>'.$e->ref_vs_end2.'</ref_vs_end2>';
    $entry .= '<series>'.$e->series.'</series>';
    $entry .= '<ministry>'.$e->ministry.'</ministry>';
    $entry .= '<teacher>'.$e->teacher.'</teacher>';
    if ($series)
    {$entry .= '<series_text><![CDATA['.$series.']]></series_text>';}
    if ($ministry)
    {$entry .= '<ministry_text><![CDATA['.$ministry.']]></ministry_text>';}
    if ($teacher)
    {$entry .= '<teacher_text><![CDATA['.$teacher.']]></teacher_text>';}
    $entry .= '<dur_hrs>'.$e->dur_hrs.'</dur_hrs>';
    $entry .= '<dur_mins>'.$e->dur_mins.'</dur_mins>';
    $entry .= '<dur_secs>'.$e->dur_secs.'</dur_secs>';
    $entry .= '<video>'.$e->video.'</video>';
    $entry .= '<video_type>'.$e->video_type.'</video_type>';
    $entry .= '<video_download>'.$e->video_download.'</video_download>';
    if ($e->video_link)
    {$entry .= '<video_link><![CDATA['.$e->video_link.']]></video_link>';}
    $entry .= '<audio>'.$e->audio.'</audio>';
    $entry .= '<audio_type>'.$e->audio_type.'</audio_type>';
    $entry .= '<audio_download>'.$e->audio_download.'</audio_download>';
    if ($e->audio_link)
    {$entry .= '<audio_link><![CDATA['.$e->audio_link.']]></audio_link>';}
    $entry .= '<published>'.$e->published.'</published>';
    $entry .= '<comments>'.$e->comments.'</comments>';
    $entry .= '<study_text><![CDATA['.$e->study_text.']]></study_text>';
    $entry .= '<text>'.$e->text.'</text>';
    $entry .= '<studylist>'.$e->studylist.'</studylist>';
    $entry .= '<hits>'.$e->hits.'</hits>';
    $entry .= '<downloads>'.$e->downloads.'</downloads>';
    $entry .= '<audio_folder>'.$e->audio_folder.'</audio_folder>';
    $entry .= '<video_folder>'.$e->video_folder.'</video_folder>';
    if ($audio_folder)
    {$entry .= '<audio_folder_text><![CDATA['.$audio_folder.']]></audio_folder_text>';}
    if ($video_folder)
    {$entry .= '<video_folder_text><![CDATA['.$video_folder.']]></video_folder_text>';}
    $entry .= '<publish_up>'.$e->publish_up.'</publish_up>';
    $entry .= '<publish_down>'.$e->publish_down.'</publish_down>';
    $entry .= '<image_folder>'.$e->image_folder.'</image_folder>';
    $entry .= '<image_foldermed>'.$e->image_foldermed.'</image_foldermed>';
    $entry .= '<image_folderlrg>'.$e->image_folderlrg.'</image_folderlrg>';
    if ($image_folder)
    {$entry .= '<image_folder_text><![CDATA['.$image_folder.']]></image_folder_text>';}
    if ($image_foldermed)
    {$entry .= '<image_foldermed_text><![CDATA['.$image_foldermed.']]></image_foldermed_text>';}
    if ($image_folderlrg)
    {$entry .= '<image_folderlrg_text><![CDATA['.$image_folderlrg.']]></image_folderlrg_text>';}
    if ($e->imagesm)
    {$entry .= '<imagesm><![CDATA['.$e->imagesm.']]></imagesm>';}
    if ($e->imagemed)
    {$entry .= '<imagemed><![CDATA['.$e->imagemed.']]></imagemed>';}
    if ($e->imagelrg)
    {$entry .= '<imagelrg><![CDATA['.$e->imagelrg.']]></imagelrg>';}
    $entry .= '<notes_folder>'.$e->notes_folder.'</notes_folder>';
    if ($notes_folder)
    {$entry .= '<notes_folder_text><![CDATA['.$notes_folder.']]></notes_folder_text>';}
    $entry .= '<notes>'.$e->notes.'</notes>';
    if ($e->notes_link)
    {$entry .= '<notes_link><![CDATA['.$e->notes_link.']]></notes_link>';}
    if ($e->downloadvid_link)
    {$entry .= '<downloadvid_link><![CDATA['.$e->downloadvid_link.']]></downloadvid_link>';}
    $entry .= '<add_downloadvid>'.$e->add_downloadvid.'</add_downloadvid>';
    $entry .= '<downloadvid_folder>'.$e->downloadvid_folder.'</downloadvid_folder>';
    if ($downloadvid_folder)
    {$entry .= '<downloadvid_folder_text><![CDATA['.$downloadvid_folder.']]></downloadvid_folder_text>';}
    $entry .= '<access>'.$e->access.'</access>';
    $entry .= '<minaccess>'.$e->minaccess.'</minaccess>';
    $entry .= '<saccess>'.$e->saccess.'</saccess>';
    $entry .= '<language>'.$e->language.'</language>';
    if ($e->audpurchase_link)
    {$entry .= '<audpurchase_link><![CDATA['.$e->audpurchase_link.']]></audpurchase_link>';}
    $entry .= '<audpurchase>'.$e->audpurchase.'</audpurchase>';
    $entry .= '<audpurchase_folder>'.$e->audpurchase_folder.'</audpurchase_folder>';
    if ($audpurchase_folder)
    {$entry .= '<audpurchase_folder_text><![CDATA['.$audpurchase_folder.']]></audpurchase_folder_text>';}
    if ($e->vidpurchase_link)
    {$entry .= '<vidpurchase_link><![CDATA['.$e->vidpurchase_link.']]></vidpurchase_link>';}
    $entry .= '<vidpurchase>'.$e->vidpurchase.'</vidpurchase>';
    $entry .= '<vidpurchase_folder>'.$e->vidpurchase_folder.'</vidpurchase_folder>';
    if ($vidpurchase_folder)
    {$entry .= '<vidpurchase_folder_text><![CDATA['.$vidpurchase_folder.']]></vidpurchase_folder_text>';}
    $entry .= '<tags>'.$e->tags.'</tags>';
    $entry .= '<audiofs>'.$e->audiofs.'</audiofs>';
    $entry .= '<videofs>'.$e->videofs.'</videofs>';
    $entry .= '<advideofs>'.$e->advideofs.'</advideofs>';
    $entry .= '<notesfs>'.$e->notesfs.'</notesfs>';
    $entry .= '</mestable>';
    $xml .= $entry;
    
}   
return $xml;    
}

/**
     * Method to get podcast records
     * return boolean
    */ 

function getpodcasts()
{
$db = & JFactory::getDBO();   
$xml = null;   
$query = " SELECT * FROM #__pipodcast";
$db->setQuery( $query );
$list = $db->loadObjectList();  
foreach ($list AS $e)
{
    $entry = null;
    $entry .= '<podtable>';
    $entry .= '<id>'.$e->id.'</id>';
    if ($e->name)
    {$entry .= '<name><![CDATA['.$e->name.']]></name>';}
    if ($e->image)
    {$entry .= '<image><![CDATA['.$e->image.']]></image>';}
    $entry .= '<records>'.$e->records.'</records>';
    if ($e->website)
    {$entry .= '<website><![CDATA['.$e->website.']]></website>';}
    $entry .= '<published>'.$e->published.'</published>';
    if ($e->description)
    {$entry .= '<description><![CDATA['.$e->description.']]></description>';}
    $entry .= '<imagehgt>'.$e->imagehgt.'</imagehgt>';
    $entry .= '<imagewth>'.$e->imagewth.'</imagewth>';
    if ($e->author)
    {$entry .= '<author><![CDATA['.$e->author.']]></author>';}
    if ($e->search)
    {$entry .= '<search><![CDATA['.$e->search.']]></search>';}
    if ($e->filename)
    {$entry .= '<filename><![CDATA['.$e->filename.']]></filename>';}
    $entry .= '<menuitem>'.$e->author.'</menuitem>';
    if ($e->language)
    {$entry .= '<language><![CDATA['.$e->language.']]></language>';}
    if ($e->editor)
    {$entry .= '<editor><![CDATA['.$e->editor.']]></editor>';}
    if ($e->email)
    {$entry .= '<email><![CDATA['.$e->email.']]></email>';}
    $entry .= '<ordering>'.$e->ordering.'</ordering>';
    $entry .= '<itunestitle>'.$e->itunestitle.'</itunestitle>';
    $entry .= '<itunessub>'.$e->itunessub.'</itunessub>';
    $entry .= '<itunesdesc>'.$e->itunesdesc.'</itunesdesc>';
    $entry .= '<series>'.$e->series.'</series>';
    $entry .= '<series_list>'.$e->series_list.'</series_list>';
    $entry .= '<ministry>'.$e->ministry.'</ministry>';
    $entry .= '<ministry_list>'.$e->ministry_list.'</ministry_list>';
    $entry .= '<teacher>'.$e->teacher.'</teacher>';
    $entry .= '<teacher_list>'.$e->teacher_list.'</teacher_list>';
    $entry .= '<media>'.$e->media.'</media>';
    $entry .= '<media_list>'.$e->media_list.'</media_list>';
    $entry .= '<languagesel>'.$e->languagesel.'</languagesel>';
    $entry .= '</podtable>';
    $xml .= $entry;
}   
return $xml;    
}
/**
     * Method to get folder info records
     * @param int $string id of the folder record
     * return boolean
    */ 

function getfolderinfo($string)
{
    if ($string)
    {$db = & JFactory::getDBO(); 
    $query = "
    SELECT ".$db->nameQuote('server')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($string).";
  ";
    $db->setQuery($query);
    $server =  $db->loadResult();
    
    $query = "
    SELECT ".$db->nameQuote('folder')."
    FROM ".$db->nameQuote('#__pifilepath')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($string).";
  ";
    $db->setQuery($query);
    $folder =  $db->loadResult();
    
    return $server.'||'.$folder;}
    else {return null;}
}

/**
     * Method to get string from list of ids
     * @param string $table table name to search
     * @param string $entry entry to search for
     * $param strgin $string list of ids separated by commas
     * return boolean
    */ 

function explodevalue($table, $entry, $string)
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
                 SELECT ".$db->nameQuote($entry)."
                  FROM ".$db->nameQuote($table)."
                  WHERE ".$db->nameQuote('id')." = ".$db->quote($row).";
                  ";
                  $db->setQuery($query);
                  $name = $db->loadResult(); 
                  
                  $array[] = $name;
            }
        }
    } 
    $value = implode(',', $array);
    return $value;
}
    
}