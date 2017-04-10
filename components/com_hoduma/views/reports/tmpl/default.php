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

//make sure we are allowed to view reports
if(!checkuser('reports')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH')); 

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
toolbar('viewreport','reset','home');

?>
<form action="index.php?option=<?php echo JRequest::getCmd('option');?>&view=report&Itemid=<?php echo JRequest::getVar('Itemid','')?>" method="post" name="reportForm" id="reportFormId">
	<table class="problemdetail searchtable">
		<tr>
			<td class="problemhead">
				<?php echo lang('SearchCriteria');?>
			</td>
		</tr>
		<tr>
			<td class="problemfieldname">
				<?php echo lang('AvailableReports');?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="rtype" value="department" checked><?php echo lang('Department');?><br />
				<input type="radio" name="rtype" value="category"><?php echo lang('Category');?><br />
				<input type="radio" name="rtype" value="rep"><?php echo lang('SupportRep');?><br />
			</td>
		</tr>
		<tr>
			<td class="problemfieldname">
				<?php echo lang('DateRange');?>: (YYYY-MM-DD)
			</td>
		</tr>
		<tr>
			<td>
				<?php echo lang('StartDate');?>: <?php echo JHTML::calendar(strftime("%Y-%m-%d", strtotime("-1 year")),'startdate','startdate','%Y-%m-%d');?><br />
				<?php echo lang('EndDate');?>: <?php echo JHTML::calendar(date('Y-m-d'),'enddate','enddate','%Y-%m-%d');?>
			</td>
		</tr>
	</table>
</form>
<script language="javascript">displayMessage('<?php echo lang('EnterReport');?>');</script>
