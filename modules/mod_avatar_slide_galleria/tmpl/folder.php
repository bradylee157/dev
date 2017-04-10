<?php 
/**
 * @version		$Id: helper.php 5 2012-04-06 20:10:35Z mozart $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @mail		chungnt@joomavatar.com
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
	<div id="avatar_galleria_<?php echo $id?>" class="galleria-<?php echo $theme?>" style="margin: auto;width:<?php echo $sliderWidth;?>;height:<?php echo $sliderHeight?>;">
		<?php
			$count = 0;
			for($p = 0 ; $p < sizeof($path) ; $p++)
			{			
				for($n = 0 ; $n < sizeof($tmpListImage[$p]) && $n< $itemCount ; $n++, $count++)
				{
					$tmp = $tmpListImage[$p][$n];
					echo "<a href='".JURI::base()."images/".$path[$p]."/".$tmp."'><img style='display:none;' src='".JURI::base()."images/".$path[$p]."/".$tmp."'";
					if ($showFileName == "true")
					{
						echo "data-title='".$tmp."'";
					}
					if ($tmpListDesc != NULL || $tmpListTitle !=NULL) 
					{
						$position = $count+1;
						if(isset($tmpListDesc["$position"]) ||isset($tmpListTitle["$position"]))
						{
							if(isset($tmpListTitle["$position"]) && $showFileName == "false")
							{
								echo "data-title='".$tmpListTitle["$position"]."' ";
							}
							if(isset($tmpListDesc["$position"]))
							{
								echo "data-description='".$tmpListDesc["$position"]."' ";
							}
						}
					}
					echo "/></a>";
				}
			}    		
		?>
	</div>