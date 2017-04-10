<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.admin.records');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/update.php');
jimport('joomla.application.component.controller');
class PreachitControllerAdmin extends JController
{
/**
	 * Method save admin record.
	 *
	 * @return	redirect with message
	 */
function save()
{

JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
// get table, bind and store data
$row =Tewebadmin::getformdetails('Piadmin'); 

if (isset($row->teacher))
{$row->teacher = implode(',', $row->teacher);} else {$row->teacher = '';}
if (isset($row->ministry))
{$row->ministry = implode(',', $row->ministry);} else {$row->ministry = '';}
if (isset($row->mfhide))
{$row->mfhide = implode(',', $row->mfhide);} else {$row->mfhide = '';}
if (isset($row->tfhide))
{$row->tfhide = implode(',', $row->tfhide);} else {$row->tfhide = '';}
if (isset($row->sfhide))
{$row->sfhide = implode(',', $row->sfhide);} else {$row->sfhide = '';}
if (isset($row->mfupsel))
{$row->mfupsel = implode(',', $row->mfupsel);} else {$row->mfupsel = '';}
if (isset($row->tfupsel))
{$row->tfupsel = implode(',', $row->tfupsel);} else {$row->tfupsel = '';}
if (isset($row->sfupsel))
{$row->sfupsel = implode(',', $row->sfupsel);} else {$row->sfupsel = '';}

if (!$row->store())
{JError::raiseError(500, $row->getError() );}
if ($this->getTask() == 'save' || $this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_SETTINGS_SAVED'), 'message' );
$app->Redirect('index.php?option=' . $option . '&view=admin');}
else {return true;}
}

/**
	 * Method to run change codeset for preachit entries in database table
	 *
	 * @return	redirect with message
	 */

function codeset()

{
JRequest::checktoken() or jexit( 'Invalid Token' );	
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$charset = JRequest::getVar('codeset', '', 'POST', 'STRING');
$db	= & JFactory::getDBO();


$db->setQuery ("ALTER TABLE #__pibckadmin CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pibiblevers CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci; ");
			$db->query();
$db->setQuery ("ALTER TABLE #__pibooks CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci; ");
			$db->query();
$db->setQuery ("ALTER TABLE #__picomments CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pifilepath CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pimediaplayers CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pimime CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__piministry CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__piseries CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__piteachers CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pipodcast CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pistudies CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();
$db->setQuery ("ALTER TABLE #__pitemplates CONVERT TO CHARACTER SET utf8 COLLATE utf8_".$charset."_ci;");
			$db->query();

$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CODESET_CHANGED'), 'notice' );			
$app->Redirect('index.php?option=' . $option . '&view=admin');
}

/**
	 * Method override run table update process.
	 * @return	redirect with message
	 */

function updatetable()
{                  
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$user	= JFactory::getUser();      
if (!$user)
{die();}
else {   
// update the tables
$this->settables();
$this->setalias();
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_TABLES_UPDATED'), 'message' );
$this->checkphp();		
$app->Redirect('index.php?option=' . $option . '&view=admin');
}
}
/**
     * Method to check php settings
     * @return    boolean
     */
function checkphp()
{
    $ajax = JRequest::getInt('ajax', 0);
    $response = null;
    $vers = Tewebcheck::checkphp();
    $curl = Tewebcheck::checkcurl();
    $error = false;
    if ($vers[0] < 5)
    {
        if ($ajax == 0)
        {JError::raiseWarning( 100, JText::sprintf('LIB_TEWEB_MESSAGE_PHP4') );}
        else {$response .= JText::_('LIB_TEWEB_MESSAGE_PHP4');}
        $error = true;
    }
    if (!$curl)
    {
        if ($ajax == 0)
        {JError::raiseWarning( 100, JText::sprintf('LIB_TEWEB_MESSAGE_NO_CURL') );}
        else {$response .= JText::_('LIB_TEWEB_MESSAGE_NO_CURL');}
        $error = true;
    }
    if (!$error)
    {
        $response = '<li class="teinstall-success"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_PHP_SETTINGS_OK').'</span></li>';
    }
    else {
        $response = '<li class="teinstall-failure"><span class="teinstall-icon"></span><span class="teinstall-row">'.$response.'</span></li>';
    }
    if ($ajax == 0)
    {return true;}
    else {echo $response;}
}

/**
     * Method to run table updates
     * @return    boolean
     */
function settables()
{
    $user    = JFactory::getUser();
    if (!$user->authorize('core.admin', 'com_preachit') && !$user->authorize('core.manage', 'com_installer') ) 
    {Tewebcheck::check403();}
    $ajax = JRequest::getInt('ajax', 0);
    $studies = PIHelperupdate::updatestudytable();
    $series = PIHelperupdate::updateseriestable();
    $ministry = PIHelperupdate::updateministrytable();
    $teacher = PIHelperupdate::updateteachertable(); 
    $podcast = PIHelperupdate::updatepodcasttable();
    $temp = PIHelperupdate::updatetemptable();  
    $template = PIHelperupdate::updatetemplatetable();
    $admin = PIHelperupdate::updateadmintable();
    $mediaplayer = PIHelperupdate::updatemediaplayertable();
    $bversion = PIHelperupdate::updatebibleversiontable();
    $book = PIHelperupdate::updatebooktable();
    $comment = PIHelperupdate::updatecommenttable();
    $mime = PIHelperupdate::updatemimetable();
    $filepath = PIHelperupdate::updatefiletable();
    $sharetable = PIHelperupdate::updatesharetable();
    $update = PIHelperupdate::settableversion();
    $response = '<li class="teinstall-success"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_TABLES_UPDATED').'</span></li>';
    if ($ajax == 0)
    {return true;}
    else {echo $response;}
    
}

/**
     * Method to run temp move
     * @return    boolean
     */
function settemplates()
{
    $user    = JFactory::getUser();
    if (!$user->authorize('core.admin', 'com_preachit') && !$user->authorize('core.manage', 'com_installer') ) 
    {Tewebcheck::check403();}
    $ajax = JRequest::getInt('ajax', 0);
    $movefiles = PIHelperupdate::movetemplates();
    $response = '<li class="teinstall-success"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_TEMPS_UPDATED').'</span></li>';
    if ($ajax == 0)
    {return true;}
    else {echo $response;}
    
}

/**
     * Method to run unique alias check
     * @return    boolean
     */
function setalias()
{
    $user    = JFactory::getUser();
    if (!$user->authorize('core.admin', 'com_preachit') && !$user->authorize('core.manage', 'com_installer') ) 
    {Tewebcheck::check403();}
    $ajax = JRequest::getInt('ajax', 0);
    $alias = PIHelperupdate::processalias();
    $response = '<li class="teinstall-success"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_ALIAS_PROCESSED').'</span></li>';
    if ($ajax == 0)
    {return true;}
    else {echo $response;}
}

/**
     * Method to remove old files
     * @return    boolean
     */
function removeoldfiles()
{
    $user    = JFactory::getUser();
    if (!$user->authorize('core.admin', 'com_preachit') && !$user->authorize('core.manage', 'com_installer') ) 
    {Tewebcheck::check403();}
    $ajax = JRequest::getInt('ajax', 0);
    $folders = PIHelperupdate::removeoldfolders();
    $files = PIHelperupdate::removeoldfiles();
    if ($folders && $files)
    {$response = '<li class="teinstall-success"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_FILES_REMOVED').'</span></li>';}
    else {$response = '<li class="teinstall-failure"><span class="teinstall-icon"></span><span class="teinstall-row">'.JText::_('LIB_TEWEB_MESSAGE_FILES_REMOVED_ERROR').'</span></li>';}
    if ($ajax == 0)
    {return true;}
    else {echo $response;}
}

/**
     * Method to get welcome message
     * @return    string
     */
function getwelcome()
{?>
<div class="tewelcomemessage">
<div style="float: right; width: 200px; text-align: center;">
  <a href="http://twitter.com/com_preachit"><img src="../components/com_preachit/assets/images/twitter.png" 
  alt="follow preachit on twitter" style="margin: 10px; border: 1px solid #D5D5D5; padding: 4px; background: transparent; float: top;"></a>
  <div style="text-align: center;"><a target="blank" title="com_preachit twitter page" href="http://twitter.com/com_preachit"><?php echo JText::_('COM_PREACHIT_CPANEL_TWITTER_TITLE');?></a></div>
  <a href="http://www.facebook.com/pages/Preachit-Joomla-extension/161990947152515"><img src="../components/com_preachit/assets/images/facebook.png" 
  alt="follow preachit on facebook" style="margin: 10px; border: 1px solid #D5D5D5; padding: 4px; background: transparent; float: top;"></a>
  <div style="text-align: center;"><a target="blank" title="com_preachit facebook page" href="http://www.facebook.com/pages/Preachit-Joomla-extension/161990947152515">
  <?php echo JText::_('COM_PREACHIT_CPANEL_FACEBOOK_TITLE');?></a></div></div>
  <img style="float: left; margin: 0 10px 10px 0;"src="../components/com_preachit/assets/images/picpanel.png" />
  <h2><?php echo JText::_('COM_PREACHIT_WEL_HEADER');?></h2><?php echo JText::_('COM_PREACHIT_WEL_MESSAGE');?>
</div>
<?php
}

function migratess()
{
JRequest::checktoken() or jexit( 'Invalid Token' );    
$app = JFactory::getApplication();    
$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/migrate.php');
// migrate folders
$folders = PIHelpermigrate::migratessfolders();
$folderspics = PIHelpermigrate::migratessfolderspics();
// migrate series
$series = PIHelpermigrate::migratessseries();
// migrate teachers
$teacher = PIHelpermigrate::migratessteachers();
// migrate messages
$message = PIHelpermigrate::migratessmessages();   
$alias = PIHelperupdate::processalias();
if (!$folders || $folderspics || !$series || !$teacher || !$message)
{$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_ERROR'), 'warning' );}
else {$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_TRUE'), 'message' );}

$app->Redirect('index.php?option=' . $option . '&view=admin');
}

function migratejbs()
{
JRequest::checktoken() or jexit( 'Invalid Token' );    
$app = JFactory::getApplication();    
$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/migrate.php');
// migrate folders
$folders = PIHelpermigrate::migratejbsfolders();
$folderspics = PIHelpermigrate::migratejbsfolderspics();
// migrate series
$series = PIHelpermigrate::migratejbsseries();
// migrate teachers
$teacher = PIHelpermigrate::migratejbsteachers();
// migrate messages
$message = PIHelpermigrate::migratejbsmessages();   
$alias = PIHelperupdate::processalias();
if (!$folders || !$folderspics || !$series || !$message || !$teacher)
{$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_ERROR'), 'warning' );}
else {$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_TRUE'), 'message' );}

$app->Redirect('index.php?option=' . $option . '&view=admin');
}

function migratesm()
{
JRequest::checktoken() or jexit( 'Invalid Token' );    
$app = JFactory::getApplication();    
$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/migrate.php');
// migrate folders
$sermons = PIHelpermigrate::migratesm(); 
if (!$sermons)
{$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_ERROR'), 'warning' );}
else {$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_MIGRATION_TRUE'), 'message' );}

$app->Redirect('index.php?option=' . $option . '&view=admin');
}

function backupall()
{
JRequest::checktoken('get') or jexit( 'Invalid Token' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/backup.php');
$backup=PIHelperbackup::backup();
die;      
}

function restore()
{
JRequest::checktoken() or jexit( 'Invalid Token' ); 
$app = JFactory::getApplication();    
$option = JRequest::getCmd('option');
jimport('joomla.filesystem.file');
$fail = false;
$msg = null;
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/restore.php');
$user =& JFactory::getUser();  
if (!$user->authorize('core.admin', 'com_preachit'))
{Tewebcheck::check403();}
// get variables
if ($this->getTask() == 'import')
{$overwrite = 0;} else {$overwrite = 1;}
$file = JRequest::getVar( 'uploadfile', '', 'files', 'array' );

// need to check if xml

$ext = JFile::getExt($file['name']);
if ($ext != 'xml')
{$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_RESTORE_ERROR_NO_XML'), 'warning' );
$fail = true;}
else {
// load file into simplexml
$tables = new SimpleXMLElement($file['tmp_name'],null,true);
// need to check if Preachit backup xml
if (!isset($tables['type']) || $tables['type'] != 'pibackup')
{$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_RESTORE_ERROR_NO_PREACHIT_XML'), 'warning' );
$fail = true;}
}
if (!$fail)
{
//restore tables
$mediaplayers = PIHelperrestore::restoremp($tables, $overwrite);
$share = PIHelperrestore::restoreshare($tables, $overwrite);
$filepath = PIHelperrestore::restorefp($tables, $overwrite);
$podcasts = PIHelperrestore::restorepod($tables, $overwrite);
$ministries = PIHelperrestore::restoremin($tables, $overwrite);
$series = PIHelperrestore::restoreser($tables, $overwrite);
$teachers = PIHelperrestore::restoreteach($tables, $overwrite);
$messages = PIHelperrestore::restoremes($tables, $overwrite);
$alias = PIHelperupdate::processalias();
$app->enqueueMessage ( JText::_('COM_PREACHIT_ADMIN_MESSAGE_RESTORE_TRUE'), 'notice' );
}
$app->Redirect('index.php?option=' . $option . '&view=admin');   
}

/**
	 * Method to checkin all records across preachit.
	 *
	 * @return	redirect with message
	 */

function checkinall()

{
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db	= & JFactory::getDBO();
$row =& JTable::getInstance('Studies', 'Table');
$stable =& JTable::getInstance('Series', 'Table');
$ttable =& JTable::getInstance('Teachers', 'Table');

$query = "SELECT * FROM #__pistudies";
$db->setQuery($query);
$studies = $db->loadObjectList();

$query = "SELECT * FROM #__piseries";
$db->setQuery($query);
$series = $db->loadObjectList();

$query = "SELECT * FROM #__piteachers";
$db->setQuery($query);
$teachers = $db->loadObjectList();

foreach ($studies as $study)
{
	$row->checkin($study->id);
}

foreach ($series as $ser)
{
	$stable->checkin($ser->id);
}

foreach ($teachers as $teach)
{
	$ttable->checkin($teach->id);
}
$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_RECORDS_CHECKED_IN'), 'notice' );
$app->Redirect('index.php?option=' . $option . '&view=admin');
}

/**
     * Method to resize all images 
     *
     * @return    redirect with message
     */

function resizeimages()
{
    JRequest::checktoken() or jexit( 'Invalid Token' ); 
    $app = JFactory::getApplication();
    $option = JRequest::getCmd('option');
    $db    = & JFactory::getDBO();
    
    $this->save();
    
    jimport('joomla.filesystem.folder');
        $abspath = JPATH_SITE;
        $folders[] = $abspath.DIRECTORY_SEPARATOR.'media/preachit/messages';
        $folders[] = $abspath.DIRECTORY_SEPARATOR.'media/preachit/ministry';
        $folders[] = $abspath.DIRECTORY_SEPARATOR.'media/preachit/teachers';
        $folders[] = $abspath.DIRECTORY_SEPARATOR.'media/preachit/series';
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
    
    // get helpers
    $abspath    = JPATH_SITE;
    require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
    jimport('joomla.filesystem.file');
    
    // get records
    $query = "SELECT * FROM #__pistudies";
    $db->setQuery($query);
    $studies = $db->loadObjectList();

    $query = "SELECT * FROM #__piseries";
    $db->setQuery($query);
    $series = $db->loadObjectList();

    $query = "SELECT * FROM #__piteachers";
    $db->setQuery($query);
    $teachers = $db->loadObjectList();
    
    $query = "SELECT * FROM #__piministries";
    $db->setQuery($query);
    $ministries = $db->loadObjectList();
    
    if (is_array($studies))
    {
        foreach ($studies as $study)
        {
            if ($study->imagelrg)
            {$file = Tewebbuildurl::geturl($study->imagelrg, $study->image_folderlrg, 'pifilepath');
            PIHelperadmin::resizemesimage($file, 4, $study->id, true);}  
        }
    }

    if (is_array($series))
    {
        foreach ($series as $ser)
        {
            if ($ser->series_image_lrg)
            {$file = Tewebbuildurl::geturl($ser->series_image_lrg, $ser->image_folderlrg, 'pifilepath');
            PIHelperadmin::resizeserimage($file, 1, $ser->id, true);}
        }
    }
       
    if (is_array($teachers))
    { 
        foreach ($teachers as $teach)
        {  
            if ($teach->teacher_image_lrg)
            {$file = Tewebbuildurl::geturl($teach->teacher_image_lrg, $teach->image_folderlrg, 'pifilepath');
            PIHelperadmin::resizeteaimage($file, 1, $teach->id, true);}
        }
    }
    
    if (is_array($ministries))
    { 
        foreach ($ministries as $min)
        {
            if ($min->ministry_image_lrg)
            {$file = Tewebbuildurl::geturl($min->ministry_image_lrg, $min->image_folder, 'pifilepath');
            PIHelperadmin::resizeminimage($file, 1, $min->id, true);}
        }
    }
    $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_IMAGES_RESIZED'), 'notice' );
    $app->Redirect('index.php?option=' . $option . '&view=admin');

}

/**
	 * Method to set display.
	 *
	 */

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'admin');}
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}
/**
	 * Method construct task associations.
	 *
	 */
function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
$this->registerTask('import', 'restore');
}
}
