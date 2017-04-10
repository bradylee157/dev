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
class TableMime extends JTable
{
var $id = null;
var $extension = null;
var $mediatype = null;
var $published = null;
	function __construct(& $db) {
		parent::__construct('#__pimime', 'id', $db);
	}
}
