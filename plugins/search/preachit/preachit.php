<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

require_once JPATH_SITE.'/components/com_preachit/router.php';
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

class plgSearchPreachit extends JPlugin
{

    public function onContentSearchAreas()
    {
        static $areas = array(
            'preachit' => 'Sermon Media'
            );
            return $areas;
    }

    public function onContentSearch($text, $phrase='', $ordering='', $areas=null)
    {
        $db    = JFactory::getDbo();
        $app    = JFactory::getApplication();
        $user    = JFactory::getUser();
        $language = JFactory::getLanguage()->getTag();
        $groups = implode(',', $user->authorisedLevels());

        require_once JPATH_SITE.'/administrator/components/com_search/helpers/search.php';

        $searchText = $text;
        if (is_array($areas)) {
            if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
                return array();
            }
        }

        $text = trim($text);
        if ($text == '') {
            return array();
        }
        
        $wheres = array();
        switch ($phrase) {
            case 'exact':
                $text        = $db->Quote('%'.$db->getEscaped($text, true).'%', false);
                $wheres2    = array();
                $wheres2[]    = 'LOWER(a.study_name) LIKE '.$text;
                $wheres2[]    = 'LOWER(a.study_description) LIKE '.$text;
                $wheres2[]    = 'LOWER(s.series_name) LIKE '.$text;
                $wheres2[]    = 'LOWER(b.book_name) LIKE '.$text;
                $wheres2[]  = 'LOWER(a.study_text) LIKE '.$text;
                $wheres2[]   = 'LOWER(a.tags) LIKE '.$text;
                // check teachers
                $wheretea = plgSearchPreachit::checktable('#__piteachers', 'a.teacher', $text);
                if ($wheretea)
                {$wheres2[] = $wheretea;}
                $where        = '(' . implode(') OR (', $wheres2) . ')';
                $where .= ' AND (a.access IN ('.$groups.') OR a.access = 0)';
                $where .= ' AND (a.saccess IN ('.$groups.') OR a.saccess = 0)';
                $where .= ' AND (a.minaccess IN ('.$groups.') OR a.minaccess = 0)';
                $where .= ' AND a.published = 1';
                $where .= ' AND a.language IN ('.$db->quote($language).','.$db->quote('*').')';
                break;

            case 'all':
            case 'any':
            default:
                $words = explode(' ', $text);
                $wheres = array();
                foreach ($words as $word) {
                    $word        = $db->Quote('%'.$db->getEscaped($word, true).'%', false);
                    $wheres2    = array();
                    $wheres2[]    = 'LOWER(a.study_name) LIKE '.$word;
                    $wheres2[]    = 'LOWER(a.study_description) LIKE '.$word;
                    $wheres2[]    = 'LOWER(s.series_name) LIKE '.$word;
                    $wheres2[]    = 'LOWER(b.book_name) LIKE '.$word;
                    $wheres2[]  = 'LOWER(a.study_text) LIKE '.$word;
                    $wheres2[]   = 'LOWER(a.tags) LIKE '.$word;
                    // check teachers
                    $wheretea = plgSearchPreachit::checktable('#__piteachers', 'a.teacher', $word);
                    if ($wheretea)
                    {$wheres2[] = $wheretea;}
                    $wheres[]    = implode(' OR ', $wheres2);
                }
                $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
                
                $where .= ' AND (a.access IN ('.$groups.') OR a.access = 0)';
                $where .= ' AND (a.saccess IN ('.$groups.') OR a.saccess = 0)';
                $where .= ' AND (a.minaccess IN ('.$groups.') OR a.minaccess = 0)';
                $where .= ' AND a.published = 1';
                $where .= ' AND a.language IN ('.$db->quote($language).','.$db->quote('*').')';
                break;
        }
        switch ($ordering) {
            case 'oldest':
                $order = 'a.study_date ASC';
                break;

            case 'popular':
                $order = 'a.hits DESC';
                break;

            case 'alpha':
                $order = 'a.study_name ASC';
                break;

            case 'newest':
            default:
                $order = 'a.study_date DESC';
                break;
        }

        $rows = array();
        $query    = $db->getQuery(true);
        $limit = $this->params->get( 'search_limit', 50 );
        $view= $this->params->get('linkview','audio');
        $item = '&Itemid='.$this->params->get('itemid');
        // search message
    
            $query->clear();
            $query->select('a.id AS id, a.study_name AS title, a.study_description AS text, a.study_date AS created, '
                        .'"Sermon Media" AS section, a.study_alias AS alias, a.id AS id, "2" AS browsernav, '
                        .'a.study_alias AS alias');
            $query->from('#__pistudies AS a');
            $query->leftJoin('#__pibooks AS b ON a.study_book = b.id');
            $query->leftJoin('#__piseries AS s ON a.series = s.id');
            $query->where('('.$where.')');
            $query->order($order);
            $db->setQuery($query, 0, $limit);
            $list = $db->loadObjectList();

            if (isset($list))
            {
                $abspath    = JPATH_SITE;
                require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
                $lang = & JFactory::getLanguage();
                 $lang->load('com_preachit');
                foreach ($list AS $key => $row)        
            {
                    $linkdesc = 'study';                  
                        
                    $list[$key]->href = 'index.php?option=com_preachit&view='.$linkdesc.'&id='.$row->id.':'. $row->alias.$item;
                    
                    // get teacher name
                    $query = "
                      SELECT ".$db->nameQuote('teacher')."
                    FROM ".$db->nameQuote('#__pistudies')."
                    WHERE ".$db->nameQuote('id')." = ".$db->quote($list[$key]->id).";
                      ";
                    $db->setQuery($query);
                    $teacher = $db->loadResult();    
                    $tname = PIHelpermessageinfo::teacher($teacher, '', 2);
                    $list[$key]->title = $list[$key]->title.' '.JText::_('COM_PREACHIT_by').' '.$tname;
                }
            }
        

        $results = $list;

        return $results;
    }
    
    /**
     * Method to get the where string when the entry is an array of ids linking to a different table
     * @param string $table title of the table to search in
     * @param string $check the column to check against in the table
     * @param string $entry the entry in the main table where the id is searched
     * @param string $text the text string to search for
     * @return    string
     */
    
    private function checktable($table, $entry, $text)
    {
        $db =& JFactory::getDBO();

        //get artist id's that might match
        
        $query = "SELECT id FROM ".$table." WHERE LOWER(CONCAT(lastname)) LIKE ".$text." OR LOWER(CONCAT(teacher_name,' ',lastname)) LIKE ".$text." OR LOWER(CONCAT(teacher_name)) LIKE ".$text;
        $db->setQuery( $query);        
        $rows = $db->loadObjectList();
        $where = '';
        //turn list into query        
        
        if (count($rows) > 1)
            {
        foreach ($rows AS $row)
                {
                    $list[] = ' '.$entry.' REGEXP "[[:<:]]'.(int) $row->id.'[[:>:]]"';
                }
        $where = '('. ( count( $list ) ? implode( ' OR ', $list ) : '' ) .')';
        }
        else if (count($rows) == 1)
            {
                foreach ($rows AS $row)
                {
                    $where = ' '.$entry. ' REGEXP "[[:<:]]'.(int) $row->id.'[[:>:]]"';
                }
            }
        return $where; 
    } 
}
