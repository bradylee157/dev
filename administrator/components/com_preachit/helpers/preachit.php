<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
 
 
class PreachitHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($smenu = 'smenu')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_CPANEL'),
			'index.php?option=com_preachit&view=cpanel',
			$smenu == 'cpanel'
		);		
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_MESSAGES'),
			'index.php?option=com_preachit&view=studylist',
			$smenu == 'messages'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_TEACHER'),
			'index.php?option=com_preachit&view=teacherlist',
			$smenu == 'teachers'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_SERIES'),
			'index.php?option=com_preachit&view=serieslist',
			$smenu == 'series'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_MINISTRIES'),
			'index.php?option=com_preachit&view=ministrylist',
			$smenu == 'ministries'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_COMMENTS'),
			'index.php?option=com_preachit&view=commentlist',
			$smenu == 'comments'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_FOLDERS'),
			'index.php?option=com_preachit&view=filepathlist',
			$smenu == 'folders'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_BIBLEBOOKS'),
			'index.php?option=com_preachit&view=booklist',
			$smenu == 'booklist'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_BIBLEVERSIONS'),
			'index.php?option=com_preachit&view=bibleverslist',
			$smenu == 'bible_versions'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_PODCASTS'),
			'index.php?option=com_preachit&view=podcastlist',
			$smenu == 'podcasts'
		);
        JSubMenuHelper::addEntry(
            JText::_('COM_PREACHIT_MENU_TAGS'),
            'index.php?option=com_preachit&view=taglist',
            $smenu == 'podcasts'
        );
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_MIMETYPES'),
			'index.php?option=com_preachit&view=mimelist',
			$smenu == 'mime_types'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_TEMPLATES'),
			'index.php?option=com_preachit&view=templatelist',
			$smenu == 'templates'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_MEDIAPLAYERS'),
			'index.php?option=com_preachit&view=mediaplayerslist',
			$smenu == 'media_players'
		);
        JSubMenuHelper::addEntry(
            JText::_('COM_PREACHIT_MENU_SHARE'),
            'index.php?option=com_preachit&view=sharelist',
            $smenu == 'share'
        );
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_EXTENSIONS'),
			'index.php?option=com_preachit&view=extensionlist',
			$smenu == 'extensions'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PREACHIT_MENU_BACKENDADMIN'),
			'index.php?option=com_preachit&view=admin',
			$smenu == 'admin'
		);
		
	}
public static function getActions($id = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_preachit';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete', 'core.edit.own'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
}