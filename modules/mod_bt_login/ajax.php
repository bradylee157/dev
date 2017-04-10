<?php
/**
 * @package 	mod_bt_login - BT Login Module
 * @version		2.3
 * @created		April 2012
 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */
	if (!defined ('_JEXEC')) {

		define( '_JEXEC', 1 );
		
		$path = dirname(dirname(dirname(__FILE__)));
		
		define('JPATH_BASE', $path );

		define( 'DS', DIRECTORY_SEPARATOR );
		
		require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
		
		require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
		
		$mainframe =& JFactory::getApplication('site');

		$db = & JFactory::getDBO();
		
		jimport ('joomla.plugin.helper');
		jimport('cms.captcha.captcha');
		
		// Initialise variables.
		$app	= JFactory::getApplication();
		//load language file
		$language =& JFactory::getLanguage();
		$language_tag = $language->getTag(); // loads the current language-tag

		JFactory::getLanguage()->load('plg_captcha_recaptcha',JPATH_ADMINISTRATOR,$language_tag,true);
		JFactory::getLanguage()->load('mod_bt_login',JPATH_SITE,$language_tag,true);
		JFactory::getLanguage()->load('lib_joomla',JPATH_SITE,$language_tag,true);
		JFactory::getLanguage()->load('com_users',JPATH_SITE,$language_tag,true);
	
	/**
	 * 
	 * function register()
	 * @param array() $temp
	 */	
	function register($temp)
	{
		$config = JFactory::getConfig();
		$db		= JFactory::getDbo();
		$params = JComponentHelper::getParams('com_users');
		
		// Initialise the table with JUser.
		$user = new JUser;
		
		// Merge in the registration data.
		foreach ($temp as $k => $v) {
			$data[$k] = $v;
		}

		// Prepare the data for the user object.
		$data['email']		= $data['email1'];
		$data['password']	= $data['password1'];
		$useractivation = $params->get ( 'useractivation' );
		
		// Check if the user needs to activate their account.
		if (($useractivation == 1) || ($useractivation == 2)) {
			$data ['activation'] = JApplication::getHash ( JUserHelper::genRandomPassword () );
			$data ['block'] = 1;
		}
		$system	= $params->get('new_usertype', 2);
		$data['groups'] = array($system);
		
		// Bind the data.
		if (! $user->bind ( $data )) {
			echo '$error$'.JText::sprintf ( 'COM_USERS_REGISTRATION_BIND_FAILED', $user->getError () );
			die ();
		}
		
		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Store the data.
		if (!$user->save()) {
			echo '$error$'.JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError());
			die();
		}

		// Compile the notification mail values.
		$data = $user->getProperties();
		$data['fromname']	= $config->get('fromname');
		$data['mailfrom']	= $config->get('mailfrom');
		$data['sitename']	= $config->get('sitename');
		$data['siteurl']	= str_replace('modules/mod_bt_login/','',JURI::root());
		
		// Handle account activation/confirmation emails.
		if ($useractivation == 2)
		{
			// Set the link to confirm the user email.					
			$data['activate'] = $data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'];
			
			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);
			
		}
		elseif ($useractivation == 1)
		{
			// Set the link to activate the user account.						
			$data['activate'] = $data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'];
		
			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);
			

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);

		} else {

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl']
			);
		}

		// Send the registration email.
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);
		
		//Send Notification mail to administrators
		if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1)) {
			$emailSubject = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_BODY',
				$data['name'],
				$data['sitename']
			);

			$emailBodyAdmin = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY',
				$data['name'],
				$data['username'],
				$data['siteurl']
			);

			// get all admin users
			$query = 'SELECT name, email, sendEmail' .
					' FROM #__users' .
					' WHERE sendEmail=1';

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			// Send mail to all superadministrators id
			foreach( $rows as $row )
			{
				$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

				// Check for an error.
				if ($return !== true) {
					echo(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
					return false;
				}
			}
		}
		// Check for an error.
		if ($return !== true) {
			echo (JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));

			// Send a system message to administrators receiving system mails
			$db = JFactory::getDBO();
			$q = "SELECT id
				FROM #__users
				WHERE block = 0
				AND sendEmail = 1";
			$db->setQuery($q);
			$sendEmail = $db->loadColumn();
			if (count($sendEmail) > 0) {
				$jdate = new JDate();
				// Build the query to add the messages
				$q = "INSERT INTO ".$db->quoteName('#__messages')." (".$db->quoteName('user_id_from').
				", ".$db->quoteName('user_id_to').", ".$db->quoteName('date_time').
				", ".$db->quoteName('subject').", ".$db->quoteName('message').") VALUES ";
				$messages = array();

				foreach ($sendEmail as $userid) {
					$messages[] = "(".$userid.", ".$userid.", '".$jdate->toSql()."', '".JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')."', '".JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])."')";
				}
				$q .= implode(',', $messages);
				$db->setQuery($q);
				$db->query();
			}
			return false;
		}
	
		
		if ($useractivation == 1)
			return "useractivate";
		elseif ($useractivation == 2)
			return "adminactivate";
		else
			return $user->id;
	}		

	// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$isRegister = JRequest::getVar('task');
		
		/**
		 * check task is login to do
		 */
		if($isRegister=='login'){
				global $mainframe;
		
				if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
					$return = base64_decode($return);
					if (!JURI::isInternal($return)) {
						$return = '';
					}
				}		
				$options = array();
				
				$options['remember'] = JRequest::getBool('remember', false);
				
				$options['return'] = $return;
		
				$credentials = array();
				
				$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
				
				$credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);
				
				//preform the login action
				$error = $mainframe->login($credentials, $options);
				
				echo $error;
				
				die();
	}elseif(($isRegister=='registration')) {
		/**
		 * check task is registration to do
		 */
		// If registration is disabled - Redirect to login page.
		if(JComponentHelper::getParams('com_users')->get('allowUserRegistration') == 0){
			
			// set message in here : Registration is disable
			echo ("Registration is not allow!");
			die;
		}
	
		//check captcha 
		$enabledRecaptcha=JRequest::getVar('recaptcha');
		if($enabledRecaptcha=='yes'){
				$captcha = JCaptcha::getInstance('recaptcha');		
				//$captcha->initialise('6Lf7Js8SAAAAAJBSx3JdwDKN0F1kVTF47Uz_DEli ');
				$checkCaptcha = $captcha->checkAnswer(JRequest::getVar('recaptcha_response_field'));
				if($checkCaptcha==false){
					echo('$error$'.JText::_('PLG_RECAPTCHA_ERROR_INCORRECT_CAPTCHA_SOL'));
					die();
				}
		}
	
		// Get the user data.
		// reset params form name in getVar function (not yet)
		$requestData ['name']= JRequest::getVar('name');
		$requestData ['username']= JRequest::getVar('username');
		$requestData ['password1']= JRequest::getVar('passwd1');
		$requestData ['password2']= JRequest::getVar('passwd2');
		$requestData ['email1']= JRequest::getVar('email1');
		$requestData ['email2']= JRequest::getVar('email2');

		// Save the data in the session.
		// may be use
		//$app->setUserState('com_users.registration.data', $requestData);
		
			
		// Attempt to save the data.
		$return	=register($requestData);	
		if ($return === 'adminactivate'){
			echo (JText::_('COM_USERS_REGISTRATION_COMPLETE_VERIFY'));
			die();
		} elseif ($return === 'useractivate') {
			echo (JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
			die();			
		} else {
			echo (JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
			die();			
		}
	}
}
?>