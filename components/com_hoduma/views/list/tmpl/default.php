<?php
/**
 * @package Hoduma
 * @copyright Copyright (c)2012 Hoduma.com, (c)2009-2011 Huru Helpdesk Developers
 * @license GNU General Public License version 3, or later
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
*/

defined('_JEXEC') or die('Restricted access');

//check user auth level
require_once JPATH_COMPONENT.DS.'helpers'.DS.'head.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'auth.php';
$mainframe = &JFactory::getApplication();	
//if(!checkusermin('user') && userlevel()<config('enablekb')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

$userlvl = userlevel();

//$type = JRequest::getVar('type',''); 
$type = trim($mainframe->getUserStateFromRequest('hh_list.type','type','')); //get list type
$stype = trim($mainframe->getUserStateFromRequest('hh_list.stype','stype','')); //get search list type if available

//determine if we are in a print view
if(JRequest::getVar('print')==1) $printing = true;
else $printing = false;

//build link for re-sorting table
//$sortlink = JFilterOutput::ampReplace('index.php?option='.JRequest::getCmd('option').'&view=hhlist&type='.$type.'&Itemid='.JRequest::getVar('Itemid',''));
$sortlink = JFilterOutput::ampReplace('index.php?option=com_hoduma&view=list&type='.$type.'&Itemid='.JRequest::getVar('Itemid',''));

//check for limits on days & user
$days = $mainframe->getUserStateFromRequest('hh_list.days','days','','int');
if($days) $sortlink = $sortlink.'&days='.$days;
$hid = $mainframe->getUserStateFromRequest('hh_list.user','user','','int');
if($hid) $sortlink = $sortlink.'&user='.$hid;

//sort order
$sort = $mainframe->getUserStateFromRequest('hh_list.sort','sort','d');
$order = $mainframe->getUserStateFromRequest('hh_list.order','order','priority');
if($sort=='a') 
{
	$sortlink = $sortlink.'&sort=d';
	$sortimage = 'media/com_hoduma/images/uparrow.png';
}
else
{
	$sortlink = $sortlink.'&sort=a';
	$sortimage = 'media/com_hoduma/images/downarrow.png';
}

//Pagination
// Get data from the model
$items =& $this->get('Data');      
$pagination =& $this->get('Pagination');
// push data into the template
$this->assignRef('items', $items);     
$this->assignRef('pagination', $pagination);

//get result count
$count = $mainframe->getUserState('hh_list.count','');

//display page title if configured
$params	=& $mainframe->getParams('com_content');
$this->assignRef('params' , $params);
if ($this->params->get('show_page_title',1))
{
	?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php
}
?>
<div class="pagetitle"><?php echo lang('PageTitle');?></div>

<div class="problemlistbuttonrow">
	<?php 
	//setup toolbar
	if($printing) toolbar('printout','closeprint'); 
	elseif($type == 'search') toolbar('searchagain','printlist','refresh','home');
	//elseif($type == 'search') toolbar('searchagain','printlist','refresh','home','submit');
	else toolbar('refresh','printlist','home','submit');
	?>
</div>

<form action="<?php echo $sortlink;?>" method="post" name="listForm">
<div class="problemlistwrapper">
	<table class="problemlist">
		<thead>
			<?php 
			if($count>0)
			{
				if(!$printing)
				{
					?>
					<tr>
						<?php if(true && $stype!='kb'){?><th align=""><a href="javascript:setorder('id');" class="listhead"><?php echo lang('ID');?></a><?php if($order=='id') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th><?php }?>
						<th align=""><a href="javascript:setorder('title');" class="listhead"><?php echo lang('Title');?></a><?php if($order=='title') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th>
						<?php if($stype!='kb'){?><th align=""><a href="javascript:setorder('uid');" class="listhead"><?php echo lang('User');?></a><?php if($order=='uid') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th><?php }?>
						<?php if($type!='assigned'){?><th align=""><a href="javascript:setorder('rep');" class="listhead"><?php echo lang('Rep');?></a><?php if($order=='rep') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th><?php }?>
						<th align=""><a href="javascript:setorder('date');" class="listhead"><?php echo lang('DateSubmitted');?></a><?php if($order=='date') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th>
						<th align=""><a href="javascript:setorder('moddate');" class="listhead"><?php echo lang('Updated');?></a><?php if($order=='moddate') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th>
						<?php if($stype!='kb'){?><th align=""><a href="javascript:setorder('priority');" class="listhead"><?php echo lang('Priority');?></a><?php if($order=='priority' || $order=='') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th><?php }?>
						<th align=""><a href="javascript:setorder('status');" class="listhead"><?php echo lang('Status');?></a><?php if($order=='status') { ?> <img class="sortpointer" src="<?php echo $sortimage;?>"><?php }?></th>
					</tr>
					<?php
				}
				else
				{
					?>
					<tr>
						<?php if(true && $stype!='kb'){?><th align=""><?php echo lang('ID');?></a></th><?php }?>
						<th align=""><?php echo lang('Title');?></a></th>
						<?php if($stype!='kb'){?><th align=""><?php echo lang('User');?></a></th><?php }?>
						<?php if($type!='assigned'){?><th align"><?php echo lang('Rep');?></a></th><?php }?>
						<th align=""><?php echo lang('DateSubmitted');?></a></th>
						<th align=""><?php echo lang('Updated');?></a></th>
						<?php if($stype!='kb'){?><th align=""><?php echo lang('Priority');?></a></th><?php }?>
						<th align=""><?php echo lang('Status');?></a></th>
					</tr>
					<?php
				}
			}
			?>
		</thead>
		
		<?php 
		$k = 0;
		
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			//base link
			$link = JFilterOutput::ampReplace('index.php?option=' . JRequest::getCmd('option') . '&view=detail&type='.$type.'&task=edit&cid[]=' . $row->id);

			?>
			
			<tr class="problemlistrow" onclick="javascript:detail('<?php echo $row->id;?>');">
				<?php if(true && $stype!='kb'){?>
					<td align="center" class="problemlist"> 
						<?php echo $row->id; ?>
					</td>
				<?php }?>
				<td align="center" class="problemlist"> 
					<?php 
					echo safe_out($row->title);
					?>
				</td>
				<?php if($stype!='kb'){?>
					<td align="center" class="problemlist"> 
						<?php echo $row->uid; ?>
					</td>
				<?php }?>
				<?php if($type!='assigned'){?>
					<td align="center" class="problemlist"> 
						<?php echo $row->repname;?>
					</td>
				<?php }?>
				<td align="center" class="problemlist"> 
					<?php echo $row->start_date; ?>
				</td>
				<td align="center" class="problemlist"> 
					<?php echo $row->maxdate; ?>
				</td>
				<?php if($stype!='kb'){?>
					<td align="center" class="problemlist">
						<?php
							if(config('colorhighlight') == 1) {
								echo '<span style="color:'. $row->prioritycolor .' ;">'. $row->priority .'</span>';
							} else {
								echo $row->priority;
							}
						?>
					</td>
				<?php }?>
				<td align="center" class="problemlist"> 
					<?php
						if(config('colorhighlight') == 1) {
							echo '<span style="color:'. $row->statuscolor .' ;">'. $row->status .'</span>';
						} else {
							echo $row->status;
						}
					?>
				</td>
			</tr>
			<?php 
			$k = 1 - $k;
		}
		?>
	</table>
</div>

	<?php 
	if($count>0 && !$printing)
	{
		?>
		<table class="pagination" align="center">
			<tr>
				<td class="pagination" colspan="6"><?php echo $this->pagination->getListFooter();?></td>
			</tr>
		</table>
		<?php 
	}
	?>
	<input type="hidden" name="option" id="option" value="<?php echo JRequest::getCmd('option'); ?>" />
	<input type="hidden" name="view" id="viewid" value="<?php echo $mainframe->getUserStateFromRequest('hh_list.view','view',''); ?>" />
	<input type="hidden" name="task" id="taskid" value="<?php echo $mainframe->getUserStateFromRequest('hh_list.task','task',''); ?>" />
	<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $mainframe->getUserStateFromRequest('hh_list.Itemid','Itemid',''); ?>" />
	<input type="hidden" name="order" id="order" value="" />
	<input type="hidden" name="cid[]" id="cidid" value="" />
	<input type="hidden" name="days" id="days" value="<?php echo $days;?>" />
	<input type="hidden" name="user" id="user" value="<?php echo $hid;?>" />

	<?php if(DEBUG) dumpdebug();?>

	<?php echo JHTML::_('form.token'); ?>
</form>

<?php
//setup the list table title that will be displayed above the list
switch ($type)
{
	case 'search':
		$msg = $count.' '.lang('SearchResults');
		break;
	case 'all':
		if($hid) $msg = lang('OpenProblems').' '.lang('for').' '.userinfo($hid,'name').' ('.$count.') ';
		elseif($days > 0) $msg = lang('Problems').' '.lang('forprevious').' '.$days.' '.lang('days').' ('.$count.') ';
		elseif($days == -1) $msg = lang('All').' '.lang('Problems').' ('.$count.') ';
		else $msg = lang('All').' '.lang('OpenProblemsLC').' ('.$count.') ';
		break;
	case 'assigned':
		$msg = lang('OpenProblemsFor');
		$msg = $msg.' '.currentuserinfo('name').' ('.$count.') ';
		break;
	case 'submitted':
		$msg = lang('ProblemsSubmittedBy');
		$msg = $msg.' '.currentuserinfo('name').' ('.$count.') ';
		break;
}
?>
<script language="javascript">displayMessage('<?php echo $msg;?>');</script>
