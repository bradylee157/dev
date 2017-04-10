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
class TableMinistry extends JTable
{
var $id = null;
var $ministry_name = null;
var $ministry_alias = null;
var $image_folder = null;
var $image_folderlrg = null;
var $ministry_image_sm = null;
var $ministry_image_lrg = null;
var $ministry_description = null;
var $ordering = null;
var $published = 1;
var $access = null;
var $language = null;
var $metakey = null;
var $metadesc = null;
	function __construct(& $db) {
		parent::__construct('#__piministry', 'id', $db);
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
