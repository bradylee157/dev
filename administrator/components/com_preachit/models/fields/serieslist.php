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

class JFormFieldSerieslist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Serieslist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();

$doc = & JFactory::getDocument();
		$view = JRequest::getVar('view', '');
		if ($view == 'studyedit')
        {$where = ' WHERE published = 1 OR published = 0';}     
        elseif ($view == 'podcastedit')
        {
            $select = 'jform_series';
            $selector = 'jform_series_list';
            $js = Tewebadminjs::selectorjs($select, $selector);
            $doc->addScriptDeclaration($js);
            $where = ' WHERE published = 1';
        }
        else
        {
            $select = 'jform_params_seriessel';
            $selector = 'jform_params_seriesselect';
            $js = Tewebadminjs::selectorjs($select, $selector);
            $doc->addScriptDeclaration($js);
            $where = ' WHERE published = 1';
        }
$query = $db->getQuery(true); 
$query = 'SELECT id, series_name'
.' FROM #__piseries'

.$where
.' ORDER BY id';
$db->setQuery($query);
$slists = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_SERIES_SELECT'));
                foreach($slists as $slist) 
                {
                        $options[] = JHtml::_('select.option', $slist->id, $slist->series_name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}