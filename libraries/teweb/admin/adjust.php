<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebadjust {

/**
	 * Method to adjust date for timezones
	 *
	 * @param	date $entry  Date entered in form.
	 * @param	date $date  Date alredy stored in database.
	 *
	 * @return	array
	 */

function adjustdate($entry, $date)
{
if ($entry == $date)
{$entry = $entry;}
else
{
// get site offset
$config =& JFactory::getConfig();
$siteOffset = $config->getValue('config.offset');
// adjust study date by site offset
$rightdate = JFactory::getDate($entry, $siteOffset); 
// update study_date with adjusted date
$entry = $rightdate->toMySQL(); }

return $entry;
}
	
}
?>