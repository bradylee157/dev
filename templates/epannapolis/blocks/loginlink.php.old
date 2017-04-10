<?php
/**
 * ------------------------------------------------------------------------
 * JA T3 System plugin for Joomla 1.7
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */
defined('_JEXEC') or die('Restricted access');
/**
 *http://docs.joomla.org/JFactory/getUser
 */
$user =& JFactory::getUser();  
echo '<?xml version="1.0" encoding="utf-8"?'.'>'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
	xml:lang="<?php echo $this->language; ?>" 
	lang="<?php echo $this->language; ?>" 
	dir="<?php echo $this->direction; ?>" >

	<div id='loginLink'>
		<!-- a class="loginLink" href="/index.php/login" -->
<?php
 		if ($user->guest) {
 			echo '<a class="loginLink" href="http://www.epannapolis.org/index.php/login">Login</a>';
 		} else {
 			$name = $user->get('username'); 
 			echo "Logged in as " . $user->name . ",&nbsp;&nbsp;";
 			//JRoute::_('index.php?option=com_users&task=user.logout&'. JUtility::getToken() .'=1')
 			//echo '<a class="loginLink" href="/index.php?option=com_user&view=login&task=logout">';
 			echo '<a class="loginLink" href="'.JRoute::_('index.php?option=com_users&task=user.logout&'. JUtility::getToken().'=1&return='.base64_encode(JURI::current())).'">';
 			echo 'Logout';
 			echo '</a>';
 		}
?>
 		<!-- /a -->
	</div>

<? /**
    *php endif; 
    */
?>