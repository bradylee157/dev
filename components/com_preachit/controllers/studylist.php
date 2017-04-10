<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class PreachitControllerstudylist extends JController
{

function comment()
{
JRequest::checktoken() or jexit( 'Invalid Token' );

// get variables

$app = JFactory::getApplication();
$option = JRequest::getCmd('option');

// import files
jimport( 'joomla.mail.helper' );
jimport('teweb.messages.comments');
jimport( 'joomla.html.parameter' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

// get comment details
$row =& JTable::getInstance('comment', 'Table');
$study_id = JRequest::getInt('study_id', 0);
$comment_date = gmdate ( 'Y-m-d H:i:s' );
$item = JRequest::getInt('Itemid', 0);
$view = JRequest::getVar('view','');
$ajax = JRequest::getInt('ajax',0);
$user    = JFactory::getUser();

// get params
$params =& $app->getParams();

// work out if user is authorised to submit comments
$groups = $user->authorisedLevels();
$access = $params->get('access', 1);
if (in_array($access, $groups))
{$allow = true;} else {$allow = false;}

// get model
jimport('teweb.messages.commentsmodel');
$requestData = JRequest::getVar('jform', array(), 'post', 'array');
$form    = Modelcomment::getForm();
if (!$form) {
    JError::raiseError(500, Modelcomment::getError());
    return false;
}
$data    = Modelcomment::validate($form, $requestData);

if ($data === false) {
// Get the validation messages.
    $errors    = Modelcomment::getErrors();
    $fail = null;
    // Push up to three validation messages out to the user.
    for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
        if ($errors[$i] instanceof Exception) {
            $fail .= '<div class="mailitsubfailnotice">'.$errors[$i]->getMessage().'</div>';
        } else {
            $fail .= '<div class="mailitsubfailnotice">'.$errors[$i].'</div>';
        }
    }
    $msg->text = $fail;
    
    if ($ajax == 1)
    {
        echo $msg->text;
    }
    else {$app->enqueueMessage ( $msg->text, 'warning' );}
}
else {

if ($allow)
{  
    $row->bind($requestData);
    $row->study_id = $study_id;
    $row->comment_date = $comment_date;
    // build comment details
        if($user->id)
        {
        $row->user_id = $user->id;}

        if ($row->full_name && $row->email && $row->comment_text)
        {
            if (!$row->store())
            {JError::raiseError(500, $row->getError());}
            $db = JFactory::getDBO();
            $query = "
            SELECT ".$db->nameQuote('study_name')."
            FROM ".$db->nameQuote('#__pistudies')."
            WHERE ".$db->nameQuote('id')." = ".$db->quote($row->study_id).";
            ";
            $db->setQuery($query);
            $article = $db->loadResult();
            $email = Tewebcomments::sendtecommentnotify($row->full_name, $row->comment_text, $article, $params);
            if ($ajax == 1)
            {
                    $msg = JText::_('LIB_TEWEB_COMMENT_ADDED');
                    $divider = '<!-- **comment message break** -->';
                    $details = array();
                    $details[0]->comment_date = $row->comment_date;
                    $details[0]->full_name = $row->full_name;
                    $details[0]->comment_text = $row->comment_text;
                    $comment = Tewebcomments::gettecommentlist($details, $ajax);
                    $divider2 = null;
                    echo $msg.$divider.$comment;
                    }
                 else {$app->enqueueMessage ( JText::_('LIB_TEWEB_COMMENT_ADDED'), 'message' );}
        }
        elseif (!JMailHelper::isEmailAddress($row->email))
        {
            if ($ajax == 1)
            {
                echo JText::_('LIB_TEWEB_COMMENT_FAILED_INVALID_EMAIL');
            }
            else {$app->enqueueMessage ( JText::_('LIB_TEWEB_COMMENT_FAILED_INVALID_EMAIL'), 'notice' );}
        }
        else 
        {
            if ($ajax == 1)
            {
                echo JText::_('LIB_TEWEB_COMMENT_FAILED_NEEDED_INFO');
            }
            else {$app->enqueueMessage ( JText::_('LIB_TEWEB_COMMENT_FAILED_NEEDED_INFO'), 'notice' );}
        }
}
else {
    if ($ajax == 1)
        {
                echo JText::_('LIB_TEWEB_403_ERROR');
        }
        else {$app->enqueueMessage ( JText::_('LIB_TEWEB_403_ERROR'), 'notice' );}
}
}


if ($ajax != 1)
{
    $link = JRoute::_('index.php?option=com_preachit&id=' . $row->study_id . '&view='.$view.'&Itemid='.$item);
    $app->redirect(str_replace("&amp;","&",$link));
}

    
    
}


function download() {
		
		$abspath    = JPATH_SITE;
		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/download.php');
		$task = JRequest::getVar('task');
		if ($task == 'download')
		{
			$download=PIHelperdownload::download();
		 die;
		}
	}

function display()
{
$view = JRequest::getVar('view');
if (!$view) {
JRequest::setVar('view', 'studylist');
}
parent::display();
}
}
