<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$jform = 'jform_';
if ($this->row)
{
?>
<script type="text/javascript">
			function insert3rdpartycode()
			{

						var study_name = document.getElementById("study_name").value;	
						var study_alias = document.getElementById("study_alias").value;
						var study_description = document.getElementById("study_description").value;
                        var tags = document.getElementById("tags").value;
						var dur_hrs = document.getElementById("dur_hrs").value;
						var dur_mins = document.getElementById("dur_mins").value;
						var dur_secs = document.getElementById("dur_secs").value;
						var video_link = document.getElementById("video_link").value;
						var video_type = document.getElementById("video_type").value;
						var imagelrg = document.getElementById("imagelrg").value;
						var image_folderlrg = document.getElementById("image_folderlrg").value;
						
				
				if (study_name) {
				window.parent.document.getElementById("<?php echo $jform;?>study_name").value = study_name;
				}
				if (study_alias) {
				window.parent.document.getElementById("<?php echo $jform;?>study_alias").value = study_alias;
				}
				if (study_description) {
				window.parent.document.getElementById("<?php echo $jform;?>study_description").value = study_description;
				}
                if (tags) {
                window.parent.document.getElementById("<?php echo $jform;?>tags").value = tags;
                }
				if (dur_hrs || dur_mins || dur_secs) {
				window.parent.document.getElementById("<?php echo $jform;?>dur_hrs").value = dur_hrs;
				window.parent.document.getElementById("<?php echo $jform;?>dur_mins").value = dur_mins;
				window.parent.document.getElementById("<?php echo $jform;?>dur_secs").value = dur_secs;
				}
				if (video_link) {
				window.parent.document.getElementById("<?php echo $jform;?>video_link").value = video_link;
				}
				if (video_type) {
				window.parent.document.getElementById("<?php echo $jform;?>video_type").value = video_type;
				}
				if (imagelrg) {
				window.parent.document.getElementById("<?php echo $jform;?>imagelrg").value = imagelrg;
				window.parent.document.getElementById("<?php echo $jform;?>image_folderlrg").value = image_folderlrg;
				}

				window.parent.document.getElementById("video_third").value = "";
				
				window.parent.SqueezeBox.close();
				return false;

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
			
			.inline-desc {
				padding: 0 5px;
				font-size: 10px;
			}
			.inline-desc-lt {
				padding: 0 5px 0 0;
				font-size: 10px;
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

		<div class="edittitle"><img class="mesimage" src="components/com_preachit/images/icon-48-preachit.png">
		<?php echo JText::_('COM_PREACHIT_ADMIN_THIRD_PARTY_DETAILS').'</div>';
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
					<input class="text_area" type="text" name="study_name" id="study_name" size="60" maxlength="250" value ="<?php echo $this->row->name;?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_ADMIN_ALIAS' ); ?>
					</label>
				</td>
				<td>
					<input class="text_area pititlebox" type="text" name="study_alias" id="study_alias" size="60" maxlength="250" value ="<?php echo $this->row->alias;?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_ADMIN_DESCRIPTION' ); ?>
					</label>
				</td>
				<td>
					<textarea class="text_area" cols="10" rows="4" name="study_description" id="study_description" style="width: 100%;"><?php echo $this->row->description;?></textarea>
				</td>
			</tr>
            <tr>
                <td class="key">
                    <label for="alias">
                        <?php echo JText::_( 'COM_PREACHIT_ADMIN_TAGS' ); ?>
                    </label>
                </td>
                <td>
                    <input class="text_area" type="text" name="tags" id="tags" size="60" maxlength="250" value ="<?php echo $this->row->tags;?>" />
                </td>
            </tr>
			<tr>
				<td width="100" class="key">
					<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_DURATION');?></label>
				</td>
				<td>
				<span class="inline-desc-lt"><?php echo JText::_('COM_PREACHIT_ADMIN_HRS');?></span><span class="comp"><input class="text_area" type="text" name="dur_hrs" id="dur_hrs" size="5" maxlength="2" value ="<?php echo $this->row->hrs;?>" /></span>
				<span class="inline-desc"><?php echo JText::_('COM_PREACHIT_ADMIN_MINS');?></span><span class="comp"><input class="text_area" type="text" name="dur_mins" id="dur_mins" size="4" maxlength="2" value ="<?php echo $this->row->mins;?>" /></span>
				<span class="inline-desc"><?php echo JText::_('COM_PREACHIT_ADMIN_SECS');?></span><span class="comp"><input class="text_area" type="text" name="dur_secs" id="dur_secs" size="4" maxlength="2" value ="<?php echo $this->row->secs;?>" /></span>
				</td>
			</tr>
			<tr> 
				<td width="100" class="key">
				<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_VIDEOFILE');?></label>
				</td>
				<td>
				<input class="text_area" type="text" name="video_link" id="video_link" size="60" maxlength="250" value ="<?php echo $this->row->link;?>" />
				</td>
			</tr>
			<tr>
				<td width="100" class="key">
					<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_IMAGE_LARGE');?></label>
				</td>
				<td>
					<input class="text_area" type="text" name="imagelrg" id="imagelrg" size="60" maxlength="250" value ="<?php echo $this->row->imagelrg; ?>" />
				</td>
			</tr>
		</table>
		<input type="hidden" id="image_folder" value ="" />
		<input type="hidden" id="image_foldermed" value ="" />
		<input type="hidden" id="image_folderlrg" value ="" />
		<input type="hidden" id="video_type" value ="<?php echo $this->row->type; ?>" />
		</form>
		<button style="margin: 10px 0 0 150px;" onclick="insert3rdpartycode();"><?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_INSERT_INFO' ); ?></button>
<?php }

else {?>
	<div style="padding: 5px;">
		<p><?php echo JText::_('COM_PREACHIT_ERROR_NOT_POSSIBLE_GET_INFO');?></p>
		<p><?php echo JText::_('COM_PREACHIT_ERROR_NOT_POSSIBLE_GET_INFO_DERVICE');?></p>
	</div>
<?php } ?>

