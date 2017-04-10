<?php

/**
 * Restore System
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
defined('_JEXEC') or die;

/**
 * Restor class
 * @package BibleStudy.Admin
 * @since 7.0.4
 * @todo Rename Class to be better suted for restore
 */
class JBSImport {

    /**
     * Import DB
     * @param boolean $perent Switch to see if it is coming from migration or restore.
     * @return boolean
     */
    public function importdb($perent) {
        $result = FALSE;
        jimport('joomla.filesystem.file');
        /**
         * Attempt to increase the maximum execution time for php scripts with check for safe_mode.
         */
        if (!ini_get('safe_mode')) {
            set_time_limit(300);
        }
        $installtype = JRequest::getString('install_directory', '', 'post');
        $backuprestore = JRequest::getString('backuprestore', '', 'post');
        if (substr_count($backuprestore, '.sql')) {
            if ($restored = JBSImport::restoreDB($backuprestore)) {
                $result = true;
                return $result;
            }
        }
        if (substr_count($installtype, 'sql')) {
            $uploadresults = JBSImport::_getPackageFromFolder();
            $result = $uploadresults;
        } else {
            $uploadresults = JBSImport::_getPackageFromUpload();
            $result = $uploadresults;
        }
        if ($result) {
            $result = JBSImport::installdb($uploadresults, $perent);
            $userfile = JRequest::getVar('importdb', null, 'files', 'array');
            if (JFile::exists(JPATH_SITE . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $userfile['name'])) {
                unlink(JPATH_SITE . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $userfile['name']);
            }
            if (($perent !== TRUE) && $result):
                require_once (BIBLESTUDY_PATH_ADMIN_LIB . DIRECTORY_SEPARATOR . 'biblestudy.assets.php');
                $fix = new fixJBSAssets();
                $fix->fixassets();
            endif;
        }
        //To do: delete uploaded files or have a option to do this??
        return $result;
    }

    /**
     * Get Package form Upload
     * @return boolean
     */
    public function _getPackageFromUpload() {
        // Get the uploaded file information
        $userfile = JRequest::getVar('importdb', null, 'files', 'array');

        // Make sure that file uploads are enabled in php
        if (!(bool) ini_get('file_uploads')) {
            JError::raiseWarning('1', JText::_('WARNINSTALLFILE'));
            return false;
        }


        // If there is no uploaded file, we have a problem...
        if (!is_array($userfile)) {
            JError::raiseWarning('1', JText::_('JBS_CMN_NO_FILE_SELECTED'));
            return false;
        }

        // Check if there was a problem uploading the file.
        if ($userfile['error'] || $userfile['size'] < 1) {
            JError::raiseWarning('1', JText::_('WARNINSTALLUPLOADERROR'));
            return false;
        }
        // Build the appropriate paths
        $tmp_dest = JPATH_SITE . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $userfile['name'];

        $tmp_src = $userfile['tmp_name'];

        // Move uploaded file
        jimport('joomla.filesystem.file');
        if (JFile::exists($tmp_src)):
            if (!JFile::exists($tmp_dest)):
                $uploaded = move_uploaded_file($tmp_src, $tmp_dest);
            else:
                JFile::delete($tmp_dest);
                $uploaded = move_uploaded_file($tmp_src, $tmp_dest);
            endif;
        endif;

        if ($uploaded) {
            return $tmp_dest;
        } else {
            return false;
        }
    }

    /**
     * Install DB
     * @param string $tmp_src Temp info
     * @param boolean $parent To tell if coming from migration
     * @return boolean if db installed correctly.
     */
    protected static function installdb($tmp_src, $parent = TRUE) {
        jimport('joomla.filesystem.file');
        /**
         * Attempt to increase the maximum execution time for php scripts with check for safe_mode.
         */
        if (!ini_get('safe_mode')) {
            set_time_limit(300);
        }

        $db = JFactory::getDBO();

        $query = file_get_contents($tmp_src);
        $exists = JFile::exists($tmp_src);

        // Graceful exit and rollback if read not successful
        if ($query === false) {
            JError::raiseWarning(1, JText::_('JBS_INS_ERROR_SQL_READBUFFER'));

            return FALSE;
        }
        // Check if sql file is for Joomla! Bible Studys
        $isold = substr_count($query, '#__bsms_admin_genesis');
        $isnot = substr_count($query, '#__bsms_studies');
        $iscernt = substr_count($query, BIBLESTUDY_VERSION_UPDATEFILE);
        if ($isold !== 0 && $isnot === 0) :
            JError::raiseWarning('403', JText::_('JBS_IBM_OLD_DB'));
            return false;
        elseif ($isnot === 0):
            JError::raiseWarning('403', JText::_('JBS_IBM_NOT_DB'));
            return false;
        elseif (($iscernt !== 0) && ($parent === TRUE)): //
            JError::raiseWarning('403', JText::_('JBS_IBM_MIGRATE_NOT_OLD_DB'));
            return false;
        elseif (($iscernt === 0) && ($parent !== TRUE)): // Way to check to see if file came from restore and is current.
            JError::raiseWarning('403', JText::_('JBS_IBM_NOT_CURENT_DB'));
            return false;
        else:
            //first we need to drop the existing JBS tables
            $objects = JBSImport::getObjects();

            foreach ($objects as $object) {
                $dropquery = 'DROP TABLE IF EXISTS ' . $object['name'] . ';';
                $db->setQuery($dropquery);
                $db->execute();
            }
            // Create an array of queries from the sql file
            $queries = $db->splitSql($query);

            if (count($queries) == 0) {
                // No queries to process
                return 0;
            }
            // Process each query in the $queries array (split out of sql file).
            foreach ($queries as $query) {
                $query = trim($query);

                if ($query != '' && $query{0} != '#') {
                    $db->setQuery($query);

                    if (!$db->execute()) {
                        JError::raiseWarning(1, JText::sprintf('JBS_IBM_INSTALLDB_ERRORS', $db->stderr(true)));

                        return FALSE;
                    }
                }
            }
        endif;
        return true;
    }

    /**
     * Restor DB for exesting Joomla Bible Study
     * @param string $backuprestore
     * @return boolean See if the restore worked.
     */
    public static function restoreDB($backuprestore) {
        $db = JFactory::getDBO();
        /**
         * Attempt to increase the maximum execution time for php scripts with check for safe_mode.
         */
        if (!ini_get('safe_mode')) {
            set_time_limit(300);
        }
        $query = file_get_contents(JPATH_SITE . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . $backuprestore);

        //Check to see if this is a backup from an old db and not a migration
        $isold = substr_count($query, '#__bsms_admin_genesis');
        $isnot = substr_count($query, '#__bsms_studies');
        $iscernt = substr_count($query, BIBLESTUDY_VERSION_UPDATEFILE);
        if ($isold !== 0 && $isnot === 0) :
            JError::raiseWarning('403', JText::_('JBS_IBM_OLD_DB'));
            return false;
        elseif ($isnot === 0):
            JError::raiseWarning('403', JText::_('JBS_IBM_NOT_DB'));
            return false;
        elseif (!$iscernt):
            JError::raiseWarning('403', JText::_('JBS_IBM_NOT_CURENT_DB'));
            return false;
        else:
            $queries = $db->splitSql($query);
            foreach ($queries as $querie) {
                $db->setQuery($querie);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    $error = "DB function failed with error number " . $db->getErrorNum() . "<br /><font color=\"red\">";
                    $error .= $db->stderr(true);
                    $error .= "</font>";
                    print_r($error);
                    return false;
                }
            }
        endif;
        return true;
    }

    /**
     * Get Packege from Folder
     * @return boolean
     */
    private static function _getPackageFromFolder() {
        $p_dir = JRequest::getString('install_directory', '', 'post');
        $p_dir = JPath::clean($p_dir);
        return $p_dir;
    }

    /**
     * Get Opjects for tables
     * @return array
     */
    protected static function getObjects() {
        $db = JFactory::getDBO();
        $tables = $db->getTableList();
        $prefix = $db->getPrefix();
        $prelength = strlen($prefix);
        $prefix . $bsms = 'bsms_';
        $objects = array();
        foreach ($tables as $table) {
            if (substr_count($table, $bsms)) {
                $table = substr_replace($table, '#__', 0, $prelength);
                $objects[] = array('name' => $table);
            }
        }
        return $objects;
    }

    /**
     * Alter tables for Blob
     * @return boolean
     */
    protected static function TablestoBlob() {
        $backuptables = $this->getObjects();

        $db = JFactory::getDBO();
        foreach ($backuptables AS $backuptable) {

            if (substr_count($backuptable['name'], 'studies')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY studytext BLOB';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }

                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY studytext2 BLOB';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'podcast')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY description BLOB';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'series')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY description BLOB';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'teachers')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY information BLOB';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
        }
        return true;
    }

    /**
     * Modify tables to Text
     * @return boolean
     */
    protected static function TablestoText() {
        $backuptables = $this->getObjects();

        $db = JFactory::getDBO();
        foreach ($backuptables AS $backuptable) {

            if (substr_count($backuptable['name'], 'studies')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY studytext TEXT';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }

                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY studytext2 TEXT';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'podcast')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY description TEXT';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'series')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY description TEXT';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
            if (substr_count($backuptable['name'], 'teachers')) {
                $query = 'ALTER TABLE ' . $backuptable['name'] . ' MODIFY information TEXT';
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum() != 0) {
                    print_r($db->stderr(true));
                }
            }
        }
        return true;
    }

}