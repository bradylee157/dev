<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PreachitViewVideothird extends JView
{
function display($tpl = null)
{

$row =& $this->get('data');
$this->assignRef('row', $row);
	
parent::display($tpl);
}
}