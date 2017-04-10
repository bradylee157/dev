<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$header = $this->params->get('headerministryseries', '1');
$headertext = JText::_($this->params->get('headerministrytext', 'COM_PREACHIT_HEADER_MINISTRY'));
?>

<!-- set the div and form for the page -->

<div class="head">

<!-- ministry info -->

<table width="100%">
	<tr>
		<td>
			<?php echo $this->ministry->imagelrg; ?>
			
			<h1 class="ministryname"><?php echo $this->ministry->name; ?></h1>
			
			<div class="ministrydescription"><?php echo $this->ministry->description; ?></div>
			
		</td>
	</tr>
</table>

<!-- end head -->

</div>

<!-- title for series list -->

<?php 
if ($header == '1')
{?>
<div class="headblock">
<div class="ministryseries"><?php echo $headertext;?></div>
</div>
<?php }?>
