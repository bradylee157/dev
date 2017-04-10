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

class PreachitModelStudyedit extends JModelForm
{

        public function getForm($data = array(), $loadData = true) 
        {
        			jimport('joomla.form.form');
        			$abspath    = JPATH_SITE;
					$models_path = $abspath.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'models';
 
                JForm::addFormPath ($models_path . DS . 'forms');
                JForm::addFieldPath($models_path . DS . 'fields');
 
                $form = JForm::getInstance('com_preachit.studyedit', 'studyedit', array('control' => 'jform', 'load_data' => $loadData));
                return $form;
        }
        
   
	public function &getData() 
        {
        				// get auto data
        				
        				$db = JFactory::getDBO();
        				
                                $query = $db->getQuery(true);
                                // Select all fields from the hello table.
                                $query->select('*');
                                $query->from('`#__pibckadmin`');
                                $query->where('id = 1');
                                $db->setQuery((string)$query);
                                $auto = & $db->loadAssoc();
                                
                                
        				$cid= & JRequest::getVar('cid', 0, '', 'array');
        				$id = (int)$cid[0];
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
                                $query->from('`#__pistudies`');
                                $query->where('id = ' . (int)$selected[0]);
                                $db->setQuery((string)$query);
                                $data = & $db->loadAssoc();
                                if (isset($data['teacher']))
                                {$data['teacher'] = explode(',', $data['teacher']);}
                                if (isset($data['ministry']))
                                {$data['ministry'] = explode(',', $data['ministry']);}
                        }
						
						if ($id == 0)						
						{
							if (isset($auto['series']))
							{$data['series'] = $auto['series'];}
							if (isset($auto['ministry']))
                            {$data['ministry'] = explode(',', $auto['ministry']);}
							if (isset($auto['video']))
							{$data['video'] = $auto['video'];}
							if (isset($auto['audio_type']))
							{$data['audio_type'] = $auto['audio_type'];}
							if (isset($auto['video_type']))
							{$data['video_type'] = $auto['video_type'];}
							if (isset($auto['video_download']))
							{$data['video_download'] = $auto['video_download'];}
							if (isset($auto['audio']))
							{$data['audio'] = $auto['audio'];}
							if (isset($auto['audio_download']))
							{$data['audio_download'] = $auto['audio_download'];}
							if (isset($auto['comments']))
							{$data['comments'] = $auto['comments'];}
							if (isset($auto['text']))
							{$data['text'] = $auto['text'];}
							if (isset($auto['studylist']))
							{$data['studylist'] = $auto['studylist'];}
							if (isset($auto['teacher']))
							{$data['teacher'] = explode(',', $auto['teacher']);}
							if (isset($auto['audio_folder']))
							{$data['audio_folder'] = $auto['audio_folder'];}
							if (isset($auto['video_folder']))
							{$data['video_folder'] = $auto['video_folder'];}
							if (isset($auto['add_downloadvid']))
							{$data['add_downloadvid'] = $auto['add_downloadvid'];}
							if (isset($auto['notes']))
							{$data['notes'] = $auto['notes'];}
							if (isset($auto['notes_folder']))
							{$data['notes_folder'] = $auto['notes_folder'];}
                            if (isset($auto['slides']))
                            {$data['slides'] = $auto['slides'];}
                            if (isset($auto['slides_folder']))
                            {$data['slides_folder'] = $auto['slides_folder'];}
                            if (isset($auto['slides_type']))
                            {$data['slides_type'] = $auto['slides_type'];}
							if (isset($auto['image_folder']))
							{$data['image_folder'] = $auto['image_folder'];}
							if (isset($auto['downloadvid_folder']))
							{$data['downloadvid_folder'] = $auto['downloadvid_folder'];}
							if (isset($auto['access']))
							{$data['access'] = $auto['access'];}
							if (isset($auto['audpurchase']))
							{$data['audpurchase'] = $auto['audpurchase'];}
							if (isset($auto['audpurchase_folder']))
							{$data['audpurchase_folder'] = $auto['audpurchase_folder'];}
							if (isset($auto['vidpurchase']))
							{$data['vidpurchase'] = $auto['vidpurchase'];}
							if (isset($auto['vidpurchase_folder']))
							{$data['vidpurchase_folder'] = $auto['vidpurchase_folder'];}
                            if (isset($auto['image_foldermed']))
                            {$data['image_foldermed'] = $auto['image_foldermed'];}
                            if (isset($auto['image_folderlrg']))
                            {$data['image_folderlrg'] = $auto['image_folderlrg'];}
                            if (isset($auto['language']))
                            {$data['language'] = $auto['language'];}        
						}
						
						if (isset($data['publish_down']))
							{
							if ($data['publish_down'] == '0000-00-00 00:00:00')
                        {$data['publish_down'] = 'Never';}		
                       }
                       else {$data['publish_down'] = 'Never';}		
                       if (isset($data['podpublish_down']))
                            {
                            if ($data['podpublish_down'] == '0000-00-00 00:00:00')
                        {$data['podpublish_down'] = 'Never';}        
                       }
                       else {$data['podpublish_down'] = 'Never';}    
                        							
								 $this->data = $data;						
			    
                }
                return $this->data;
        }
}