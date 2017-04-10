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
<input id="tag" name="tag" value="<?php echo $this->filter_tag;?>" type="hidden"/>
<input id="layout" value="<?php echo $this->listview;?>" type="hidden"/>
<!-- head -->

<?php $header = JText::_('COM_PREACHIT_TAG').' - <span>'.$this->tag.'</span>';

	if ($this->tag)
		{ ?>
			
			<h1 class="tagheader"><?php echo $header; ?></h1>
			
		<?php } ?>
			

<!-- end head -->
