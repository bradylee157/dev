<?php
/**
 * sh404SEF support for com_XXXXX component.
 * Author : Nick Fossen
 * Contact : nfossen@gmail
 * Home URL : http://www.newhorizoncf.org
 * {shSourceVersionTag: Version 1.1 - 2010-01-12}
 *    
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
$lang = & JFactory::getLanguage();
$lang->load('com_preachit', JPATH_SITE);
jimport('teweb.details.standard');
// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - for use language ----------------------------------------
//$shLangIso = shLoadPluginLanguage( 'com_jv_product', $shLangIso, '_SH404SEF_JV_PRODUCT_CREATE_NEW');
// ------------------  load language file - for use language  ----------------------------------------

global $mainframe;

// get DB
$database =& JFactory::getDBO();

$shHomePageFlag = false;

$shHomePageFlag = !$shHomePageFlag ? shIsHomepage ($string): $shHomePageFlag;

if (!$shHomePageFlag) {  // we may have found that this is homepage, so we msut return an empty string
  // do something about that Itemid thing
  if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
    // V 1.2.4.t moved back here
    if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
      $string .= '&Itemid='.$shCurrentItemid; ;  // append current Itemid
      $Itemid = $shCurrentItemid;
      shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
    }

    if ($sefConfig->shInsertTitleIfNoItemid)
    $title[] = $sefConfig->shDefaultMenuItemName ?
  		$sefConfig->shDefaultMenuItemName : getMenuTitle($option, (isset($view) ? @$view : null), $shCurrentItemid, null, $shLangName );  // V 1.2.4.q added forced language
  		$shItemidString = '';
  		if ($sefConfig->shAlwaysInsertItemid && (!empty($Itemid) || !empty($shCurrentItemid)))
    $shItemidString = _COM_SEF_SH_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement
    .(empty($Itemid)? $shCurrentItemid :$Itemid);
  } else {  // if Itemid in non-sef URL
    $shItemidString = $sefConfig->shAlwaysInsertItemid ?
    _COM_SEF_SH_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
    : '';
    if ($sefConfig->shAlwaysInsertMenuTitle){
      //global $Itemid; V 1.2.4.g we want the string option, not current page !
      if ($sefConfig->shDefaultMenuItemName)
      $title[] = $sefConfig->shDefaultMenuItemName;// V 1.2.4.q added force language
      elseif ($menuTitle = getMenuTitle($option, (isset($view) ? @$view : null), $Itemid, '',$shLangName )) {
        //echo 'Menutitle = '.$menuTitle.'<br />';
        if ($menuTitle != '/') $title[] = $menuTitle;
      }
    }
  }
//  echo $view;
//  echo $limit;
//  echo "xxxxx";
//  die;
//	echo $option;
//	$title[]="jvproduct";
  $view = isset($view) ? $view : null;
switch ($view) {
	case 'studylist':
		$title[] = JText::_('COM_PREACHIT_VIEW_STUDYLIST');
        $layout = isset($layout) ? @$layout : null;
        if ($layout)
        {
            if ($layout == 'tag')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_TAG');
                $tag = isset($tag) ? @$tag : null;
                if ($tag)
                {
                      $title[] = $tag;
                }    
            }
            elseif ($layout == 'book')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_BOOK');
                $book = isset($book) ? @$book: null;
                if ($book)
                {
                      $title[] = $book;
                      $ch = isset($ch) ? @$ch: null;
                      if ($ch)
                      {
                          $title[] = $ch;
                      }
                }    
            }
            elseif ($layout == 'date')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_YEAR');
                $year = isset($year) ? @$year: null;
                if ($year)
                {
                      $title[] = $year;
                      $month = isset($month) ? @$month: null;
                      if ($month)
                      {
                          $title[] = $month;
                      }
                }    
            }
            elseif ($layout == 'media')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_MEDIALIST');
                $id = isset($id) ? @$id: null;
                if ($id)
                {
                      $title[] = Tewebdetails::getslugstring($id);
                }    
            }
            elseif ($layout == 'teacher')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_TEACHER');
                $teacher = isset($teacher) ? @$teacher : null;
                if ($teacher)
                {
                      $title[] = Tewebdetails::getslugstring($teacher);
                }    
            }
            elseif ($layout == 'series')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_SERIES');
                $series = isset($series) ? @$series : null;
                if ($series)
                {
                      $title[] = Tewebdetails::getslugstring($series);
                }    
            }
        }
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGETVarsList('Itemid');
		        	
		break;
	case 'ministrylist':
		$title[] = JText::_('COM_PREACHIT_VIEW_MINISTRYLIST');
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGETVarsList('Itemid');
		break;       			
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGetVarsList('id');
//		shRemoveFromGETVarsList('Itemid');
		break;
	case 'study':  // Need to keep the id because of the number of teachings
//		$title[] = $view;
//		$title[] = $id;
//		jos_pistudies
        $title[] = JText::_('COM_PREACHIT_VIEW_STUDY');
		$id = isset($id) ? @$id : null;
        if($id)
        {
		   	$title[] = Tewebdetails::getslugstring($id);
        }
        $mode = isset($mode) ? @$mode : null;
        if($mode)
        {
               if ($mode == 'listen')
               {$title[] = JText::_('COM_PREACHIT_VIEW_LISTEN');}
               elseif ($mode == 'watch')
               {$title[] = JText::_('COM_PREACHIT_VIEW_WATCH');}
               elseif ($mode == 'read')
               {$title[] = JText::_('COM_PREACHIT_VIEW_READ');}
        }
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGetVarsList('id');
//		shRemoveFromGETVarsList('Itemid');
		break;
	case 'studypopup':  // Need to keep the id because of the number of teachings
        $tmpl = isset($tmpl) ? @$tmpl : null;
        if ($tmpl)
        {
            $title[] = JText::_('COM_PREACHIT_VIEW_POPUP');
        }
		$title[] = JText::_('COM_PREACHIT_VIEW_STUDYPOPUP');
		$id = isset($id) ? @$id : null;
        if($id)
        {
               $title[] = Tewebdetails::getslugstring($id);
        }
        $mode = isset($mode) ? @$mode : null;
        if($mode)
        {
               if ($mode == 'listen')
               {$title[] = JText::_('COM_PREACHIT_VIEW_LISTEN');}
               elseif ($mode == 'watch')
               {$title[] = JText::_('COM_PREACHIT_VIEW_WATCH');}
               elseif ($mode == 'read')
               {$title[] = JText::_('COM_PREACHIT_VIEW_READ');}
        }
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGetVarsList('id');
//		shRemoveFromGETVarsList('Itemid');
	break;
	case 'serieslist':
		$title[] = JText::_('COM_PREACHIT_VIEW_SERIESLIST');
        $layout = isset($layout) ? @$layout : null;
        if ($layout)
        {
            if ($layout == 'ministry')
            {
                $title[] = JText::_('COM_PREACHIT_VIEW_MINISTRY');
                $ministry = isset($ministry) ? @$ministry : null;
                if ($ministry)
                {
                      $title[] = Tewebdetails::getslugstring($ministry);
                }    
            }
        }
        
        
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGETVarsList('Itemid');
		break;
	case 'teacherlist':
		$title[] = JText::_('COM_PREACHIT_VIEW_TEACHERLIST');
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGETVarsList('Itemid');
		break;
	case 'podcastlist':
		$title[] = JText::_('COM_PREACHIT_VIEW_PODCASTLIST');;
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGETVarsList('Itemid');
	break;
	case 'studyedit':  // Need to keep the id because of the number of teachings
		$title[] = JText::_('COM_PREACHIT_VIEW_STUDYEDIT');;
		$title[] = Tewebdetails::getslugstring($id);
//		shRemoveFromGETVarsList('view');
//		shRemoveFromGetVarsList('id');
//		shRemoveFromGETVarsList('Itemid');
	break;
    case 'teacheredit':  // Need to keep the id because of the number of teachings
        $title[] = JText::_('COM_PREACHIT_VIEW_TEACHEREDIT');;
        $title[] = Tewebdetails::getslugstring($id);
//        shRemoveFromGETVarsList('view');
//        shRemoveFromGetVarsList('id');
//        shRemoveFromGETVarsList('Itemid');
    break;
    case 'seriesedit':  // Need to keep the id because of the number of teachings
        $title[] = JText::_('COM_PREACHIT_VIEW_SERIESEDIT');;
        $title[] = Tewebdetails::getslugstring($id);
//        shRemoveFromGETVarsList('view');
//        shRemoveFromGetVarsList('id');
//        shRemoveFromGETVarsList('Itemid');
    break;
    case 'booklist':
        $title[] = JText::_('COM_PREACHIT_VIEW_BOOKLIST');
//        shRemoveFromGETVarsList('view');
//        shRemoveFromGETVarsList('Itemid');
        break;
    case 'taglist':
        $title[] = JText::_('COM_PREACHIT_VIEW_TAGLIST');
//        shRemoveFromGETVarsList('view');
//        shRemoveFromGETVarsList('Itemid');
        break;
    case 'datelist':
        $title[] = JText::_('COM_PREACHIT_VIEW_DATELIST');
//        shRemoveFromGETVarsList('view');
//        shRemoveFromGETVarsList('Itemid');
        break;
}

// Change the URL for downloading file
 if(isset($task)){
	 if($task == 'download')
	 {
	 		if($media == '0'){$m = 'audio';}
	 		if($media == '1'){$m = 'video';}
		 $title[] = 'download';
		 $title[] = $m;
		 $title[] = Tewebdetails::getslugstring($study);
		 shRemoveFromGETVarsList('controller');
		 shRemoveFromGETVarsList('task');
		 shRemoveFromGETVarsList('study');
		 shRemoveFromGETVarsList('media');
	 }
 }
  shRemoveFromGETVarsList('option');
  if (!empty($lang))
  	shRemoveFromGETVarsList('lang');
  if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
  if (!empty($limit))
  	$title[]=$limit;
//  shRemoveFromGETVarsList('limit');
  if (isset($limitstart))
    	$title[]=$limitstart;
//  shRemoveFromGETVarsList('limitstart');
  // V 1.2.4.q
  shRemoveFromGETVarsList('view');
  if (isset($id))
  shRemoveFromGETVarsList('id');
    if (isset($layout))
  shRemoveFromGETVarsList('layout');
    if (isset($tmpl))
  shRemoveFromGETVarsList('tmpl');
//  if (isset($layout))
//  shRemoveFromGETVarsList('layout');
  if (isset($task))
  shRemoveFromGETVarsList('task');
  if (isset($teacher))
  shRemoveFromGETVarsList('teacher');
  if (isset($series))
  shRemoveFromGETVarsList('series');
 
 
// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), 
    (isset($shLangName) ? @$shLangName : null), (isset($showall) ? @$showall : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
} else { // this is multipage homepage
  $title[] = '/';
  $string = sef_404::sefGetLocation( $string, $title, null, (isset($limit) ? @$limit : null),
  (isset($limitstart) ? @$limitstart : null), (isset($shLangName) ? @$shLangName : null),
  (isset($showall) ? @$showall : null));
}
?>
