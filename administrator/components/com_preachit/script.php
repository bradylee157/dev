<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class com_preachitInstallerScript
{

function install($parent) 
{
        $this->_update();
        $parent->getParent()->setRedirectURL('index.php?option=com_preachit');
}

/**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {

    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
     function postflight($type, $parent) {

    }


function uninstall($parent) 
{
	$database	= & JFactory::getDBO();
	$query = "SELECT ".$database->nameQuote('droptables')."
    FROM ".$database->nameQuote('#__pibckadmin')."
    WHERE ".$database->nameQuote('id')." = ".$database->quote('1').";
  ";
$database->setQuery($query);
$droptables = $database->loadResult();

    $database->setQuery ("TRUNCATE TABLE #__pitemplate");
        $database->query();
        if ($database->getErrorNum()) {
                    echo 'Database Error: '.$database->stderr().' Error ';
                    return false;
                }

	if ($droptables >0)
	{
		
		$database->setQuery ("DROP TABLE IF EXISTS #__pistudies");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__piteachers");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pimime");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pibooks");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__piseries");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__picomments");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pifilepath");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pipodcast");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__piministry");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pimediaplayers");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pibckadmin");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pipodmes");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__adminpodmes");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pibiblevers");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
		$database->setQuery ("DROP TABLE IF EXISTS #__pitemplates");
		$database->query();
		if ($database->getErrorNum()) {
					echo 'Database Error: '.$database->stderr().' Error ';
					return false;
				}
        $database->setQuery ("DROP TABLE IF EXISTS #__pishare");
        $database->query();
        if ($database->getErrorNum()) {
                    echo 'Database Error: '.$database->stderr().' Error ';
                    return false;
                }
if ($database->query()) {
                                    echo '<tr><td><li >Successful - Preachit Tables Dropped</li></td></tr>';
                                    }
                                else {
                                    echo '<tr><td><li >Attempt to drop tables not successful. They must be manually removed.</li></td></tr>';
                                    }
	}
	else
	{
		echo '<li >Database tables have not been removed<p> Be sure to uninstall the module and plugin as well if you have installed them. </p> 
		<p> If you want to complete your uninstall of preachit, remove all database tables that start with #__pi (or jos_pi in most cases). </p></li>';
	}
}


/**
     * method to update the component
     *
     * @return void
     */
    function update($parent) 
    {
        $this->_update();
    }
    
    /**
     * method to run to update tables, install templates and remove any old files necessary
     *
     * @return void
     */
    function _update(){
        $abspath    = JPATH_SITE;
        require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/update.php');
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
        PIHelperupdate::movetemplates();
        PIHelperupdate::processalias();
        $folders = PIHelperupdate::removeoldfolders();
        $files = PIHelperupdate::removeoldfiles();
        return;
    }


}
