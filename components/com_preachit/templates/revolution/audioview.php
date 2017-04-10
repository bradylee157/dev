<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
JHTML::_('behavior.modal');
PIHelperadditional::loadsqueeze();
?>

<div id="audioview" class="page">

	<!-- title & date -->

	<div class="topbar">
		<div class="date"><?php echo $this->message->date;?></div>
		<h1 class="study_name"><?php echo $this->message->name;?></h1>
	</div>

	<!-- scripture & teacher name -->

	<div class="subtitle">
		<?php echo $this->message->scripture; ?>
		<?php if ($this->message->teachername)
		{
		echo ' '.JText::_('COM_PREACHIT_by').' '.$this->message->teachername;}?>
	</div>

	<!-- media -->

	<?php PIHelperadditional::showmediaplayer($this->message->audioplayer); ?>

	<!-- message description -->

	<?php if ($this->message->description)
	{?>
	<div class="study_description"><?php echo $this->message->description;?></div>
	<?php } ?>

	<!-- series name -->

	<?php if ($this->message->seriesname)
	{ ?>
	<div class="series"><?php echo JText::_('COM_PREACHIT_Series').':';?><span><?php echo $this->message->seriesname;?></span></div>
	<?php } ?>

	<!-- message duration -->

	<?php if ($params->get('show_duration_aud', '1') == '1')
	{
	if ($this->message->duration)
	{ ?>
	<div class="duration"><?php echo JText::_('COM_PREACHIT_Duration').':';?><span><?php echo $this->message->duration;?></span></div>
	<?php } ?>
	<?php }?>
	
	<!-- tags -->
	
	<?php if ($this->message->tags)
	{ ?>
	<div class="preachittagscontainer">
		<div class="preachittags"><?php echo JText::_('COM_PREACHIT_TAGS').':';?><span><?php echo $this->message->tags;?></span></div>
	</div>
	<?php } ?>

	<!-- links -->
	
	<div class="medialinks">
	
		<!-- share link -->
	
		<?php if ($params->get('share', '1') == '1' || $params->get('print_text', '1') == 1)
    {?>
        <div class="shareprint"> 
            <?php if ($params->get('share', '1') == '1')
                 { ?>
                    <?php if ($this->message->share) {?>
                        <div class="share"><?php echo $this->message->share;?></div>
                    <?php } ?>
                <?php } ?>    
            <?php if ($params->get('print_text', '1') == 1 && $params->get('show_text_aud', 0) == 1 && strip_tags($this->message->text) != null)
                {?>
                    <div class="printbutton"><a href="<?php echo JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=print&view=text&id='.$this->message->id);?>" target="blank"><?php echo JText::_('COM_PREACHIT_PRINT');?></a></div>
            <?php }?>
        </div>
    <?php } ?>
		
		<!-- media links -->
	
		<?php if ($this->message->linkwatch || $this->message->downloadvid || $this->message->purchasevid)
		{?>
		<span class="videolinks"><?php echo JText::_('COM_PREACHIT_Video').':'; echo $this->message->linkwatch; echo $this->message->downloadvid; echo $this->message->purchasevid;?></span>
		<?php } ?>
		
		<?php if ($this->message->downloadaud || $this->message->purchaseaud)
		{?>	
		<span class="audiolinks"><?php echo JText::_('COM_PREACHIT_Audio').':'; echo $this->message->downloadaud; echo $this->message->purchaseaud;?></span>
		<?php } ?>	
		
		<?php if ($this->message->linktext || $this->message->linknotes  || $this->message->linkslides)
		{?>		
		<span class="textlinks"><?php echo JText::_('COM_PREACHIT_Text').':'; echo $this->message->linktext; echo $this->message->linknotes; echo $this->message->linkslides;?></span>
		<?php } ?>	
		
		<?php if ($this->message->amlink)
		{?>		
		<span class="asmedialinks"><?php echo JText::_('COM_PREACHIT_Other').':'; echo $this->message->amlink;?></span>
		<?php } ?>
			
		<?php if ($this->message->editlink)
		{ ?>
		<span class="editlinks"><?php echo JText::_('Manage').':'; echo $this->message->editlink;?></span>
		<?php } ?>	
		
	</div>

<!-- message text -->
 	<?php $text = $params->get('show_text_aud', 0);
	if ($text == 1 && $this->message->text)
	{?>
 	<div class="study_text"><?php echo $this->message->text;?></div>
 	
	<?php if ($params->get('show_2links_aud', 0) == 1)
 	{?>
 	
 	<!-- links -->
	
	<div class="medialinks">
	
		<!-- share link -->
	
		<?php if ($params->get('share', '1') == '1' || $params->get('print_text', '1') == 1)
    {?>
        <div class="shareprint"> 
            <?php if ($params->get('share', '1') == '1')
                 { ?>
                    <?php if ($this->message->share) {?>
                        <div class="share"><?php echo $this->message->share;?></div>
                    <?php } ?>
                <?php } ?>    
            <?php if ($params->get('print_text', '1') == 1 && $params->get('show_text_aud', 0) == 1 && strip_tags($this->message->text) != null)
                {?>
                    <div class="printbutton"><a href="<?php echo JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=print&view=text&id='.$this->message->id);?>" target="blank"><?php echo JText::_('COM_PREACHIT_PRINT');?></a></div>
            <?php }?>
        </div>
    <?php } ?>
		
		<!-- media links -->
	
		<?php if ($this->message->linkwatch || $this->message->downloadvid || $this->message->purchasevid)
		{?>
		<span class="videolinks"><?php echo JText::_('COM_PREACHIT_Video').':'; echo $this->message->linkwatch; echo $this->message->downloadvid; echo $this->message->purchasevid;?></span>
		<?php } ?>
		
		<?php if ($this->message->downloadaud || $this->message->purchaseaud)
		{?>	
		<span class="audiolinks"><?php echo JText::_('COM_PREACHIT_Audio').':'; echo $this->message->downloadaud; echo $this->message->purchaseaud;?></span>
		<?php } ?>	
		
		<?php if ($this->message->linktext || $this->message->linknotes || $this->message->linkslides)
		{?>		
		<span class="textlinks"><?php echo JText::_('COM_PREACHIT_Text').':'; echo $this->message->linktext; echo $this->message->linknotes; echo $this->message->linkslides;?></span>
		<?php } ?>		
		
		<?php if ($this->message->amlink)
		{?>		
		<span class="asmedialinks"><?php echo JText::_('COM_PREACHIT_Other').':'; echo $this->message->amlink;?></span>
		<?php } ?>
			
		<?php if ($this->message->editlink)
		{ ?>
		<span class="editlinks"><?php echo JText::_('COM_PREACHIT_Manage').':'; echo $this->message->editlink;?></span>
		<?php } ?>	
		
	</div>

 	<?php }?>
 <?php }?>
 
	<!-- backlink -->
 
	<?php echo $this->backlink;?>

	<!-- comments -->

	<?php
	require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/comments.php');
	$comments = PIHelpercomments::getcomments($this->message->id, $this->message->comments, $params);
	 ?>
 
	<?php echo $comments;?>
	
	<!-- powered by notice -->

	<?php echo $this->powered_by;?>
	
<!-- end view id container -->

</div>