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

class JFormFieldMessagelist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Messagelist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
	$query = $db->getQuery(true); 

$query = 'SELECT id, CONCAT(id," - ",study_name) AS study_name'
.' FROM #__pistudies'

.' WHERE published = 1'
.' ORDER BY id DESC';
$db->setQuery($query);
$mlists = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_MESSAGE_SELECT'));
                foreach($mlists as $mlist) 
                {
                        $options[] = JHtml::_('select.option', $mlist->id, $mlist->study_name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}