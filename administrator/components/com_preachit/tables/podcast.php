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
class TablePodcast extends JTable
{
var $id = null;
var $published = 1;
var $name = null;
var $records = 10;
var $description = null;
var $image = null;
var $imagehgt = null;
var $imagewth = null;
var $author = null;
var $search = null;
var $filename = null;
var $menu_item = null;
var $language = null;
var $editor = null;
var $email = null;
var $ordering = null;
var $podpub = null;
var $itunestitle = null;
var $itunessub = null;
var $itunesdesc = null;
var $series = null;
var $series_list = null;
var $ministry = null;
var $ministry_list = null;
var $teacher = null;
var $teacher_list = null;
var $media = null;
var $media_list = null;
var $languagesel = null;
	function __construct(& $db) {
		parent::__construct('#__pipodcast', 'id', $db);
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
