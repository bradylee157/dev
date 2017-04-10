<?php
/**
 * @version		$Id: coolfeed.php 97 2011-12-14 15:12:49Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgContentAvatarSlide extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$app = JFactory::getApplication();
		
		$document = JFactory::getDocument();
		$document->addStyleSheet('plugins/content/AvatarSlide/assets/css/style1.css');
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		$document->addScript('plugins/content/AvatarSlide/assets/js/jquery.easing.js');
		$document->addScript('plugins/content/AvatarSlide/assets/js/script.js');
		$pathDefault = NULL;
		$timeDefault = 4000;
		$autoDefault = 1;
		$slideHeightDefault = 300;
		$slideWidthDefault = 600;
		$thumbDisplayDefault = 6;
		$thumbSize = 2;
		
		$path = array();
		$time = array();
		$auto = array();
		$slideHeight = array();
		$slideWidth = array();
		$thumbDisplay = array();
		$ratio = array();
		$countPlg= 0 ;
		
		$text = &$article->text;

		$pattern = '/\{avatarslide[^}]*\/}/i';
		preg_match_all($pattern, $text, $matches);
		$arrayFormat = array();
		ob_start();
		foreach ($matches[0] as $format)
		{
			$id = "AvatarSlideplg";
			$pattern = '/\bsrc=[a-zA-Z0-9\/]*/i';
			preg_match($pattern, $format, $srcInfo);
			if (count($srcInfo) > 0)
			{
				$tmp = explode('=', $srcInfo[0]);			
				$path[$countPlg]=$tmp[1];
			}
			else
				{
					$path[$countPlg]=$pathDefault;
				}
			
			$pattern = '/\btime=[0-9]*\b/';
			preg_match($pattern, $format, $timeInfo);
			if (count($timeInfo) > 0) 
			{
				$tmp = explode('=', $timeInfo[0]);
				$time[$countPlg]=$tmp[1];
			}
			else
				{
					$time[$countPlg]=$timeDefault;
				}
			
//			var_dump($format, $feedInfo, $groupInfo);
			$pattern = '/\bauto=[a-z]*\b/';
			preg_match($pattern, $format, $autoInfo);
			if (count($autoInfo) > 0) 
			{
				$tmp = explode('=', $autoInfo[0]);
				if(strcmp($tmp[1], "true") == 0 || strcmp($tmp[1], "TRUE") == 0 || strcmp($tmp[1], "false") == 0 ||strcmp($tmp[1], "FALSE") == 0)
					$auto[$countPlg]=$tmp[1];
			}
			else
				{
					$auto[$countPlg]=$autoDefault;
				}
				
			$pattern = '/\bheight=[0-9]*\b/';
			preg_match($pattern, $format, $heightInfo);
			if (count($heightInfo) > 0)
			{
				$tmp = explode('=', $heightInfo[0]);
				$slideHeight[$countPlg]=$tmp[1];
			}
			else
				{
					$slideHeight[$countPlg]=$slideHeightDefault;
				}
			
			$pattern = '/\bwidth=[0-9]*\b/';
			preg_match($pattern, $format, $widthInfo);
			if (count($widthInfo) > 0) 
			{
				$tmp = explode('=', $widthInfo[0]);
				$slideWidth[$countPlg]=$tmp[1];
			}
			else
				{
					$slideWidth[$countPlg]=$slideWidthDefault;
				}
			
			$pattern = '/\bthumb=[0-9]*\b/';
			preg_match($pattern, $format, $thumbInfo);
			if (count($thumbInfo) > 0) 
			{
				$tmp = explode('=', $thumbInfo[0]);
				$thumbDisplay[$countPlg]=$tmp[1];
			}
			else
				{
					$thumbDisplay[$countPlg]=$thumbDisplayDefault;
				}
				
			$ratio[$countPlg] = $slideHeight[$countPlg]/$slideWidth[$countPlg];
			//var_dump($path,$slideHeight,$slideWidth);
			
			?>		
			<script type="text/javascript">
			jQuery.noConflict();
			(function($) 
			{ 
				$(function() 
				{
					$(document).ready( function(){
							// buttons for next and previous item						 
							var buttons = { previous:$("#<?php echo $id;?> .button-previous") , next:$("#<?php echo $id;?> .button-next"),auto:$("#<?php echo $id;?> .button-control") };			
							  $("#<?php echo $id;?>").lofJSidernews( { interval : <?php echo $time[$countPlg]?>,
																direction		: "opacitys",	
																easing			: "easeInOutExpo",
																duration		: 1500,
																maxItemDisplay  : <?php echo $thumbDisplay[$countPlg]?>,
																navSize			: <?php echo $thumbSize?>,
																mainWidth		: <?php echo $slideWidth[$countPlg]?>,
																ratio			: <?php echo $ratio[$countPlg]?>,
																buttons			: buttons,
																auto			: <?php echo $auto[$countPlg]?>
																} );
							$$('#<?php echo $id;?>,#<?php echo $id;?>.lof-slidecontent-plg,#<?php echo $id;?>.main-slider-content,#<?php echo $id;?> .navigator-content').setStyle('width',<?php echo $slideWidth[$countPlg]?>);
							$$('#<?php echo $id;?>,#<?php echo $id;?>.lof-slidecontent-plg,.lof-slidecontent-plg  ul.sliders-wrap-inner li').setStyle('height',<?php echo $slideHeight[$countPlg]?>);
					});
				})
			})(jQuery);
			</script>
			
				<?php
				$PathRoot = JPath::clean(JPATH_ROOT.DS.$path[$countPlg]);
				$listImage =JFolder::files($PathRoot,$filter = '.');
				$size = array();
				$tmpListImage = array();
				$count=0;
				for($n=0;$n<sizeof($listImage);$n++)
				{
					$tmp=$listImage[$n];
					$pattern = '/[^A-Za-z0-9._-\s()]/';
					$ext = end(explode('.', $tmp));
					if(strcmp($ext,"png") == 0||strcmp($ext,"jpeg") == 0||strcmp($ext,"jpg") == 0||strcmp($ext,"gif") == 0)
					{
						if(preg_match($pattern, $tmp));
						else {
							$size[$count] = getimagesize($PathRoot.'/'.$tmp);
							$tmpListImage[$count] = $tmp;
							$count++;
						}
					}
				}			
				$thumbWidth=70;
				$thumbHeight=$thumbWidth*$ratio[$countPlg];
				$cssTopPN=($thumbHeight-15)/2;
			    ?>
			
			
			<div id="<?php echo $id;?>" class="lof-slidecontent-plg">
				<div class="preload">
							<div></div>
				</div>
			    <!-- MAIN CONTENT --> 
			    <div class="main-slider-content">
			    	<ul class="sliders-wrap-inner">
			    		<?php			
							for($n = 0 ;$n < sizeof($tmpListImage)&&@n<10; $n++)
							{
									$tmp=$tmpListImage[$n];
									$w = $size[$n][0];
									$h = $size[$n][1];
									if($w>$slideWidth[$countPlg]||$h>$slideHeight[$countPlg])
									{
										if($w/$h<=$slideWidth[$countPlg]/$slideHeight[$countPlg])
										{
											$w = $slideHeight[$countPlg]*$w/$h;
											$h = $slideHeight[$countPlg];
										}
										if($w/$h>$slideWidth[$countPlg]/$slideHeight[$countPlg])
										{
											$h = $slideWidth[$countPlg]*$h/$w;
											$w = $slideWidth[$countPlg];
										}
									}
									$t = ($slideHeight[$countPlg]-$h)/2;
									$l = ($slideWidth[$countPlg]-$w)/2;				
									echo "<li><img src='".JURI::base()."$path[$countPlg]/$tmp' style='width:$w";echo "px;height:$h";echo "px;top:$t";echo "px;left:$l";echo "px;'/></li> ";
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
											for($n=0 ; $n < sizeof($tmpListImage)&&@n<10; $n++)
											{
													$tmp=$tmpListImage[$n];
													$w = $size[$n][0];
													$h = $size[$n][1];
													if($w>$thumbWidth||$h>$thumbHeight)
													{
														if($w/$h<=$thumbWidth/$thumbHeight)
														{
															$w = $thumbHeight*$w/$h;
															$h = $thumbHeight;
														}
														if($w/$h>$thumbWidth/$thumbHeight)
														{
															$h = $thumbWidth*$h/$w;
															$w = $thumbWidth;
														}
													}
													echo "<li><img src='".JURI::base()."$path[$countPlg]/$tmp' style='width:$w";echo "px;height:$h";echo "px;'/></li> ";
											}  		
							    		?>      		
			                        </ul>
			                  </div>
			                  <div  class="button-next" style="margin-top:<?php echo $cssTopPN?>px">Next</div>
			     </div> 
			          <!----------------- END OF NAVIGATOR --------------------->
			          <!-- BUTTON PLAY-STOP -->
			          <div class="button-control"><span></span></div>		          
			           <!-- END OF BUTTON PLAY-STOP --> 
			</div>
			<div class="avatarslide-copyright" style="width: <?php echo $slideWidth[$countPlg]?>px;">
				&copy; JoomAvatar.com
				<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Extension</a>-
				<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Template</a>
			</div>
			<?php
			$countPlg++;
			$content = ob_get_clean();
			$arrayFormat[$format] = $content;
		}
		foreach ($arrayFormat as $keyFormat => $valueFormat)
		{
			if (!empty($valueFormat)) {
				$text = str_replace($keyFormat, $valueFormat, $text);	
			} else {
				$text = str_replace($keyFormat, '', $text);
			}
		}
	}
}