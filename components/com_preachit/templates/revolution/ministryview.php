<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
JHTML::_('behavior.modal');
PIHelperadditional::loadsqueeze();
$option = JRequest::getCmd('option');
$header = $params->get('headerministryseries', '1');
$headertext = JText::_($params->get('headerministrytext', 'COM_PREACHIT_HEADER_MINISTRY'));
$listtype = $params->get('ministryview_listtype', '0');
$columns = $params->get('ministryview_imageacross', '4');
$total = $params->get ('series_ministry', '10');
$k = 0;
$t = 1;
?>

<!-- set the div and form for the page -->

<div id="ministryview" class="list">

<div class="head">

<!-- ministry info -->

<table width="100%">
	<tr>
		<td>
			<?php echo $this->ministry->imagelrg; ?>
			
			<h1 class="ministryname"><?php echo $this->ministry->name; ?></h1>
			
			<div class="ministrydescription"><?php echo $this->ministry->description; ?></div>
			
		</td>
	</tr>
</table>

<!-- end head -->

</div>

<!-- title for series list -->

<?php 
if ($header == '1')
{?>
<div class="headblock">
<div class="ministryseries"><?php echo $headertext;?></div>
</div>
<?php }?>

<!-- set background variable for alternate rows -->

<?php $bgrd = 1;?>


<!-- loop through series list -->

<?php 
if (is_array($this->series))
{
foreach ($this->series as $series)
{	
if ($listtype == 0)
{
// divs for alternate colours if needed

if ($bgrd == 1)
{$alternate = 'piodd';}
if ($bgrd == 0)
{$alternate = 'pieven';}
$this->assignref('alternate', $alternate);

// get the right image

if ($params->get('minserpic', '1') == '1')
{
$seriesimage = $series->imagemed;
}
else {$seriesimage = '';}
?>

<!-- display the info -->

<div class="listblock <?php echo $alternate;?>">
<table width="100%">
	<tr>
		<td>
			<?php echo $seriesimage; ?>
			
			<div class="seriesname"><?php echo $series->name; ?></div>
			
			<?php if ($params->get('description_serieslist', '1') == '1')
			{?>
				<div class="seriesdescription"><?php echo $series->description; ?></div>
			<?php }?>
			
			<?php echo $series->editlink;?>
			
		</td>
	</tr>
</table>
</div>

<?php
$bgrd = 1 - $bgrd; 
}
elseif ($listtype == 1)
{		
if ($k < $columns) {$k = $k + 1;}
else {$k = 1;}

// get the right image

if ($params->get('minserpic', '1') == '1')
{
if ($params->get('ministry_imagesize', '0') == 0)
{ $seriesimage = $series->imagesm;}
else if ($params->get('ministry_imagesize', '0') == 1)
{ $seriesimage = $series->imagelrg;}
}
else {$seriesimage = '';}
?>

<!-- display the info -->

<?php if ($k == '1')
{?> 
<div class="listblock">
<?php ;} ?>
	<div class="gallery_column">

			<?php echo $seriesimage; ?>
			
			<div class="seriesname"><?php echo $series->name; ?></div>
			
			<?php echo $series->editlink;?>
			
	</div>

<?php
if ($t == $total)
{echo '</div><div class="clr"></div>';}
else {
if ($k == $columns)
{echo '</div><div class="clr"></div>';
$t = $t + 1;}
else {$t = $t + 1;}
}
} 
}
if ($listtype == 1)
{if ($t <= $total && $k < $columns)
{echo '</div><div class="clr"></div>';}
}
}
else {echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_MV').'</div>';} ?>
<div class="clr"></div>
<!-- Pagination -->

<?php
require_once($abspath.DS.'components/com_preachit/helpers/additional.php');
$pagination = PIHelperadditional::pagination($this->pagination);
 ?>
 
<?php echo $pagination;?>

<!-- backlink -->

<?php echo $this->backlink;?>

<!-- powered by notice -->

<?php echo $this->powered_by;?>
</div>