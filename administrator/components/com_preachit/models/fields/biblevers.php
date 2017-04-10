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

class JFormFieldBiblevers extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Biblevers';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();

$query = 'SELECT name, code'
.' FROM #__pibiblevers'

.' WHERE published = 1'
.' ORDER BY name';
$db->setQuery($query);
$bvers = $db->loadObjectList();
                $options = array();
                foreach($bvers as $bver) 
                {
                        $options[] = JHtml::_('select.option', $bver->code, $bver->name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}