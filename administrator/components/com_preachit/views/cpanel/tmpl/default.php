<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 * This control panel uses styling that has been adapted from the Kunena Control Panel
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/scripture.php');
$option = JRequest::getCmd('option');
?>
<style>
#fbadmin {
text-align:left;
}
#fbheader {
clear:both;
}
#fbmenu {
margin-top:15px;
border-top:1px solid #ccc;
}
#fbmenu a{
display:block;
font-size:11px;
border-left:1px solid #ccc;
border-bottom:1px solid #ccc;

}
.fbmainmenu {
background:#FBFBFB;
padding:5px;
}
.fbactivemenu {
background:#fff;
}
.fbsubmenu {
background:#fff;
padding-left:10px;
padding:5px 5px 5px 15px;
}
.fbright {
border:1px solid #ccc;
background:#fff;
padding:5px;
}
.fbfooter {
font-size:10px;
text-align: right;
padding:5px;
background:#FBFBFB;
border-bottom:1px solid #CCC;
border-left:1px solid #CCC;
border-right:1px solid #CCC;
}
.fbfunctitle {
font-size:16px;
text-align: left;
padding:5px;
background:#FBFBFB;
border:1px solid #CCC;
font-weight:bold;
margin-bottom:10px;
clear:both;
}
.fbfuncsubtitle {
font-size:14px;
text-align: left;
padding:5px;
border-bottom:3px solid  #7F9DB9;
font-weight:bold;
color:#7F9DB9;
margin:10px 0 10px 0;
}
.fbrow0 td {
padding:8px 5px;
text-align:left;
border-bottom:1px  dotted #ccc;
}
.fbrow1 td {
padding:8px 5px;
text-align:left;
border-bottom:1px dotted #ccc;
}
td.fbtdtitle {
font-weight:bold;
padding-left:10px;
color:#666;
}
#fbcongifcover fieldset {
border: 1px solid #CFDCEB;
}
#fbcongifcover fieldset legend{
color:#666;
}
.scripture {text-align: center; font-style: italic; font-size: 16px; padding: 20px 10px 40px 5px;}
.ref {text-align: center; font-style: italic; font-size: 12px; padding: 10px 5px;}
</style>

<div id="fbadmin">
 <!-- Header -->
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" valign="top">
    <!-- Begin: AdminLeft -->
        <div id="fbheader">
        <p style="text-align: center;"><img align="middle" src = "../components/com_preachit/assets/images/picpanel.png" border="0" alt = "preachit"/></p>
        </div>
        <!-- Bible text -->
        <div id="fbmenu">

       <table><tr><td class="scripture">"<?php echo JText::_('COM_PREACHIT_VS');?>"<div class="ref"><?php echo JText::_('COM_PREACHIT_VS_REF');?></div></td></tr>
<tr><td>
<div class="fbmainmenu"></div>
</td></tr>
</table> 

        </div>
        <!-- Bible text-->

    <!-- Finish: AdminLeft -->
    </td>
    <td  valign="top" class="fbright">
    <!-- Begin: AdminRight -->

<style>
.fbwelcome {
	clear:both;
	margin-bottom:10px;
	padding:10px;
	font-size:12px;
	color:#536482;
	line-height:140%;
	border:1px solid #ddd;
}
.fbwelcome h3 {
	margin:0;
	padding:0;
}
table.thisform {
	width: 100%;
	padding: 10px;
	border-collapse: collapse;
}
table.thisform tr.row0 {
	background-color: #F7F8F9;
}
table.thisform tr.row1 {
	background-color: #eeeeee;
}
table.thisform th {
	font-size: 15px;
	font-weight: normal;
	font-variant: small-caps;
	padding-top: 6px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	text-align: left;
	height: 25px;
	color: #666666;
	background: url(../images/background.gif);
	background-repeat: repeat;
}
table.thisform td {
	padding: 3px;
	text-align: left;
}
.fbstatscover {
	padding:0px;
}
table.fbstat {
	background-color:#FFFFFF;
	border:1px solid #ddd;
	padding:1px;
	width:100%;
}
table.fbstat th {
	background:#EEE;
	border-bottom:1px solid #CCC;
	border-top:1px solid #EEE;
	color:#666;
	font-size:11px;
	padding:3px 4px;
	text-align:left;
}
table.fbstat td {
	font-size:11px;
	line-height:140%;
	padding:4px;
	text-align:left;
}
table.fbstat caption {
	clear:both;
	font-size:14px;
	font-weight:bold;
	margin:10px 0 2px 0;
	padding:2px;
	text-align:left;
}
table.fbstat .col1 {
	background-color:#F1F3F5;
}
table.fbstat .col2 {
	background-color: #FBFBFB;
}
</style>
<div class="fbwelcome">
  <h3><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_WELCOME');?></h3>
  <p><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_WELCOME_MES');?></p>
</div>
<div style="border:1px solid #ddd; background:#FBFBFB;">
  <table class = "thisform">
    <tr class = "thisform">
      <td width = "100%" valign = "top" class = "thisform"><div id = "cpanel">
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=studylist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MESSAGES');?>"> <img src = "../components/com_preachit/assets/images/message.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MESSAGES'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=teacherlist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TEACHERS');?>"> <img src = "../components/com_preachit/assets/images/teacher.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TEACHERS'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=serieslist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_SERIES');?>"> <img src = "../components/com_preachit/assets/images/series.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_SERIES'); ?> </span> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=ministrylist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MINISTRIES');?>"> <img src = "../components/com_preachit/assets/images/ministry.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MINISTRIES'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=commentlist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_COMMENTS');?>"> <img src = "../components/com_preachit/assets/images/comment.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_COMMENTS'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=filepathlist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_FOLDERS');?>"> <img src = "../components/com_preachit/assets/images/folder.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_FOLDERS'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=booklist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_BOOKS');?>"> <img src = "../components/com_preachit/assets/images/book.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_BOOKS'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=bibleverslist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_BIBLEVERS');?>"> <img src = "../components/com_preachit/assets/images/version.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_BIBLEVERS'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=podcastlist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_PODCASTS')?>"> <img src = "../components/com_preachit/assets/images/podcast.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_PODCASTS'); ?> </span></a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=taglist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TAG');?>"> <img src = "../components/com_preachit/assets/images/tag.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TAG');?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=mimelist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MIME');?>"> <img src = "../components/com_preachit/assets/images/mime.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MIME');?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=templatelist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TEMPLATES');?>"> <img src = "../components/com_preachit/assets/images/template.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TEMPLATES'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=mediaplayerslist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MPLAYERS');?>"> <img src = "../components/com_preachit/assets/images/player.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MPLAYERS'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=sharelist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_SHARE');?>"> <img src = "../components/com_preachit/assets/images/share.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_SHARE'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=extensionlist" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_EXTENSIONS');?>"> <img src = "../components/com_preachit/assets/images/extension.png" align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_EXTENSIONS'); ?> </a> </div>
          </div>
          <div style = "float:left;">
            <div class = "icon"> <a href = "index.php?option=com_preachit&amp;view=admin" style = "text-decoration:none;" title = "<?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_ADMIN');?>"> <img src = "../components/com_preachit/assets/images/admin.png"  align = "middle" border = "0"/> <span> <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_ADMIN'); ?> </a> </div>
          </div>
        </div></td>
    </tr>
  </table>
</div>

<!-- BEGIN: STATS -->
<div class="fbstatscover">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="33%" valign="top"><!-- -->
<script language="javascript" type="text/javascript">
Joomla.submitbutton = function(task)
	{
	if (task == "")
        		{
                return false;
        		}
   else if (task == "resethits") 
	{
		if(confirm("<?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_RESET_WARNING');?>"))
		{Joomla.submitform(task);}
		} 
	else if (task == "resetdownloads") 
	{
		if(confirm("<?php echo JText::_('COM_PREACHIT_TEMPLATE_MANAGER_DOWNLOADS_WARNING');?>"))
		{Joomla.submitform(task);}
		} 
	
 else {
			Joomla.submitform(task);
		}
}
</script>
      <form action="index.php" method="post" name="adminForm">
        <table cellspacing="1"  border="0" width="100%" class="fbstat">
          <caption>
          <?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_GENERAL_STATS'); ?>
          </caption>
          <col class="col1">
          <col class="col2">
          <col class="col2">
          <thead>
            <tr>
              <th><?php echo JText::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
              <th></th>
              <th><?php echo JText::_('COM_PREACHIT_ADMIN_NUMBERSLIST');?></th>
            </tr>
          </thead>
          <tbody>
            <?php  require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.stats.class.php');?>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MESSAGE_NO')?></td>
					<td></td>
					<td><?php echo piStats::get_no_messages();?></td>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_SERIES_NO')?></td>
					<td></td>
					<td><?php echo piStats::get_no_series();?></td>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_TEACHERS_NO')?></td>
					<td></td>
					<td><?php echo piStats::get_no_teachers();?></td>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_MINISTRIES_NO')?></td>
					<td></td>
					<td><?php echo piStats::get_no_ministry();?></td>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_PODCASTS_NO')?></td>
					<td></td>
					<td><?php echo piStats::get_no_podcast();?></td>
					</tr>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_HITS')?></td>
					<td></td>
					<?php
					$submith = "Joomla.submitbutton('resethits')";?>
					<td><?php echo piStats::totalhits();?><span style="padding-left: 20px;"><button type="button" onclick="<?php echo $submith;?>">
 <?php echo JText::_('COM_PREACHIT_RESET');?> </button></span></td>
					</tr>
					<tr>
					<td><?php echo JText::_('COM_PREACHIT_ADMIN_CPANEL_DOWNLOADS')?></td>
					<td></td>
					<?php
					$submitd = "Joomla.submitbutton('resetdownloads')";?>
					<td><?php echo piStats::totaldownloads();?><span style="padding-left: 20px;"><button type="button" onclick="<?php echo $submitd;?>">
 <?php echo JText::_('COM_PREACHIT_RESET');?> </button></span></td>
					</tr>
          </tbody>
        </table>
        <input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="cpanel" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
        <!-- / -->
      </td>
      <td width="1%">&nbsp;</td>
      <td width="65%" valign="top"><!--  -->
        <table cellspacing="1"  border="0" width="100%" class="fbstat">
          <caption>
          <?php echo  Jtext::_('COM_PREACHIT_ADMIN_CPANEL_LATMES'); ?>
          </caption>
          <col class="col1">
          <col class="col2">
          <col class="col2">
          <thead>
            <tr>
              <th width="32%"><?php echo JText::_('COM_PREACHIT_ADMIN_TITLELIST');?></th>
              <th width="2%"></th>
              <th width="32%"><?php echo Jtext::_('COM_PREACHIT_ADMIN_SCRIPTURELIST');?></th>
              <th width="2%"></th>
              <th width="32%"><?php echo Jtext::_('COM_PREACHIT_ADMIN_DATELIST');?></th>
            </tr>
          </thead>
          <tbody>
		<?php foreach($this->latests as $latest)
		{ 
	
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=studylist&task=edit&cid[]='. $latest->id );	
	
		//build scripture ref
	
		//get scripture

        $scripture = PIHelperscripture::podscripture($latest->id);
		?>
		<tr>
		<td><a href="<?php echo $link; ?>"><?php echo $latest->study_name;?></a></td>
		<td></td>
		<td><?php echo $scripture;?></td>
		<td></td>
		<td><?php echo JHTML::Date($latest->study_date, $this->dateformat); ?></td>
		</tr>
		<?php } ?>
          </tbody>
        </table>
        <!-- / -->
      </td>
    </tr>
  </table>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="33%" valign="top"><!-- -->
      <table cellspacing="1"  border="0" width="100%" class="fbstat">
          <caption>
          <?php echo  Jtext::_('COM_PREACHIT_ADMIN_CPANEL_LATPOD'); ?>
          </caption>
          <col class="col1">
          <col class="col2">
          <col class="col2">
          <thead>
            <tr>
              <th><?php echo Jtext::_('COM_PREACHIT_ADMIN_NAMELIST');?></th>
              <th></th>
              <th><?php echo Jtext::_('COM_PREACHIT_ADMIN_CPANEL_PODPUB');?></th>
            </tr>
          </thead>
          <tbody>
			<?php foreach($this->pods as $pod)
		{ 
	
		$link2 = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=podcastlist&task=edit&cid[]='. $pod->id );	
	
		?>
		<tr>
		<td><a href="<?php echo $link2; ?>"><?php echo $pod->name;?></a></td>
		<td></td>
		<td><?php echo JHTML::Date($pod->podpub, $this->dateformat); ?></td>
		</tr>
		<?php } ?>
	
          </tbody>
        </table>
        
        <!-- / -->
      </td>
      <td width="1%">&nbsp;</td>
      <td width="65%" valign="top"><!--  -->
        <table cellspacing="1"  border="0" width="100%" class="fbstat">
          <caption>
          <?php echo Jtext::_('COM_PREACHIT_ADMIN_CPANEL_POPMES'); ?>
          </caption>
          <col class="col1">
          <col class="col2">
          <col class="col2">
          <thead>
            <tr>
              <th width="32%"><?php echo JText::_('COM_PREACHIT_ADMIN_TITLELIST');?></th>
              <th width="2%"></th>
              <th width="32%"><?php echo Jtext::_('COM_PREACHIT_ADMIN_SCRIPTURELIST');?></th>
              <th width="2%"></th>
              <th width="32%"><?php echo Jtext::_('COM_PREACHIT_ADMIN_HITSLIST');?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($this->pops as $pop)
		{ 
	
		$link1 = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=studylist&task=edit&cid[]='. $pop->id );	
	
		//build scripture ref
	
		//get scripture

        $scripture1 = PIHelperscripture::podscripture($pop->id);
		?>
		<tr>
		<td><a href="<?php echo $link1; ?>"><?php echo $pop->study_name;?></a></td>
		<td></td>
		<td><?php echo $scripture1;?></td>
		<td></td>
		<td><?php echo $pop->hits; ?></td>
		</tr>
		<?php } ?>
          </tbody>
        </table>
        <!-- / -->
      </td>
    </tr>
  </table>
</div>

    </td>
  </tr>
  <tr><td></td><td>
 <!-- Footer -->
 <div class="fbfooter">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer(1);?></div>
<!-- /Footer -->

  </td></tr>
</table>

</div>