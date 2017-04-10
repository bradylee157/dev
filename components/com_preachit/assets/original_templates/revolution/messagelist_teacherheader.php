<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$header = $this->params->get('headerteachersermons', '1');
$headertext = JText::_($this->params->get('headerteachertext', 'COM_PREACHIT_HEADER_TEACHER'));
?>
<input id="layout" value="<?php echo $this->listview;?>" type="hidden"/>
<input id="teacher" value="<?php echo $this->filter_teacher;?>" type="hidden"/>
<!-- head -->

<div class="head">

	<!-- teacher info -->
	
	<table width="100%">
		<tr>
			<td>
				<?php echo $this->teacher->imagelrg;?>
				<?php echo $this->teacher->editlink;?>
				<h1 class="teachername"><?php echo $this->teacher->name; ?></h1>
				<?php if ($this->teacher->role)
				{?>
					<div class="teacherrole"><?php echo JText::_('COM_PREACHIT_ROLE').':';?> <?php echo htmlspecialchars($this->teacher->role); ?></div><?php }?>
				<?php if ($this->teacher->web)
				{?>
					<div class="teacherweb"><?php echo JText::_('COM_PREACHIT_WEB').':';?> <?php echo $this->teacher->web; ?></div><?php }?>
			</td>
		</tr>
	</table>
	
	<div class="teacherdescription"><?php echo $this->teacher->description; ?></div>			

<!-- end head -->

</div>

<!-- title for message list -->

<?php 
if ($header == '1')
{?>
<div class="headblock">
<div class="sermonsbyteacher"><?php echo $headertext;?></div>
</div>
<?php }?>
