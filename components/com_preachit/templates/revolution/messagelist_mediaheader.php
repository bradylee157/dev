<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$header = $this->params->get('headermediasermons', '1');
$headertext = JText::_($this->params->get('headermediatext', 'COM_PREACHIT_HEADER_MEDIA'));
?>
<input id="layout" value="<?php echo $this->listview;?>" type="hidden"/>
<input id="asmedia" value="<?php echo $this->filter_media;?>" type="hidden"/>
<!-- head -->

<div class="head">

	<!-- title & date -->

	<div class="topbar">
		<div class="date"><?php echo $this->messagemain->date;?></div>
		<h1 class="study_name"><?php echo $this->messagemain->name;?></h1>
	</div>

	<!-- scripture & teacher name -->

	<div class="subtitle">
		<?php echo $this->messagemain->scripture; ?>
		<?php if ($this->messagemain->teachername)
		{
		echo ' '.JText::_('COM_PREACHIT_by').' '.$this->messagemain->teachername;}?>
	</div>

	<!-- message description -->

	<?php if ($this->messagemain->description)
	{?>
	<div class="study_description"><?php echo $this->messagemain->description;?></div>
	<?php } ?>

	<!-- series name -->

	<?php if ($this->messagemain->seriesname)
	{ ?>
	<div class="series"><?php echo JText::_('COM_PREACHIT_Series').':';?><span><?php echo $this->messagemain->seriesname;?></span></div>
	<?php } ?>

	<!-- message duration -->

	<?php if ($this->params->get('show_duration_aud', '1') == '1')
	{
	if ($this->messagemain->duration)
	{ ?>
	<div class="duration"><?php echo JText::_('COM_PREACHIT_Duration').':';?><span><?php echo $this->messagemain->duration;?></span></div>
	<?php } ?>
	<?php }?>

	<!-- share link -->

	<div class="medialinks">
	
		<?php if ($this->params->get('share', '1') == '1')
		{?>
		<?php if ($this->messagemain->share) {?>
			<div class="share"><?php echo $this->messagemain->share;?></div>
		<?php } ?>
		<?php } ?>	
	
	<!-- media links -->
	
		<?php if ($this->messagemain->linkwatch || $this->messagemain->downloadvid)
		{?>
		<span class="videolinks"><?php echo JText::_('COM_PREACHIT_Video').':'; echo $this->messagemain->linkwatch; echo $this->messagemain->downloadvid;?></span>
		<?php } ?>
		
		<?php if ($this->messagemain->linklisten || $this->messagemain->downloadaud)
		{?>	
		<span class="audiolinks"><?php echo JText::_('COM_PREACHIT_Audio').':'; echo $this->messagemain->linklisten; echo $this->messagemain->downloadaud;?></span>
		<?php } ?>	
		
		<?php if ($this->messagemain->linktext || $this->messagemain->linkslides)
		{?>		
		<span class="textlinks"><?php echo JText::_('COM_PREACHIT_Text').':'; echo $this->messagemain->linktext; echo $this->messagemain->linkslides?></span>
		<?php } ?>	
			
		<?php if ($this->messagemain->editlink)
		{ ?>
		<span class="editlinks"><?php echo JText::_('COM_PREACHIT_Manage').':'; echo $this->messagemain->editlink;?></span>
		<?php } ?>	
		
	</div>

<!-- end head -->

</div>

<!-- title for message list -->

<?php 
if ($header == '1')
{?>
<div class="headblock">
<div class="mediasermons"><?php echo $headertext;?></div>
</div>
<?php }?>