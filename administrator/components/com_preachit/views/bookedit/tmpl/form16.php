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
JHTML::_('behavior.tooltip');
JText::script('COM_PREACHIT_FIELDS_INVALID');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$user	= JFactory::getUser();
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/bookedit/tmpl/submitbutton.js');

?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<div class="width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_ADMIN_BOOKS_LEGEND');?></legend>
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
                    <?php if ($field->name == 'jform[display_name]')
                    {echo PIHelpertooltips::bkdispname();}?>
                    <?php if ($field->name == 'jform[book_name]')
                    {echo PIHelpertooltips::bkname();}?>
                    <?php if ($field->name == 'jform[shortform]')
                    {echo PIHelpertooltips::bkshort();}?>
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
<input type="hidden" name="controller" value="booklist" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>






