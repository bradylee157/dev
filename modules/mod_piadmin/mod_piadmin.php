<?php
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.modal');
$document =& JFactory::getDocument();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$document->addStyleSheet('modules/mod_piadmin/assets/modstyle.css');
$layout = $params->get('style', 'default');
$rel = "'iframe'";
$link = '<a id="pimessageadd" href ="' . JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=modal&view=studyedit') . '" class="modal" rel="{handler: '.$rel.', size: {x: 960, y: 600}}">'.JText::_('MOD_PIADMIN_ADD_A_MESSAGE').'</a>';
$link2 = '<a id="pipodpub" href ="' . JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=modal&view=podcastlist') . '" class="modal" rel="{handler: '.$rel.', size: {x: 960, y: 600}}">'.JText::_('MOD_PIADMIN_PUBLISH_A_PODCAST').'</a>';
$link3 = '<a id="piseriesadd" href ="' . JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=modal&view=seriesedit') . '" class="modal" rel="{handler: '.$rel.', size: {x: 960, y: 600}}">'.JText::_('MOD_PIADMIN_ADD_A_SERIES').'</a>';
$link4 = '<a id="piteachadd" href ="' . JRoute::_( 'index.php?option=com_preachit&tmpl=component&layout=modal&view=teacheredit') . '" class="modal" rel="{handler: '.$rel.', size: {x: 960, y: 600}}">'.JText::_('MOD_PIADMIN_ADD_A_TEACHER').'</a>';

if ($layout == 'bulleted')
{
?>
<div class="piadmin<?php echo $moduleclass_sfx; ?> bulletadmin">
<ul class="ul">
<?php if ($params->get('message', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link;?></span></li>
<?php } ?>
<?php if ($params->get('teacher', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link4;?></span></li>
<?php } ?>
<?php if ($params->get('series', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link3;?></span></li>
<?php } ?>
<?php if ($params->get('podcast', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link2;?></span></li>
<?php } ?>

</ul>
</div>
<?php }

else {
	?>
<div class="piadmin<?php echo $moduleclass_sfx; ?> defaultadmin">
	<?php if ($params->get('message', 1) == 1)
{ ?>
<div class="links"><?php echo $link;?></div>
<?php } ?>
<?php if ($params->get('teacher', 1) == 1)
{ ?>
<div class="links"><?php echo $link4;?></div>
<?php } ?>
<?php if ($params->get('series', 1) == 1)
{ ?>
<div class="links"><?php echo $link3;?></div>
<?php } ?>
<?php if ($params->get('podcast', 1) == 1)
{ ?>
<div class="links"><?php echo $link2;?></div>
<?php } ?>
</div>
<?php } ?>

<!-- Javascript to adjust modal size if smaller window -->

<script type="text/javascript" >
function piadminrescheck()
{
var width = '';
var height = '';
if (screen.width < 1000 || screen.height < 900)
{width = screen.width - 100;
height = screen.height - 300;}
if (width && height)
{
	if (res = document.getElementById('pimessageadd'))
	{res = document.getElementById('pimessageadd');
	res.rel = "{handler: 'iframe', size: {x: "+width+", y: "+height+"}}";}
	if (res = document.getElementById('pipodpub'))
	{res = document.getElementById('pipodpub');
	res.rel = "{handler: 'iframe', size: {x: "+width+", y: "+height+"}}";}
	if (res = document.getElementById('piseriesadd'))
	{res = document.getElementById('piseriesadd');
	res.rel = "{handler: 'iframe', size: {x: "+width+", y: "+height+"}}";}
	if (res = document.getElementById('piteachadd'))
	{res = document.getElementById('piteachadd');
	res.rel = "{handler: 'iframe', size: {x: "+width+", y: "+height+"}}";}
}
}
if (window.addEventListener){
window.addEventListener('load', piadminrescheck, false);
} else if (window.attachEvent){
 window.attachEvent('load', piadminrescheck);
}

</script>