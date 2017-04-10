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
class PreachitModelTemplateedit extends JModel
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
	$temp = JRequest::getVar('template', 0);
    if ($temp > 0)
    {
        $db = & JFactory::getDBO();
         // check if it needs to be default or not
         $query = "
                  SELECT ".$db->nameQuote('params')."
                FROM ".$db->nameQuote('#__pitemplate')."
                WHERE ".$db->nameQuote('id')." = ".$db->quote($temp).";
                  ";
                $db->setQuery($query);
                $this->_data = $db->loadResult();
    }
	else {
		JError::raiseError(404, 'The params file you requested is not available.' );
}

		return $this->_data;
	}
	
public function getparamform($data = array(), $loadData = true) 

        {
        			jimport('joomla.form.form');
        			$temp = JRequest::getVar('template', 0);
                    
                    $db = & JFactory::getDBO();
                    // check if it needs to be default or not
                    $query = "
                  SELECT ".$db->nameQuote('template')."
                  FROM ".$db->nameQuote('#__pitemplate')."
                  WHERE ".$db->nameQuote('id')." = ".$db->quote($temp).";
                    ";
                    $db->setQuery($query);
                    $tempfolder = $db->loadResult();
        			
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates';
 			
                JForm::addFormPath ($models_path . DS . $tempfolder);
 
                $form = JForm::getInstance('com_preachit.templateparams', 'template16', array('control' => 'params', 'load_data' => $loadData));
                return $form;
        }
	
        public function getForm($data = array(), $loadData = true) 
        {
        			jimport('joomla.form.form');
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'models';
 
                JForm::addFormPath ($models_path . DS . 'forms');
                JForm::addFieldPath($models_path . DS . 'fields');
 
                $form = JForm::getInstance('com_preachit.templateedit', 'templates', array('control' => 'jform', 'load_data' => $loadData));
                return $form;
        }
        
        public function getTitleform($data = array(), $loadData = true) 
        {
        			jimport('joomla.form.form');
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'models';
 
                JForm::addFormPath ($models_path . DS . 'forms');
                JForm::addFieldPath($models_path . DS . 'fields');
 
                $form = JForm::getInstance('com_preachit.templatetitle', 'templatetitle', array('control' => 'jtemp', 'load_data' => $loadData));
                return $form;
        }
        
   
	public function &getCustdata() 
        {
        		
                if (empty($this->Custdata)) 
                {
                        $app = & JFactory::getApplication();
                        $data = & JRequest::getVar('jform');
                        if (empty($data)) 
                        {      
                        			$selected = 1; 
                                $db = JFactory::getDBO();
                                $query = $db->getQuery(true);
                                $query->select('*');
                                $query->from('`#__pitemplates`');
                                $query->where('id = ' . $selected);
                                $db->setQuery((string)$query);
                                $data = & $db->loadAssoc();
                        }
								 $this->custdata = $data;						
                }
                return $this->custdata;
        }
        
     public function &getTitledata() 
        {
        		
                if (empty($this->Titledata)) 
                {
                        $app = & JFactory::getApplication();
                        $data = & JRequest::getVar('jtemp');
                        if (empty($data)) 
                        {      
                        	$temp = JRequest::getVar('template', 0);
                            $row = & JTable::getInstance('Template', 'Table');
                            $row->load($temp);
                            $data['title'] = $row->title;
                            $data['id'] = $temp;
                            if ($row->client_id == 0)
                            {
                                $data['template'] = $row->template;
                            }
                            else {
                                   $db = & JFactory::getDBO();
                                   // check if it needs to be default or not
                                   $query = "
                                   SELECT ".$db->nameQuote('template')."
                                   FROM ".$db->nameQuote('#__pitemplate')."
                                   WHERE ".$db->nameQuote('id')." = ".$db->quote($row->client_id).";
                                   ";
                                   $db->setQuery($query);
                                   $data['template'] = $db->loadResult();
                            }
                        }
								 $this->titledata = $data;						
                }
                return $this->titledata;
        }
}