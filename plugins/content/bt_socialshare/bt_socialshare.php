<?php
/**
 * @package 	bt_socialshare - BT Social Share Plugin
 * @version		1.0
 * @created		Oct 2011

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgContentBt_socialshare extends JPlugin
{
	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{
		if($context == 'com_content.article')
		{
			$view = JRequest::getString('view');

			$show_plugin_in= $this->params->get('show_plugin_in');
			$document	= &JFactory::getDocument();
			$show = false;
			if($show_plugin_in){
				foreach($show_plugin_in as $option){

					if(strtolower($view) == strtolower($option)|| $option=="all"){
						$show = true;
					}

				}
			}
			if(!$show){
				return;
			}


			// Exclude Category
			$excludingCategories = $this->params->get('excluding_categories', 0);
			if(!empty($excludingCategories))
			{
				if(strlen(array_search($row->catid, $excludingCategories)))
				{
					return;
				}
			}

			// Exclude Article
			$excludingArticles = $this->params->get('excluding_article', '');
			$excludingArticles = explode(",",$excludingArticles);
			if(!empty($excludingArticles))
			{
				if(strlen(array_search($row->id, $excludingArticles)))
				{
					return;
				}
			}

			//Run plugin
			if($this->params->get('css_plugin')==1)
			{
				$document->addStyleSheet(JURI::root().'/plugins/content/bt_socialshare/assets/bt_socialshare.css');
			}
			if (($this->params->get('facebook_like')==1)||($this->params->get('facebook_share_button')==1)||($this->params->get('facebook_comment')==1)) {
				$document->addScript("http://connect.facebook.net/en_US/all.js#xfbml=1");
			}
			
			require_once(JPATH_BASE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
			if($row->id)
			{
				$link_article = JRoute::_(ContentHelperRoute::getArticleRoute($row->id, $row->catid));
				$uri = & JURI::getInstance();
				$link_article = $uri->getScheme()."://".$uri->getHost().$link_article;
			}else
			{
				$uri =& JURI::getInstance();
				$link_article = $uri->toString();
			}

			$title = html_entity_decode($row->title,ENT_QUOTES, "UTF-8");


			$html = '<div style="clear:both;"></div>';
			
			if(trim($this->params->get('facebook_api_id')))
			{
				$fb_api = "&appId=".trim($this->params->get('facebook_api_id'));
			}
			else{
				$fb_api = "";
			}
			
			
			$html .='<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) {return;}
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1'.$fb_api.'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, \'script\', \'facebook-jssdk\'));</script>';
			
			$html .= '<div class="bt-social-share">';

			if($this->params->get('facebook_share_button')==1)
			{
				$html .= '<div class="bt-social-share-button bt-facebook-share-button">
		            <a  name="fb_share" type="'.$this->params->get('facebook_share_button_type').'"  share_url="' . $link_article . '">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
		            </div>
		            ';
			}

			if($this->params->get('facebook_like')==1)
			{
				$html .= '<div class="bt-social-share-button bt-facebook-like-button">';
				if($this->params->get('facebook_html5')==1){
					$html.= '<div class="fb-like" data-href="'.$link_article.'" data-send="'.($this->params->get('facebook_sendbutton')==1?"true":"false").'" data-layout="'.$this->params->get('facebook_like_type').'" data-width="'.$this->params->get('facebook_like_width').'" data-show-faces="'.($this->params->get('facebook_showface')==1?"true":"false").'" data-action="'.$this->params->get('facebook_like_action').'"></div>';
				}else{
					$html.= '<fb:like send="'.($this->params->get('facebook_sendbutton')==1?"true":"false").'" href="'.$link_article.'" layout="'.$this->params->get('facebook_like_type').'" width="'.$this->params->get('facebook_like_width').'" show_faces="'.($this->params->get('facebook_showface')==1?"true":"false").'" action="'.$this->params->get('facebook_like_action').'"></fb:like>';
				}
				$html .= '</div>';
			}
			$facebookcomment = "";
			if($this->params->get("facebook_comment")) {
				if($this->params->get('facebook_html5')==1){
					$facebookcomment.= '<br /><div class="fb-comments" data-colorscheme="'.$this->params->get("facebook_comment_color_schema","light").'" data-href="'.$link_article.'" data-num-posts="'.$this->params->get("facebook_comment_numberpost","2").'" data-width="'.$this->params->get("facebook_comment_width","500").'"></div>';
				}
				else{
					$facebookcomment.= '<br /><fb:comments colorscheme="'.$this->params->get("facebook_comment_color_schema","light").'" href="'.$link_article.'" num_posts="'.$this->params->get("facebook_comment_numberpost","2").'" width="'.$this->params->get("facebook_comment_width","500").'"></fb:comments>';
				}
			}
			if($this->params->get('twitter')==1)
			{
				$html .='<div class="bt-social-share-button bt-twitter-button">';
				$html .= '<a href="http://twitter.com/share" class="twitter-share-button" data-via="' . $this->params->get('twitter_name') . '" data-url="'.$link_article.'" data-count="'.$this->params->get('twitter_type').'" >Twitter</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
				$html .= '</div>';
			}

			if($this->params->get('linkedin')==1)
			{
				$html .='<div class="bt-social-share-button bt-linkedin-button">';
				$html .= '<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="IN/share" data-url="' . $link_article . '" data-counter="'.$this->params->get('linkedIn_type').'"></script>';
				$html .= '</div>';
			}
			if($this->params->get('google_plus')==1)
			{
				$html .='<div class="bt-social-share-button bt-googleplus-button">';


				$html .= '<g:plusone href="' . $link_article . '" annotation="' . $this->params->get("google_plus_annotation",1). '" size="' . $this->params->get("google_plus_type",1). '"></g:plusone>';
				$html .= '<script type="text/javascript">(function() {var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;po.src = \'https://apis.google.com/js/plusone.js\';var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);})();</script>';
				$html .= '</div>';
			}

			if($this->params->get("stumble")) {

				$html .= '
				<div class="bt-social-share-button bt-stumble-button">
				<script src="http://www.stumbleupon.com/hostedbadge.php?s=' . $this->params->get("stumble_type",1). '&r=' . rawurlencode($link_article) . '"></script>
				</div>
				';
			}

			if($this->params->get("digg")) {

				$html .= '<div class="bt-social-share-button bt-dig-button">
							<script type="text/javascript">
				(function() {
				var s = document.createElement(\'SCRIPT\'), s1 = document.getElementsByTagName(\'SCRIPT\')[0];
				s.type = \'text/javascript\';
				s.async = true;
				s.src = \'http://widgets.digg.com/buttons.js\';
				s1.parentNode.insertBefore(s, s1);
				})();
				</script>
				<a 
				class="DiggThisButton '.$this->params->get("digg_type","DiggCompact") . '"
				href="http://digg.com/submit?url=' . rawurlencode($link_article) . '&amp;title=' . rawurlencode($title) . '">
				</a>
							</div>
							';
			}
			$html .= '<div style="clear:both;"></div>';
			
			
			$html .= '</div>';


			$position 	 = $this->params->get('position', 'above');

			if($position == 'above')
			{
				if(isset($row->fulltext) == '')
				{
					if(isset($row->text)) $row->text = $html . $row->text;
					$row->introtext = $html . $row->introtext;
				}
				else
				{
					$row->text = $html . $row->text;
				}
			}
			else
			{	
				$row->text .= $html;
				$row->introtext .= $html;
			}
			$row->text .=$facebookcomment;
			$row->introtext .=$facebookcomment;
		}
		return;
	}
}
?>