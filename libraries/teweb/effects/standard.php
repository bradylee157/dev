<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebeffects {

/**
	 * Method to put span around first part of title
	 * @param $title title string
	 * @return	string
	 */

function titlespans($title)
{
$titlearray = explode( ' ', $title);
if (count($titlearray) < 2)
{return $title;}
$i = 1;
$full = '';
foreach ($titlearray as $word)
{
    if ($i == 1)
    {
        $seg = '<span>'.$word.'</span>';
    }
    else {$seg = $word;}
    $i = 0;
    $full = $full.' '. $seg;
}
$title = $full;
return $title;
}

/**
     * Method to run the content plugins on an element
     * @param string $event plugin event to run
     * @param string $context context being run
     * @param string $text element to run content plugins on
     * @param unknown_type $params component params
     * @return    string
     */

function runcontentplugins($event, $context, $text, $params)
{
    $row->text = $text;
    $limitstart = 0;
    $dispatcher    =& JDispatcher::getInstance();
    JPluginHelper::importPlugin('content');
    $results = $dispatcher->trigger('onContentPrepare', array ($context, & $row, & $params, $limitstart));
    return $row->text;
}

/**
     * Method to shorten text to specified length and add ... if too long
     * @param string $text text to shorten
     * @param int $length length to shorten to
     * @return    string
     */

function shortentext($text, $length)
{
    if (strlen($text) > $length - 1)
    {$end = '...';} else {$end = '';}
    return substr($text, 0, $length - 1).$end;
}


}
?>