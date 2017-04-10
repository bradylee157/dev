<?php
/**
 * Default
 * @package BibleStudy.Site
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

JHtml::_('behavior.multiselect');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>
<h2><?php echo JText::_('JBS_CMN_MESSAGES_LIST'); ?></h2>
<form action="<?php echo JRoute::_('index.php?option=com_biblestudy&view=messages'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_studytitle"><?php echo JText::_('JBS_CMN_STUDY_TITLE'); ?>: </label>
            <input type="text" name="filter_studytitle" id="filter_studytitle" value="<?php echo $this->escape($this->state->get('filter.studytitle')); ?>" title="<?php echo JText::_('JBS_CMN_FILTER_SEARCH_DESC'); ?>" />

            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_studytitle').value='';Joomla.submitbutton();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="clr"></div>
        <div class="filter-select fltlft">
            <select name="filter_book" class="inputbox" onchange="Joomla.submitbutton()">
                <option value=""><?php echo JText::_('JBS_CMN_SELECT_BOOK'); ?></option>
                <?php echo JHtml::_('select.options', $this->books, 'value', 'text', $this->state->get('filter.book')); ?>
            </select>
            <select name="filter_teacher" class="inputbox" onchange="Joomla.submitbutton()">
                <option value=""><?php echo JText::_('JBS_CMN_SELECT_TEACHER'); ?></option>
                <?php echo JHtml::_('select.options', $this->teachers, 'value', 'text', $this->state->get('filter.teacher')); ?>
            </select>
            <select name="filter_series" class="inputbox" onchange="Joomla.submitbutton()">
                <option value=""><?php echo JText::_('JBS_CMN_SELECT_SERIES'); ?></option>
                <?php echo JHtml::_('select.options', $this->series, 'value', 'text', $this->state->get('filter.series')); ?>
            </select>
            <select name="filter_message_type" class="inputbox" onchange="Joomla.submitbutton()">
                <option value=""><?php echo JText::_('JBS_CMN_MESSAGE_TYPE'); ?></option>
                <?php echo JHtml::_('select.options', $this->messageTypes, 'value', 'text', $this->state->get('filter.messageType')); ?>
            </select>
            <select name="filter_year" class="inputbox" onchange="Joomla.submitbutton()">
                <option value=""><?php echo JText::_('JBS_CMN_SELECT_YEAR'); ?></option>
                <?php echo JHtml::_('select.options', $this->years, 'value', 'text', $this->state->get('filter.year')); ?>
            </select>
            <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true); ?>
            </select>
        </div>
    </fieldset>
    <div>
        <h3> <?php echo $this->newlink; ?></h3>
    </div>
    <div class="clr"></div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <?php echo 'id'; ?>
                </th>
                <th width="8%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'study.published', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JBS_CMN_STUDY_DATE', 'study.studydate', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JBS_CMN_TITLE', 'study.studytitle', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JBS_CMN_SCRIPTURE', 'book.bookname', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JBS_CMN_TEACHER', 'teacher.teachername', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JBS_CMN_MESSAGE_TYPE', 'messageType.message_type', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="12">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <?php
        foreach ($this->items as $i => $item) :
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="center">
                    <?php echo $item->id; ?>
                </td>
                <td class="center">
                    <?php echo JHtml::_('jgrid.published', $item->published, $i, 'messages.', true, 'cb', '', ''); ?>
                </td>
                <td class="center">
                    <?php echo JHtml::_('date', $item->studydate, JText::_('DATE_FORMAT_LC4')); ?>
                </td>
                <td class="center">
                    <a href="<?php echo JRoute::_('index.php?option=com_biblestudy&view=message&layout=form&task=message.edit&a_id=' . (int) $item->id); ?>">
                        <?php echo $this->escape($item->studytitle); ?>
                    </a>
                </td>
                <td class="center">
                    <?php echo JText::_($this->escape($item->bookname)) . ' ' . $this->escape($item->chapter_begin) . ':' . $this->escape($item->verse_begin); ?>
                </td>
                <td class="center">
                    <?php echo $this->escape($item->teachername); ?>
                </td>
                <td class="center">
                    <?php echo $this->escape($item->messageType); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div>
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
