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

class JFormFieldBooklist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Booklist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
{
		
	$abspath    = JPATH_SITE;
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');	
	$blists = PIHelperscripture::getbooklist();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_BOOK_SELECT'));
                foreach($blists as $blist) 
                {
                        $options[] = JHtml::_('select.option', $blist->value, $blist->text);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}