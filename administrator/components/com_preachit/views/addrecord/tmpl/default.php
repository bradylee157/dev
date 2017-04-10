<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script type="text/javascript">
			function createrecord()
			{
			
				if (document.getElementById("name").value == '') {
			alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_NAME');?>");
			} 
			 else {

						var name = document.getElementById("name").value;	
						<?php if ($this->record == 'teacher')
						{?>
						if (document.getElementById("tview0").checked)
						{var tview = 0;}
						else
						{var tview = 1;}
						var urldetails = 'tview='+tview+'&name='+name+'&record=<?php echo $this->record;?>';
						<?php } 
						else {?>
						var urldetails = 'name='+name+'&record=<?php echo $this->record;?>';
						<?php } ?>
						var addentry = 'error';				
				<!-- load revolving gif -->
				
				var revolve = document.getElementById('pirevolvegif').src;
				document.getElementById('pisubmit').innerHTML = '<div style="text-align: center;"><img style="margin: 0 50%;" src="'+revolve+'"></div>';	
				var token = '<?php echo JUtility::getToken();?>=1';
				var url = 'index.php?option=com_preachit&controller=studylist&task=createrecord&format=raw&'+token+'&'+urldetails;	
				<!-- Ajax call to get select string -->

				var container = new Element('div', { 'class': 'meltempcontainer',
                                         'styles': { 'display': 'none'
                                                   }	});	
					var XHRCheckin = new Request.HTML({
					url: url, 
					method: 'get',
					update: container,
					onComplete: function() {
						var response = container.innerHTML;
						addentry = response;
					if (addentry != 'error')
					{<?php if ($this->record == 'teacher')
					{?>
						var formid = 'jform_teacher';	
					<?php }		
					if ($this->record == 'series')
					{?>
						var formid = 'jform_series';	
					<?php }
					if ($this->record == 'ministry')
					{?>
						var formid = 'jform_ministry';	
					<?php } ?>
					var str = window.parent.document.getElementById(formid).innerHTML;
					str = str.replace(/selected="selected"/g, '');
					window.parent.document.getElementById(formid).innerHTML = str+addentry;
					window.parent.SqueezeBox.close();
					return false;}
					else {document.getElementById('pisubmit').innerHTML = '<dl id="system-message"><dt class="message">Message</dt><dd class="error error"><ul><li><?php echo JText::_('COM_PREACHIT_WAS_ERROR');?></li></ul></dd></dl>';}
						}
					
					}).send();
				
			}
            }
		</script>
		
		<style>
			.edittitle {
				font-size: 24px; 
				font-weight: bold; 
				line-height: 40px;
			}

			.mesimage {
				vertical-align: middle; 
				margin: 5px 10px 5px 5px;
			}	
				
			table.admintable td { 
				padding: 3px; 
			}
			table.admintable td.key {
				background-color: #f6f6f6;
				text-align: right;
				width: 140px;
				color: #666;
				font-weight: bold;
				border-bottom: 1px solid #e9e9e9;
				border-right: 1px solid #e9e9e9;
			}
			table.adminform td { 
				padding: 3px; 
				text-align: left; 
			}
		</style>

		<div class="edittitle"><img class="mesimage" src="../components/com_preachit/assets/images/icon-48-preachit.png">
		<?php echo $this->heading.'</div>';
		?>
		<hr class="sep">
		<form>
		<table class="admintable" width="100%" align="center">
			<tr>
				<td class="key" width="100">
					<label for="title">
						<?php echo JText::_( 'COM_PREACHIT_ADMIN_NAME' ); ?>
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="name" id="name" size="60" maxlength="250" value ="" />
				</td>
			</tr>
			<?php if ($this->record == 'teacher')
			{?>
			<tr>
				<td class="key">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_ADMIN_TEACHER_PAGE' ); ?>
					</label>
				</td>
				<td>
					<?php echo $this->tview;?>
				</td>
			</tr>
			<?php } ?>
		</table>
		</form>
		<!-- load revolving gif image into memory with display none so not shown -->
 		<img id="pirevolvegif" style="display:none;" src="../components/com_preachit/assets/images/ajax-loader.gif">
 		<div id="pisubmit">
		<button id="submitbutton" style="margin: 10px 0 0 150px;" onclick="createrecord();"><?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_CREATE_RECORD' ); ?></button>
		</div>
