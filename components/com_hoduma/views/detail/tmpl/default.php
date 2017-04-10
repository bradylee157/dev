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
if(!checkusermin('user') && !config('allowanonymous')) $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));

if(DEBUG) $mainframe->enqueueMessage('Detail view');

/* Include Recruiting Parser code for BBCode use */
/* See parser.php file for copyright */
require_once JPATH_COMPONENT.DS.'helpers'.DS.'parser.php'; // path to Recruiting Parsers' file
$parser = new parser; //  start up Recruiting Parsers

//get user auth level
$userlvl = userlevel();

//check to see if we are dealing with a new problem or an existing problem
if(isset($this->row->id) && $this->row->id >= 0) $newproblem = false;
else $newproblem = true;

//if user is a user or anonymous, then they can't just view any case unless its a knowledgebase case from a kb search
if(!(	config('enablekb') > KB_LEVEL_DISABLE /*if kb is enabled*/ 
		&& $this->row->kb==1 /*and this is a kb case*/ 
		&& $mainframe->getUserState('hh_list.stype','stype','')=='kb' /*and we're coming from a kb search*/
	) 
	&& 	!$newproblem /*it's not a new problem*/
	&& 	$userlvl <= USER_LEVEL_USER /*the user is a user or anonymous*/
	&& 	!caseauthor($this->row->uid, $this->row->uemail, safe(JRequest::getVar('chk','','','string',JREQUEST_ALLOWRAW))) /*the user is not the case author*/
	) $mainframe->redirect('index.php?option='.JRequest::getCmd('option').'&Itemid='.JRequest::getVar('Itemid'), JText::_(lang('NotFound')));

//determine if form can be edited based on user level and case status
$editable = editable($userlvl, $this->row->status);

//determine if we are in a print view
if(JRequest::getVar('print')==1) $printing = true;
else $printing = false;

//if its a new problem, find the default status and priority
if($newproblem)
{
	//$query = 'SELECT defaultpriority, defaultstatus FROM #__hoduma_config';
	//$db =& JFactory::getDBO();
	//$db->setQuery($query);
	//$crow = $db->loadRow();
	//$defaultpriority = $crow[0];	
	//$defaultstatus = $crow[1];
	
	$defaultpriority = $this->cparams->get('defaultpriority');
	$defaultstatus = $this->cparams->get('defaultstatus');
	
	$defaultuser = currentuserinfo('hoduma_id'); //this will default the user select box - not sure if we want to do this due to user confusion
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

//list type we are coming from
$type = $mainframe->getUserStateFromRequest('hh_list.type','type','');

//setup toolbar
//if we're in a print view, just give us the print buttons
if($printing)
{
	toolbar('printout','closeprint');
}
//if the case is closed (not editable) and we are admin, let us reopen it
elseif(!$editable && $userlvl == USER_LEVEL_ADMIN)
{
	toolbar('reopen','print','close','refresh','home');
}
//if the case is generally editable, is a new problem, or we entered the case, let us add notes & save
//elseif($editable || $newproblem || (caseauthor($this->row->uid,'','') && $userlvl > USER_LEVEL_NONE)) toolbar('saveproblem','print','close','refresh','home');
elseif(!closed($this->row->status) && ($editable || $newproblem || caseauthor($this->row->uid, $this->row->uemail, safe(JRequest::getVar('chk','','','string',JREQUEST_ALLOWRAW)))))
{
	if($newproblem) {
		toolbar('submitproblem','print','close','refresh','home');
	} else {
		toolbar('saveproblem','print','close','refresh','home');
	}
}
//otherwise, just give us the ability to print
else
{
	toolbar('reopen','print','close','refresh','home');//##my201004090326 Add reopen possibility. It was: else toolbar('print','close','refresh','home');
}
?>
<form action="index.php?option=<?php echo JRequest::getCmd('option');?>" method="post" name="problem_form" id="problem_formid" enctype="multipart/form-data">
	<div class="problemdetailform">
		<?php
		if($mainframe->getUserState('hh_list.stype','stype','')!='kb')
		{
			?>
			<div class="hite">
				<div class="problemcolumn problemcolumnleft">
					<div class="problemcolumnhead">
					<?php
					if($userlvl >= config('show_username') || $userlvl >= config('show_email') || $userlvl >= config('show_department') || $userlvl >= config('show_location') || $userlvl >= config('show_phone') || $userlvl >= config('userselect'))
					{
						echo lang('ContactInformation');
					}
					?>
					</div>
					<div class="problemcolumndetail">
					
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_username'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('UserName');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_username') && $newproblem && !$printing)
								{
									?>
									<input type="text" class="detail" name="uid" id="uidid" size="30" maxlength="255" value="<?php echo safe_out(currentuserinfo('username'));?>" /><font color="red">*</font>
									<?php 
								}
								else
								{
									echo safe_out($this->row->uid);
									?>
									<input type="hidden" class="detail" name="uid" id="uidid" value="<?php echo safe_out($this->row->uid);?>" />
									<?php 
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_email'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Email');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_email') && $newproblem && !$printing)
								{
									?>
									<input type="text" class="detail" name="uemail" id="uemailid" size="30" maxlength="255" value="<?php echo safe_out(currentuserinfo('email'));?>" /><font color="red">*</font>
									<?php 
								}
								elseif($userlvl >= config('set_email') && $editable && !$printing)
								{
									?>
									<input type="text" class="detail" name="uemail" id="uemailid" size="30" maxlength="255" value="<?php echo safe_out($this->row->uemail);?>" /><font color="red">*</font>
									<?php 
								}
								else echo safe_out($this->row->uemail);
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_department'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Department');?>: </div>
								<div class="problemfield">
								<?php 

								if($userlvl >= config('set_department') && $newproblem && !$printing)
								{
									?>
									<select class="detail" name="department" id="departmentid">
										<option class="detail" value="-1"><?php echo lang('SelectDepartment');?></option>
										<?php
										//get list of departments
										$query = "SELECT * FROM #__hoduma_departments ORDER BY dname";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $drow)
										{
											?>
											<option class="detail" value="<?php echo $drow['id'];?>" <?php if(currentuserinfo('department')==$drow['id']) echo " selected";?> ><?php echo $drow['dname'];?></option>
											<?php
										}
										?>
									</select><font color="red">*</font>
									<?php 
								}
								elseif($userlvl >= config('set_department') && $editable && !$printing)
								{
									?>
									<select class="detail" name="department" id="departmentid">
										<?php
										if($newproblem)
										{
											?>
											<option class="detail" value="-1"><?php echo lang('SelectDepartment');?></option>
											<?php
										}
										//get list of departments
										$query = "SELECT * FROM #__hoduma_departments ORDER BY dname";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $drow)
										{
											?>
											<option class="detail" value="<?php echo $drow['id'];?>" <?php if($this->row->department==$drow['id']) echo " selected";?> ><?php echo $drow['dname'];?></option>
											<?php
										}
										?>
									</select>
									<?php 
								}
								else
								{
									//get departments
									$query = "SELECT * FROM #__hoduma_departments WHERE id=".$this->row->department;
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									$department = $db->loadRow();
									//##my201004071556 {added to hide warning
									if (!isset ($department[1]) ) {
										$department[1] = null;
									}
									//##my201004071556 }
									echo $department[2];
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_location'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Location');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_location') && $newproblem && !$printing)
								{
									?>
									<input class="detail" type="text" name="ulocation" id="ulocationid" size="30" maxlength="255" value="<?php echo safe_out(currentuserinfo('location1'));?>" />
									<?php 
								}
								elseif($userlvl >= config('set_location') && $editable && !$printing)
								{
									?>
									<input class="detail" type="text" name="ulocation" id="ulocationid" size="30" maxlength="255" value="<?php echo safe_out($this->row->ulocation);?>" />
									<?php 
								}
								else echo safe_out($this->row->ulocation);
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_phone'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Phone');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_phone') && $newproblem && !$printing)
								{
									?>
									<input class="detail" type="text" name="uphone" id="uphoneid" size="30" maxlength="255" value="<?php echo safe_out(currentuserinfo('phone'));?>" />
									<?php 
								}
								elseif($userlvl >= config('set_phone') && $editable && !$printing)
								{
									?>
									<input class="detail" type="text" name="uphone" id="uphoneid" size="30" maxlength="255" value="<?php echo safe_out($this->row->uphone);?>" />
									<?php 
								}
								else echo safe_out($this->row->uphone);
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<p> </p>
							<?php
							
							//if(($newproblem && $userlvl > USER_LEVEL_NONE && userselect()) && !$printing) //dont show the user select drop down for anonymous
							if(($newproblem && $userlvl >= config('userselect')) && !$printing) //dont show the user select drop down for anonymous
							{
								//if *any* of the user fields are shown, show the 'or' text - otherwise don't
								?><div class="problemfieldname2"><?php
								if($userlvl >= config('show_username') || $userlvl >= config('show_email') || $userlvl >= config('show_department') || $userlvl >= config('show_location') || $userlvl >= config('show_phone'))
								{
									echo lang('Or').'&nbsp;';
								}
								echo lang('SelectUser');?>: </div>
								<div class="problemfield">
								<select class="detail" name="userselect" id="userselectid">
									<option class="detail" value="-1"><?php echo lang('SelectUser');?></option>
									<?php
									//get list of users
									$query = "SELECT ju.username as username, ju.name as name, hh.id as id FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id ORDER BY ju.username";
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									foreach($db->loadAssocList() as $urow)
									{
										?>
										<option class="detail" value="<?php echo $urow['id'];?>"><?php echo $urow['username'].' ('.$urow['name'].')';?></option>
										<?php
									}
									?>
								</select><font color="red">*</font> 
								<?php
								//if *any* of the user fields are shown, show the 'override' text - otherwise don't
								if(config('show_username') || config('show_email') || config('show_department') || config('show_location') || config('show_phone'))
								{
									echo lang('SelectOverride');
								}
								?>
								</font>
								</div><div class="problemclear"></div>
								<?php 
							}

							if(!$newproblem && !$printing)
							{
								?>
								<div class="problemfieldname2"><?php echo lang('EnteredBy');?>: </div>
								<div class="problemfield">
								<?php 
								//get user
								$query = "SELECT ju.name FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.id = ".$this->row->entered_by;
								$db =& JFactory::getDBO();
								$db->setQuery($query);
								$by = $db->loadRow();
								//##my201004071556 {added to hide warning
								if (!isset ($by[0]) ) {
									$by[0] = null;
								}
								//##my201004071556 }
								echo $by[0];
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="problemcolumn problemcolumnright">
					<div class="problemcolumnhead">
					<?php
					//don't show the header if all the fields under it are hidden
					if($userlvl >= config('show_category') || $userlvl >= config('show_status') || $userlvl >= config('show_priority') || $userlvl >= config('show_rep') || $userlvl >= config('show_timespent'))
					{
						echo lang('Classification');
					}
					?>
					</div>
					<div class="problemcolumndetail">
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_category'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Category');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_category') && ($editable || $newproblem) && !$printing)
								{
									?>
									<select class="detail" name="category" id="categoryid">
										<?php
										if($newproblem)
										{
											?>
											<option value="-1"><?php echo lang('SelectCategory');?></option>
											<?php
										}
										//get list of categories
										$query = "SELECT * FROM #__hoduma_categories ORDER BY cname";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $crow)
										{
											?>
											<option class="detail" value="<?php echo $crow['id'];?>" <?php if($this->row->category==$crow['id']) echo " selected";?> ><?php echo $crow['cname'];?></option>
											<?php
										}
										?>
									</select>
									<?php 
									if(config('require_category')) echo '<font color="red">*</font>';
								}
								else
								{
									$query = "SELECT cname FROM #__hoduma_categories WHERE id=".$this->row->category;
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									$category = $db->loadRow();
									//##my201004071556 {added to hide warning
									if (!isset ($category[0]) ) {
										$category[0] = null;
									}
									//##my201004071556 }
									echo $category[0];
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_status'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Status');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_status') && ($editable || $newproblem) && !$printing)
								{
									?>
									<select class="detail" name="status" id="statusid">
										<?php
										//get list of statuses
										$query = "SELECT id, sname FROM #__hoduma_statuses WHERE published = 1 ORDER BY ordering";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $srow)
										{
											?>
											<option class="detail" value="<?php echo $srow['id'];?>"<?php /*##my201004080356. Fix incorrect array. It was: <option value="<?php echo $srow[id];?>"  */?>
											<?php if($this->row->status==$srow['id'] || ($newproblem && $defaultstatus==$srow['id'])) echo " selected";?> 
											>
											<?php echo $srow['sname'];?></option>
											<?php
										}
										?>
									</select>
									<?php 
								}
								else
								{
									//##my201004071556 {added to hide warning
									if (!isset ($this->row->status) ) {
										$this->row->status = 0;
									}
									//##my201004071556 }
									$query = "SELECT sname FROM #__hoduma_statuses WHERE id=".$this->row->status;
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									$status = $db->loadRow();
									//##my201004071556 {added to hide warning
									if (!isset ($status[0] )) {
										$status[0] = null;
									}
									//##my201004071556 }
									echo $status[0];
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_priority'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('Priority');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_priority') && ($editable || $newproblem) && !$printing)
								{
									?>
									<select class="detail" name="priority" id="priorityid">
										<?php
										//get list of priorities
										$query = "SELECT * FROM #__hoduma_priorities ORDER BY id";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $prow)
										{
											?>
											<option class="detail" value="<?php echo $prow['id'];?>" 
											<?php if($this->row->priority==$prow['id'] || ($newproblem && $defaultpriority==$prow['id'])) echo " selected";?> 
											>
											<?php echo $prow['pname'];?></option>
											<?php
										}
										?>
									</select>
									<?php 
								}
								else
								{
									//##my201004071556 {added to hide warning
									if (!isset ($this->row->priority) ) {
										$this->row->priority = 0;
									}
									//##my201004071556 }
									$query = "SELECT pname FROM #__hoduma_priorities WHERE id=".$this->row->priority;
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									$priority = $db->loadRow();
									//##my201004071556 {added to hide warning
									if (!isset ($priority[0]) ) {
										$priority[0] = null;
									}
									echo $priority[0];
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_rep'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('AssignedTo');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_rep') && ($editable || $newproblem) && !$printing)
								{
									?>
									<select class="detail" name="rep" id="repid">
										<?php
										if($newproblem)
										{
											?>
											<option class="detail" value="-1">
											<?php
											if(config('require_rep')) echo lang('SelectRep');
											else echo lang('DefaultAssignment');
											?>
											</option>
											<?php
										}
										//get list of reps
										$query = "SELECT * FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.isrep=1 ORDER BY ju.name";
										$db =& JFactory::getDBO();
										$db->setQuery($query);
										foreach($db->loadAssocList() as $rrow)
										{
											?>
											<option class="detail" value="<?php echo $rrow['id'];?>" <?php if($this->row->rep==$rrow['id']) echo " selected";?> ><?php echo $rrow['name'];?></option>
											<?php
										}
										?>
									</select>
									<?php 
									if(config('require_rep')) echo '<font color="red">*</font>';
								}
								else
								{
									//##my201004071556 {added to hide warning
									if (!isset ($this->row->rep) ) {
										$this->row->rep = 0;
									}
									//##my201004071556 }
									$query = "SELECT ju.name FROM #__users AS ju JOIN #__hoduma_users AS hh ON ju.id = hh.joomla_id WHERE hh.id=".$this->row->rep;
									$db =& JFactory::getDBO();
									$db->setQuery($query);
									$rep = $db->loadRow();
									//##my201004071556 {added to hide warning
									if (!isset ($rep[0]) ) {
										$rep[0] = null;
									}
									//##my201004071556 }
									echo $rep[0];
								}
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if($userlvl >= config('show_timespent'))
							{
								?>
								<div class="problemfieldname2"><?php echo lang('TimeSpent');?>: </div>
								<div class="problemfield">
								<?php 
								if($userlvl >= config('set_timespent') && ($editable || $newproblem) && !$printing)
								{
									?>
									<input class="detail" type="text" name="time_spent" id="time_spentid" size="15" maxlength="255" value="<?php echo safe_out($this->row->time_spent);?>" /><?php echo ' ('.lang('minutes').')';?>
									<?php 
									if(config('require_timespent')) echo '<font color="red">*</font>';
								}
								else echo safe_out($this->row->time_spent).' ('.lang('minutes').')';
								?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
						
						<div class="problemcolumndetailfield">
							<?php
							if(!$newproblem) //don't show dates for new cases
							{
								?>
								<div class="problemfieldname2"><?php echo lang('StartDate');?>: </div>
								<div class="problemfield">
								<?php echo date('D, j M Y  g:i A',strtotime($this->row->start_date));?>
								</div>
								<div class="problemclear"></div>
								<div class="problemfieldname2"><?php echo lang('CloseDate');?>: </div>
								<div class="problemfield">
								<?php if($this->row->close_date >= $this->row->start_date) echo date('D, j M Y  g:i A',strtotime($this->row->close_date));?>
								</div>
								<div class="problemclear"></div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php 
		}
		?>

		<div class="probleminformation">
			<div class="problemhead"><?php echo lang('ProblemInformation');?></div>
			<span class="problemfieldname"><?php echo lang('Title');?>:</span> 
			<?php 
			if(($editable || $newproblem) && !$printing)
			{
				?>
				<input class="detail" type="text" name="title" id="titleid" size="100" maxlength="255" value="<?php echo safe_out($this->row->title);?>" />
				<?php 
			}
			else
			{
				?>
				<div class="notetext"><?php echo safe_out($this->row->title);?></div>
				<?php
			}
			?>
			<br />
			<span class="problemfieldname"><?php echo lang('Description');?> </span>
			<?php 
			if(($editable || $newproblem) && !$printing)
			{
				if(config('use_bbcode')) echo '<script>edToolbar("descriptiontext"); </script>';
				?>
				<textarea id="descriptiontext" name="description" cols="85" rows="8" class="editor_ed problemtext"><?php echo safe_out($this->row->description);?></textarea>
				<?php 
			}
			else 
			{
				?>
				<div class="notetext">
					<?php
					//if bbcode is enabled, then parse the output, otherwise just format it normally
					if(config('use_bbcode') && isset($this->row->description) && strlen($this->row->description)>0) echo formatWhitespace(($parser->p($this->row->description,1))); //parser cleans HTML chars, so no safe_out needed
					else echo formatROText(safe_out($this->row->description));				
					?>
				</div>
				<?php
			}
			?>
		</div>

		<div class="probleminformation">
			<div class="problemhead"><?php echo lang('Notes');?></div>
			<?php
			//get all the notes for the case
			$query = "SELECT * FROM #__hoduma_notes WHERE problem_id = ".$this->row->id;
			if(!checkusermin('rep')) $query = $query." AND priv <> 1"; //keeps private notes from users - reps & admins can see all notes
			$query = $query." ORDER BY adddate ASC, id ASC";
			$db =& JFactory::getDBO();
			$db->setQuery($query);
			if(isset($this->row->id)) $notesArray = $db->loadAssocList();
			
			if(count($notesArray) > 0)
			{
				foreach($notesArray as $nrow)
				{
					?>
					<div class="problemnote">
						<div class="notetext"><b><?php echo $nrow['adddate'].' '.$nrow['uid']; /*if(checkusermin('rep')) echo ' - ['.$nrow['ip'].'] ';*/ if($nrow['priv']==1) echo ' (Private)';?></b><br/ >
							<?php 
							if($userlvl >= config('fileattach_download'))
							{
								$attachment_id = get_attachment_id($nrow['id']);
								$attachment_name = get_attachment_name($attachment_id);
								$attachment_url = 'components/com_hoduma/helpers/download.php?id='.$attachment_id.'&name='.$attachment_name.'&note_id='.$nrow['id'];
								if(strlen($attachment_id) > 0) 
								{
									if(checkuser('admin')) echo '<span class="delete" name="delattach" id="delattachid" onclick="deleteattachment('.$attachment_id.');">X</span>';
									echo '<b>'.lang('Attachment').':</b> <a href="'.$attachment_url.'">'.$attachment_name."</a>";
									echo '<br />';
								}
							}

							//if bbcode is enabled, then parse the output, otherwise just format it normally
							if(config('use_bbcode') && isset($nrow['note']) && strlen($nrow['note'])>0) echo formatWhitespace($parser->p($nrow['note'],1)); //parser cleans HTML chars, so no safe_out needed
							else echo formatROText(safe_out($nrow['note']));

							?>
						</div>
					</div>
					<?php 
				}
			}
			?>
		</div>

		<div class="probleminformation">
			<?php
			//all users are allowed to add notes to cases if they submitted the case, we are not closed, and we are not printing
			if($newproblem || ($editable || submitted($this->row->entered_by) || caseauthor($this->row->uid, $this->row->uemail, safe(JRequest::getVar('chk','','','string',JREQUEST_ALLOWRAW)))) && !$printing && !closed($this->row->status))
			{
				?>
				<div class="problemhead"><?php echo lang('EnterAdditionalNotes');?></div>
				<?php if(config('use_bbcode')) echo '<script>edToolbar("newnotetext"); </script>';?>
				<textarea name="newnote" id="newnotetext" cols="85" rows="8" class="editor_ed problemtext"></textarea>
				<div class="problemtextunder">
					<?php
					//but only reps & admins can make notes private
					if($editable && !$printing)
					{
						?>
						<div class="problemtextunderleft">
							<input type="checkbox" name="privatenote" id="privatenoteid" value="1" />
							<?php echo lang('HideFromEndUser');?>
						</div>
						<?php 
					}
					else echo "";//this is here for formatting reasons
					
					//only show the file input if file upload is enabled for this user
					if(userlevel() >= config('fileattach_allow'))
					{
						?>
						<span class="attachtext"><?php echo lang('AttachFileToNote');?>:&nbsp;<input type="file" name="userfile" id="file" class="fileupload"></span>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<div class="probleminformation">
			<div class="problemhead"><?php echo lang('Solution');?></div>
			<?php 
			if($editable && !$printing)
			{
				if(config('use_bbcode')) echo '<script>edToolbar("solutiontext"); </script>';
				?>
				<textarea name="solution" id="solutiontext" cols="85" rows="8" class="editor_ed problemtext"><?php echo safe_out($this->row->solution);?></textarea>
				<?php 
			}
			else 
			{
				?>
				<div class="problemnote">
					<div class="notetext">
						<?php
						//if bbcode is enabled, then parse the output, otherwise just format it normally
						if(config('use_bbcode') && isset($this->row->solution) && strlen($this->row->solution)>0) echo formatWhitespace($parser->p($this->row->solution,1)); //parser cleans HTML, so no safe_out needed
						else echo formatROText(safe_out($this->row->solution));				
						?>
					</div>
				</div>
				<?php
			}

			if($editable && !$printing)
			{
				?>
				<div class="problemtextunder">
					<input type="checkbox" name="kb" id="kbid" value="1" <?php if($this->row->kb==1) echo 'checked';?> />
					<?php echo lang('EnterinKnowledgeBase');?>
				</div>
				<?php 
			}
			?>	
		</div>
	</div>
	
	<input type="hidden" name="id" id="idid" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="cid[]" id="cidid" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="option" id="optionid" value="<?php echo JRequest::getCmd('option'); ?>" />
	<input type="hidden" name="task" id="taskid" value="save" /><!-- this is here to make up for bad IE behavior-->
	<input type="hidden" name="view" id="viewid" value="<?php echo safe_out(JRequest::getVar('view','')); ?>" />
	<input type="hidden" name="type" id="typeid" value="<?php echo safe_out(JRequest::getVar('type','')); ?>" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo safe_out(JRequest::getVar('Itemid','')); ?>" />
	<input type="hidden" name="chk" id="chkid" value="<?php echo safe_out(JRequest::getVar('chk','')); ?>" />
	<input type="hidden" name="newproblem" id="newproblemid" value="<?php echo $newproblem; ?>" />
	<input type="hidden" name="anon" id="anonid" value="<?php if($userlvl == USER_LEVEL_NONE) echo '1'; ?>" />
	<input type="hidden" name="attachment_id" id="attachment_idid" value="" />

	<?php echo JHTML::_('form.token'); ?>

</form>

<?php 

//setup toolbar
//if we're in a print view, just give us the print buttons
if($printing)
{
	toolbar('printout','closeprint');
}
//if the case is closed (not editable) and we are admin, let us reopen it
elseif(!$editable && $userlvl == USER_LEVEL_ADMIN)
{
	toolbar('reopen','print','close','refresh','home');
}
//if the case is generally editable, is a new problem, or we entered the case, let us add notes & save
//elseif($editable || $newproblem || (caseauthor($this->row->uid,'','') && $userlvl > USER_LEVEL_NONE)) toolbar('saveproblem','print','close','refresh','home');
elseif(!closed($this->row->status) && ($editable || $newproblem || caseauthor($this->row->uid, $this->row->uemail, safe(JRequest::getVar('chk','','','string',JREQUEST_ALLOWRAW)))))
{
	if($newproblem) {
		toolbar('submitproblem','print','close','refresh','home');
	} else {
		toolbar('saveproblem','print','close','refresh','home');
	}
}
//otherwise, just give us the ability to print
else
{
	toolbar('print','close','refresh','home');
}

?>

<?php if(DEBUG) dumpdebug();?>

<?php 
	if($newproblem) $msg = lang('NewProblem');
	else $msg = lang('ProblemNumber').$this->row->id;
?>
<script language="javascript">displayMessage('<?php echo $msg;?>');</script>