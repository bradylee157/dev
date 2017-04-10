<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access.
defined('_JEXEC') or die;

	class GlobalsUniteHCar{
		
		const EXTENSION_NAME = "unitehcarousel"; 
		const COMPONENT_NAME = "com_unitehcarousel";
		
		const TABLE_SLIDERS = "#__unitehcarousel_sliders";
		const TABLE_SLIDES = "#__unitehcarousel_slides";
		
		const VIEW_SLIDER = "slider";
		const VIEW_SLIDERS = "sliders";
		const VIEW_ITEMS = "items";
		
		const LAYOUT_SLIDER_GENERAL = "edit";
		const LAYOUT_SLIDER_VISUAL = "visual";

		public static $urlAssets;
		public static $urlAssetsArrows;
		public static $urlAssetsBullets;
		public static $urlItemPlugin;
		
		public static $pathAssets;
		public static $pathComponent;
		public static $pathAssetsArrows;
		public static $pathAssetsBullets;
		public static $pathViews;
		
		
		/**
		 * 
		 * init globals
		 */
		public static function init(){
			//set global vars
			
			self::$urlAssets = JURI::root()."administrator/components/".self::COMPONENT_NAME."/assets/";			
			self::$urlAssetsArrows = self::$urlAssets."arrows/";
			self::$urlAssetsBullets = self::$urlAssets."bullets/";
			
			self::$pathComponent = JPATH_ADMINISTRATOR."/components/".self::COMPONENT_NAME."/";
			self::$pathAssets = GlobalsUniteHCar::$pathComponent."assets/";		
			self::$pathAssetsArrows = GlobalsUniteHCar::$pathAssets."arrows/";
			self::$pathAssetsBullets = GlobalsUniteHCar::$pathAssets."bullets/";
			self::$pathViews = GlobalsUniteHCar::$pathComponent."views/";
			
			self::$urlItemPlugin = self::$urlAssets."fred-carousel/";
		}
		
	}

?>