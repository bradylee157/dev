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
<td> <?php echo $this->state_list; ?></td>
</tr></table>
<table class="adminlist">
<thead>
<tr>
<th width="20">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" />
</th>
<th width="10%" nowrap="nowrap"><?php echo JText::_('COM_PREACHIT_ADMIN_STATELIST');?></th>
<th width ="80"><?php echo JText::_('COM_PREACHIT_ADMIN_ORDERLIST');?></th>
<th width ="1%"><a title="Save Order" href="#" onclick="submitbutton('saveorder')">
<img alt="Save Order" src="../components/com_preachit/assets/images/filesave.png">
</a></th>
<th width="20%"><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
<th width="60%"><?php echo JText::_('COM_PREACHIT_ADMIN_CODELIST');?></th>
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

$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=sharelist&task=edit&cid[]='. $row->id );

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
<td align="center">
<?php echo $published; ?>
</td>
<td class="order" colspan="2">
<span><?php echo $this->pageOrd->orderUpIcon( $i );?></span><span><?php echo $this->pageOrd->orderDownIcon( $i, $this->rowcount );?></span>
<input type="text" style="text-align: center" class="text_area" value="<?php echo $row->ordering;?>" size="5" name="order[]">
</td>
<td>
<a href="<?php echo $link; ?>"><?php echo $name; ?></a>
</td>
<td>
<?php
$code = htmlspecialchars($row->code);
 echo JString::substr($code, 0, 149); ?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
	      <tfoot><tr>
	      <td colspan="6"> <?php echo $this->pagination->getListFooter(); ?> </td></tr>
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
<input type="hidden" name="controller" value="sharelist" />
<input type="hidden" name="boxchecked" value="0" />
</form>