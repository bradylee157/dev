<?php
/**
 * @package 	mod_bt_contentslider - BT ContentSlider Module
 * @version		1.1
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
defined('_JEXEC') or die('Restricted access');

?>

<?php if(count($list)>0) :?>
<div style="width:<?php echo $moduleWidthWrapper;?>">
<div class="btcontentslider_tl"></div>
<div class="btcontentslider_tr"></div>
<div class="btcontentslider_tm"></div>
	<div id="btcontentslider<?php echo $module->id; ?>" style="display:none" class="bt-cs<?php echo $moduleclass_sfx? ' bt-cs'.$params->get('moduleclass_sfx'):'';?>">
		<?php if( $next_back && $totalPages  > 1  ) : ?>
		<a class="next" href="#">Next</a> <a class="prev" href="#">Prev</a>
		<?php endif; ?>
		<?php 

			if( trim($params->get('content_title')) ){
		?>
		<h3>
			<span><?php echo $params->get('content_title') ?> </span>
		</h3>
		<?php } ?>
		<div class="slides_container" style="width:<?php echo $moduleWidth;?>">
			
			<?php foreach( $pages as $key => $list ): ?>
			
				<div class="slide" style="width:<?php echo $moduleWidth;?>">				
					
					<?php foreach( $list as $i => $row ): ?>
					
					<div class="bt-row <?php if($i==0) echo 'bt-row-first'; else if($i==count($list)-1) echo 'bt-row-last' ?>" style="width:<?php echo $itemWidth;?>%" >
					   
						<div class="bt-inner">
							 <?php if( $show_category_name ): ?>
									<?php if($show_category_name_as_link) : ?>
									 <a class="bt-category" target="<?php echo $openTarget; ?>" title="<?php echo $row->category_title; ?>" href="<?php echo $row->categoryLink;?>">
									   <?php echo $row->category_title; ?>
									 </a>
									<?php else :?>
									<span class="bt-category">
									   <?php echo $row->category_title; ?>
									</span>
									 <?php endif; ?>
							 <?php endif; ?>
							<?php if( $show_intro ): ?>	
							<?php if( $showTitle ): ?>
							 <a class="bt-title" target="<?php echo $openTarget; ?>" title="<?php echo $row->title; ?>" href="<?php echo $row->link;?>">
							   <?php echo $row->title_cut; ?>
							 </a>
							 <?php endif; ?>
							
							<?php if( $showAuthor || $showDate ): ?>
							<div class="bt-extra">
							<?php if( $showAuthor ): ?>
							   <span class="bt-author"><?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' ,
				 JHtml::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$row->created_by),$row->author)); ?></span>						  
							<?php endif; ?> 
							<?php if( $showDate ): ?>
							   <span class="bt-date"><?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', $row->date); ?></span>						  
							<?php endif; ?>
							</div>
							<?php endif; ?>
							
												
							<div class="bt-introtext">
								 <?php if( $row->thumbnail ): ?>
								<a target="<?php echo $openTarget; ?>" class="bt-image-link" title="<?php echo $row->title;?>" href="<?php echo $row->link;?>">
								  <img <?php echo $imgClass ?>  src="<?php echo $row->thumbnail; ?>" alt="<?php echo $row->title?>"  style=" height:<?php echo $thumbHeight ;?>px; width:<?php echo $thumbWidth ;?>px; float:<?php echo $align_image;?>;margin-<?php echo $align_image=="left"? "right":"left";?>:5px" title="<?php echo $row->title?>" />
								</a> 
								<?php endif ; ?>
							  <?php echo $row->description; ?>
							</div>
							<?php else: ?>
							
																		
								<div class="bt-introtext">
									 <?php if( $row->thumbnail ): ?>
									<a target="<?php echo $openTarget; ?>" class="bt-image-link" title="<?php echo $row->title;?>" href="<?php echo $row->link;?>">
									  <img <?php echo $imgClass ?>  src="<?php echo $row->thumbnail; ?>" alt="<?php echo $row->title?>"  style=" height:<?php echo $thumbHeight ;?>px; width:<?php echo $thumbWidth ;?>px; float:<?php echo $align_image;?>;margin-<?php echo $align_image=="left"? "right":"left";?>:5px" title="<?php echo $row->title?>" />
									</a> 
									<?php endif ; ?>
									  <?php if( $showTitle ): ?>
									 <a class="bt-title-nointro" target="<?php echo $openTarget; ?>" title="<?php echo $row->title; ?>" href="<?php echo $row->link;?>">
									   <?php echo $row->title_cut; ?>
									 </a>
									 <?php endif; ?>
								
									<?php if( $showAuthor || $showDate ): ?>
									<br />
									<?php if( $showAuthor ): ?>
									   <span class="bt-author"><?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' ,
						 				JHtml::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$row->created_by),$row->author)); ?></span>						  
									<?php endif; ?> 
									<?php if( $showDate ): ?>
									   <span class="bt-date"><?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', $row->date); ?></span>						  
									<?php endif; ?>
									
									<?php endif; ?>
								</div>
							
							
							<?php endif; ?>
							
														

							<?php if( $showReadmore ) : ?>
							<p class="readmore">
							  <a  target="<?php echo $openTarget; ?>"  title="<?php echo $row->title;?>" href="<?php echo $row->link;?>">
								<?php echo JText::_('READ_MORE');?>
							  </a>
							</p>
							<?php endif; ?>
							
						</div>				
					    <!-- bt-inner -->
					   
					</div> 			
					<!-- bt-row -->					
					<?php
						if($itemsPerCol > 1 && $i < count($list)-1){
							if(($i+1)%$itemsPerRow ==0){
								echo '<div class="bt-row-separate"></div>';
							}
						}
					?>
					
					<?php endforeach; ?>
					<div style="clear:both;"></div>
				
				</div>			
			<!-- bt-main-item page	-->	
			<?php endforeach; ?>			
			
		</div>
		
	
	</div> 
	<!-- bt-container -->   


  </div>
 <?php else : ?>
 <div> No result...</div>
 <?php endif; ?>
 <div style="clear:both;"></div>
