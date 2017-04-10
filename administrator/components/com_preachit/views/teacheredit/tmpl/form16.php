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
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$option = JRequest::getCmd('option');
JText::script('COM_PREACHIT_FIELDS_INVALID');
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );  
$user	= JFactory::getUser();
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/teacheredit/tmpl/submitbutton.js');
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {

if (pressbutton == 'upload') 
{
		if (document.adminForm.upload_folder.value == '') {
			alert("<?php echo JText::_('COM_PREACHIT_JAVA_SELECT_FOLDER');?>");
		} 
		
		else if (document.adminForm.mediaselector.value == '' ) {
			alert("<?php echo JText::_('COM_PREACHIT_JAVA_SELECT_MEDIA');?>");
		} 
  else {
			submitform(pressbutton);
		}
	 } 

else {
		submitform(pressbutton);
	}
}

function showupload(id) {
    if (document.getElementById(id)) {
    if (document.adminForm.upload_folder.value != '' && document.adminForm.mediaselector.value != '')
        {document.getElementById(id).style.display = 'inline';}
        else {document.getElementById(id).style.display = 'none';}
    }
    }
</script>
<form action="index.php" class ="form-validate" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_TEACHER_LEGEND' ), 'MAIN' );
?>
<div class="width-100">
<fieldset class="panelform">
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
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
<div class="clr"></div>   
<h2><?php echo JText::_('COM_PREACHIT_SUB_META_OPTIONS');?></h2>
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
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_IMAGEHEAD' ), 'MESIMAGES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("images") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>  
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[teacher_image_lrg]')
                    {echo PIHelpertooltips::putextimg();}?>
                </li>
                <?php if ($field->name == 'jform[teacher_image_lrg]')
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
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_DESCHEAD' ), 'DESC' );
?>
<div class="width-100">
<fieldset>
<?php echo $this->form->getLabel('teacher_description'); ?>
<div class="clr"></div>
<?php echo $this->form->getInput('teacher_description'); ?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_UPLOADHEAD' ), 'THIRDPARTY' );
?>
<div class="width-100">
<fieldset class="panelform">
<table class="adminformlist">
<tr>
<td width="130">
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
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="teacherlist" />
<input type="hidden" name="task" value ="" />
<input type="hidden" name="flupfile" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>