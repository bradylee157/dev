<?php
/**
 * @version		$Id: mod_AvatarSlide.php 48 2011-06-25 08:22:19Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
class modAvatarSlideHelper
{ 
    function getjslide($params){return $params;}
    function getPath($params){return $params->get('Path');}
	function getTime($params){return $params->get('Time');}
	function getHeight($params){return $params->get('SlideHeight');}
	function getWidth($params){return $params->get('SlideWidth');}
	function getThumbSize($params){return $params->get('ThumbSize');}
	function getThumbDisplay($params){return $params->get('ThumbDisplay');}
	function getAuto($params){return $params->get('Auto');}
}
?>