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
<form action="index.php" method="post" name="adminForm">
<div class="piformdiv">
<fieldset class="adminform">
<legend><?php echo JText::_( 'COM_PREACHIT_ADMIN_CSS_LEGEND' ); ?></legend>
<table class="adminlist">
<tr>
<td width="100" align="right" class="key">
<?php echo JText::_( 'COM_PREACHIT_ADMIN_CSS_FILE' ); ?>:
</td>
<td>
<textarea name="filecontent" id="filecontent" class="inputbox" rows=" 40" cols="90"><?php echo $this->CSSfile->filecontent;?></textarea>
</td>
</tr>
</table>
</fieldset>
</div>
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="cssedit" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="override" value="<?php echo $this->override; ?>" />
<input type="hidden" name="cssfile" value="<?php echo $this->cssfile; ?>" />
<input type="hidden" name="temp" value="<?php echo $this->temp; ?>" />
<input type="hidden" name="mod" value="<?php echo $this->mod; ?>" />
<input type="hidden" name="plug" value="<?php echo $this->plug; ?>" />
</form>