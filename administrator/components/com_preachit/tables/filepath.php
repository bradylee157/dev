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
class Tablefilepath extends JTable
{
var $id = null;
var $name = null;
var $server = null;
var $folder = null;
var $description = null;
var $published = 1;
var $type = null;
var $ftphost = null;
var $ftpuser = null;
var $ftppassword = null;
var $ftpport = null;
var $aws_key = null;
var $aws_secret = null;
	function __construct(& $db) {
		parent::__construct('#__pifilepath', 'id', $db);
	}
}
