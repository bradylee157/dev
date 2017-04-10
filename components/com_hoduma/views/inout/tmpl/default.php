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
if(!checkusermin('rep')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

$userlvl = userlevel();

//build link for re-sorting table
$sortlink = JFilterOutput::ampReplace('index.php?option='.JRequest::getCmd('option').'&view='.JRequest::getVar('view','').'&type='.JRequest::getVar('type','').'&Itemid='.JRequest::getVar('Itemid',''));

if(JRequest::getVar('sort')=='a') $sortlink = $sortlink.'&sort=d';
else $sortlink = $sortlink.'&sort=a';

//Pagination
// Get data from the model
$items =& $this->get('Data');      
$pagination =& $this->get('Pagination');
// push data into the template
$this->assignRef('items', $items);     
$this->assignRef('pagination', $pagination);

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
<?php 

//setup toolbar
if(JRequest::getVar('type')=='rep') toolbar('inoutall','refresh','home');
else toolbar('inoutrep','refresh','home');
?>
<form action="index.php" method="post" name="adminForm">
	<table class="userlist">
		<thead>
			<tr>
				<th align="center"><?php echo lang('In');?></th>
				<th align="center"><?php echo lang('Out');?></th>
				<th align="center"><a href="<?php echo $sortlink;?>&order=username" class="listhead"><?php echo lang('Username');?></a></th>
				<th align="center"><a href="<?php echo $sortlink;?>&order=name" class="listhead"><?php echo lang('Name');?></a></th>
				<th align="center"><a href="<?php echo $sortlink;?>&order=email" class="listhead"><?php echo lang('Email');?></a></th>
				<th align="center"><?php echo lang('Rep');?></th>
				<th align="center"><?php echo lang('Admin');?></th>
			</tr>
		</thead>
		
		<?php 
		$k = 0;
		
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			?>
			
			<tr>
				<?php 
				$query = "SELECT username FROM #__session WHERE guest<>1 AND username='".$row->username."'";
				$db =& JFactory::getDBO();
				$db->setQuery($query);
				$online = $db->loadRow();
				?>
				
				<td align="center" class="problemlist"> 
					<?php 
					if(isset($online[0]) && strlen($online[0])>0)//##my201004080318 Fix warning. It was: if(strlen($online[0])>0)
					{
						?>
						<img src="media/com_hoduma/images/circle_green_16.png" class="userstatusicon"/>
						<?php 
					}
					?>
				</td>
				<td align="center" class="problemlist"> 
					<?php 
					if(!isset($online[0]) || strlen($online[0])<=0) //##my201004080318 Fix warning. It was: if(strlen($online[0])<=0)
					{
						?>
						<img src="media/com_hoduma/images/circle_red_16.png" class="userstatusicon"/>
						<?php 
					}
					?>
				</td>
				<td align="center" class="problemlist"> 
					<?php echo $row->username; ?>
				</td>
				<td align="center" class="problemlist"> 
					<?php echo $row->name; ?>
				</td>
				<td align="center" class="problemlist"> 
					<?php echo $row->email; ?>
				</td>
				<td align="center" class="problemlist"> 
					<?php 
					if($row->isrep == 1)
					{
						?>
						<img src="media/com_hoduma/images/circle_blue_16.png" class="userstatusicon"/>
						<?php 
					}
					?>
				</td>
				<td align="center" class="problemlist"> 
					<?php 
					if($row->isadmin == 1)
					{
						?>
						<img src="media/com_hoduma/images/circle_blue_16.png" class="userstatusicon"/>
						<?php 
					}
					?>
				</td>
			</tr>
			<?php 
			$k = 1 - $k;
		}
		?>
	</table>
	<table class="pagination" align="center">
		<tr>
			<td class="pagination" colspan="6"><?php echo $this->pagination->getListFooter();?></td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getCmd('option'); ?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="type" value="<?php echo JRequest::getVar('type',''); ?>" />
	<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<script language="javascript">displayMessage('<?php if(JRequest::getVar('type')=='rep') echo lang('RepsAdmins');else echo lang('AllUsers');?>');</script>
	
	

		