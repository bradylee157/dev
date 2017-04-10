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
jimport('teweb.file.functions');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/temp.php');
class PreachitModelTemplatelist extends JModel
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
        $option = JRequest::getCmd('option');
 
        // Get pagination request variables
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
       $limitstart = $app->getUserStateFromRequest( $option.'&view=templatelist.limitstart', 'limitstart', 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
    
 function _buildQuery()
    {
        $query = "SELECT * FROM #__pitemplate ORDER BY title" 
            ;
        return $query;
    }


 function getData() 
  {
        jimport('joomla.filesystem.folder');
        jimport( 'joomla.utilities.simplexml' );
        $client    =& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
        $templateBaseDir = $client->path.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates';
        $templateDirs = JFolder::folders($templateBaseDir);
        $rows = array();        $i = 0;
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) 
        {
            $query = $this->_buildQuery();
            $temps = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
            
            foreach ($temps AS $temp)
            {    
                            $rows[$i]->name = $temp->title;
                            $rows[$i]->template = $temp->template;
                            $rows[$i]->def = $temp->def;
                            $rows[$i]->id = $temp->id;
                            $rows[$i]->css = null;
                            $rows[$i]->client_id = $temp->client_id;
                            $csstest = $templateBaseDir.DIRECTORY_SEPARATOR.$temp->template.'/css';    
                            $xmltest = $templateBaseDir.DIRECTORY_SEPARATOR.$temp->template.'/template.xml';                    
                            $xml = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp->template.DIRECTORY_SEPARATOR. 'template.xml';
                            if (Tewebfile::checkfile($xml))
                            { 
                            if ($rss = new SimpleXMLElement($xml,null,true))
                            {
                            $authorUrl = $rss->authorUrl;
                            $authorUrl = str_replace('http://','', $authorUrl );    
                            $authorUrl = 'http://'.$authorUrl;                            
                            $rows[$i]->date = $rss->creationDate;
                            $rows[$i]->author = '<a href="'.$authorUrl.'">'.$rss->author.'</a>';
                            $rows[$i]->version = $rss->version;
                           }
                           }
                           else {
                            $rows[$i]->date = '';
                            $rows[$i]->author = '';
                            $rows[$i]->version = '';
                           }
                           if (JFolder::exists($csstest) && $temp->client_id == 0)
                           {
                               $cssfiles = PIHelpertemp::getcssfiles($csstest);
                               $rows[$i]->css = PIHelpertemp::getcssstring($temp->template, $cssfiles);}
                           else {$rows[$i]->css = PIHelpertemp::getcssorlink($temp->id);}
                           $i++;
            }
            $this->_data = $rows;
        }
        
        return $this->_data;
  }


function getTotal()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  }

  function getPagination()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  }
}