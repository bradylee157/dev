<?php 
/**
 * @version		$Id: mod_AvatarSlide.php 48 2011-06-25 08:22:19Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_AvatarSlide/assets/css/style1.css');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
$document->addScript('modules/mod_AvatarSlide/assets/js/jquery.easing.js');
$document->addScript('modules/mod_AvatarSlide/assets/js/script.js');
$id="AvatarSlide";
$buttonId=uniqid('buttonControl_');
?>
<script type="text/javascript">
jQuery.noConflict();
(function($) 
{ 
	$(function() 
	{
		$(document).ready( function(){
				// buttons for next and previous item						 
				var buttons = { previous:$("#<?php echo $id;?> .button-previous") , next:$("#<?php echo $id;?> .button-next"), auto:$("#<?php echo $id;?> .button-control") };			
				 $("#<?php echo $id;?>").lofJSidernews( { interval : <?php echo $Time?>,
													direction		: "opacitys",	
													easing			: "easeInOutExpo",
													duration		: 1500,
													maxItemDisplay  : <?php echo $ThumbDisplay?>,
													navSize			: <?php echo $ThumbSize?>,
													mainWidth		: <?php echo $SlideWidth?>,
													ratio			: <?php echo $Ratio?>,
													buttons			: buttons,
													buttonControl	: "#<?php echo $buttonId?>",
													auto			: <?php echo $Auto?>
													} );
				$$('#<?php echo $id;?>,#<?php echo $id;?>.lof-slidecontent,#<?php echo $id;?>.main-slider-content,#<?php echo $id;?> .navigator-content').setStyle('width',<?php echo $SlideWidth?>);
				$$('#<?php echo $id;?>,#<?php echo $id;?>.lof-slidecontent,.lof-slidecontent  ul.sliders-wrap-inner li').setStyle('height',<?php echo $SlideHeight?>);
		});
	})
})(jQuery);
</script>

	<?php
	$PathRoot= JPath::clean(JPATH_ROOT.DS.'/images/');
	for($p = 0; $p < sizeof($Path); $p++)
	{
		$ListImage[$p] = JFolder::files($PathRoot.$Path[$p],$filter = '.');
	}
	$size = array();
	$tmpListImage = array();
	$count = 0;
	for($p = 0; $p < sizeof($Path); $p++)
	{
		$imgInFolder=0;	
		$tmpListImage[$p] = array();		
		for($n = 0;$n < sizeof($ListImage[$p]); $n++)
		{
			$tmp = $ListImage[$p][$n];
			$pattern = '/[^A-Za-z0-9._-\s()]/';
			$ext = end(explode('.', $tmp));
			if(strcmp($ext,"png") == 0||strcmp($ext,"jpeg") == 0||strcmp($ext,"jpg") == 0||strcmp($ext,"gif") == 0)
			{
				if(preg_match($pattern, $tmp));
				else {
					$size[$count++] = getimagesize($PathRoot.$Path[$p].'/'.$tmp);
					$tmpListImage[$p][$imgInFolder++] = $ListImage[$p][$n];
				}
			}		
		}
	}
	if($ThumbSize==1)
	{
			$ThumbWidth = 100;
	}
	else
	{
		$ThumbWidth = 70;
	}
	
	$ThumbHeight = $ThumbWidth*$Ratio;
	$cssTopPN = ($ThumbHeight-15)/2;
    ?>
<style type="text/css">
#<?php echo $id; ?> ul{
	margin: 0;
	padding: 0;
}
</style>  
<div id="<?php echo $id;?>" class="lof-slidecontent">
	<div class="preload">
		<div></div>
	</div>
    <!-- MAIN CONTENT --> 
    <div class="main-slider-content">
    	<ul class="sliders-wrap-inner">
    		<?php
    		$count=0;
			for($p = 0; $p < sizeof($Path); $p++)
			{			
				for($n = 0;$n < sizeof($tmpListImage[$p])&&$count<10;$n++,$count++)
				{
					$tmp = $tmpListImage[$p][$n];
					$w = $size[$count][0];
					$h = $size[$count][1];
					if($w > $SlideWidth || $h > $SlideHeight)
					{
						if($w/$h < $SlideWidth/$SlideHeight)
						{
							$w = $SlideHeight*$w/$h;
							$h = $SlideHeight;
						}
						if($w/$h >= $SlideWidth/$SlideHeight)
						{
							$h = $SlideWidth*$h/$w;
							$w = $SlideWidth;
						}
					}
					$t = ($SlideHeight-$h)/2;
					$l = ($SlideWidth-$w)/2;
					echo "<li><img src='".JURI::base()."images/$Path[$p]/$tmp' style='width:$w";echo "px;height:$h";echo "px;top:$t";echo "px;left:$l";echo "px;'/></li> ";
				}
			}   		
    		?>
         </ul>  	
    </div>
 		   <!-- END MAIN CONTENT --> 
           <!-- NAVIGATOR -->
    <div class="navigator-content">
                  <div class="button-previous" style="margin-top:<?php echo $cssTopPN?>px">Previous</div>
                  <div class="navigator-wrapper">
                        <ul class="navigator-wrap-inner">
                        	<?php
                        	$count = 0;
				    		for($p = 0;$p < sizeof($Path);$p++)
							{			
								for($n = 0;$n < sizeof($tmpListImage[$p])&&$count<10;$n++,$count++)
								{
									$tmp = $tmpListImage[$p][$n];
									$w = $size[$count][0];
									$h = $size[$count][1];
									if($w > $ThumbWidth||$h > $ThumbHeight)
									{
										if($w/$h < $ThumbWidth/$ThumbHeight)
										{
											$w = $ThumbHeight*$w/$h;
											$h = $ThumbHeight;
										}
										if($w/$h >= $ThumbWidth/$ThumbHeight)
										{
											$h = $ThumbWidth*$h/$w;
											$w = $ThumbWidth;
										}
									}
									echo "<li><img src='".JURI::base()."images/$Path[$p]/$tmp' style='width:$w";echo "px;height:$h";echo "px;'/></li> ";
								}
							}   		
				    		?>      		
                        </ul>
                  </div>
                  <div  class="button-next" style="margin-top:<?php echo $cssTopPN?>px">Next</div>
     </div> 
          <!----------------- END OF NAVIGATOR --------------------->
          <!-- BUTTON PLAY-STOP -->
          <div id="<?php echo $buttonId?>" class="button-control"><span></span></div>
          <!-- END OF BUTTON PLAY-STOP --> 
</div>
<div class="avatarslide-copyright" style="width: <?php echo $SlideWidth; ?>px;">
	&copy; JoomAvatar.com
	<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Extension</a>-
	<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Template</a>
</div>