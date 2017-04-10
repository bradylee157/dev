<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$option = JRequest::getCmd('option');
JText::script('COM_PREACHIT_FIELDS_INVALID');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$user	= JFactory::getUser();
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/filepathedit/tmpl/submitbutton.js');
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );
?>
<form class ="form-validate" action="index.php" method="post" name="adminForm" id="adminForm">
<?php
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_FOLDERS_LEGEND' ), 'MAIN' );
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
                    <?php echo $field->input; ?>
                    <?php if ($field->name == 'jform[server]')
                    {echo PIHelpertooltips::server();}?>
                    <?php if ($field->name == 'jform[folder]')
                    {echo PIHelpertooltips::folder();}?>
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
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_FTPHEAD' ), 'FTP' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("ftptab") as $field):
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
echo $pane->startPanel( JText::_( 'COM_PREACHIT_ADMIN_AWS' ), 'AWS' );
?>
<div class="width-100">
<fieldset class="panelform">
<ul class="adminformlist">			
<?php
foreach ($this->form->getFieldset("awstab") as $field):
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
<input type="hidden" name="controller" value="filepathlist" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>


