<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class TableTequeue extends JTable
{
var $id = null;
var $sender = null;
var $sendername = null;
var $subject = null;
var $text = null;
var $emails = null;
	function __construct(& $db) {
		parent::__construct('#__tequeue', 'id', $db);
	}
}
