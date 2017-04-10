<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.details.standard');
function PreachitBuildRoute(&$query)
{
    $lang = & JFactory::getLanguage();
    $lang->load('com_preachit');
	$segments = array();
	
	if (isset($query['tmpl'])) {
		if ($query['tmpl'] == 'component')
		{$segments[] = JText::_('COM_PREACHIT_VIEW_POPUP');}
		unset($query['tmpl']);
	}
	
	if (isset($query['view'])) {
		if ($query['view'] == 'videopopup')
		{$segments[] = JText::_('COM_PREACHIT_VIEW_VIDEOPOPUP');}
        elseif ($query['view'] == 'video')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_VIDEO');}
		elseif ($query['view'] == 'audiopopup')
		{$segments[] = JText::_('COM_PREACHIT_VIEW_AUDIOPOPUP');}
        elseif ($query['view'] == 'audio')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_AUDIO');}
        elseif ($query['view'] == 'medialist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_MEDIALIST');}
        elseif ($query['view'] == 'ministry')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_MINISTRY');}
        elseif ($query['view'] == 'ministrylist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_MINISTRYLIST');}
        elseif ($query['view'] == 'podcastlist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_PODCASTLIST');}
        elseif ($query['view'] == 'series')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_SERIES');}
        elseif ($query['view'] == 'seriesedit')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_SERIESEDIT');}
        elseif ($query['view'] == 'serieslist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_SERIESLIST');}
        elseif ($query['view'] == 'studyedit')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_STUDYEDIT');}
        elseif ($query['view'] == 'studylist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_STUDYLIST');}
        elseif ($query['view'] == 'taglist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TAGLIST');}
        elseif ($query['view'] == 'booklist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_BOOKLIST');}
        elseif ($query['view'] == 'datelist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_DATELIST');}
        elseif ($query['view'] == 'teacher')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TEACHER');}
        elseif ($query['view'] == 'teacheredit')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TEACHEREDIT');}
        elseif ($query['view'] == 'teacherlist')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TEACHERLIST');}
        elseif ($query['view'] == 'text')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TEXT');}
        elseif ($query['view'] == 'study')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_STUDY');}
        elseif ($query['view'] == 'studypopup')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_STUDYPOPUP');}
		else {$segments[] = $query['view'];}
		unset($query['view']);
	}
	
	if (isset($query['layout'])) {
		if ($query['layout'] == 'tag')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TAG');}
        elseif ($query['layout'] == 'book')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_BOOK');}
        elseif ($query['layout'] == 'date')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_YEAR');}
        elseif ($query['layout'] == 'media')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_MEDIALIST');}
        elseif ($query['layout'] == 'teacher')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_TEACHER');}
        elseif ($query['layout'] == 'series')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_SERIES');}
        elseif ($query['layout'] == 'ministry')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_MINISTRY');}
        else {$segments[] = $query['layout'];}
		unset($query['layout']);
	}
	
	if (isset($query['id'])) {
		$segments[] = Tewebdetails::getslugstring($query['id']);
		unset($query['id']);
	}
    if (isset($query['teacher'])) {
        $segments[] = Tewebdetails::getslugstring($query['teacher']);
        unset($query['teacher']);
    }
    if (isset($query['series'])) {
        $segments[] = Tewebdetails::getslugstring($query['series']);
        unset($query['series']);
    }
    if (isset($query['ministry'])) {
        $segments[] = Tewebdetails::getslugstring($query['ministry']);
        unset($query['ministry']);
    }
    if (isset($query['asmedia'])) {
        $segments[] = Tewebdetails::getslugstring($query['asmedia']);
        unset($query['asmedia']);
    }
	if (isset($query['controller'])) {
		unset($query['controller']);
	}
	
	if (isset($query['task'])) {
		$segments[] = $query['task'];
		unset($query['task']);
	}
	
	if (isset($query['media'])) {
		if ($query['media'] == 0)
		{$segments[] = 'audio';}
		elseif ($query['media'] == 1)
		{$segments[] = 'video';}
		unset($query['media']);
	}	
	if (isset($query['study'])) {
		$segments[] = Tewebdetails::getslugstring($query['study']);
		unset($query['study']);
	}
    if (isset($query['tag'])) {
        $segments[] = $query['tag'];
        unset($query['tag']);
    }
    if (isset($query['mode'])) {
        if ($query['mode'] == 'listen')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_LISTEN');}
        elseif ($query['mode'] == 'watch')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_WATCH');}
        elseif ($query['mode'] == 'read')
        {$segments[] = JText::_('COM_PREACHIT_VIEW_READ');}
        else {$segments[] = $query['mode'];}
        unset($query['mode']);
    }
    
    if (isset($query['year'])) {
        $segments[] = $query['year'];
        unset($query['year']);
        if (isset($query['month'])) {
            $segments[] = $query['month'];
            unset($query['month']);}
    }
    
    if (isset($query['book'])) {
        $segments[] = $query['book'];
        unset($query['book']);
        if (isset($query['ch'])) {
            $segments[] = $query['ch'];
            unset($query['ch']);}
    }
	
	return $segments;
}

function PreachitParseRoute($segments)
{
    $lang = & JFactory::getLanguage();
    $lang->load('com_preachit');
	$vars = array();
	
		if ($segments[0] == 'download')
		{
			$var['controller'] = 'studylist';
	
			if (isset($segments[0])) {
			$vars['task'] = $segments[0];
			}
			
			if (isset($segments[1])) {
				if ($segments[1] == 'audio')
				{$vars['media'] = 0;}
				elseif ($segments[1] == 'video')
				{$vars['media'] = 1;}
			}
	
			if (isset($segments[2])) {
			$vars['study'] = Tewebdetails::getslugid($segments[2], '#__pistudies', 'study_alias');
			}
		}	
		elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_POPUP'))
		{
			$vars['tmpl'] = 'component';
			
			if (isset($segments[1])) {
			    if ($segments[1] == JText::_('COM_PREACHIT_VIEW_AUDIOPOPUP'))
				{$vars['view'] = 'audiopopup';}
				elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_VIDEOPOPUP'))
				{$vars['view'] = 'videopopup';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_STUDYPOPUP'))
                {$vars['view'] = 'studypopup';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_STUDYEDIT'))
                {$vars['view'] = 'studyedit';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_TEACHEREDIT'))
                {$vars['view'] = 'teacheredit';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_SERIESEDIT'))
                {$vars['view'] = 'seriesedit';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_PODCASTLIST'))
                {$vars['view'] = 'podcastlist';}
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_TEXT'))
                {$vars['view'] = 'text';}    
				else {$vars['view'] = $segments[1];}
			}
			if (isset($segments[2])) {
				if ($segments[2] == 'modal')
				{$vars['layout'] = $segments[2];
				if (isset($segments[3])) 
                {
                    if ($vars['view'] == 'audiopopup' || $vars['view'] == 'videopopup' || $vars['view'] == 'studypopup' || $vars['view'] == 'studyedit' || $vars['view'] == 'text')
				    {$vars['id'] = Tewebdetails::getslugid($segments[3], '#__pistudies', 'study_alias');}
                    elseif ($vars['view'] == 'teacheredit')
                    {$vars['id'] = Tewebdetails::getslugid($segments[3], '#__piteachers', 'teacher_alias');}
                    elseif ($vars['view'] == 'seriesedit')
                    {$vars['id'] = Tewebdetails::getslugid($segments[3], '#__piseries', 'series_alias');}
                }	
				}
                elseif ($segments[2] == 'print')
                {$vars['layout'] = $segments[2];
                if (isset($segments[3])) {
                $vars['id'] = Tewebdetails::getslugid($segments[3], '#__pistudies', 'study_alias');}    
                }
				else {
                    if ($vars['view'] == 'audiopopup' || $vars['view'] == 'videopopup' || $vars['view'] == 'studypopup' || $vars['view'] == 'studyedit' || $vars['view'] == 'text')
                    {$vars['id'] = Tewebdetails::getslugid($segments[2], '#__pistudies', 'study_alias');}
                    elseif ($vars['view'] == 'teacheredit')
                    {$vars['id'] = Tewebdetails::getslugid($segments[2], '#__piteachers', 'teacher_alias');}
                    elseif ($vars['view'] == 'seriesedit')
                    {$vars['id'] = Tewebdetails::getslugid($segments[2], '#__piseries', 'series_alias');}
                    if (isset($segments[3])) {
                    if ($segments[3] == JText::_('COM_PREACHIT_VIEW_LISTEN'))
                    {$vars['mode'] = 'listen';} 
                    elseif ($segments[3] == JText::_('COM_PREACHIT_VIEW_WATCH'))
                    {$vars['mode'] = 'watch';}
                    elseif ($segments[3] == JText::_('COM_PREACHIT_VIEW_READ'))
                    {$vars['mode'] = 'read';} 
                    else {$vars['mode'] = $segments[3];}
                    } 
                }	
				}
		}
        elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_TAGLIST'))
        {
            if (isset($segments[0])) {
            $vars['view'] = 'taglist';
            }
            if (isset($segments[1])) {
            $vars['tag'] = $segments[1];
            }
        }
        elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_PODCASTLIST'))
                {$vars['view'] = 'podcastlist';
                if (isset($segments[1])) {
                $vars['layout'] = $segments[1];}
                }
		else {
			if (isset($segments[0])) {
            if ($segments[0] == JText::_('COM_PREACHIT_VIEW_AUDIO'))
                {$vars['view'] = 'audio';} 
            if ($segments[0] == JText::_('COM_PREACHIT_VIEW_STUDY'))
                {$vars['view'] = 'study';} 
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_MEDIALIST'))
                {$vars['view'] = 'medialist';}
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_MINISTRYLIST'))
                {$vars['view'] = 'ministrylist';} 
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_MINISTRY'))
                {$vars['view'] = 'ministry';} 
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_SERIES'))
                {$vars['view'] = 'series';}    
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_SERIESLIST'))
                {$vars['view'] = 'serieslist';}         
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_STUDYLIST'))
                {$vars['view'] = 'studylist';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_STUDYEDIT'))
                {$vars['view'] = 'studyedit';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_TEACHER'))
                {$vars['view'] = 'teacher';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_TEACHERLIST'))
                {$vars['view'] = 'teacherlist';}  
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_TEXT'))
                {$vars['view'] = 'text';}    
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_VIDEO'))
                {$vars['view'] = 'video';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_BOOKLIST'))
                {$vars['view'] = 'booklist';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_DATELIST'))
                {$vars['view'] = 'datelist';}   
            elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_TEACHEREDIT'))
                {$vars['view'] = 'teacheredit';}
                elseif ($segments[0] == JText::_('COM_PREACHIT_VIEW_SERIESEDIT'))
                {$vars['view'] = 'seriesedit';}
            else {$vars['view'] = $segments[0];}
			}
			if (isset($segments[1])) {
                if ($segments[1] == JText::_('COM_PREACHIT_VIEW_YEAR'))
                {
                    $vars['layout'] = 'date';
                    if (isset($segments[2]))
                    {
                        $vars['year'] = $segments[2];
                    }
                    if (isset($segments[3]))
                    {
                        $vars['month'] = $segments[3];
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_BOOK'))
                {
                    $vars['layout'] = 'book';
                    if (isset($segments[2]))
                    {
                        $vars['book'] = $segments[2];
                    }
                    if (isset($segments[3]))
                    {
                        $vars['ch'] = $segments[3];
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_TAG'))
                {
                    $vars['layout'] = 'tag';
                    if (isset($segments[2]))
                    {
                        $vars['tag'] = $segments[2];
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_TEACHER'))
                {
                    $vars['layout'] = 'teacher';
                    if (isset($segments[2]))
                    {
                        $vars['teacher'] = Tewebdetails::getslugid($segments[2], '#__piteachers', 'teacher_alias');;
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_SERIES'))
                {
                    $vars['layout'] = 'series';
                    if (isset($segments[2]))
                    {
                        $vars['series'] = Tewebdetails::getslugid($segments[2], '#__piseries', 'series_alias');
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_MINISTRY'))
                {
                    $vars['layout'] = 'ministry';
                    if (isset($segments[2]))
                    {
                        $vars['ministry'] = Tewebdetails::getslugid($segments[2], '#__piministry', 'ministry_alias');
                    }
                }
                elseif ($segments[1] == JText::_('COM_PREACHIT_VIEW_MEDIALIST'))
                {
                    $vars['layout'] = 'media';
                    if (isset($segments[2]))
                    {
                        $vars['asmedia'] = Tewebdetails::getslugid($segments[2], '#__pistudies', 'study_alias');;
                    }
                }
                else {
                    $vars['id'] = Tewebdetails::getslugid($segments[1], '#__pistudies', 'study_alias');
                    if (isset($segments[2])) {
                    if ($segments[2] == JText::_('COM_PREACHIT_VIEW_LISTEN'))
                    {$vars['mode'] = 'listen';} 
                    elseif ($segments[2] == JText::_('COM_PREACHIT_VIEW_WATCH'))
                    {$vars['mode'] = 'watch';}
                    elseif ($segments[2] == JText::_('COM_PREACHIT_VIEW_READ'))
                    {$vars['mode'] = 'read';} 
                    else {$vars['mode'] = $segments[2];}
                    } 
                }
            }
		}		

	return $vars;
}