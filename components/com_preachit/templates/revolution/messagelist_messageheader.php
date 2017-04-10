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

<!-- hidden inputs to run js script -->

  <input name="checkvar" value="<?php echo $this->item;?>" type="hidden"/>
  <input name="pifbook" value="<?php echo $this->pifbook;?>" type="hidden"/>
  <input name="pifteach" value="<?php echo $this->pifteach;?>" type="hidden"/>
  <input name="pifseries" value="<?php echo $this->pifseries;?>" type="hidden"/>
  <input name="pifministry" value="<?php echo $this->pifministry;?>" type="hidden"/>
  <input name="pifyear" value="<?php echo $this->pifyear;?>" type="hidden"/>

<!-- display the sortlists -->

<?php if ($this->params->get('filterbar', '1'))
{?>
<div class="headblock">
<div class="sortlistblock">
<table class="pifilter">
<tr>
<td>
<div class="filtertext"><?php echo JText::_('COM_PREACHIT_FILTER_MEDIA');?></div>
</td>
<?php if ($this->params->get('filter_book', '1'))
{?>
<td>
<div class="sortlists flbook"><?php echo $this->study_book;?></div>
</td>
<?php }
if ($this->params->get('filter_teacher', '1'))
{?>
<td>
<div class="sortlists flteach"><?php echo $this->teacher_list; ?></div>
</td>
<?php }
if ($this->params->get('filter_series', '1'))
{?>
<td>
<div class="sortlists flseries"><?php echo $this->series_list; ?></div>
</td>
<?php }
if ($this->params->get('filter_ministry', '0'))
{?>
<td>
<div class="sortlists flminsitry"><?php echo $this->ministry_list; ?></div>
</td>
<?php }
if ($this->params->get('filter_year', '1'))
{?>
<td>
<div class="sortlists flyear"><?php echo $this->years_list;?></div>
</td>
<?php } ?>
</tr>
</table>
</div>
<noscript><input class="pimlsubmit" type="submit" value="<?php echo JText::_('COM_PREACHIT_GO');?>"></noscript>
</div>

<?php
}
?>