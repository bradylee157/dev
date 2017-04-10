<?php

/**
 * Upload Helper
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

/**
 * JBS Upload class
 * @package BibleStudy.Site
 * @since 7.1.0
 */
class JBSUpload {
//    /**
//     * Method to load javascript for squeezebox modal
//     *
//     * $param string $host the site base url
//     *
//     * @return	string
//     */
//    function uploadjs($host, $admin) {
//        //when we send the files for upload, we have to tell Joomla our session, or we will get logged out
//        $session = JFactory::getSession();
//
//        $val = ini_get('upload_max_filesize');
//        $val = trim($val);
//        $last = strtolower($val[strlen($val) - 1]);
//        switch ($last) {
//            // The 'G' modifier is available since PHP 5.1.0
//            case 'g':
//                $val *= 1024;
//            case 'm':
//                $val *= 1024;
//            case 'k':
//                $val *= 1024;
//        }
//        $valk = $val / 1024;
//        $valm = $valk / 1024;
//        $maxupload = $valm . ' MB';
//        $swfUploadHeadJs = '
//    var swfu;
//
//    window.onload = function()
//    {
//
//    var settings =
//    {
//            //this is the path to the flash file, you need to put your components name into it
//            flash_url : "' . $host . 'media/com_biblestudy/js/swfupload/swfupload.swf",
//
//            //we can not put any vars into the url for complicated reasons, but we can put them into the post...
//            upload_url: "' . $host . $admin . 'index.php?option=com_biblestudy&view=mediafile&task=uploadflash",
//            post_params: {
//            		"option" : "com_biblestudy",
//           		"controller" : "Mediafile",
//            		"task" : "upflash",
//            		"' . $session->getName() . '" : "' . $session->getId() . '",
//           		"format" : "raw"
//           	},
//            //you need to put the session and the "format raw" in there, the other ones are what you would normally put in the url
//            file_size_limit : "' . $maxupload . '",
//            //client side file checking is for usability only, you need to check server side for security
//            file_types : "",
//            file_types_description : "All Files",
//            file_upload_limit : 100,
//            file_queue_limit : 10,
//            custom_settings :
//            {
//                    progressTarget : "fsUploadProgress",
//                    cancelButtonId : "btnCancel"
//            },
//            debug: false,
//
//            // Button settings
//            button_image_url: "' . $host . 'media/com_biblestudy/js/swfupload/images/uploadbutton.png",
//            button_width: "86",
//            button_height: "33",
//            button_placeholder_id: "spanButtonPlaceHolder",
//            button_text: \'<span class="upbutton">' . JText::_('JBS_CMN_BROWSE') . '</span>\',
//            button_text_style: ".upbutton { font-size: 14px; margin-left: 15px;}",
//            button_text_left_padding: 5,
//            button_text_top_padding: 5,
//
//            // The event handler functions are defined in handlers.js
//            file_queued_handler : fileQueued,
//            file_queue_error_handler : fileQueueError,
//            file_dialog_complete_handler : fileDialogComplete,
//            upload_start_handler : uploadStart,
//            upload_progress_handler : uploadProgress,
//            upload_error_handler : uploadError,
//            upload_success_handler : uploadSuccess,
//            upload_complete_handler : uploadComplete,
//            queue_complete_handler : queueComplete     // Queue plugin event
//    };
//    swfu = new SWFUpload(settings);
//    };
//
//    ';
//
//        return $swfUploadHeadJs;
//    }

    /**
     * Method to get temp file name from database
     *
     * @return	string
     */
    public function gettempfile() {
        $temp = JRequest::getVar('flupfile', '', 'POST', 'STRING');
        return $temp;
    }

    /**
     * Method to build temp folder
     *
     * @return	string
     */
    public function gettempfolder() {
        $abspath = JPATH_SITE;
        $temp_folder = $abspath . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
        return $temp_folder;
    }

    /**
     * Method to get path variable
     *
     * @param	array $url  message details.
     * @param	string $tempfile  Temp file path.
     * @param   string $front Front info
     * @return	string
     */
    public function getpath($url, $tempfile, $front = '') {
        jimport('joomla.filesystem.file');
        $path = JRequest::getVar('upload_folder', '', 'POST', 'INT');
        $server = JRequest::getVar('upload_server', '', 'POST', 'INT');
        if ($server == '') {
            if ($tempfile) {
                JFile::delete($tempfile);
            }
            $msg = JText::_('JBS_MED_UPLOAD_FAILED_NO_FOLDER');
            if ($front) {
                JBSUpload::setRedirect($url . $msg);
            } else {
                JBSUpload::setRedirect($url, $msg);
            }
        }
        $returnpath = $server . $path;
        return $returnpath;
    }

    /**
     * Method to delete temp file
     *
     * @param	string $tempfile  Temp file path.
     *
     * @return	bolean
     */
    public function deletetempfile($tempfile) {
        $db = JFactory::getDBO();
        jimport('joomla.filesystem.file');

        // delete file
        JFile::delete($tempfile);



        return true;
    }

    /**
     * Method to check upload file to see if it is allowed
     *
     * @param	array $file  File info
     *
     * @return	bolean
     */
    public function checkfile($file) {
        $allow = true;
        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl", ".py");

        foreach ($blacklist as $ext) {
            if (preg_match("/$ext\$/i", $file)) {
                $allow = false;
            }
        }

        return $allow;
    }

    /**
     * Method to process flash uploaded file
     *
     * @param string $tempfile tempfile location
     * @param	array $filename File info
     *
     * @return	string
     */
    public function processflashfile($tempfile, $filename) {
        jimport('joomla.filesystem.file');
        $uploadmsg = '';
        if ($filename->type == 1) {
            $uploadmsg = JText::_('JBS_MED_UPLOAD_FAILED_NOT_UPLOAD_THIS_FOLDER');
        } elseif ($filename->type == 2) {
            if (!$copy = JBSUpload::ftp($tempfile, $filename, 1)) {
                $uploadmsg = JText::_('JBS_MED_FILE_NO_UPLOADED_FTP');
            }
        } elseif ($filename->type == 3) {
            if (!$copy = JBSUpload::aws($tempfile, $filename, 1)) {
                $uploadmsg = JText::_('JBS_MED_FILE_NO_UPLOADED_AWS');
            }
        } else {
            if (!$copy = JFile::copy($tempfile, $filename->path)) {
                $uploadmsg = JText::_('JBS_MED_FILE_NO_UPLOADED');
            }
        }

        return $uploadmsg;
    }

    /**
     * Method to process flash uploaded file
     *
     * @param array $file tempfile location
     * @param	array $filename File info
     *
     * @return	string
     */
    public function processuploadfile($file, $filename) {
        jimport('joomla.filesystem.file');
        $uploadmsg = '';

        if ($filename->type == 1) {
            $uploadmsg = JText::_('JBS_MED_UPLOAD_FAILED_NOT_UPLOAD_THIS_FOLDER');
        } elseif ($filename->type == 2) {
            $temp_folder = JBSUpload::gettempfolder();
            $tempfile = $temp_folder . $file['name'];
            $uploadmsg = JBSUpload::uploadftp($tempfile, $file);
            if (!$uploadmsg) {
                if (!$copy = JBSUpload::ftp($tempfile, $filename, 0)) {
                    $uploadmsg = JText::_('JBS_MED_FILE_NO_UPLOADED_FTP');
                }

                JFile::delete($tempfile);
            }
        } elseif ($filename->type == 3) {
            $temp_folder = JBSUpload::gettempfolder();
            $tempfile = $temp_folder . $file['name'];
            $uploadmsg = JBSUpload::uploadftp($tempfile, $file);
            if (!$uploadmsg) {
                if (!$copy = JBSUpload::aws($tempfile, $filename, 1)) {
                    $uploadmsg = JText::_('JBS_MED_FILE_NO_UPLOADED_AWS');
                }

                JFile::delete($tempfile);
            }
        } else {

            if (!JFILE::upload($file['tmp_name'], $filename->path)) {
                $uploadmsg = JText::_('JBS_MED_UPLOAD_FAILED_CHECK_PATH');
            }
        }

        return $uploadmsg;
    }

    /**
     * Method to upload the file
     *
     * @param	array $filename Destination file details.
     * @param	array $file  Source File details.
     *
     * @return	string
     */
    public function upload($filename, $file) {
        $msg = '';
        jimport('joomla.filesystem.file');
        if (!JFILE::upload($file['tmp_name'], $filename->path)) {
            $msg = JText::_('JBS_MED_UPLOAD_FAILED_CHECK_PATH') . ' ' . $filename->path . ' ' . JText::_('JBS_MED_UPLOAD_EXISTS');
        }

        return $msg;
    }

    /**
     * Method to upload the file for ftp upload
     *
     * @param	array $filename Destination file details.
     * @param	array $file  Source File details.
     *
     * @return	string
     */
    public function uploadftp($filename, $file) {
        $msg = '';
        jimport('joomla.filesystem.file');
        if (!JFILE::upload($file['tmp_name'], $filename)) {
            $msg = JText::_('JBS_MED_UPLOAD_FAILED_CHECK_PATH') . ' ' . $filename->path . ' ' . JText::_('JBS_MED_UPLOAD_EXISTS');
        }
        return $msg;
    }

    /**
     * Method to upload the file over ftp
     *
     * @param	array $file  Source File details.
     * @param	array $filename Destination file details.
     * @param	bolean $admin Sets whether call is from Joomla admin or site.
     *
     * @return	bolean
     */
    public function ftp($file, $filename, $admin = 0) {

        $app = JFactory::getApplication();
        $ftpsuccess = true;
        $ftpsuccess1 = true;
        $ftpsuccess2 = true;
        $ftpsuccess3 = true;
        $ftpsuccess4 = true;
        // FTP access parameters
        $host = $filename->ftphost;
        $usr = $filename->ftpuser;
        $pwd = $filename->ftppassword;
        $port = $filename->ftpport;

        // file to move:
        $local_file = $file;
        $ftp_path = $filename->path;
        // connect to FTP server (port 21)
        if (!$conn_id = ftp_connect($host, $port)) {
            if ($admin == 0) {
                $app->enqueueMessage(JText::_('JBS_MED_FTP_NO_CONNECT'), 'error');
            }
            $ftpsuccess1 = false;
        }

        // send access parameters
        if (!ftp_login($conn_id, $usr, $pwd)) {
            if ($admin == 0) {
                $app->enqueueMessage(JText::_('JBS_MED_FTP_NO_LOGIN'), 'error');
            }
            $ftpsuccess2 = false;
        }

        // turn on passive mode transfers (some servers need this)
        // ftp_pasv ($conn_id, true);
        // perform file upload
        if (!$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_BINARY)) {
            $stop = 'stopped at ftp_put';
            if ($admin == 0) {
                $app->enqueueMessage(JText::_('JBS_MED_FTP_NO_UPLOAD'), 'error');
            }
            $ftpsuccess3 = false;
        }

        /*
         * * Chmod the file (just as example)
         */

        // If you are using PHP4 then you need to use this code:
        // (because the "ftp_chmod" command is just available in PHP5+)
        if (!function_exists('ftp_chmod')) {

            /**
             * FTP Chmod
             * @param string $ftp_stream
             * @param string $mode
             * @param array $filename
             * @return \bolean|boolean
             */
            function ftp_chmod($ftp_stream, $mode, $filename) {
                return ftp_site($ftp_stream, sprintf('CHMOD %o %s', $mode, $filename));
            }

        }

        // try to chmod the new file to 666 (writeable)
        if (ftp_chmod($conn_id, 0755, $ftp_path) == false) {
            if ($admin == 0) {
                $app->enqueueMessage(JText::_('JBS_MED_FTP_NO_CHMOD'), 'error');
            }
            $ftpsuccess4 = false;
        }

        // close the FTP stream
        ftp_close($conn_id);

        if (!$ftpsuccess1 || !$ftpsuccess2 || !$ftpsuccess3) {
            $ftpsuccess = false;
        }

        return $ftpsuccess;
    }

    /**
     * Method to build filepath
     *
     * @param	array $file  File details.
     * @param string $type
     * @param int $serverid
     * @param int $folderid
     * @param	int $path The path id.
     * @param	bolean $flash	Sets whether this is a flash upload or normal php upload and chooses right path through function.
     *
     * @return	array
     */
    public function buildpath($file, $type, $serverid, $folderid, $path, $flash = 0) {
        JTable::addIncludePath(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'tables');
        $filepath = JTable::getInstance('Server', 'Table');
        $filepath->load($serverid);
        $folderpath = JTable::getInstance('Folder', 'Table');
        $folderpath->load($folderid);
        //  $folder = $filepath->server_path.$folderpath->folderpath;
        $folder = $folderpath->folderpath;
        $filename->type = $filepath->type;
        $filename->ftphost = $filepath->ftphost;
        $filename->ftpuser = $filepath->ftpuser;
        $filename->ftppassword = $filepath->ftppassword;
        $filename->ftpport = $filepath->ftpport;
        $filename->aws_key = $filepath->aws_key;
        $filename->aws_secret = $filepath->aws_secret;
        $filename->aws_bucket = $filepath->server_path . $folderpath->folderpath;

        //sanitise folder
        //remove last / if present from folder

        $last1 = substr($folder, -1);
        if ($last1 == '/') {
            $folder = substr_replace($folder, "", -1);
        }

        //remove first / if present from folder

        $first = substr($folder, 0, 1);
        if ($first == '/') {
            $folder = substr_replace($folder, '', 0, 1);
        }

        //   $pre = PIHelperadmin::buildprefix($type, $media, $id);
        //This removes any characters that might cause headaches to browsers. This also does the same thing in the model
        $badchars = array(' ', '\'', '"', '`', '@', '^', '!', '#', '$', '%', '*', '(', ')', '[', ']', '{', '}', '~', '?', '>', '<', ',', '|', '\\', ';', '&', '_and_');

        if ($flash == 0) {
            $file['name'] = str_replace($badchars, '_', $file['name']);
            $filename->file = JFILE::makeSafe($file['name']);
        }

        if ($flash == 1) {
            $file = str_replace($badchars, '_', $file);
            $filename->file = JFILE::makeSafe($file);
        }
        if ($filename->type == 2) {
            $filename->path = $folder . '/' . $filename->file;
        } else {
            $filename->path = JPATH_SITE . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename->file;
            //   $filename->path =  $folder . '/' . $filename->file;
        }

        return $filename;
    }

    /**
     * AWS
     * @param string $file
     * @param string $filename
     * @param string $admin
     * @return boolean
     */
    public function aws($file, $filename, $admin = 0) {
        $app = JFactory::getApplication();
        $awssuccess = true;
        $awssuccess5 = true;
        $awssuccess1 = true;
        $awssuccess2 = true;
        $awssuccess3 = true;
        $awssuccess4 = true;
        $aws_key = $filename->aws_key;
        $aws_secret = $filename->aws_secret;

        $source_file = $file; // file to upload to S3

        jimport('joomla.filesystem.file');
        $ext = JFile::getExt($filename->file);

        if ($ext == 'jpg') {
            $file_type = 'image/jpg';
        } elseif ($ext == 'png') {
            $file_type = 'image/png';
        } elseif ($ext == 'gif') {
            $file_type = 'image/gif';
        } else {

            if (!$file_type) {
                $file_type = 'binary/octet-stream';
            }
        }

        $aws_bucket = $filename->aws_bucket; // AWS bucket
        $aws_object = $filename->file;         // AWS object name (file name)


        if (strlen($aws_secret) != 40) {
            if ($admin == 0) {
                $app->enqueueMessage(JText::_('JBS_MED_AWS_SECRET_WRONG_LENGTH'), 'error');
            }
            $awssuccess1 = false;
        } else {
            $file_data = file_get_contents($source_file);
            if ($file_data == false) {
                if ($admin == 0) {
                    $app->enqueueMessage(JText::_('JBS_MED_AWS_FAILED_READ_FILE'), 'error');
                }
                $awssuccess2 = false;
            } else {


                // opening HTTP connection to Amazon S3
                $fp = fsockopen("s3.amazonaws.com", 80, $errno, $errstr, 30);
                if (!$fp) {
                    if ($admin == 0) {
                        $app->enqueueMessage(JText::_('JBW_MED_AWS_NOT_OPEN_SOCKET'), 'error');
                    }
                    $awssuccess3 = false;
                } else {


                    // Creating or updating bucket

                    $dt = gmdate('r'); // GMT based timestamp
                    // preparing String to Sign    (see AWS S3 Developer Guide)
                    $string2sign = "PUT


        {$dt}
        /{$aws_bucket}";

                    // preparing HTTP PUT query
                    $query = "PUT /{$aws_bucket} HTTP/1.1
        Host: s3.amazonaws.com
        Connection: keep-alive
        Date: $dt
        Authorization: AWS {$aws_key}:" . JBSUpload::amazon_hmac($string2sign, $aws_secret) . "\n\n";

                    $resp = JBSUpload::sendREST($fp, $query);
                    if (strpos($resp, '<Error>') !== false) {
                        if ($admin == 0) {
                            $app->enqueueMessage(JText::_('JBS_MED_AWS_CANNOT_CREATE_BUCKET'), 'error');
                        }
                        $awssuccess4 = false;
                    } else {
                        // done
                        // Uploading object
                        $file_length = strlen($file_data); // for Content-Length HTTP field

                        $dt = gmdate('r'); // GMT based timestamp
                        // preparing String to Sign    (see AWS S3 Developer Guide)
                        $string2sign = "PUT

        {$file_type}
        {$dt}
        x-amz-acl:public-read
        /{$aws_bucket}/{$aws_object}";

                        // preparing HTTP PUT query
                        $query = "PUT /{$aws_bucket}/{$aws_object} HTTP/1.1
        Host: s3.amazonaws.com
        x-amz-acl: public-read
        Connection: keep-alive
        Content-Type: {$file_type}
        Content-Length: {$file_length}
        Date: $dt
        Authorization: AWS {$aws_key}:" . JBSUpload::amazon_hmac($string2sign, $aws_secret) . "\n\n";
                        $query .= $file_data;

                        $resp = JBSUpload::sendREST($fp, $query);
                        if (strpos($resp, '<Error>') !== false) {
                            if ($admin == 0) {
                                $app->enqueueMessage(JText::_('JBS_MED_AWS_CANNOT_CREATE_FILE'), 'error');
                            }
                            $awssuccess5 = false;
                        }

                        fclose($fp);
                    }
                }
            }
        }

        if (!$awssuccess1 || !$awssuccess2 || !$awssuccess3 || !$awssuccess4 || !$awssuccess5) {
            $awssuccess = false;
        }

        return $awssuccess;
    }

    /**
     * Amazon HMAC
     * @param string $stringToSign
     * @param string $aws_secret
     * @return string
     */
    public function amazon_hmac($stringToSign, $aws_secret) {
        // helper function binsha1 for amazon_hmac (returns binary value of sha1 hash)
        if (!function_exists('binsha1')) {

            /**
             * BinSha1
             * @param string $d
             * @return string
             */
            function binsha1($d) {
                if (version_compare(phpversion(), "5.0.0", ">=")) {


                    return sha1($d, true);
                } else {
                    return pack('H*', sha1($d));
                }
            }

        }

        if (strlen($aws_secret) == 40)
            $aws_secret = $aws_secret . str_repeat(chr(0), 24);

        $ipad = str_repeat(chr(0x36), 64);
        $opad = str_repeat(chr(0x5c), 64);

        $hmac = binsha1(($aws_secret ^ $opad) . binsha1(($aws_secret ^ $ipad) . $stringToSign));
        return base64_encode($hmac);
    }

    /**
     * Send Rest
     * @param string $fp
     * @param string $q
     * @param string $debug
     * @return string
     */
    public function sendREST($fp, $q, $debug = false) {
        if ($debug)
            echo "\nQUERY<<{$q}>>\n";

        fwrite($fp, $q);
        $r = '';
        $check_header = true;
        while (!feof($fp)) {
            $tr = fgets($fp, 256);
            if ($debug)
                echo "\nRESPONSE<<{$tr}>>";
            $r .= $tr;

            if (($check_header) && (strpos($r, "\r\n\r\n") !== false)) {
                // if content-length == 0, return query result
                if (strpos($r, 'Content-Length: 0') !== false)
                    return $r;
            }

            // Keep-alive responses does not return EOF
            // they end with \r\n0\r\n\r\n string
            if (substr($r, -7) == "\r\n0\r\n\r\n")
                return $r;
        }
        return $r;
    }

}