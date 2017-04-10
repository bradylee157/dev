<?php
/**
 * @package 	mod_bt_login - BT Login Module
 * @version		2.4.0
 * @created		April 2012

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modbt_loginHelper
{
	function loadModule($name,$title){
		$module=JModuleHelper::getModule($name,$title);
		return JModuleHelper::renderModule($module);
	}
	function loadModuleById($id){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
			$query->select('module,title' );
			$query->from('#__modules');
			$query->where('#__modules.id='.$id);
			$db->setQuery((string)$query);
			$module = $db->loadObject();
			
			$module = JModuleHelper::getModule( $module->module,$module->title );
			
			
			$contents = JModuleHelper::renderModule ( $module);
			return $contents;
	}
	static function getReturnURL($params, $type)
	{
		$app	= JFactory::getApplication();
		$router = $app->getRouter();
		$url = null;
		if ($itemid =  $params->get($type))
		{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select($db->quoteName('link'));
			$query->from($db->quoteName('#__menu'));
			$query->where($db->quoteName('published') . '=1');
			$query->where($db->quoteName('id') . '=' . $db->quote($itemid));

			$db->setQuery($query);
			if ($link = $db->loadResult()) {
				if ($router->getMode() == JROUTER_MODE_SEF) {
					$url = 'index.php?Itemid='.$itemid;
				}
				else {
					$url = $link.'&Itemid='.$itemid;
				}
			}
		}
		if (!$url)
		{
			// stay on the same page
			$uri = clone JFactory::getURI();
			$vars = $router->parse($uri);
			unset($vars['lang']);
			if ($router->getMode() == JROUTER_MODE_SEF)
			{
				if (isset($vars['Itemid']))
				{
					$itemid = $vars['Itemid'];
					$menu = $app->getMenu();
					$item = $menu->getItem($itemid);
					unset($vars['Itemid']);
					if (isset($item) && $vars == $item->query) {
						$url = 'index.php?Itemid='.$itemid;
					}
					else {
						$url = 'index.php?'.JURI::buildQuery($vars).'&Itemid='.$itemid;
					}
				}
				else
				{
					$url = 'index.php?'.JURI::buildQuery($vars);
				}
			}
			else
			{
				$url = 'index.php?'.JURI::buildQuery($vars);
			}
		}

		return base64_encode($url);
	}

	function getType()
	{
		$user = & JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}
	
	function getModules($params) {
		$user = & JFactory::getUser();
		if ($user->get('guest')) return '';
		
		$document = JFactory::getDocument();
		$moduleRender = $document->loadRenderer('module');
		$positionRender = $document->loadRenderer('modules');
		
		$html = '';
		
		$db = JFactory::getDbo();
		$i=0;
		$module_id = $params->get('module_id', array());
		if (count($module_id) > 0) {
			$sql = "SELECT * FROM #__modules WHERE id IN (".implode(',', $module_id).") ORDER BY ordering";
			$db->setQuery($sql);
			$modules = $db->loadObjectList();
			foreach ($modules as $module) {
				
				if ($module->module != 'mod_bt_login') {
					$i++;
					$html = $html . $moduleRender->render($module->module, array('title' => $module->title, 'style' => 'rounded'));
					//$html = $html .$moduleRender->render($module->module, array('title' => $module->title, 'style' => 'rounded'));
					//if($i%2==0) $html.="<br clear='both'>";
				}
			}
		}	
		$module_position = $params->get('module_position', array());
		if (count($module_position) > 0) {
			foreach ($module_position as $position) {
				$modules = JModuleHelper::getModules($position);
				foreach ($modules as $module) {
					if ($module->module != 'mod_bt_login') {
						$i++;
						$html = $html . $moduleRender->render($module, array('style' => 'rounded'));
						//if($i%2==0) $html.="<br clear='both'>";
					}
				}
			}
		}
		if ($html==''){
			$html= $moduleRender->render('mod_menu',array('title'=>'User Menu','style'=>'rounded'));
		}
		return $html;
	}
	function fetchHead($params){
		$document	= &JFactory::getDocument();
		$header = $document->getHeadData();
		if($params->get('loadCSS',"1")) {
			$document->addStyleSheet(JURI::root().'modules/mod_bt_login/assets/css/style2.0.css');
		}

		$loadJquery = true;
		switch($params->get('loadJquery',"auto")){
			case "0":
				$loadJquery = false;
				break;
			case "1":
				$loadJquery = true;
				break;
			case "auto":
				
				foreach($header['scripts'] as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'jquery'))
					{
						$loadJquery = false;
						break;
					}
				}
			break;		
		}
		//Add js
		if($loadJquery)
		{ 
			$document->addScript(JURI::root().'modules/mod_bt_login/assets/js/jquery.min.js');
		}
		$document->addScript(JURI::root().'modules/mod_bt_login/assets/js/jquery.simplemodal.js');
		$document->addScript(JURI::root().'modules/mod_bt_login/assets/js/default.js');	

	}
}
