<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/admin.php');
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/helpers/temp.php');
jimport('teweb.admin.records');
jimport('teweb.file.functions');
jimport('joomla.application.component.controller');
class PreachitControllerTemplates extends JController
{
function cancel()
{
$option = JRequest::getCmd('option');
$app = JFactory::getApplication();	
$app->redirect('index.php?option=com_preachit&view=templatelist');
}

function save()

{
JRequest::checktoken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$app = JFactory::getApplication();	
$row = & JTable::getInstance('Template', 'Table');
$jtemp = JRequest::getVar('jtemp', array(), 'post', 'array');  
$row->load($jtemp['id']);
$row->bind($jtemp);
$params = JRequest::getVar('params', array(), 'post', 'array');
$registry = new JRegistry();
$registry->loadArray($params);
$row->params = $registry->toString();
if (!$row->store())
{JError::raiseError(500, $row->getError() );  }
//save template code if custom
if ($row->template == 'custom')
{
// get table, bind and store data
$temp =Tewebadmin::getformdetails('Templates'); 
if (!$temp->store())
{JError::raiseError(500, $temp->getError() );}
}	
if ($this->getTask() == 'apply')
{$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
$url = 'index.php?option='.$option.'&view=templateedit&template='.$row->id;}
else {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
$url = 'index.php?option='.$option.'&view=templatelist';}
$this->setRedirect($url);
}

function deftemp()

{
	
JRequest::checkToken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$db =& JFactory::getDBO();
$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
$id = $cid[0];
$query = "SELECT id FROM #__pitemplate"; 
$db->setQuery($query);
$temps = $db->loadObjectList();
    
    foreach ($temps as $temp)
    
        {
            if ($temp->id != $id)
            {$db->setQuery ("UPDATE #__pitemplate SET def = 0 WHERE id = '{$temp->id}' ;"); 
                    $db->query();}
            else
            {$db->setQuery ("UPDATE #__pitemplate SET def = 1 WHERE id = '{$temp->id}' ;"); 
                    $db->query();}
        }


$this->setRedirect('index.php?option=com_preachit&view=templatelist');	
	
}


function remove()
{
	JRequest::checktoken() or jexit( 'Invalid Token' );
	$app = JFactory::getApplication();
	$option = JRequest::getCmd('option');		
	$cid = JRequest::getVar('cid', array());
	$i = 0;
	
	// get default template to prevent it being deleted

	$db =& JFactory::getDBO();
	$query = "
  		SELECT ".$db->nameQuote('id')."
    	FROM ".$db->nameQuote('#__pitemplate')."
    	WHERE ".$db->nameQuote('def')." = ".$db->quote(1).";
  			";
		$db->setQuery($query);
	$default_template = $db->loadResult();
	
	foreach ($cid as $temp)
	
		{
			if ($temp == $default_template)	
			{
				$app->enqueueMessage ( JText::_('LIB_TEWEB_TEMPLATE_MANAGER_NOT_REMOVE_DEFAULT').': ' . $error, 'warning' );
			}
			else 
			{		
                $row = & JTable::getInstance('Template', 'Table');
                $row->load($temp);
                $title = $row->title;
                if ($row->client_id == 0)
				{$path = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$row->template;
				$delete = $this->deletetempfolder($path); }
                if (!$row->delete($temp))
                {JError::raiseError(500, $row->getError() );}
				$app->enqueueMessage ( $title.' '.JText::_('LIB_TEWEB_TEMPLATE_MANAGER_TEMP_DELETED'), 'message');
			}
		}
	
	$app->redirect('index.php?option=' . $option . '&view=templatelist');
	
}

function copy()
{
	JRequest::checktoken() or jexit( 'Invalid Token' );
    $db =& JFactory::getDBO();
	$app = JFactory::getApplication();
	$option = JRequest::getCmd('option');		
	$cid = JRequest::getVar('cid', array());
	jimport ( 'joomla.filesystem.folder' );
	$no = '';	
	
	foreach ($cid as $temp)
	
		{
            $row = & JTable::getInstance('Template', 'Table');
            $row->load($temp);
            
            $newtemp = PIHelpertemp::initialisetemp();
            $newtemp->template = $row->template;
            $newtemp->params = PIHelpertemp::tempparams(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$row->template);
            $newtemp->client_id = $row->id;
			$count = 1;
            $title = $row->title;
			while ($count > 0)
            {
                    $query='SELECT COUNT(*) FROM #__pitemplate WHERE title  = '.$db->quote($title);
                    $db->setQuery($query);
                    $count =  intval($db->loadResult());
                    if ($count > 0)
                    {
                        // get number from end of folder name if present
                    
                        $parts = explode( '_', $title);
                        $num = count($parts);
                        if (is_array($parts))
                            {$no = $parts[$num - 1];
                            if (is_numeric($no))
                                {
                                    $no = $no + 1;
                                    $parts[$num - 1] = $no;
                                    $title = implode( '_', $parts );
                                }
                            else 
                                {
                                    $title = $title.'_1';
                                    $no = 1;
                                }
                        }
                        else 
                        {
                            $title = $title.'_1';
                            $no = 1;
                        }
                    }
            }
              $newtemp->title = $title;
            if (!$newtemp->store())
            {JError::raiseError(500, $temp->getError() );}       
    }
	$app->enqueueMessage ( JText::sprintf('LIB_TEWEB_TEMPLATE_MANAGER_TEMPLATE_COPIED'), 'message');
			
	$app->redirect('index.php?option=' . $option . '&view=templatelist');
}
						

function addPITemplate()
{
	JRequest::checktoken() or jexit( 'Invalid Token' );
	JRequest::setVar('view', 'templateinstall');
	$this->display();
}

function display()
{
$view = JRequest::getVar('view');
if (!$view) 
{JRequest::setVar('view', 'templates');}	
$menu = Tewebadmin::setmenu('preachit');
parent::display();
}

function __construct($config = array())
{
parent::__construct($config);
$this->registerTask('apply', 'save');
}


//###########################################
//			START TEMPLATE MANAGER
//###########################################


	function extracttemplate()
	{
		JRequest::checktoken() or jexit( 'Invalid Token' );
		$app = JFactory::getApplication ();
		$option		= JRequest::getVar('option', '', '', 'cmd');
        $type = JRequest::getVar('installtype', 1);

		jimport ( 'joomla.filesystem.folder' );
		jimport ( 'joomla.filesystem.file' );
		jimport ( 'joomla.filesystem.archive' );
		$tmp = JPATH_ROOT . '/tmp/pitemp/';
		$dest = JPATH_ROOT . '/components/com_preachit/templates/';
		$file = JRequest::getVar ( 'install_package', NULL, 'FILES', 'array' );

		if (!$file || !is_uploaded_file ( $file ['tmp_name'])) 
			
			{
				$app->enqueueMessage ( JText::sprintf('LIB_TEWEB_A_TEMPLATE_MANAGER_INSTALL_EXTRACT_MISSING', $file ['name']), 'notice' );
			}
			
		else 
		
			{
				$success = JFile::upload($file ['tmp_name'], $tmp . $file ['name']);
				$success = JArchive::extract ( $tmp . $file ['name'], $tmp );
				
				if (! $success) 
				
				{
					$app->enqueueMessage ( JText::sprintf('LIB_TEWEB_A_TEMPLATE_MANAGER_INSTALL_EXTRACT_FAILED', $file ['name']), 'notice' );
				}
			
				// Delete the tmp install directory
				if (JFolder::exists($tmp)) 
				
					{
						$templates = JFolder::folders($tmp);
				
						if (!empty($templates)) 
						
							{
								
								foreach ($templates as $template) 
								
									{
						
												$installtype = '';
												if (file_exists($tmp.$template.'/template.xml'))
												{
												if ($rss = new SimpleXMLElement($tmp.$template.'/template.xml',null,true))
													{
														$installtype = $rss['type'];
													}	
												}									
												
												if ($installtype == 'pitemplate')
													
													{	
                                                        $newcreate = false;
                                                        if (!JFolder::exists($dest.$template))
                                                        {
                                                            $type = 1;
                                                            $newcreate = true;
                                                            if (!JFolder::create($dest.$template))
                                                            {$noerror = false;}
                                                            
                                                        }
                                                        $filepresent = true;
                                                        // replace tmp params and css if update type
                                                        // test all folders and files present
                                                        foreach ($rss->core->folder AS $folder)
                                                        {
                                                            if (!JFolder::exists ($tmp.$template.'/'.$folder))
                                                            {
                                                                $app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_FILE_NOT_FOUND').': ' . $folder, 'notice' );
                                                                $filepresent = false;
                                                            }
                                                        }
                                                        foreach ($rss->core->file AS $file)
                                                        {
                                                            if (!JFile::exists ($tmp.$template.'/'.$file))
                                                            {
                                                                $app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_FILE_NOT_FOUND').': ' . $file, 'notice' );
                                                                $filepresent = false;
                                                            }
                                                        }
                                                        
                                                        if ($type == 1)
                                                        {
                                                            foreach ($rss->style->folder AS $folder)
                                                            {
                                                                if (!JFolder::exists ($tmp.$template.'/'.$folder))
                                                                {
                                                                    $app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_FILE_NOT_FOUND').': ' . $folder, 'notice' );
                                                                    $filepresent = false;
                                                                }
                                                            }
                                                            foreach ($rss->style->file AS $file)
                                                            {
                                                                if (!JFile::exists ($tmp.$template.'/'.$file))
                                                                {
                                                                    $app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_FILE_NOT_FOUND').': ' . $file, 'notice' );
                                                                    $filepresent = false;
                                                                }
                                                            }
                                                        }
                                                        
                                                        if (!$filepresent)
                                                        {
                                                            if ($newcreate == true)
                                                            {JFolder::delete($dest.$template);}
                                                            $app->redirect( JURI::base () . 'index.php?option='.$option.'&view=templateinstall');
                                                        }
                                                        
                                                        // having checked files present now copy the relevent files
                                                        
                                                        $noerror = true;
                                                        
                                                        foreach ($rss->core->folder AS $folder)
                                                        {
                                                            if (JFolder::exists ($dest.$template.'/'.$folder))
                                                            {
                                                                JFolder::delete($dest.$template.'/'.$folder);
                                                            }
                                                            if (!JFolder::copy($tmp.$template.'/'.$folder, $dest.$template.'/'.$folder))
                                                            {$noerror = false;}
                                                        }
                                                        foreach ($rss->core->file AS $file)
                                                        {
                                                            if (JFile::exists ($dest.$template.'/'.$file))
                                                            {
                                                                JFile::delete($dest.$template.'/'.$file);
                                                            }
                                                            if (!JFile::copy($tmp.$template.'/'.$file, $dest.$template.'/'.$file))
                                                            {$noerror = false;}
                                                        }
                                                        
                                                        if ($type == 1)
                                                        {
                                                            foreach ($rss->style->folder AS $folder)
                                                            {
                                                                if (JFolder::exists ($dest.$template.'/'.$folder))
                                                                {
                                                                    JFolder::delete($dest.$template.'/'.$folder);
                                                                }
                                                                if (!JFolder::copy($tmp.$template.'/'.$folder, $dest.$template.'/'.$folder))
                                                                {$noerror = false;}
                                                            }
                                                            foreach ($rss->style->file AS $file)
                                                            {
                                                                if (JFile::exists ($dest.$template.'/'.$file))
                                                                {
                                                                    JFile::delete($dest.$template.'/'.$file);
                                                                }
                                                                if (!JFile::copy($tmp.$template.'/'.$file, $dest.$template.'/'.$file))
                                                                {$noerror = false;}
                                                            }
                                                        }
                                                            
                                                        
                                
                                                        if ($noerror !== true) 
                                                            
                                                            {
                                                                $app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_COPY_FAILED').': ' . $error, 'notice' );
                                                            }
                                                            
                                                        else 
                                                        
                                                            {
                                                                $record = PIHelpertemp::createtemprecord($dest.$template, $template);
                                                                $app->enqueueMessage ( JText::sprintf('LIB_TEWEB_A_TEMPLATE_MANAGER_INSTALL_EXTRACT_SUCCESS', $file ['name']) );
                                                            }
							
													}
													
												else 
												
													{
														$app->enqueueMessage ( JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE').' ' . JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_NO_XML'), 'notice' );
													}
																		
									}						
						
								$retval = JFolder::delete($tmp);	
							} 
						
						else 
						
							{
								JError::raiseWarning(100, JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE_MISSING_FILE'));
								$retval = false;
							}
					} 
					
				else 
				
					{
						JError::raiseWarning(100, JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_TEMPLATE').' '.JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_UNINSTALL').': '.JText::_('LIB_TEWEB_A_TEMPLATE_MANAGER_DIR_NOT_EXIST'));
						$retval = false;
					}
			}
			
		$app->redirect( JURI::base () . 'index.php?option='.$option.'&view=templatelist');
	}
	
	
function deletetempfolder($path)

{
        // Sanity check
        if (!$path) 
        
        	{
                // Bad programmer! Bad Bad programmer!
                JError::raiseWarning(500, 'JFolder::delete: ' . JText::_('LIB_TEWEB_TEMPLATE_MANAGER_ATTEMPT_BASE_DIR') );
                return false;
        	}
 
        // Initialize variables
        jimport('joomla.client.helper');
        $ftpOptions = JClientHelper::getCredentials('ftp');
 
        // Check to make sure the path valid and clean
        $path = JPath::clean($path);
 
        // Is this really a folder?
        if (!is_dir($path)) 
        
        	{
                JError::raiseWarning(21, 'JFolder::delete: ' . JText::_('LIB_TEWEB_TEMPLATE_MANAGER_PATH_NOT_FOLDER'), 'Path: ' . $path);
                return false;
        	}
 
        // Remove all the files in folder if they exist
        $files = JFolder::files($path, '.', false, true, array());
        if (!empty($files)) 
        
        		{
                jimport('joomla.filesystem.file');
                if (JFile::delete($files) !== true) 
                
                		{
                        // JFile::delete throws an error
                        return false;
              			}
        		}
 
        // Remove sub-folders of folder
        $folders = JFolder::folders($path, '.', false, true, array());
        foreach ($folders as $folder) 
        
        	{
                if (is_link($folder)) 
                	
                	{
                        // Don't descend into linked directories, just delete the link.
                        jimport('joomla.filesystem.file');
                        
                        if (JFile::delete($folder) !== true) 
                        
                        	{
                                // JFile::delete throws an error
                                return false;
                        	}
                	} 
                	
                elseif (JFolder::delete($folder) !== true) 
                	
                	{
                        // JFolder::delete throws an error
                        return false;
                	}
        }
 
        if ($ftpOptions['enabled'] == 1) 
        
        		{
                // Connect the FTP client
                jimport('joomla.client.ftp');
                $ftp = &JFTP::getInstance(
                        $ftpOptions['host'], $ftpOptions['port'], null,
                        $ftpOptions['user'], $ftpOptions['pass']
                );
        		}
 
        // In case of restricted permissions we zap it one way or the other
        // as long as the owner is either the webserver or the ftp
        if (@rmdir($path)) 
        
        		{
                $ret = true;
        		} 
        
        elseif ($ftpOptions['enabled'] == 1) 
        
        		{
                // Translate path and delete
                $path = JPath::clean(str_replace(JPATH_ROOT, $ftpOptions['root'], $path), '/');
                // FTP connector throws an error
                $ret = $ftp->delete($path);
        		} 
        		
        else 
        
        		{
                JError::raiseWarning(
                        'SOME_ERROR_CODE',
                        'JFolder::delete: ' . JText::_('LIB_TEWEB_TEMPLATE_MANAGER_NO_DELETE_FOLDER'),
                        'Path: ' . $path
                );
                $ret = false;
        		}
        		
        return $ret;
}
}
