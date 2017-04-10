<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
@error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Help get past php timeouts if we made it that far
// Joomla 1.5 installer can be very slow and this helps avoid timeouts
@set_time_limit(300);
$kn_maxTime = @ini_get('max_execution_time');

$maxMem = trim(@ini_get('memory_limit'));
if ($maxMem) {
	$unit = strtolower($maxMem{strlen($maxMem) - 1});
	switch($unit) {
		case 'g':
			$maxMem	*=	1024;
		case 'm':
			$maxMem	*=	1024;
		case 'k':
			$maxMem	*=	1024;
	}
	if ($maxMem < 16000000) {
		@ini_set('memory_limit', '16M');
	}
	if ($maxMem < 32000000) {
		@ini_set('memory_limit', '32M');
	}
	if ($maxMem < 48000000) {
		@ini_set('memory_limit', '48M');
	}
}
ignore_user_abort(true);

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.version.php');
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/temp.php');
jimport('teweb.admin.records');

JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelperupdate
{
 
/**
     * Get the current table version
     * return int
    */

function tableversion()
{
	$version = PIVersion::versionXML();

	return $version;
}

/**
     * Method to update pistudies table
     * return boolean
    */

function updatestudytable()
{
	
$db	= & JFactory::getDBO();
$tn = '#__pistudies';
	$fields = $db->getTableFields( array( $tn ) );
	$ministry = false;
	$ministry	= isset( $fields[$tn]['ministry'] );
	$check = $ministry;	
			if (!$ministry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN ministry INT(11) NOT NULL AFTER series;");
			$db->query();}
			
$tn = '#__pistudies';
	$fields = $db->getTableFields( array( $tn ) );
	$audio_type = false;
	$audio_type	= isset( $fields[$tn]['audio_type'] );
	$check = $audio_type;	
			if (!$audio_type) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audio_type INT(11) NOT NULL AFTER audio;");
			$db->query();}
			
$tn = '#__pistudies';
	$fields = $db->getTableFields( array( $tn ) );
	$scripture = false;
	$scripture	= isset( $fields[$tn]['study_book2'] );
	$check = $scripture;
			if (!$scripture) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN study_book2 INT(11) NOT NULL AFTER ref_vs_end;");
			$db->query();}
	$scripture = false;
	$scripture	= isset( $fields[$tn]['ref_ch_beg2'] );
			if (!$scripture) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN ref_ch_beg2 INT(4) NOT NULL AFTER study_book2;");
			$db->query();}
	$scripture = false;
	$scripture	= isset( $fields[$tn]['ref_ch_end2'] );
			if (!$scripture) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN ref_ch_end2 INT(4) NOT NULL AFTER ref_ch_beg2;");
			$db->query();}
	$scripture = false;
	$scripture	= isset( $fields[$tn]['ref_vs_beg2'] );
			if (!$scripture) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN ref_vs_beg2 INT(4) NOT NULL AFTER ref_ch_end2;");
			$db->query();}
	$scripture = false;
	$scripture	= isset( $fields[$tn]['ref_vs_end2'] );
			if (!$scripture) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN ref_vs_end2 INT(4) NOT NULL AFTER ref_vs_beg2;");
			$db->query();}
	$hits = false;
	$hits	= isset( $fields[$tn]['hits'] );
			if (!$hits) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN hits INT(11) DEFAULT '0' NOT NULL AFTER podcast_video;");
			$db->query();}
	$downloads = false;
	$downloads = isset( $fields[$tn]['downloads'] );
			if (!$downloads) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN downloads INT(11) DEFAULT '0' NOT NULL AFTER hits;");
			$db->query();}
	$asmedia = false;
	$asmedia = isset( $fields[$tn]['asmedia'] );
			if (!$asmedia) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN asmedia INT(11) NOT NULL AFTER downloads;");
			$db->query();}
	$studylist = false;
	$studylist = isset( $fields[$tn]['studylist'] );
			if (!$studylist) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN studylist TINYINT(3) NOT NULL AFTER asmedia;");
			$db->query();}
	$study_alias = false;
	$study_alias = isset( $fields[$tn]['study_alias'] );
			if (!$study_alias) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN study_alias VARCHAR(250) NOT NULL AFTER study_name;");
			$db->query();}
			
			if (!$studylist)
			{
			$query3 = "SELECT * FROM #__pistudies";
			$db->setQuery($query3);
			$studies = $db->loadObjectList();
			
					foreach ($studies as $study)
						{		 						
					$db->setQuery ("UPDATE #__pistudies SET studylist = 1 WHERE id = '{$study->id}' ;"); 
					$db->query();
							
						}
			}
		
	$fields = $db->getTableFields( array( $tn ) );
	$publish_up = false;
	$publish_up	= isset( $fields[$tn]['publish_up'] );
	$check = $publish_up;
			if (!$publish_up) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN publish_up DATETIME NOT NULL;");
			$db->query();}
	$publish_down = false;
	$publish_down	= isset( $fields[$tn]['publish_down'] );
			if (!$publish_down) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN publish_down DATETIME NOT NULL;");
			$db->query();}
    $publish_up = false;
    $publish_up    = isset( $fields[$tn]['podpublish_up'] );
    $check = $publish_up;
            if (!$publish_up) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN podpublish_up DATETIME NOT NULL;");
            $db->query();}
    $publish_down = false;
    $publish_down    = isset( $fields[$tn]['podpublish_down'] );
            if (!$publish_down) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN podpublish_down DATETIME NOT NULL;");
            $db->query();}
	$image_folder = false;
	$image_folder	= isset( $fields[$tn]['image_folder'] );
			if (!$image_folder) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN image_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['image_foldermed'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN image_foldermed INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['image_folderlrg'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN image_folderlrg INT(11) NOT NULL;");
			$db->query();}
	$imagesm = false;
	$imagesm	= isset( $fields[$tn]['imagesm'] );
			if (!$imagesm) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN imagesm VARCHAR(100) NOT NULL;");
			$db->query();}
	$imagemed = false;
	$imagemed = isset( $fields[$tn]['imagemed'] );
			if (!$imagemed) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN imagemed VARCHAR(100) NOT NULL;");
			$db->query();}
	$imagelrg = false;
	$imagelrg = isset( $fields[$tn]['imagelrg'] );
			if (!$imagelrg) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN imagelrg VARCHAR(100) NOT NULL;");
			$db->query();}
	$notes_folder = false;
	$notes_folder	= isset( $fields[$tn]['notes_folder'] );
			if (!$notes_folder) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN notes_folder INT(11) NOT NULL;");
			$db->query();}
	$notes = false;
	$notes	= isset( $fields[$tn]['notes'] );
			if (!$notes) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN notes TINYINT(3) NOT NULL;");
			$db->query();}
	$notes_link = false;
	$notes_link	= isset( $fields[$tn]['notes_link'] );
			if (!$notes_link) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN notes_link VARCHAR(250) NOT NULL;");
			$db->query();}
	$add_downloadvid = false;
	$add_downloadvid = isset( $fields[$tn]['add_downloadvid'] );
			if (!$add_downloadvid) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN add_downloadvid TINYINT(3) NOT NULL;");
			$db->query();}
	$downloadvid_folder = false;
	$downloadvid_folder = isset( $fields[$tn]['downloadvid_folder'] );
			if (!$downloadvid_folder) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN downloadvid_folder INT(11) NOT NULL;");
			$db->query();}
	$downloadvid_link = false;
	$downloadvid_link = isset( $fields[$tn]['downloadvid_link'] );
			if (!$downloadvid_link) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN downloadvid_link VARCHAR(250) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$tn]['checked_out'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN checked_out TINYINT(1);");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['checked_out_time'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN checked_out_time DATETIME;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['user'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN user INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['access'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN access INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['saccess'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN saccess INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['minaccess'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN minaccess INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
		$entry = false;
	$entry	= isset( $fields[$tn]['audpurchase'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audpurchase TINYINT(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['audpurchase_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audpurchase_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['audpurchase_link'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audpurchase_link VARCHAR(250) NOT NULL;");
			$db->query();}
		$entry = false;
	$entry	= isset( $fields[$tn]['vidpurchase'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN vidpurchase TINYINT(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['vidpurchase_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN vidpurchase_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['vidpurchase_link'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN vidpurchase_link VARCHAR(250) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['tags'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN tags TEXT NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['audiofs'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audiofs INT(24) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['videofs'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN videofs INT(24) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['advideofs'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN advideofs INT(24) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$tn]['notesfs'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN notesfs INT(24) NOT NULL;");
			$db->query();}
    $entry = false;
	$entry	= isset( $fields[$tn]['language'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN language CHAR(7) DEFAULT '*' NOT NULL;");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['slidesfs'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN slidesfs INT(24) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['slides'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN slides TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['slides_folder'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN slides_folder INT(11) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['slides_type'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN slides_type TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['slides_link'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN slides_link VARCHAR(250) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['metakey'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN metakey TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['metadesc'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN metadesc TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['audioprice'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN audioprice VARCHAR(250) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$tn]['videoprice'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pistudies ADD COLUMN videoprice VARCHAR(250) NOT NULL;");
            $db->query();}
			
	$db->setQuery("ALTER TABLE #__pistudies CHANGE teacher teacher TEXT NOT NULL; ");
	$db->query();
	
	$db->setQuery("ALTER TABLE #__pistudies CHANGE ministry ministry TEXT NOT NULL; ");
	$db->query();
	
	$db->setQuery("ALTER TABLE #__pistudies CHANGE study_text study_text MEDIUMTEXT NOT NULL; ");
	$db->query();
    
    $db->setQuery("ALTER TABLE #__pistudies CHANGE checked_out checked_out INT(11) NOT NULL;");
    $db->query();

	return true;
}

/**
     * Method to update piseries table
     * return boolean
    */

function updateseriestable()
{

	$db	= & JFactory::getDBO();
	$sn = '#__piseries';
	$fields = $db->getTableFields( array( $sn ) );
	$ministry = false;
	$ministry	= isset( $fields[$sn]['ministry'] );
	$check = $ministry;	
			if (!$ministry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN ministry INT(11) NOT NULL AFTER series_description;");
			$db->query();}
	$ministry = false;
	$ministry	= isset( $fields[$sn]['ordering'] );
	$check = $ministry;	
			if (!$ministry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN ordering INT(11) NOT NULL AFTER ministry;");
			$db->query();}
	$series_alias = false;
	$series_alias = isset( $fields[$sn]['series_alias'] );
			if (!$series_alias) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN series_alias VARCHAR(250) NOT NULL AFTER series_name;");
			$db->query();}

	$fields = $db->getTableFields( array( $sn ) );
	$entry = false;
	$entry	= isset( $fields[$sn]['introvideo'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN introvideo TINYINT(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['videoplayer'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN videoplayer INT(11) NOT NULL;");
			$db->query();}
			$entry = false;
	$entry	= isset( $fields[$sn]['videofolder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN videofolder INT(11) NOT NULL;");
			$db->query();}
			$entry = false;
	$entry	= isset( $fields[$sn]['videolink'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN videolink VARCHAR(100) NOT NULL;");
			$db->query();}
			$entry = false;
	$entry	= isset( $fields[$sn]['vwidth'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN vwidth INT(4) NOT NULL;");
			$db->query();}
			$entry = false;
	$entry	= isset( $fields[$sn]['vheight'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN vheight INT(4) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['checked_out'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN checked_out TINYINT(1);");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['checked_out_time'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN checked_out_time DATETIME;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['user'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN user INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['access'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN access INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$sn]['image_folderlrg'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN image_folderlrg INT(11) NOT NULL;");
			$db->query();
			
			$query = "SELECT * FROM #__piseries";
			$db->setQuery($query);
			$series = $db->loadObjectList();
			
					foreach ($series as $ser)
						{
								$folder = $ser->image_folder;	
   							 						
					$db->setQuery ("UPDATE #__piseries SET image_folderlrg = '{$folder}' WHERE id = '{$ser->id}' ;"); 
					$db->query(); }			
			
			}
	$entry	= isset( $fields[$sn]['language'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN language CHAR(7) DEFAULT '*' NOT NULL;");
			$db->query();}
	$db->setQuery("ALTER TABLE #__piseries CHANGE ministry ministry TEXT NOT NULL; ");
	$db->query();
    $entry = false;
    $entry    = isset( $fields[$sn]['metakey'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN metakey TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$sn]['metadesc'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN metadesc TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$sn]['part'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piseries ADD COLUMN part TINYINT(3) DEFAULT '1' NOT NULL;");
            $db->query();}
    
    $db->setQuery("ALTER TABLE #__piseries CHANGE checked_out checked_out INT(11) NOT NULL;");
    $db->query();

	return true;

}

/**
     * Method to update piministry table
     * return boolean
    */

function updateministrytable()
{

	$db	= & JFactory::getDBO();
	$mn = '#__piministry';
	$fields = $db->getTableFields( array( $mn ) );
	$ministry = false;
	$ministry	= isset( $fields[$mn]['ordering'] );
	$check = $ministry;	
			if (!$ministry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN ordering INT(11) NOT NULL AFTER ministry_description;");
			$db->query();}
	$ministry_alias = false;
	$ministry_alias = isset( $fields[$mn]['ministry_alias'] );
			if (!$ministry_alias) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN ministry_alias VARCHAR(250) NOT NULL AFTER ministry_name;");
			$db->query();}

	$min = '#__piministry';
	$fields = $db->getTableFields( array( $min ) );
	$entry = false;
	$entry	= isset( $fields[$min]['access'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN access INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$min]['image_folderlrg'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN image_folderlrg INT(11) NOT NULL;");
			$db->query();
			
			$query = "SELECT * FROM #__piministry";
			$db->setQuery($query);
			$ministry = $db->loadObjectList();
			
					foreach ($ministry as $min)
						{
								$folder = $min->image_folder;	
   							 						
					$db->setQuery ("UPDATE #__piministry SET image_folderlrg = '{$folder}' WHERE id = '{$min->id}' ;"); 
					$db->query(); }			
			
			}
	$entry	= isset( $fields[$min]['language'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN language CHAR(7) DEFAULT '*' NOT NULL;");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$min]['metakey'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN metakey TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$min]['metadesc'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piministry ADD COLUMN metadesc TEXT NOT NULL;");
            $db->query();}
            

		return true;
		
}

/**
     * Method to update piteachers table
     * return boolean
    */

function updateteachertable()
{

	$db	= & JFactory::getDBO();
	$ten = '#__piteachers';
	$fields = $db->getTableFields( array( $ten ) );
	$teacher_alias = false;
	$teacher_alias = isset( $fields[$ten]['teacher_alias'] );
			if (!$teacher_alias) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN teacher_alias VARCHAR(250) NOT NULL AFTER teacher_name;");
			$db->query();}

	$fields = $db->getTableFields( array( $ten ) );
	$entry = false;
	$entry	= isset( $fields[$ten]['checked_out'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN checked_out TINYINT(1);");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$ten]['checked_out_time'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN checked_out_time DATETIME;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$ten]['user'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN user INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$ten]['image_folderlrg'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN image_folderlrg INT(11) NOT NULL;");
			$db->query();
			
			$query = "SELECT * FROM #__piteachers";
			$db->setQuery($query);
			$teachers = $db->loadObjectList();
			
					foreach ($teachers as $tea)
						{
								$folder = $tea->image_folder;	
   							 						
					$db->setQuery ("UPDATE #__piteachers SET image_folderlrg = '{$folder}' WHERE id = '{$tea->id}' ;"); 
					$db->query(); }			
			
			}	
	$db->setQuery("ALTER TABLE #__piteachers CHANGE teacher_role teacher_role VARCHAR(50) NOT NULL; ");
	$db->query();

	$entry	= isset( $fields[$ten]['language'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN language CHAR(7) DEFAULT '*' NOT NULL;");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$ten]['metakey'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN metakey TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$ten]['metadesc'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN metadesc TEXT NOT NULL;");
            $db->query();}
    
    $db->setQuery("ALTER TABLE #__piteachers CHANGE checked_out checked_out INT(11) NOT NULL;");
    $db->query();
    
    $entry = false;
    $entry    = isset( $fields[$ten]['lastname'] );
    $check = $entry;    
            if (!$entry) {
            $db->setQuery ("ALTER TABLE #__piteachers ADD COLUMN lastname VARCHAR(250) NOT NULL;");
            $db->query();
            
            $query = "SELECT id FROM #__piteachers";
            $db->setQuery($query);
            $teachers = $db->loadObjectList();
            
                    foreach ($teachers as $tea)
                        {
                                $row = & JTable::getInstance('Teachers', 'Table');
                                $row->load($tea->id);
                                $name = explode(' ', $row->teacher_name);
                                if (!isset($name[1]))
                                {
                                    $row->teacher_name = '';
                                    $row->lastname = $name[0];
                                    $test = true;
                                }
                                else {
                                    $row->lastname = str_replace($name[0].' ', '', $row->teacher_name);
                                    $row->teacher_name = $name[0];  
                                }
    
                       
                                if (!$row->store())
                                {JError::raiseError(500, $row->getError() );} 
                        }            
            
            }

		return true;	
		
}

/**
     * Method to update pipodcast table
     * return boolean
    */

function updatepodcasttable()
{

	$db	= & JFactory::getDBO();
			
	$pn = '#__pipodcast';
	$fields = $db->getTableFields( array( $pn ) );
	$ordering = false;
	$ordering	= isset( $fields[$pn]['ordering'] );
	$check = $ordering;	
			if (!$ordering) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN ordering INT(11) NOT NULL AFTER email;");
			$db->query();}	
	$podpub = false;
	$podpub	= isset( $fields[$pn]['podpub'] );
	$check = $podpub;	
			if (!$podpub) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN podpub DATETIME NOT NULL AFTER ordering;");
			$db->query();}	
	$menuitem = false;
	$menuitem	= isset( $fields[$pn]['menu_item'] );
	$check = $menuitem;	
			if (!$menuitem) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN menu_item INT(11) NOT NULL AFTER filename;");
			$db->query();}	
	$itunestitle = false;
	$itunestitle	= isset( $fields[$pn]['itunestitle'] );
	$check = $itunestitle;	
			if (!$itunestitle) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN itunestitle INT(11) NOT NULL;");
			$db->query();}
	$itunessub = false;
	$itunessub	= isset( $fields[$pn]['itunessub'] );
	$check = $itunessub;	
			if (!$itunessub) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN itunessub INT(11) NOT NULL;");
			$db->query();}
	$itunesdesc = false;
	$itunesdesc	= isset( $fields[$pn]['itunesdesc'] );
	$check = $itunesdesc;	
			if (!$itunesdesc) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN itunesdesc INT(11) NOT NULL;");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$bn]['series'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN series TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$pn]['series_list'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN series_list TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$bn]['ministry'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN ministry TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$pn]['ministry_list'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN ministry_list TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$bn]['teacher'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN teacher TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$pn]['teacher_list'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN teacher_list TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$bn]['media'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN media TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$pn]['media_list'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN media_list TEXT NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$pn]['languagesel'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pipodcast ADD COLUMN languagesel CHAR(7) DEFAULT '*' NOT NULL;");
            $db->query();}
			
			$query = "SELECT * FROM #__piseries";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			
		foreach ($rows as $row)
		{
			if ($row->ordering < 1)
				{
					$db->setQuery ("UPDATE #__piseries SET ordering = '{$row->id}' WHERE id = '{$row->id}' ;"); 
					$db->query();
				}
		}
		
		$query1 = "SELECT * FROM #__pipodcast";
			$db->setQuery($query1);
			$pods = $db->loadObjectList();
			
		foreach ($pods as $pod)
		{
			if ($pod->ordering < 1)
				{
					$db->setQuery ("UPDATE #__pipodcast SET ordering = '{$pod->id}' WHERE id = '{$pod->id}' ;"); 
					$db->query();
				}
		}
        
        //remove adminpodmes and podmes tables
		
        $db->setQuery ("DROP TABLE IF EXISTS #__pipodmes");
        $db->query();
        $db->setQuery ("DROP TABLE IF EXISTS #__piadminpodmes");
        $db->query();
        
		return true;
		
}

/**
     * Method to update pitemplates table (used by the custom template)
     * return boolean
    */

function updatetemptable()
{

	$db	= & JFactory::getDBO();
		
	$temp = '#__pitemplates';
	$fields = $db->getTableFields( array( $temp ) );
	$header = false;
	$header	= isset( $fields[$temp]['seriesheader'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN seriesheader TEXT NOT NULL AFTER text;");
			$db->query();}	
	$header = false;
	$header	= isset( $fields[$temp]['teacherheader'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN teacherheader TEXT NOT NULL AFTER seriessermons;");
			$db->query();}	
	$header = false;
	$header	= isset( $fields[$temp]['ministryheader'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN ministryheader TEXT NOT NULL AFTER teachersermons;");
			$db->query();}	
	$header = false;
	$header	= isset( $fields[$temp]['medialisthead'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN medialisthead TEXT NOT NULL;");
			$db->query();
			$insert = '<div class="topbar"><div class="study_name"><div class="date">[date]</div>'
							.'[name]</div>'
							.'<div class="mainsubtitle">[scripture][scripture2] by [teacher]</div>'
							.'<div class="mainstudy_description">[description]</div>'
							.'<div class="mainseries">[series]</div>'
							.'<div class="mainmedialinks">[medialinks]</div>'
							.'<div class="mainshare">[share]</div>'
							.'</div>';
			$tempid = 1;
			$db->setQuery ("UPDATE #__pitemplates SET medialisthead = '{$insert}'  WHERE id = '{$tempid}' ;");
					$db->query();}
	$header = false;
	$header	= isset( $fields[$temp]['mediasermons'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN mediasermons TEXT NOT NULL;");
			$db->query();
			$insert = '<div class="listblock"><div class="medialinks">[medialinks]</div><div class="study_name">[name]</div>'
					.'<div class="scripture">Passage: [scripture][scripture2]<span class="date">[date]</span></div>'
					.'<div class="teacher">Teacher: [teacher]</div>'
					.'</div>';
			$tempid = 1;	
			$db->setQuery ("UPDATE #__pitemplates SET mediasermons =  '{$insert}'  WHERE id = '{$tempid}' ;");
					$db->query();}	
	$header = false;
	$header	= isset( $fields[$temp]['taglist'] );
	$check = $header;	
			if (!$header) {$db->setQuery ("ALTER TABLE #__pitemplates ADD COLUMN taglist TEXT NOT NULL;");
			$db->query();
			$insert = '<div class="listblock"><div class="medialinks">[medialinks]</div><div class="study_name">[name]</div>'
					.'<div class="scripture">Passage: [scripture][scripture2]<span class="date">[date]</span></div>'
					.'<div class="teacher">Teacher: [teacher]</div>'
					.'</div>';
			$tempid = 1;	
			$db->setQuery ("UPDATE #__pitemplates SET taglist =  '{$insert}'  WHERE id = '{$tempid}' ;");
					$db->query();}	
					
		return true;
}

/**
     * Method to update piadmin table
     * return boolean
    */

function updateadmintable()
{

	$db	= & JFactory::getDBO();
			
	$table = '#__pibckadmin';
	$fields = $db->getTableFields ( array( $table ) );
	$studylistad = false;
	$studylistad = isset( $fields[$table]['studylist'] );
			if (!$studylistad) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN studylist TINYINT(3) DEFAULT '1' NOT NULL;");
			$db->query();}
	$studylistad = isset( $fields[$table]['getupdate'] );
			if (!$studylistad) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN getupdate TINYINT(3) DEFAULT '0' NOT NULL;");
			$db->query();}
	$image_folder = false;
	$image_folder	= isset( $fields[$table]['image_folder'] );
			if (!$image_folder) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN image_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['image_foldermed'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN image_foldermed INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['image_folderlrg'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN image_folderlrg INT(11) NOT NULL;");
			$db->query();}
	$notes_folder = false;
	$notes_folder	= isset( $fields[$table]['notes_folder'] );
			if (!$notes_folder) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN notes_folder INT(11) NOT NULL;");
			$db->query();}
	$notes = false;
	$notes	= isset( $fields[$table]['notes'] );
			if (!$notes) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN notes TINYINT(3) NOT NULL;");
			$db->query();}
	$add_downloadvid = false;
	$add_downloadvid = isset( $fields[$table]['add_downloadvid'] );
			if (!$add_downloadvid) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN add_downloadvid TINYINT(3) NOT NULL;");
			$db->query();}
	$downloadvid_folder = false;
	$downloadvid_folder = isset( $fields[$table]['downloadvid_folder'] );
			if (!$downloadvid_folder) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN downloadvid_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['default_template'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN default_template VARCHAR(100) NOT NULL DEFAULT 'revolution';");
			$db->query();}
	if (!$entry)  {
		$bckid = 1; $deftemp = 'revolution';
		$db->setQuery ("UPDATE #__pibckadmin SET default_template = '{$deftemp}' WHERE id = '{$bckid}' ;"); 
					$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['uploadtype'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN uploadtype TINYINT(3) NOT NULL DEFAULT '1';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['checkin'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN checkin TINYINT(3) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['uploadfile'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN uploadfile VARCHAR(250) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['access'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN access TINYINT(3) NOT NULL DEFAULT '0';");
			$db->query();}
		$entry = false;
	$entry	= isset( $fields[$table]['audpurchase'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audpurchase TINYINT(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['audpurchase_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audpurchase_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['vidpurchase'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN vidpurchase TINYINT(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['vidpurchase_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN vidpurchase_folder INT(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['tableversion'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN tableversion TEXT NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['autopodcast'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN autopodcast int(4) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['droptables'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN droptables int(4) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['series'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN series int(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['ministry'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN ministry int(11) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['video'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN video tinyint(3) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['video_type'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN video_type int(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['audio_type'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audio_type int(11) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['video_download'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN video_download tinyint(3) NOT NULL;");
			$db->query();}			
	$entry = false;
	$entry	= isset( $fields[$table]['audio'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audio tinyint(3) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['audio_download'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audio_download tinyint(3) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['comments'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN comments tinyint(3) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['text'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN text int(4) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['teacher'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teacher int(11) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['audio_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN audio_folder int(11) NOT NULL;");
			$db->query();}	
	$entry = false;
	$entry	= isset( $fields[$table]['video_folder'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN video_folder int(11) NOT NULL;");
			$db->query();}	
	$entry	= isset( $fields[$table]['mfhide'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN mfhide text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['sfhide'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN sfhide text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['tfhide'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN tfhide text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['mfupsel'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN mfupsel text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['sfupsel'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN sfupsel text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['tfupsel'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN tfupsel text NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimsmw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimsmw INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimsmh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimsmh INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimmedw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimmedw INT(11) NOT NULL DEFAULT '100';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimmedh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimmedh INT(11) NOT NULL DEFAULT '100';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimlrgw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimlrgw INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['msimlrgh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN msimlrgh INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['teaimsmw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimsmw INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['teaimsmh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimsmh INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['teaimmedw'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimmedw INT(11) NOT NULL DEFAULT '100';");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['teaimmedh'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimmedh INT(11) NOT NULL DEFAULT '60';");
            $db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['teaimlrgw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimlrgw INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['teaimlrgh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN teaimlrgh INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['serimsmw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimsmw INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['serimsmh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimsmh INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['serimmedw'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimmedw INT(11) NOT NULL DEFAULT '100';");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['serimmedh'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimmedh INT(11) NOT NULL DEFAULT '60';");
            $db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['serimlrgw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimlrgw INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['serimlrgh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN serimlrgh INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['minimsmw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimsmw INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['minimsmh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimsmh INT(11) NOT NULL DEFAULT '50';");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['minimmedw'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimmedw INT(11) NOT NULL DEFAULT '100';");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['minimmedh'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimmedh INT(11) NOT NULL DEFAULT '60';");
            $db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['minimlrgw'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimlrgw INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['minimlrgh'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN minimlrgh INT(11) NOT NULL DEFAULT '200';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['imagequal'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN imagequal INT(11) NOT NULL DEFAULT '65';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['imageresize'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN imageresize INT(11) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['versioncheck'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN versioncheck DATETIME NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$table]['curversion'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN curversion TEXT NOT NULL;");
			$db->query();}
	$entry	= isset( $fields[$table]['language'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN language CHAR(7) DEFAULT '*' NOT NULL;");
			$db->query();}
	$entry	= isset( $fields[$table]['multilanguage'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN multilanguage TINYINT(3) NOT NULL;");
			$db->query();}
    $entry    = isset( $fields[$table]['prefixm'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN prefixm TINYINT(3) NOT NULL DEFAULT '1';");
            $db->query();}
    $entry    = isset( $fields[$table]['prefixi'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN prefixi TINYINT(3) NOT NULL DEFAULT '1';");
            $db->query();}
    $entry    = isset( $fields[$table]['upload_selector'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN upload_selector INT(11) NOT NULL;");
            $db->query();}
    $entry    = isset( $fields[$table]['upload_folder'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN upload_folder INT(11) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['slides'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN slides TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['slides_folder'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN slides_folder INT(11) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['slides_type'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN slides_type TINYINT(3) NOT NULL;");
            $db->query();}
    $entry = false;
    $entry    = isset( $fields[$table]['cookieconsent'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__pibckadmin ADD COLUMN cookieconsent TINYINT(3) NOT NULL DEFAULT '0';");
            $db->query();}

	$db->setQuery("ALTER TABLE #__pibckadmin CHANGE ministry ministry TEXT NOT NULL; ");
	$db->query();
	
	$db->setQuery("ALTER TABLE #__pibckadmin CHANGE teacher teacher TEXT NOT NULL; ");
	$db->query();
	
	$db->setQuery ("UPDATE #__pibckadmin SET versioncheck = '0000-00-00 00:00:00' WHERE id = '1' ;");
		$db->query();
		
	return true;
	
}

/**
     * Method to update pimediaplayers table
     * return boolean
    */

function updatemediaplayertable()
{

	$db	= & JFactory::getDBO();
		
	$mp = '#__pimediaplayers';
	$fields = $db->getTableFields ( array( $mp ) );
    
	$entry = false;
    $entry = isset( $fields[$mp]['vers'] );
    $check = $entry;    
    if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN vers INT(11) NOT NULL;");
    $db->query();}
	$fields = $db->getTableFields( array( $mp ) );
	$entry = false;
	$entry	= isset( $fields[$mp]['published'] );
	$check = $entry;	
	if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN published TINYINT(3) NOT NULL DEFAULT '1';");
	$db->query();}
    $db->setQuery ("ALTER TABLE #__pimediaplayers CHANGE vers vers DECIMAL( 5,2 ) NOT NULL;");
    $db->query();
		
	$entry = false;
	$entry	= isset( $fields[$mp]['playerscript'] );
	$check = $entry;	
	if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN playerscript VARCHAR(250) NOT NULL;");
	$db->query();
			
	$JWvid = 1;
	$JWaud = 6;	
	$Flow = 7;	
	$JWscript = 'components/com_preachit/assets/mediaplayers/jwplayer.js';
	$flowscript = 'components/com_preachit/assets/mediaplayers/flowplayer-3.2.2.min.js';
			
	$db->setQuery ("UPDATE #__pimediaplayers SET playerscript = '{$JWscript}' WHERE id = '{$JWvid}' ;"); 
	$db->query();	
	$db->setQuery ("UPDATE #__pimediaplayers SET playerscript = '{$JWscript}' WHERE id = '{$JWaud}' ;"); 
	$db->query();	
	$db->setQuery ("UPDATE #__pimediaplayers SET playerscript = '{$flowscript}' WHERE id = '{$Flow}' ;"); 
	$db->query();
	}
	$pixel = 5;
	$query = "
  	SELECT ".$db->nameQuote('playerscript')."
    FROM ".$db->nameQuote('#__pimediaplayers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($pixel).";
  	";
	$db->setQuery($query);
	$test = $db->loadResult();
				
	if ($test == '')
	{
	    $pixelscript = 'components/com_preachit/assets/mediaplayers/audio-player.js';
		$db->setQuery ("UPDATE #__pimediaplayers SET playerscript = '{$pixelscript}' WHERE id = '{$pixel}' ;"); 
		$db->query();			
	}
	$entry = false;
	$entry	= isset( $fields[$mp]['html5'] );
	$check = $entry;	
	if (!$entry) {
        $db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN html5 TINYINT(3) NOT NULL DEFAULT '0';");
			$db->query();
			$JWvid = 1;
			$JWaud = 6;	
			$Flow = 7;
			$pix = 5;	
			$set = 1;
			$db->setQuery ("UPDATE #__pimediaplayers SET html5 = '{$set}' WHERE id = '{$JWvid}' ;"); 
					$db->query();	
			$db->setQuery ("UPDATE #__pimediaplayers SET html5 = '{$set}' WHERE id = '{$JWaud}' ;"); 
					$db->query();	
			$db->setQuery ("UPDATE #__pimediaplayers SET html5 = '{$set}' WHERE id = '{$Flow}' ;"); 
					$db->query();	
			$db->setQuery ("UPDATE #__pimediaplayers SET html5 = '{$set}' WHERE id = '{$pix}' ;"); 
					$db->query();	
	}
            
    $query = "
    SELECT ".$db->nameQuote('version')."
    FROM ".$db->nameQuote('#__pimediaplayers')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote(3).";
    ";
    $db->setQuery($query);
    $vers = $db->loadResult();
                
    if ($vers < 3)
    {
        $code = '<div class="youtubeplayer"><iframe width="[width]" height="[height]" src="http://www.youtube.com/embed/[fileid]?rel=0" frameborder="0" allowfullscreen></iframe></div>';
        $db->setQuery ("UPDATE #__pimediaplayers SET playercode = '{$code}' WHERE id = '3' ;"); 
        $db->query();
    }
            
    $entry    = isset( $fields[$mp]['facebook'] );
    $check = $entry;    
    if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN facebook TINYINT(3) NOT NULL;");
    $db->query();}
    $entry    = isset( $fields[$mp]['image'] );
    $check = $entry;    
    if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN image INT(11) NOT NULL;");
    $db->query();}
    $entry    = isset( $fields[$mp]['playerurl'] );
    $check = $entry;    
    if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN playerurl VARCHAR(250) NOT NULL;");
    $db->query();}
    $entry    = isset( $fields[$mp]['runplugins'] );
    $check = $entry;    
    if (!$entry) {$db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN runplugins TINYINT(3) NOT NULL;");
    $db->query();}
    
            $JWvid = 1;
            $JWaud = 6;
            $pixel = 5;
            $flow = 7;
            $vimeo = 2;
            $youtube = 3;
            $bliptv = 4;
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($JWvid).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
                
                
            if ($vers < 3.54)
            {
                $db->setQuery ("ALTER TABLE #__pimediaplayers ADD COLUMN vers INT(11) DEFAULT '1' NOT NULL;");
                $db->query();
                $JWcode = '<div class="localvideoplayer" id="player-div">'
                            .'<p id="localplayer[unique_id]"></p>'
                            .'<script type="text/javascript">'
                            .'jwplayer("localplayer[unique_id]").setup({'
                            .'flashplayer: "[playerurl]",'
                            .'file: "[fileurl]",'
                            .'height: [height],'
                            .'width: [width],'
                            .'skin: "[skin]", controlbar: "bottom"'
                            .'});'
                            .'</script>'
                            .'</div>';
                $db->setQuery ("UPDATE #__pimediaplayers SET playercode = '{$JWcode}' WHERE id = '{$JWvid}' ;"); 
                $db->query(); 
            }
            if ($vers < 3.55)
            {   
                $set = '[root]/components/com_preachit/assets/mediaplayers/player.swf';
                 $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$JWvid}' ;"); 
                    $db->query();   
            }
            
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($JWaud).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
            if ($vers < 3.5)
            {
                $JWcode2 = '<div class="localaudioplayer" id="player-div">'
                            .'<p id="localplayer[unique_id]"></p>'
                            .'<script type="text/javascript">'
                            .'jwplayer("localplayer[unique_id]").setup({'
                            .'flashplayer: "[playerurl]",'
                            .'file: "[fileurl]",'
                            .'height: [height],'
                            .'width: [width],'
                            .'skin: "[skin]", controlbar: "bottom"'
                            .'});'
                            .'</script>'
                            .'</div>';
                
                
                $db->setQuery ("UPDATE #__pimediaplayers SET playercode = '{$JWcode2}' WHERE id = '{$JWaud}' ;"); 
                    $db->query(); 
            }
            if ($vers < 3.55)
            {    
                $set = '[root]/components/com_preachit/assets/mediaplayers/player.swf';
                $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$JWaud}' ;"); 
                    $db->query();  
            }
            
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($pixel).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
            if ($vers < 3.5)
            {
                    
                $pixelcode = '<div class="localaudioplayer">'
                                        .'<script type="text/javascript">'
                                    .'AudioPlayer.setup("[playerurl]", {'  
                                       .' width: [width],'  
                                        .'initialvolume: 100,'  
                                        .'transparentpagebg: "yes",'  
                                        .'left: "000000",'  
                                        .'lefticon: "FFFFFF"' 
                                    .'});'  
                                       .' </script> '
                                        .'<p id="audioplayer_[unique_id]">Alternative content</p>'  
                                    .'<script type="text/javascript">  '
                                        .'AudioPlayer.embed("audioplayer_[unique_id]", { ' 
                                        .'soundFile: "[fileurl]",'  
                                        .'titles: "Title",'  
                                        .'artists: "Artist name",'  
                                        .'autostart: "no"' 
                                        .'});'  
                                        .'</script>'
                                        .'</div>'; 
                    
                    $db->setQuery ("UPDATE #__pimediaplayers SET playercode = '{$pixelcode}' WHERE id = '{$pixel}' ;"); 
                    $db->query();
            }
            if ($vers < 3.55)
            {  
                    $set = '[root]/components/com_preachit/assets/mediaplayers/pixelplayer.swf';
                    $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$pixel}' ;"); 
                    $db->query(); 
            }
            
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($flow).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
            if ($vers < 3.5)
            {
                
                $flowcode = '<div class="localvideoplayer" id="player-div">'
                            .'<div style="width:[width]px;height:[height]px;" id="player[unique_id]"></div>'
                            .'<!-- this script block will install Flowplayer inside previous DIV tag -->'
                            .'<script language="JavaScript">'
                            .'flowplayer('
                            .'"player[unique_id]",'
                            .'"[playerurl]",'
                            .'"[fileurl]"'
                            .');'
                            .'</script>'
                            .'</div>';
                   $db->setQuery ("UPDATE #__pimediaplayers SET playercode = '{$flowcode}' WHERE id = '{$flow}' ;"); 
                   $db->query();
            }
            if ($vers < 3.55)
            {  
                   $set = '[root]/components/com_preachit/assets/mediaplayers/flowplayer-3.2.2.swf';
                   $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$flow}' ;"); 
                   $db->query(); 
            }
            
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($vimeo).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
            if ($vers < 3.5)
            {
                $set = 'http://vimeo.com/moogaloop.swf?clip_id=[fileid]&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0';
                $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$vimeo}' ;"); 
                   $db->query(); 
            }
            
            $vers = null;
            $query = "
                  SELECT ".$db->nameQuote('vers')."
                FROM ".$db->nameQuote('#__pimediaplayers')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($youtube).";
                  ";
                $db->setQuery($query);
                $vers = $db->loadResult();
            if ($vers < 3.5)
            {
                $set = 'http://www.youtube.com/watch?v=[fileid]';
                $db->setQuery ("UPDATE #__pimediaplayers SET playerurl = '{$set}' WHERE id = '{$youtube}' ;"); 
                   $db->query(); 
            }
            
            $query7 = "SELECT * FROM #__pimediaplayers";
            $db->setQuery($query7);
            $meplays = $db->loadObjectList();
            
            foreach ($meplays as $meplay)
            {
                $version = 3.55;    
                $db->setQuery ("UPDATE #__pimediaplayers SET vers = '{$version}' WHERE id = '{$meplay->id}' ;");
                $db->query(); 
            }

			
		return true;
}

/**
     * Method to update pishare table
     * return boolean
    */

function updatesharetable()
{

    $db    = & JFactory::getDBO();
    $tables = $db->getTableList();
    $prefix = $db->getPrefix();
    $tablecheck = $prefix.'pishare';
    if (!in_array($tablecheck, $tables))
    {    
        // set up table
        $db->setQuery ( "CREATE TABLE IF NOT EXISTS `#__pishare` LIKE `#__pimediaplayers`;"
                                );
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare CHANGE playername name VARCHAR(250) NOT NULL;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare CHANGE playerscript script VARCHAR(250) NOT NULL;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare CHANGE playercode code TEXT NOT NULL;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare DROP playertype;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare DROP vers;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pishare DROP html5;");
        $db->query();
        $db->setQuery ("ALTER TABLE #__pishare ADD COLUMN ordering INT(11) NOT NULL;");
        $db->query();
        
        // add data
        
        $share = & JTable::getInstance('Share', 'Table');
        $share->name = 'Addthis';
        $share->published = 1;
        $share->code = '<!-- AddThis Button begin -->
        <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_compact at300m" href="http://www.addthis.com/bookmark.php" 
        addthis:description="[sharedescription]" 
        addthis:title="[pagetitle]" addthis:url="[shareurl]" addthis:ui_click="true">[sharetext]</a><div class="atclear"></div></div>
          <script src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4bf7f9c3283266f1" type="text/javascript"></script>
          <!-- AddThis Button END -->';
        if (!$share->store())
        {JError::raiseError(500, $share->getError() );}
          
    }

        return true;
}

/**
     * Method to update pitemplates table
     * return boolean
    */

function updatetemplatetable()
{

    $db    = & JFactory::getDBO();
    $tables = $db->getTableList();
    $prefix = $db->getPrefix();
    $tablecheck = $prefix.'pitemplate';
    if (!in_array($tablecheck, $tables))
    {    
        // set up table
        $db->setQuery ( "CREATE TABLE IF NOT EXISTS `#__pitemplate` LIKE `#__template_styles`;"
                                );
        $db->query();
        $db->setQuery("ALTER TABLE #__pitemplate DROP home;");
        $db->query();  
        $db->setQuery ("ALTER TABLE #__pitemplate ADD COLUMN def TINYINT(3) NOT NULL;");
        $db->query();
        $db->setQuery ("ALTER TABLE #__pitemplate ADD COLUMN cssoverride TEXT NOT NULL;");
        $db->query();
        $db->setQuery("ALTER TABLE #__pibckadmin DROP default_template;");
        $db->query();
          
    }

        return true;
}

/**
     * Method to update pibiblevers
     * return boolean
    */		

function updatebibleversiontable()
{

	$db	= & JFactory::getDBO();
					
	$bv = '#__pibiblevers';
	$fields = $db->getTableFields( array( $bv ) );
	$entry = false;
	$entry	= isset( $fields[$bv]['published'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibiblevers ADD COLUMN published TINYINT(3) NOT NULL DEFAULT '1';");
			$db->query();}

	return true;
}

/**
     * Method to update pibooks table
     * return boolean
    */

function updatebooktable()
{

	$db	= & JFactory::getDBO();
			
	$bk = '#__pibooks';
	$fields = $db->getTableFields( array( $bk ) );
	$entry = false;
	$entry	= isset( $fields[$bk]['published'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibooks ADD COLUMN published TINYINT(3) NOT NULL DEFAULT '1';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$bk]['display_name'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibooks ADD COLUMN display_name VARCHAR(50) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$bk]['shortform'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pibooks ADD COLUMN shortform VARCHAR(50) NOT NULL;");
			$db->query();
			
			$query = "SELECT * FROM #__pibooks";
			$db->setQuery($query);
			$books = $db->loadObjectList();
			
					foreach ($books as $book)
						{
								$id = $book->id;
							if ($id == 1)
							{$dname = 'Genesis'; $sform = 'Gen';}
							if ($id == 2)
							{$dname = 'Exodus'; $sform = 'Exod';}
							if ($id == 3)
							{$dname = 'Leviticus'; $sform = 'Lev';}
							if ($id == 4)
							{$dname = 'Numbers'; $sform = 'Num';}
							if ($id == 5)
							{$dname = 'Deuteronomy'; $sform = 'Deut';}
							if ($id == 6)
							{$dname = 'Joshua'; $sform = 'Josh';}
							if ($id == 7)
							{$dname = 'Judges'; $sform = 'Judg';}
							if ($id == 8)
							{$dname = 'Ruth'; $sform = 'Ruth';}
							if ($id == 9)
							{$dname = '1 Samuel'; $sform = '1Sam';}
							if ($id == 10)
							{$dname = '2 Samuel'; $sform = '2Sam';}
							if ($id == 11)
							{$dname = '1 Kings'; $sform = '1Kgs';}
							if ($id == 12)
							{$dname = '2 Kings'; $sform = '2Kgs';}
							if ($id == 13)
							{$dname = '1 Chronicles'; $sform = '1Chr';}
							if ($id == 14)
							{$dname = '2 Chronicles'; $sform = '2Chr';}
							if ($id == 15)
							{$dname = 'Ezra'; $sform = 'Ezra';}
							if ($id == 16)
							{$dname = 'Nehemiah'; $sform = 'Neh';}
							if ($id == 17)
							{$dname = 'Esther'; $sform = 'Esth';}
							if ($id == 18)
							{$dname = 'Job'; $sform = 'Job';}
							if ($id == 19)
							{$dname = 'Psalms'; $sform = 'Ps';}
							if ($id == 20)
							{$dname = 'Proverbs'; $sform = 'Prov';}
							if ($id == 21)
							{$dname = 'Ecclesiastes'; $sform = 'Eccl';}
							if ($id == 22)
							{$dname = 'Song of Songs'; $sform = 'Song';}
							if ($id == 23)
							{$dname = 'Isaiah'; $sform = 'Isa';}
							if ($id == 24)
							{$dname = 'Jeremiah'; $sform = 'Jer';}
							if ($id == 25)
							{$dname = 'Lamentations'; $sform = 'Lam';}
							if ($id == 26)
							{$dname = 'Ezekiel'; $sform = 'Ezek';}
							if ($id == 27)
							{$dname = 'Daniel'; $sform = 'Dan';}
							if ($id == 28)
							{$dname = 'Hosea'; $sform = 'Hos';}
							if ($id == 29)
							{$dname = 'Joel'; $sform = 'Joel';}
							if ($id == 30)
							{$dname = 'Amos'; $sform = 'Amos';}
							if ($id == 31)
							{$dname = 'Obadiah'; $sform = 'Obad';}
							if ($id == 32)
							{$dname = 'Jonah'; $sform = 'Jonah';}
							if ($id == 33)
							{$dname = 'Micah'; $sform = 'Mic';}
							if ($id == 34)
							{$dname = 'Nahum'; $sform = 'Nah';}
							if ($id == 35)
							{$dname = 'Habakkuk'; $sform = 'Hab';}
							if ($id == 36)
							{$dname = 'Zephaniah'; $sform = 'Zeph';}
							if ($id == 37)
							{$dname = 'Haggai'; $sform = 'Hag';}
							if ($id == 38)
							{$dname = 'Zechariah'; $sform = 'Zech';}
							if ($id == 39)
							{$dname = 'Malachi'; $sform = 'Mal';}
							if ($id == 40)
							{$dname = 'Matthew'; $sform = 'Matt';}
							if ($id == 41)
							{$dname = 'Mark'; $sform = 'Mark';}
							if ($id == 42)
							{$dname = 'Luke'; $sform = 'Luke';}
							if ($id == 43)
							{$dname = 'John'; $sform = 'John';}
							if ($id == 44)
							{$dname = 'Acts'; $sform = 'Acts';}
							if ($id == 45)
							{$dname = 'Romans'; $sform = 'Rom';}
							if ($id == 46)
							{$dname = '1 Corinthians'; $sform = '1Cor';}
							if ($id == 47)
							{$dname = '2 Corinthians'; $sform = '2Cor';}
							if ($id == 48)
							{$dname = 'Galatians'; $sform = 'Gal';}
							if ($id == 49)
							{$dname = 'Ephesians'; $sform = 'Eph';}
							if ($id == 50)
							{$dname = 'Philippians'; $sform = 'Phil';}
							if ($id == 51)
							{$dname = 'Colossians'; $sform = 'Col';}
							if ($id == 52)
							{$dname = '1 Thessalonians'; $sform = '1Thess';}
							if ($id == 53)
							{$dname = '2 Thessalonians'; $sform = '2Thess';}
							if ($id == 54)
							{$dname = '1 Timothy'; $sform = '1Tim';}
							if ($id == 55)
							{$dname = '2 Timothy'; $sform = '2Tim';}
							if ($id == 56)
							{$dname = 'Titus'; $sform = 'Titus';}
							if ($id == 57)
							{$dname = 'Philemon'; $sform = 'Phlm';}
							if ($id == 58)
							{$dname = 'Hebrews'; $sform = 'Heb';}
							if ($id == 59)
							{$dname = 'James'; $sform = 'Jas';}
							if ($id == 60)
							{$dname = '1 Peter'; $sform = '1Pet';}
							if ($id == 61)
							{$dname = '2 Peter'; $sform = '2Pet';}
							if ($id == 62)
							{$dname = '1 John'; $sform = '1John';}
							if ($id == 63)
							{$dname = '2 John'; $sform = '2John';}
							if ($id == 64)
							{$dname = '3 John'; $sform = '3John';}
							if ($id == 65)
							{$dname = 'Jude'; $sform = 'Jude';}
							if ($id == 66)
							{$dname = 'Revelation'; $sform = 'Rev';}
							if ($id == 67)
							{$dname = 'Topical'; $sform = '';}
   							 						
					$db->setQuery ("UPDATE #__pibooks SET display_name = '{$dname}' WHERE id = '{$id}' ;"); 
					$db->query(); 
					$db->setQuery ("UPDATE #__pibooks SET shortform = '{$sform}' WHERE id = '{$id}' ;"); 
					$db->query(); 				
				}
			
			
	}

	return true;

}

/**
     * Method to update picomments table
     * return boolean
    */

function updatecommenttable()
{

	$db	= & JFactory::getDBO();

	$com = '#__picomments';
	$fields = $db->getTableFields( array( $com ) );
	$entry = false;
	$entry	= isset( $fields[$com]['published'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__picomments ADD COLUMN published TINYINT(3) NOT NULL DEFAULT '1';");
			$db->query();}
    $entry = false;
    $entry    = isset( $fields[$com]['email'] );
    $check = $entry;    
            if (!$entry) {$db->setQuery ("ALTER TABLE #__picomments ADD COLUMN email VARCHAR(250) NOT NULL;");
            $db->query();}
			
	return true;

}

/**
     * Method to update pifilepath table
     * return boolean
    */

function updatefiletable()
{

	$db	= & JFactory::getDBO();
		
	$file = '#__pifilepath';
	$fields = $db->getTableFields( array( $file ) );
	$entry = false;
	$entry	= isset( $fields[$file]['type'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN type TINYINT(3) NOT NULL DEFAULT '0';");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['ftphost'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN ftphost VARCHAR(100) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['ftpuser'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN ftpuser VARCHAR(250) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['ftppassword'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN ftppassword VARCHAR(250) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['ftpport'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN ftpport VARCHAR(10) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['aws_key'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN aws_key VARCHAR(100) NOT NULL;");
			$db->query();}
	$entry = false;
	$entry	= isset( $fields[$file]['aws_secret'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pifilepath ADD COLUMN aws_secret VARCHAR(100) NOT NULL;");
			$db->query();}
			
	return true;

}

/**
     * Method to update pimime table
     * return boolean
    */

function updatemimetable()
{

	$db	= & JFactory::getDBO();
		
	$ml = '#__pimime';
	$fields = $db->getTableFields( array( $ml ) );
	$entry = false;
	$entry	= isset( $fields[$ml]['published'] );
	$check = $entry;	
			if (!$entry) {$db->setQuery ("ALTER TABLE #__pimime ADD COLUMN published TINYINT(3) NOT NULL DEFAULT '1';");
			$db->query();}
    
    //add necessary rows
    
    $doc = PIHelperupdate::addmimerow('doc', 'application/msword');
    $doc = PIHelperupdate::addmimerow('pdf', 'application/pdf');
    $doc = PIHelperupdate::addmimerow('ppt', 'application/vnd.ms-powerpoint');
    
    $row =& JTable::getInstance('Mime', 'Table');
    
			
	return true;

}

/**
     * Method to set table version
     * return boolean
    */

function settableversion()
{
	$db = & JFactory::getDBO();
	$version = PIHelperupdate::tableversion();
	$id = 1;

	$db->setQuery ("UPDATE #__pibckadmin SET tableversion = '{$version}' WHERE id = '{$id}' ;"); 
	$db->query();
	
	return true;
}

/**
     * Method to copy revolution template on fresh install
     * return boolean
    */

function movetemplates()
{
	$path = 	JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tmp';
	$copy = false;
	$revolution = PIHelperupdate::filemover('revolution');
	
	if ($revolution)
	{
		$copy = true;
	}
	
	return $copy;
	
}

/**
     * Method to copy file
     * @param string $temp temp folder name
     * return boolean
    */

function filemover($temp)
{
           
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
    jimport('joomla.client.helper');
   $src = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'original_templates'.DIRECTORY_SEPARATOR.$temp;
   $dest = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp;
   $copy = false;
   $exists = JFolder::exists($dest);    
   $id = PIHelpertemp::tempid($temp);        
   if ($id >! 0 && $exists || $id == null && $exists)
   {$record = PIHelpertemp::createtemprecord($dest, $temp);
   JFolder::delete($dest);
   $copy = JFolder::copy($src, $dest);} 
   elseif ($id >! 0 && !$exists || $id == null && !$exists)
   {$copy = JFolder::copy($src, $dest);
   $record = PIHelpertemp::createtemprecord($dest, $temp);}
   
   // update mediaplayer activator in templates
   
   // get all the template folders
   
   $folders = JFolder::folders(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates');
   
   //loop through folders
   
   foreach ($folders as $folder)
   {
       // fet files to check
       $files = JFolder::files(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.'/'.$folder);
       // loop through files to check and change if necessary
       foreach ($files AS $file)
       {
           $filecontent = null;
           $filepath = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.'/'.$folder.'/'.$file;
           // open file
           if (!JFile::exists($filepath))
           {continue;}
           $filecontent=fopen($filepath,"rb");
           $content = fread($filecontent,filesize($filepath));
           fclose($filecontent);
           
           // string replace the code
           
           $content = str_replace('echo $this->message->audioplayer;', 'PIHelperadditional::showmediaplayer($this->message->audioplayer);', $content );
        
            $content = str_replace('echo $this->message->videoplayer;', 'PIHelperadditional::showmediaplayer($this->message->videoplayer);', $content );
           
           // Set FTP credentials, if given
           JClientHelper::setCredentialsFromRequest('ftp');
           $ftp = JClientHelper::getCredentials('ftp');
           $client =& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
           // Try to make the template file writeable
           
           JFILE::write($filepath, $content);
       }
       
       $plugins = JFolder::files(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.'/'.$folder.'/plugin');
       // loop through files to check and change if necessary
       foreach ($files AS $file)
       {
           $filecontent = null;
           $filepath = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.'/'.$folder.'/plugin/'.$file;
           // open file
           if (!JFile::exists($filepath))
           {continue;}
           $filecontent=fopen($filepath,"rb");
           $content = fread($filecontent,filesize($filepath));
           fclose($filecontent);
           
           // string replace the code
           
           $content = str_replace('$html .= $message->audioplayer;', 'PIHelperadditional::showpluginmediaplayer($message->audioplayer);', $content );
           $content = str_replace('$html.= $message->audioplayer;', 'PIHelperadditional::showpluginmediaplayer($message->audioplayer);', $content );
           $content = str_replace('$html .=$message->audioplayer;', 'PIHelperadditional::showpluginmediaplayer($message->audioplayer);', $content );
           $content = str_replace('$html.=$message->audioplayer;', 'PIHelperadditional::showpluginmediaplayer($message->audioplayer);', $content );
           $content = str_replace('$html .= $message->videoplayer;', 'PIHelperadditional::showpluginmediaplayer($message->videoplayer);', $content );
           $content = str_replace('$html.= $message->videoplayer;', 'PIHelperadditional::showpluginmediaplayer($message->videoplayer);', $content );
           $content = str_replace('$html .=$message->videoplayer;', 'PIHelperadditional::showpluginmediaplayer($message->videoplayer);', $content );
           $content = str_replace('$html.=$message->videoplayer;', 'PIHelperadditional::showpluginmediaplayer($message->videoplayer);', $content );
           
           // Set FTP credentials, if given
           JClientHelper::setCredentialsFromRequest('ftp');
           $ftp = JClientHelper::getCredentials('ftp');
           $client =& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
           // Try to make the template file writeable
           
           JFILE::write($filepath, $content);
       }
       
       
   }
	
	return $copy;
	
}	

/**
     * Method to add a record to pimime
     * @param string $ext extension value
     * @param string $type extension type
     * return boolean
    */

function addmimerow($ext, $type)
{
    
    $db=& JFactory::getDBO();    
    $query = "SELECT ".$db->nameQuote('id')."
    FROM ".$db->nameQuote('#__pimime')."
    WHERE ".$db->nameQuote('extension')." = ".$db->quote($ext).";
  ";
  $db->setQuery($query);
  $entry = $db->loadResult();
  
  if ($entry >! 0 || !$entry)
    { 
        $row =& JTable::getInstance('Mime', 'Table');
        $row->published = 1;
        $row->extension = $ext;
        $row->mediatype = $type;
        if (!$row->store())
        {JError::raiseError(500, $row->getError() );}
    }
  return true;
}

/**
     * Method to process alias' to be unique'
     * return boolean
    */
function processalias()
{
    $db    = & JFactory::getDBO();
    define('tealiasadmin', true);
    // run alias update and chaeck
    
    $query = "SELECT id FROM #__pistudies";
            $db->setQuery($query);
            $studies = $db->loadObjectList();
            
                    foreach ($studies as $study)
                    {                                 
                        $row =& JTable::getInstance('Studies', 'Table');
                        $row->load($study->id);
                        if(empty($row->study_alias)) 
                        {$row->study_alias = $row->study_name;} 
                        $row->study_alias = Tewebadmin::uniquealias('#__pistudies',$row->study_alias, $row->id, 'study_alias');
                        if (!$row->store())
                        {JError::raiseError(500, $row->getError() );}    
                    }
    
    $query = "SELECT id FROM #__piseries";
            $db->setQuery($query);
            $series = $db->loadObjectList();
            
                    foreach ($series as $ser)
                    {                                 
                        $row =& JTable::getInstance('Series', 'Table');
                        $row->load($ser->id);
                        if(empty($row->series_alias)) 
                        {$row->series_alias = $row->series_name;} 
                        $row->series_alias = Tewebadmin::uniquealias('#__piseries',$row->series_alias, $row->id, 'series_alias');
                        if (!$row->store())
                        {JError::raiseError(500, $row->getError() );}    
                    }
    
    $query = "SELECT id FROM #__piministry";
            $db->setQuery($query);
            $ministry = $db->loadObjectList();
            
                    foreach ($ministry as $min)
                    {                                 
                        $row =& JTable::getInstance('Ministry', 'Table');
                        $row->load($min->id);
                        if(empty($row->ministry_alias)) 
                        {$row->ministry_alias = $row->ministry_name;} 
                        $row->ministry_alias = Tewebadmin::uniquealias('#__piministry',$row->ministry_alias, $row->id, 'ministry_alias');
                        if (!$row->store())
                        {JError::raiseError(500, $row->getError() );}    
                    }
    
    $query = "SELECT id FROM #__piteachers";
            $db->setQuery($query);
            $teachers = $db->loadObjectList();
            
                    foreach ($teachers as $tea)
                    {                                 
                        $row =& JTable::getInstance('Teachers', 'Table');
                        $row->load($tea->id);
                        if(empty($row->teacher_alias)) 
                        {
                            if ($row->teacher_name)
                            {$name = $row->teacher_name.' '.$row->lastname;}
                            else {$name = $row->lastname;}
                            $row->teacher_alias = $name;
                        }
                        $row->teacher_alias = Tewebadmin::uniquealias('#__piteachers',$row->teacher_alias, $row->id, 'teacher_alias');
                        if (!$row->store())
                        {JError::raiseError(500, $row->getError() );}    
                    }
    return true;
    
}

/**
     * Method to remove old folders
     * return boolean
    */
function removeoldfolders()
{
    jimport('joomla.filesystem.folder');
    $abspath = JPATH_SITE;
    $folders = array();
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/elements';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/images';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/assets/swfupload';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/assets/icons';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/audio';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/audiopopup';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/ministry';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/series';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/teacher';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/video';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/videopopup';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/models/forms';
    $folders[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/models/fields';
    $noerror = true;
    foreach ($folders AS $f)
    {
        if (JFolder::exists($f))
        {
            if (!JFolder::delete($f))
            {
                $noerror = false;
            }
        }
    }
    return $noerror;  
}

/**
     * Method to remove old folders
     * return boolean
    */
function removeoldfiles()
{
    jimport('joomla.filesystem.file');
    $abspath = JPATH_SITE;
    $files = array();
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/tables/bckadmin.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/admin/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/bibleversedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/bookedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/commentedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/filepathedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/mediaplayersedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/mimeedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/ministryedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/podcastedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/seriesedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/studyedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/teacheredit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/views/templateedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/models/series.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/models/teacher.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/models/ministry.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/studyedit/tmpl/form15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/booklist/tmpl/default.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/datelist/tmpl/default.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/studyedit/tmpl/form15.xml';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/seriesedit/tmpl/modal15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/seriesedit/tmpl/modal15.xml';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/teacheredit/tmpl/modal15.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/views/teacheredit/tmpl/modal15.xml';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/addchecks.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/adminfunctions.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/audioid3.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/imageresize.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/pluginviewaudio.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/pluginviewlist.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/pluginviewvideo.php';
    $files[] = $abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/urlbuilder.php';
    
    $noerror = true;
    foreach ($files AS $f)
    {
        if (JFile::exists($f))
        {
            if (!JFile::delete($f))
            {
                $noerror = false;
            }
        }
    }
    return $noerror;  
}
		
}
