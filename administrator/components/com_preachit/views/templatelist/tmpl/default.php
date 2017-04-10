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
 		
?>
<script language="javascript" type="text/javascript">
<?php 
echo 'Joomla.submitbutton = function(task)
	{
	if (task == "")
        		{
                return false;
        		}
   else if (task == "resettemp") 
	{
		if(confirm("'.JText::_('COM_PREACHIT_TEMPLATE_MANAGER_RESET_TEMP_WARN').'"))
		{Joomla.submitform(task);}
		} 
 else {
			Joomla.submitform(task);
		}
}';?>
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
<thead>
<tr>
<th width="20">
</th>
<th width="3%" nowrap="nowrap"><?php echo JText::_('COM_PREACHIT_ADMIN_IDLIST');?></th>
<th width="18%"><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
<th width="5%"><?php echo JText::_('COM_PREACHIT_ADMIN_DEFAULTLIST');?></th>
<th width="19%"><?php echo JText::_('COM_PREACHIT_ADMIN_TEMPLATELIST');?></th>
<th width="5%"><?php echo JText::_('COM_PREACHIT_ADMIN_VERSIONLIST');?></th>
<th width="15%"><?php echo JText::_('COM_PREACHIT_ADMIN_CREATION_DATELIST');?></th>
<th width="20%"><?php echo JText::_('COM_PREACHIT_ADMIN_AUTHORLIST');?></th>
<th width="15%"><?php echo JText::_('COM_PREACHIT_ADMIN_CSS_FILELIST');?></th>
</tr>
</thead>
<?php
jimport('joomla.filter.output');
$k = 0;
for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
{
$row = &$this->rows[$i];
$checked = JHTML::_('grid.id', $i, $row->id );
$linkcust = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&view=templates');
$linkedit = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&view=templateedit&template='. $row->id);
if ($row->client_id > 0)
{$master = null;}
else {$master = '<span class="master">'.JText::_('LIB_TEWEB_TEMP_MASTER').'</span>';}
?>
<tr class="<?php echo "row$k"; ?>">
<td>
<?php echo $checked; ?>
</td>
<td style="text-align: center;">
<?php echo $row->id; ?>
</td>
<td>
<?php echo '<a href="'.$linkedit.'">'.$row->name.'</a>'.$master;?>
</td>
<td style="text-align: center;">
<?php if ($row->def == 1)
{?> <img alt="Default" src="../components/com_preachit/assets/images/icon-16-default.png"> <?php }?>
</td>
<td style="text-align: center;">
<?php echo $row->template; ?>
</td>
<td style="text-align: center;">
<?php if ($row->version)
{ echo $row->version; } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td style="text-align: center;">
<?php if ($row->date)
{ echo JHTML::Date($row->date, $this->dateformat); } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td style="text-align: center;">
<?php if ($row->author)
{ echo $row->author; } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td style="text-align: center;">
<?php echo $row->css;?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
	      <tfoot><tr>
	      <td colspan="9"> <?php echo $this->pagination->getListFooter(); ?> </td></tr>
	      </tfoot>
</table>
<div style="text-align: center; padding-top: 5px;">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="templates" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>