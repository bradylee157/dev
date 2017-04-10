<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DIRECTORY_SEPARATOR.'com_preachit'.DIRECTORY_SEPARATOR.'tables');

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
	
class PIHelperscripture{	
	
/**
     * Method to get scripture with links if needed
     * @param int $id message id
     * @return   string
     */     
    
public function scripture($id)
{
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

//get Bible book name

$book = PIHelperscripture::getbookname($study->study_book, 'display_name');

$book = PIHelperscripture::getdisplayname($book);

//get 2nd Bible book name

$book2 = PIHelperscripture::getbookname($study->study_book2, 'display_name');

$book2 = PIHelperscripture::getdisplayname($book2);

if ($study->study_book == '67')

{$scripturelink = 'Topical';}
elseif ($study->study_book == '0')
{$scripturelink = '';}
else {

//build scripture reference

$scripture = PIHelperscripture::buildref($study->study_book, $book, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);

//build 2nd scripture reference

$scripturealt = PIHelperscripture::buildref($study->study_book2, $book2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);


//build scripture links

if ($params->get('bible_link', '1') == 1)

{

$lbook = PIHelperscripture::getbookname($study->study_book, 'book_name');

//get 2nd Bible book name

$lbook2 = PIHelperscripture::getbookname($study->study_book2, 'book_name');
	
	if ($params->get('biblelinktype', '1') == 1)
	{		
	if ($study->study_book2 == '0' || $study->study_book2 == '')
		{$scripturegateway = PIHelperscripture::getBGlink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);}
	else {
		$scripturelink1 = PIHelperscripture::getBGlink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);
		$scripturelink2 = PIHelperscripture::getBGlink($scripturealt, $params, $study->study_book2, $lbook2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);
		$scripturegateway = $scripturelink1.' '.JText::_('COM_PREACHIT_AND_SYMBOL').' '.$scripturelink2; 
		}
	}
	
	if ($params->get('biblelinktype', '1') == 2)
	{
			
	if ($study->study_book2 == '0' || $study->study_book2 == '')
		{$scripturegateway = PIHelperscripture::getBiblialink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);}
	else {
		$scripturelink1 = PIHelperscripture::getBiblialink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);
		$scripturelink2 = PIHelperscripture::getBiblialink($scripturealt, $params, $study->study_book2, $lbook2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);
		$scripturegateway = $scripturelink1.' '.JText::_('COM_PREACHIT_AND_SYMBOL').' '.$scripturelink2; 
		}
	}
	
	if ($params->get('biblelinktype', '1') == 3)
	{
			
	if ($study->study_book2 == '0' || $study->study_book2 == '')
		{$scripturegateway = PIHelperscripture::getYouversionlink($scripture, $study->study_book, $study->ref_ch_beg, $study->ref_vs_beg, $params);}
	else {
		$scripturelink1 = PIHelperscripture::getYouversionlink($scripture, $study->study_book, $study->ref_ch_beg, $study->ref_vs_beg, $params);
		$scripturelink2 = PIHelperscripture::getYouversionlink($scripturealt, $study->study_book2, $study->ref_ch_beg2, $study->ref_vs_beg2, $params);
		$scripturegateway = $scripturelink1.' '.JText::_('COM_PREACHIT_AND_SYMBOL').' '.$scripturelink2; 
		}
	}
	
}

else

{
	if ($study->study_book2 > 0)
	{$scripturegateway = $scripture.' '.JText::_('COM_PREACHIT_AND_SYMBOL').' ' . $scripturealt;} 
	else {$scripturegateway = $scripture;} 
}


$scripturelink = $scripturegateway;
}

return $scripturelink;
}

/**
     * Method to get scripture without link
     * @param int $id message id
     * @return   string
     */    

public function podscripture($id)
{
$app = JFactory::getApplication();	
$db =& JFactory::getDBO();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

//get Bible book name

$book = PIHelperscripture::getbookname($study->study_book, 'display_name');

$book = PIHelperscripture::getdisplayname($book);

//build scripture reference

if ($study->study_book == '67')

{$scripture = 'Topical';}
elseif ($study->study_book == '0')
{$scripture = '';}

else {$scripture = PIHelperscripture::buildref($study->study_book, $book, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);}

return $scripture;
}

/**
     * Method to get first scripture reference
     * @param int $id message id
     * @return   string
     */    

public function ref1($id)
{
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

//get Bible book name

$book = PIHelperscripture::getbookname($study->study_book, 'display_name');

$book = PIHelperscripture::getdisplayname($book);

if ($study->study_book == '67')

{$scripture = $book;}
elseif ($study->study_book == '0')
{$scripture = '';}

else {$scripture = PIHelperscripture::buildref($study->study_book, $book, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);}

//build scripture links

if ($params->get('bible_link', '1') == 1)
{
	
$lbook = PIHelperscripture::getbookname($study->study_book, 'book_name');

//get 2nd Bible book name

$lbook2 = PIHelperscripture::getbookname($study->study_book2, 'book_name');
	
	if ($params->get('biblelinktype', '1') == 1)
		{		
		$ref1 = PIHelperscripture::getBGlink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);
		}
	
	if ($params->get('biblelinktype', '1') == 2)
		{
		$ref1 = PIHelperscripture::getBiblialink($scripture, $params, $study->study_book, $lbook, $study->ref_ch_beg, $study->ref_vs_beg, $study->ref_ch_end, $study->ref_vs_end);
		}
	if ($params->get('biblelinktype', '1') == 3)
		{
		$ref1 = PIHelperscripture::getYouversionlink($scripture, $study->study_book, $study->ref_ch_beg, $study->ref_vs_beg, $params);
		}
}

else {$ref1 = $scripture;}

return $ref1;
}

/**
     * Method to get second scripture reference
     * @param int $id message id
     * @return   string
     */    

public function ref2($id)
{
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

//get 2nd Bible book name

$book2 = PIHelperscripture::getbookname($study->study_book2, 'display_name');

if ($study->study_book == '67')
{$scripturealt = '';}
elseif ($study->study_book2 == '0')
{$scripturealt = '';}

else {$scripturealt = PIHelperscripture::buildref($study->study_book2, $book2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);}

//build scripture links


if ($params->get('bible_link', '1') == 1)
{
	
$lbook = PIHelperscripture::getbookname($study->study_book, 'book_name');

//get 2nd Bible book name

$lbook2 = PIHelperscripture::getbookname($study->study_book2, 'book_name');
	
	
	if ($params->get('biblelinktype', '1') == 1)
		{		
		$ref2 = PIHelperscripture::getBGlink($scripturealt, $params, $study->study_book2, $lbook2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);
		}
	
	if ($params->get('biblelinktype', '1') == 2)
		{
		$ref2 = PIHelperscripture::getBiblialink($scripturealt, $params, $study->study_book2, $lbook2, $study->ref_ch_beg2, $study->ref_vs_beg2, $study->ref_ch_end2, $study->ref_vs_end2);
		}
	if ($params->get('biblelinktype', '1') == 3)
		{
		$ref2 = PIHelperscripture::getYouversionlink($scripturealt, $study->study_book2, $study->ref_ch_beg2, $study->ref_vs_beg2, $params);
		}
}

else {$ref2 = $scripturealt;}

return $ref2;
}

/**
     * Method to get second scripture reference preceded by and
     * @param int $id message id
     * @return   string
     */    

public function ref2and($id)
{
$option = 'com_preachit';
$db =& JFactory::getDBO();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();

$study =& JTable::getInstance('Studies', 'Table');

$study->load($id);

$ref2 = PIHelperscripture::ref2($study->id); 

if ($study->study_book2 == '0')
{$ref2and = '';}
else {
$ref2and = JText::_('COM_PREACHIT_AND_SYMBOL').' '.$ref2;}

return $ref2and;

}

/**
     * Method to build raw date into readable reference
     * @param int $id message id
     * @param string $book book name
     * @param int $ch1 first chapter in reference
     * @param int $vs1 first verse in reference
     * @param int $ch2 second chapter in reference
     * @param int $vs2 second verse in reference
     * @return   string
     */    

private function buildref($id, $book, $ch1, $vs1, $ch2, $vs2)
{
	$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
$sep = $params->get('bible_sep', ':');	
if ($id == '0')
{
$scripture = '';	
}
else {
	
if ($ch1 > 0 && $ch1 == $ch2) {
	if ($vs1 == $vs2)
		{$scripture = $book . ' ' . $ch1 . $sep . $vs1;}
	else {$scripture = $book . ' ' . $ch1 . $sep . $vs1 . '-' . $vs2; }}
	
elseif ($ch2 == 0 && $ch1 > 0 && $vs1 > 0)
		{$scripture = $book . ' ' . $ch1 . $sep . $vs1;}
		
elseif ($ch2 == 0 && $ch1 > 0 && $vs1 == 0)
		{$scripture = $book . ' ' . $ch1;}		
		
elseif ($ch2 > 0 && $ch1 > 0 && $vs1 == 0 && $vs2 == 0)
		{$scripture = $book . ' ' . $ch1 . '-' . $ch2;}

elseif ($ch1 == 0)
		{$scripture = $book;}
	
else {$scripture = $book . ' ' . $ch1 . $sep . $vs1 . '-' . $ch2 . $sep . $vs2; }
}

return $scripture;

}

/**
     * Method to build bible gateway link
     * @param string $scripture scripture reference
     * @param unknown_type $params template params
     * @param int $id message id
     * @param string $book book name
     * @param int $ch1 first chapter in reference
     * @param int $vs1 first verse in reference
     * @param int $ch2 second chapter in reference
     * @param int $vs2 second verse in reference
     * @return   string
     */    

private function getBGlink($scripture, $params, $id, $book, $ch1, $vs1, $ch2, $vs2)
{
	$scripturelinkfill = "'width=1050,height=650,scrollbars=1'";
	$linkbvers = PIHelperscripture::buildref($id, $book, $ch1, $vs1, $ch2, $vs2);
	$biblevers = PIHelperscripture::getbiblevers($params);
    $modal = PIHelperscripture::getmodal($params);
    if ($modal != null)
    {$js = $modal;}
    else $js = 'onclick="window.open(this. href,this.target,' . $scripturelinkfill . ');return false;"';
	
	$scripturelink = '<a '.$js.' target="_blank" href="http://www.biblegateway.com/passage/?search=' . $linkbvers . '&version='.$biblevers.'">' 
		. $scripture . '</a>';
		
	return $scripturelink;
}

/**
     * Method to build Bibia.com link
     * @param string $scripture scripture reference
     * @param unknown_type $params template params
     * @param int $id message id
     * @param string $book book name
     * @param int $ch1 first chapter in reference
     * @param int $vs1 first verse in reference
     * @param int $ch2 second chapter in reference
     * @param int $vs2 second verse in reference
     * @return   string
     */    


private function getBiblialink($scripture, $params, $id, $book, $ch1, $vs1, $ch2, $vs2)
{
	$linkbvers = PIHelperscripture::buildref($id, $book, $ch1, $vs1, $ch2, $vs2);
	$sep = $params->get('bible_sep', ':');	
	$linkbvers = str_replace($sep, '.', $linkbvers);
	$linkbvers = htmlentities($linkbvers);
	$biblevers = PIHelperscripture::getbiblevers($params);
    $modal = PIHelperscripture::getmodal($params);

	$scripturelink = '<a target="_blank"'.$modal.' href="http://biblia.com/bible/'.$biblevers.'/' . $linkbvers . '">' 
		. $scripture . '</a>';
		
		return $scripturelink;
}

/**
     * Method to build you version link
     * @param string $scripture scripture reference
     * @param int $id message id
     * @param int $ch first chapter in reference
     * @param int $vs first verse in reference
     * @param unknown_type $params template params
     * @return   string
     */    


private function getYouversionlink($scripture, $id, $ch, $vs, $params)
{
	$db =& JFactory::getDBO();	
	
	// get shortform
    
    $sform = PIHelperscripture::getbookname($id, 'shortform');
	
	if ($vs == 0)
	{$vs = 1;}
	$modal = PIHelperscripture::getmodal($params);
	$biblevers = strtolower(PIHelperscripture::getbiblevers($params));
	$scripturelink = '<a target="_blank"'.$modal.'  href="http://www.youversion.com/bible/'. $biblevers . '/' . $sform . '/'. $ch .'/'. $vs . '">' 
		. $scripture . '</a>';
		
		return $scripturelink;
}

/**
     * Method to get bible version from params
     * @param unknown_type $params template params
     * @return   string
     */    

private function getbiblevers($params)
{
	$biblevers = $params->get('bible_version', 'NIV');
	return $biblevers;
}

/**
     * Method to get display name from database or translation
     * @param string $name Bible book name
     * @param boolean $translate override selection to translate or get from database
     * @return   string
     */    

public function getdisplayname($name, $translate = null)
{
	if (!$translate)
	{$translate = PIHelperadditional::translate();}
	if ($translate == 1)
	{
		$option = JRequest::getCmd('option');
		if ($option != 'com_preachit')
		{$lang = & JFactory::getLanguage();
  		$lang->load('com_preachit');}
		$name = str_replace(' ', '_', $name);
		$name = JText::_($name);
	}
	return $name;
}

/**
     * Method to get list of books
     * @return   array
     */    

public function getbooklist()
{
	$translate = PIHelperadditional::translate();
	$db =& JFactory::getDBO();
	$db->setQuery('SELECT id AS value, display_name AS text FROM #__pibooks WHERE published = 1');
	$list = $db->loadObjectList();
	if ($translate == 1)
	{
		$i = 0;
		foreach ($list AS $bl)
		{
			$booklist[$i]->value = $bl->value;
			$booklist[$i]->text = PIHelperscripture::getdisplayname($bl->text, $translate);
			$i++;
		}
		return $booklist;
	}
	else {return $list;}
}

/**
     * Method to determine whether link should be in modal window or not
     * @param unknown_type $params template params
     * @return   string
     */    

private function getmodal($params)
{
    $modal = null;
    if ($params->get('bible_link_modal', 0) == 1)
    {
        $modal = ' onclick="SqueezeBox.setContent( \'iframe\', this.href ); return false;"';
    }
    return $modal;
}
/**
     * Method to get book name
     * @param int
     * @param string search value
     * @return   string
     */  
public function getbookname($id, $column)
{
    $db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote($column)."
    FROM ".$db->nameQuote('#__pibooks')."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
  ";
  $db->setQuery($query);

  $book = $db->loadResult();
  return $book;
}

}
?>