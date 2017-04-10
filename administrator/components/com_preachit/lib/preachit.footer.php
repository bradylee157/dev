<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class PIfooter{
	/**
	* Retrieve info and build footer
	*
	* @return string version
	*/	
	function footer($type = 1)
	{
	$abspath    = JPATH_SITE;	
		require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.version.php');
		$footer = JText::_('COM_PREACHIT_INSTALLED').' Preachit '. PIVersion::versionXML().' | '
		. PIVersion::dateXML().' | '. JText::_('COM_PREACHIT_COPYRIGHT'). ' &copy; '. PIVersion::copyrightXML()
		.' <a target="_blank" href="http://te-webdesign.org.uk">Truthengaged</a>  | '.JText::_('COM_PREACHIT_LICENSE').' <a target="_blank" href="http://www.gnu.org/copyleft/gpl.html">GNU GPL</a>';
		return $footer;
	}
	
}
?>
