<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="pitags<?php echo $moduleclass_sfx; ?>">			
	<div class="blocklist">
<?php
foreach ($tagdata->tagarray as &$tag)
{
	echo '<a class="taglink" style="font-size: '.round($tag->size, 3).$unit.';" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=tag&tag='.$tag->name.'&Itemid='.$menuid).'">'.htmlspecialchars($tag->name).'</a> ';
}
?>

	</div>
</div>
