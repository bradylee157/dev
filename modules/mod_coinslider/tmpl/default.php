<?php
/**
* Module mod_coinslider For Joomla 1.5.x
* Version		: 1.4.3
* Created by	: Daniel Pardons
* Email			: daniel.pardons@joompad.be
* Created on	: 17 April 2010
* Last Modified : 03 May 2011
* URL			: www.joompad.be
* License GPLv2.0 - http://www.gnu.org/licenses/gpl-2.0.html
* Based on jquery(http://www.jquery.com) and on Ivan Lazarevic "Coin Slider: Jquery Image slider with Unique Effects" script (http://workshop.rs/projects/coin-slider) 
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$baseurl 		= JURI::base();

$module_id		= $params->get( 'module_id' );

$gallery_width	= $params->get( 'gallery_width' );
$gallery_height	= $params->get( 'gallery_height' );
$gallery_position = $params->get( 'gallery_position' );
$gallery_navigation	= $params->get( 'gallery_navigation' ) ? "true" : "false";
$gallery_use_links	= $params->get( 'gallery_use_links' ) ? "true" : "false";

$gallery_effect	= $params->get( 'gallery_effect' );
$slides_delay	= $params->get( 'slides_delay' );
$teaser_bgcolor = $params->get( 'teaser_bgcolor' );
$teaser_color	= $params->get( 'teaser_color' );

$gallery_wrapper_css = $params->get( 'gallery_wrapper_css' );
$gallery_css	= $params->get( 'gallery_css' );
$title_css		= $params->get( 'title_css' );
$teaser_css		= $params->get( 'teaser_css' );

$navigation_css	= $params->get( 'navigation_css' );
$navigation_a_css = $params->get( 'navigation_a_css' );
$navigation_a_active_css = $params->get( 'navigation_a_active_css' );

$folder			= $params->get( 'folder' );

$image_status1 	= $params->get( 'image_status1' );
$image_img1 	= $folder.$params->get( 'image_img1' );
$image_alt1 	= $params->get( 'image_alt1' );
$image_title1 	= $params->get( 'image_title1' );
$image_teaser1 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser1' )) : $params->get( 'image_teaser1' );
$image_url1 	= str_replace('&', '&amp;', $params->get( 'image_url1' ));
$target_url1 	= $params->get( 'target_url1' );

$image_status2 	= $params->get( 'image_status2' );
$image_img2		= $folder.$params->get( 'image_img2' );
$image_alt2 	= $params->get( 'image_alt2' );
$image_title2 	= $params->get( 'image_title2' );
$image_teaser2 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser2' )) : $params->get( 'image_teaser2' );
$image_url2 	= str_replace('&', '&amp;', $params->get( 'image_url2' ));
$target_url2 	= $params->get( 'target_url2' );

$image_status3 	= $params->get( 'image_status3' );
$image_img3		= $folder.$params->get( 'image_img3' );
$image_alt3 	= $params->get( 'image_alt3' );
$image_title3 	= $params->get( 'image_title3' );
$image_teaser3 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser3' )) : $params->get( 'image_teaser3' );
$image_url3 	= str_replace('&', '&amp;', $params->get( 'image_url3' ));
$target_url3 	= $params->get( 'target_url3' );

$image_status4 	= $params->get( 'image_status4' );
$image_img4		= $folder.$params->get( 'image_img4' );
$image_alt4 	= $params->get( 'image_alt4' );
$image_title4 	= $params->get( 'image_title4' );
$image_teaser4 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser4' )) : $params->get( 'image_teaser4' );
$image_url4 	= str_replace('&', '&amp;', $params->get( 'image_url4' ));
$target_url4 	= $params->get( 'target_url4' );

$image_status5 	= $params->get( 'image_status5' );
$image_img5		= $folder.$params->get( 'image_img5' );
$image_alt5 	= $params->get( 'image_alt5' );
$image_title5 	= $params->get( 'image_title5' );
$image_teaser5 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser5' )) : $params->get( 'image_teaser5' );
$image_url5 	= str_replace('&', '&amp;', $params->get( 'image_url5' ));
$target_url5 	= $params->get( 'target_url5' );

$image_status6 	= $params->get( 'image_status6' );
$image_img6		= $folder.$params->get( 'image_img6' );
$image_alt6 	= $params->get( 'image_alt6' );
$image_title6 	= $params->get( 'image_title6' );
$image_teaser6 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser6' )) : $params->get( 'image_teaser6' );
$image_url6 	= str_replace('&', '&amp;', $params->get( 'image_url6' ));
$target_url6 	= $params->get( 'target_url6' );

$image_status7 	= $params->get( 'image_status7' );
$image_img7		= $folder.$params->get( 'image_img7' );
$image_alt7 	= $params->get( 'image_alt7' );
$image_title7 	= $params->get( 'image_title7' );
$image_teaser7 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser7' )) : $params->get( 'image_teaser7' );;
$image_url7 	= str_replace('&', '&amp;', $params->get( 'image_url7' ));
$target_url7 	= $params->get( 'target_url7' );

$image_status8 	= $params->get( 'image_status8' );
$image_img8		= $folder.$params->get( 'image_img8' );
$image_alt8 	= $params->get( 'image_alt8' );
$image_title8 	= $params->get( 'image_title8' );
$image_teaser8 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser8' )) : $params->get( 'image_teaser8' );
$image_url8 	= str_replace('&', '&amp;', $params->get( 'image_url8' ));
$target_url8 	= $params->get( 'target_url8' );

$image_status9 	= $params->get( 'image_status9' );
$image_img9		= $folder.$params->get( 'image_img9' );
$image_alt9 	= $params->get( 'image_alt9' );
$image_title9 	= $params->get( 'image_title9' );
$image_teaser9 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser9' )) : $params->get( 'image_teaser9' );
$image_url9 	= str_replace('&', '&amp;', $params->get( 'image_url9' ));
$target_url9 	= $params->get( 'target_url9' );

$image_status10 = $params->get( 'image_status10' );
$image_img10	= $folder.$params->get( 'image_img10' );
$image_alt10 	= $params->get( 'image_alt10' );
$image_title10 	= $params->get( 'image_title10' );
$image_teaser10 = ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser10' )) : $params->get( 'image_teaser10' );
$image_url10 	= str_replace('&', '&amp;', $params->get( 'image_url10' ));
$target_url10 	= $params->get( 'target_url10' );

$image_status11 = $params->get( 'image_status11' );
$image_img11	= $folder.$params->get( 'image_img11' );
$image_alt11 	= $params->get( 'image_alt11' );
$image_title11 	= $params->get( 'image_title11' );
$image_teaser11 = ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser11' )) : $params->get( 'image_teaser11' );
$image_url11 	= str_replace('&', '&amp;', $params->get( 'image_url11' ));
$target_url11 	= $params->get( 'target_url11' );

$image_status12 = $params->get( 'image_status12' );
$image_img12	= $folder.$params->get( 'image_img12' );
$image_alt12 	= $params->get( 'image_alt12' );
$image_title12 	= $params->get( 'image_title12' );
$image_teaser12 = ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser12' )) : $params->get( 'image_teaser12' );
$image_url12 	= str_replace('&', '&amp;', $params->get( 'image_url12' ));
$target_url12 	= $params->get( 'target_url12' );

$document =& JFactory::getDocument();
if ($params->get('load_JQuery')==1)  {
	$document->addScript(JURI::base() . 'modules/mod_coinslider/js/jquery-1.4.2.min.js');
}
$document->addCustomTag('<script type="text/javascript"> jQuery.noConflict(); </script>');


$document->addScript(JURI::base() . 'modules/mod_coinslider/js/coin-slider.js');

$cscss="\n".'<style type="text/css">'."\n";
if ($gallery_position == 1) {
	$cscss .= '#coin-slider-wrapper {
		margin-left: auto;
		margin-right: auto;
		width: '.$gallery_width.'px;
	}';
}
if ($gallery_wrapper_css) {
	$cscss .= '#coin-slider-wrapper {'.$gallery_wrapper_css.'}';
}

$imagesdirectory = JURI::base(true).'/modules/mod_coinslider/images/';
$cscss .= '
.coin-slider { overflow: hidden; zoom: 1; position: relative; width:'.$gallery_width.'px;}
.coin-slider {'.$gallery_css.'}
.coin-slider a {text-decoration: none; outline: none; border: none; }
.cs-title { background-color: '.$teaser_bgcolor.'; color: '.$teaser_color.'; }
.cs-title {'.$teaser_css.'}
.cs-active { background-color: #B8C4CF; color: #FFFFFF; }
.cs-prev, .cs-next { background-color: #000000; color: #FFFFFF; padding: 0px 10px; }
.cs-prev {background:url('.$imagesdirectory.'prev.png) no-repeat 0 0 transparent !important; width:35px; height:35px; text-indent:-9999px; display:block; padding:0 !important; opacity:1 !important; filter:alpha(opacity=100) !important; left:20px !important; }
.cs-prev:hover {background-position:0 -35px !important;}
.cs-next {background:url('.$imagesdirectory.'next.png) no-repeat 0 0 transparent !important; width:35px; height:35px; text-indent:-9999px; display:block; padding:0 !important;  opacity:1 !important; filter:alpha(opacity=100) !important; right:20px !important; }
.cs-next:hover {background-position:0 -35px !important;}
.cs-buttons {'.$navigation_css.'}
.cs-buttons a {'.$navigation_a_css.'}
.cs-buttons a.cs-active {'.$navigation_a_active_css.'}';
$cscss .= "\n".'</style>';
$mainframe->addCustomHeadTag($cscss);

?>
<!-- coin-slider by Ivan Lazarevic (http://workshop.rs/projects/coin-slider)-->
<div id='coin-slider-wrapper'>
	<div id='coin-slider'>
	  <?php if ($image_status1==1) { ?>
			<!--galleryEntry 1-->
				<a href="<?php echo $image_url1 ?>" target="<?php echo $target_url1; ?>">
				  <img src="<?php echo $baseurl.$image_img1; ?>" alt="<?php echo $image_alt1; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title1; ?></span><br/><?php echo $image_teaser1; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status2==1) { ?>
			<!--galleryEntry 2-->
				<a href="<?php echo $image_url2; ?>" target="<?php echo $target_url2; ?>">
				  <img src="<?php echo $baseurl.$image_img2; ?>" alt="<?php echo $image_alt2; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title2; ?></span><br/><?php echo $image_teaser2; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status3==1) { ?>
			<!--galleryEntry 3-->
				<a href="<?php echo $image_url3; ?>" target="<?php echo $target_url3; ?>">
				  <img src="<?php echo $baseurl.$image_img3; ?>" alt="<?php echo $image_alt3; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title3; ?></span><br/><?php echo $image_teaser3; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status4==1) { ?>
			<!--galleryEntry 4-->
				<a href="<?php echo $image_url4; ?>" target="<?php echo $target_url4; ?>">
				  <img src="<?php echo $baseurl.$image_img4; ?>" alt="<?php echo $image_alt4; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title4; ?></span><br/><?php echo $image_teaser4; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status5==1) { ?>
			<!--galleryEntry 5-->
				<a href="<?php echo $image_url5; ?>" target="<?php echo $target_url5; ?>">
				  <img src="<?php echo $baseurl.$image_img5; ?>" alt="<?php echo $image_alt5; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title5; ?></span><br/><?php echo $image_teaser5; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status6==1) { ?>
			<!--galleryEntry 6-->
				<a href="<?php echo $image_url6; ?>" target="<?php echo $target_url6; ?>">
				  <img src="<?php echo $baseurl.$image_img6; ?>" alt="<?php echo $image_alt6; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title6; ?></span><br/><?php echo $image_teaser6; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status7==1) { ?>
			<!--galleryEntry 7-->
				<a href="<?php echo $image_url7; ?>" target="<?php echo $target_url7; ?>">
				  <img src="<?php echo $baseurl.$image_img7; ?>" alt="<?php echo $image_alt7; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title7; ?></span><br/><?php echo $image_teaser7; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status8==1) { ?>
			<!--galleryEntry 8-->
				<a href="<?php echo $image_url8; ?>" target="<?php echo $target_url8; ?>">
				  <img src="<?php echo $baseurl.$image_img8; ?>" alt="<?php echo $image_alt8; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title8; ?></span><br/><?php echo $image_teaser8; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status9==1) { ?>
			<!--galleryEntry 9-->
				<a href="<?php echo $image_url9; ?>" target="<?php echo $target_url9; ?>">
				  <img src="<?php echo $baseurl.$image_img9; ?>" alt="<?php echo $image_alt9; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title9; ?></span><br/><?php echo $image_teaser9; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status10==1) { ?>
			<!--galleryEntry 10-->
				<a href="<?php echo $image_url10; ?>" target="<?php echo $target_url10; ?>">
				  <img src="<?php echo $baseurl.$image_img10; ?>" alt="<?php echo $image_alt10; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title10; ?></span><br/><?php echo $image_teaser10; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status11==1) { ?>
			<!--galleryEntry 11-->
				<a href="<?php echo $image_url11; ?>" target="<?php echo $target_url11; ?>">
				  <img src="<?php echo $baseurl.$image_img11; ?>" alt="<?php echo $image_alt11; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title11; ?></span><br/><?php echo $image_teaser11; ?></span>
				</a>
	  <?php } ?>

	  <?php if ($image_status12==1) { ?>
			<!--galleryEntry 12-->
				<a href="<?php echo $image_url12; ?>" target="<?php echo $target_url12; ?>">
				  <img src="<?php echo $baseurl.$image_img12; ?>" alt="<?php echo $image_alt12; ?>" />
				  <span><span style="<?php echo $title_css; ?>"><?php echo $image_title12; ?></span><br/><?php echo $image_teaser12; ?></span>
				</a>
	  <?php } ?>

	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	$('#coin-slider').coinslider({ width: <?php echo $gallery_width ?>, height: <?php echo $gallery_height ?>, navigation: <?php echo $gallery_navigation ?>, effect: '<?php echo $gallery_effect ?>' , links: <?php echo $gallery_use_links ?>, delay: <?php echo $slides_delay ?> });
});
</script>
<?php

/*
width: 565, // width of slider panel
height: 290, // height of slider panel
spw: 7, // squares per width
sph: 5, // squares per height
delay: 3000, // delay between images in ms
sDelay: 30, // delay beetwen squares in ms
opacity: 0.7, // opacity of title and navigation
titleSpeed: 500, // speed of title appereance in ms
effect: '', // random, swirl, rain, straight
navigation: true, // prev next and buttons
links : true, // show images as links
hoverPause: true // pause on hover
*/