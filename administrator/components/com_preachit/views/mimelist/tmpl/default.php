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
<th width="30%"><?php echo JText::_('COM_PREACHIT_ADMIN_PAYER_EXTENSIONLIST');?></th>
<th width="70%"><?php echo JText::_('COM_PREACHIT_ADMIN_PLAYER_MEDIATYPELIST');?></th>
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

$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=mimelist&task=edit&cid[]='. $row->id );

//determine name column

if ($user->authorise('core.edit', 'com_preachit')) 
{
$name = '<a href="'.$link.'">'.$row->extension.'</a>';}
else {$name = $row->extension;}

?>

<tr class="<?php echo "row$k"; ?>">
<td>
<?php echo $checked; ?>
</td>
<td align="center">
<?php echo $published; ?>
</td>
<td>
<a href="<?php echo $link; ?>"><?php echo $name; ?></a>
</td>
<td>
<?php echo $row->mediatype; ?>
</td>
</tr>
<?php
$k = 1 - $k;
}
?>
	      <tfoot><tr>
	      <td colspan="4"> <?php echo $this->pagination->getListFooter(); ?> </td></tr>
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
<input type="hidden" name="controller" value="mimelist" />
<input type="hidden" name="boxchecked" value="0" />
</form>