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
JText::script('COM_PREACHIT_FIELDS_INVALID');
$user    = JFactory::getUser();
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/commentedit/tmpl/submitbutton.js');
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<div class="width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_ADMIN_COMMENTS_LEGEND');?></legend>
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('id'); ?>
        <?php echo $this->form->getInput('id'); ?></li> 
<?php
if ($user->authorise('core.edit.state', 'com_preachit')) 
{?>
<li><?php echo $this->form->getLabel('published'); ?>
        <?php echo $this->form->getInput('published'); ?></li> 
<?php  }?>
<li><?php echo $this->form->getLabel('full_name'); ?>
				<?php echo $this->form->getInput('full_name'); ?></li> 
<li><?php echo $this->form->getLabel('comment_date'); ?>
				<?php echo $this->form->getInput('comment_date'); ?></li> 
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_ADMIN_STUDY');?>
</label>
<input type="text" size="50" readonly="readonly" class="readonly" value="<?php echo $this->studyname;?>" />
</li>
<li><?php echo $this->form->getLabel('comment_text'); ?>
				<?php echo $this->form->getInput('comment_text'); ?></li>
</ul>
</fieldset>
</div>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="controller" value="comment" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>






