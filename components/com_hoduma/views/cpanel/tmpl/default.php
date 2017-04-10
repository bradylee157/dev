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

$Itemid = JRequest::getVar('Itemid');
$userlvl = userlevel();

//charting constants
$baseURL = 'http://chart.apis.google.com/chart?cht=p3&chs=250x100&chf=bg,s,00000000&chdls=000000,10';
$chartDataBase = '&amp;chd=t:';
$chartLabelsBase = '&amp;chdl=';
$chartColors = '&amp;chco=000088,cccccc';
$chartColors2 = '&amp;chco=aa0000,cccccc';
//$chartColors = '&amp;chco=ff0000|0000ff|00ffff|880000|008800|000088|ffff00';

//display page title if configured
$mainframe = &JFactory::getApplication();	
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

<form action="index.php" method="post" name="cpanelForm">
	<?php
	if(config('statuschart') && ($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP))
	{
		?>
		<div class="cpanelinfobox">
			<?php echo '<div class="cpanelinfoheader">'.lang('HelpdeskStatus').'</div>';?>
			<div class="cpanelinfo">
				<?php
				//get closed status since we ignore closed problems for this view
				//$query = 'SELECT s.id AS sid FROM #__hoduma_config AS c JOIN #__hoduma_status AS s ON s.id=c.closestatus';
				//$db =& JFactory::getDBO();
				//$db->setQuery($query);
				//$closed = $db->loadRow();
				$closed = $this->cparams->get('closedstatus');

				//get user id
				$user =& JFactory::getUser();
				$uid = $user->id;
				$query = 'SELECT id FROM #__hoduma_users WHERE joomla_id='.$uid;
				$db =& JFactory::getDBO();
				$db->setQuery($query);
				$hid = $db->loadRow();

				//count and display open problems assigned to user
				$query = 'SELECT COUNT(*) FROM #__hoduma_problems WHERE status <> '.$closed.' AND rep='.$hid[0];
				$db =& JFactory::getDBO();
				$db->setQuery($query);
				$count = $db->loadRow();
				echo '<div class="cpanelinfotext"><span class="cpanelinfotextlabel">'.lang('OpenProblemsFor').' '.currentuserinfo('name').':</span> '.$count[0].'</div>';

				if($count > 0)
				{
					//count cases assigned to user that are under each priority
					$query = 'SELECT pr.pname, count(*) as count FROM #__hoduma_problems p INNER JOIN #__hoduma_priorities pr ON p.priority = pr.id WHERE p.status <> '.$closed.' AND p.rep='.$hid[0].' GROUP BY pr.pname ORDER BY pr.id DESC';
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$prior = $db->loadAssocList();

					if(count($prior)>0)
					{
						$chartLabels = null;
						$chartData = null;

						for ($i = 0; $i < count($prior); $i++)
						{
							if(strlen($chartLabels) > 0) $chartLabels = $chartLabels.'|'; //add delimiter if this is not the first label
							if(strlen($prior[$i]['pname'])>0) $chartLabels = $chartLabels.$prior[$i]['pname'].': '.$prior[$i]['count']; else $chartLabels = $chartLabels.lang('Unknown');

							if(strlen($chartData) > 0) $chartData = $chartData.','; //add a delimiter if this is not the first data point
							$chartData = $chartData.$prior[$i]['count'];
						}

						//chart cases assigned to user by priority
						$chartURL = $baseURL.$chartDataBase.$chartData.$chartLabelsBase.$chartLabels.$chartColors;
						if(DEBUG) echo $chartURL;
						?>
						<img src="<?php echo $chartURL;?>" alt="<?php echo lang('PercentProblemTotal');?>" align="center"/></p>
						<?php 
					}
					
					//count cases assigned to user that are under each status
					$query = 'SELECT s.sname AS sname, count(*) as count FROM #__hoduma_problems p INNER JOIN #__hoduma_statuses s ON p.status = s.id WHERE p.status <> '.$closed.' AND p.rep='.$hid[0].' GROUP BY s.sname ORDER BY s.id ASC';
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$stat = $db->loadAssocList();

					if(count($stat)>0)
					{
						$chartLabels = null;
						$chartData = null;

						for ($i = 0; $i < count($stat); $i++)
						{
							if(strlen($chartLabels) > 0) $chartLabels = $chartLabels.'|'; //add delimiter if this is not the first label
							if(strlen($stat[$i]['sname'])>0) $chartLabels = $chartLabels.$stat[$i]['sname'].': '.$stat[$i]['count']; else $chartLabels = $chartLabels.lang('Unknown');

							if(strlen($chartData) > 0) $chartData = $chartData.','; //add a delimiter if this is not the first data point
							$chartData = $chartData.$stat[$i]['count'];
						}

						//chart cases assigned to user by status
						$chartURL = $baseURL.$chartDataBase.$chartData.$chartLabelsBase.$chartLabels.$chartColors2;
						if(DEBUG)echo $chartURL;
						?>
						<img src="<?php echo $chartURL;?>" alt="<?php echo lang('PercentProblemTotal');?>" align="center"/></p>
						<?php 
					}
				}

				if($userlvl==USER_LEVEL_ADMIN)
				{
					//count and display number of open cases in system
					$query = 'SELECT COUNT(*) FROM #__hoduma_problems WHERE status <> '.$closed;
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$count = $db->loadRow();
					echo '<div class="cpanelinfotext"><span class="cpanelinfotextlabel">'.lang('All').' '.lang('OpenProblemsLC').':</span> '.$count[0].'</div>';

					if($count > 0)
					{
						//count all cases that are under each priority
						$query = 'SELECT pr.pname, count(*) as count FROM #__hoduma_problems p INNER JOIN #__hoduma_priorities pr ON p.priority = pr.id WHERE p.status <> '.$closed.' GROUP BY pr.pname ORDER BY pr.id DESC';
						$db =& JFactory::getDBO();
						$db->setQuery($query);
						$prior = $db->loadAssocList();

						$chartLabels = null;
						$chartData = null;

						for ($i = 0; $i < count($prior); $i++)
						{
							if(strlen($chartLabels) > 0) $chartLabels = $chartLabels.'|'; //add delimiter if this is not the first label
							if(strlen($prior[$i]['pname'])>0) $chartLabels = $chartLabels.$prior[$i]['pname'].': '.$prior[$i]['count']; else $chartLabels = $chartLabels.lang('Unknown');

							if(strlen($chartData) > 0) $chartData = $chartData.','; //add a delimiter if this is not the first data point
							$chartData = $chartData.$prior[$i]['count'];
						}

						//chart cases assigned to user by priority
						$chartURL = $baseURL.$chartDataBase.$chartData.$chartLabelsBase.$chartLabels.$chartColors;
						if(DEBUG)echo $chartURL;
						?>
						<img src="<?php echo $chartURL;?>" alt="<?php echo lang('PercentProblemTotal');?>" align="center"/></p>
						<?php 
					}

					//count and display total number of cases in system
					$query = 'SELECT COUNT(*) FROM #__hoduma_problems';
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$count = $db->loadRow();
					echo '<div class="cpanelinfotext"><span class="cpanelinfotextlabel">'.lang('All').' '.lang('Problems').':</span> '.$count[0].'</div>';
					
					//count and display number of knowledgebase cases in system
					$query = 'SELECT COUNT(*) FROM #__hoduma_problems WHERE kb = 1';
					$db =& JFactory::getDBO();
					$db->setQuery($query);
					$count = $db->loadRow();
					echo '<div class="cpanelinfotext"><span class="cpanelinfotextlabel">'.lang('KnowledgebaseProblems').':</span> '.$count[0].'</div>';
				}
				?>
			</div>
		</div>
		<?php 
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP || $userlvl==USER_LEVEL_USER || $userlvl==USER_LEVEL_NONE)
	{
		if($userlvl!=USER_LEVEL_NONE || config('allowanonymous'))	
		{
			?>
			<img src="media/com_hoduma/images/add_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=detail&cid[]=-1&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('SubmitNewProblem');?></a><br />
			<?php 
		}
	}

	if($userlvl==USER_LEVEL_USER)
	{
		?>
		<img src="media/com_hoduma/images/user_add_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=list&type=submitted&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('ViewSubmittedProblems');?></a><br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP)
	{
		?>
		<img src="media/com_hoduma/images/user_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=list&type=assigned&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('ViewAssignedProblems');?></a><br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN)
	{
		?>
		<img src="media/com_hoduma/images/users_two_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=list&type=all&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('ViewProblemList');?></a><br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN)
	{
		?>
		<img src="media/com_hoduma/images/user2_24.png" class="cpanelicon"/>
		<?php echo lang('Viewproblemsfor');?> &nbsp;
		<select name="replist" id="replist" class="cpanel">
			<?php
			//get list of reps
			$query = "SELECT ju.name as name, hh.id as hid, hh.isrep FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.isrep = 1 ORDER BY ju.name";
			$db =& JFactory::getDBO();
			$db->setQuery($query);

			foreach($db->loadAssocList() as $urow)
			{
				?>
				<option class="cpanel" value="<?php echo $urow['hid'];?>"><?php echo $urow['name'];?></option>
				<?php
			}
			?>
		</select>&nbsp;
		<button class="cpanel" style="cursor:pointer;" onclick="window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=list&type=all&user=' + document.getElementById('replist').value;return false;"><?php echo lang('View'); ?></button>
		<br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN)
	{
		?>
		<img src="media/com_hoduma/images/newspaper_24.png" class="cpanelicon"/>
		<?php echo lang('ViewProblemsFromLast');?>
		<select name="days" id="days" class="cpanel">
			<option class="cpanel" value="-1"><?php echo lang('NoLimit');?></option>
			<option class="cpanel" value="1">1</option>
			<option class="cpanel" value="7">7</option>
			<option class="cpanel" value="8">8</option>
			<option class="cpanel" value="14">14</option>
			<option class="cpanel" value="30">30</option>
			<option class="cpanel" value="90">90</option>
			<option class="cpanel" value="365">365</option>
		</select>
		<?php echo lang('days').'.';?>&nbsp;&nbsp;
		<button class="cpanel" onclick="window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=list&type=all&days=' + document.getElementById('days').value;return false;"><?php echo lang('View');?></button>
		<button class="cpanel" onclick="window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=activity&days=' + document.getElementById('days').value;return false;"><?php echo lang('Activity');?></button>
		<br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP || $userlvl==USER_LEVEL_USER || ($userlvl==USER_LEVEL_NONE && config('allowanonymous')))
	{
		?>
		<img src="media/com_hoduma/images/folder_24.png" class="cpanelicon"/><?php echo lang('ProblemID');?>
		<input type="text" class="cpanel" name="problemid" id="problemidtext" size="6" maxlength="6"/>&nbsp;
		<?php 
		if($userlvl == USER_LEVEL_NONE)
		{
			?>
			&nbsp;<?php echo lang('EnterVerification');?>: <input type="text" class="cpanel" name="chk" id="chk" size="15" maxlength="255" value="<?php echo lang('EmailAddress');?>"/>&nbsp;
			<button class="cpanel" style="cursor:pointer;" onclick="window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=detail&cid[]=' + document.getElementById('problemidtext').value + '&chk=' + document.getElementById('chk').value;return false;"><?php echo lang('View');?></button><br />
			<?php
		}
		else
		{
		?>
			<button class="cpanel" style="cursor:pointer;" onclick="window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=detail&cid[]=' + document.getElementById('problemidtext').value;return false;"><?php echo lang('View');?></button><br />
		<?php
		}
	}

	if($userlvl==USER_LEVEL_ADMIN)
	{
		?>
		<img src="media/com_hoduma/images/cancel_24.png" class="cpanelicon"/><?php echo lang('DeleteProblem');?>
		<input type="text" class="cpanel" name="problemdeleteid" id="problemdeleteidtext" size="6" maxlength="6"/>&nbsp;
		<button class="cpanel" style="cursor:pointer;" onclick="if(confirmation(1)) window.location='index.php?option=com_hoduma&Itemid=<?php echo $Itemid;?>&view=cpanel&task=deletecase&id=' + document.getElementById('problemdeleteidtext').value;return false;"><?php echo lang('Delete');?></button><br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN)
	{
		?>
		<img src="media/com_hoduma/images/search_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=search&stype=all&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('SearchProblems');?></a><br />
		<?php
	}
	
	$kblevel = config('enablekb');
	if( 	$kblevel == KB_LEVEL_ALL
		|| ($kblevel == KB_LEVEL_USER  && $userlvl >= USER_LEVEL_USER) 
		|| ($kblevel == KB_LEVEL_REP   && $userlvl >= USER_LEVEL_REP)
		|| ($kblevel == KB_LEVEL_ADMIN && $userlvl >= USER_LEVEL_ADMIN)
		)
	{
		?>
		<img src="media/com_hoduma/images/lightbulb_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=search&stype=kb&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('SearchtheKnowledgeBase');?></a><br />
		<?php 
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP)
	{
		if(checkuser('reports'))
		{
			?>
			<img src="media/com_hoduma/images/paper_content_chart_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=reports&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('Reports');?></a><br />
			<?php 
		}
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP)
	{
		?>
		<img src="media/com_hoduma/images/green_pin.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=inout&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('InOutBoard');?></a><br />
		<?php
	}

	if($userlvl==USER_LEVEL_ADMIN || $userlvl==USER_LEVEL_REP || $userlvl==USER_LEVEL_USER)
	{
		?>
		<img src="media/com_hoduma/images/mail_write_24.png" class="cpanelicon"/><a class="cpanel" href="index.php?option=com_hoduma&view=editinfo&Itemid=<?php echo JRequest::getVar('Itemid',''); ?>"><?php echo lang('EditInformation');?></a>
		<?php
	}
	?>
	<input type="hidden" name="option" id="option" value="<?php echo JRequest::getCmd('option'); ?>" />
	<input type="hidden" name="view" id="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="type" id="type" value="<?php echo JRequest::getVar('type',''); ?>" />
	<input type="hidden" name="Itemid" id="itemid" value="<?php echo JRequest::getVar('Itemid',''); ?>" />
</form>

<?php if(DEBUG) dumpdebug();?>
