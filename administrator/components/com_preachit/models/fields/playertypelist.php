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

class JFormFieldPlayertypelist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'playertypelist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_TYPE_SELECT'));
                $options[] = JHtml::_('select.option', '1', JText::_('PIAUDIO'));
                $options[] = JHtml::_('select.option', '2', JText::_('PIVIDEO'));
                $options[] = JHtml::_('select.option', '3', JText::_('PIAUDIOANDVIDEO'));
                
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}