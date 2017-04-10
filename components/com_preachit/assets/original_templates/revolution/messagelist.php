<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// get template params
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
$this->assignRef('params', $params);
// get menu params
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
$this->assignRef('Mparams', $Mparams);
JHTML::_('behavior.modal');
PIHelperadditional::loadsqueeze();
$option = JRequest::getCmd('option');
$bgrd = 1;
// set heading vaiables

$show = $Mparams->get('show_page_heading', 1);
$enttitle = $Mparams->get('page_heading', '');
$pgtitle = $Mparams->get('page_title', '');
if ($enttitle)
{$pgheader = $enttitle;}
else {$pgheader = $pgtitle;}

//run header stuff if not ajax call

if (!$this->ajax)
{?>
    
 <!-- page title -->

<?php /** Begin Page Title **/ if ($show) : ?>
        <h1 class="title"><?php echo $pgheader; ?></h1>
<?php /** End Page Title **/ endif;?>

<?php
// set up the headers for the pages & page id

if ($this->listview == 'messagelist')
{
?>
<!-- set the div and form for the page -->
<div id="messagelist" class="pipage">
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="pimessages">
<?php
echo $this->loadTemplate('messageheader');
}


elseif ($this->listview == 'series')
{
?>
<!-- set the div and form for the page -->
<div id="seriesview" class="pipage">
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="pimessages">
<?php
echo $this->loadTemplate('seriesheader');
}


elseif ($this->listview == 'teacher')
{
?>
<!-- set the div and form for the page -->
<div id="teacherview" class="pipage">
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="pimessages">
<?php
echo $this->loadTemplate('teacherheader');
}


elseif ($this->listview == 'tag')
{
?>
<!-- set the div and form for the page -->
<div id="taglist" class="pipage">
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="pimessages">
<?php
echo $this->loadTemplate('tagheader');
}

elseif ($this->listview == 'media')
{
?>
<!-- set the div and form for the page -->
<div id="medialist" class="pipage">
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="pimessages">
<?php
echo $this->loadTemplate('mediaheader');
}?>

<!-- set list id for use with possible ajax refresh in future -->

<div id="pistudylist">
<?php } ?>

<!-- **pi ajax list break** -->

<!-- loop through the information -->

<?php
if (is_array($this->messages))
{
foreach ($this->messages as $message)
{
// divs for alternate colours if needed

if ($bgrd == 1)
{$alternate = 'piodd';}
if ($bgrd == 0)
{$alternate = 'pieven';}
$this->assignref('alternate', $alternate);

// get the right image

if ($this->listview == 'messagelist')
{if ($params->get('listimage', '1') == 2)
{ $image = $message->timagemed;}
else if ($params->get('listimage', '1') == 3)
{ $image = $message->simagemed;}
else if ($params->get('listimage', '1') == 4)
{ $image = $message->mimagemed;}
else {$image = '';}
}

elseif ($this->listview == 'series')
{$listimage = $params->get('seriesimage', '1');
if ($listimage == 2)
{ $image = $message->mimagemed;}
elseif ($listimage == 3)
{ $image = $message->timagemed;}
else {$image = '';}}

elseif ($this->listview == 'teacher')
{$listimage = $params->get('teacherimage', '1');
if ($listimage == 2)
{ $image = $message->mimagemed;}
elseif ($listimage == 3)
{ $image = $message->simagemed;}
else {$image = '';}
}

elseif ($this->listview == 'tag')
{$listimage = $params->get('tagmediaimage', '1');
if ($listimage == 2)
{ $image = $message->timagemed;}
else if ($listimage == 3)
{ $image = $message->simagemed;}
else if ($listimage == 4)
{ $image = $message->mimagemed;}
else {$image = '';}
}

elseif ($this->listview == 'media')
{$listimage = $params->get('asmediaimage', '1');
if ($listimage == 2)
{ $image = $message->timagemed;}
else if ($listimage == 3)
{ $image = $message->simagemed;}
else if ($listimage == 4)
{ $image = $message->mimagemed;}
else {$image = '';}
}

$this->assignref('image', $image);



// load message item template

$this->message=$message;
echo $this->loadTemplate('item');

$bgrd = 1 - $bgrd; 
} 
}
else {
	
// echo the right message	
	if ($this->listview == 'messagelist')
	{
	echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_ML').'</div>';}
	elseif ($this->listview == 'seriesview')
	{echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_SV').'</div>';}
	elseif ($this->listview == 'teacherview')
	{echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_TV').'</div>';}
	elseif ($this->listview == 'medialist')
	{echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_MEDL').'</div>';}
	}

?>

<!-- Pagination -->

<?php
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');

if ($params->get('ajaxrefresh', 0) == 1)
{$ajax = 1;}
else {$ajax = '';}

$pagination = PIHelperadditional::pagination($ajax);
 ?>
 
<?php echo $pagination;?>

<!-- **pi ajax list break** -->

<!-- run footer stuff if not an ajax call -->

<?php
if (!$this->ajax)
{?>

</div>

<!-- backlink -->
<?php if (isset($this->backlink))
{echo $this->backlink;}?> 

<!-- powered by notice -->

<?php echo $this->powered_by;?>

</form>

<?php
if ($params->get('ajaxrefresh', 0) == 1)
{?>
 <!-- load revolving gif image into memory with display none so not shown -->
 <img id="pirevolvegif" style="display:none;" src="components/com_preachit/assets/images/ajax-loader.gif">
<?php } ?>
</div>

<?php } ?>