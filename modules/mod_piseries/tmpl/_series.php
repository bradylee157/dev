<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
jimport('teweb.effects.standard');
$sd = $params->get('seriesdesc', 0);
$si = $params->get('seriesimage', 1);
$menuid = $params->get('menuid');

if ($si ==1)
{
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/seriesimage.php');

$image = PIHelpersimage::seriesimage($series->id, 1, $menuid, 'small');
}
else {$image = '';}

if ($sd == '1')
			{$description = '<div class="sdescription">' . $series->series_description. '</div>';}
			else {$description = '';}

if ($params->get('namelength', '') > 0)
{$series->series_name = Tewebeffects::shortentext($series->series_name, $params->get('namelength', ''));}
            
$title = '<div class="seriesname">'.$series->link . $series->series_name . '</a></div>';
