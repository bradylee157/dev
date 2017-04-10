<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$user    = JFactory::getUser();
$option = JRequest::getCmd('option');
 jimport('joomla.html.pane');
    $pane =& JPane::getInstance( 'tabs' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$tefolder = $abspath.DIRECTORY_SEPARATOR.'components/com_teadmin';
$te = JFolder::exists($tefolder);
?>
<style>
.current {
    max-width: 900px !important;
}
</style>
<script language="javascript" type="text/javascript">
function submitbutton(task)
{
        if (task == '')
                {
                return false;
                }
           else if (task == 'upload')
                {
                    if (document.adminForm.upload_folder.value == '') 
                        {
                            alert("<?php echo JText::_('COM_PREACHIT_JAVA_SELECT_FOLDER');?>");
                        } 
                    else if (document.adminForm.mediaselector.value == '' ) 
                        {
                            alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_MEDIATYPE');?>");
                        } 
                      else {
                        submitform(task);
                  return true;
                        }
                 }
         else if  (task == 'thirdparty') 
                {
                    if (document.adminForm.video_third.value == '') 
                        {
                            alert("<?php echo JText::_('COM_PREACHIT_JAVA_ADD_THIRD_PARTY_URL');?>");
                        } 
                    else
                        {
                            if(confirm("<?php echo JText::_('COM_PREACHIT_JAVA_SURE_OVERWRITE_DETAILS');?>"))
                                {submitform(task);
                                   return true;}
                        }
                }
       else if (task == 'cancelclose')
                  {
                      var PICCheckin = new Request.HTML({url:'index.php'}).post('option=com_preachit&controller=studyedit&task=checkin&id=<?php echo $this->id; ?>');
                      dummy = $time() + $random(0, 100);
                    PICCheckin.send("t"+dummy);
                    window.parent.location.reload(true);
                    window.parent.SqueezeBox.close();
                }
        else
            {
                var isValid=true;
                if (task != 'cancel' && task != 'close' && task != 'uploadflash')
                {
                        var forms = $$('form.form-validate');
                        for (var i=0;i<forms.length;i++)
                        {
                                if (!document.formvalidator.isValid(forms[i]))
                                {
                                        isValid = false;
                                        break;
                                }
                        }
                }
 
                if (isValid)
                {
                        submitform(task);
                        return true;
                }
                else
                {
                        alert('<?php echo JText::_('COM_PREACHIT_FIELDS_INVALID');?>');
                        return false;
                }
        }
}
</script>

<script language="javascript" type="text/javascript">

function showupload() {
    var id = 'SWFUpload_0';
    if (document.getElementById(id)) {
    if (document.adminForm.upload_folder.value != '' && document.adminForm.mediaselector.value != '')
        {document.getElementById(id).style.display = 'inline';}
        else {document.getElementById(id).style.display = 'none';}
    }
    }
    
function addrecord(record) {
    SqueezeBox.setContent( 'iframe', 'index.php?option=com_preachit&view=addrecord&tmpl=component&record='+record );
}
function launchthirdparty() {
    var videourl = document.adminForm.video_third.value;
    SqueezeBox.setContent( 'iframe', 'index.php?option=com_preachit&view=videothird&tmpl=component&url='+videourl );
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

<?php if ($this->layout == 'modal')
{?>
<script type="text/javascript">

    window.addEvent('domready', function(){

        parent.$('sbox-overlay').removeEvents('click');

        parent.$('sbox-btn-close').removeEvents('click');
        
        parent.$('sbox-btn-close').addEvent('click', function(){
        submitbutton('cancelclose');
        });

    });

</script>
<?php } ?>
<style>
#sbox-btn-close {
    background: none !important;
    display: none;
}</style>
<div class="backgrd piformdiv j16">
<div class="pifrontedit">
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div id="extrainputs" style="display: none;"></div>
<fieldset>
    <div id="toolbar" class="toolbar-list">
        <ul>
                <?php if ($this->layout == 'modal' || $te)
                {?>
                    <li id="toolbar-save" class="button">
                        <a title="<?php echo JText::_('TE_TOOLBAR_SAVE'); ?>" class="toolbar" onclick="javascript: submitbutton('applymodal'); return false;" href="#">
                        <span class="icon-32-save"></span>
                            <?php echo JText::_('TE_TOOLBAR_SAVE'); ?>
                        </a>
                    </li>
                    <li id="toolbar-cancel" class="button">
                        <a title="<?php echo JText::_('TE_TOOLBAR_CLOSE'); ?>" class="toolbar" onclick="javascript: submitbutton('cancelclose'); return false;" href="#">
                        <span class="icon-32-cancel"></span>
                            <?php echo JText::_('TE_TOOLBAR_CLOSE'); ?>
                        </a>
                    </li>

                <?php } ?>
                <?php if ($this->layout == 'form' && !$te)
                {?>
                    <li id="toolbar-save" class="button">
                        <a title="<?php echo JText::_('TE_TOOLBAR_SAVE'); ?>" class="toolbar" onclick="javascript: submitbutton('save'); return false;" href="#">
                        <span class="icon-32-save"></span>
                            <?php echo JText::_('TE_TOOLBAR_SAVE'); ?>
                        </a>
                    </li>
                    <li id="toolbar-save" class="button">
                        <a title="<?php echo JText::_('TE_TOOLBAR_APPLY'); ?>" class="toolbar" onclick="javascript: submitbutton('apply'); return false;" href="#">
                        <span class="icon-32-apply"></span>
                            <?php echo JText::_('TE_TOOLBAR_APPLY'); ?>
                        </a>
                    </li>
                <?php } ?>

</ul>
<div class="clr"></div>
</div>
<div class="pagetitle icon-48-message">
<h2>
<?php if ($this->id)
{echo JText::_('COM_PREACHIT_ADMIN_MESSAGES_EDIT');}
else { echo JText::_('COM_PREACHIT_ADMIN_MESSAGES_DETAILS');}?>
</h2>
</div>
</fieldset>
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_MESSAGES_LEGEND' ), 'MAIN' );
?>
<div class="width-100">
<fieldset class="panelform ">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("maininfo") as $field) { 
if (!$user->authorise('core.edit.state', 'com_preachit') && $field->name == 'jform[published]')
{continue;}
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{ 
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php if ($field->name != 'jform[dur_hrs]') {echo $field->input;} ?>
                    <?php if ($field->name == 'jform[study_book]')
                    {?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_BEG');?>" style="border: 0pt none;                    font-size: 10px;"><?php echo $this->form->getInput('ref_ch_beg'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_BEG');?>" style="border: 0pt none;                    font-size: 10px;"><?php echo $this->form->getInput('ref_vs_beg'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_END');?>" style="border: 0pt none;                        font-size: 10px;"><?php echo $this->form->getInput('ref_ch_end'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_END');?>" style="border: 0pt none;                        font-size: 10px;"><?php echo $this->form->getInput('ref_vs_end'); ?> <?php } ?>
                    <?php if ($field->name == 'jform[study_book2]')
                    {?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_BEG');?>" style="border: 0pt none;                    font-size: 10px;"><?php echo $this->form->getInput('ref_ch_beg2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_BEG');?>" style="border: 0pt none;                    font-size: 10px;"><?php echo $this->form->getInput('ref_vs_beg2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_CH_END');?>" style="border: 0pt none;                        font-size: 10px;"><?php echo $this->form->getInput('ref_ch_end2'); ?>
                    <input type="text" size="7" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_VS_END');?>" style="border: 0pt none;                        font-size: 10px;"><?php echo $this->form->getInput('ref_vs_end2'); ?> <?php } ?>
                    <?php if ($field->name == 'jform[dur_hrs]')
                    {?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_HRS');?>" style="border: 0pt none;                           font-size: 10px;">
                    <?php echo $this->form->getInput('dur_hrs'); ?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_MINS');?>" style="border: 0pt none;                      font-size: 10px;">
                    <?php echo $this->form->getInput('dur_mins'); ?>
                    <input type="text" size="3" readonly="readonly" value="<?php echo JText::_('COM_PREACHIT_ADMIN_SECS');?>" style="border: 0pt none;                      font-size: 10px;">
                    <?php echo $this->form->getInput('dur_secs'); ?><?php } ?>
                    <?php if ($field->name == 'jform[teacher][]' && !in_array('newteacherbutton', $this->hide))
                    {?><button type="button" style="margin-top: 0; margin-left: 10px;" onclick="addrecord('teacher')">
                     <?php echo JText::_('COM_PREACHIT_ADD_NEW_RECORD');?> </button><?php } ?>
                     <?php if ($field->name == 'jform[series]' && !in_array('newseriesbutton', $this->hide))
                    {?><button type="button" style="margin-top: 0; margin-left: 10px;" onclick="addrecord('series')">
                     <?php echo JText::_('COM_PREACHIT_ADD_NEW_RECORD');?> </button><?php } ?>
                     <?php if ($field->name == 'jform[ministry][]' && !in_array('newministrybutton', $this->hide))
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
        <?php }
}?>
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
if ($user->authorise('core.edit.state', 'com_preachit') && Tewebcheck::showtab($this->form, 'puboptions', $this->hide)) { ?>
<h2><?php echo JText::_('COM_PREACHIT_SUB_PUBLISH_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("puboptions") as $field):
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
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
        <?php   }
        endforeach;?>
</ul>
<?php } ?>
<?php if (Tewebcheck::showtab($this->form, 'displayoptions', $this->hide))
{ ?>
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
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
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
        <?php   }
        endforeach;?>
</ul>
<?php } ?>
<?php if (Tewebcheck::showtab($this->form, 'metaoptions', $this->hide))
{ ?>
<div class="clr"></div>
<h2><?php echo JText::_('COM_PREACHIT_SUB_META_OPTIONS');?></h2>
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("metaoptions") as $field):
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
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
        <?php    }
        endforeach;?>
</ul>
<?php } ?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_AUDIOHEAD' ), 'AUDIO' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php if (Tewebcheck::showtab($this->form, 'audtab', $this->hide))
{ ?>
<li id="pimform_afile_head"><label class="pitablesubhead"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_FILE');?></label></li>
<?php
foreach ($this->form->getFieldset("audtab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[audio_link]')
                    {echo PIHelpertooltips::putext(0);}?>
                    <?php if ($field->name == 'jform[audiofs]')
                    {echo PIHelpertooltips::filesize(0);}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
}
}
}?>
<?php if (Tewebcheck::showtab($this->form, 'audpurtab', $this->hide))
{?>
<li id="pimform_apur_head"><label class="pitablesubhead"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_PUR');?></label</li>
<?php
foreach ($this->form->getFieldset("audpurtab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
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
}
}
}?>
</ul>
</fieldset></div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_VIDEOHEAD' ), 'VIDEO' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php if (Tewebcheck::showtab($this->form, 'vidtab', $this->hide))
{?>
<li id="pimform_vfile_head"><label class="pitablesubhead"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_FILE');?></label></li>
<?php
foreach ($this->form->getFieldset("vidtab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>   
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[video_folder]')
                    {echo PIHelpertooltips::vidfolder(0);}?>
                    <?php if ($field->name == 'jform[video_link]')
                    {echo PIHelpertooltips::vidtype(0);}?>
                    <?php if ($field->name == 'jform[videofs]')
                    {echo PIHelpertooltips::filesize(0);}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
}
}
}?>
<?php if (Tewebcheck::showtab($this->form, 'addvidtab', $this->hide))
{?>
<li id="pimform_dvidfile_head"><label class="pitablesubhead"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_VIDEO_ADDFILE');?></label></li>
<?php
foreach ($this->form->getFieldset("addvidtab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>   
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[advideofs]')
                    {echo PIHelpertooltips::filesize(0);}?>
                </li>
                <?php
                endif;       
            ?>
        <?php
}
}
}?>
<?php if (Tewebcheck::showtab($this->form, 'vidpurtab', $this->hide))
{?>
<li id="pimform_vpur_head"><label class="pitablesubhead"><?php echo JText::_('COM_PREACHIT_ADMIN_SUB_PUR');?></label></li>
<?php
foreach ($this->form->getFieldset("vidpurtab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
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
}
}
}?>
</ul>
</fieldset></div>
<?php
echo $pane->endPanel();
if (!in_array('study_text', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_TEXTHEAD' ), 'STUDYTEXT' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php echo $this->form->getInput('study_text'); ?>
</fieldset></div>
<?php
echo $pane->endPanel();
}
if (Tewebcheck::showtab($this->form, 'notestab', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_NOTESHEAD' ), 'MESSAGENOTES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("notestab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?> 
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[notesfs]')
                    {echo PIHelpertooltips::filesize(0);}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
}
}?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
}
if (Tewebcheck::showtab($this->form, 'slidestab', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_SLIDESHEAD' ), 'MESSAGENOTES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("slidestab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?> 
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[slidesfs]')
                    {echo PIHelpertooltips::filesize(0);}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
}
}?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
}
if (Tewebcheck::showtab($this->form, 'imagetab', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_IMAGEHEAD' ), 'MESIMAGES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("imagetab") as $field) {
if (!in_array(Tewebcheck::gettvalue($field->name), $this->hide))
{
        ?> 
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                <?php if ($field->name == 'jform[imagelrg]')
                    {echo PIHelpertooltips::putextimg(0);}?>
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
        <?php
}
}?>
</ul>
</fieldset></div>
<?php
echo $pane->endPanel();
}
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_THIRDPARTY_HEAD' ), 'THIRDPARTY' );
?>
<div class="desc-title">
<?php echo JText::_('COM_PREACHIT_ADMIN_THIRDPARTY_TITLE');?>
</div>
<div class="desc">
<?php echo JText::_('COM_PREACHIT_ADMIN_THIRDPARTY_HELP');?>
</div>
<div class="width-100">
<fieldset class="panelform">
<table class="admintable piadmintable">
<tr> 
<td width="100" align="right" class="key">
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_3RD_PARTY_VIDEO');?></label>
</td>
<td>
    <input class="text_area" type="text" name="video_third" id="video_third" size="60" maxlength="150" value ="" />
    <button type="button" onclick="launchthirdparty()">
 <?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_THIRD_PARTY');?> </button>
</td>
</tr>
</table>
</fieldset></div>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<div class="width-100" style="margin-top: 30px;">
<fieldset class="panelform uploadform">
<legend><?php echo JText::_( 'COM_PREACHIT_ADMIN_UPLOADHEAD' );?></legend>
<table class="admintable piadmintable">
<tr>
<td width="100" align="right" class="key">
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_UPLOAD_FOLDER');?></label>
</td>
<td>
<?php echo $this->upload_folder; ?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
<label class="label"><?php echo JText::_('COM_PREACHIT_ADMIN_UPLOAD_SELECTOR');?></label>
</td>
<td>
<?php echo $this->mediaselector;?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
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
     <?php echo PIHelpertooltips::uploadfolder(0);?>
 <?php } ?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key"></td>
<td>
<?php echo JText::_('COM_PREACHIT_ADMIN_MAX_UPLOAD').' '.Tewebdetails::maxupload();?>
</td>
</tr>
</table>
</fieldset></div>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer(0);?></div>
<!-- /Footer -->
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="layout" value="<?php echo $this->layout; ?>" />
<input type="hidden" name="controller" value="studyedit" />
<input type="hidden" name="task" value ="" />
<input type="hidden" name="flupfile" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>