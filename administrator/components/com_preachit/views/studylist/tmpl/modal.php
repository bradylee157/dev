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
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/message-info.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
?>

<form action="index.php" method="post" name="adminForm">
<table width="100%">
<tr>
<td> <?php echo $this->study_book;?>
	<?php echo $this->teacher_list; ?>
	<?php echo $this->series_list; ?>
	<?php echo $this->years_list; ?> </td>
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
 ?>
<table class="adminlist mc-list-table">
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
<th width="20%"><?php echo JHTML::_( 'grid.sort',$head_script, 'study_book', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="15%"><?php echo JHTML::_( 'grid.sort',$head_teacher , 'teacher', $this->lists['order_Dir'], $this->lists['order']); ?></th>
<th width="15%"><?php echo JHTML::_( 'grid.sort', $head_series, 'series', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<th width="15%"><?php echo JHTML::_( 'grid.sort', $head_hits, 'hits', $this->lists['order_Dir'], $this->lists['order']); ?></th>
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

//get teacher name

$teacher = PIHelpermessageinfo::teacher($row->teacher, '', 2);

//get series name

$series = PIHelpermessageinfo::series($row->series, '', 2);

//get scripture

$scripture = PIHelperscripture::podscripture($row->id);
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
<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $function;?>('<?php echo $row->id; ?>', '<?php echo addslashes($row->study_name); ?>');">
<?php echo JHTML::Date($row->study_date, 'd F, Y'); ?></a>
</td>
<td>
<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $function;?>('<?php echo $row->id; ?>', '<?php echo addslashes($row->study_name); ?>');">
<?php echo $row->study_name; ?></a>
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
<td>
<?php echo $row->hits; ?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
	      <tfoot><tr>
	      <td colspan="9"> <?php echo $this->pagination->getListFooter(); ?> </td></tr></tfoot>
</table>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="studylist" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="layout" value="modal" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>