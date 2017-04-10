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

require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'head.php'; //sends us to the core helper files
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'configcheck.php'; //sends us to the admin helper files
?>
<table class="adminform">
	<tr>
		<td width="60%">
			<div id="cpanel">
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=categories" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/categories.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_CATEGORIES'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=departments" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/departments.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_DEPARTMENTS'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=priorities" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/priorities.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_PRIORITIES'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=statuses" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/statuses.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_STATUSES'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=users" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/users.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_USERS'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=emails" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/mails.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_EMAILS'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=about" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/about.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_ABOUT'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon">
					<a href="index.php?option=com_hoduma&view=wizard" >
						<img src="<?php echo JURI::root(); ?>media/com_hoduma/images/wizard.png" alt=" Tabs" width="42px" height="42px" />
						<br /><span><?php echo JText::_('COM_HODUMA_WIZARD'); ?></span>
						</a>
					</div>
				</div>
				<div style="float:left;">
					<div class="icon" style="font-size: 10px;">
						<?php echo LiveUpdate::getIcon(); ?>
					</div>
				</div>
			</div>
			<div style="clear:both;"> </div>
			<div>
				<p><a href="index.php?option=com_hoduma&view=import"><?php echo JText::_('COM_HODUMA_IMPORT_USERS'); ?></a></p>
			</div>
			<div>
				<p><a href="http://www.hoduma.com" target="_blank"><?php echo JText::_('COM_HODUMA_PROJECTHOME'); ?></a></p>
				<p><a href="http://www.hoduma.com/documentation" target="_blank"><?php echo JText::_('COM_HODUMA_DOCUMENTATION'); ?></a></p>
				<p><a href="http://www.hoduma.com/support" target="_blank"><?php echo JText::_('COM_HODUMA_SUPPORT'); ?></a></p>
			</div>
		</td>
		<td width="40%">
			<p><img src="components/com_hoduma/images/logo.png" style=""></img></p>
			<p><b><?php echo JText::_('COM_HODUMA'); ?> <?php echo $this->version; ?></b></p>
			<p><b><?php echo JText::_('COM_HODUMA_CPANEL_CHANGES'); ?></b><br />
			- changes for Joomla! 2.5
			</p>
			<p><b><?php echo JText::_('COM_HODUMA_CONFIG_CHECK'); ?></b></p>
			<div><?php configCheck();?></div>
		</td>
	</tr>
</table>