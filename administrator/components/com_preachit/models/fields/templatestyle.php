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
class JFormFieldTemplatestyle extends JFormFieldList
{
	
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Templatestyle';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
protected function getOptions()
	{
        jimport('joomla.filesystem.folder');
        $temp = JRequest::getVar('template', '');
        $db =& JFactory::getDBO();
        $query = "
          SELECT ".$db->nameQuote('template')."
        FROM ".$db->nameQuote('#__pitemplate')."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($temp).";
              ";
        $db->setQuery($query);
        $tempfolder = $db->loadResult();
        if ($tempfolder)
        {
            $templateBaseDir = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$tempfolder.DIRECTORY_SEPARATOR.'styles';
	        $templateDirs = JFolder::folders($templateBaseDir);
                $options = array();
                foreach ($templateDirs as $templateDir)
                {
                        $options[] = JHtml::_('select.option', $templateDir, $templateDir);
                }
                $options = array_merge(parent::getOptions() , $options);
                return $options;
        }
        else {return array();}
}
}