<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$option = JRequest::getCmd('option');
$user	= JFactory::getUser();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$tefolder = $abspath.DIRECTORY_SEPARATOR.'components/com_teadmin';
$te = JFolder::exists($tefolder);
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.tooltip');
?>
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
function showupload(id) {
    if (document.getElementById(id)) {
    if (document.adminForm.upload_folder.value != '' && document.adminForm.mediaselector.value != '')
        {document.getElementById(id).style.display = 'inline';}
        else {document.getElementById(id).style.display = 'none';}
    }
    }
function shownew(string) {
	if ( document.getElementById('jform_'+string).options[1].selected == true)
		{document.getElementById('jform_new'+string).style.display = 'inline';}
		else {document.getElementById('jform_new'+string).style.display = 'none';}	
		if (!document.getElementById('jform_new'+string).value)
		{document.getElementById('jform_new'+string).value = '<?php echo JText::_('COM_PREACHIT_NEW_ENTRY');?>';}
	}
</script>

<script type="text/javascript">

	window.addEvent('domready', function(){

		parent.$('sbox-overlay').removeEvents('click');

		parent.$('sbox-btn-close').removeEvents('click');
		
		parent.$('sbox-btn-close').addEvent('click', function(){
        submitbutton('cancelclose');
		});

	});

</script>
<style>
#sbox-btn-close {
	background: none !important;
	display: none;
}</style>
<div class="backgrd piformdiv j16">
<div class="pifrontedit">
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<fieldset>
    <div id="toolbar" class="toolbar-list">
        <ul>
                    <li id="toolbar-save" class="button">
                        <a title="<?php echo JText::_('TE_TOOLBAR_SAVE'); ?>" class="toolbar" onclick="javascript: submitbutton('applymodal'); return false;" href="#">
                        <span class="icon-32-save"></span>
                            <?php echo JText::_('TE_TOOLBAR_SAVE'); ?>
                        </a>
                    </li>

                        <li id="toolbar-save" class="button">
                            <a title="<?php echo JText::_('TE_TOOLBAR_CLOSE'); ?>" class="toolbar" onclick="javascript: submitbutton('cancelclose'); return false;" href="#">
                            <span class="icon-32-cancel"></span>
                                <?php echo JText::_('TE_TOOLBAR_CLOSE'); ?>
                                </a>
                        </li>


</ul>
<div class="clr"></div>
</div>
<div class="pagetitle icon-48-message">
<h2>
<?php if ($this->id)
{echo JText::_('COM_PREACHIT_ADMIN_SERIES_EDIT');}
else { echo JText::_('COM_PREACHIT_ADMIN_SERIES_DETAILS');}?>
</h2>
</div>
</fieldset>
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_SERIES_LEGEND' ), 'MAIN' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("maininfo") as $field):
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
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php }
        endforeach;?>
</ul>
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
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_IMAGEHEAD' ), 'TIMAGES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("images") as $field):
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
                    <?php if ($field->name == 'jform[series_image_lrg]')
                    {echo PIHelpertooltips::putextimg(0);}?>
                </li>
                <?php if ($field->name == 'jform[series_image_lrg]')
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
endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
if (Tewebcheck::showtab($this->form, 'videotab', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_VIDEOHEAD' ), 'VIDEO' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("videotab") as $field):
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
                    <?php if ($field->name == 'jform[videolink]')
                    {echo PIHelpertooltips::vidtype(0);}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
}
endforeach;?>
        </ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
}
if (!in_array('series_description', $this->hide))
{
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_DESCHEAD' ), 'DESC' );
?>
<div class="width-100">
<fieldset class="panelform">
<?php echo $this->form->getInput('series_description'); ?>
</fieldset>
</div>
<?php
echo $pane->endPanel();
}
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_UPLOADHEAD' ), 'UPLOAD' );
?>
<div class="width-100">
<fieldset class="panelform">
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
<?php echo PIfooter::footer(0);?></div>
<!-- /Footer -->
<input type="hidden" name="controller" value="seriesedit" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<input type="hidden" name="flupfile" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>