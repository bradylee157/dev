<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PreachitViewStudylist extends JView
{
function display($tpl = null)
{
$app = JFactory::getApplication();
 	$option = JRequest::getCmd('option');
$document =& JFactory::getDocument();
$document->addStyleSheet('../components/com_preachit/assets/css/preachit.css');

// get Joomla version to decide which form and method

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');

$admin =& JTable::getInstance('Piadmin', 'Table');
$aid = '1';
$admin->load($aid);
$checkin = $admin->checkin;
$this->assignRef('checkin', $checkin);

$rows =& $this->get('data');
$pagination =& $this->get('Pagination');
$this->assignRef('rows', $rows);
$this->assignRef('pagination',	$pagination);

//assign filter options

$db		=& JFactory::getDBO();
$uri	=& JFactory::getURI();
$filter_book		= $app->getUserStateFromRequest( $option.'filter_book', 'filter_book',0,'int' );
$filter_teacher		= $app->getUserStateFromRequest( $option.'filter_teacher','filter_teacher',0,'int' );
$filter_series		= $app->getUserStateFromRequest( $option.'filter_series',	'filter_series',0,'int' );
$filter_lang		= $app->getUserStateFromRequest( $option.'filter_lang','filter_lang',0,'string' );
$filter_year		= $app->getUserStateFromRequest( $option.'filter_year','filter_year',0,'int' );
$filter_ministry		= $app->getUserStateFromRequest( $option.'filter_ministry','filter_ministry',0,'int' );
$filter_order	 	= $app->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'studydate',	'cmd' );
$filter_order_Dir	= $app->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'DESC' );

//state list

$filter_state = $app->getUserStateFromRequest( $option.'filter_statemes', 'filter_statemes'. '', 'int' );
$this->assignRef('filter_state',	$filter_state);

$selectstate = Tewebdetails::stateselector();
$this->assignRef('state_list', JHTML::_('select.genericList', $selectstate, 'filter_statemes', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_state ));

//Book list

$db =& JFactory::getDBO();
$list = PIHelperscripture::getbooklist();
$selectbook = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_BOOK_SELECT')),

);
$booklist         = array_merge( $selectbook, $list );
$this->assignRef('study_book', JHTML::_('select.genericList', $booklist, 'filter_book', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_book ));

//teacher list

$db =& JFactory::getDBO();
$db->setQuery('SELECT id AS value, teacher_name AS text, lastname AS text2, language AS lang FROM #__piteachers');
$tlists = $db->loadObjectList();
$selectteach = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_TEACHER_SELECT'), 'lang' => ''),
);
$teachlist = array();
$i=0;
foreach($tlists as $tlist) 
 {$translate = PIHelperadditional::translate();
    if ($tlist->text != '')
    {$name = $tlist->text.' '.$tlist->text2;}
    else {$name = $tlist->text2;}
   if ($translate)
   {if ($tlist->lang != '*') {$name = $name.' - '.$tlist->lang;}}
     $teachlist[$i]->value = $tlist->value;
     $teachlist[$i]->text = $name; $i++;}
$teacherlist         = array_merge( $selectteach, $teachlist );
$this->assignRef('teacher_list', JHTML::_('select.genericList', $teacherlist, 'filter_teacher', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_teacher ));

//series list

$db->setQuery('SELECT id AS value, series_name AS text FROM #__piseries ORDER by series_name');
$selectseries = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_SERIES_SELECT')),
);
$serieslist = array_merge( $selectseries, $db->loadObjectList() );
$this->assignRef('series_list', JHTML::_('select.genericList', $serieslist, 'filter_series', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_series ));
//ministry list

$db->setQuery('SELECT id AS value, ministry_name AS text FROM #__piministry ORDER by ministry_name');
$selectseries = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_MINISTRY_SELECT')),
);
$ministrylist = array_merge( $selectseries, $db->loadObjectList() );
$this->assignRef('ministry_list', JHTML::_('select.genericList', $ministrylist, 'filter_ministry', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_ministry ));

//year list

$query = " SELECT DISTINCT date_format(study_date, '%Y') AS value, date_format(study_date, '%Y') AS text "
		. ' FROM #__pistudies '
		. ' ORDER BY value DESC';
$db->setQuery( $query );
$studyyear = $db->loadObjectList();
$selectyears = array(
array('value' => '', 'text' => JText::_('COM_PREACHIT_ADMIN_YEAR_SELECT')),
);
$yearslist = array_merge( $selectyears, $db->loadObjectList() );
$this->assignRef('years_list', JHTML::_('select.genericList', $yearslist, 'filter_year', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_year ));
// language list
jimport( 'joomla.language.helper' );
$langlist = JHtml::_('contentlanguage.existing', true, true);
$defaultlang = array(
array('value' => '', 'text' => JText::_('JOPTION_SELECT_LANGUAGE')),
);
$langlist = array_merge( $defaultlang, $langlist );
$this->assignRef('lang_list', JHTML::_('select.genericList', $langlist, 'filter_lang', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $filter_lang ));

// table order
$lists['order_Dir'] = $filter_order_Dir;
$lists['order'] = $filter_order;
$this->assignRef('lists', $lists);

$dateformat = 'd F, Y';
$this->assignRef('dateformat', $dateformat);
$this->addToolbar();
parent::display($tpl);
}

/**
     * Add the page title and toolbar.
     *
     * @since    1.6
     */
protected function addToolbar()
{
$user    = JFactory::getUser();     
JToolBarHelper::title( JText::_( 'COM_PREACHIT_ADMIN_TITLE_MESSAGES' ), 'message.png');
if ($user->authorise('core.create', 'com_preachit'))  {
JToolBarHelper::addNew();}
if ($user->authorise('core.edit', 'com_preachit'))  {
JToolBarHelper::editList();
}
JToolBarHelper::divider();
if ($user->authorise('core.edit.state', 'com_preachit')) 
{
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
}
JToolBarHelper::divider();
if ($this->filter_state == -2 && $user->authorise('core.delete', 'com_preachit')) {
            JToolBarHelper::deleteList('', 'remove','TE_TOOLBAR_EMPTY_TRASH');
        } else if ($user->authorise('core.edit.state', 'com_preachit')) {
            JToolBarHelper::trash('trash','TE_TOOLBAR_TRASH');
        }
JToolBarHelper::divider();
if ($user->authorise('core.admin', 'com_preachit'))  {
JToolBarHelper::custom('resetall', 'hits32.png', 'hits32.png', 'COM_PREACHIT_RESET_HITS', false);
JToolBarHelper::custom('resetdownloads', 'down32.png', 'down32.png', 'COM_PREACHIT_RESET_DOWNLOADS', false);
JToolBarHelper::divider();
JToolBarHelper::preferences('com_preachit', '550', '900');
}
JToolBarHelper::help('pihelp', 'com_preachit');
}

}