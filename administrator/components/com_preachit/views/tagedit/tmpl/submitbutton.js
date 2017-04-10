Joomla.submitbutton = function(task)
{
        if (task == '')
        {
                return false;
        }
        else if (task == 'cancel')
        {
            Joomla.submitform(task);
            return true;
        }
        else
        {
                var isValid=true;
                var action = task.split('.');
                if (task != 'cancel')
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
                        if (document.getElementById('tag').value != document.getElementById('original').value)
                        {
                            Joomla.submitform(task);
                            return true;
                        }
                        else
                        {
                        alert(Joomla.JText._('COM_PREACHIT_TAG_NO_CAHNGE_WARNING','You haven\'t made any changes'));
                        return false;
                        }
                        
                }
                else
                {
                        alert(Joomla.JText._('COM_PREACHIT_FIELDS_INVALID','Some required fields are missing'));
                        return false;
                }
        }
}

