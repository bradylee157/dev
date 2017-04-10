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

class JFormFieldPodcastlist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Podcastlist';

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
.' FROM #__pipodcast'

.' WHERE published = 1'

.' ORDER BY id';
$db->setQuery($query);
$podlists = $db->loadObjectList();
                $options = array();
                foreach($podlists as $podlist) 
                {
                        $options[] = JHtml::_('select.option', $podlist->id, $podlist->name);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}