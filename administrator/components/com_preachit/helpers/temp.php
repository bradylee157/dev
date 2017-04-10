<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

class PIHelpertemp
{
    
/**
     * Method to create template record
     * @param string $path folder path for the temple
     * @param string $folder template folder to create for
     * return boolean
    */ 
    function createtemprecord($path, $folder)
    {
        $temp = PIHelpertemp::initialisetemp();
        $temp->template = $folder;
        // get name
        $temp->title = PIHelpertemp::tempname($path);
        // get id
        $temp->id = PIHelpertemp::tempid($folder);
        // get params
        if ($temp->id >! 0 || $temp->id == null)
        {$temp->params = PIHelpertemp::tempparams($path); }
        else {unset($temp->params);}
        // check if needs to be default
        $temp->def = PIHelpertemp::checkdefault($temp->id); 
         if (!$temp->store())
         {JError::raiseError(500, $temp->getError() );}  
          return true;
    }
    
/**
     * Method to initialise temp record
     * return array
    */ 
    function initialisetemp()
    {
        $temp = & JTable::getInstance('Template', 'Table');
          $temp->id = 0;
          $temp->client_id = 0;
          $temp->template = '';
          $temp->title = '';
          $temp->cssoverride = '';
          $temp->params = '';
          $temp->def = 0;
          return $temp;
    }

/**
     * Method to get temp name
     * @param string $path folder path for template
     * return array
    */ 
    function tempname($path)
    {
        $name = '';
        if (file_exists($path.'/template.xml'))
        {          
            if ($rss = new SimpleXMLElement($path.'/template.xml',null,true))
            {         
                $name = strval($rss->name);
            }    
        }
        return $name;
    }

/**
     * Method to get temp params
     * @param string $path folder path for template
     * return array
    */ 
    function tempparams($path)
    {
        $params = '';
        if (file_exists($path.'/params.ini'))
        {
            $paramsfile=fopen($path.'/params.ini',"rb");
            $piparams = fread($paramsfile,filesize($path.'/params.ini'));
            fclose($paramsfile); 
            $params = $piparams;
        }   
        return $params;
    }

/**
     * Method to get temp id if already installed
     * @param string $folder folder for template
     * return array
    */ 
    function tempid($folder)
    {
        $db = & JFactory::getDBO();
        $query = "
                  SELECT ".$db->nameQuote('id')."
                FROM ".$db->nameQuote('#__pitemplate')."
                WHERE ".$db->nameQuote('template')." = ".$db->quote($folder)." AND ".$db->nameQuote('client_id')." = ".$db->quote(0).";
                  ";
                $db->setQuery($query);
                $id = $db->loadResult();  
        return $id;
    }

/**
     * Method to return default value if not already set
     * @param int $tempid idif not new
     * return array
    */ 
    function checkdefault($tempid)
    {
        $db = & JFactory::getDBO();
        $default = 0;
         // check if it needs to be default or not
         $query = "
                  SELECT ".$db->nameQuote('id')."
                FROM ".$db->nameQuote('#__pitemplate')."
                WHERE ".$db->nameQuote('def')." = ".$db->quote(1).";
                  ";
                $db->setQuery($query);
                $id = $db->loadResult();
         if ($id >! 0 || $id == null || $id == $tempid)
         {
             $default = 1;
         }  
        return $default;
    }
    
/**
     * Method to return array of css files
     * @param string $folder
     * return array
    */ 
    function getcssfiles($folder)
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        $files = JFolder::files($folder);
        $cssfiles = array();
        $i = 0;
        foreach ($files AS $file)
        {
               if (JFile::getExt($file) == 'css')
               {
                   $cssfiles[$i] = JFile::stripExt($file);
                   $i++;
               }
        }
        
        // put preachit.css at the top of the list
        $key = array_search('preachit', $cssfiles);
        $temp = array($key => $cssfiles[$key]);
        unset($cssfiles[$key]);
        $cssfiles = $temp + $cssfiles;
        
        return $cssfiles;
    }
    
/**
     * Method to turn files into string
     * @param string $temp
     * @param array $files
     * return string
    */ 
    function getcssstring($temp, $files)
    {
        $link = JFilterOutput::ampReplace( 'index.php?option=com_preachit&controller=cssedit&task=edit&template='. $temp.'&file={{file}}' );
        $css = '<ul class="tempcsslinks">';
        foreach ($files AS $file)
        {
             $csslink = str_replace('{{file}}', $file, $link);
             $css .= '<li><a title="['. JText::_('COM_PREACHIT_TEMPLATE_CSS_EDIT').']" href="'.$csslink.'">'.$file.'.css</a></li>';
        }
        $css .= '</ul>';
        return $css;
    }
/**
     * Method to turn files into string
     * @param int $id
     * return string
    */ 
    function getcssorlink($id)
    {
        $link = JFilterOutput::ampReplace( 'index.php?option=com_preachit&controller=cssedit&task=edit&override='.$id );
        $css = '<ul class="tempcsslinks">';
        $css .= '<li><a title="['. JText::_('COM_PREACHIT_TEMPLATE_CSS_EDIT').']" href="'.$link.'">'. JText::_('COM_PREACHIT_TEMPLATE_CSS_OVERRIDE').'</a></li>';
        $css .= '</ul>';
        return $css;
    }
    
    
	
}