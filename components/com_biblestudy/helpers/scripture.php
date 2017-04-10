<?php

/**
 * Scripure Helper
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

/**
 * Get Scripture
 * @param object $params
 * @param object $row
 * @param string $esv
 * @param string $scripturerow
 * @return strings
 */
function getScripture($params, $row, $esv, $scripturerow) {
    $mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');
    if (!isset($row->id)) {
        return;
    }
    if (!isset($row->booknumber)):
        $row->booknumber = 0;
    endif;
    if (!isset($row->booknumber2)):
        $row->booknumber2 = 0;
    endif;
    if ($scripturerow == 2 && $row->booknumber2 >= 1) {
        $booknumber = $row->booknumber2;
        $ch_b = $row->chapter_begin2;
        $ch_e = $row->chapter_end2;
        $v_b = $row->verse_begin2;
        $v_e = $row->verse_end2;
    } elseif ($scripturerow == 1 && isset($row->booknumber) >= 1) {
        $booknumber = $row->booknumber;
        $ch_b = $row->chapter_begin;
        $ch_e = $row->chapter_end;
        $v_b = $row->verse_begin;
        $v_e = $row->verse_end;
    }
    if (!isset($booknumber)) {
        $scripture = '';
        return $scripture;
    }
    $show_verses = $params->get('show_verses');
    $db = JFactory::getDBO();
    $query = 'SELECT #__bsms_studies.*, #__bsms_books.bookname, #__bsms_books.id as bid '
            . ' FROM #__bsms_studies'
            . ' LEFT JOIN #__bsms_books ON (#__bsms_studies.booknumber = #__bsms_books.booknumber)'
            . '  WHERE #__bsms_studies.id = ' . $row->id;
    $db->setQuery($query);
    $bookresults = $db->loadObject();
    $affectedrows = count($bookresults);
    if ($affectedrows < 1) {
        return;
    }
    $query = 'SELECT bookname, booknumber FROM #__bsms_books WHERE booknumber = ' . $booknumber;
    $db->setQuery($query);
    $booknameresults = $db->loadObject();
    if (!isset($booknameresults)) {
        $scripture = '';
        return $scripture;
    }
    if ($booknameresults->bookname) {
        $book = JText::_($booknameresults->bookname);
    } else {
        $book = '';
    }
    $b1 = ' ';
    $b2 = ':';
    $b2a = ':';
    $b3 = '-';
    $b3a = '-';
    if ($show_verses == 1) {
        $scripture = $book . $b1 . $ch_b . $b2 . $v_b . $b3 . $ch_e . $b2a . $v_e;
        if ($ch_e == $ch_b) {
            $ch_e = '';
            $b2a = '';
        }
        if ($ch_e == $ch_b && $v_b == $v_e) {
            $b3 = '';
            $ch_e = '';
            $b2a = '';
            $v_e = '';
        }
        if ($v_b == 0) {
            $v_b = '';
            $v_e = '';
            $b2a = '';
            $b2 = '';
        }
        if ($v_e == 0) {
            $v_e = '';
            $b2a = '';
        }
        if ($ch_e == 0) {
            $b2a = '';
            $ch_e = '';
            if ($v_e == 0) {
                $b3 = '';
            }
        }
        $scripture = $book . $b1 . $ch_b . $b2 . $v_b . $b3 . $ch_e . $b2a . $v_e;
    }
    //else
    if ($show_verses == 0) {
        if ($ch_e > $ch_b) {
            $scripture = $book . $b1 . $ch_b . $b3 . $ch_e;
        } else {
            $scripture = $book . $b1 . $ch_b;
        }
    }
    if ($esv == 1) {
        $scripture = $book . $b1 . $ch_b . $b2 . $v_b . $b3 . $ch_e . $b2a . $v_e;
        if ($ch_e == $ch_b) {
            $ch_e = '';
            $b2a = '';
        }
        if ($v_b == 0) {
            $v_b = '';
            $v_e = '';
            $b2a = '';
            $b2 = '';
        }
        if ($v_e == 0) {
            $v_e = '';
            $b2a = '';
        }
        if ($ch_e == 0) {
            $b2a = '';
            $ch_e = '';
            if ($v_e == 0) {
                $b3 = '';
            }
        }
        $scripture = $book . $b1 . $ch_b . $b2 . $v_b . $b3 . $ch_e . $b2a . $v_e;
    }

    if ($row->booknumber > 166) {
        $scripture = $book;
    }
    if ($show_verses == 2) {
        $scripture = $book;
    }
    return $scripture;
}