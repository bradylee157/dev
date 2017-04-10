<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * ALFContact Component Controller
 */
class AlfContactController extends JController
{
	function sendemail()
	{
		$app = JFactory::getApplication();
		$model = $this->getModel();
		
		// get the parameters
		$params = JComponentHelper::getParams('com_alfcontact');
		$redirect_option = $params->get('redirect_option', 1);
		$redirect_url = $params->get('custom_header', '');
		$verbose = $params->get('verbose', 1);
		$html = $params->get('htmlmail', 1);
		$site = $params->get('fromsite', 0);
		$sitename = $app->getCfg('fromname');
		$siteaddress = $app->getCfg('mailfrom');
		
		if ($html)
		{
			$sep  = "<BR>";
			$line = "<HR>";
		} 
		else 
		{
			$sep  = "\n";
			$line = "-------------------------------------------------------------------------------\n";
		}
						
				
		//Variable ophalen die verstuurd zijn via URL
        $name       = JRequest::getString('name','', 'post');
		$email      = JRequest::getString('email','', 'post');		
		$emailto_id = JRequest::getInt('emailto_id', 99);
        $subject    = JRequest::getString('subject','','post');
        $message    = JRequest::getString('message','','post');
		$copy       = JRequest::getVar('copy', '0');
		$extravalue = JRequest::getString('extravalue','','post');
		$extra2value = JRequest::getString('extra2value','','post');
    
		//Store form data in the session
     	$app->setUserState('com_alfcontact.name', $name);
		$app->setUserState('com_alfcontact.email', $email);
		$app->setUserState('com_alfcontact.emailto_id', $emailto_id);
		$app->setUserState('com_alfcontact.subject', $subject);
		$app->setUserState('com_alfcontact.message', $message);
		$app->setUserState('com_alfcontact.copy', $copy);
		$app->setUserState('com_alfcontact.extravalue', $extravalue);
		$app->setUserState('com_alfcontact.extra2value', $extra2value);
		
		//check the security measures
		if (!$model->CheckCaptcha()) 
		{
			JError::raiseWarning("0", JText::_('COM_ALFCONTACT_WRONG_CAPTCHA'));
			$this->setRedirect(JRoute::_("index.php?option=com_alfcontact&view=alfcontact", false));
			return false;
		}
		
        // field validation - we trim the input to prevent whitespace-only values
        if (!trim($name)) {
			JError::raiseWarning("0", JText::_('COM_ALFCONTACT_INVALID_NAME'));
			$this->setRedirect(JRoute::_("index.php?option=com_alfcontact&view=alfcontact", false));
			return false;
        }
        if (!preg_match('/^[a-zA-Z0-9._-]+(\\+[a-zA-Z0-9._-]+)*@([a-zA-Z0-9.-]+\\.)+[a-zA-Z0-9.-]{2,4}$/', $email)) {
			JError::raiseWarning("0", JText::_('COM_ALFCONTACT_INVALID_EMAIL'));
            $this->setRedirect(JRoute::_("index.php?option=com_alfcontact&view=alfcontact", false));
            return false;
        }
        if (!trim($subject)) {
            JError::raiseWarning("0", JText::_('COM_ALFCONTACT_INVALID_SUBJECT'));
            $this->setRedirect(JRoute::_("index.php?option=com_alfcontact&view=alfcontact", false));
            return false;
        }
        if (!trim($message)) {
			JError::raiseWarning("0", JText::_('COM_ALFCONTACT_INVALID_MESSAGE'));
            $this->setRedirect(JRoute::_("index.php?option=com_alfcontact&view=alfcontact", false));
            return false;
        }
    
		//get email address coresponding to ID number
		if ($emailto_id == '99')
		{
			$emailto = $siteaddress; 
		}
		else
		{		
			
			$db = JFactory::getDBO();
			$query = "SELECT * FROM #__alfcontact WHERE id =". (int) $emailto_id;
		
			$db->setQuery( $query );
        	$rows      = $db->loadObjectList();
			$emailto   = $rows[0]->email;
			$prefix    = $rows[0]->prefix;
			$extraname = $rows[0]->extra;
			$extra2name = $rows[0]->extra2;
		
            //Adding prefix to subject
			$subject = $prefix.' '.$subject;
		}
		
		//Split multiple email addresses into an array
		$recipients = explode("\n", $emailto);
		
		// Add information from the extra fields if applicable
		if ($extraname)
		{
			$extramsg = $extraname . ": " . $extravalue . $sep . $line;
			$message = $extramsg . $sep . $message;
		}
		
		if ($extra2name)
		{
			$extra2msg = $extra2name . ": " . $extra2value . $sep . $line;
			$message = $extra2msg . $sep . $message;
		}
		
								
		// send copy if requested
		if ($copy)
		{
			$copySubject = JText::_('COM_ALFCONTACT_COPYOFMESSAGE').' '.$sitename ;
			
			$mail = JFactory::getMailer();
			$mail->addRecipient($email);
			$mail->setSender(array($siteaddress, $sitename));
			$mail->setSubject($copySubject);
			$mail->setBody($message);
			if ($html)
			{
				$mail->IsHTML(True);
				$mail->setBody(nl2br($message));
		    }
			$sent = $mail->Send();
		}
		
		//Add an infomation banner to the top of the contacts message.
		if ($verbose)
		{
			$header = JText::_('COM_ALFCONTACT_DETAILS_HEADER') . $sep;
			$header = $header . $line;
			$header = $header . JText::_('COM_ALFCONTACT_DETAILS_NAME') . " " . $name . $sep;
			$header = $header . JText::_('COM_ALFCONTACT_DETAILS_EMAIL') . " " . $email . $sep;
			$header = $header . JText::_('COM_ALFCONTACT_DETAILS_IP') . " " . $_SERVER['REMOTE_ADDR'] . $sep;
			$header = $header . JText::_('COM_ALFCONTACT_DETAILS_BROWSER') . " " .$_SERVER['HTTP_USER_AGENT'] . $sep;
			$header = $header . $line;
			$message = $header . $message; 
		}
		
		//send mail
		$mail = JFactory::getMailer();
		
		foreach($recipients as $value)
		{
			$mail->addRecipient($value);	
		}
						
		if ($site)
		{
			$mail->setSender(array($siteaddress, $name));
		}
		else
		{
			$mail->setSender(array($email, $name));
		}
				
		$mail->setSubject($subject);
		$mail->setBody($message);
		$mail->addReplyTo(array($email, $name));
		
		if ($html) 
		{
			$mail->IsHTML(True);
			$mail->setBody(nl2br($message));
		}
				
		$sent = $mail->Send();
		
		//Clear session variables
		$app->setUserState('com_alfcontact.name', null);
		$app->setUserState('com_alfcontact.email', null);
		$app->setUserState('com_alfcontact.emailto_id', null);
		$app->setUserState('com_alfcontact.subject', null);
		$app->setUserState('com_alfcontact.message', null);
		$app->setUserState('com_alfcontact.copy', null);
		$app->setUserState('com_alfcontact.extravalue', null);
		$app->setUserState('com_alfcontact.extra2value', null);
		
		//redirect
		switch ($redirect_option) {
			case 2: $this->setRedirect(JURI::current());
					break;
			case 3: $this->setRedirect(JRoute::_('index.php?option=com_alfcontact&view=response'));
					break;
			case 4: $this->setRedirect($redirect_url);
					break;
			default:$this->setRedirect(JRoute::_(JURI::root()));
					break;
		}
	}    
}
