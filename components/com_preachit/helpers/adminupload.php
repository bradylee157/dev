<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');
jimport('teweb.file.upload');

class PIHelperadminupload{

/**
	 * Method to build filepath
	 *
	 * @param	array $file  File details.
	 * @param	int $path The path id.
	 * @param	bolean $flash	Sets whether this is a flash upload or normal php upload and chooses right path through function.
	 *
	 * @return	array
	 */

function buildpath($file, $type, $media, $id, $path, $flash = 0)
{
$pifilepath=& JTable::getInstance('Filepath', 'Table');

$pifilepath->load($path);

$folder = $pifilepath->folder;
$filename = Tewebupload::initialisfileinfo();
$filename->type = $pifilepath->type;
$filename->ftphost = $pifilepath->ftphost;
$filename->ftpuser = $pifilepath->ftpuser;
$filename->ftppassword = $pifilepath->ftppassword;
$filename->ftpport = $pifilepath->ftpport;
$filename->aws_key = $pifilepath->aws_key;
$filename->aws_secret = $pifilepath->aws_secret;
$filename->aws_bucket = $pifilepath->folder;

//sanitise folder

//remove last / if present from folder

$last1 = substr($folder, -1);
if ($last1 == '/')
{$folder = substr_replace($folder,"",-1);}

//remove first / if present from folder

$first = substr($folder, 0, 1);
if ($first == '/')
{$folder = substr_replace($folder,'',0, 1);}

$pre = PIHelperadmin::buildprefix($type, $media, $id);

//This removes any characters that might cause headaches to browsers. This also does the same thing in the model
			$badchars = array(' ', '\'', '"', '`', '@', '^', '!', '#', '$', '%', '*', '(', ')', '[', ']', '{', '}', '~', '?', '>', '<', ',', '|', '\\', ';', '&', '_and_');
			
if ($flash == 0)
{
    $filename->file = Tewebupload::makesafe($file['name']);
}
if ($flash == 1)
{
    $filename->file = Tewebupload::makesafe($file);
}
if ($filename->type == 2)
{$filename->path = $folder . '/' . $filename->file;}
else {
$filename->path = JPATH_SITE . DS . $folder . DS . $filename->file;}

return $filename;
}

/**
	 * Method to build prefix for file naming convention
	 *
	 * @param	int $type Type of record
	 * @param   int $media Type of media
	 * @param   int $id  $id for the record
	 *
	 * @return	bolean
	 */

function buildprefix($type, $media, $id)
{
$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
if ($type == 1)
{
// build prefix to prevent overwriting file
if ($media == 1 && $admin->prefixm == 1)
{$pre = 'pa'.$id.'_';}
elseif ($media == 2 && $admin->prefixm == 1)
{$pre = 'pv'.$id.'_';}
elseif ($media == 3 && $admin->prefixm == 1)
{$pre = 'pn'.$id.'_';}
elseif ($media == 4 && $admin->prefixi == 1)
{$pre = 'pims'.$id.'_';}
elseif ($media == 5 && $admin->prefixi == 1)
{$pre = 'pimm'.$id.'_';}
elseif ($media == 6 && $admin->prefixi == 1)
{$pre = 'piml'.$id.'_';}
elseif ($media == 7 && $admin->prefixm == 1)
{$pre = 'pid'.$id.'_';}
elseif ($media == 8 && $admin->prefixm == 1)
{$pre = 'pisl'.$id.'_';}
else {$pre = '';}
}
elseif ($type == 2)
{
if ($media == 1 && $admin->prefixi == 1)
{$pre = 'ptis'.$id.'_';}
elseif ($media == 2 && $admin->prefixi == 1)
{$pre = 'ptil'.$id.'_';}
else {$pre = '';}
}
elseif ($type == 3)
{
if ($media == 1 && $admin->prefixi == 1)
{$pre = 'psis'.$id.'_';}
elseif ($media == 2 && $admin->prefixi == 1)
{$pre = 'psil'.$id.'_';}
elseif ($media == 3 && $admin->prefixm == 1)
{$pre = 'psv'.$id.'_';}
else {$pre = '';}
}

elseif ($type == 4)
{
if ($media == 1 && $admin->prefixi == 1)
{$pre = 'pmnis'.$id.'_';}
elseif ($media == 2 && $admin->prefixi == 1)
{$pre = 'pmnil'.$id.'_';}
else {$pre = '';}
}

return $pre;
}

}
?>