<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebbuildurl{

/**
     * Method to get url 
     *
     * @param string $file filename or whole url to build url for
     * @param int $folderid id of folder record if needed
     * @param string $dtable table name to search for folder details without #__
     *
     * @return   boolean
     */
    
function geturl($file, $folderid = 0, $dtable = null)
{
if ($folderid > 0)
{
// get raw details
$server = Tewebbuildurl::getserver($folderid, $dtable);
$folder = Tewebbuildurl::getfolder($folderid, $dtable);	
// clean variables if entered wrong
$server = Tewebbuildurl::cleanserver($server, $dtable);
$folder = Tewebbuildurl::cleanfolder($folder, $dtable);
//build the url
$fileurl = Tewebbuildurl::buildurl($server, $folder, trim($file));
}
else {$fileurl = $file;}
return $fileurl;
}

/**
     * Method to get server from database
     *
     * @param int $folderid id of folder record
     * @param string $dtable table name to search for folder details without #__
     *
     * @return   boolean
     */

function getserver($folder, $dtable)
{
$db=& JFactory::getDBO();
$query = "
  SELECT ".$db->nameQuote('server')."
    FROM ".$db->nameQuote('#__'.$dtable)."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($folder).";
  ";
$db->setQuery($query);
$server = $db->loadResult();
return trim($server);
}

/**
     * Method to get folderpath from database
     *
     * @param int $folderid id of folder record
     * @param string $dtable table name to search for folder details without #__
     *
     * @return   boolean
     */

function getfolder($folder, $dtable)
{
$db=& JFactory::getDBO();

$query = "
  SELECT ".$db->nameQuote('folder')."
    FROM ".$db->nameQuote('#__'.$dtable)."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($folder).";
  ";
$db->setQuery($query);
$folder = $db->loadResult();
return trim($folder);
}

/**
     * Method to clean off unwanted /'s and put right prefix as in http:// from server
     *
     * @param string $server server entry in database
     *
     * @return   boolean
     */

function cleanserver($server)
{
//remove http:// from $server
$server = str_replace('http://', '', $server);
//remove last / if present
$last = substr($server, -1);
if ($last == '/')
{$server = substr_replace($server,"",-1);}
//check to see if this is ftp, https, normal
$ftpcheck = substr($server, 0, 6);
$httpscheck = substr($server, 0, 8);
if ($ftpcheck == 'ftp://')
{$server = $server;}
elseif ($httpscheck == 'https://')
{$server = $server;}
elseif (!$server)
{$server = '';}
else
{$server = 'http://' . $server;}
return $server;
}

/**
     * Method to clean off unwanted /'s from folder path
     *
     * @param string $folder folder entry in database
     *
     * @return   boolean
     */

function cleanfolder($folder)
{
//remove last / if present from folder
$last1 = substr($folder, -1);
if ($last1 == '/')
{$folder = substr_replace($folder,"",-1);}
//remove first / if present from folder
$first = substr($folder, 0, 1);
if ($first == '/')
{$folder = substr_replace($folder,'',0, 1);}
return $folder;
}

/**
     * Method to build together parts of url
     * @param string $server server entry
     * @param string $folder folder entry
     * @@param string $file filename
     * @return   boolean
     */

function buildurl($server, $folder, $file)
{
if (!$server)
{$website = JURI::BASE();
$website = str_replace('administrator/','', $website );
$fileurl = $website.$folder. '/' . $file;}
else {$fileurl = $server . '/' . $folder . '/' . $file;}
return $fileurl;
}

}
?>