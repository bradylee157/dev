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
$this->params = $params;
// get menu params
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
JHTML::_('behavior.modal');
PIHelperadditional::loadsqueeze();
$option = JRequest::getCmd('option');
$listtype = $params->get('series_listtype', '0');
$columns = $params->get('series_imageacross', '4');
$total = $params->get ('serieslist_no', '10');
$k = 0;
$t = 1;
$bgrd = 1;
// set heading vaiables

$show = $Mparams->get('show_page_heading', 1);
$enttitle = $Mparams->get('page_heading', '');
$pgtitle = $Mparams->get('page_title', '');
if ($enttitle)
{$pgheader = $enttitle;}
else {$pgheader = $pgtitle;}
?>

<?php /** Begin Page Title **/ if ($show) : ?>
		<h1 class="title">
			<?php echo $pgheader; ?>
		</h1>
<?php /** End Page Title **/ endif; ?>

<?php if ($this->listview == 'serieslist')
{?>

<!-- set the div and form for the page -->
<div id="serieslist">
<?php if ($params->get('seriessort', '1') == 5 || $params->get('seriessort', '1') == 6) {
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/templates/revolution/helpers/helper.php');
$letterlist = Revolutionhelper::getalphalist('#__piseries', 'series_name', 0, 'serieslist');?>
<div id="pialphalist">
<ul class="alphalist">
<?php echo $letterlist;?>
</ul>
</div>
<?php } ?>

<?php }

elseif ($this->listview == 'ministry')
{?>
<div id="ministryview" class="list">
<?php echo $this->loadTemplate('ministry');
}?>

<!-- loop through the information -->

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

if ($params->get('picture_serieslist', '1') == '1')
{
$seriesimage = $series->imagemed;
}
else {$seriesimage = '';}
?>

<!-- display the info -->

<div class="listblock <?php echo $alternate;?>">
			<?php echo $seriesimage; ?>
			
			<div class="seriesname"><?php echo $series->name; ?></div>
            
            <?php if ($params->get('date_serieslist', '1') == '1')
            {?>
            <div class="seriesdate"><?php echo $series->daterange; ?></div>
            <?php }?>
			
			<?php if ($params->get('description_serieslist', '1') == '1')
			{?>
				<div class="seriesdescription"><?php echo $series->description; ?></div>
			<?php }?>
			
			<?php echo $series->editlink;?>
</div>
<div class="clr"></div>

<?php
$bgrd = 1 - $bgrd; 
}
elseif ($listtype == 1)
{	
if ($k < $columns) {$k = $k + 1;}
else {$k = 1;}

// get the right image

if ($params->get('picture_serieslist', '1') == '1')
{
$seriesimage = $series->imagemed;
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
            
            <?php if ($params->get('date_serieslist', '1') == '1')
            {?>
            <div class="seriesdate"><?php echo $series->daterange; ?></div>
            <?php }?>
			
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
}
else {echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_SL').'</div>';}
?>
<div class="clr"></div>

<!-- backlink -->
<?php if (isset($this->backlink))
{echo $this->backlink;}?> 

<!-- Pagination -->

<?php
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$pagination = PIHelperadditional::pagination($this->pagination);
 ?>
 
<?php echo $pagination;?>

<!-- powered by notice -->

<?php echo $this->powered_by;?>

</div>