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
class PreachitModelExtensionlist extends JModel
{
var $_data = null;
var $_pagination = null;
var $_total = null;
var $_search = null;
var $_query = null;
  
function getmodules() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_modules)) 
		{
			//get template folders
			
			jimport('joomla.filesystem.file');
			jimport('joomla.filesystem.folder');
			$abspath    = JPATH_SITE;
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
			$modBaseDir = JPATH_SITE.DIRECTORY_SEPARATOR.'modules'.DS;
			$plugBaseDir = JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DS;
			$root = JURI::BASE();
			$root = str_replace("/administrator/",'', $root );	
			$modpath = $root.'/modules/';
			$plugpath = $root.'/plugins/';
			
			//build module and plugin list			
			
			$rows = array();
			$mods = array();
			$plugs = array();
			$mods[0]='mod_preachit';
			$mods[1]='mod_piteachers';
			$mods[2]='mod_piseries';
			$mods[3]='mod_piadmin';
			$mods[4]='mod_pisidebar';
            $mods[5]='mod_pitags';
            $mods[6]='mod_pilatmes';
            $mods[7]='mod_pimediaplayer';
			$plugs[0]->filename = 'content_plugin';
            $plugs[0]->alias = 'plg_content_plugin';
            $plugs[1]->filename = '';
            $plugs[1]->alias = 'plg_search_plugin';
            $plugs[2]->filename = '';
            $plugs[2]->alias = 'plg_editor_button';
            $plugs[3]->filename = '';
            $plugs[3]->alias = 'plg_finder_preachit';
            $plugs[4]->filename = '';
            $plugs[4]->alias = 'plg_system_pipodupdater';
                        
            $plugs[1]->path='search/preachit/preachit';
            $plugs[0]->path='content/preachit/preachit';
            $plugs[2]->path='editors-xtd/preachit/preachit';
            $plugs[3]->path='finder/preachit/preachit';
            $plugs[4]->path='system/pipodupdater/pipodupdater';
			
			// get update info			

			$i = 0;
			
        			
        			foreach ($mods as $mod)
					{		
							// test modules installed
							
							$file = $modBaseDir.$mod.'/'.$mod.'.xml'; 
							$cssfile = $modBaseDir.$mod.'/assets/modstyle.css';

							//get info from module xml file
							if (Tewebfile::checkfile($file, true))
							{ 
							if ($rss = new SimpleXMLElement($file,null,true))
							{

							$authorUrl = $rss->authorUrl;
							$authorUrl = str_replace('http://','', $authorUrl );	
							$authorUrl = 'http://'.$authorUrl;		
							
							$rows[$i]->name = $rss->name;
							$rows[$i]->date = $rss->creationDate;
							$rows[$i]->author = $rss->author;
							$rows[$i]->version = $rss->version;
							$rows[$i]->authorUrl = $authorUrl;
						   $rows[$i]->dir = $mod;
						   if (file_exists($cssfile))
						   {
						   $rows[$i]->link = 'index.php?option=com_preachit&controller=cssedit&task=edit&module='.$mod;}
						   else {$rows[$i]->link = '';}
						   $latestversion = '';
						   $rows[$i]->upgrade = '';
						   $i++;
						  }
						  
						  }
        			}
        			
        			foreach ($plugs as $plug)
					{		
							// test modules installed
							
							$file = $plugBaseDir.$plug->path.'.php';
							$cssfile = $client->path.DIRECTORY_SEPARATOR.'components/com_preachit/assets/css/'.$plug->filename.'.css';
							
							//get info from module xml file
							
							$xml = $plugBaseDir.$plug->path.'.xml';
							if (Tewebfile::checkfile($xml, true))
							{
							if ($rss = new SimpleXMLElement($xml,null,true))
							{
							
							$authorUrl = $rss->authorUrl;
							$authorUrl = str_replace('http://','', $authorUrl );	
							$authorUrl = 'http://'.$authorUrl;		
							
							$rows[$i]->name = $rss->name;
							$rows[$i]->date = $rss->creationDate;
							$rows[$i]->author = $rss->author;
							$rows[$i]->version = $rss->version;
							$rows[$i]->authorUrl = $authorUrl;
						   $rows[$i]->dir = $plug->filename;
						   $rows[$i]->link = '';
						   $latestversion = '';
						   $rows[$i]->upgrade = '';
						   $i++;
						  }
						  }
						  
        			}
        			
			$this->_modules = $rows;
			
		}        			
        			
        return $this->_modules;
  }
}