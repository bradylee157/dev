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
class TableTeachers extends JTable
{
var $id = null;
var $teacher_name = null;
var $lastname = null;
var $teacher_alias = null;
var $teacher_role = null;
var $image_folder = null;
var $image_folderlrg = null;
var $teacher_image_sm = null;
var $teacher_image_lrg = null;
var $teacher_email = null;
var $teacher_website = null;
var $teacher_description = null;
var $published = 1;
var $ordering = null;
var $teacher_view = 1;
var $checked_out = null;
var $checked_out_time = null;
var $user = null;
var $language = null;
var $metakey = null;
var $metadesc = null;
	function __construct(& $db) {
		parent::__construct('#__piteachers', 'id', $db);
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
