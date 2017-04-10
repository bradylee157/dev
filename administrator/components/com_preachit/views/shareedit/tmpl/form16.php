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
JText::script('COM_PREACHIT_FIELDS_INVALID');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$option = JRequest::getCmd('option');
$user	= JFactory::getUser();
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/shareedit/tmpl/submitbutton.js');
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<div class="width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_ADMIN_SHARE_LEGEND');?></legend>
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
                    <?php if ($field->name == 'jform[code]')
                    {echo PIHelpertooltips::sharedef();}?>
                    <?php if ($field->name == 'jform[script]')
                    {echo PIHelpertooltips::sharescript();}?>
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
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="controller" value="sharelist" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>




