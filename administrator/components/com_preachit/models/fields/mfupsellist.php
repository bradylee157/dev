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
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/forms.php');

class JFormFieldMfupsellist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'mfupsellist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
{
	
                $options = array();
                $select = array();
                $select[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_UPLOAD_SEL_MEDIA'));
                $options = PIHelperforms::getmessagesel(0);
                $options = array_merge(parent::getOptions() , $options);
                $options = array_merge($select , $options);
                return $options;

}
}