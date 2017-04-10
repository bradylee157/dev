<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.checks.standard');
class Tewebadmin
{

/**
     * Method to publish or unpublish a record
     *
     * $param string $table name of the table to affect
     *
     * @return    string
     */
     
function publish($table, $context = null)
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$cid = JRequest::getVar('cid', array());
$row =& JTable::getInstance($table, 'Table');
$publish = 1;
// check task and act accordingly
if($this->getTask() == 'unpublish')
{$publish = 0;}
//set the publish value
if (!$row->publish($cid, $publish))
{JError::raiseError(500, $row->getError() );}
// check whether plural of message needed
if (count($cid) > 1)
{$msg = JText::_('LIB_TEWEB_MESSAGE_DETAILS');}
else
{$msg = JText::_('LIB_TEWEB_MESSAGE_DETAIL');}
// assign right ending to message
if ($this->getTask() == 'unpublish')
{$msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_UNPUBLISHED');}
else
{$msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_PUBLISHED');}

$app->enqueueMessage ( $msg, 'message' );

Tewebadmin::runfinderplugins('onContentChangeState', $context, $cid, $publish);

return true;
}

/**
     * Method to remove a record
     *
     * @param string $table name of the table to affect
     * @return    string
     */
     
function remove($table, $context = null)
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$cid = JRequest::getVar('cid', array(0));
$row =& JTable::getInstance($table, 'Table');
foreach ($cid as $id)
{
    $id = (int) $id;
    Tewebadmin::runfinderplugins('onContentAfterDelete', $context, $id, null);
    if (!$row->delete($id))
    {JError::raiseError(500, $row->getError() );}
}
// check whether plural of message needed
if (count($cid) > 1)
{
    $msg = JText::_('LIB_TEWEB_MESSAGE_DETAILS');}
else
{$msg = JText::_('LIB_TEWEB_MESSAGE_DETAIL');}	

$app->enqueueMessage ( $msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_DELETED'), 'message' ); 

return true;

}

/**
     * Method to remove a record
     *
     * @param string $table name of the table to affect
     * @param string $dtable database table
     * @return    string
     */
     
function trash ($table, $dtable, $context = null)
{
JRequest::checkToken() or jexit( 'Invalid Token' );
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$db =& JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0));
$row =& JTable::getInstance($table, 'Table');
foreach ($cid as $id)
{
    $id = (int) $id;	
	$db->setQuery ("UPDATE ".$dtable." SET published = -2 WHERE id = '{$id}' ;"); 
					$db->query();
}

$s = '';
// check whether plural of message needed
if (count($cid) > 1)
{$msg = JText::_('LIB_TEWEB_MESSAGE_DETAILS');}
else
{$msg = JText::_('LIB_TEWEB_MESSAGE_DETAIL');}   
$app->enqueueMessage ( $msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_TRASHED'), 'message' ); 

Tewebadmin::runfinderplugins('onContentChangeState', $context, $cid, -2);
	
return true;
}

/**
	 * Method to get post or JForm array depending on Jversion
	 *
	 * @param string $table table name
     * @param unknown type $model model to get form and validate if needed
     * @param string $url url to redirect minus the id number
	 *
	 * @return	array
	 */	

function getformdetails($table, $model = null, $url = null)
{
$app = JFactory::getApplication();
$bind = JRequest::getVar('jform', array(), 'post', 'array');
$row =& JTable::getInstance($table, 'Table');
if ($model)
{
    $form = $model->getForm();
    if (!$form) {
        JError::raiseError(500, $model->getError());
        return false;
    }
    $data = $model->validate($form, $bind);
    if ($data === false) {
    // Get the validation messages.
        $errors    = $model->getErrors();
        $fail = null;
        // Push up to three validation messages out to the user.
        for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
            if ($errors[$i] instanceof Exception) {
                $fail .= $errors[$i]->getMessage().'<br />';
                
            } else {
                $fail .= $errors[$i].'<br />';
                    }
            }
    $app->enqueueMessage ( $fail, 'warning' );
    // Redirect back to the edit screen.
    $app->Redirect(JRoute::_($url.$bind['id'], false));
    return false;
    }    
}
if (!$row->bind($bind))
{JError::raiseError(500, $row->getError() );}
return $row;
}

/**
     * Method to set the menu on the page
     * @param string $component component name without the com_ and first letter capitalised
     * @return    string
     */

function setmenu($component)
{
require_once JPATH_COMPONENT.'/helpers/'.strtolower($component).'.php';
$functionname = $component.'Helper::addSubmenu';
call_user_func($functionname);
return true;
}

/**
     * Method to change the order
     *
     * @param string $table name of the table to affect
     * @param string $task orderup or orderdown
     * @return    string
     */
     
function order($table, $task, $where = null)
{
$cid = JRequest::getVar('cid', array(0));
$id = (int) $cid[0];
$row =& JTable::getInstance($table, 'Table');
$row->load($id);
if ($task == 'orderdown') 
{$dir = 1;} 
else 
{$dir = -1;}
$row->move($dir, $where);
return true;	
}

/**
     * Method to save order in a form
     *
     * @param string $table name of the table to affect
     * @return    string
     */
     
function saveorder($table)
{
$app = JFactory::getApplication();
$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
JArrayHelper::toInteger($cid);
if (empty( $cid )) 
{return JError::raiseWarning( 500, JText::_('LIB_TEWEB_NO_RECORDS_SELECTED') );}
$total = count( $cid );
$row =& JTable::getInstance($table, 'Table');
$order = JRequest::getVar( 'order', array(0), 'post', 'array' );
JArrayHelper::toInteger($order);
// update ordering values
for ($i = 0; $i < $total; $i++)
{
	$row->load( (int) $cid[$i] );
	if ($row->ordering != $order[$i])
		{
			$row->ordering = $order[$i];
			if (!$row->store()) 
				{
					return JError::raiseWarning( 500, $db->getErrorMsg() );
				}
		}
}
$app->enqueueMessage ( $msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_ORDER_CHANGED'), 'message' );
return true;
}

/**
     * Method to reset hits
     *
     * @param string $dtable database table
     * @return    string
     */
     
function resethits($dtable)
{   
    $app = JFactory::getApplication();
	$db =& JFactory::getDBO();
	
	$query = "SELECT id FROM ".$dtable; 
	$db->setQuery($query);
	$resets = $db->loadObjectList();
	
	foreach ($resets as $reset)
	
		{
			$db->setQuery ("UPDATE ".$dtable." SET hits = 0 WHERE id = '{$reset->id}' ;"); 
					$db->query();
		}
	$app->enqueueMessage ( $msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_HITS_RESET'), 'message' );
	
	return true;
	
}

/**
     * Method to reset downloads
     *
     * @param string $dtable database table
     * @return    string
     */
function resetdownloads($dtable)
{   
    $app = JFactory::getApplication();
	$db =& JFactory::getDBO();
	
	$query = "SELECT id FROM ".$dtable; 
	$db->setQuery($query);
	$resets = $db->loadObjectList();
	
	foreach ($resets as $reset)
	
		{
			$db->setQuery ("UPDATE ".$dtable." SET downloads = 0 WHERE id = '{$reset->id}' ;"); 
					$db->query();
		}
	$app->enqueueMessage ( $msg .= ' '.JText::_('LIB_TEWEB_MESSAGE_DOWNLOADS RESET'), 'message' );
	
	return true;
	
}

/**
     * Method to set published for new record
     *
     * @param array $row details from form
     * @return    string
     */
function setstate($row, $component)
{
    $user = JFactory::getUser();
    if ($row->id < 1 && !$user->authorize('core.edit.state', $component))
    {$row->published = 0;}
    return $row;   
}

/**
     * Method to run finder plugin when called
     * @param string $event plugin event to trigger
     * @param strign $context context of plugin call
     * @param array $row details from form
     * $param boolean $isNew toggles is new setting
     * @return    boolean
     */
function runfinderplugins($event, $context, $row, $isNew)
{
    $jversion = Tewebcheck::getJversion();
    
    // check finder is active
        $db =& JFactory::getDBO();
        $query = "
        SELECT ".$db->nameQuote('enabled')."
        FROM ".$db->nameQuote('#__extensions')."
        WHERE ".$db->nameQuote('name')." = ".$db->quote('plg_content_finder').";
        ";
        $db->setQuery($query);
        $finder = $db->loadResult();    
    
    if ($context && $jversion >= 2.5 && $finder == 1)
    {
        $dispatcher = JDispatcher::getInstance();
        // Include the content plugins for the on save events.
        JPluginHelper::importPlugin('content');
        
        // Trigger the onContentBeforeSave event.
            $result = $dispatcher->trigger($event, array($context, &$row, $isNew));
            if (in_array(false, $result, true))
            {
                $this->setError($row->getError());
                return false;
            }
    }
    return true;
}

/**
     * Method to process unique alias''
     * @param string $dtable database table to search
     * @param string $alias alias string to process
     * @param int $id record id
     * @param string $column alias column in table
     * @return    string
     */
function uniquealias($dtable, $alias, $id, $column = 'alias')
{
    $app = JFactory::getApplication();   
    $db=& JFactory::getDBO();
    jimport( 'joomla.filter.output' );
    $alias = JFilterOutput::stringURLSafe($alias);
    if ($alias == null)
    {return $alias;}
    $count = 1;
    $i = 0;
    $change = false;
    while ($count > 0)
    {
        if ($i > 0)
        {$test = $alias.$i;}
        else {$test = $alias;}
        $query='SELECT COUNT(*) FROM '.$dtable.' WHERE '.$column.' = '.$db->quote($test);
        $db->setQuery($query);
        $count =  intval($db->loadResult());
        if ((defined('tealiasadmin') && $i == 0 && $count == 1) || (Tewebadmin::checkalias($test, $id, $column, $dtable) && $count == 1))
        {$count = 0;}
        if ($count > 0 && $change == false)
        {
            $app->enqueueMessage ( JText::_('LIB_TEWEB_MESSAGE_ALIAS_MODIFIED'), 'notice' );
            $change = true;
        }
        $i++;
    }
    return $test;
}

function checkalias($alias, $id, $column, $dtable)
{
    $db =& JFactory::getDBO();
        $query = "
        SELECT ".$db->nameQuote($column)."
        FROM ".$db->nameQuote($dtable)."
        WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
        ";
        $db->setQuery($query);
        $test = $db->loadResult(); 
        if ($test == $alias)
        {return true;}
        else {return false;}
}

}
