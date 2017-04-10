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
?>
<script language="javascript" type="text/javascript">

Joomla.submitbutton = function(task)
{
        if (task == '')
                {
                return false;
                }
           else if (task == 'extracttemplate')
                {
                    
                    var type = getCheckedValue(document.getElementsByName('installtype'));
                    if (type == 1)
                    {if (confirm('<?php echo JText::_('COM_PREACHIT_TEMP_COMP_INSTALL_CONFIRM');?>'))
                        Joomla.submitform(task);}
                    else if (type == 0)
                    {if (confirm('<?php echo JText::_('COM_PREACHIT_TEMP_UPDATE_INSTALL_CONFIRM');?>'))
                        Joomla.submitform(task);}
                    else {return false;}
                }
           else  {Joomla.submitform(task);}}
}

function getCheckedValue(radioObj) {
    if(!radioObj)
        return "";
    var radioLength = radioObj.length;
    if(radioLength == undefined)
        if(radioObj.checked)
            return radioObj.value;
        else
            return "";
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            return radioObj[i].value;
        }
    }
    return "";
}

</script>



<div class="piadmin-functitle template-manager"><?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_INSTALL_TITLE');?></div><br>
		
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="piformdiv width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_UPLOAD_TITLE');?></legend>
<table class="admintable">
                <tr>
                    <td width="120">
                        <label for="install_package"><?php echo JText::_('COM_PREACHIT_ADMIN_TYPE');?></label>
                    </td>
                    <td>
                        <fieldset class="radio inputbox" id="installtype">
                        <input type="radio" value="0" name="installtype" id="installtype0"><label for="installtype0"><?php echo JText::_('COM_PREACHIT_ADMIN_TEMP_UPDATE_INSTALL');?></label>
                        <input type="radio" checked="checked" value="1" name="installtype" id="installtype1"><label for="jinstalltype1"><?php echo JText::_('COM_PREACHIT_ADMIN_TEMP_COMP_INSTALL');?></label></fieldset>
                    </td>
                </tr>
				<tr>
					<td width="120">
						<label for="install_package"><?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_PACKAGEFILE');?></label>
					</td>
					<td>
						<input type="file" size="57" name="install_package" class="input_box">
						<button type="button" onclick="javascript:Joomla.submitbutton('extracttemplate')">
						<?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_SUBMIT_BUTTON_TITLE');?> </button>
					</td>
				</tr>
				<tfoot style="height: 20px;"><tr>
	      <td></td></tr></tfoot>
			</table>
</fieldset>
</div>
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="controller" value="templates" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>








