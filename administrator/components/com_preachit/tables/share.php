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
class TableShare extends JTable
{
var $id = null;
var $name = null;
var $code = null;
var $script = null;
var $published = null;
var $ordering = null;
var $cookieconsent = null;

function __construct(& $db) 
{
    parent::__construct('#__pishare', 'id', $db);
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
