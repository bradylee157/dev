<?php
/**
 * @version		$Id: mod_AvatarSlide.php 48 2011-06-25 08:22:19Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.path' );
require_once( dirname(__FILE__).DS.'helper.php' );

$show = modAvatarSlideHelper::getjslide($params);
$Path = modAvatarSlideHelper::getPath($params);
$Time = modAvatarSlideHelper::getTime($params);
$Auto = modAvatarSlideHelper::getAuto($params);
$SlideHeight = modAvatarSlideHelper::getHeight($params);
$SlideWidth = modAvatarSlideHelper::getWidth($params);
$ThumbSize = modAvatarSlideHelper::getThumbSize($params);
$ThumbDisplay = modAvatarSlideHelper::getThumbDisplay($params);
$Ratio=$SlideHeight/$SlideWidth;
require( JModuleHelper::getLayoutPath( 'mod_AvatarSlide' ) );
?>