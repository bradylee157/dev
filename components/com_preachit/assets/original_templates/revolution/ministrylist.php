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
// get menu params
$app = JFactory::getApplication();
$Mparams =& $app->getParams();
$option = JRequest::getCmd('option');
$listtype = $params->get('ministry_listtype', '0');
$columns = $params->get('ministry_imageacross', '4');
$total = $params->get ('ministrylist_no', '10');
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

<!-- set the div and form for the page -->
<div id="ministrylist" class="list">

<?php /** Begin Page Title **/ if ($show) : ?>
		<h1 class="title">
			<?php echo $pgheader; ?>
		</h1>
<?php /** End Page Title **/ endif; ?>

<!-- loop through the information -->

<?php
if (is_array($this->ministry))
{
foreach ($this->ministry as $ministry)
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

if ($params->get('picture_ministrylist', '1') == '1')
{
$ministryimage = $ministry->imagemed;
}
else {$ministryimage = '';}
?>

<!-- display the info -->

<div class="listblock <?php echo $alternate;?>">
<table width="100%">
	<tr>
		<td>
			<?php echo $ministryimage; ?>
			
			<div class="ministryname"><?php echo $ministry->name; ?></div>
			
			<?php if ($params->get('description_ministrylist', '1') == '1')
			{?>
				<div class="ministrydescription"><?php echo $ministry->description; ?></div>
			<?php }?>
			
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

if ($params->get('picture_ministrylist', '1') == '1')
{
$ministryimage = $ministry->imagemed;
}
else {$ministryimage = '';}
?>

<!-- display the info -->

<?php if ($k == '1')
{?> 
<div class="listblock">
<?php ;} ?>
	<div class="gallery_column">
	
			<?php echo $ministryimage; ?>
			
			<div class="ministryname"><?php echo $ministry->name; ?></div>
			
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
else {echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_MINL').'</div>';}
?>
<div class="clr"></div>
<!-- Pagination -->

<?php
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$pagination = PIHelperadditional::pagination($this->pagination);
 ?>
 
<?php echo $pagination;?>

<!-- powered by notice -->

<?php echo $this->powered_by;?>

</div>