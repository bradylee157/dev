<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_('behavior.tooltip');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$option = JRequest::getCmd('option');
JText::script('COM_PREACHIT_FIELDS_INVALID');
$user	= JFactory::getUser();
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/podcastedit/tmpl/submitbutton.js');
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_PODCAST_LEGEND' ), 'MAIN' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("maininfo") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                elseif (!$user->authorise('core.edit.state', 'com_preachit') && $field->name == 'jform[published]'):
                            continue;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>   
                    <?php if ($field->name != 'jform[podpub]' ) {?> 
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[website]' || $field->name == 'jform[image]')
                    {echo PIHelpertooltips::nohttp();}?>
                     <?php if ($field->name == 'jform[description]')
                    {echo PIHelpertooltips::poddescription();}?>
                    <?php if ($field->name == 'jform[filename]')
                    {echo PIHelpertooltips::podfilename();}?>
                    <?php if ($field->name == 'jform[search]')
                    {echo PIHelpertooltips::separate();}?>
                    <?php if ($field->name == 'jform[menu_item]')
                    {echo PIHelpertooltips::podmenuitem();}?>
                    <?php if ($field->name == 'jform[language]')
                    {echo PIHelpertooltips::lang();}?>
                    <?php }
                    else {?>
                    <input id="podpub" type="text" readonly="readonly" size="100" style="border: 0px" value="<?php echo JHTML::Date($this->row->podpub, 'D, d M, Y');?>" name="podpub">
                    <?php }?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_EPISODEHEAD' ), 'EPISODES' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("episodes") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[menu_item]')
                    {echo PIHelpertooltips::podmenuitem();}?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_CONTENTHEAD' ), 'CONTENT' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("content") as $field):
        ?>
          <?php 
                if ($field->hidden):
                    echo $field->input;
                else:
                ?>
                <li>
                    <?php echo $field->label; ?>       
                    <?php echo $field->input; ?>
                </li>
                <?php
                endif;
           
            ?>
        <?php
        endforeach;?>
</ul>
</fieldset>
</div>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="controller" value="podcastlist" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>