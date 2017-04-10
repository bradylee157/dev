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
JText::script('COM_PREACHIT_TAG_NO_CAHNGE_WARNING');
$user	= JFactory::getUser();
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/tagedit/tmpl/submitbutton.js');
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<div class="width-100">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_ADMIN_TAG_LEGEND');?></legend>
<ul class="adminformlist">
<li>
<label id="tag-lbl" class="required" for="tag-lbl">
<?php echo JText::_('COM_PREACHIT_ADMIN_TAG_LABEL');?>
<span class="star">&nbsp;*</span>
</label>
<input id="tag" class="inputbox required" type="text" maxlength="40" size="40" value="<?php echo $this->tag;?>" name="tag" aria-required="true" required="required">
</li>
</ul>
</fieldset>
</div>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input id="controller" type="hidden" name="controller" value="taglist" />
<input id="original" type="hidden" name="original" value="<?php echo $this->tag; ?>" />
<input id="option "type="hidden" name="option" value="<?php echo $option;?>" />
<input id="task" type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>






