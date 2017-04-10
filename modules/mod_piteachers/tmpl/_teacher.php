<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
jimport('teweb.effects.standard');
$td = $params->get('teacherdesc', 0);
$ti = $params->get('teacherimage', 1);
$menuid = $params->get('menuid');

if ($ti ==1)
{
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/teacherimage.php');
$image = PIHelpertimage::teacherimage($teacher->id, 1, $menuid, 'small');
}
else {$image = '';}

if ($td == '1')
			{$description = '<div class="tdescription">' . $teacher->teacher_description. '</div>';}
			else {$description = '';}

if ($teacher->teacher_name != '')
{
    $name = $teacher->teacher_name.' '.$teacher->lastname;
}
else {$name = $teacher->lastname;}

if ($params->get('namelength', '') > 0)
{$name = Tewebeffects::shortentext($name, $params->get('namelength', ''));}
            
$title = '<div class="teachername">'.$teacher->link . $name . '</a></div>';
