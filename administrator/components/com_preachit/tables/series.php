<?php
/**
 * @Component - Preachit
 * @version 1.0.0 May, 2010
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class TableSeries extends JTable
{
var $id = null;
var $series_name = null;
var $series_alias = null;
var $image_folder = null;
var $image_folderlrg = null;
var $series_image_sm = null;
var $series_image_lrg = null;
var $series_description = null;
var $ministry = null;
var $ordering = null;
var $published = 1;
var $introvideo = null;
var $videoplayer = null;
var $videofolder = null;
var $videolink = null;
var $vwidth = null;
var $vheight = null;
var $checked_out = null;
var $checked_out_time = null;
var $user = null;
var $access = null;
var $language = null;
var $metakey = null;
var $metadesc = null;
var $part = null;
function __construct(& $db) 
{
    parent::__construct('#__piseries', 'id', $db);
}
function bind($vars, $ignore = array())
{
parent::bind($vars, $ignore);
if (!$this->id)
{
$this->ordering = $this->getNextOrder();
}
return true;
}
}
