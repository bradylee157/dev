<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$header = $this->params->get('headerseriessermons', '1');
$headertext = JText::_($this->params->get('headerseriestext', 'COM_PREACHIT_HEADER_SERIES'));
?>
<input id="layout" value="<?php echo $this->listview;?>" type="hidden"/>
<input id="series" value="<?php echo $this->filter_series;?>" type="hidden"/>
<!-- head -->

<div class="head">

	<!-- series info -->

				<?php echo $this->series->imagelrg;?>
				<?php echo $this->series->editlink;?>
				<h1 class="seriesname"><?php echo $this->series->name; ?></h1>
                <div class="seriesdate"><?php echo $this->series->daterange; ?></div>
				<div class="seriesdescription"><?php echo $this->series->description; ?></div>

<!-- end head -->

</div>
<div class="clr"></div>

<!-- title for message list -->

<?php 
if ($header == '1')
{?>
<div class="headblock">
<div class="seriessermons"><?php echo $headertext;?></div>
</div>
<?php }?>