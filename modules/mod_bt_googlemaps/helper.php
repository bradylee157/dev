<?php
/**
 * @package 	mod_bt_googlemaps - BT Google Maps
 * @version		1.0.1
 * @created		Jun 2012

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2012 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modbt_googlemapsHelper
{	
	public static function fetchHead($params, $module){
		$document	= JFactory::getDocument();
		$mainframe = JFactory::getApplication();
		$template = $mainframe->getTemplate();
		JHTML::_('behavior.mootools');
		
		$language = JFactory::getLanguage();
		$tag = $language->getTag();
		$document->addScript('http://maps.google.com/maps/api/js?sensor=true&language='.$tag);
		
		if(file_exists(JPATH_BASE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_bt_googlemaps'.DS.'js'.DS.'default.js'))
		{
			//$document->addStyleSheet(  JURI::root().'templates/'.$template.'/html/mod_bt_googlemaps/css/style.css');
			$document->addScript(JURI::root().'templates/'.$template.'/html/mod_bt_googlemaps/js/default.js');	
		}
		else{
			//$document->addStyleSheet(JURI::root().'modules/mod_bt_googlemaps/tmpl/css/style.css');
			$document->addScript(JURI::root().'modules/mod_bt_googlemaps/tmpl/js/default.js');	
		}
		$image = trim($params->get('image','modules/mod_bt_googlemaps/tmpl/images/marker.png'));
		$shadow = trim($params->get('shadow','modules/mod_bt_googlemaps/tmpl/images/shadow.png'));
		$contentInfo = trim(str_replace(array("\n","\r"),' ',$params->get('contentInfo')));

		if($contentInfo){
			$regex = "/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/Us";
			preg_match_all($regex, $contentInfo, $matches);
			foreach ($matches[1] as $key => $match) {
				if(!substr_count($match,'http://')){
					$contentInfo = str_replace($match, JURI::base().$match, $contentInfo);
				}
			}
			$contentInfo = addslashes($contentInfo);
		}
		$script = 'window.addEvent(\'domready\', function(){';		
		$script .=  'var config = {';
		$script .=  'inputType:\''.$params->get('inputType').'\',';
		$script .=  'mapType:\''.$params->get('mapType').'\',';
		$script .=  'width:\''.$params->get('width').'\',';
		$script .=  'height:\''.$params->get('height').'\',';
		$script .=  'address:\''.addslashes($params->get('address')).'\',';
		$script .=  'latitude:'.$params->get('latitue','0').',';
		$script .=  'longitude:'.$params->get('longtitue','0').',';
		$script .=  'cavas_id:"cavas_id'.$module->id.'",';
		$script .=  'zoom:'.$params->get('zoom').',';
		$script .=  'zoomControl:'.$params->get('zoomControl','true').',';
		$script .=  'scaleControl:'.$params->get('scaleControl','true').',';
		$script .=  'panControl:'.$params->get('panControl','true').',';
		$script .=  'mapTypeControl:'.$params->get('mapTypeControl','true').',';
		$script .=  'streetViewControl:'.$params->get('streetViewControl','true').',';
		$script .=  'overviewMapControl:'.$params->get('overviewMapControl','true').',';
		$script .=  'marker:'.$params->get('marker').',';
		$script .=  'title:\''.addslashes($params->get('title')).'\',';
		$script .=  'image:\''.($image!=''? JURI::root().$image:'').'\',';
		$script .=  'shadow:\''.($shadow!=''? JURI::root().$shadow:'').'\',';
		$script .=  'contentInfo:\''.$contentInfo.'\',';
		$script .=  'showContentOnload:'.$params->get('showContentOnload','true');
		$script .=  '};';
		$script .=  'initializeMap(config);';
		$script .=  '})';
		$document->addScriptDeclaration($script);
	}
}
