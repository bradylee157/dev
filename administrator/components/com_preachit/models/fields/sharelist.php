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

class JFormFieldSharelist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'sharelist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
	$query = $db->getQuery(true); 

$query = 'SELECT id, name'
.' FROM #__pishare'

.' WHERE published = 1'
.' ORDER BY ordering ASC';
$db->setQuery($query);
$sharelist = $db->loadObjectList();
                $options = array();
                if (!is_array($sharelist))
                {$options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_SHARE_NONE'));}
                else {
                    foreach($sharelist as $share) 
                    {
                        $options[] = JHtml::_('select.option', $share->id, $share->name);
                    }
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}