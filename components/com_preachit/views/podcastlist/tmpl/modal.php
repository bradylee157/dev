<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$user =& JFactory::getUser();
$params = PIHelperadditional::getPIparams();
?>
<style>
.podcastname {font-size: 16px; font-weight: bold; padding: 3px 0 7px 0; }

.headblock {border-bottom: 1px solid #666666; margin: 0 10px; padding: 10px 5px; }

.listblock {border-bottom: 1px solid #666666; margin: 0 10px; padding: 20px 5px; }

.lastwrite {padding: 0 0 0 10px; font-size: 12px;}

.legend {font-size: 16px; font-weight: bold;}
.mesimage {vertical-align: middle; margin: 0 5px 0 0;}
.edittitle {font-size: 24px; font-weight: bold; margin: 5px 0 5px 0;}
.formelm_buttons {margin: 0 0 0 15px; font-size: 14px;}
.backgrd {background=color: #ffffff;}
.footeredit {text-align: center; font-size: 12px; margin: 10px 0 0 0;}
</style>
<div class="backgrd">
<?php echo $this->msg;?>
<div class="listblock">
	<div class="edittitle"><img class="mesimage" src="components/com_preachit/assets/images/podcast.png">
<?php echo JText::_('COM_PREACHIT_ADMIN_PODCASTS_PUBLISH');?></div></div>
<div class="listblock">
<?php
foreach ($this->rows as $row)
{

//check user has access to edit buttons

if (!$user->authorize('core.create', 'com_preachit')) 
{Tewebcheck::check403($params);}

$link = JURI::BASE().'index.php?option=com_preachit&controller=podcastlist&task=publishXMLmodal&id='.$row->id;
$date = JHTML::Date($row->podpub, 'd F, Y');
?>

<div class="podcastname"><?php echo htmlspecialchars($row->name);?><span class="formelm_buttons"><a href="<?php echo $link;?>"><button type="button">
		<?php echo JText::_('COM_PREACHIT_ADMIN_BUTTON_WRITE_XML');  ?>
	</button></a></span><span class="lastwrite"><?php echo JText::_('COM_PREACHIT_ADMIN_LAST_WRITE_XML');?> <?php echo $date;?></span>
	</div><?php
}
 ?>
 </div>
 <div class="listingfooter" >
	<?php 
     echo $this->pagination->getPagesLinks();
      echo $this->pagination->getPagesCounter();
     ?>
</div>

<!-- Footer -->
<div class="footeredit">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
</div>