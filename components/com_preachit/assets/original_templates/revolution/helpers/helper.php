<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

class Revolutionhelper {

/**
     * Method to get alphabetical links
     * @param string $table table to search
     * @param string $column column to use
     * @param int $type 1 = artist 0 = album
     * @param string $view view to link to
     * @return    string
     */
function getalphalist($table, $column, $type, $view)
{
    $alist = null;
    $item = JRequest::getInt('Itemid', '');
    $language = JFactory::getLanguage()->getTag();    
    $user    = JFactory::getUser();
    $app = JFactory::getApplication();
    $menuparams =& $app->getParams();
    // get list of years
    $db =& JFactory::getDBO();
    $filter_order_Dir = 'ASC';
    $filter_order = 'value';
    $where = array();
    $where[] = ' published = 1';  
    $groups = implode(',', $user->authorisedLevels());
    $where[] = ' language IN ('.$db->quote($language).','.$db->quote('*').')'; 
    if ($type == 0)    
    {
        $where[] = ' (access IN ('.$groups.') OR access = 0)';   
        $seriessel = $menuparams->get('seriessel', 0);
        $seriesselection = $menuparams->get('seriesselect');
        $layout = JRequest::getVar('layout', '');
        if ($layout == 'ministry')
        {$ministry = JRequest::getInt('ministry', 0);}
        else {$ministry = 0;}
        if ($seriessel == 1 && $ministry >! 0) {
            if (count($seriesselection) > 1)
            {
            foreach ($seriesselection AS $sl)
                {
                    $slist[] = '#__piseries.id = '.$sl;
                }
                die();
            $where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';
            }
            else
            {
                $where[] = '#__piseries.id = '.PIHelperadditional::getwherevalue($seriesselection);
            }
        }
        $groups = implode(',', $user->authorisedLevels());
        $where[] = ' language IN ('.$db->quote($language).','.$db->quote('*').')'; 
    }
    if ($type == 1)
    {
        $where[] = ' teacher_view = 1';
        $teachersel = $menuparams->get('teachersel', 0);
        $teacherselection = $menuparams->get('teacherselect');
        if ($teachersel == 1) {
            if (count($teacherselection) > 1)
            {
            foreach ($teacherselection AS $tl)
                {
                    $tlist[] = '#__piteachers.id = '.$tl;
                }
            $where[] = '('. ( count( $tlist ) ? implode( ' OR ', $tlist ) : '' ) .')';
            }
            else
            {
                $where[] = '#__piteachers.id = '.PIHelperadditional::getwherevalue($teacherselection);
            }
        }
    }        
            
    $where         = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
    
    
    
    $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
    $query = " SELECT DISTINCT SUBSTRING(".$column.", 1, 1) AS value "
        . " FROM ".$table
            . $where
            . $orderby
            ;
    $db->setQuery($query);
    $letters = $db->loadObjectList();
    
    $letter = JRequest::getVar('alpha', '');
    
    foreach ($letters AS $l)
    {
        if (!ctype_alpha($l->value))
        {continue;}
        $current = null;
        if (strtolower($letter) == strtolower($l->value))
        {$current = ' class="current"';}
        $alist .= '<li'.$current.'><a href="'.JRoute::_('index.php?option=com_preachit&view='.$view.'&alpha='.strtolower($l->value).'&Itemid='.$item).'" title="'. strtolower($l->value).'">'. strtolower($l->value).'</a></li>';}
        $alist .= '<li><a href="'. JRoute::_('index.php?option=com_preachit&view='.$view.'&Itemid='.$item).'" title="'.strtolower(JText::_('TEALL')).'">'. strtolower(JText::_('TEALL')).'</a></li>';
    return $alist;    
}


}
