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
require_once($abspath.DS.'libraries/teweb/media/imageresize.php');

class Tewebmedia {

/**
     * Method to resize image
     *
     * @param int $width new width of image
     * @param int $height new height of image
     * @param int $file new filename of image
     * @param int $quality new quality of image
     *
     * @return   boolean
     */
    
function imageresize ($width, $height, $file, $quality)
{
    // *** 1) Initialise / load image
    $resizeObj = new  Tewebimgresize($file);

    // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
    $resizeObj -> resizeImage($width, $height, 'crop', $file);

    // *** 3) Save image
    $resizeObj -> saveImage($file, $quality);
    
    return true;
}

/**
     * Method to check if image needs resizing
     *
     * @param int $width width to check against
     * @param int $height height to check against
     * @param int $file image to check
     *
     * @return   boolean
     */

function checksize($width, $height, $image)
{
    if (!file_exists($image))   
    {
        $imagesize = getimagesize($image);
        if ($imagesize[0] == $width && $imagesize[1] == $height)
        {return true;}
    }
    return false;
}

/**
     * Method to get id3 info from a mp3 file
     *
     * @param    array or string $ufile
     * @param    bolean $type whether $ufile is php file array or filepath
     *
     * @return    array
     */    

function getid3($ufile, $type)
{
    $ext = '';
    $filename = '';
    
    if ($type == 1)
    {
        $pathinfo = pathinfo($ufile);
        $ext = $pathinfo['extension'];
        $filename = $ufile;
    }    
    if ($type == 2)
    {
        jimport('joomla.filesystem.file');
        $ext = JFile::getExt($ufile['name']);
        $filename = $ufile['tmp_name'];
    }
    
    $data = Tewebmedia::parseid3($ext, $filename);
    
    return $data;
}

/**
     * Method to initialise id3 array
     *
     *
     * @return    array
     */  
function initialiseid3()
{
    $data["song"] = '';
    $data["artist"] = '';
    $data["album"] = '';
    $data["year"] = '';
    $data["comment"] = '';
    $data["hrs"] = '';
    $data["mins"] = '';
    $data["secs"] = '';
    $data["track"] = '';
    return $data;
}

/**
     * Method to parse id3 tags
     * @param string $ext file extension
     * @param string $file absolute path and name of file
     * @return    array
     */  
function parseid3($ext, $file)
{
    $data = Tewebmedia::initialiseid3();
    
    $extensions = array('mp3', 'aac', 'm4v', 'm4a', 'mp4', 'ogg', 'flv', 'mpg');

    if (in_array(strval($ext), $extensions))
    {
        jimport('teweb.media.getid3.getid3'); 
        $instance = new getid3();
        $info = $instance->analyze($file);
        getid3_lib::CopyTagsToComments($info);

        if (isset($info['comments_html']['title'][0]))
         {$data["song"] = $info['comments_html']['title'][0];}
        if (isset($info['comments_html']['artist'][0]))
         {$data["artist"] = $info['comments_html']['artist'][0];}
        if (isset($info['comments_html']['album'][0]))
         {$data["album"] = $info['comments_html']['album'][0];}
        if (isset($info['comments_html']['creation_date'][0]))
         {$data["year"] = $info['comments_html']['creation_date'][0];}
        if (isset($info['comments_html']['comment'][0]))
         {$data["comment"] = $info['comments_html']['comment'][0];}
        if (isset($info['comments_html']['track'][0]))
         {$data["track"] = $info['comments_html']['track'][0];}
         
         // get duration of song

         if (isset($info['playtime_string']))
         {
                 $duration = Tewebmedia::timepassed($info['playtime_string']);
                 $data["hrs"] = $duration->hrs;
                 $data["mins"] = $duration->mins;
                 $data["secs"] = $duration->secs;
         }
    }

    
    return $data;
}

/**
     * Method to get duration from seconds into hrs, mins, secs
     *
     * @param    int $seconds  Time in seconds
     *
     * @return    array
     */

function timePassed($timestring)
{
$dur = explode(':',$timestring);
if (count($dur) == 1)
{$seconds = $dur[0];}
elseif (count($dur) == 2)  
{$seconds = ($dur[0] * 60) + $dur[1];}
elseif (count($dur) == 3)  
{$seconds = ($dur[0] * 3600) + ($dur[1] * 60) + $dur[2];}
    
$duration->hrs = 0;
$duration->mins = 0;
$duration->secs = 0;
// get the number of complete hours
if($seconds > 3600)
{$h = floor($seconds / 3600);
$seconds -= $h * 3600;
$duration->hrs = $h;}
// get the number of complete minutes
if($seconds > 60)
{$m = floor($seconds / 60);
$seconds -= $m * 60;
$duration->mins = $m;}
// get the number of complete seconds
$duration->secs = round($seconds);

return $duration;
}

/**
     * Method to get info from Vimeo api
     *
     * @param    string $url  Vimeo video url
     *
     * @return    array
     */

function vimeoinfo($url)
{

$info = '';    

//get number for video

$url = str_replace('http://', '', $url);
$urlarray = explode('/', $url);
$no = count($urlarray);
$code = $urlarray[$no - 1];

// get xml info from vimeo

$api_endpoint = 'http://vimeo.com/api/v2/video/';
$xml = $api_endpoint . $code.'.xml';
$videos = simplexml_load_file($xml);
$rss = $videos->video;

$info->name = $rss->title;
$info->description = $rss->description;
$info->imagesm = $rss->thumbnail_small;
$info->imagemed = $rss->thumbnail_medium;
$info->imagelrg = $rss->thumbnail_large;
$info->link = $code;
$info->imfolder = '';
$info->tags = $rss->tags;

// build alias

jimport( 'joomla.filter.output' );

$info->alias = $info->name;
$info->alias = JFilterOutput::stringURLSafe($info->alias);


// get duration

$duration = Tewebmedia::timePassed($rss->duration);
$info->hrs = $duration->hrs;
$info->mins = $duration->mins;
$info->secs = $duration->secs;

//select video type

$info->type = 2;

return $info;
}

/**
     * Method to get info from Youtube api
     *
     * @param    string $url  Youtube video url
     *
     * @return    array
     */

function youtubeinfo($url)
{
$info = '';        

//get number for video

$url = str_replace('http://', '', $url);
$watch = 'watch';
$user = 'user';
if (strlen(strstr($url,$user))>0)
{
    $urlarray = explode('/', $url);
    $no = count($urlarray);
    $code = $urlarray[$no - 1];
}
if (strlen(strstr($url,$watch))>0)
{
    $url = str_replace('www.youtube.com/watch?v=', '', $url);
    $urlarray = explode('&', $url);
    $code = $urlarray[0];
}

// get xml info from youtube

$api_endpoint = 'http://gdata.youtube.com/feeds/api/videos/';
$xml = $api_endpoint . $code;
$videos = simplexml_load_file($xml);

// parse video entry
$video = Tewebmedia::parseVideoEntry($videos);

$info->name = $videos->title;
$info->description = $videos->content;
$info->imagesm = $video->smthumbnailURL;
$info->imagemed = '';
$info->imagelrg = $video->thumbnailURL;
$info->link = $code;
$info->imfolder = '';
$info->tags = null;

// build alias

jimport( 'joomla.filter.output' );

$info->alias = $info->name;
$info->alias = JFilterOutput::stringURLSafe($info->alias);

// get duration
$duration = Tewebmedia::timePassed($video->length);
$info->hrs = $duration->hrs;
$info->mins = $duration->mins;
$info->secs = $duration->secs;

//select video type

$info->type = 3;

return $info;
}

/**
     * Method to parse Youtube xml from api
     *
     * @param    string $entry  Content of xml
     *
     * @return    array
     */

function parseVideoEntry($entry) 

{      
      $obj= new stdClass;
      
      // get nodes in media: namespace for media information
      $media = $entry->children('http://search.yahoo.com/mrss/');
      $obj->title = $media->group->title;
      $obj->description = $media->group->description;
      
      // get video player URL
      $attrs = $media->group->player->attributes();
      $obj->watchURL = $attrs['url']; 
      
      // get video thumbnail
      $attrs = $media->group->thumbnail[0]->attributes();
      $obj->thumbnailURL = $attrs['url']; 
      
      // get smallvideo thumbnail
      $attrs = $media->group->thumbnail[1]->attributes();
      $obj->smthumbnailURL = $attrs['url']; 
            
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $obj->length = $attrs['seconds']; 
      
      // get <yt:stats> node for viewer statistics
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->statistics->attributes();
      $obj->viewCount = $attrs['viewCount']; 
      
      // get <gd:rating> node for video ratings
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->rating) { 
        $attrs = $gd->rating->attributes();
        $obj->rating = $attrs['average']; 
      } else {
        $obj->rating = 0;         
      }
        
      // get <gd:comments> node for video comments
      $gd = $entry->children('http://schemas.google.com/g/2005');
      if ($gd->comments->feedLink) { 
        $attrs = $gd->comments->feedLink->attributes();
        $obj->commentsURL = $attrs['href']; 
        $obj->commentsCount = $attrs['countHint']; 
      }
      
      // get feed URL for video responses
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
      2007#video.responses']"); 
      if (count($nodeset) > 0) {
        $obj->responsesURL = $nodeset[0]['href'];      
      }
         
      // get feed URL for related videos
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
      2007#video.related']"); 
      if (count($nodeset) > 0) {
        $obj->relatedURL = $nodeset[0]['href'];      
      }
    
      // return object to caller  
      return $obj;      
} 

/**
     * Method to get info from Blip.tv api
     *
     * @param    string $url  Blip.tv video url
     *
     * @return    array
     */ 


function bliptvinfo($url)
{
$info = '';    

$xml = $url.'?skin=rss';    
$videos = simplexml_load_file($xml);

$rows = $videos->xpath('channel/item');
$embed = 'blip:embedLookup';
$thumblrg = 'media:thumbnail';
$runtime = 'blip:runtime';
foreach($rows as $row)
{
$info->name = $row->title;
$description = $row->puredescription;
$description = str_replace('<![CDATA[', '', $description);
$description = str_replace(']]>', '', $description);
$info->description = $description;
$info->tags = null;
$blip = $row->children("http://blip.tv/dtd/blip/1.0");
$media = $row->children("http://search.yahoo.com/mrss/");
$info->imagesm = $blip->smallThumbnail;
$info->imagemed = '';
$info->imagelrg = $media->thumblrg;
$info->link = 'http://blip.tv/play/'.$blip->embedLookup;
$info->imfolder = '';

// build alias

jimport( 'joomla.filter.output' );

$info->alias = $info->name;
$info->alias = JFilterOutput::stringURLSafe($info->alias);


// get duration

$duration = Tewebmedia::timePassed($blip->runtime);
$info->hrs = $duration->hrs;
$info->mins = $duration->mins;
$info->secs = $duration->secs;

//select video type

$info->type = 4;
}

return $info;
}


}
?>