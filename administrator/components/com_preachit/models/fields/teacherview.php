<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
class JFormFieldTeacherview extends JFormField
{
/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Teacherview';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

protected function getInput()
	{		// Load the javascript and css
		JHtml::_('behavior.framework');
		JHTML::_('script','system/modal.js', false, true);
		JHTML::_('stylesheet','system/modal.css', array(), true);

		// Build the script.
		$script = array();
		$script[] = '	function jSelectChart_'.$this->id.'(id, name, object) {';
		$script[] = '		document.id("'.$this->id.'_id").value = id;';
		$script[] = '		document.id("'.$this->id.'_name").value = name;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Build the script.
		$script = array();
		$script[] = '	window.addEvent("domready", function() {';
		$script[] = '		var div = new Element("div").setStyle("display", "none").injectBefore(document.id("menu-types"));';
		$script[] = '		document.id("menu-types").injectInside(div);';
		$script[] = '		SqueezeBox.initialize();';
		$script[] = '		SqueezeBox.assign($$("input.modal"), {parse:"rel"});';
		$script[] = '	});';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


		// Get the title of the linked chart
		$db = & JFactory::getDBO();
		$db->setQuery(
			'SELECT teacher_name' .
			' FROM #__piteachers' .
			' WHERE id = '.(int) $this->value
		);
		$title = $db->loadResult();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}

		if (empty($title)) {
			$title = JText::_('COM_PREACHIT_VIEW_PARAMS_CHOOSE_TEACHER');
		}

		$link = 'index.php?option=com_preachit&amp;view=teacherlist&amp;tmpl=component&amp;layout=modal&amp;function=jSelectChart_'.$this->id;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div class="fltlft"><input type="text" id="'.$this->id.'_name" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Choose a study').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('Choose').'</a></div></div>'."\n";
		// The active contact id field.
		if (0 == (int)$this->value) { 
			$value = '';
		} else {
			$value = (int)$this->value; 
		}

		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}
		
		$html .= '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';

		return $html;
	}
}