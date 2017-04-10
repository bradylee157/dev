<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );
JText::script('COM_PREACHIT_FIELDS_INVALID');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/studyedit/tmpl/submitbutton.js');
$user	= JFactory::getUser();
$option = JRequest::getCmd('option');
?>
<script language="javascript" type="text/javascript">

function showupload() {
    var id = 'SWFUpload_0';
    if (document.getElementById(id)) {
	if (document.adminForm.upload_folder.value != '' && document.adminForm.mediaselector.value != '')
		{document.getElementById(id).style.display = 'inline';}
		else {document.getElementById(id).style.display = 'none';}
    }
    }

function launchthirdparty() {
	var videourl = document.adminForm.video_third.value;
	SqueezeBox.setContent( 'iframe', 'index.php?option=com_preachit&view=videothird&tmpl=component&url='+videourl );
}

function addrecord(record) {
	SqueezeBox.setContent( 'iframe', 'index.php?option=com_preachit&view=addrecord&tmpl=component&record='+record );
}

if (window.addEventListener){
 window.addEventListener('load', showupload, false);
} else if (window.attachEvent){
 window.attachEvent('load', showupload);
}

document.addEvent('domready', function() {
 
    // Test source, list of tags from http://del.icio.us/tag/
    var tokens = [<?php echo $this->taglist;?>];
 
    // Our instance for the element with id "demo-local"
    if (Autocompleter.Local && document.getElementById('jform_tags'))
    {new Autocompleter.Local('jform_tags', tokens, {
        'minLength': 1, // We need at least 1 character
        'selectMode': 'type-ahead', // Instant completion
        'multiple': true // Tag support, by default comma separated
    });
    }
});

</script>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_MESSAGES_LEGEND' ), 'MAIN' );
?>
<div class="width-100">
<fieldset class="panelform ">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("maininfo") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                elseif (!$user->authorise('core.edit.state', 'com_preachit') && $field->name == 'jform[published]'):
                            continue;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php if ($field->name != 'jform[dur_hrs]') {echo $field->input;} ?>
                    <?php if ($field->name == 'jform[study_book]')
                    {?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_BEG');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_ch_beg'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_BEG');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_vs_beg'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_END');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_ch_end'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_END');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_vs_end'); ?> <?php } ?>
                    <?php if ($field->name == 'jform[study_book2]')
                    {?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_BEG');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_ch_beg2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_BEG');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_vs_beg2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_END');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_ch_end2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_END');?>" style="border: 0pt none; font-size: 10px;"><?php echo $this->form->getInput('ref_vs_end2'); ?> <?php } ?>
                    <?php if ($field->name == 'jform[dur_hrs]')
                    {?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_HRS');?>" style="border: 0pt none; font-size: 10px;">
                    <?php echo $this->form->getInput('dur_hrs'); ?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_MINS');?>" style="border: 0pt none; font-size: 10px;">
                    <?php echo $this->form->getInput('dur_mins'); ?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_SECS');?>" style="border: 0pt none; font-size: 10px;">
                    <?php echo $this->form->getInput('dur_secs'); ?><?php } ?>
                    <?php if ($field->name == 'jform[teacher][]')
                    {?><button type="button" style="margin-top: 0; margin-left: 10px;" onclick="addrecord('teacher')">
                     <?php echo JText::_('COM_PREACHIT_ADD_NEW_RECORD');?> </button><?php } ?>
                     <?php if ($field->name == 'jform[series]')
                    {?><button type="button" style="margin-top: 0; margin-left: 10px;" onclick="addrecord('series')">
                     <?php echo JText::_('COM_PREACHIT_ADD_NEW_RECORD');?> </button><?php } ?>
                     <?php if ($field->name == 'jform[ministry][]')
                    {?><button type="button" style="margin-top: 0; margin-left: 10px;" onclick="addrecord('ministry')">
                     <?php echo JText::_('COM_PREACHIT_ADD_NEW_RECORD');?> </button><?php } ?>
                </li>
                <?php if ($field->name == 'jform[tags]')
                    {?><li><label></label>
                    <input type="text" size="100%" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_TAG_HELP');?>" 
                        style="border: 0pt none; font-size: 10px; font-style: italic;">
                        </li><?php } ?>
                <?php if ($field->name == 'jform[hits]')
                    {?><button type="button" style="margin-top: 0;" onclick="submitbutton('reset')">
                        <?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_RESET');?> </button><?php } ?>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_LINKHEAD' ), 'LINKS' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php
if ($user->authorise('core.edit.state', 'com_preachit')) { ?>
<h2><?php echo JText::_('COM_PREACHIT_SUB_PUBLISH_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("puboptions") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
<?php } ?>
<div class="clr"></div>
<h2><?php echo JText::_('COM_PREACHIT_SUB_PODPUBLISH_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("podoptions") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
<div class="clr"></div>
<h2><?php echo JText::_('COM_PREACHIT_SUB_DISPLAY_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("displayoptions") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
<div class="clr"></div>
<h2><?php echo JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("metaoptions") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_AUDIOHEAD' ), 'AUDIO' );
?>
<div class="width-100">
<fieldset class="panelform">
<table class="adminformlist">
<tbody>
<tr><td class="pitablesubhead" colspan="2"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_FILE');?></td></tr>
<?php
foreach ($this->form->getFieldset("audtab") as $field):
        ?>
            <tr>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <td>
                    <?php echo $field->label; ?>  
                </td>  
                <td>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[audio_link]')
                    {echo PIHelpertooltips::putext();}?>
                    <?php if ($field->name == 'jform[audiofs]')
                    {echo PIHelpertooltips::filesize();}?>
                </td>
                <?php
                endif;
           
            ?>
            </tr>
        <?php
        endforeach;?>
        
<tr><td class="pitablesubhead" colspan="2"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_PUR');?></td></tr>
<?php
foreach ($this->form->getFieldset("audpurtab") as $field):
        ?>
            <tr>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <td>
                    <?php echo $field->label; ?>  
                </td>  
                <td>  
                    <?php echo $field->input; ?>
                </td>
                <?php
                endif;
           
            ?>
            </tr>
        <?php
        endforeach;?>
</tbody>
</table>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_VIDEOHEAD' ), 'VIDEO' );
?>
<div class="width-100">
<fieldset class="panelform">
<table class="adminformlist">
<tbody>
<tr><td class="pitablesubhead" colspan="2"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_FILE');?></td></tr>
<?php
foreach ($this->form->getFieldset("vidtab") as $field):
        ?>
            <tr>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <td>
                    <?php echo $field->label; ?>  
                </td>  
                <td>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[video_folder]')
                    {echo PIHelpertooltips::vidfolder();}?>
                    <?php if ($field->name == 'jform[video_link]')
                    {echo PIHelpertooltips::vidtype();}?>
                    <?php if ($field->name == 'jform[videofs]')
                    {echo PIHelpertooltips::filesize();}?>
                </td>
                <?php
                endif;
           
            ?>
            </tr>
        <?php
        endforeach;?>
<tr><td class="pitablesubhead" colspan="2"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_VIDEO_ADDFILE');?></td></tr>
<?php
foreach ($this->form->getFieldset("addvidtab") as $field):
        ?>
            <tr>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <td>
                    <?php echo $field->label; ?>  
                </td>  
                <td>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[advideofs]')
                    {echo PIHelpertooltips::filesize();}?>
                </td>
                <?php
                endif;
           
            ?>
            </tr>
        <?php
        endforeach;?>
<tr><td class="pitablesubhead" colspan="2"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_PUR');?></td></tr>
<?php
foreach ($this->form->getFieldset("vidpurtab") as $field):
        ?>
            <tr>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <td>
                    <?php echo $field->label; ?>  
                </td>  
                <td>  
                    <?php echo $field->input; ?>
                </td>
                <?php
                endif;
           
            ?>
            </tr>
        <?php
        endforeach;?>
</tbody>
</table>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_TEXTHEAD' ), 'STUDYTEXT' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="admintable">
<li>	<?php echo $this->form->getInput('study_text'); ?></li>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_NOTESHEAD' ), 'MESSAGENOTES' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php
foreach ($this->form->getFieldset("notestab") as $field):
        ?>
            <ul class="adminformlist">
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[notesfs]')
                    {echo PIHelpertooltips::filesize();}?>
                </li>
                <?php
                endif;
           
            ?>
            </ul>
        <?php
        endforeach;?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_SLIDESHEAD' ), 'MESSAGESLIDES' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php
foreach ($this->form->getFieldset("slidestab") as $field):
        ?>
            <ul class="adminformlist">
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[slidesfs]')
                    {echo PIHelpertooltips::filesize();}?>
                </li>
                <?php
                endif;
           
            ?>
            </ul>
        <?php
        endforeach;?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_IMAGEHEAD' ), 'MESIMAGES' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php
foreach ($this->form->getFieldset("imagetab") as $field):
        ?>
            <ul class="adminformlist">
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[imagelrg]')
                    {echo PIHelpertooltips::putextimg();}?>
                </li>
                <?php if ($field->name == 'jform[imagelrg]')
                    {?>
                    <li>
                        <label>
                            <?php echo JText::_('COM_PREACHIT_ADMIN_LRGIMAGE_PREVIEW');?>
                        </label>
                            <?php echo $this->image; ?>
                    </li> <?php } ?>
                <?php
                endif;
           
            ?>
            </ul>
        <?php
        endforeach;?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_THIRDPARTY_HEAD' ), 'THIRDPARTY' );
?>
<div class="width-100">
<fieldset class="panelform">
<div class="desc-title">
<?php echo JText::_('COM_PREACHIT_ADMIN_THIRDPARTY_TITLE');?>
</div>
<div class="desc">
<?php echo JText::_('COM_PREACHIT_ADMIN_THIRDPARTY_HELP');?>
</div>
<table class="adminformlist">
<tr> 
<td>
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_3RD_PARTY_VIDEO');?></label>
</td>
<td>
    <input class="text_area" type="text" name="video_third" id="video_third" size="105" maxlength="150" value ="" />
    <button type="button" onclick="launchthirdparty()">
 <?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_THIRD_PARTY');?> </button>
</td>
</tr>
</table>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<div class="width-100" style="margin-top: 30px;">
<fieldset class="panelform">
<legend><?php echo JText::_( 'COM_PREACHIT_ADMIN_UPLOADHEAD' );?></legend>
<table class="adminformlist">
<tr>
<td width="200">
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_UPLOAD_FOLDER');?></label>
</td>
<td>
<?php echo $this->upload_folder; ?>
</td>
</tr>
<tr>
<td>
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_UPLOAD_SELECTOR');?></label>
</td>
<td>
<?php echo $this->mediaselector;?>
</td>
</tr>
<tr>
<td>
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_FILE_UPLOAD');?></label>
</td>
<td>
<?php if ($this->admin->uploadtype == 1)
{ ?>
<div class="desc">
<?php echo JText::_('COM_PREACHIT_ADMIN_UPLOAD_HELP');?>
</div>
<div id="swfuploader">
<div class="fieldset flash" id="fsUploadProgress">
                        </div> 	
                        <div>
                         <span id="spanButtonPlaceHolder"></span>
                                <input id="btnCancel" type="button" value="<?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_CANCEL_UPLOAD');?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
                        </div>
</div>
<?php }
if ($this->admin->uploadtype == 0)
{ ?>
<input type="file" name ="uploadfile" value="" /><button type="button" onclick="submitbutton('upload')">
 <?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_UPLOAD');?> </button>
 	<?php echo PIHelpertooltips::uploadfolder();?>
 <?php } ?>
</td>
</tr>
<tr>
<td></td>
<td>
<?php echo JText::_('COM_PREACHIT_ADMIN_MAX_UPLOAD').' '.Tewebdetails::maxupload();?>
</td>
</tr>
</table>
</fieldset>
</div>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="studylist" />
<input type="hidden" name="task" value ="" />
<input type="hidden" name="flupfile" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>