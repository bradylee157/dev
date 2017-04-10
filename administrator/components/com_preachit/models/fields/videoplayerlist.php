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

class JFormFieldVideoplayerlist extends JFormFieldList
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Videoplayerlist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getOptions()
	{$db = JFactory::getDBO();
$query = $db->getQuery(true); 
$query = 'SELECT id, playername'
.' FROM #__pimediaplayers'

.' WHERE playertype = 2 AND published = 1 || playertype = 3 AND published = 1'
.' ORDER BY playername';
$db->setQuery($query);
$vplayers = $db->loadObjectList();
                $options = array();
                $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_VIDPLAY_SELECT'));
                foreach($vplayers as $vplayer) 
                {
                        $options[] = JHtml::_('select.option', $vplayer->id, $vplayer->playername);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;

}
}