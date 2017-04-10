<?php defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="piteachers<?php echo $moduleclass_sfx; ?> modtbullet">

<?php 

foreach ($list as $teacher) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_piteachers', '_teacher')); ?>
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