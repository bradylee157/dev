<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class TableBooks extends JTable
{
var $id = null;
var $book_name = null;
var $display_name = null;
var $shortform = null;
var $published = null;
	function __construct(& $db) {
		parent::__construct('#__pibooks', 'id', $db);
	}
}
