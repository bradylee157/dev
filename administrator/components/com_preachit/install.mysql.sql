CREATE TABLE IF NOT EXISTS `#__pibooks` (
  `id` int(11) NOT NULL auto_increment,
  `book_name` varchar(50) NOT NULL,
  `published` TINYINT( 3 ) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
);

INSERT IGNORE INTO `#__pibooks` (`id`, `book_name`)
VALUES ('1', 'Genesis'),
('2', 'Exodus'),
('3', 'Leviticus'),
('4', 'Numbers'),
('5', 'Deuteronomy'),
('6', 'Joshua'),
('7', 'Judges'),
('8', 'Ruth'),
('9', '1 Samuel'),
('10', '2 Samuel'),
('11', '1 Kings'),
('12', '2 Kings'),
('13', '1 Chronicles'),
('14', '2 Chronicles'),
('15', 'Ezra'),
('16', 'Nehemiah'),
('17', 'Esther'),
('18', 'Job'),
('19', 'Psalm'),
('20', 'Proverbs'),
('21', 'Ecclesiastes'),
('22', 'Song of Songs'),
('23', 'Isaiah'),
('24', 'Jeremiah'),
('25', 'Lamentations'),
('26', 'Ezekiel'),
('27', 'Daniel'),
('28', 'Hosea'),
('29', 'Joel'),
('30', 'Amos'),
('31', 'Obadiah'),
('32', 'Jonah'),
('33', 'Micah'),
('34', 'Nahum'),
('35', 'Habakkuk'),
('36', 'Zephaniah'),
('37', 'Haggai'),
('38', 'Zechariah'),
('39', 'Malachi'),
('40', 'Matthew'),
('41', 'Mark'),
('42', 'Luke'),
('43', 'John'),
('44', 'Acts'),
('45', 'Romans'),
('46', '1 Corinthians'),
('47', '2 Corinthians'),
('48', 'Galatians'),
('49', 'Ephesians'),
('50', 'Philippians'),
('51', 'Colossians'),
('52', '1 Thessalonians'),
('53', '2 Thessalonians'),
('54', '1 Timothy'),
('55', '2 Timothy'),
('56', 'Titus'),
('57', 'Philemon'),
('58', 'Hebrews'),
('59', 'James'),
('60', '1 Peter'),
('61', '2 Peter'),
('62', '1 John'),
('63', '2 John'),
('64', '3 John'),
('65', 'Jude'),
('66', 'Revelation'),
('67', 'topical')
;

CREATE TABLE IF NOT EXISTS `#__picomments` (
  `id` int(11) NOT NULL auto_increment,
  `study_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_text` text NOT NULL,
  `published` TINYINT( 3 ) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__pifilepath` (
  `id` int(11) NOT NULL auto_increment,
  `server` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `name` varchar(40) NOT NULL,
  `type` TINYINT(3) NOT NULL,
  `ftphost` VARCHAR(100) NOT NULL,
  `ftpuser` VARCHAR(250) NOT NULL,
  `ftppassword` VARCHAR(250) NOT NULL,
  `ftpport` VARCHAR(10) NOT NULL,
  `aws_key` VARCHAR(100) NOT NULL,
  `aws_secret` VARCHAR(100) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__pimime` (
  `id` int(11) NOT NULL auto_increment,
  `extension` varchar(10) NOT NULL,
  `mediatype` varchar(20) NOT NULL,
  `published` TINYINT( 3 ) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
);


INSERT IGNORE INTO `#__pimime` (`id`, `extension`, `mediatype`)
VALUES ('1', 'mp3', 'audio/mpeg'),
('2', 'mp4', 'video/mpeg'),
('3', 'ra', 'audio/x-pn-realaudio'),
('4', 'm4v', 'video/x-m4v'),
('5', 'rm', 'application/vnd.rn-r'),
('6', 'wma', 'audio/x-ms-wma'),
('7', 'wav', 'audio/x-wav'),
('8', 'rpm', 'audio/x-pn-realaudio'),
('9', 'rm', 'audio/x-pn-realaudio'),
('10', 'ram', 'audio/x-pn-realaudio'),
('11', 'mpg', 'video/mpeg'),
('12', 'mp2', 'video/mpeg'),
('13', 'avi', 'video/x-msvideo'),
('14', 'flv', 'video/x-flv .flv');


CREATE TABLE IF NOT EXISTS `#__pipodcast` (
  `id` int(11) NOT NULL auto_increment,
  `published` tinyint(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `records` int(3) NOT NULL,
  `website` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(100) NOT NULL,
  `imagehgt` int(4) NOT NULL,
  `imagewth` int(4) NOT NULL,
  `author` varchar(50) NOT NULL,
  `search` varchar(200) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `menu_item` int(11) NOT NULL,
  `language` varchar(10) NOT NULL,
  `editor` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ordering` int(11) NOT NULL,
  `podpub` datetime NOT NULL,
  `itunestitle` int(11) NOT NULL,
  `itunessub` int(11) NOT NULL,
  `itunesdesc` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__piseries` (
  `id` int(11) NOT NULL auto_increment,
  `series_name` varchar(250) NOT NULL,
  `series_alias` varchar(250) NOT NULL,
  `image_folder` int(11) NOT NULL,
  `image_folderlrg` int(11) NOT NULL,
  `series_image_sm` varchar(250) NOT NULL,
  `series_image_lrg` varchar(250) NOT NULL,
  `series_description` text NOT NULL,
  `ministry` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `introvideo` tinyint(3) NOT NULL,
  `videoplayer` int(11) NOT NULL,
  `videofolder` int(11) NOT NULL,
  `videolink` varchar(250) NOT NULL,
  `vheight` int(4) NOT NULL,
  `vwidth` int(4) NOT NULL,
  `checked_out` tinyint(1),
  `checked_out_time` datetime,
  `user` int(11) NOT NULL,
  `access` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__piministry` (
  `id` int(11) NOT NULL auto_increment,
  `ministry_name` varchar(250) NOT NULL,
  `ministry_alias` varchar(250) NOT NULL,
  `image_folder` int(11) NOT NULL,
  `image_folderlrg` int(11) NOT NULL,
  `ministry_image_sm` varchar(250) NOT NULL,
  `ministry_image_lrg` varchar(250) NOT NULL,
  `ministry_description` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `access` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__piteachers` (
  `id` int(11) NOT NULL auto_increment,
  `teacher_name` varchar(30) NOT NULL,
  `teacher_alias` varchar(250) NOT NULL,
  `teacher_role` varchar(50) NOT NULL,
  `image_folder` int(11) NOT NULL,
  `image_folderlrg` int(11) NOT NULL,
  `teacher_image_sm` varchar(250) NOT NULL,
  `teacher_image_lrg` varchar(250) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `teacher_website` varchar(250) NOT NULL,
  `teacher_description` text NOT NULL,
  `published` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `teacher_view` tinyint(3) NOT NULL,
  `checked_out` tinyint(1),
  `checked_out_time` datetime,
  `user` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__pistudies` (
  `id` int(11) NOT NULL auto_increment,
  `study_date` datetime NOT NULL,
  `study_name` varchar(255) NOT NULL,
  `study_alias` varchar(250) NOT NULL,
  `study_description` text NOT NULL,
  `study_book` int(11) NOT NULL,
  `ref_ch_beg` int(4) NOT NULL,
  `ref_ch_end` int(4) NOT NULL,
  `ref_vs_beg` int(4) NOT NULL,
  `ref_vs_end` int(4) NOT NULL,
  `study_book2` int(11) NOT NULL,
  `ref_ch_beg2` int(4) NOT NULL,
  `ref_ch_end2` int(4) NOT NULL,
  `ref_vs_beg2` int(4) NOT NULL,
  `ref_vs_end2` int(4) NOT NULL,
  `series` int(11) NOT NULL,
  `ministry` int(11) NOT NULL,
  `dur_hrs` int(4) NOT NULL,
  `dur_mins` int(4) NOT NULL,
  `dur_secs` int(4) NOT NULL,
  `video` tinyint(1) NOT NULL,
  `video_type` int(11) NOT NULL,
  `video_link` varchar(250) NOT NULL,
  `video_download` tinyint(3) NOT NULL,
  `audio` tinyint(3) NOT NULL,
  `audio_type` int(11) NOT NULL,
  `audio_link` varchar(250) NOT NULL,
  `audio_download` tinyint(3) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `comments` tinyint(3) NOT NULL,
  `study_text` mediumtext NOT NULL,
  `teacher` text NOT NULL,
  `audio_folder` int(11) NOT NULL,
  `video_folder` int(11) NOT NULL,
  `text` tinyint(3) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `asmedia` int(11) NOT NULL,
  `studylist` tinyint(3) NOT NULL,
  `publish_up` DATETIME NOT NULL ,
  `publish_down` DATETIME NOT NULL ,
  `image_folder` INT( 11 ) NOT NULL ,
  `image_foldermed` int(11) NOT NULL,
  `image_folderlrg` int(11) NOT NULL,
  `imagesm` VARCHAR( 250 ) NOT NULL ,
  `imagemed` VARCHAR( 250 ) NOT NULL ,
  `imagelrg` VARCHAR( 250 ) NOT NULL ,
  `notes_folder` INT( 11 ) NOT NULL ,
  `notes` TINYINT( 3 ) NOT NULL ,
  `notes_link` VARCHAR( 250 ) NOT NULL ,
  `add_downloadvid` TINYINT( 3 ) NOT NULL ,
  `downloadvid_link` VARCHAR( 250 ) NOT NULL,
  `downloadvid_folder` INT(11) NOT NULL,
  `checked_out` tinyint(1),
  `checked_out_time` datetime,
  `user` int(11) NOT NULL,
  `access` int(11) NOT NULL DEFAULT '0',
  `saccess` int(11) NOT NULL DEFAULT '0',
  `minaccess` int(11) NOT NULL DEFAULT '0',
  `audpurchase` tinyint(3) NOT NULL,
  `audpurchase_folder` int(11) NOT NULL,
  `audpurchase_link` varchar(250) NOT NULL,
  `vidpurchase` tinyint(3) NOT NULL,
  `vidpurchase_folder` int(11) NOT NULL,
  `vidpurchase_link` varchar(250) NOT NULL,
  `tags` text NOT NULL,
  `audiofs` int(24) NOT NULL,
  `videofs` int(24) NOT NULL,
  `notesfs` int(24) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__pimediaplayers` (
  `id` int(11) NOT NULL auto_increment,
  `playername` varchar(250) NOT NULL,
  `playertype` int(11) NOT NULL,
  `playercode` mediumtext NOT NULL,
  `published` TINYINT( 3 ) NOT NULL DEFAULT '1',
  `vers` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

INSERT IGNORE INTO `#__pimediaplayers` (`id`, `playertype`, 
`playername`, `playercode`)
VALUES ('1', '2', 'JWplayer Video', '<div class="localvideoplayer" id="player-div">
<p id=''localplayer''></p>
<script type="text/javascript">
jwplayer("localplayer").setup({
flashplayer: "[root]components/com_preachit/assets/mediaplayers/player.swf",
file: "[fileurl]",
height: [height],
width: [width],
skin: "[skin]", controlbar: "bottom"
});
</script>
</div> '),
('2', '2', 'Vimeo', '<div class="vimeoplayer">
<iframe src="http://player.vimeo.com/video/[fileid]?title=0&amp;byline=0&amp;portrait=0" width="[width]" height="[height]" frameborder="0"></iframe>
</div>'),
('3', '2', 'Youtube', '<div class="youtubeplayer">
<iframe width="[width]" height="[height]" src="http://www.youtube.com/embed/[fileid]?rel=0" frameborder="0" allowfullscreen></iframe>
</div>'),
('4', '2', 'Blip tv', '<div class="blipplayer">
<embed src="[fileid]" type="application/x-shockwave-flash" width="[width]" height="[height]" allowscriptaccess="always" allowfullscreen="true"></embed>
</div>'),
('5', '1', 'One pixel out', '<div class="localaudioplayer">
<object height="[height]" width="[width]" id="audioplayer1" data="[root]components/com_preachit/assets/mediaplayers/pixelplayer.swf" type="application/x-shockwave-flash">
<param value="[root]components/com_preachit/assets/mediaplayers/pixelplayer.swf" name="movie">
<param value="playerID=1&amp;soundFile=[fileurl]" name="FlashVars">
<param value="high" name="quality">
<param value="false" name="menu">
<param value="transparent" name="wmode">
</object>
</div>'),
('6', '1', 'JWplayer Audio', '<div class="localaudioplayer" id="player-div">
<p id="localplayer"></p>
<script type="text/javascript">
jwplayer("localplayer").setup({
flashplayer: "[root]components/com_preachit/assets/mediaplayers/player.swf",
file: "[fileurl]",
height: [height],
width: [width],
skin: "[skin]", controlbar: "bottom"
});
</script>
</div> ');
INSERT IGNORE INTO `#__pimediaplayers` (`id`, `playertype`, 
`playername`, `playercode`)
VALUES ('7', '2', 'Flowplayer', '<div style="width:[width]px;height:[height]px;" id="player">
<!-- this script block will install Flowplayer inside previous DIV tag -->
<script language="JavaScript">
flowplayer(
"player", 
"[root]components/com_preachit/assets/mediaplayers/flowplayer-3.2.2.swf", 
		"[fileurl]"
	);
</script>
</div> ');

CREATE TABLE IF NOT EXISTS `#__pibckadmin` (
  `id` int(11) NOT NULL auto_increment,
  `autopodcast` int(4) NOT NULL DEFAULT '0',
  `droptables` int(4) NOT NULL DEFAULT '0',
  `studyedit_temp` int(4) NOT NULL,
  `getupdate` tinyint(3) NOT NULL DEFAULT '0',
  `series` int(11) NOT NULL,
  `ministry` int(11) NOT NULL,
  `video` tinyint(1) NOT NULL,
  `video_type` int(11) NOT NULL,
  `audio_type` int(11) NOT NULL,
  `video_download` tinyint(3) NOT NULL,
  `audio` tinyint(3) NOT NULL,
  `audio_download` tinyint(3) NOT NULL,
  `comments` tinyint(3) NOT NULL,
  `text` int(4) NOT NULL,
  `teacher` int(11) NOT NULL,
  `powered` text NOT NULL,
  `audio_folder` int(11) NOT NULL,
  `video_folder` int(11) NOT NULL,
  `studylist` tinyint(3) NOT NULL DEFAULT '1',
  `image_folder` INT( 11 ) NOT NULL,
  `image_foldermed` INT( 11 ) NOT NULL ,
  `image_folderlrg` INT( 11 ) NOT NULL ,
  `notes_folder` INT( 11 ) NOT NULL,
  `notes` TINYINT( 3 ) NOT NULL,
  `add_downloadvid` TINYINT( 3 ) NOT NULL,
  `downloadvid_folder` INT(11) NOT NULL,
  `default_template` VARCHAR(100) NOT NULL DEFAULT 'revolution',
  `uploadtype` tinyint(3) NOT NULL DEFAULT '1',
  `checkin` tinyint(3) NOT NULL DEFAULT '0',
  `access` tinyint(3) NOT NULL DEFAULT '0',
  `uploadfile` VARCHAR(250) NOT NULL,
  `tableversion` TEXT NOT NULL,
  PRIMARY KEY  (`id`)
);

INSERT IGNORE INTO `#__pibckadmin` (`id`, `powered`)
VALUES ('1', '<div style="text-align: center; padding-top: 15px; font-size: 10px;">Powered by <a href="http://webdesign.truthengaged.org.uk">Truthengaged</a></div>' );

CREATE TABLE IF NOT EXISTS `#__pitemplates` (
  `id` int(11) NOT NULL auto_increment,
  `messortlists` text NOT NULL,
  `messagelist` text NOT NULL,
  `audio` text NOT NULL,
  `audiopopup` text NOT NULL,
  `video` text NOT NULL,
  `videopopup` text NOT NULL,
  `text` text NOT NULL,
  `seriesheader` text NOT NULL,
  `serieslist` text NOT NULL,
  `series` text NOT NULL,
  `seriessermons` text NOT NULL,
  `teacherheader` text NOT NULL,
  `teacherlist` text NOT NULL,
  `teacher` text NOT NULL,
  `teachersermons` text NOT NULL,
  `ministryheader` text NOT NULL,
  `ministrylist` text NOT NULL,
  `ministry` text NOT NULL,
  `ministryseries` text NOT NULL,
  `taglist` text NOT NULL,
  PRIMARY KEY  (`id`)
); 

CREATE TABLE IF NOT EXISTS `#__pipodmes` (
  `mesid` int(11) NOT NULL,
  `podaudid` int(11) NOT NULL,
  `podvidid` int(11) NOT NULL,
  `date` datetime NOT NULL
);

CREATE TABLE IF NOT EXISTS `#__piadminpodmes` (
  `mesid` int(11) NOT NULL,
  `podaudid` int(11) NOT NULL,
  `podvidid` int(11) NOT NULL,
  `date` datetime NOT NULL
);

INSERT IGNORE INTO `#__pitemplates` (`id`, `messortlists`, `messagelist`, 
`audio`, `audiopopup`, `video`, `videopopup`, `text`, `serieslist`, `series`, `seriessermons`, `teacherlist`, `teacher`, `teachersermons`, `ministrylist`, `ministry`, `ministryseries`)
VALUES (
'1',
'<div class="headblock">
<div class="sortlistblock">
<span class="filtertext">Filter Media by:</span>
<span class="sortlists">[booklist]</span>
<span class="sortlists">[teacherlist]</span>
<span class="sortlists">[serieslist]</span>
<span class="sortlists">[yearlist]</span>
</div>
</div>',
'<div class="listblock">
<div class="date">[date]</div>
<div class="medialinks">[medialinks]</div>
<div class="study_name">[name]</div>
<div class="scripture">Passage: [scripture][scripture2]</div>
<div class="additional"><span class="teacher">Teacher: [teacher]</span><span class="series">Series: [series]</span><span class="duration">Duration: [duration]</span></div>
</div>', '<div class="topbar"><div class="study_name"><div class="date">[date]</div>
[name]</div>
<div class="subtitle">[scripture][scripture2] by [teacher]</div>
<div class="study_description">[description]</div>
<div class="series">[series]</div>
[audio]
<div class="medialinks">[medialinks]</div>
<div class="share">[share]</div>
</div>
[backlink]', '<div class="detailscontainer"><div class="topbar"><div class="study_name"><div class="date">[date]</div>
[name]</div>
<div class="subtitle">[scripture][scripture2] by [teacher]
Series: [series]
</div></div>
[audio]
div class="study_description">[description]</div>
<div class="links"
<div class="medialinks">[medialinks]</div>
<div class="share">[share]</div>
 </div></div>', '<div class="topbar"><div class="study_name"><div class="date">[date]</div>
[name]</div>
<div class="subtitle">[scripture][scripture2] by [teacher]</div></div>
[video]
<div class="study_description">[description]</div>
<div class="series">Series: [series]</div>
<div class="medialinks">
<div class="share">[share]</div>
[medialinks]</div>
[backlink]',
'<div class="detailscontainer">
<div class="topbar"><div class="study_name">[date]</div>
[name]</div>
<div class="subtitle"><div class="series">Series: [series]</div>[scripture][scripture2] by [teacher]</div></div>
[video]
<div class="study_description">[description]</div>
<div class="links"><div class="medialinks">[medialinks]</div>
<div class="share">[share]</div>
</div>
</div>',
'<div class="topbar"><div class="study_name"><div class="date">[date]</div>
[name]</div>
<div class="subtitle">[scripture][scripture2] by [teacher]</div></div>
<div class="study_description">[description]</div>
<div class="series">Series: [series]</div>
<div class="medialinks">
<div class="share">[share]</div>
[medialinks]</div>

<div class="study_text">[text]</div>

<div class="medialinks">
<div class="share">[share]</div>
[medialinks]</div>

[backlink]',
'<div class="listblock">
<table width="100%">
<tr>
<td>[simagesm]
<div class="seriesname">[series]</div>
<div class="seriesdescription">[seriesdescription]</div>
</td>
</tr>
</table>
</div>',
'<table width="100%">
<tr>
<td>
[simagelrg]
<div class="seriesname">[series]</div>
<div class="seriesdescription">[seriesdescription]</div>
</td>
</tr>
</table>',
'<div class="listblock">
<div class="medialinks">[medialinks]</div>
<div class="study_name">[name]</div>
<div class="scripture">Passage: [scripture][scripture2]<span class="date">[date]</span></div>
<div class="teacher">Teacher: [teacher]</div>
</div>',
'<div class="listblock">
<table width="100%">
<tr>
<td>[timagesm]
<div class="teachername">[teacher]</div>
<div class="teacherrole">[role]</div>
<div class="teacherdescription">[teacherdescription]</div>
</td>
</tr>
</table>
</div>',
'<table width="100%">
<tr>
<td>
[timagelrg]
<div class="teachername">[teacher]</div>
<div class="teacherrole">Role: [role]</div>
<div class="teacherweb">Web: [web]</div></td>
</tr>
</table>
<div class="teacherdescription">[teacherdescription]</div>',
'<div class="listblock">
<div class="medialinks">[medialinks]</div>
<div class="study_name">[name]</div>
<div class="date">[date]<span class="scripture">Passage: [scripture][scripture2]</span></div>
</div>',
'<div class="listblock">
<table width="100%">
<tr>
<td>[mimagesm]
<div class="ministryname">[ministry]</div>
<div class="ministrydescription">[ministrydescription]</div>
</td>
</tr>
</table>
</div>',
'<table width="100%">
<tr>
<td>[mimagelrg]
<div class="ministryname">[ministry]</div>
<div class="ministrydescription">[ministrydescription]</div>
</td>
</tr>
</table>',
'<div class="listblock">
<table width="100%">
<tr>
<td>[simagesm]
<div class="seriesname">[series]</div>
<div class="seriesdescription">[seriesdescription]</div>
</td>
</tr>
</table>
</div>');



CREATE TABLE IF NOT EXISTS `#__pibiblevers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `published` TINYINT( 3 ) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
);

INSERT IGNORE INTO `#__pibiblevers` (`id`, `name`, `code`)
VALUES ('1', 'New International Version', 'NIV'),
('2', 'New International Version UK', 'NIVUK'),
('3', 'Contemporary English Version', 'CEV'),
('4', 'English Standard Version', 'ESV'),
('5', 'New King James Version', 'NKJV'),
('6', 'New American Standard Version', 'NASB'),
('7', 'New Living Translation', 'NLT'),
('8', 'The Message', 'MSG'),
('9', 'Todays New International Version', 'TNIV'),
('10', 'Louis Segond', 'LSG'),
('11', 'La Bible du Semeur', 'BDS'),
('12', 'Nueva Version Internacional', 'NVI');

ALTER TABLE `#__pistudies` CHANGE `study_description` `study_description` TEXT NOT NULL;
ALTER TABLE `#__pistudies` CHANGE `audio_link` `audio_link` varchar(250) NOT NULL;
ALTER TABLE `#__pistudies` CHANGE `video_link` `video_link` varchar(250) NOT NULL;
ALTER TABLE `#__piseries` CHANGE `series_image_sm` `series_image_sm` varchar(250) NOT NULL;
ALTER TABLE `#__piseries` CHANGE `series_image_lrg` `series_image_lrg` varchar(250) NOT NULL;
ALTER TABLE `#__piministry` CHANGE `ministry_image_sm` `ministry_image_sm` varchar(250) NOT NULL;
ALTER TABLE `#__piministry` CHANGE `ministry_image_sm` `ministry_image_sm` varchar(250) NOT NULL;
ALTER TABLE `#__piteachers` CHANGE `teacher_image_sm` `teacher_image_sm` varchar(250) NOT NULL;
ALTER TABLE `#__piteachers` CHANGE `teacher_image_lrg` `teacher_image_lrg` varchar(250) NOT NULL;
UPDATE `#__pibckadmin` SET `powered` = '<a href="http://te-webdesign.org.uk">Truthengaged</a>';
