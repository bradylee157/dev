<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div class="listblock <?php echo $this->alternate;?>">

	<!-- image -->
	<?php echo $this->image; ?>
	
	<!-- message title -->
	
	<?php if ($this->message->name) {?>
	<div class="study_name"><?php echo $this->message->name;?></div>
	<?php } ?>
			
	<!-- message date -->
		
	<?php if ($this->params->get('date_studylist', '1') == '1')
	{?>
	<?php if ($this->message->date) {?>
	<div class="date"><?php echo $this->message->date;?></div>
	<?php } ?>
	<?php } ?>
	
	<!-- message info -->
	
	<div class="study_info">
		
		<?php if ($this->params->get('teacher_studylist', '1') == '1')
		{  if ($this->message->teachername) {?>
		<div class="teacher"><?php echo JText::_('COM_PREACHIT_by');?> <span><?php echo $this->message->teachername;?></span></div>
		<?php } ?>
		<?php } ?>
		
		<?php if ($this->message->scripture) {?>
		<div class="scripture"><?php echo JText::_('COM_PREACHIT_Passage');?>: <span><?php echo $this->message->scripture;?></span></div>
		<?php } ?>
		
		<?php if ($this->params->get('series_studylist', '1') == '1')
		{?>
		<?php if ($this->message->seriesname) {?>
		<div class="series"><?php echo JText::_('COM_PREACHIT_Series');?>: <span><?php echo $this->message->seriesname;?></span></div>
		<?php } ?>
		<?php } ?>
		
		<?php if ($this->params->get('duration_studylist', '1') == '1')
		{?>
		<?php if ($this->message->duration) {?>
		<div class="duration"><?php echo JText::_('COM_PREACHIT_Duration');?>: <span><?php echo $this->message->duration;?></span></div>
		<?php }?>
		<?php } ?>
		
	</div>
	
	<!-- message description -->
	
	<?php if ($this->params->get('description_studylist', '1') == '1')
	{
	if ($this->message->description) {?>
	<div class="study_description"><?php echo $this->message->description; ?></div>
	<?php } ?>
	<?php }?>	
    
    <!-- message comment count -->
    
    <?php if ($this->params->get('commentcount_studylist', '1') == '1')
    {
    if ($this->message->commentno) {?>
    <?php echo $this->message->commentno; ?>
    <?php } ?>
    <?php }?>    
	
	<!-- links -->
	
	<div class="medialinks">
	
		<!-- share link -->
	
		<?php if ($this->params->get('share', '1') == '1')
		{?>
		<?php if ($this->message->share) {?>
		<div class="share"><?php echo $this->message->share;?></div>
		<?php } ?>
		<?php } ?>	
		
		<!-- media links -->
	
		<?php if ($this->message->linkwatch || $this->message->downloadvid || $this->message->purchasevid)
		{?>
		<span class="videolinks"><?php echo JText::_('COM_PREACHIT_Video').':'; echo $this->message->linkwatch; echo $this->message->downloadvid; echo $this->message->purchasevid;?></span>
		<?php } ?>
		
		<?php if ($this->message->linklisten || $this->message->downloadaud || $this->message->purchaseaud)
		{?>	
		<span class="audiolinks"><?php echo JText::_('COM_PREACHIT_Audio').':'; echo $this->message->linklisten; echo $this->message->downloadaud; echo $this->message->purchaseaud;?></span>
		<?php } ?>	
		
		<?php if ($this->message->linktext || $this->message->linknotes || $this->message->linkslides)
		{?>		
		<span class="textlinks"><?php echo JText::_('COM_PREACHIT_Text').':'; echo $this->message->linktext; echo $this->message->linknotes; echo $this->message->linkslides?></span>
		<?php } ?>	
		
		<?php if ($this->message->amlink && $this->listview != 'media')
		{?>		
		<span class="asmedialinks"><?php echo JText::_('COM_PREACHIT_Other').':'; echo $this->message->amlink;?></span>
		<?php } ?>
			
		<?php if ($this->message->editlink)
		{ ?>
		<span class="editlinks"><?php echo JText::_('COM_PREACHIT_Manage').':'; echo $this->message->editlink;?></span>
		<?php } ?>	
		
	</div>
		
</div>