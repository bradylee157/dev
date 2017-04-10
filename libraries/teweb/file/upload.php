<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DS.'libraries/teweb/file/functions.php');

class Tewebupload{

/**
     * Method to initiliase filename array
     *
     * @return    array
     */
     
function initialisfileinfo()
{
$filename->type = null;
$filename->ftphost = null;
$filename->ftpuser = null;
$filename->ftppassword = null;
$filename->ftpport = null;
$filename->aws_key = null;
$filename->aws_secret = null;
$filename->aws_bucket = null;
return $filename;
}
    
/**
	 * Method to make safe filename
	 *
	 * @param	string $file  Filename.
	 *
	 * @return	array
	 */

function makesafe($file)
{
    jimport('joomla.filesystem.file');
    //This removes any characters that might cause headaches to browsers. This also does the same thing in the model
    $badchars = array(' ', '\'', '"', '`', '@', '^', '!', '#', '$', '%', '*', '(', ')', '[', ']', '{', '}', '~', '?', '>', '<', ',', '|', '\\', ';', '&', '_and_');
    $safefile = str_replace($badchars, '_', $file);
    $safefile = JFILE::makeSafe($safefile);
    return $safefile;
}

/**
	 * Method to get temp file name from post
	 *
	 * @return	string
	 */

function gettempfile()
{
	$temp = JRequest::getVar ( 'flupfile', '', 'POST', 'STRING');
	return $temp;
}

/**
	 * Method to build temp folder
	 *
	 * @return	string
	 */

function gettempfolder()
{
	$app = JFactory::getApplication();
	$temp_folder = $app->getCfg('tmp_path').DS;
	return $temp_folder;
}

/**
	 * Method to get path variable and redirect if none
	 *
	 * @param	array $row  message details.
	 * @param	string $tempfile  Temp file path.	 
	 * @return	string
	 */

function getpath($url, $tempfile, $front = '')
{
	jimport('joomla.filesystem.file');
    $app = JFactory::getApplication();
	$path = JRequest::getVar('upload_folder', '', 'POST', 'INT');
	if ($path == '')
	{
		if ($tempfile)
		{JFile::delete($tempfile);}
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_UPLOAD_FAILED_NO_FOLDER'), 'warning' );
		$this->setRedirect($url);
	}
	return $path;
}

/**
	 * Method to delete temp file
	 *
	 * @param	string $tempfile  Temp file path.
	 *
	 * @return	bolean
	 */

function deletetempfile($tempfile)
{
	$db = & JFactory::getDBO();
	jimport('joomla.filesystem.file');
	// delete file
	JFile::delete($tempfile);
	return true;
}

/**
	 * Method to check upload file to see if it is allowed
	 *
	 * @param	array $file  File info
	 *
	 * @return	bolean
	 */

function checkfile($file, $blacklist = null, $whitelist = null)
{
	$allow = false;	
    if (!$blacklist)
	{$blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl" ,".py");}
    if (!$whitelist) {
	    foreach ($blacklist as $ext)
	    {
		    if(preg_match("/$ext\$/i", $file))
		    {$allow = false; }
            else {$allow = true;}
	    }
    }
    else  {
        foreach ($whitelist as $ext)
        {
            if(preg_match("/$ext\$/i", $file))
            {$allow = true; break;}
        }
    }
	
	return $allow;
}

/**
	 * Method to process flash uploaded file
	 *
	 * @param string $tempfile tempfile location
	 * @param	array $filename File info
	 *
	 * @return	string
	 */

function processflashfile($tempfile, $filename, $dtable = null)
{
	jimport('joomla.filesystem.file');
    $app = JFactory::getApplication();
	$uploadmsg = false;	
	if ($filename->type == 1)
	{
	    $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_UPLOAD_FAILED_NOT_UPLOAD_THIS_FOLDER'), 'warning');
        $uploadmsg = true;
	}
	elseif ($filename->type == 2)
	{
	if (!$copy = Tewebupload::ftp($tempfile, $filename, 1))
	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_NO_UPLOADED_FTP'), 'warning');
        $uploadmsg = true;}
	}
	elseif ($filename->type == 3)
	{
	if (!$copy = Tewebupload::aws($tempfile, $filename, 1, $dtable))
	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_NO_UPLOADED_AWS'), 'warning');
        $uploadmsg = true;}
	}

	else {
	if (!Tewebfile::copyfile($tempfile, $filename->path, true))
	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_NO_UPLOADED'), 'warning');
        $uploadmsg = true;}
	}
	
	return $uploadmsg;
}

/**
	 * Method to process flash uploaded file
	 *
	 * @param array $file tempfile location
	 * @param	array $filename File info
	 *
	 * @return	string
	 */

function processuploadfile($file, $filename, $dtable = null)
{
	jimport('joomla.filesystem.file');
    $app = JFactory::getApplication();
	$uploadmsg = false;	
	if ($filename->type == 1)
	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_UPLOAD_FAILED_NOT_UPLOAD_THIS_FOLDER'), 'warning');
        $uploadmsg = true;
	}
	elseif ($filename->type == 2)
	{
	$temp_folder = Tewebupload::gettempfolder();
	$tempfile = $temp_folder.$file['name'];	
	$uploadmsg = Tewebupload::uploadftp($tempfile, $file);
	if (!$uploadmsg)
		{
			if (!$copy = Tewebupload::ftp($tempfile, $filename, 1))
			{
                $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_NO_UPLOADED_FTP'), 'warning');
                $uploadmsg = true;
            }

	JFile::delete($tempfile);	
		}
	}
	elseif ($filename->type == 3)
	{
	$temp_folder = Tewebupload::gettempfolder();
	$tempfile = $temp_folder.$file['name'];	
	$uploadmsg = Tewebupload::uploadftp($tempfile, $file);
	if (!$uploadmsg)
		{
			if (!$copy = Tewebupload::aws($tempfile, $filename, 1, $dtable = null))
			{ 
                $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_FILE_NO_UPLOADED_AWS'), 'warning');
                $uploadmsg = true;
            }

		JFile::delete($tempfile);
		}	
	}
	else
	{
		$uploadmsg = Tewebupload::upload($filename, $file);
	}
	
	return $uploadmsg;
}

/**
	 * Method to upload the file
	 *
	 * @param	array $file  Source File details.
	 * @param	array $filename Destination file details.
	 *
	 * @return	string
	 */

function upload($filename, $file)
{$msg = false;
$app = JFactory::getApplication();
jimport('joomla.filesystem.file');
if (!JFILE::upload($file['tmp_name'], $filename->path))
{ $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_UPLOAD_FAILED_CHECK_PATH').' '. $filename->path .' '.JText::_('LIB_TEWEB_MESSAGE_UPLOAD_EXISTS'), 'warning');
$msg = true;}
return $msg;
}

/**
	 * Method to upload the file for ftp upload
	 *
	 * @param	array $file  Source File details.
	 * @param	array $filename Destination file details.
	 *
	 * @return	string
	 */

function uploadftp($filename, $file)
{$msg = false;
jimport('joomla.filesystem.file');
$app = JFactory::getApplication();
if (!JFILE::upload($file['tmp_name'], $filename))
{ $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_UPLOAD_FAILED_CHECK_PATH').' '. $filename->path .' '.JText::_('LIB_TEWEB_MESSAGE_UPLOAD_EXISTS'), 'warning');
$msg = true;}
return $msg;
}

/**
	 * Method to upload the file over ftp
	 *
	 * @param	array $file  Source File details.
	 * @param	array $filename Destination file details.
	 * @param	bolean $admin Sets whether call is from Joomla admin or site.
	 *
	 * @return	bolean
	 */

function ftp($file, $filename, $admin = 0)
{
$app = JFactory::getApplication();
$ftpsuccess = true;
$ftpsuccess1 = true;
$ftpsuccess2 = true;
$ftpsuccess3 = true;
$ftpsuccess4 = true;
	// FTP access parameters
$host = $filename->ftphost;
$usr = $filename->ftpuser;
$pwd = $filename->ftppassword;
$port = $filename->ftpport;
 
// file to move:
$local_file = $file;
$ftp_path = $filename->path;
// connect to FTP server (port 21)
if (!$conn_id = ftp_connect($host, $port))
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_FTP_NO_CONNECT'), 'error' );}
 $ftpsuccess1 = false;
}


// send access parameters
if (!ftp_login($conn_id, $usr, $pwd))
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_FTP_NO_LOGIN'), 'error' );}
 $ftpsuccess2 = false;
}


 
// turn on passive mode transfers (some servers need this)
// ftp_pasv ($conn_id, true);
 
// perform file upload
if (!$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_BINARY))
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_FTP_NO_UPLOAD'), 'error' );}
 $ftpsuccess3 = false;
}


 
/*
** Chmod the file (just as example)
*/
 
// If you are using PHP4 then you need to use this code:
// (because the "ftp_chmod" command is just available in PHP5+)
if (!function_exists('ftp_chmod')) {
   function ftp_chmod($ftp_stream, $mode, $filename){
        return ftp_site($ftp_stream, sprintf('CHMOD %o %s', $mode, $filename));
   }
}
 
// try to chmod the new file to 666 (writeable)
if (ftp_chmod($conn_id, 0755, $ftp_path) == false)
{
	if ($admin == 0)
 	{
    $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_FTP_NO_CHMOD'), 'error' );}
 	$ftpsuccess4 = false;
}
 
// close the FTP stream
ftp_close($conn_id);

if (!$ftpsuccess1 || !$ftpsuccess2 || !$ftpsuccess3)
{$ftpsuccess = false;}

return $ftpsuccess;
}

/**
	 * Method to upload the file over AWS
	 *
	 * @param	array $file  Source File details.
	 * @param	array $filename Destination file details.
	 * @param   string $dtable table name to look up mime
	 * @return	bolean
	 */


function aws($file, $filename, $admin = 0, $dtable)
{
$app = JFactory::getApplication();
$awssuccess = true;
$awssuccess5 = true;
$awssuccess1 = true;
$awssuccess2 = true;
$awssuccess3 = true;
$awssuccess4 = true;
$aws_key = $filename->aws_key;
$aws_secret = $filename->aws_secret;

$source_file = $file; // file to upload to S3

jimport('joomla.filesystem.file');
$ext = JFile::getExt($filename->file);
$file_type = null;
if ($ext ==  'jpg')
{$file_type = 'image/jpg';}
elseif ($ext ==  'png')
{$file_type = 'image/png';}
elseif ($ext ==  'gif')
{$file_type = 'image/gif';}
elseif  ($dtable != ''){ 
    $db=& JFactory::getDBO();    
    $query = "SELECT ".$db->quoteName('mediatype')."
        FROM ".$db->quoteName($dtable)."
        WHERE ".$db->quoteName('extension')." = ".$db->quote($ext).";
    ";
    $db->setQuery($query);
    $file_type = $db->loadResult();
}
if (!$file_type)
{$file_type = 'binary/octet-stream';}

$aws_bucket = $filename->aws_bucket; // AWS bucket 
$aws_object = $filename->file;         // AWS object name (file name)


if (strlen($aws_secret) != 40) 
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_AWS_SECRET_WRONG_LENGTH'), 'error' );}
 $awssuccess1 = false;
}
else {
$file_data = file_get_contents($source_file);
if ($file_data == false)
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_AWS_FAILED_READ_FILE'), 'error' );}
 $awssuccess2 = false;
}
else {


// opening HTTP connection to Amazon S3
$fp = fsockopen("s3.amazonaws.com", 80, $errno, $errstr, 30);
if (!$fp) {
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_AWS_NOT_OPEN_SOCKET'), 'error' );}
 $awssuccess3 = false;
}
else {


// Creating or updating bucket 

$dt = gmdate('r'); // GMT based timestamp 

// preparing String to Sign    (see AWS S3 Developer Guide)
$string2sign = "PUT


{$dt}
/{$aws_bucket}";

// preparing HTTP PUT query
$query = "PUT /{$aws_bucket} HTTP/1.1
Host: s3.amazonaws.com
Connection: keep-alive
Date: $dt
Authorization: AWS {$aws_key}:".Tewebupload::amazon_hmac($string2sign, $aws_secret)."\n\n";

$resp = Tewebupload::sendREST($fp, $query);
if (strpos($resp, '<Error>') !== false)
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_AWS_CANNOT_CREATE_BUCKET'), 'error' );}
 $awssuccess4 = false;
}
else {
// done


// Uploading object
$file_length = strlen($file_data); // for Content-Length HTTP field 

$dt = gmdate('r'); // GMT based timestamp
// preparing String to Sign    (see AWS S3 Developer Guide)
$string2sign = "PUT

{$file_type}
{$dt}
x-amz-acl:public-read
/{$aws_bucket}/{$aws_object}";

// preparing HTTP PUT query
$query = "PUT /{$aws_bucket}/{$aws_object} HTTP/1.1
Host: s3.amazonaws.com
x-amz-acl: public-read
Connection: keep-alive
Content-Type: {$file_type}
Content-Length: {$file_length}
Date: $dt
Authorization: AWS {$aws_key}:".Tewebupload::amazon_hmac($string2sign, $aws_secret)."\n\n";
$query .= $file_data;

$resp = Tewebupload::sendREST($fp, $query);
if (strpos($resp, '<Error>') !== false)
{
 if ($admin == 0)
 {
 $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGES_AWS_CANNOT_CREATE_FILE'), 'error' );}
 $awssuccess5 = false;
}

fclose($fp);
}
}
}
}

if (!$awssuccess1 || !$awssuccess2 || !$awssuccess3 || !$awssuccess4 || !$awssuccess5)
{$awssuccess = false;}

return $awssuccess;

}

// Sending HTTP query and receiving, with trivial keep-alive support
function sendREST($fp, $q, $debug = false)
{
    if ($debug) echo "\nQUERY<<{$q}>>\n";

    fwrite($fp, $q);
    $r = '';
    $check_header = true;
    while (!feof($fp)) {
        $tr = fgets($fp, 256);
        if ($debug) echo "\nRESPONSE<<{$tr}>>"; 
        $r .= $tr;

        if (($check_header)&&(strpos($r, "\r\n\r\n") !== false))
        {
            // if content-length == 0, return query result
            if (strpos($r, 'Content-Length: 0') !== false)
                return $r;
        }

        // Keep-alive responses does not return EOF
        // they end with \r\n0\r\n\r\n string
        if (substr($r, -7) == "\r\n0\r\n\r\n")
            return $r;
    }
    return $r;
}

// hmac-sha1 code START
// hmac-sha1 function:  assuming key is global $aws_secret 40 bytes long
// read more at http://en.wikipedia.org/wiki/HMAC
// warning: key($aws_secret) is padded to 64 bytes with 0x0 after first function call 
function amazon_hmac($stringToSign, $aws_secret) 
{
    // helper function binsha1 for amazon_hmac (returns binary value of sha1 hash)
    if (!function_exists('binsha1'))
    { 
        if (version_compare(phpversion(), "5.0.0", ">=")) { 
            function binsha1($d) { return sha1($d, true); }
        } else { 
            function binsha1($d) { return pack('H*', sha1($d)); }
        }
    }

    if (strlen($aws_secret) == 40)
        $aws_secret = $aws_secret.str_repeat(chr(0), 24);

    $ipad = str_repeat(chr(0x36), 64);
    $opad = str_repeat(chr(0x5c), 64);

    $hmac = binsha1(($aws_secret^$opad).binsha1(($aws_secret^$ipad).$stringToSign));
    return base64_encode($hmac);
}
// hmac-sha1 code END 

/**
     * Method to upload a file through the swf upload client
     *
     * @return    exit
     */

function flashupload()
{
//import joomla filesystem functions, we will do all the filewriting with joomlas functions,
//so if the ftp layer is on, joomla will write with that, not the apache user, which might
//not have the correct permissions
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
$abspath    = JPATH_SITE;
//this is the name of the field in the html form, filedata is the default name for swfupload
//so we will leave it as that
$fieldName = 'Filedata';
//any errors the server registered on uploading
$fileError = $_FILES[$fieldName]['error'];
if ($fileError > 0) 
{
        switch ($fileError) 
        {
        case 1:
        echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_TOO_LARGE_THAN_PHP_INI_ALLOWS' );
        return;
 
        case 2:
        echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_TO_LARGE_THAN_HTML_FORM_ALLOWS' );
        return;
 
        case 3:
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_PARTIAL_UPLOAD' );
        return;
 
        case 4:
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_NO_FILE' );
        return;
        }
}
 
//check for filesize
$fileSize = $_FILES[$fieldName]['size'];
if($fileSize > 500000000)
{
    echo JText::_( 'LIB_TEWEB_MESSAGE_FILE_BIGGER_THAN').' 500MB';
}

//check the file extension is ok
$fileName = $_FILES[$fieldName]['name'];
$extOk = Tewebfile::checkfile($fileName);
 
if ($extOk == false) 
{
        echo JText::_( 'LIB_TEWEB_MESSAGE_NOT_UPLOAD_THIS_FILE_EXT' );
        return;
}
 
//the name of the file in PHP's temp directory that we are going to move to our folder
$fileTemp = $_FILES[$fieldName]['tmp_name'];
 
//always use constants when making file paths, to avoid the possibilty of remote file inclusion
$uploadPath = Tewebupload::gettempfolder().DS.$fileName;
 
if(!JFile::upload($fileTemp, $uploadPath)) 
{
        echo JText::_( 'LIB_TEWEB_MESSAGE_ERROR_MOVING_FILE' );
        return;
}
else
{
   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
   exit(0);
}
}

	
}
?>