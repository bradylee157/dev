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
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dialog-modal').dialog({
			height: 250,
			width: 450,
			modal: true,
			autoOpen: false,
			resizable: false,
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
		$('#dialog-confirm').dialog({
			resizable: false,
			height: 300,
			width: 450,
			modal: true,
			autoOpen: false,
			buttons: {
				'<?php echo JText::_('COM_HODUMA_CONFIRM'); ?>': function() {
					$(this).dialog('close');
					$('#buttonstart').css('display', 'none');
					$('#progressbar').progressbar();
					$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_ATTACHMENTS'); ?>');
					$.blockUI({
						message: $('#blockui')
					});
					$.ajax({
						type: 'GET',
						url: 'index.php?option=com_hoduma&task=wizard.transferattachments',
						cache: false,
						success: function(data) {
							$('#progressbar').progressbar('option', 'value', 11);
							$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_CATEGORIES'); ?>');
							$.ajax({
								type: 'GET',
								url: 'index.php?option=com_hoduma&task=wizard.transfercategories',
								cache: false,
								success: function(data) {
									$('#progressbar').progressbar('option', 'value', 22);
									$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_DEPARTMENTS'); ?>');
									$.ajax({
										type: 'GET',
										url: 'index.php?option=com_hoduma&task=wizard.transferdepartments',
										cache: false,
										success: function(data) {
											$('#progressbar').progressbar('option', 'value', 33);
											$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_EMAILS'); ?>');
											$.ajax({
												type: 'GET',
												url: 'index.php?option=com_hoduma&task=wizard.transferemailmsg',
												cache: false,
												success: function(data) {
													$('#progressbar').progressbar('option', 'value', 44);
													$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_NOTES'); ?>');
													$.ajax({
														type: 'GET',
														url: 'index.php?option=com_hoduma&task=wizard.transfernotes',
														cache: false,
														success: function(data) {
															$('#progressbar').progressbar('option', 'value', 55);
															$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_PRIORITIES'); ?>');
															$.ajax({
																type: 'GET',
																url: 'index.php?option=com_hoduma&task=wizard.transferpriorities',
																cache: false,
																success: function(data) {
																	$('#progressbar').progressbar('option', 'value', 66);
																	$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_PROBLEMS'); ?>');
																	$.ajax({
																		type: 'GET',
																		url: 'index.php?option=com_hoduma&task=wizard.transferproblems',
																		cache: false,
																		success: function(data) {
																			$('#progressbar').progressbar('option', 'value', 77);
																			$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_STATUSES'); ?>');
																			$.ajax({
																				type: 'GET',
																				url: 'index.php?option=com_hoduma&task=wizard.transferstatuses',
																				cache: false,
																				success: function(data) {
																					$('#progressbar').progressbar('option', 'value', 88);
																					$('#currentstep').html('<?php echo JText::_('COM_HODUMA_TRANSFER_USERS'); ?>');
																					$.ajax({
																						type: 'GET',
																						url: 'index.php?option=com_hoduma&task=wizard.transferusers',
																						cache: false,
																						success: function(data) {
																							$('#progressbar').progressbar('option', 'value', 100);
																							$('#progressbar').progressbar('option', 'value', 100);
																							$.unblockUI();
																							$('#blockui').css('display', 'none');
																							$('#currentstep').css('display', 'none');
																							$('#progressbar').css('display', 'none');
																							$('#maincontent').html('<p>Transfer completed!</p>');
																							$('#dialog-modal').dialog('open');
																						}
																					});
																				}
																			});
																		}
																	});
																}
															});
														}
													});
												}
											});
										}
									});
								}
							});
						}
					});
				},
				'<?php echo JText::_('COM_HODUMA_CANCEL'); ?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		if($('#buttonstart').length > 0) {
			$('#buttonstart').click(function() {
				$('#dialog-confirm').dialog('open');
			});
		}
	});
</script>
<h1><?php echo JText::_('COM_HODUMA_MIGRATION_WIZARD'); ?></h1>
<p><?php echo JText::_('COM_HODUMA_MIGRATION_WIZARD_DESC'); ?></p>
<div id="maincontent">
	<h2><?php echo JText::_('COM_HODUMA_HURU_INSTALL_CHECK'); ?></h2>
	<?php
	if($this->hurufound == false) {
		echo '<p>'. JText::_('COM_HODUMA_HURU_NOTFOUND') .'</p>';
	} else {
		echo '<p>'. JText::_('COM_HODUMA_HURU_FOUND') .'</p>';
		echo '<button id="buttonstart">'. JText::_('COM_HODUMA_START_MIGRATION') .'</button>';
	}
	?>
</div>
<div id="blockui">
	<div id="currentstep"></div>
	<div id="progressbar"></div>
</div>
<div id="dialog-modal" title="Status"><p><?php echo JText::_('COM_HODUMA_MIGRATION_SUCCESSFUL'); ?></p></div>
<div id="dialog-confirm" title="<?php echo JText::_('COM_HODUMA_MIGRATE_TITLE'); ?>">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo JText::_('COM_HODUMA_CONFIRM_TRANSFER'); ?></p>
</div>
