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
		$abspath    = JPATH_SITE;
		require_once($abspath.DS.'components/com_preachit/helpers/additional.php');	
		$translate = PIHelperadditional::translate();
		$view = JRequest::getVar('view', '');
        $select = 'jform_params_selection';
            $selector = 'jform_params_selids';
        $js = Tewebadminjs::selectorjs($select, $selector);
        $doc->addScriptDeclaration($js);
        $where = ' WHERE published = 1';
		
$query = $db->getQuery(true); 
$query = 'SELECT id, teacher_name, lastname, language'
.' FROM #__piteachers'

.$where
.' ORDER BY id';
$db->setQuery($query);
$tlists = $db->loadObjectList();

                $options = array();
                //$options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_TEACHER_SELECT'));
                foreach($tlists as $tlist) 
                {
                	if ($tlist->lastname != '')
                        {$name = $tlist->teacher_name.' '.$tlist->lastname;}
                    if ($translate)
                            {if ($tlist->language != '*') {$name = $tlist->teacher_name.' '.$tlist->lastname.' - '.$tlist->language;}}
                        $options[] = JHtml::_('select.option', $tlist->id, $name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}