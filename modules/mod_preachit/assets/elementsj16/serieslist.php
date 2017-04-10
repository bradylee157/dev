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
			var filter0 = $('jform_params_seriessel0');
			if (!filter0) return;
			filter0.addEvent('click', function(){
				$('jform_params_seriesselect').setProperty('disabled', 'disabled');
				$$('#jform_params_seriesselect option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			})
			
			$('jform_params_seriessel1').addEvent('click', function(){
				$('jform_params_seriesselect').removeProperty('disabled');
				$$('#jform_params_seriesselect option').each(function(el) {
					el.removeProperty('selected');
				});

			})
			
			if ($('jform_params_seriessel0').checked) {
				$('jform_params_seriesselect').setProperty('disabled', 'disabled');
				$$('#jform_params_seriesselect option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			}
			
			if ($('jform_params_seriessel1').checked) {
				$('jform_params_seriesselect').removeProperty('disabled');
			}
			
		});
		";
		
		$doc->addScriptDeclaration($js);
$query = $db->getQuery(true); 

$query = 'SELECT id, series_name'
.' FROM #__piseries'

.' WHERE published = 1'
.' ORDER BY id';
$db->setQuery($query);
$slists = $db->loadObjectList();
                $options = array();
                if (!$slists)
                {
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_MENU_PARAMS_NO_SERIES'));
                }
                else
                {
                foreach($slists as $slist) 
                {
                        $options[] = JHtml::_('select.option', $slist->id, $slist->series_name);
                }
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}