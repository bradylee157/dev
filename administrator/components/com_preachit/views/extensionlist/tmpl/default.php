<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$dateformat = '';
$dateformat = 'F, Y';
$option = JRequest::getCmd('option');
?>
<form action="index.php" method="post" name="adminForm">
<table class="adminlist">
<thead>
<tr>
<th width="30%"><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
<th width="5%"><?php echo JText::_('COM_PREACHIT_ADMIN_VERSIONLIST');?></th>
<th width="5%"><?php echo JText::_('COM_PREACHIT_ADMIN_UPGRADELIST');?></th>
<th width="20%"><?php echo JText::_('COM_PREACHIT_ADMIN_CREATION_DATELIST');?></th>
<th width="30%"><?php echo JText::_('COM_PREACHIT_ADMIN_AUTHORLIST');?></th>
<th width="10%"><?php echo JText::_('COM_PREACHIT_ADMIN_CSS_FILELIST');?></th>
</tr>
</thead>
<?php
jimport('joomla.filter.output');
$k = 0;
for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
{
$row = &$this->rows[$i];
$checked = JHTML::_('grid.id', $i, $row->dir );
?>
<tr class="<?php echo "row$k"; ?>">
<td>
<?php if ($row->name)
{ echo JText::_($row->name); } 
else {echo '<div style="text-align: center;">'.$row->dir.'</div>';} ?>
</td>
<td style="text-align: center;">
<?php if ($row->version)
{ echo $row->version; } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td style="text-align: center;">
<?php if ($row->upgrade)
{ echo '<a class="piupgrade" href="http://te-webdesign.org.uk">['.$row->upgrade.']</a>'; } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td>
<?php if ($row->date)
{ echo JHTML::Date($row->date, $dateformat); } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td>
<?php if ($row->author)
{ echo $row->author; } 
else {echo '<div style="text-align: center;"> - </div>';} ?>
</td>
<td style="text-align: center;">
<?php if ($row->link)
{?>
<a href="<?php echo $row->link; ?>">[<?php echo JText::_('COM_PREACHIT_EXTENSION_CSS_EDIT');?>]</a>
<?php }
else { echo ' - ';}?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
<tfoot style="height: 20px;"><tr>
	      <td colspan="7"></td></tr></tfoot>
</table>
<div style="text-align: center; padding-top: 5px;">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="extensions" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>