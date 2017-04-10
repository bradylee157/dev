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

//get user type
require_once JPATH_COMPONENT.DS.'helpers'.DS.'head.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'auth.php';
$mainframe = &JFactory::getApplication();	

$Itemid = JRequest::getVar('Itemid');
$userlvl = userlevel();

//make sure we are allowed to search for the type of search we want to perform
$stype = $mainframe->getUserStateFromRequest('hh_list.stype','stype','');
if($stype != 'all' && $stype != 'kb') $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH')); //only accept allowed search types
if($stype == 'all' && $userlvl < USER_LEVEL_ADMIN) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH')); //must be admin for full search
if($stype == 'kb') //if the type is kb, make sure we are authorized at the right level
{
	$kblevel = config('enablekb');
	if($kblevel==KB_LEVEL_DISABLE ||
	  ($kblevel==KB_LEVEL_USER && $userlvl < USER_LEVEL_USER) ||
	  ($kblevel==KB_LEVEL_REP  && $userlvl < USER_LEVEL_REP)) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH')); 
}

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
//if($stype == 'kb') toolbar('search','browse','reset','home');
if($stype == 'kb') toolbar('search','reset','home');
else toolbar('search','reset','home');

?>
<form action="index.php?option=<?php echo JRequest::getCmd('option');?>&view=hhlist&type=search&Itemid=<?php echo JRequest::getVar('Itemid','')?>" method="post" name="searchForm" id="searchFormId">
	<table class="problemdetail searchtable">
		<?php 
		if($stype == 'all') //only show the following fields if we are doing a full search, not a kb search
		{
			?>
			<tr>
				<div class="problemhead" colspan="2">
					<?php echo lang('SearchCriteria');?>
				</div>
			</tr>
			<tr class="searchfields">
				<td class="problemfieldname"><?php echo lang('UserName');?>: </td>
				<td>
					<input type="text" name="searchusername" id="searchusername" size="25" maxlength="255" />
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('ProblemID');?>: </td>
				<td>
					<input type="text" name="searchproblemid" id="searchproblemid" size="25" maxlength="255" />
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('AssignedTo');?>: </td>
				<td>
					<select name="searchrep" id="searchrep">
						<option value="-1">---</option>
						<?php
						//get list of reps
						$query = "SELECT * FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.isrep=1 ORDER BY ju.name";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						foreach($db->loadAssocList() as $rrow)
						{
							?>
							<option value="<?php echo $rrow['id'];?>"><?php echo $rrow['name'];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('Category');?>: </td>
				<td>
					<select name="searchcategory" id="searchcategory">
						<option value="-1">---</option>
						<?php
						//get list of categories
						$query = "SELECT * FROM #__hoduma_categories";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						foreach($db->loadAssocList() as $crow)
						{
							?>
							<option value="<?php echo $crow['id'];?>" ><?php echo $crow['cname'];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('Department');?>: </td>
				<td>
					<select name="searchdepartment" id="searchdepartment">
						<option value="-1">---</option>
						<?php
						//get list of departments
						$query = "SELECT * FROM #__hoduma_departments";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						foreach($db->loadAssocList() as $drow)
						{
							?>
							<option value="<?php echo $drow['id'];?>" ><?php echo $drow['dname'];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('Status');?>: </td>
				<td>
					<select name="searchstatus" id="searchstatus">
						<option value="-1">---</option>
						<?php
						//get list of statuses
						$query = "SELECT * FROM #__hoduma_statuses";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						foreach($db->loadAssocList() as $srow)
						{
							?>
							<option value="<?php echo $srow['id'];?>" ><?php echo $srow['sname'];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('Priority');?>: </td>
				<td>
					<select name="searchpriority" id="searchpriority">
						<option value="-1">---</option>
						<?php
						//get list of priorities
						$query = "SELECT * FROM #__hoduma_priorities";
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						foreach($db->loadAssocList() as $prow)
						{
							?>
							<option value="<?php echo $prow['id'];?>" ><?php echo $prow['pname'];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="problemfieldname"><?php echo lang('StartDate');?>: <br /> (YYYY-MM-DD)</td>
				<td class="problemfieldname">
					<?php echo lang('From');?>: <?php echo JHTML::calendar(strftime("%Y-%m-%d", strtotime("-1 year")),'searchstartdatefrom','searchstartdatefrom','%Y-%m-%d');?>&nbsp;&nbsp;&nbsp;
					<?php echo lang('To');?>: <?php echo JHTML::calendar(date('Y-m-d'),'searchstartdateto','searchstartdateto','%Y-%m-%d');?>
				</td>
			</tr>
			<?php 
		}
		?>
		<tr>
			<td class="problemfieldname"><?php echo lang('SearchText');?>: </td>
			<td>
				<input type="text" name="searchkeyword" id="searchkeyword" size="100" maxlength="255" />
			</td>
		</tr>
		<tr>
			<td class="problemfieldname"><?php echo lang('SearchFields');?>: </td>
			<td>
				<input type="checkbox" name="searchsubject" id="searchsubject" value="1" checked /><?php echo lang('Title');?><br />
				<input type="checkbox" name="searchdescription" id="searchdescription" value="1" checked /><?php echo lang('Description');?><br />
				<input type="checkbox" name="searchsolution" id="searchsolution" value="1" checked /><?php echo lang('Solution');?><br />
			</td>
		</tr>
	</table>

	<input type="hidden" name="view" id="view" value="list" />
	<input type="hidden" name="task" id="task" value="find" />
	<input type="hidden" name="type" id="type" value="search" />
	<input type="hidden" name="stype" id="stype" value="<?php echo JRequest::getVar('stype',''); ?>" />
</form>
<script language="javascript">displayMessage('<?php echo lang('EnterSearch');?>');</script>
