<?php
/**
 * Default Main
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers');

JHTML::_('behavior.tooltip');
$params = $this->params;
$document = JFactory::getDocument();
$document->addScript(JURI::base() . 'media/com_biblestudy/js/tooltip.js');

$row = $this->study;
// @todo need to clean up old code.
$listingcall = JView::loadHelper('listing');
$sharecall = JView::loadHelper('share');
?>
<div id="bsmHeader">
    <?php
    if ($this->params->get('showpodcastsubscribedetails') == 1) {
        echo $this->subscribe;
    }
    if ($this->params->get('showrelated') == 1) {
        echo $this->related;
    }
    ?>
    <div class="buttonheading">

        <?php
        if ($this->params->get('show_print_view') > 0) {
            echo $this->page->print;
        }
        ?>
    </div>

    <?php
    //Social Networking begins here
    if ($this->admin_params->get('socialnetworking') > 0) {
        ?>
        <div id="bsms_share">
            <?php
            $social = getShare($this->detailslink, $row, $params, $this->admin_params);
            echo $this->page->social;
            ?>
        </div>
    <?php } //End Social Networking     ?>
    <?php
    if ($this->params->get('show_teacher_view') > 0) {
        $teacher_call = JView::loadHelper('teacher');
        $teacher = getTeacher($this->params, $row->teacher_id, $this->admin_params);
        echo $teacher;
        ?>
    </td>
    <td>
        <?php
    }
    if ($this->params->get('title_line_1') + $params->get('title_line_2') > 0) {
        $title_call = JView::loadHelper('title');
        $title = getTitle($this->params, $row, $this->admin_params, $this->template);
        echo $title;
    }
    ?>
</div><!-- header -->
<div>
    <table id="bsmsdetailstable" cellspacing="0">
        <thead>
            <?php
            if ($this->params->get('use_headers_view') > 0 || $this->params->get('list_items_view') < 1) {
                $headerCall = JView::loadHelper('header');
                $header = getHeader($row, $this->params, $this->admin_params, $this->template, $showheader = $params->get('use_headers_view'), $ismodule = 0);
                echo $header;
            }
            ?>
        </thead>
        <tbody>
            <?php if ($this->params->get('list_items_view') == 1) { ?> <!-- Media table listing view -->
                        <?php
                        require_once (JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_biblestudy' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'biblestudy.media.class.php');
                        $media = new jbsMedia();
                        $listing = $media->getMediaTable($row, $this->params, $this->admin_params);
                        echo $listing;
                        ?>
                <?php
            }
            if ($params->get('list_items_view') == 0) {
                ?><!-- List items view -->
                        <?php
                        $oddeven = 'bsodd';
                        $listing = getListing($row, $this->params, $oddeven, $this->admin_params, $this->template, $ismodule = 0);
                        echo $listing;
                        ?>
    <?php } ?>
        </tbody>
    </table>
    <?php
    echo $this->passage;
    if ($this->params->get('show_scripture_link') > 0) {
        ?>
        <div style="width:80%">
        <?php echo $this->article->studytext; ?>
        </div>
        <?php
    } else {
        echo $this->study->studytext;
    }
    ?>
    <?php
    if ($this->params->get('showrelated') == 2) {
        echo $this->related;
    }
    ?>
    <?php
    if ($this->params->get('showpodcastsubscribedetails') == 2) {
        echo $this->subscribe;
    }
    ?>
</div>