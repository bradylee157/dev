<?php
/**
 * Default Custom
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

$mainframe = JFactory::getApplication();
$option = JRequest::getCmd('option');
$document = JFactory::getDocument();
$params = $this->params;
$url = $this->params->get('stylesheet');
if ($url) {
    $document->addStyleSheet($url);
}
$listingcall = JView::loadHelper('serieslist');
$t = $this->params->get('serieslisttemplateid');
if (!$t) {
    $t = JRequest::getVar('t', 1, 'get', 'int');
}
?>
<form action="<?php echo str_replace("&", "&amp;", $this->request_url); ?>" method="post" name="adminForm">
    <div id="biblestudy" class="noRefTagger"> <!-- This div is the container for the whole page -->
            <?php
            echo getSeriesDetailsExp($this->items, $this->params, $this->admin_params, $this->template);
            ?> <table class="bslisttable" cellspacing="0"> <?php
        $studies = getSeriesstudiesExp($this->items->id, $this->params, $this->admin_params, $this->template);
        echo $listing;
        echo $studies;
            ?></table>
        <?php
        if ($this->params->get('series_list_return') > 0) {
            // @todo need to rework to be proper php
            echo '<table><tr class="seriesreturnlink"><td><a href="' . JRoute::_('index.php?option=com_biblestudy&view=seriesdisplays&t=' . $t) . '"><< ' . JText::_('JBS_SER_RETURN_SERIES_LIST') . '</a> | <a href="' . JRoute::_('index.php?option=com_biblestudy&view=sermons&filter_series=' . $this->items->id . '&t=' . $t) . '">' . JText::_('JBS_CMN_SHOW_ALL') . ' ' . JText::_('JBS_SER_STUDIES_FROM_THIS_SERIES') . ' >></a></td></tr></table>';
        }
        ?>
    </div><!--end of bspagecontainer div-->
    <input name="option" value="com_biblestudy" type="hidden">
    <input name="task" value="" type="hidden">
    <input name="boxchecked" value="0" type="hidden">
    <input name="controller" value="seriesdisplay" type="hidden">
</form>