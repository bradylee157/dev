<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$eName	= JRequest::getVar('e_name');
$eName	= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
?>
<script type="text/javascript">
			function insertPreachitcode()
			{
				if (document.getElementById("piid").value == '') {
				alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_ID');?>");
				} 	
				
				else if (document.getElementById("piview").value == '') {
				alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_VIEW');?>");
				} 
				
				else if (document.getElementById("piwidth").value == '' && document.getElementById("piheight").value != '') {
				alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_BOTH_HEIGHT_AND_WIDTH');?>");
				} 
				
				else if (document.getElementById("piheight").value == '' && document.getElementById("piwidth").value != '') {
				alert("<?php echo JText::_('COM_PREACHIT_JAVA_ENTER_BOTH_HEIGHT_AND_WIDTH');?>");
				} 
				
				else {	
				
				var picode = '';	
				
				if (document.getElementById("piwidth").value != '' && document.getElementById("piwidth").value != '')
	
					{
						var piid = document.getElementById("piid").value;	
						var piview = document.getElementById("piview").value;
						var piwidth = document.getElementById("piwidth").value;
						var piheight = document.getElementById("piheight").value;
						
						picode = "{preachit "+piid+", "+piview+", "+piwidth+", "+piheight+"}";
					}
					
				else {
					
						var piid = document.getElementById("piid").value;	
						var piview = document.getElementById("piview").value;
						picode = "{preachit "+piid+", "+piview+"}";	
					}
				

				window.parent.jInsertEditorText(picode, '<?php echo $eName; ?>');
				window.parent.SqueezeBox.close();
				return false;
				
				}
			}
		</script>

		<form>
		<table width="100%" align="center">
			<tr>
				<td class="key" align="right" width="100px">
					<label for="title">
						<?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_ID' ); ?>
					</label>
				</td>
				<td>
					<?php echo $this->piid;?>
				</td>
			</tr>
			<tr>
				<td class="key" align="right">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_VIEW' ); ?>
					</label>
				</td>
				<td>
					<?php echo $this->piview;?>
				</td>
			</tr>
			<tr>
				<td class="key" align="right">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_WIDTH' ); ?>
					</label>
				</td>
				<td>
					<input type="text" id="piwidth" name="piwidth" />
				</td>
			</tr>
			<tr>
				<td class="key" align="right">
					<label for="alias">
						<?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_HEIGHT' ); ?>
					</label>
				</td>
				<td>
					<input type="text" id="piheight" name="piheight" />
				</td>
			</tr>
		</table>
		</form>
		<button style="margin: 10px 0 0 100px;" onclick="insertPreachitcode();"><?php echo JText::_( 'COM_PREACHIT_EDITOR_BUTTON_INSERT_CODE' ); ?></button>










