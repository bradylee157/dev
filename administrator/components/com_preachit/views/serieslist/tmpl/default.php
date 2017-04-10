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
?>
<script type="text/javascript" >

function submitbutton(pressbutton) {
	if (pressbutton == 'saveorder') 
	{
		var n = <?php echo count( $this->rows ); ?>;
		var fldName = 'cb';
		var f = document.adminForm;
		var c = 1;
		var n2 = 0;
		for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
		cb.checked = c;
		n2++;
		}
		}
		if (c) {
			document.adminForm.boxchecked.value = n2;
		} else {
			document.adminForm.boxchecked.value = 0;
		} 
		submitform(pressbutton);
	}
	else {submitform(pressbutton);}
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table width="100%">
<tr>
<td><?php echo $this->lang_list; ?>
<?php echo $this->state_list; ?></td>
</tr></table>
<table class="adminlist">
<thead>
<tr>
<th width="20">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" />
</th>
<th width="5%" nowrap="nowrap"><?php echo JText::_('COM_PREACHIT_ADMIN_IDLIST');?></th>
<th width="5%" nowrap="nowrap"><?php echo JText::_('COM_PREACHIT_ADMIN_STATELIST');?></th>
<th width ="80"><?php echo JText::_('COM_PREACHIT_ADMIN_ORDERLIST');?></th>
<th width ="1%"><a title="Save Order" href="#" onclick="submitbutton('saveorder')">
<img alt="Save Order" src="../components/com_preachit/assets/images/filesave.png">
</a></th>
<th width="27%"><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
<th width="45%"><?php echo JText::_('COM_PREACHIT_ADMIN_DESCRIPTIONLIST');?></th>
<th width="8%"><?php echo JText::_('JGRID_HEADING_LANGUAGE'); ?></th>
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
$published = JHtml::_('jgrid.published', $row->published, $i, '', $user->authorise('core.edit.state', 'com_preachit'), 'cb');

$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=serieslist&task=edit&cid[]='. $row->id );

//determine name column

if ($user->authorise('core.edit', 'com_preachit') && !$row->checked_out || $user->authorise('core.edit', 'com_preachit') && $this->checkin == 0 
|| $user->authorize('core.edit.own', 'com_preachit') && $user->id == $row->user && !$row->checked_out || $user->authorize('core.edit.own', 'com_preachit') && $user->id == $row->user && $this->checkin == 0) 
{
$name = '<a href="'.$link.'">'.$row->series_name.'</a>';}
elseif ($row->checked_out == $user->id && $this->checkin == 1 && $user->authorise('core.edit', 'com_preachit') || 
$row->checked_out == $user->id && $this->checkin == 1 && $user->authorise('core.edit.own', 'com_preachit') && $user->id == $row->user )
{$name = '<a href="'.$link.'">'.$row->series_name.' '.JText::_('COM_PREACHIT_ADMIN_RECORD_CHECKED_OUT').'</a>';}
elseif ($row->checked_out && $this->checkin == 1)
{$name = $row->series_name.' '.JText::_('COM_PREACHIT_ADMIN_RECORD_CHECKED_OUT');}
else {$name = $row->series_name;}

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
<td align="center">
<?php echo $row->id; ?></td>
<td align="center">
<?php echo $published;?>
</td>
<td class="order" colspan="2">
<span><?php echo $this->pageOrd->orderUpIcon( $i );?></span><span><?php echo $this->pageOrd->orderDownIcon( $i, $this->rowcount );?></span>
<input type="text" style="text-align: center" class="text_area" value="<?php echo $row->ordering;?>" size="5" name="order[]">
</td>
<td>
<?php echo $name; ?>
</td>
<td>
<?php echo JString::substr($row->series_description, 0, 149); ?>
</td>
<td class="center">
<?php if ($row->language=='*'):?>
<?php echo JText::alt('JALL','language'); ?>
<?php else:?>
<?php echo $language_title ? $this->escape($language_title) : JText::_('JUNDEFINED'); ?>
<?php endif;?>
</td>
</tr>
<?php
$k = 1 - $k;
}
$col = 8;
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
<input type="hidden" name="controller" value="serieslist" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>