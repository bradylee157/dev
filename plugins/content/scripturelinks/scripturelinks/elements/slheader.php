<?php

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.form.formfield');
class JFormFieldSLHeader extends JFormField {

		var	$type = 'header';

		function getInput(){
			return JElementSLHeader::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}

		function getLabel(){
			return '';
		}

}
jimport('joomla.html.parameter.element');

class JElementSLHeader extends JElement {

	var	$_name = 'header';

	function fetchElement($name, $value, &$node, $control_name){
		$document = & JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true).'/plugins/content/scripturelinks/scripturelinks/elements/slheader.css');
		return '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_($value).'</div><div class="slclr"></div></div>';
	}

	function fetchTooltip($label, $description, &$node, $control_name, $name){
		return NULL;
	}
}
