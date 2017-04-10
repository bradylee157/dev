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
$head_name = Jtext::_('COM_PREACHIT_ADMIN_NAMELIST');
$head_count = JText::_('COM_PREACHIT_ADMIN_COUNTLIST');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
<thead>
<tr>
<th width="20">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php echo count( $this->rows); ?>);" />
</th>
<th width="50%"><?php echo JHTML::_( 'grid.sort',$head_name , 'name', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th width="50%"><?php echo JHTML::_( 'grid.sort', $head_count, 'count', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
</tr>
</thead>
<?php
jimport('joomla.filter.output');
$k = 0;
$i = 0;
foreach($this->rows AS $row)
{
$checked = JHTML::_('grid.id', $i, $row->name );

$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=taglist&task=edit&tagstring='. $row->name );

//determine name column

if ($user->authorise('core.edit', 'com_preachit')) 
{
$name = '<a href="'.$link.'">'.$row->name.'</a>';}
else {$name = $row->name;}

?>

<tr class="<?php echo "row$k"; ?>">
<td>
<?php echo $checked; ?>
</td>
<td>
<a href="<?php echo $link; ?>"><?php echo $name; ?></a>
</td>
<td style="text-align: center;">
<?php echo $row->count; ?>
</td>
</tr>
<?php
$k = 1 - $k;
$i++;
}
?>
	      <tfoot><tr>
	      <td colspan="3"> <?php echo $this->pagination->getListFooter(); ?> </td></tr>
	      </tfoot>
</table>
<div style="text-align: center; padding-top: 5px;">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="taglist" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>