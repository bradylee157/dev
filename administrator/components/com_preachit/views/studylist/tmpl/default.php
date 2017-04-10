<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$user	= JFactory::getUser();
$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
?>
<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
	{
	if (task == "")
        		{
                return false;
        		}
   else if (task == "resetall") 
	{
		if(confirm("<?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_RESET_WARNING');?>"))
		{Joomla.submitform(task);}
		} 
	else if (task == "resetdownloads") 
	{
		if(confirm("<?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_DOWNLOADS_WARNING');?>"))
		{Joomla.submitform(task);}
		} 
	
 else {
			Joomla.submitform(task);
		}
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table width="100%">
<tr>
<td> <?php echo $this->study_book;?>
	<?php echo $this->teacher_list; ?>
	<?php echo $this->series_list; ?>
	<?php echo $this->ministry_list; ?>
	<?php echo $this->years_list; ?> 
	<?php echo $this->lang_list; ?>
	<?php echo $this->state_list; ?></td>
</tr></table>
 <?php
 //headings in JText
 
 $head_id = Jtext::_('COM_PREACHIT_ADMIN_IDLIST');
 $head_published = JText::_('COM_PREACHIT_ADMIN_STATELIST');
 $head_date = JText::_('COM_PREACHIT_ADMIN_DATELIST');
 $head_title = JText::_('COM_PREACHIT_ADMIN_NAMELIST');
 $head_script = JText::_('COM_PREACHIT_ADMIN_SCRIPTURELIST');
 $head_teacher = JText::_('COM_PREACHIT_ADMIN_TEACHERLIST');
 $head_series = JText::_('COM_PREACHIT_ADMIN_SERIESLIST');
 $head_hits = JText::_('COM_PREACHIT_ADMIN_HITLIST');
 $head_downloads = JText::_('COM_PREACHIT_ADMIN_DOWNLOADSLIST');
 $head_podpub = JText::_('COM_PREACHIT_ADMIN_PODPUBLIST');
 ?>
<table class="adminlist">
<thead>
<tr>
<th width="20">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" />
</th>
<th width="40"><?php echo JHTML::_( 'grid.sort',$head_id,'id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',$head_published,'published',$this->lists['order_Dir'],$this->lists['order']); ?></th>
<th width="12%"><?php echo JHTML::_('grid.sort',$head_date,'study_date',$this->lists['order_Dir'],$this->lists['order']); ?></th>
<th width="20%"><?php echo JHTML::_( 'grid.sort', $head_title, 'study_name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="14%"><?php echo JHTML::_( 'grid.sort',$head_script, 'study_book', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="14%"><?php echo JHTML::_( 'grid.sort',$head_teacher , 'teacher', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th width="14%"><?php echo JHTML::_( 'grid.sort', $head_series, 'series', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="8%"><?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th width="5%"><?php echo JHTML::_( 'grid.sort', $head_hits, 'hits', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th width="5%"><?php echo JHTML::_( 'grid.sort', $head_downloads, 'downloads', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th><?php echo $head_podpub;?></th>
</tr>
</thead>
<?php
jimport('joomla.filter.output');
$k = 0;
for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
{
$row = &$this->rows[$i];
$checked = JHTML::_('grid.id', $i, $row->id );

// determine state column
if ($row->publish_down == '0000-00-00 00:00:00' || $row->publish_down == '')
{$publishdown = '0000-00-00 00:00:00';}
else {$publishdown = $row->publish_down;}
$published = JHtml::_('jgrid.published', $row->published, $i, '', $user->authorise('core.edit.state', 'com_preachit'), 'cb', $row->publish_up, $publishdown);

$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=studylist&task=edit&cid[]='. $row->id );

//determine name column

if ($user->authorise('core.edit', 'com_preachit') && !$row->checked_out || $user->authorise('core.edit', 'com_preachit') && $this->checkin == 0 
|| $user->authorize('core.edit.own', 'com_preachit') && $user->id == $row->user && !$row->checked_out || $user->authorize('core.edit.own', 'com_preachit') && $user->id == $row->user && $this->checkin == 0) 
{
$date = '<a href="'.$link.'">'.JHTML::Date($row->study_date, $this->dateformat).'</a>';}
elseif ($row->checked_out == $user->id && $this->checkin == 1 && $user->authorise('core.edit', 'com_preachit') || 
$row->checked_out == $user->id && $this->checkin == 1 && $user->authorise('core.edit.own', 'com_preachit') && $user->id == $row->user )
{$date = '<a href="'.$link.'">'.JHTML::Date($row->study_date, $this->dateformat).' '.JText::_('COM_PREACHIT_ADMIN_RECORD_CHECKED_OUT').'</a>';}
elseif ($row->checked_out && $this->checkin == 1)
{$date = JHTML::Date($row->study_date, $this->dateformat).' '.JText::_('COM_PREACHIT_ADMIN_RECORD_CHECKED_OUT');}
else {$date = JHTML::Date($row->study_date, $this->dateformat);}

// determin podpub column

if ($row->podpublish_down == '0000-00-00 00:00:00' || $row->podpublish_down == '')
{$podpublishdown = '0000-00-00 00:00:00';}
else {$podpublishdown = $row->podpublish_down;}

$now = gmdate ( 'Y-m-d H:i:s' );
$nullDate = '0000-00-00 00:00:00';

if (($row->published == 1 && ($row->publish_up == $nullDate || $row->publish_up == '' || $row->publish_up <= $now) && ($row->publish_down == $nullDate || $row->publish_down == '' || $row->publish_down >= $now)) && (($row->podpublish_up == $nullDate || $row->podpublish_up == '' || $row->podpublish_up <= $now) && ($row->podpublish_down == $nullDate || $row->podpublish_down == '' || $row->podpublish_down >= $now)))
{
    $podpub = '<img style="width: 16px; height: 16px;" src="../components/com_preachit/assets/images/success.png">';
}
else {$podpub = '<img style="width: 16px; height: 16px;" src="../components/com_preachit/assets/images/failure.png">';}

$published = JHtml::_('jgrid.published', $row->published, $i, '', $user->authorise('core.edit.state', 'com_preachit'), 'cb', $row->publish_up, $publishdown);

//get teacher name

$teacher = PIHelpermessageinfo::teacher($row->teacher, '', 2);

//get series name

$series = PIHelpermessageinfo::series($row->series, '', 2);

//get scripture

$scripture = PIHelperscripture::podscripture($row->id);

// get language title

$db =& JFactory::getDBO();
	$query = "SELECT ".$db->nameQuote('title')."
    FROM ".$db->nameQuote('#__languages')."
    WHERE ".$db->nameQuote('lang_code')." = ".$db->quote($row->language).";
  ";
	$db->setQuery($query);
	$language_title = $db->loadResult();
?>

<tr class="<?php echo "row$k"; ?>">
<td>
<?php echo $checked; ?>
</td>
<td>
<?php echo $row->id; ?></td>
<td align="center">
<?php echo $published;?>
</td>
<td>
<?php echo $date; ?>
</td>
<td>
<?php echo $row->study_name; ?>
</td>
<td>
<?php echo $scripture; ?>
</td>
<td>
<?php echo $teacher; ?>
</td>
<td>
<?php echo $series; ?>
</td>
<td class="center">
<?php if ($row->language=='*'):?>
<?php echo JText::alt('JALL','language'); ?>
<?php else:?>
<?php echo $language_title ? $this->escape($language_title) : JText::_('JUNDEFINED'); ?>
<?php endif;?>
</td>
<td align="center">
<?php echo $row->hits; ?>
</td>
<td align="center">
<?php echo $row->downloads; ?>
</td>
<td align="center">
<?php echo $podpub; ?>
</td>
</tr>
<?php
$k = 1 - $k;
}
$col = 12;
?>
	      <tfoot><tr>
	      <td colspan="<?php echo $col;?>"> <?php echo $this->pagination->getListFooter(); ?> </td></tr>
 </tfoot>
</table>
<div style="text-align: center; padding-top: 5px;">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="studylist" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
