<?php
/**
 * @package Hoduma
 * @copyright Copyright (c)2012 Hoduma.com
 * @license GNU General Public License version 3, or later
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
*/

defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//$params = $this->form->getFieldsets('params');
?>
<form action="<?php echo JRoute::_('index.php?option=com_hoduma&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="user-form" class="form-validate">
 
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_HODUMA_VIEW_USER_LEGEND_GENERAL' ); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('general') as $field): ?>
					<li><?php echo $field->label;echo $field->input;?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>
 
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','user-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<?php foreach ($this->form->getFieldset('editoptions') as $field) : ?>
						<li><?php echo $field->label; ?>
						<?php echo $field->input; ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	
	<div class="clr"></div>
 
	<div>
		<input type="hidden" name="task" value="user.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>