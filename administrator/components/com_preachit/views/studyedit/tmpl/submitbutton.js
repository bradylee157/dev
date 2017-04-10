Joomla.submitbutton = function(task)
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
							alert("<?php echo JText::_('COM_PREACHIT_JAVA_SELECT_MEDIA');?>");
						} 
  					else {
						Joomla.submitform(task);
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
								{Joomla.submitform(task);
       							return true;}
						}
				}
		  else if  (task == 'reset') 
				{
					if(confirm("<?php echo JText::_('COM_PREACHIT_JAVA_SURE_RESET_HITS');?>"))
						{Joomla.submitform(task);
       							return true;}			
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
                        Joomla.submitform(task);
                        return true;
                }
                else
                {
                        alert(Joomla.JText._('COM_PREACHIT_FIELDS_INVALID','Some required fields are missing'));
                        return false;
                }
        }
}

