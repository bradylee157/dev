<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$params =& $app->getParams();

?>

<div id="textview" class="print">

<div class="topbar">
<div class="date"><?php echo $this->message->date;?></div>
<div class="study_name"><?php echo $this->message->name;?></div>
</div>
<div class="subtitle"><?php echo $this->message->scripture; ?>
<?php if ($this->message->teachername)
{
echo ' '.JText::_('COM_PREACHIT_BY').' '.$this->message->teachername;}?>
</div>
<SCRIPT LANGUAGE="JavaScript"> 
if (window.print) {
document.write('<div class="noprint" style="padding-right: 10px; float: right;"><A HREF="javascript:window.print()"><?php echo JText::_('COM_PREACHIT_PRINT_THIS_PAGE');?></A></div>');
}
</script>
<div class="study_description"><?php echo $this->message->description;?></div>
<?php if ($this->message->teachername)
{?>
<div class="series"><?php echo JText::_('COM_PREACHIT_SERIES').': ' . $this->message->seriesname;?></div>
<?php } ?>
<div class="study_text"><?php echo $this->message->text;?></div>
<SCRIPT LANGUAGE="JavaScript"> 
if (window.print) {
document.write('<div class="noprint" style="padding-right: 10px; float: right;"><A HREF="javascript:window.print()"><?php echo JText::_('COM_PREACHIT_PRINT_THIS_PAGE');?></A></div>');
}
</script>
</div>
