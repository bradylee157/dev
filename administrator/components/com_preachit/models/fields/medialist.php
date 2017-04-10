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
jimport('teweb.admin.javascript');
JFormHelper::loadFieldClass('list');

class JFormFieldMedialist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Medialist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
	
        $doc = & JFactory::getDocument();
		$js = Tewebadminjs::selectorjs('jform_media', 'jform_media_list');
		
		$doc->addScriptDeclaration($js);
        $mlists = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', 'audio', JText::_('COM_PREACHIT_UPLOAD_SEL_AUDIO'));
                $options[] = JHtml::_('select.option', 'video', JText::_('COM_PREACHIT_UPLOAD_SEL_VIDEO'));
                $options[] = JHtml::_('select.option', 'notes', JText::_('COM_PREACHIT_UPLOAD_SEL_NOTES'));
                $options[] = JHtml::_('select.option', 'slides', JText::_('COM_PREACHIT_UPLOAD_SEL_SLIDES'));
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}