<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgButtonPreachit extends JPlugin {

 /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param     object $subject The object to observe
     * @param     array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgButtonPreachit(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

	function onDisplay($name)
    {
        $link = 'index.php?option=com_preachit&amp;view=plginsert&amp;tmpl=component&amp;e_name='.$name;
        
		  JHTML::_('behavior.modal'); 
		  $lang = & JFactory::getLanguage();
 		 $lang->load('com_preachit', JPATH_ADMINISTRATOR); 
		        
        $css = ".button2-left .preachitButton {
                    background: transparent url(".JURI::ROOT()."components/com_preachit/assets/images/preachit.png) no-repeat 100% 0px;
                }";
        $doc = & JFactory::getDocument();
        $doc->addStyleDeclaration($css);
        $button = new JObject();
        $button->set('modal', true);
        $button->set('onclick', 'buttonPreachitClick(\''.$name.'\');return false;');
        $button->set('text', JText::_('COM_PREACHIT_EDITOR_BUTTON_TITLE'));
        $button->set('name', 'preachitButton');
        $button->set('link', $link);
        $button->set('options', "{handler: 'iframe', size: {x: 550, y: 200}}");

        return $button;
    }

}