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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');
class PreachitModelCssedit extends JModel
{
var $_data = null;
var $_pagination = null;
var $_total = null;
var $_search = null;
var $_query = null;

function __construct()
  {
        parent::__construct();
 
        $app = JFactory::getApplication();
	}


function getData() 
  {
	$temp = JRequest::getVar('template', '');
    $cssfile = JRequest::getVar('file', '');
	$mod = JRequest::getVar('module', '');
	$plug = JRequest::getVar('plugin', '');
    $override = JRequest::getVar('override', '');

	if ($temp && $cssfile)
	{
	$filename = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp.DIRECTORY_SEPARATOR. 'css' .DIRECTORY_SEPARATOR. $cssfile.'.css';
	}
	elseif ($mod)
	{
		$filename = JPATH_ROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$mod.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR. 'modstyle.css';
	}
	elseif ($plug)
	{
		$filename = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$plug.'.css';
	}
    elseif ($override)
    {
        $db = & JFactory::getDBO();
        // check if it needs to be default or not
        $query = "
        SELECT ".$db->nameQuote('cssoverride')."
        FROM ".$db->nameQuote('#__pitemplate')."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($override).";
        ";
        $db->setQuery($query);
        $this->_data->filecontent = $db->loadResult();
        return $this->_data;
    }
	else {$filename = '';}
	if ($filename)
	{

	$csscontents=fopen($filename,"rb");
		$this->_data->filecontent = fread($csscontents,filesize($filename));
		fclose($csscontents);}
		
	else {
		JError::raiseError(404, 'The css file you requested is not available.' );
}

		return $this->_data;
	}
}