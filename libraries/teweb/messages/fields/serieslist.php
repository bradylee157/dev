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
		$js = "
		window.addEvent('domready', function(){
			var filter0 = $('jform_seriessel0');
			if (!filter0) return;
			filter0.addEvent('click', function(){
				$('jform_series').setProperty('disabled', 'disabled');
				$$('#jform_series option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			})
			
			$('jform_seriessel1').addEvent('click', function(){
				$('jform_series').removeProperty('disabled');
				$$('#jform_series option').each(function(el) {
					el.removeProperty('selected');
				});

			})
			
			if ($('jform_seriessel0').checked) {
				$('jform_series').setProperty('disabled', 'disabled');
				$$('#jform_series option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			}
			
			if ($('jform_seriessel1').checked) {
				$('jform_series').removeProperty('disabled');
			}
			
		});
		";
		
		$doc->addScriptDeclaration($js);
		
$slists = '';
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'piseries';
if (in_array($table, $tables))
{
$query = $db->getQuery(true); 

$query = 'SELECT id, series_name'
.' FROM #__piseries'

.' WHERE published = 1'
.' ORDER BY id';
$db->setQuery($query);
$slists = $db->loadObjectList();
}
                $options = array();
                if (count($slists) < 1 || !$slists)
                {$options[] = JHtml::_('select.option', '', JText::_('PLG_TECOMMENTS_NONE_DISPLAY'));}
                if (is_array($slists)) {
                foreach($slists as $slist) 
                {
                        $options[] = JHtml::_('select.option', $slist->id, $slist->series_name);
                }}
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}