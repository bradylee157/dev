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

class JFormFieldMinistrylist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Ministrylist';

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
            $select = 'jform_ministry';
            $selector = 'jform_ministry_list';
            $js = Tewebadminjs::selectorjs($select, $selector);
            $doc->addScriptDeclaration($js);
            $where = ' WHERE published = 1';
        }
        else
        {
            $select = 'jform_params_ministrysel';
            $selector = 'jform_params_ministryselect';
            $js = Tewebadminjs::selectorjs($select, $selector);
            $doc->addScriptDeclaration($js);
            $where = ' WHERE published = 1';
        }
        
        
$query = $db->getQuery(true); 
$query = 'SELECT id, ministry_name'
.' FROM #__piministry'

.$where
.' ORDER BY id';
$db->setQuery($query);
$mlists = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_MINISTRY_SELECT'));
             
                foreach($mlists as $mlist) 
                {
                        $options[] = JHtml::_('select.option', $mlist->id, $mlist->ministry_name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}