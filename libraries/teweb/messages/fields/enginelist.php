<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
$lang = & JFactory::getLanguage();
$lang->load('lib_teweb', JPATH_SITE);

class JFormFieldEnginelist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Enginelist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
{$db = JFactory::getDBO();

        $query = "
        SELECT ".$db->nameQuote('enabled')."
        FROM ".$db->nameQuote('#__extensions')."
        WHERE ".$db->nameQuote('name')." = ".$db->quote('com_jcomments').";
        ";
        $db->setQuery($query);
        $jcomment = $db->loadResult(); 
        
        $query = "
        SELECT ".$db->nameQuote('enabled')."
        FROM ".$db->nameQuote('#__extensions')."
        WHERE ".$db->nameQuote('name')." = ".$db->quote('com_jomcomments').";
        ";
        $db->setQuery($query);
        $jomcomment = $db->loadResult(); 

$options[] = JHtml::_('select.option', 'inbuilt', 'Inbuilt');
if ($jcomment == 1)
{$options[] = JHtml::_('select.option', 'jcomment', 'Jcomment');}
if ($jomcomment == 1)
{$options[] = JHtml::_('select.option', 'jomcomment', 'Jomcomment');}
$options[] = JHtml::_('select.option', 'intensedebate', 'IntenseDebate');
$options[] = JHtml::_('select.option', 'disqus', 'Disqus');
$options[] = JHtml::_('select.option', 'facebook', 'Facebook');

                return $options;

}
}