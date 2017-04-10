<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.html.parameter' );

class PIVersion {
    
/**
	* Retrieve preachit version from preachit.xml
	*
	* @return string version
	*/	
	function versionXML()
	{
		$abspath    = JPATH_SITE;
        jimport('joomla.filesystem.file');
	    $install = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/preachit.xml';
        if (JFile::exists($install))
        {
		    if ($data = JApplicationHelper::parseXMLInstallFile($install)) {	
            			return $data['version'];
		    }
        }
		return 'ERROR';
	}
    
/**
    * Retrieve preachit created date from preachit.xml
    *
    * @return string version
    */    
	function dateXML()
	{
    $abspath    = JPATH_SITE;
	$install = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/preachit.xml';
		if ($data = JApplicationHelper::parseXMLInstallFile($install)) {	
					return $data['creationDate'];
		}
		return 'ERROR';
	}
    
/**
    * Retrieve preachit copyright from preachit.xml
    *
    * @return string version
    */    
	function copyrightXML()
	{
		$abspath    = JPATH_SITE;
	$install = $abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/preachit.xml';
		if ($data = JApplicationHelper::parseXMLInstallFile($install)) {
			return $data['copyright'];
		}
		return 'ERROR';
	}

}
?>
