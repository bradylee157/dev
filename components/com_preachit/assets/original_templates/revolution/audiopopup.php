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
require_once($abspath.DIRECTORY_SEPERATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
?>

<div id="audiopopup" class="page">

	<!-- logo container -->
	
	<div class="logo"></div>
	
	<!-- details container -->
	
	<div class="detailscontainer">

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
		echo ' '.JText::_('by').' '.$this->message->teachername;}?>
		
		<?php if ($this->message->seriesname)
		{ ?>
		<div class="series"><?php echo JText::_('COM_PREACHIT_Series').':';?><span><?php echo $this->message->seriesname;?></span></div>
		<?php } ?>
	
	</div>

	<!-- media -->

	<?php echo $this->message->audioplayer->code; 
        if ($this->message->audioplayer->script != '')
        {
            $document->addScript($this->message->audioplayer->script);
        } ?>

	<!-- message description -->

	<?php if ($this->message->description)
	{?>
	<div class="study_description"><?php echo $this->message->description;?></div>
	<?php } ?>

	<!-- message duration -->

	<?php if ($params->get('show_duration_aud', '1') == '1')
	{
	if ($this->message->duration)
	{ ?>
	<div class="duration"><?php echo JText::_('COM_PREACHIT_Duration').':';?><span><?php echo $this->message->duration;?></span></div>
	<?php } ?>
	<?php }?>

	<!-- links -->
	
	<div class="medialinks">
	
		<!-- share link -->
	
		<?php if ($params->get('share', '1') == '1')
		{?>
		<?php if ($this->message->share) {?>
		<div class="share"><?php echo $this->message->share;?></div>
		<?php } ?>
		<?php } ?>	
		
		<!-- media links -->
	
		<?php if ($this->message->linkwatch || $this->message->downloadvid)
		{?>
		<span class="videolinks"><?php echo JText::_('COM_PREACHIT_Video').':'; echo $this->message->linkwatch; echo $this->message->downloadvid;?></span>
		<?php } ?>
		
		<?php if ($this->message->downloadaud)
		{?>	
		<span class="audiolinks"><?php echo JText::_('COM_PREACHIT_Audio').':'; echo $this->message->downloadaud;?></span>
		<?php } ?>	
		
		<?php if ($this->message->linknotes || $this->message->linkslides)
		{?>		
		<span class="textlinks"><?php echo JText::_('COM_PREACHIT_Text').':'; echo $this->message->linknotes; echo $this->message->linkslides;?></span>
		<?php } ?>
		
	</div>

</div>

	<!-- comments -->

	<?php
	require_once($abspath.DIRECTORY_SEPERATOR.'components/com_preachit/helpers/comments.php');
	$comments = PIHelpercomments::getcomments($this->message->id, $this->message->comments, $params);
	 ?>
 
	<?php echo $comments;?>
	
	<!-- powered by notice -->

	<?php echo $this->powered_by;?>
	
<!-- end view id container -->

</div>