<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JTable::addIncludePath(JPATH_SITE.
DS.'libraries'.DS.'teweb'.DS.'tables');

class Tewebemail{

/**
     * Method to initialise values for e mail functions
     *
     * @return    array
     */    
     
function initialise()
{
    $app = JFactory::getApplication();
    $details->recipient = null;
    $details->emails[0] = $app->getCfg('mailfrom');
    $details->text = null;
    $details->sender = $app->getCfg('mailfrom');
    $details->sendername = $app->getCfg('sitename');
    $details->subject = null;
    return $details;
}

/**
     * Method to get user email
     * @param    int $userid id for the user that we want to add into the array
     * @return    string
     */    
     
function getemail($userid)
{
    $db = JFactory::getDBO();
    $query = "
    SELECT ".$db->nameQuote('email')."
    FROM ".$db->nameQuote('#__users')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($userid).";
     ";
     $db->setQuery($query);
     $email = trim($db->loadResult());
    
    return $email;
}


/**
     * Method to replace bracketed code included in e mail text
     * @param    array $details info for the email
     * @return    bolean
     */   

function sendemail($details, $errors = false)
{
    $app = JFactory::getApplication();
    jimport( 'joomla.mail.helper' );
    $mailer =& JFactory::getMailer();
    $mailer->setSender(array($details->sender, $details->sendername));
    $mailer->setSubject(JMailHelper::cleanSubject($details->subject));
    $mailer->setBody(JMailHelper::cleanBody($details->text));
    $mailer->IsHTML(true);
    foreach ($details->emails as $email) {
            $mailer->addRecipient($email);
        }
    $rs = $mailer->Send();
    
    if ( JError::isError($rs) ) {
        if ($errors)
            {$app->enqueueMessage ( $rs->getError(), 'notice' );}
            return true;
    } elseif(!$rs) {
        if ($errors)
            {$app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_EMAIL_FAILED').' '.$email, 'notice' );}
            return true;
        } 
    
    return true;
}   

/**
     * Method to add email details to the tequeue email queue
     * @param    array $details info for the email
     * @return    bolean
     */   

function sendtoqueue($details)
{
    $details->emails = implode(',', $details->emails);
    $row =& JTable::getInstance('tequeue', 'Table');
    $row->sender = $details->sender;
    $row->sendername = $details->sendername;
    $row->subject = $details->subject;
    $row->text = $details->text;
    $row->emails = $details->emails;
    if (!$row->store())
    {return false;}
    return true;
}  

/**
     * Method to get email details to send from the queue
     * @param    int $limit max number of emails to send
     * @param    boolean $erros whether to displayt errors
     * @return    bolean
     */   

function queuetoemail($errors = false)
{
    $email = false;
    $row =& JTable::getInstance('tequeue', 'Table');
    $id = Tewebemail::getqueueid();
    $row->load($id);
    $row->emails = explode(',', $row->emails);
    if (is_array($row->emails) && count($row->emails > 0))
    {
        $email = Tewebemail::sendemail($row, $errors);
        if ($email)
        {$row->delete($id);}
    }
    else {$row->delete($id);}
    return $email;
}  

/**
     * Method to get id of next line in the queue table
     * @return    int
     */   

function getqueueid()
{
    $db = JFactory::getDBO();
    $query = "SELECT id FROM #__tequeue ORDER BY id LIMIT 1";
    $db->setQuery($query);
    $info = $db->loadObjectlist();
    $id = $info[0]->id;
    return $id;
}  


}