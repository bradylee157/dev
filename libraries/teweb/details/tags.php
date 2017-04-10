<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebtags{

/**
     * Retrieves tags list of tags from the database
     * @return array() object array with tag data strings
     */    
     public function getTags($table, $order = 'DESC', $sort = 'count', $publishup = true)
     {
         $tags = array();
         $rows = Tewebtags::getdataTags($table, $publishup);
         if (is_array($rows))
         {
             $tags = Tewebtags::extractTagsData($rows);
             $tags = Tewebtags::sorttags($tags, $order, $sort);
         }

         return $tags;
     }
    
    
/**
     * Retrieves tags data from database
     * @param string $table the mysql table name you are wanting to search
     * @param boolean $publishup set to false if no publishup, publishdown setting in the table
     * @return array() object array with tag data strings
     */
    private function getdataTags($table, $publishup)
    {
        $app = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $db=& JFactory::getDBO();
        $nullDate = $db->getNullDate(); //since Joomla 1.5
        $now = gmdate ( 'Y-m-d H:i:s' );
        $language = JFactory::getLanguage()->getTag();
        
        if ($publishup)
        {
            $where = " AND (publish_up = '"
                    .$nullDate."' OR publish_up <= '".$now."')"
                    ." AND (publish_down = '".$nullDate."'"
                    ."OR publish_down >= '".$now."')";
        }
        else {$where = null;}
        if ($app->isSite())
        {
            if ($option == 'com_preachit')
            {
                $abspath = JPATH_SITE;
                require_once($abspath.DS.'components/com_preachit/helpers/studylist.php');
                $where = PIHelperstudylist::wherevalue();
            }
            elseif ($option == 'com_melody')
            {
                $abspath = JPATH_SITE;
                require_once($abspath.DS.'components/com_melody/helpers/songlist.php');
                $where = MELHelpersonglist::wherevalue();
            }
            else {$where = "WHERE published = '1'".$where
                    ." AND language IN (".$db->quote($language).",".$db->quote("*").")";}
        }
        else {$where = "WHERE published = '1'".$where
                    ." AND language IN (".$db->quote($language).",".$db->quote("*").")";}

        $query = "SELECT tags FROM ".$table." ".$where;

        $db->setQuery( $query );

        $rows = $db->loadObjectList();
        return $rows;
    }
    
    /**
     * Get raw data for tags.
     * @param $data results object
     * @param array() $rows objects in array must have member tags, a string with tags (comma separated).
     * @return stdClass with raw data.
     */
    private static function extractTagsData($rows)
    {
        $string = '';
        $tagarray = array();
        foreach ($rows as &$row)
        {
            $string = $row->tags;
            //$string = $row->study_name;
            if (!$string || $string=='')
                continue;

            $taglist = explode(',', $string);
            //$taglist = explode(' ', $string);

            foreach ($taglist as &$tag)
            {
                //sanitise tag
                $t = JString::trim($tag);
                if ($t=='')
                {
                    continue;
                }

                //save tag and count
                $tn = null;
                if (isset($tagarray[$t]))
                {
                    $tn = $tagarray[$t];
                }
                else
                {
                    //Create new tag data object
                    $tn = new stdClass();
                    $tn->name = $t;
                    $tn->count = 0;

                    $data->count += 1;
                }
                $tn->count += 1;
                $tagarray[$t] = $tn;

            }
        }

        return $tagarray;
    }

/**
     * Sort tag array by count or name, asc or desc
     * @param array $tags tag info
     * @param string $order Asc or DESC
     * @param string $sort value to sort by
     * @return array() object array with tag data strings
     */
     private function sorttags($tagarray, $order, $sort)
     {
         $order = strtolower($order);
         $sort = strtolower($sort);
         if ($order == 'asc' && $sort == 'count')
         {
             uasort($tagarray, array('Tewebtags', 'cmpTagCountAsc'));
         }
         elseif ($order == 'desc' && $sort == 'name')
         {
             uasort($tagarray, array('Tewebtags', 'cmpTagNameDesc'));
         }
         elseif ($order == 'asc' && $sort == 'name')
         {
             uasort($tagarray, array('Tewebtags', 'cmpTagNameAsc'));
         }
         //sort array from most popular to least popular
         else
         {
             uasort($tagarray, array('Tewebtags', 'cmpTagCountDesc'));
         }
         return $tagarray;
     }
    
/**
     * Compare function for tag array. Sort criteria: tag count reverse
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return -1, if lesser; 0, if equal; +1 if greater.
     */
     public function cmpTagCountDesc(&$a, &$b)
    {
        $va = $a->count;
        $vb = $b->count;
        if ($va == $vb)
        {
            return 0;
        }
        return ($va < $vb) ? +1 : -1;
    }
    
/**
     * Compare function for tag array. Sort criteria: tag count ascending
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return +1, if lesser; 0, if equal; -1 if greater.
     */
   public function cmpTagCountAsc(&$a, &$b)
    {
        $va = $a->count;
        $vb = $b->count;
        if ($va == $vb)
        {
            return 0;
        }
        return ($va < $vb) ? -1 : +1;
    }

/**
     * Compare function for tag array. Sort criteria: tag count reverse
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return -1, if lesser; 0, if equal; +1 if greater.
     */
    public function cmpTagNameDesc(&$a, &$b)
    {
        $va = strtolower($a->name);
        $vb = strtolower($b->name);
        $result = strcmp($va, $vb);
        if ($result == 0)
        {
            return 0;
        }
        elseif($result > 0)
        {
            return -1;
        }
        else {return +1;}
    }
    
/**
     * Compare function for tag array. Sort criteria: tag count ascending
     * @param stdClass $a tag object A
     * @param stdClass $b tag object B
     * @return +1, if lesser; 0, if equal; -1 if greater.
     */
    public function cmpTagNameAsc(&$a, &$b)
    {
        $va = strtolower($a->name);
        $vb = strtolower($b->name);
        $result = strcmp($va, $vb);
        if ($result == 0)
        {
            return 0;
        }
        elseif($result > 0)
        {
            return +1;
        }
        else {return -1;}
    }

/**
     * method to replace tags with a new tag
     * @param string $original the tag to change
     * @param string $newtag the tag to change to
     * @param string $table the mysql table name you are wanting to search
     * @return string message to show on return
     */
    public function changetag($original, $newtag, $table)
    {
        $app = JFactory::getApplication();
        $msg = JText::_('LIB_TEWEB_NO_CHANGES_MADE');
        if ($original != $newtag)
        {
            $db=& JFactory::getDBO();
            $query = "SELECT tags, id FROM ".$table;
            $db->setQuery( $query );
            $rows = $db->loadObjectList();
            if (is_array($rows) && count($rows) > 0)
            {
                foreach ($rows AS $row)
                {
                    $string = null;
                    $string = $row->tags;
                    if (!$string || $string=='')
                    continue;
                    $taglist = explode(',', $string);
                    $i = 0;
                    $change = false;
                    foreach ($taglist as &$tag)
                    {
                        //sanitise tag
                        $t = JString::trim($tag);
                        if ($t == $original)
                        {
                            $taglist[$i] = $newtag;
                            $change = true;
                        }
                        $i++;
                    }
                    if ($change)
                    {
                        $string = implode(',', $taglist);
                        Tewebtags::updatetagentry($table, $row->id, $string);
                        $msg = JText::_('LIB_TEWEB_TAGS_CHANGED');
                    }
                }
            }
        }
        $app->enqueueMessage ( $msg, 'message' );
        return true;
    }

/**
     * method to remove tags
     * @param string $original the tag to change
     * @param string $newtag the tag to change to
     * @param string $table the mysql table name you are wanting to search
     * @return string message to show on return
     */
    public function deletetag($table)
    {
        $app = JFactory::getApplication();
        $cid = JRequest::getVar('cid', array());
        // trim cid array
        $i = 0;
        foreach ($cid AS $name)
        {
            $n = JString::trim($name);
            $cid[$i] = $n;
            $i++;
        }
        $db=& JFactory::getDBO();
        $query = "SELECT tags, id FROM ".$table;
        $db->setQuery( $query );
        $rows = $db->loadObjectList();

        foreach ($rows AS $row)
        {
            $string = null;
            $string = $row->tags;
            if (!$string || $string=='')
            continue;
            $taglist = explode(',', $string);
            $i = 0;
            $change = false;
            foreach ($taglist as &$tag)
            {
                //sanitise tag
                $t = JString::trim($tag);
                if (in_array($t, $cid))
                {
                    unset($taglist[$i]);
                    $change = true;
                }
                $i++;
                if ($change)
                {
                    $string = implode(',', $taglist);
                    Tewebtags::updatetagentry($table, $row->id, $string);
                }
            }
        }
        
        // check whether plural of message needed
        if (count($cid) > 1)
        {$msg = JText::_('LIB_TEWEB_TAGS_DELETED');}
        else
        {$msg = JText::_('LIB_TEWEB_TAG_DELETED');}
        $app->enqueueMessage ( $msg, 'message' );
        return true;
    }
    
/**
     * Method to update the table with the new tag entry
     * @param string $table the mysql table name you are wanting to update
     * @param int $id id of the record you want to update
     * @parem string $tag tag entry to update
     * @return boolean
     */
    public function updatetagentry($table, $id, $tag)
    {
        // update sent date in admin table
        $db =& JFactory::getDBO();
        $db->setQuery ("UPDATE ".$table." SET tags = ".$db->quote($tag)." WHERE id = ".$db->quote($id).";");
        $db->query();
        $updateresult = $db->getAffectedRows();
        if ($updateresult > 0) {return true;} else {return false;}
    }
    
    
}

?>