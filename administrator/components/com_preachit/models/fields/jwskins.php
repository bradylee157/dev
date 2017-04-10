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
JFormHelper::loadFieldClass('list');
class JFormFieldJwskins extends JFormFieldList
{
	
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Jwskins';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
protected function getOptions()
	{
// Read the template folder to find templates

		jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$skinsBaseDir = $client->path.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'mediaplayers'.DIRECTORY_SEPARATOR.'jwskins';
		$skins = JFolder::files($skinsBaseDir);
		$info = array();
		$i = 0;
        $options = array();
        $options[] = JHtml::_('select.option', '', JText::_('COM_PREACHIT_ADMIN_DD_DEFAULT')); 
        foreach ($skins as $skin)
        {
		$ext = JFile::getExt($skin);
		if ($ext == 'zip')
		    { 
		        $options[] = JHtml::_('select.option', $skin, JFile::stripExt($skin));
		    }
        }
        $options = array_merge(parent::getOptions() , $options);
        return $options;
}
}