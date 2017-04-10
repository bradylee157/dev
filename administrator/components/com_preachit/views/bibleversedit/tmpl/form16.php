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
JText::script('COM_PREACHIT_FIELDS_INVALID');
$user	= JFactory::getUser();
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/bibleversedit/tmpl/submitbutton.js');
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<div class="width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_ADMIN_BIBLEVERS_LEGEND');?></legend>
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
</fieldset>
</div>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="controller" value="biblevers" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>






