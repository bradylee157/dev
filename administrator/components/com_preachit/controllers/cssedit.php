<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.admin.records');
jimport('joomla.application.component.controller');
class PreachitControllerCssedit extends JController
{
function add()
{
JRequest::setVar('view', 'cssedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function edit()
{
JRequest::setVar('view', 'cssedit');
JRequest::setVar('hidemainmenu', 1);
$this->display();
}

function cancel()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$option = JRequest::getCmd('option');
$app = JFactory::getApplication();	
$temp = JRequest::getVar('temp', '', 'post', 'string');
$mod = JRequest::getVar('mod', '', 'post', 'string');
$plug = JRequest::getVar('plug', '', 'post', 'string');
$override = JRequest::getVar('override', '', 'post', 'int');

if ($temp || $override)

	{
		$app->redirect('index.php?option=' . $option . '&view=templatelist');
	}
	
	
if ($mod || $plug)

	{
		$app->redirect('index.php?option=' . $option . '&view=extensionlist');
    }
}

function save()
{
JRequest::checktoken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();    
$option = JRequest::getCmd('option');
$temp = JRequest::getVar('temp', '', 'post', 'string');
$cssfile = JRequest::getVar('cssfile', '');
$mod = JRequest::getVar('mod', '', 'post', 'string');
$plug = JRequest::getVar('plug', '', 'post', 'string');
$override = JRequest::getVar('override', '', 'post', 'int');

$save = true;

if ($temp)

	{
		$file= JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$temp.DIRECTORY_SEPARATOR. 'css' .DIRECTORY_SEPARATOR. $cssfile.'.css';
	}

elseif ($mod)

	{
		$file = JPATH_ROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$mod.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR. 'modstyle.css';
	}

elseif ($plug)

	{
		$file = JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$plug.'.css';
	}
$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

if (!$filecontent && !$override) 

	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_OPERATION_FAILED_CSS'), 'warning' );
		$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&id=' . $id);
	}

if ($override && $override > 0)
{
    $row = & JTable::getInstance('Template', 'Table');
    $row->load($override);
    $row->cssoverride = $filecontent;
    if (!$row->store())
    {JError::raiseError(500, $temp->getError() );}
    $save = false;
    $return = true;
}

if ($save)
{
// Set FTP credentials, if given
		jimport('joomla.client.helper');
		jimport('joomla.filesystem.file');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');
		$client =& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
	
	// Try to make the template file writeable
	
$return = JFILE::write($file, $filecontent);

}

if ($return)
	{
		if ($this->getTask() == 'apply')
			{
	            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_CHANGES_APPLIED'), 'message' );
				if ($temp)	
				
					{
						$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&template='.$temp.'&file='.$cssfile );
					}
					
				if ($mod)

					{
						$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&module='.$mod);
					}
					
				if ($plug)
				
					{
						$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&plugin='.$plug);
					}
                if ($override)
                
                    {
                        $this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&override='.$override);
                    }
			}
		else
			{
			    $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_DETAILS_SAVED'), 'message' );
				if ($temp || $override)	
					
					{
						$this->setRedirect('index.php?option='.$option.'&view=templatelist');
					}
					
				if ($mod || $plug)
	
					{
						$this->setRedirect('index.php?option='.$option.'&view=extensionlist');
					}			
			
		}
	}
else 

	{
        $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_OPERATION_FAILED').': '.JText::sprintf('LIB_TEWEB_MESSAGE_FAILED_OPEN', $file), 'warning' );
		if ($temp)	
		
			{

				$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&template='.$temp.'&file='.$cssfile);
			
			}
		if ($mod)

			{
				$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&module='.$mod);
			}
			
		if ($plug)
		
			{
				$this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&plugin='.$plug);
			}
        if ($override)
                
                    {
                        $this->setRedirect('index.php?option='.$option.'&controller=cssedit&task=edit&override='.$override);
                    }
			
	}	
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
}
