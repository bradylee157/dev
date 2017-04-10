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
class TableTemplates extends JTable
{
var $id = null;
var $messortlists = null;
var $messagelist = null;
var $audio = null;
var $audiopopup = null;
var $video = null;
var $videopopup = null;
var $text = null;
var $seriesheader = null;
var $serieslist = null;
var $series = null;
var $seriessermons = null;
var $teacherheader = null;
var $teacherlist = null;
var $teacher = null;
var $teachersermons = null;
var $ministryheader = null;
var $ministrylist = null;
var $ministry = null; 
var $ministryseries = null;
var $medialisthead = null;
var $mediasermons = null;
var $taglist = null;
	function __construct(& $db) {
		parent::__construct('#__pitemplates', 'id', $db);
	}
}
