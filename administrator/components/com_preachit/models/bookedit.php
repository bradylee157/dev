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
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

class PreachitModelBookedit extends JModelForm
{
	
	
        public function getForm($data = array(), $loadData = true) 
        {
        			jimport('joomla.form.form');
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'models';
 
                JForm::addFormPath ($models_path . DS . 'forms');
                JForm::addFieldPath($models_path . DS . 'fields');
 
                $form = JForm::getInstance('com_preachit.bookedit', 'bookedit', array('control' => 'jform', 'load_data' => $loadData));
                return $form;
        }
        
   
	public function &getData() 
        {
        			
                if (empty($this->data)) 
                {
                        $app = & JFactory::getApplication();
                        $data = & JRequest::getVar('jform');
                        if (empty($data)) 
                        {
                                $selected = & JRequest::getVar('cid', 0, '', 'array');      
                                $db = JFactory::getDBO();
                                $query = $db->getQuery(true);
                                // Select all fields from the hello table.
                                $query->select('*');
                                $query->from('`#__pibooks`');
                                $query->where('id = ' . (int)$selected[0]);
                                $db->setQuery((string)$query);
                                $data = & $db->loadAssoc();
                        }
								 $this->data = $data;						
                }
                return $this->data;
        }
}