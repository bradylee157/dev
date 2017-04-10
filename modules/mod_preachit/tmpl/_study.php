<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
$abspath    = JPATH_SITE;
require_once($abspath.DS.'components/com_preachit/helpers/message-info.php');
require_once($abspath.DS.'components/com_preachit/helpers/scripture.php');
jimport('teweb.effects.standard');
$t = $params->get('teacher', 1);
$ser = $params->get('series', 1);
$s = $params->get('scripture', 1);
$m = $params->get('medialinks', 1);
$d = $params->get('date', 1);
$dateformat = $params->get('date_format');
$tl = $params->get('titlelink', 1);
$menuid = $params->get('menuid');
if ($params->get('namelength', '') > 0)
{$study->study_name = Tewebeffects::shortentext($study->study_name, $params->get('namelength', ''));}
if ($tl == '1')
{$title = $study->link . $study->study_name . '</a>';}
else
{$title = $study->study_name;}


//get teacher name
$teacher_name =  PIHelpermessageinfo::teacher($study->teacher, $item, 2);

//get series name

$series_name =  PIHelpermessageinfo::series($study->series, $item, 2);

//get scripture

$scripture = PIHelperscripture::podscripture($study->id);

// get image

if ($params->get('listimage', 1) != 1)
{
    if ($params->get('listimage', 1) == 2)
    {
        require_once($abspath.DS.'components/com_preachit/helpers/teacherimage.php');
        $image = PIHelpertimage::teacherimage($study->teacher, 1, $menuid , 'small');
    }
    elseif ($params->get('listimage', 1) == 3)
    {
        require_once($abspath.DS.'components/com_preachit/helpers/seriesimage.php');
        $image = PIHelpersimage::seriesimage($study->series, 1, $menuid, 'small');
    }
    elseif ($params->get('listimage', 1) == 4)
    {
        require_once($abspath.DS.'components/com_preachit/helpers/messageimage.php');
        $image = PIHelpermimage::messageimage($study->id, 1, $menuid, $params->get('popup', 0), 'small');
    }
}
else {$image = null;}