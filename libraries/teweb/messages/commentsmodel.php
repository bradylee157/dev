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
jimport('joomla.event.dispatcher');

class Modelcomment extends JModelForm
{
	
	
        public function getForm($data = array(), $loadData = true) 
        {
        			jimport('joomla.form.form');
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DS.'libraries'.DS.'teweb'.DS.'messages';
 
                JForm::addFormPath ($models_path . DS . 'forms');
                JForm::addFieldPath($models_path . DS . 'fields');
 
                $form = JForm::getInstance('teweb.comments', 'comments', array('control' => 'jform', 'load_data' => $loadData));
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
                                
                        }
								 $this->data = $data;						
                }
                return $this->data;
        }
}