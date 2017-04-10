<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$option = JRequest::getCmd('option');
$function = JRequest::getVar('function', 'jSelectChart');
JHTML::_('behavior.mootools');
?>
<form action="index.php" method="post" name="adminForm">
<table class="adminlist mc-list-table">
<thead>
<tr>
<th width="20">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" />
</th>
<th width="5%" nowrap="nowrap"><?php echo JText::_('COM_PREACHIT_ADMIN_STATELIST');?></th>
<th width ="5%"><?php echo JText::_('COM_PREACHIT_ADMIN_ORDERLIST');?></th>
<th width="25%"><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
<th width="60%"><?php echo JText::_('COM_PREACHIT_ADMIN_DESCRIPTIONLIST');?></th>
</tr>
</thead>
<?php
jimport('joomla.filter.output');
$k = 0;
for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
{
$row = &$this->rows[$i];
$checked = JHTML::_('grid.id', $i, $row->id );
$published = JHTML::_('grid.published', $row, $i );
?>
<tr class="<?php echo "row$k"; ?>">
<td>
<?php echo $checked; ?>
</td>
<td align="center">
<?php echo $published;?>
</td>
<td class="order">
<?php echo $row->ordering;?>
</td>
<td>
<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $function;?>('<?php echo $row->id; ?>', '<?php echo addslashes($row->series_name); ?>');">
<?php echo $row->series_name; ?></a>
</td>
<td>
<?php echo JString::substr($row->series_description, 0, 149); ?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
	      <tfoot><tr>
	      <td colspan="5"> <?php echo $this->pagination->getListFooter(); ?> </td></tr></tfoot>
</table>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="serieslist" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="layout" value="modal" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>