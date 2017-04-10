<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class UAMViewUAM extends Jview
{
	public function display($tpl = null){

		$document = &JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'/components/com_uam/assets/css/style.css');

		JToolBarHelper::title(JText::_('User Article Manager'), 'uam');
		JToolBarHelper::preferences('com_uam', '500', '500');

		parent::display($tpl);

	}

}
?>
