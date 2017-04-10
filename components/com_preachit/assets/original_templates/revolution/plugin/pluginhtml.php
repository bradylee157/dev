<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class PIpluginhtml{

/**
     * Method to get html for a list entry using the content plugin
     *
     * @param array $message array containing the message details
     * @param array $params array containing the template parameters
     * @param array $pluginParams array containing the plugin parameters
     * @return   string
     */
    
function getlisthtml($message, $params, $pluginParams)
{
    // build html
    
    $html = '';                
                                
$html = '<div id="messagelist"><div class="listblock">';
    
    //message title
    
    if($pluginParams->get('title', 1) == 1)
    
    {$html.= '<div class="study_name">'.$message->name.'</div>';}

            
    //message date
        
    if ($pluginParams->get('date', '1') == '1')
    {
        if ($message->date)
            
            {$html.= '<div class="date">'.$message->date.'</div>';}
    }

    
    //message info
    
    $html.= '<div class="study_info">';
        
        if ($pluginParams->get('teacher', '1') == '1')
        {  
            if ($message->teachername)
                
                {$html.= '<div class="teacher">'.JText::_('COM_PREACHIT_BY').' <span>'.$message->teachername.'</span></div>';}
                
        }

        if ($pluginParams->get('scripture', '1') == '1')
        {        
            if ($message->scripture)
            
                {$html.= '<div class="scripture">'.JText::_('COM_PREACHIT_Passage').': <span>'. $message->scripture .'</span></div>';}
        
        }
        
        if ($pluginParams->get('series', '1') == '1')
        {
            if ($message->seriesname)
            
                {$html.= '<div class="series">'.JText::_('COM_PREACHIT_Series').': <span>'.$message->seriesname.'</span></div>';}
        
        }
        
        if ($pluginParams->get('duration', '1') == '1')
        {
            if ($message->duration)
            
                {$html.= '<div class="duration">'.JText::_('COM_PREACHIT_Duration').': <span>'.$message->duration.'</span></div>';}

        }
        
    $html.='</div>';
    
    //message description
    
    if ($pluginParams->get('description', '1') == '1')
    {
        if ($message->description)
        
            {$html.= '<div class="study_description">'.$message->description.'</div>';}

    }
    
    if ($params->get('commentcount_studylist', '1') == '1')
    {
        if ($message->commentno) 
        {
            $html .= $message->commentno;
        }
    }  
    
    //links
    
    if ($pluginParams->get('links', '1') == '1' || $pluginParams->get('share', '1') == '1')
    {
    $html.= '<div class="medialinks">';
    
        //share link
    
        if ($pluginParams->get('share', '1') == '1')
        {
            if ($message->share)
            
                {$html.= '<div class="share">'.$message->share.'</div>';}

        }
        
        //media links
        
        if ($pluginParams->get('links', '1') == '1')
        {
    
        if ($message->linkwatch || $message->downloadvid || $message->purchasevid)
        {
            $html.= '<span class="videolinks">'.JText::_('COM_PREACHIT_Video').':'.$message->linkwatch.$message->downloadvid.$message->purchasevid.'</span>';
        }
        
        if ($message->linklisten || $message->downloadaud || $message->purchaseaud)
        {    
            $html.= '<span class="audiolinks">'.JText::_('COM_PREACHIT_Audio').':'. $message->linklisten.$message->downloadaud.$message->purchaseaud.'</span>';
        }    
        
        if ($message->linktext || $message->linknotes)
        {        
        $html.= '<span class="textlinks">'.JText::_('COM_PREACHIT_Text').':'.$message->linktext.$message->linknotes.'</span>';
        }    
        
        }
        
    $html.= '</div>';
    }
    
    $html.= '</div></div>';        
                
  return $html;
}
    
/**
     * Method to get html for a video entry using the content plugin
     *
     * @param array $message array containing the message details
     * @param string $media contains the code for the media player
     * @param array $params array containing the template parameters
     * @param array $pluginParams array containing the plugin parameters
     * @return   string
     */   
    
function getvideohtml($message, $media, $params, $pluginParams)
{

// build html

$html = '';

$html = '<div id="audioview" class="page">';

    //title & date
    
    if($pluginParams->get('title', 1) ==1 || $pluginParams->get('date', 1) == 1)
    {
    $html.='<div class="topbar">';
    
        if ($pluginParams->get('date', 1) == 1)
        {
            $html.='<div class="date">'.$message->date.'</div>';
        }
        
        if($pluginParams->get('title', 1) ==1)
        {
            $html.='<h1 class="study_name">'.$message->name.'</h1>';
        }
            
    $html.='</div>';
    }

    //scripture & teacher name

    if($pluginParams->get('teacher', 1) ==1 || $pluginParams->get('scripture', 1) == 1)
    {
    $html.='<div class="subtitle">';
        if ($pluginParams->get('scripture', 1) == 1)
        {
            if ($message->scripture)
            
                {$html.=$message->scripture;}
                
        }
        
        if ($pluginParams->get('teacher', 1) == 1)
        {
            if ($message->teachername)
            
                {$html.=' '.JText::_('COM_PREACHIT_BY').' '.$message->teachername;}
        }
    
    $html.='</div>';
    }

    //media

    $html.=PIHelperadditional::showpluginmediaplayer($message->videoplayer);

    //message description
    
    if ($pluginParams->get('description', 1) == 1)
    {

        if ($message->description)
    
            {$html.='<div class="study_description">'.$message->description.'</div>';}

    }

    //series name

    if ($pluginParams->get('series', 1) == 1)
    {

        if ($message->seriesname)
    
            {$html.='<div class="series">'.JText::_('COM_PREACHIT_SERIES').':'.'<span>'.$message->seriesname.'</span></div>';}

    }

    //message duration

    if ($pluginParams->get('duration', 1) == 1)
    {

        if ($message->duration)
        
            {$html.='<div class="duration">'.JText::_('COM_PREACHIT_DURATION').':'.'<span>'.$message->duration.'</span></div>';}

    }
    
    if ($message->tags && $pluginParams->get('tags', 1) == 1)
    {
        $html .= '<div class="preachittagscontainer">';
        $html .= '<div class="preachittags">'.JText::_('COM_PREACHIT_TAGS').':<span>'.$message->tags.'</span></div>';
        $html .= '</div>';
    }

    //links
    
    if ($pluginParams->get('links', '1') == '1' || $pluginParams->get('share', '1') == '1')
    {
        $html.= '<div class="medialinks">';
    
        //share link
    
        if ($pluginParams->get('share', '1') == '1')
        {
            if ($message->share)
            
                {$html.= '<div class="share">'.$message->share.'</div>';}

        }
        
        //media links
        
        if ($pluginParams->get('links', '1') == '1')
        {
    
        if ($message->downloadvid || $message->purchasevid)
        {
            $html.= '<span class="videolinks">'.JText::_('COM_PREACHIT_VIDEO').':'.$message->downloadvid.$message->purchasevid.'</span>';
        }
        
        if ($message->linklisten || $message->downloadaud || $message->purchaseaud)
        {    
            $html.= '<span class="audiolinks">'.JText::_('COM_PREACHIT_AUDIO').':'. $message->linklisten.$message->downloadaud.$message->purchaseaud.'</span>';
        }    
        
        if ($message->linktext || $message->linknotes)
        {        
        $html.= '<span class="textlinks">'.JText::_('COM_PREACHIT_TEXT').':'.$message->linktext.$message->linknotes.'</span>';
        }    
        
        }
        
    $html.= '</div>';
    }

    $html.= '</div>';        
                
  return $html;
}

/**
     * Method to get html for a audio entry using the content plugin
     *
     * @param array $message array containing the message details
     * @param string $media contains the code for the media player
     * @param array $params array containing the template parameters
     * @param array $pluginParams array containing the plugin parameters
     * @return   string
     */  

function getaudiohtml($message, $media, $params, $pluginParams)
{

// build html

$html = '';

$html = '<div id="audioview" class="page">';

    //title & date
    
    if($pluginParams->get('title', 1) ==1 || $pluginParams->get('date', 1) == 1)
    {
    $html.='<div class="topbar">';
    
        if ($pluginParams->get('date', 1) == 1)
        {
            $html.='<div class="date">'.$message->date.'</div>';
        }
        
        if($pluginParams->get('title', 1) ==1)
        {
            $html.='<h1 class="study_name">'.$message->name.'</h1>';
        }
            
    $html.='</div>';
    }

    //scripture & teacher name

    if($pluginParams->get('teacher', 1) ==1 || $pluginParams->get('scripture', 1) == 1)
    {
    $html.='<div class="subtitle">';
        if ($pluginParams->get('scripture', 1) == 1)
        {
            if ($message->scripture)
            
                {$html.=$message->scripture;}
                
        }
        
        if ($pluginParams->get('teacher', 1) == 1)
        {
            if ($message->teachername)
            
                {$html.=' '.JText::_('COM_PREACHIT_BY').' '.$message->teachername;}
        }
    
    $html.='</div>';
    }

    //media

    $html.=PIHelperadditional::showpluginmediaplayer($message->audioplayer);

    //message description
    
    if ($pluginParams->get('description', 1) == 1)
    {

        if ($message->description)
    
            {$html.='<div class="study_description">'.$message->description.'</div>';}

    }

    //series name

    if ($pluginParams->get('series', 1) == 1)
    {

        if ($message->seriesname)
    
            {$html.='<div class="series">'.JText::_('COM_PREACHIT_SERIES').':'.'<span>'.$message->seriesname.'</span></div>';}

    }

    //message duration

    if ($pluginParams->get('duration', 1) == 1)
    {

        if ($message->duration)
        
            {$html.='<div class="duration">'.JText::_('COM_PREACHIT_DURATION').':'.'<span>'.$message->duration.'</span></div>';}

    }
    
    if ($message->tags && $pluginParams->get('tags', 1) == 1)
    {
        $html .= '<div class="preachittagscontainer">';
        $html .= '<div class="preachittags">'.JText::_('COM_PREACHIT_TAGS').':<span>'.$message->tags.'</span></div>';
        $html .= '</div>';
    }

    //links
    
    if ($pluginParams->get('links', '1') == '1' || $pluginParams->get('share', '1') == '1')
    {
        $html.= '<div class="medialinks">';
    
        //share link
    
        if ($pluginParams->get('share', '1') == '1')
        {
            if ($message->share)
            
                {$html.= '<div class="share">'.$message->share.'</div>';}

        }
        
        //media links
        
        if ($pluginParams->get('links', '1') == '1')
        {
    
        if ($message->linkwatch || $message->downloadvid || $message->purchasevid)
        {
            $html.= '<span class="videolinks">'.JText::_('COM_PREACHIT_Video').':'.$message->linkwatch.$message->downloadvid.$message->purchasevid.'</span>';
        }
        
        if ( $message->downloadaud || $message->purchaseaud)
        {    
            $html.= '<span class="audiolinks">'.JText::_('COM_PREACHIT_Audio').':'. $message->downloadaud.$message->purchaseaud.'</span>';
        }    
        
        if ($message->linktext || $message->linknotes)
        {        
        $html.= '<span class="textlinks">'.JText::_('COM_PREACHIT_Text').':'.$message->linktext.$message->linknotes.'</span>';
        }    
        
        }
        
    $html.= '</div>';
    }

    $html.= '</div>';        
                
  return $html;
}

}

?>