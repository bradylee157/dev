<?php
defined('_JEXEC') or die('Restricted access');

function modChrome_homeEvents($module, &$params, &$attribs) {
  if (!empty ($module->content)) {
    echo '<div class="moduletable-ah">';
	echo '<h3>Upcoming Events</h3>';
    echo '<div class="scroll-pane">'; 
    echo $module->content;
    echo '</div>';
    echo '</div>';	
  }	
}


function modChrome_sponsors($module, &$params, &$attribs) {
  if (!empty ($module->content)) {
    echo '<div class="sponsors">';
    echo $module->content;
    echo '</div>';
  }	
}

function modChrome_rightText($module, &$params, &$attribs) {
  if (!empty ($module->content)) {
    echo '<div class="rightText'.$params->get('moduleclass_sfx').'">';
	if ($module->showtitle) {
	  echo '<h'.$headerLevel.'>'.$module->title.'</h>';
	}
    echo $module->content;
    echo '</div>';
  }	
}

function modChrome_leftMenu($module, &$params, &$attribs) {
  if (!empty ($module->content)) {
?>
    <table cellpadding="0" cellspacing="0" border="0" summary="Table for menu format only">
      <tr>
	    <td colspan="3"><img src="<?php echo JURI::base(); ?>/templates/esm_home/images/menu_top_3.jpg" alt=""/></td>
	  </tr>	
	  <tr>
  	    <td class="menu_left">&nbsp;</td>
	    <td class="menu_center"><?php echo $module->content; ?></td>
	    <td class="menu_right">&nbsp;</td>
      </tr>
	  <tr>		
	    <td colspan="3"><img src="<?php echo JURI::base(); ?>/templates/esm_home/images/menu_bottom_3.jpg" alt=""/></td>	    
      </tr>
	 </table>
<?php  
  }	
}
?>