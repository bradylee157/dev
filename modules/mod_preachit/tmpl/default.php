<?php defined( '_JEXEC' ) or die( 'Restricted access' );

$item = $params->get('menuid');
$popup = $params->get('popup');

?>
<div class="pimessages<?php echo $moduleclass_sfx; ?> moddefault">

<?php 


foreach ($list as $study) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_preachit', '_study')); ?>
		
		<?php 

$studyslug = $study->id.':'.$study->study_alias;

        //elements for popup link
$beg = '<span class="videolink">';
$begaud = '<span class="audiolink">';
$meatvideo = "<a href='index.php?option=com_preachit&tmpl=component&id=" .$study->id . "&view=studypopup&mode=watch' onClick='showPopup(this.href);return(false);'>". JText::_("MOD_PREACHIT_WATCH")."</a></span>";
$meataudio = "<a href='index.php?option=com_preachit&tmpl=component&id=" .$study->id . "&view=studypopup&mode=listen' onClick='showPopup(this.href);return(false);'>". JText::_("MOD_PREACHIT_LISTEN")."</a></span>";

//video link
if ($popup == '0')
{$linkvideo = '<span class="videolink"><a href = "' . JRoute::_('index.php?option=com_preachit&id=' . $studyslug . '&view=study&mode=watch&Itemid='.$item) . '" >'. JText::_('MOD_PREACHIT_WATCH').'</a></span>';}
if ($popup == '1')
{$linkvideo = $beg.$meatvideo;}

if ($study->video_link != '') {
$link = $linkvideo;
}
else {
$link = '';
}

//audio link
if ($popup == '0')
{$linkaudio = '<span class="audiolink"><a href = "' . JRoute::_('index.php?option=com_preachit&id=' . $studyslug . '&view=study&mode=listen&Itemid='.$item) . '" >'. JText::_('MOD_PREACHIT_LISTEN').'</a></span>';}
if ($popup == '1')
{$linkaudio = $begaud.$meataudio;}

if ($study->audio_link != '') {
$link2 = $linkaudio;
}
else {
$link2 = '';
} 

if ($study->text == 1) {
$link6 = '<span class="textlink"><a href = "' . JRoute::_('index.php?option=com_preachit&id=' . $studyslug . '&view=study&mode=read&Itemid='.$item) . '" >'. JText::_('MOD_PREACHIT_READ').'</a></span>';
}
else {
$link6 = '';
} 
		
		if ($m == '1')
			{$medialinks = '<div class="medialinks">' . $link . $link2 . $link6 . '</div>';}
			else {$medialinks = '';}
	
		if ($s == '1')
			{$script = '<div class="scripture">' . $scripture . '</div>';}
			else {$script = '';}
	
		if ($t == '1')
			{$teacher = '<div class="teacher">' . $teacher_name . '</div>';}
			else {$teacher = '';}
			
		if ($t == '1' && $ser == '1' && $teacher_name && $series_name)	
		{$join = ' - ';}
		else {$join = '';}	
		
		if ($ser == '1')
			{$series = $join.'<div class="series">' . $series_name . '</div>';}
			else {$series = '';}
		
		if ($d == '1')
			{$date = '<div class="date">' . JHTML::Date($study->study_date, $dateformat) . '</div>';}
			else {$date = '';}?>			
	<div class="blocklist">
        <?php echo $image; ?>
		<div class="studyname"><?php echo $title;?></div>	
		<?php echo $script;?>
		<?php echo $date;?>
		<?php echo $teacher;?>
		<?php echo $series;?>
		<?php echo $medialinks;?>
        <div class="clr"></div>
	</div>

	<?php
}
?>
</div>