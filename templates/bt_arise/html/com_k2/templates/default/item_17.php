<?php
/**
 * @version		$Id: item.php 836 2011-06-21 12:43:40Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php if(JRequest::getInt('print')==1): ?>
<!-- Print button at the top of the print page only -->
<a class="itemPrintThisPage" rel="nofollow" href="#" onclick="window.print();return false;">
	<span><?php echo JText::_('K2_PRINT_THIS_PAGE'); ?></span>
</a>
<?php endif; ?>

<!-- Start K2 Item Layout -->
<span id="startOfPageId<?php echo JRequest::getInt('id'); ?>"></span>

<div id="k2Container" class="itemView<?php echo ($this->item->featured) ? ' itemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">

	<!-- Plugins: BeforeDisplay -->
	<?php if(isset($this->item->event->BeforeDisplay)) echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php if(isset($this->item->event->K2BeforeDisplay)) echo $this->item->event->K2BeforeDisplay; ?>

	<?php if(isset($this->item->editLink)): ?>
	<!-- Item edit link -->
	<span class="itemEditLink">
		<a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->item->editLink; ?>">
			<?php echo JText::_('K2_EDIT_ITEM'); ?>
		</a>
	</span>
	<?php endif; ?>

	<div class="itemHeader">

		<?php if($this->item->params->get('itemDateCreated')): ?>
		<!-- Date created -->
		<div class="article-date">
			<span class="itemDateCreated">
				<?php echo JHTML::_('date', $this->item->created , JText::_('m/d Y')); ?>
			</span>
		</div>
		<?php endif; ?>

	  <?php if($this->item->params->get('itemTitle')): ?>
	  <!-- Item title -->
	  <h2 class="itemTitle">
		<span>
	  	<?php echo $this->item->title; ?>

	  	<?php if($this->item->params->get('itemFeaturedNotice') && $this->item->featured): ?>
	  	<!-- Featured flag -->
		<sup>
		  		<?php echo JText::_('K2_FEATURED'); ?>
		</sup>
	  	<?php endif; ?>
		</span>
	  </h2>
	  <?php endif; ?>
		
	  <?php if($this->item->params->get('itemRating') || $this->item->params->get('itemAuthor') || $this->item->params->get('itemCategory')):?>
		<div class="itemDetail">
		<?php if($this->item->params->get('itemRating')): ?>
		<!-- Item Rating -->
		<div class="itemRatingBlock">
			<span><?php echo JText::_('Vote it');//JText::_('K2_RATE_THIS_ITEM'); ?></span>
			<div class="itemRatingForm">
				<ul class="itemRatingList">
					<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
					<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
					<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
					<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
					<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
					<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
				</ul>
				<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('itemAuthor')): ?>
		<!-- Item Author -->
		<span class="itemAuthor">
			<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?>&nbsp;
			<?php if(empty($this->item->created_by_alias)): ?>
			<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
			<?php else: ?>
			<?php echo $this->item->author->name; ?>
			<?php endif; ?>
		</span>
		<?php endif; ?>
		
		<?php if($this->item->params->get('itemCategory')): ?>
		<!-- Item category name -->
		<span class="itemCategory">
			<?php echo JText::_('K2_PUBLISHED_IN'); ?>
			<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
		</span>
		<?php endif; ?>
		<div class="clr"></div>
		</div>
		<?php endif; ?>

  </div>

  <!-- Plugins: AfterDisplayTitle -->
  <?php if(isset($this->item->event->AfterDisplayTitle)) echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php if(isset($this->item->event->K2AfterDisplayTitle)) echo $this->item->event->K2AfterDisplayTitle; ?>

	<!-- Toolbar -->

	

  <div class="itemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php if(isset($this->item->event->BeforeDisplayContent)) echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php if(isset($this->item->event->K2BeforeDisplayContent)) echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('itemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="itemImageBlock">
		  <span class="itemImage">
		  	<a class="modal" rel="{handler: 'image'}" href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
		  		<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo $this->item->image_caption; else echo $this->item->title; ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" />
		  	</a>
		  </span>

		  <?php if($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)): ?>
		  <!-- Image caption -->
		  <span class="itemImageCaption"><?php echo $this->item->image_caption; ?></span>
		  <?php endif; ?>

		  <?php if($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)): ?>
		  <!-- Image credits -->
		  <span class="itemImageCredits"><?php echo $this->item->image_credits; ?></span>
		  <?php endif; ?>

		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if(!empty($this->item->fulltext)): ?>

	  <?php if($this->item->params->get('itemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="itemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('itemFullText')): ?>
	  <!-- Item fulltext -->
	  <div class="itemFullText">
	  	<?php echo $this->item->fulltext; ?>
	  </div>
	  <?php endif; ?>

	  <?php else: ?>

	  <!-- Item text -->
	  <div class="itemFullText">
	  	<?php echo $this->item->introtext; ?>
	  </div>

	  <?php endif; ?>

		<div class="clr"></div>

	  <?php if($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)): ?>
	  <!-- Item extra fields -->
	  <div class="itemExtraFields">
	  	<h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
	  	<ul>
			<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
			<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
				<span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
				<span class="itemExtraFieldsValue"><?php echo ($extraField->type=='date')?JHTML::_('date', $extraField->value, JText::_('K2_DATE_FORMAT_LC')):$extraField->value; ?></span>
			</li>
			<?php endforeach; ?>
			</ul>
	    <div class="clr"></div>
	  </div>
	  <?php endif; ?>

		<?php if($this->item->params->get('itemDateModified') && intval($this->item->modified)!=0): ?>
		<!-- Item date modified -->
		<?php if($this->item->created != $this->item->modified): ?>
		<span class="itemDateModified">
			<?php echo JText::_('K2_LAST_MODIFIED_ON'); ?> <?php echo JHTML::_('date', $this->item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?>
		</span>
		<?php endif; ?>
		<?php endif; ?>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php if(isset($this->item->event->AfterDisplayContent)) echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php if(isset($this->item->event->K2AfterDisplayContent)) echo $this->item->event->K2AfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

  <?php if(
  $this->item->params->get('itemHits') ||
  $this->item->params->get('itemTwitterLink') ||
  $this->item->params->get('itemTags') ||
  $this->item->params->get('itemShareLinks') ||
  $this->item->params->get('itemAttachments')
  ): ?>
  <div class="itemLinks">

		<?php if($this->item->params->get('itemHits') || $this->item->params->get('itemTwitterLink')): ?>
		<div class="itemHitsTwitter">
			<?php if($this->item->params->get('itemHits')): ?>
			<!-- Item Hits -->
			<span class="itemHits">
				<?php echo JText::_('K2_READ'); ?> <b><?php echo $this->item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
			</span>
			<?php endif; ?>

			<?php if($this->item->params->get('itemHits') && $this->item->params->get('itemTwitterLink') && $this->item->params->get('twitterUsername')): ?>
			<span class="itemHitsTwitterSep">|</span>
			<?php endif; ?>

			<?php if($this->item->params->get('itemTwitterLink') && $this->item->params->get('twitterUsername')): ?>
			<!-- Twitter Link -->
			<span class="itemTwitterLink">
				<a class="classicPopup" rel="{x:500,y:250}" title="<?php echo JText::_('K2_LIKE_THIS_TWEET_IT_TO_YOUR_FOLLOWERS'); ?>" href="<?php echo $this->item->twitterURL; ?>" target="_blank">
					<?php echo JText::_('K2_LIKE_THIS_TWEET_IT_TO_YOUR_FOLLOWERS'); ?>
				</a>
			</span>
			<?php endif; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>

		

	  <?php if($this->item->params->get('itemTags') && count($this->item->tags)): ?>
	  <!-- Item tags -->
	  <div class="itemTagsBlock">
		  <span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
		  <ul class="itemTags">
		    <?php foreach ($this->item->tags as $tag): ?>
		    <li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
		    <?php endforeach; ?>
		  </ul>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('itemShareLinks')): ?>
	  <!-- Item social links -->
		<div class="itemSocialLinksBlock">
			<span><?php echo JText::_('K2_SOCIAL_SHARING'); ?></span>
			<ul class="itemSocialLinks">
				<li><a class="googlebuzz" title="<?php echo JText::_('K2_ADD_TO_GOOGLE_BUZZ'); ?>" href="http://www.google.com/buzz/post?url=<?php echo $this->item->socialLink; ?>&amp;message=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_GOOGLE_BUZZ'); ?></span></a></li>
				<li><a class="facebook" title="<?php echo JText::_('K2_ADD_TO_FACEBOOK'); ?>" href="http://www.facebook.com/sharer.php?u=<?php echo $this->item->socialLink; ?>&amp;t=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_FACEBOOK'); ?></span></a></li>
				<li><a class="delicious" title="<?php echo JText::_('K2_ADD_TO_DELICIOUS'); ?>" href="http://del.icio.us/post?url=<?php echo $this->item->socialLink; ?>&amp;title=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_DELICIOUS'); ?></span></a></li>
				<li><a class="digg" title="<?php echo JText::_('K2_DIGG_THIS'); ?>" href="http://digg.com/submit?url=<?php echo $this->item->socialLink; ?>&amp;title=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_DIGG_THIS'); ?></span></a></li>
				<li><a class="reddit" title="<?php echo JText::_('K2_ADD_TO_REDDIT'); ?>" href="http://reddit.com/submit?url=<?php echo $this->item->socialLink; ?>&amp;title=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_REDDIT'); ?></span></a></li>
				<li><a class="stumble" title="<?php echo JText::_('K2_ADD_TO_STUMBLEUPON'); ?>" href="http://www.stumbleupon.com/submit?url=<?php echo $this->item->socialLink; ?>&amp;title=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_STUMBLEUPON'); ?></span></a></li>
				<li><a class="myspace" title="<?php echo JText::_('K2_ADD_TO_MYSPACE'); ?>" href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u=<?php echo $this->item->socialLink; ?>&amp;t=<?php echo urlencode($this->item->title); ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_MYSPACE'); ?></span></a></li>
				<li><a class="technorati" title="<?php echo JText::_('K2_ADD_TO_TECHNORATI'); ?>" href="http://www.technorati.com/faves?add=<?php echo $this->item->socialLink; ?>" target="_blank"><span><?php echo JText::_('K2_ADD_TO_TECHNORATI'); ?></span></a></li>
				<li class="clr"></li>
			</ul>
			<div class="clr"></div>
		</div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('itemAttachments') && count($this->item->attachments)): ?>
	  <!-- Item attachments -->
	  <div class="itemAttachmentsBlock">
		  <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
		  <ul class="itemAttachments">
		    <?php foreach ($this->item->attachments as $attachment): ?>
		    <li>
			    <a title="<?php echo htmlentities($attachment->titleAttribute, ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo JRoute::_('index.php?option=com_k2&view=item&task=download&id='.$attachment->id); ?>">
			    	<?php echo $attachment->title ; ?>
			    </a>
			    <?php if($this->item->params->get('itemAttachmentsCounter')): ?>
			    <span>(<?php echo $attachment->hits; ?> <?php echo (count($attachment->hits)==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
			    <?php endif; ?>
		    </li>
		    <?php endforeach; ?>
		  </ul>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias)): ?>
  <!-- Author Block -->
  <div class="itemAuthorBlock">

  	<?php if($this->item->params->get('itemAuthorImage') && !empty($this->item->author->avatar)): ?>
  	<img class="itemAuthorAvatar" src="<?php echo $this->item->author->avatar; ?>" alt="<?php echo $this->item->author->name; ?>" />
  	<?php endif; ?>

    <div class="itemAuthorDetails">
      <h3 class="itemAuthorName">
      	<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
      </h3>

      <?php if($this->item->params->get('itemAuthorDescription') && !empty($this->item->author->profile->description)): ?>
      <p><?php echo $this->item->author->profile->description; ?></p>
      <?php endif; ?>

      <?php if($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)): ?>
      <span class="itemAuthorUrl"><?php echo JText::_('K2_WEBSITE'); ?> <a rel="me" href="<?php echo $this->item->author->profile->url; ?>" target="_blank"><?php echo str_replace('http://','',$this->item->author->profile->url); ?></a></span>
      <?php endif; ?>

      <?php if($this->item->params->get('itemAuthorEmail')): ?>
      <span class="itemAuthorEmail"><?php echo JText::_('K2_EMAIL'); ?> <?php echo JHTML::_('Email.cloak', $this->item->author->email); ?></span>
      <?php endif; ?>

			<div class="clr"></div>

			<!-- K2 Plugins: K2UserDisplay -->
			<?php if(isset($this->item->event->K2UserDisplay)) echo $this->item->event->K2UserDisplay; ?>

    </div>
    <div class="clr"></div>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)): ?>
  <!-- Latest items from author -->
	<div class="itemAuthorLatest">
		<h3><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo $this->item->author->name; ?></h3>
		<ul>
			<?php foreach($this->authorLatestItems as $key=>$item): ?>
			<li class="<?php echo ($key%2) ? "odd" : "even"; ?>">
				<a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

  <?php if($this->item->params->get('itemRelated') && isset($this->relatedItems)): ?>
  <!-- Related items by tag -->
	<div class="itemRelated">
		<h3><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h3>
		<ul>
			<?php foreach($this->relatedItems as $key=>$item): ?>
			<li class="<?php echo ($key%2) ? "odd" : "even"; ?>">
				<a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<div class="clr"></div>

  <?php if($this->item->params->get('itemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <a name="itemVideoAnchor" id="itemVideoAnchor"></a>

  <div class="itemVideoBlock">
  	<h3><?php echo JText::_('K2_RELATED_VIDEO'); ?></h3>

		<?php if($this->item->videoType=='embedded'): ?>
		<div class="itemVideoEmbedded">
			<?php echo $this->item->video; ?>
		</div>
		<?php else: ?>
		<span class="itemVideo"><?php echo $this->item->video; ?></span>
		<?php endif; ?>

	  <?php if($this->item->params->get('itemVideoCaption') && !empty($this->item->video_caption)): ?>
	  <span class="itemVideoCaption"><?php echo $this->item->video_caption; ?></span>
	  <?php endif; ?>

	  <?php if($this->item->params->get('itemVideoCredits') && !empty($this->item->video_credits)): ?>
	  <span class="itemVideoCredits"><?php echo $this->item->video_credits; ?></span>
	  <?php endif; ?>

	  <div class="clr"></div>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)): ?>
  <!-- Item image gallery -->
  <a name="itemImageGalleryAnchor" id="itemImageGalleryAnchor"></a>
  <div class="itemImageGallery">
	  <h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
	  <?php echo $this->item->gallery; ?>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('itemNavigation') && !JRequest::getCmd('print') && (isset($this->item->nextLink) || isset($this->item->previousLink))): ?>
  <!-- Item navigation -->
  <div class="itemNavigation">
  	<span class="itemNavigationTitle"><?php echo JText::_('K2_MORE_IN_THIS_CATEGORY'); ?></span>

		<?php if(isset($this->item->previousLink)): ?>
		<a class="itemPrevious" href="<?php echo $this->item->previousLink; ?>">
			&laquo; <?php echo $this->item->previousTitle; ?>
		</a>
		<?php endif; ?>

		<?php if(isset($this->item->nextLink)): ?>
		<a class="itemNext" href="<?php echo $this->item->nextLink; ?>">
			<?php echo $this->item->nextTitle; ?> &raquo;
		</a>
		<?php endif; ?>

  </div>
  <?php endif; ?>

  <!-- Plugins: AfterDisplay -->
  <?php if(isset($this->item->event->AfterDisplay)) echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php if(isset($this->item->event->K2AfterDisplay)) echo $this->item->event->K2AfterDisplay; ?>

  <?php if($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
  <!-- K2 Plugins: K2CommentsBlock -->
  <?php echo $this->item->event->K2CommentsBlock; ?>
  <?php endif;?>

 <?php if($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)): ?>
  <!-- Item comments -->
  <a name="itemCommentsAnchor" id="itemCommentsAnchor"></a>

  <div class="itemComments">

	  <?php if($this->item->params->get('commentsFormPosition')=='above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
	  <!-- Item comments form -->
	  <div class="itemCommentsForm">
	  	<?php echo $this->loadTemplate('comments_form'); ?>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->numOfComments>0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))): ?>
	  <!-- Item user comments -->
	  <h3 class="itemCommentsCounter">
	  	<span><?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?></span> 
	  </h3>

	  <ul class="itemCommentsList">
	    <?php foreach ($this->item->comments as $key=>$comment): ?>
	    <li class="<?php echo ($key%2) ? "odd" : "even"; echo (!$this->item->created_by_alias && $comment->userID==$this->item->created_by) ? " authorResponse" : ""; echo($comment->published) ? '':' unpublishedComment'; ?>">
			<div class="itemComment">
			<div class="itemCommentLeft">
			<span class="commentAuthorName">
			    <?php //echo JText::_('K2_POSTED_BY'); ?>
			    <?php if(!empty($comment->userLink)): ?>
			    <a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
			    	<?php echo $comment->userName; ?>
			    </a>
			    <?php else: ?>
			    <?php echo $comment->userName; ?>
			    <?php endif; ?>
		    </span>
			
			<?php if($comment->userImage): ?>
			<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $this->item->params->get('commenterImgWidth'); ?>" />
			<?php endif; ?>
			</div>

			<div class="itemCommentRight">
			<span class="commentLink">
		    	<a href="<?php echo $this->item->link; ?>#comment<?php echo $comment->id; ?>" name="comment<?php echo $comment->id; ?>" id="comment<?php echo $comment->id; ?>">
		    		<?php echo JText::_('K2_COMMENT_LINK'); ?>
		    	</a>
		    </span>
			<span class="commentDate">
			<?php echo JText::_('Posted on'); ?>
			<?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?>
		    </span>

		    <p><?php echo $comment->commentText; ?></p>
				
				<?php if($this->inlineCommentsModeration || ($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest)))): ?>
				<span class="commentToolbar">
					<?php if($this->inlineCommentsModeration): ?>
					<?php if(!$comment->published): ?>
					<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_APPROVE')?></a>
					<?php endif;?>
					
					<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_REMOVE')?></a>
					<?php endif;?>
					
					<?php if($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest))): ?>
					<a class="modal" rel="{handler:'iframe',size:{x:640,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id)?>"><?php echo JText::_('K2_REPORT')?></a>
					<?php endif;?>
				</span>
				<?php endif;?>
			</div>
				<div class="clr"></div>
			</div>
	    </li>
	    <?php endforeach; ?>
	  </ul>

	  <div class="itemCommentsPagination">
	  	<?php echo $this->pagination->getPagesLinks(); ?>
	  	<div class="clr"></div>
	  </div>
		<?php endif; ?>

		<?php if($this->item->params->get('commentsFormPosition')=='below' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
	  <!-- Item comments form -->
	  <div class="itemCommentsForm">
	  	<?php echo $this->loadTemplate('comments_form'); ?>
	  </div>
	  <?php endif; ?>

	  <?php $user = &JFactory::getUser(); if ($this->item->params->get('comments') == '2' && $user->guest): ?>
	  		<div><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS');?></div>
	  <?php endif; ?>

  </div>
  <?php endif; ?>

	<?php if(!JRequest::getCmd('print')): ?>
	<!--<div class="itemBackToTop">
		<a class="k2Anchor" href="<?php echo $this->item->link; ?>#startOfPageId<?php echo JRequest::getInt('id'); ?>">
			<?php echo JText::_('K2_BACK_TO_TOP'); ?>
		</a>
	</div>-->
	<?php endif; ?>

	<div class="clr"></div>
</div>
<!-- End K2 Item Layout -->
