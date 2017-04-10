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

class JFormFieldTeacherlist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Teacherlist';

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
			var filter0 = $('jform_params_teachersel0');
			if (!filter0) return;
			filter0.addEvent('click', function(){
				$('jform_params_teacherselect').setProperty('disabled', 'disabled');
				$$('#jform_params_teacherselect option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			})
			
			$('jform_params_teachersel1').addEvent('click', function(){
				$('jform_params_teacherselect').removeProperty('disabled');
				$$('#jform_params_teacherselect option').each(function(el) {
					el.removeProperty('selected');
				});

			})
			
			if ($('jform_params_teachersel0').checked) {
				$('jform_params_teacherselect').setProperty('disabled', 'disabled');
				$$('#jform_params_teacherselect option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			}
			
			if ($('jform_params_teachersel1').checked) {
				$('jform_params_teacherselect').removeProperty('disabled');
			}
			
		});
		";
		
		$doc->addScriptDeclaration($js);

$query = $db->getQuery(true); 

$query = 'SELECT id, teacher_name, lastname'
.' FROM #__piteachers'
.' ORDER BY id';
$db->setQuery($query);
$tlists = $db->loadObjectList();

                $options = array();
                if (!$tlists)
                {
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_MENU_PARAMS_NO_TEACHER'));
                }
                else
                {
            
                foreach($tlists as $tlist) 
                {
                        if ($tlist->teacher_name != '')
                        {
                            $name = $tlist->teacher_name.' '.$tlist->lastname;
                        }
                        else {$name = $tlist->lastname;}
                        $options[] = JHtml::_('select.option', $tlist->id, $name);
                }
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}