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

class JFormFieldFolderlist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Folderlist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
	$query = $db->getQuery(true); 

$query = 'SELECT id, name'
.' FROM #__pifilepath'

.' WHERE published = 1'
.' ORDER BY name';
$db->setQuery($query);
$flists = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_FOLDER_SELECT'));
                foreach($flists as $flist) 
                {
                        $options[] = JHtml::_('select.option', $flist->id, $flist->name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}