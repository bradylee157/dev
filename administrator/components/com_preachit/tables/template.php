<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class TableTemplate extends JTable
{
var $id = null;
var $client_id = null;
var $template = null;
var $params = null;
var $cssoverride = null;
var $title = null;
var $def = null;
	function __construct(& $db) {
		parent::__construct('#__pitemplate', 'id', $db);
	}
}
