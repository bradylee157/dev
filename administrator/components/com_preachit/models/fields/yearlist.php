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

class JFormFieldYearlist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Yearlist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
	
$doc = & JFactory::getDocument();
$select = 'jform_params_datesel';
$selector = 'jform_params_dateselect';
$js = Tewebadminjs::selectorjs($select, $selector);
$doc->addScriptDeclaration($js);
$where = ' WHERE published = 1';

        
        
$query = $db->getQuery(true); 
$query = " SELECT DISTINCT date_format(study_date, '%Y') AS value, date_format(study_date, '%Y') AS text "
        . ' FROM #__pistudies '
        .$where
        .' ORDER BY value DESC';
$db->setQuery($query);
$yearlists = $db->loadObjectList();
                $options = array();
                if (!is_array($yearlists))
                {$options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_NO_YEAR_SELECT'));}
             
                foreach($yearlists as $year) 
                {
                        $options[] = JHtml::_('select.option', $year->value, $year->text);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}