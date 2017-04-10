<?php defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="piseries<?php echo $moduleclass_sfx; ?> modsdefault">

<?php 

foreach ($list as $series) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_piseries', '_series')); ?>
				
	<div class="blocklist">
		<?php echo $image; ?>
		<?php echo $title;?>
		<?php echo $description;?>
		<div class="clr"></div>
	</div>
	<?php
}?>
</div>