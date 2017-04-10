<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Finder.Preachit
 *
 * @copyright   Copyright (C) 2012 te-webdesign
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_BASE') or die;

$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/message-info.php');
require_once($abspath.DS.'components/com_preachit/helpers/additional.php');
require_once($abspath.DS.'components/com_preachit/helpers/scripture.php');

jimport('joomla.application.component.helper');

// Load the base adapter.
require_once JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/adapter.php';

/**
 * Finder adapter for Joomla Web Links.
 *
 * @package     Joomla.Plugin
 * @subpackage  Finder.Weblinks
 * @since       2.5
 */
class plgFinderPreachit extends FinderIndexerAdapter
{
	/**
	 * The plugin identifier.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $context = 'Preachit';

	/**
	 * The extension name.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $extension = 'com_preachit';

	/**
	 * The sublayout to use when rendering the results.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $layout = 'message';

	/**
	 * The type of content that the adapter indexes.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $type_title = 'Preachit';

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 *
	 * @since   2.5
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

    /**
     * Method to update the item link information when the item category is
     * changed. This is fired when the item category is published or unpublished
     * from the list view.
     *
     * @param   string   $extension  The extension whose category has been updated.
     * @param   array    $pks        A list of primary key ids of the content that has changed state.
     * @param   integer  $value      The value of the state that the content has been changed to.
     *
     * @return  void
     *
     * @since   2.5
     */
    public function onFinderCategoryChangeState($extension, $pks, $value)
    {
 
    }

    /**
     * Method to remove the link information for items that have been deleted.
     *
     * @param   string  $context  The context of the action being performed.
     * @param   JTable  $table    A JTable object containing the record to be deleted
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     * @throws  Exception on database error.
     */
    public function onFinderAfterDelete($context, $table)
    {
        if ($context == 'com_preachit.message')
        {
            $urls = $this->allpiurl($table, null);
            foreach ($urls AS $url)
            {
                $link_ids = $this->getfinderitems('link_id', 'url', $url, true);

                // Check the items.
                if (empty($link_ids))
                {
                    continue;
                }

                // Remove the items.
                foreach ($link_ids as $link_id)
                {   
                      FinderIndexer::remove($link_id);
                }
            }
        }
                
        elseif ($context == 'com_finder.index')
        {
            $id = $table->link_id;
        }
        else
        {
            return true;
        }
        // Remove the items.
        return $this->remove($id);
    }

    /**
     * Method to determine if the access level of an item changed.
     *
     * @param   string   $context  The context of the content passed to the plugin.
     * @param   JTable   $row      A JTable object
     * @param   boolean  $isNew    If the content has just been created
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     * @throws  Exception on database error.
     */
    public function onFinderAfterSave($context, $row, $isNew)
    {
        // We only want to handle web links here
        if ($context == 'com_preachit.message')
        {
            // Run the setup method.
            $this->setup();

            // Get the item.
            $item = $this->getItem($row->id);

            // Index the item.
            $this->index($item);
        
        }
        return true;
            
    }

    /**
     * Method to reindex the link information for an item that has been saved.
     * This event is fired before the data is actually saved so we are going
     * to queue the item to be indexed later.
     *
     * @param   string   $context  The context of the content passed to the plugin.
     * @param   JTable   $row     A JTable object
     * @param   boolean  $isNew    If the content is just about to be created
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     * @throws  Exception on database error.
     */
    public function onFinderBeforeSave($context, $row, $isNew)
    {
        // We only want to handle web links here
        if ($context == 'com_preachit.message')
        {
        }

        return true;
    }

    /**
     * Method to update the link information for items that have been changed
     * from outside the edit screen. This is fired when the item is published,
     * unpublished, archived, or unarchived from the list view.
     *
     * @param   string   $context  The context for the content passed to the plugin.
     * @param   array    $pks      A list of primary key ids of the content that has changed state.
     * @param   integer  $value    The value of the state that the content has been changed to.
     *
     * @return  void
     *
     * @since   2.5
     */
    public function onFinderChangeState($context, $pks, $value)
    {
        
        // We only want to handle web links here
        if ($context == 'com_preachit.message')
        {
            
            foreach ($pks as $pk)
            {
                $urls = $this->allpiurl($pk, null);
                foreach ($urls AS $url)
                {
                    $link_ids = $this->getfinderitems('link_id', 'url', $url, true);

                // Check the items.
                    if (empty($link_ids))
                    {
                     continue;
                    }

                    // Remove the items.
                    foreach ($link_ids as $link_id)
                    {  
                        $property[0] = 'state';
                        $this->changevalues($link_id, $value, $property);
                    }
                }

                // Queue the item to be reindexed.
//                FinderIndexerQueue::add($context, $pk, JFactory::getDate()->toMySQL());
            }
        }

        // Handle when the plugin is disabled
        if ($context == 'com_plugins.plugin' && $value === 0)
        {
            // Since multiple plugins may be disabled at a time, we need to check first
            // that we're handling web links
            foreach ($pks as $pk)
            {
                if ($this->getPluginType($pk) == 'preachit')
                {
                    // Get all of the web links to unindex them
                    $sql = clone($this->_getStateQuery());
                    $this->db->setQuery($sql);
                    $items = $this->db->loadColumn();

                    // Remove each item
                    foreach ($items as $item)
                    {
                        $this->remove($item);
                    }
                }
            }
        }
    }

    /**
     * Method to index an item. The item must be a FinderIndexerResult object.
     *
     * @param   FinderIndexerResult  $item  The item to index as an FinderIndexerResult object.
     *
     * @return  void
     *
     * @since   2.5
     * @throws  Exception on database error.
     */
    protected function index(FinderIndexerResult $item)
    {
        // Check if the extension is enabled
        if (JComponentHelper::isEnabled($this->extension) == false)
        {
            return;
        }

        $linkdesc = 'study';  
        $lang = & JFactory::getLanguage();
        $lang->load('com_preachit', JPATH_SITE);
        
        $item->access = max($item->access, $item->saccess, $item->minaccess);

        // Build the necessary route and path information.
        $item->url  = $this->formpiurl($linkdesc, $item->id, $item->alias);
        $item->route = $this->formpiurl($linkdesc, $item->id, $item->alias);
        $item->path = FinderIndexerHelper::getContentPath($item->route);
        
        // need to search if audio or text link - and change link to reflect new priority rather than redo whole record
        
        $changeurl = $this->changeurl($item->id, $item->alias, $item->url);
        
        //get scripture
        $scripture = PIHelperscripture::podscripture($item->id);
        $item->summary .= '<br />'.JText::_('COM_PREACHIT_PASSAGE').': '.$scripture;

        // Handle the link to the meta-data.
        //$item->addInstruction(FinderIndexer::META_CONTEXT, 'link');

        // Set the language.
        $item->language = FinderIndexerHelper::getDefaultLanguage();
        
        // get teacher & series namename   
        $tname = PIHelpermessageinfo::teacher($item->teacher, '', 2);
        $sname = PIHelpermessageinfo::series($item->series, '', 2);
        // Add the type taxonomy data.
        $item->addTaxonomy('Type', 'Sermon Media');
        
        if ($item->saccess == 0)
        {$item->saccess = 1;}

        // Add the series taxonomy data.

        if (!empty($sname))
        {$item->addTaxonomy('Series', $sname, $item->state, $item->saccess);}
            
        if (!empty($tname))
        {$item->addTaxonomy('Author', $tname, $item->state, $item->access);}

        // Get content extras.
        FinderIndexerHelper::getContentExtras($item);

        // Index the item.
        FinderIndexer::index($item);
    }

    /**
     * Method to setup the indexer to be run.
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     */
    protected function setup()
    {
        // Load dependent classes.
        require_once JPATH_SITE . '/includes/application.php';
        //require_once JPATH_SITE . '/components/com_preachit/helpers/router.php';

        return true;
    }

    /**
     * Method to get the SQL query used to retrieve the list of content items.
     *
     * @param   mixed  $sql  A JDatabaseQuery object or null.
     *
     * @return  JDatabaseQuery  A database object.
     *
     * @since   2.5
     */
    protected function getListQuery($sql = null)
    {
        $db = JFactory::getDbo();
        // Check if we can use the supplied SQL query.
        $sql = is_a($sql, 'JDatabaseQuery') ? $sql : $db->getQuery(true);
        $sql->select('a.id, a.series, a.teacher, a.study_name AS title, a.study_alias AS alias, a.study_description AS summary');
        $sql->select('a.publish_up AS publish_start_date, a.publish_down AS publish_end_date');
        $sql->select('a.published AS state, a.access, a.saccess, a.minaccess, a.study_date AS start_date');
        $sql->select('CASE WHEN CHAR_LENGTH(a.study_alias) THEN ' . $sql->concatenate(array('a.id', 'a.study_alias'), ':') . ' ELSE a.id END as slug');
        $sql->select('CASE WHEN CHAR_LENGTH(a.study_alias) THEN ' . $sql->concatenate(array('a.id', 'a.study_alias'), ':') . ' ELSE a.id END as catslug');
        $sql->from('#__pistudies AS a');
        //$sql->join('LEFT', '#__piseries AS c ON c.id = a.series');

        return $sql;
    }

    /**
     * Method to get the query clause for getting items to update by time.
     *
     * @param   string  $time  The modified timestamp.
     *
     * @return  JDatabaseQuery  A database object.
     *
     * @since   2.5
     */
    protected function getUpdateQueryByTime($time)
    {
        // Build an SQL query based on the modified time.
        $sql = $this->db->getQuery(true);
        $sql->where('a.date >= ' . $this->db->quote($time));

        return $sql;
    }

    /**
     * Method to get a SQL query to load the published and access states for
     * an web link and category.
     *
     * @return  JDatabaseQuery  A database object.
     *
     * @since   2.5
     */
    private function _getStateQuery()
    {
        $sql = $this->db->getQuery(true);
        $sql->select('a.id');
        $sql->select('a.published AS state');
        $sql->select('a.access AS access, a.saccess AS cat_access, a.minaccess AS min_access');
        $sql->from('#__pistudies AS a');

        return $sql;
    }
    
/**
     * Method to change url to guard against multiple entries of the same sermon
     *
     * @param   int $id id of the message
     * @param   string $alias alias of the message
     * @param string $newurl url to change to
     * @return  void
     */
    protected function changeurl($id, $alias, $newurl)
    {
            
            $urls = $this->allpiurl($id, $alias);
            foreach ($urls AS $url)
            {
                $items = $this->getfinderitems('link_id', 'url', $url, true);

                // Check the items.
                if (empty($items))
                {
                    continue;
                }

                // Remove the items.
                foreach ($items as $item)
                {   
                      $property[0] = 'url';
                      $property[1] = 'route';
                      $this->changevalues($item, $newurl, $property);
                }
            }
        return;
        
    }
    
    /**
     * Method to change values in finder entry
     *
     * @param   int $id id of the mfinder entry
     * @param   array $change items to change
     *
     * @return  void
     * @since   2.5
     * @throws    Exception on database error.
     */
    protected function changevalues($id, $value, $property)
    {
        foreach ($property AS $prop)
        {
            // Update the content items.
            $query = $this->db->getQuery(true);
            $query->update($this->db->quoteName('#__finder_links'));
            $query->set($this->db->quoteName($prop) . ' = ' . $this->db->quote($value));
            $query->where($this->db->quoteName('link_id') . ' = ' . $id);
            $this->db->setQuery($query);
            $this->db->query();
            
            // Check for a database error.
            if ($this->db->getErrorNum())
            {
                // Throw database error exception.
                throw new Exception($this->db->getErrorMsg(), 500);
            }
        }
        return;
    }
    
/**
     * Method to get all possible piurls
     * @param   int $id id of the mfinder entry
     * @param   string $alias item alias
     *
     * @return  string
     */
    protected function allpiurl($id, $alias)
    {
        $view[0] = 'study';
        $i = 0;
        foreach ($view AS $linkdesc)
        {
            $url[$i] = $this->formpiurl($linkdesc, $id, null);
            $i++;
        }
        return $url;
    }
    
        /**
     * Method to form pi url
     * @param string $view view to link to
     * @param   int $id id of the mfinder entry
     * @param   string $alias item alias
     *
     * @return  string
     */
    protected function formpiurl($view, $id, $alias)
    {
        if ($alias)
        {$aliasadd = ':'.$alias;}
        else {$aliasadd = null;}
        $url = 'index.php?option=com_preachit&view='.$view.'&id='.$id.$aliasadd;
        return $url;
    }
    
    /**
     * Method to form pi url
     * @param string $view view to link to
     * @param   int $id id of the mfinder entry
     * @param   string $alias item alias
     * @param   boolean $like toggles on/off like or = in query
     * @return  array
     * @since   2.5
     * @throws    Exception on database error.
     */
    protected function getfinderitems($id, $property, $value, $like = false)
    {
        // quote the value
        if (!$like)
        {$value = $this->db->quote($value);}
        else
        {$value = $this->db->quote('%'.$this->db->getEscaped($value, true).'%', false);}
        
        // Get the link ids for the content items.
        $query = $this->db->getQuery(true);
        $query->select($this->db->quoteName('link_id'));
        $query->from($this->db->quoteName('#__finder_links'));
        if (!$like)
        {$query->where($this->db->quoteName($property) . ' = ' . $value );}
        else
        {$query->where($this->db->quoteName($property) . ' LIKE ' . $value );}
        $this->db->setQuery($query);
        $items = $this->db->loadColumn();
        
        // Check for a database error.
        if ($this->db->getErrorNum())
        {
            // Throw database error exception.
            throw new Exception($this->db->getErrorMsg(), 500);
        }

        
        return $items;
    }


}
