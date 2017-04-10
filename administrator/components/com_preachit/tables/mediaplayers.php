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
class TableMediaplayers extends JTable
{
var $id = null;
var $playername = null;
var $playertype = null;
var $playercode = null;
var $playerscript = null;
var $published = null;
var $html5 = null;
var $facebook = null;
var $image = null;
var $palyerurl = null;
var $runplugins = null;
	function __construct(& $db) {
		parent::__construct('#__pimediaplayers', 'id', $db);
	}
}
