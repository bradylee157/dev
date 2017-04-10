<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.file.functions');
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
class JFormFieldTemplatechooser extends JFormFieldList
{
	
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Templatechooser';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
protected function getOptions()
	{
// Read the template folder to find templates
         $db = JFactory::getDBO();
         $query = $db->getQuery(true); 

         $query = 'SELECT id, title'
         .' FROM #__pitemplate'
         .' ORDER BY title';
         $db->setQuery($query);
         $templist = $db->loadObjectList();

                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_PARAMS_USE_DEFAULT_TEMP'));
                foreach($templist as $info) 
                {
                        $options[] = JHtml::_('select.option', $info->id, $info->title);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;
}
}