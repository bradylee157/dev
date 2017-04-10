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
JHTML::_('behavior.modal');
PIHelperadditional::loadsqueeze();
$option = JRequest::getCmd('option');
$listtype = $params->get('teacher_listtype', '0');
$columns = $params->get('teacher_imageacross', '4');
$total = $params->get ('teacherlist_no', '10');
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
<div id="teacherlist">

<?php /** Begin Page Title **/ if ($show) : ?>
		<h1 class="title">
			<?php echo $pgheader; ?>
		</h1>
<?php /** End Page Title **/ endif; ?>

<?php if ($params->get('teachersort', '1') == 1 || $params->get('teachersort', '1') == 2) {
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/templates/revolution/helpers/helper.php');
$letterlist = Revolutionhelper::getalphalist('#__piteachers', 'lastname', 1, 'teacherlist');?>
<div id="pialphalist">
<ul class="alphalist">
<?php echo $letterlist;?>
</ul>
</div>
<?php } ?>

<!-- loop through the information -->

<?php
if (is_array($this->teachers))
{
foreach ($this->teachers as $teacher)
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

if ($params->get('picture_teacherlist', '1') == '1')
{
$teacherimage = $teacher->imagemed;
}
else {$teacherimage = '';}
?>

<!-- display the info -->

<div class="listblock <?php echo $alternate;?>">
<table width="100%">
	<tr>
		<td>
			<?php echo $teacherimage; ?>
			
			<div class="teachername"><?php echo $teacher->name; ?></div>
			
			<?php if ($params->get('role_teacherlist', '1') == '1')
			{?>
				<div class="teacherrole"><?php echo $teacher->role; ?></div>
			<?php }?>
			
			<?php if ($params->get('description_teacherlist', '1') == '1')
			{?>
				<div class="teacherdescription"><?php echo $teacher->description; ?></div>
			<?php }?>
			
			<?php echo $teacher->editlink;?>
			
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

if ($params->get('picture_teacherlist', '1') == '1')
{
if ($params->get('teacher_imagesize', '0') == 0)
{ $teacherimage = $teacher->imagesm;}
else if ($params->get('teacher_imagesize', '0') == 1)
{ $teacherimage = $teacher->imagelrg;}
}
else {$teacherimage = '';}
?>

<!-- display the info -->

<?php if ($k == '1')
{?> 
<div class="listblock">
<?php ;} ?>
	<div class="gallery_column">

			<?php echo $teacherimage; ?>
			
			<div class="teachername"><?php echo $teacher->name; ?></div>
			
			<?php if ($params->get('role_teacherlist', '1') == '1')
			{?>
				<div class="teacherrole"><?php echo $teacher->role; ?></div>
			<?php }?>
			
			<?php echo $teacher->editlink;?>
			
	</div>

<?php
if ($t == $total)
{echo '</div>';}
else {
if ($k == $columns)
{echo '</div>';
$t = $t + 1;}
else {$t = $t + 1;}
}
} 
}
if ($listtype == 1)
{if ($t <= $total && $k < $columns)
{echo '</div>';}
}
}
else {echo '<div class="noneassigned">'.JText::_('COM_PREACHIT_NONE_ASSIGNED_MESSAGE_TL').'</div>';}
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