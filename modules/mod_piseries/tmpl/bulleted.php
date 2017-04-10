<?php defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="piseries<?php echo $moduleclass_sfx; ?> modsbullet">

<?php 

foreach ($list as $series) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_piseries', '_series')); ?>
		
	<div class="blocklist"><ul>
		<li><?php echo $image; ?>
		<?php echo $title;?>
		<?php echo $description;?></li>
	</ul>
	<div class="clr"></div>
	</div>
	<?php
}
?>
</div>