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
$user    = JFactory::getUser();
$app = JFactory::getApplication();
$option = JRequest::getCmd('option');
$token = JUtility::getToken() ."=1";
?>
<script language="javascript" type="text/javascript">
submitbutton = function(task)
    {
    if (task == "")
                {
                return false;
                }
   else if (task == "migratess") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORTSS_WARNING');?>"))
        {Joomla.submitform(task);}
        } 
   else if (task == "migratejbs") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORTJBS_WARNING');?>"))
        {Joomla.submitform(task);}
        } 
    else if (task == "migratesm") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORTSM_WARNING');?>"))
        {Joomla.submitform(task);}
        } 
    else if (task == "restore") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_OVERWRITE_WARNING1');?>"))
        {Joomla.submitform(task);}
    }
    else if (task == "import") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_OVERWRITE_WARNING2');?>"))
        {Joomla.submitform(task);}
        } 
    else if (task == "resizeimages") 
    {
        if(confirm("<?php echo JText::_('COM_PREACHIT_BCKADMIN_RESIZE_WARNING');?>"))
        {Joomla.submitform(task);}
        } 
    else {Joomla.submitform(task);}
} 

function submiturl(url)
{
    window.open(url);
}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_PREACHIT_BCKADMIN_ADMIN_SETTINGS');?></legend>
<?php
    jimport('joomla.html.pane');
    $pane =& JPane::getInstance( 'sliders' );
    $tab =& JPane::getInstance( 'tabs' );
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_GENERAL' ), 'GENERAL' );
?>
<fieldset class="panelform">
<?php
foreach ($this->form->getFieldset("general") as $field):
        ?>
            <ul class="adminformlist">
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
            </ul>
        <?php
        endforeach;?>
    </fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_AUTOFILL_STUDY' ), 'AUTO-FILL STUDY' );
echo $tab->startPane( 'content-pane' );
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_AUTOFILL_MESSAGE_DETAILS' ), 'MESSAGE DETAILS' );
?>
<fieldset class="panelform">
<?php
foreach ($this->form->getFieldset("message") as $field):
        ?>
            <ul class="adminformlist">
            <?php
                // If the field is hidden, just display the input.
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
            </ul>
        <?php
        endforeach;?>
    </fieldset>
<?php
echo $tab->endPanel();
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_AUDIO_DETAILS' ), 'AUDIODETAILS' );
?>
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("audio") as $field):
        ?>
            <?php
                // If the field is hidden, just display the input.
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
<?php
echo $tab->endPanel();
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_VIDEO_DETAILS' ), 'VIDEODETAILS' );
?>
<fieldset class="panelform">
<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("video") as $field):
        ?>
            <?php
                // If the field is hidden, just display the input.
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
<?php
echo $tab->endPanel();
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_OTHERS_HEADER' ), 'VIDEODETAILS' );
?>
<fieldset class="panelform">
 <ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("other") as $field):
        ?>
            <?php
                // If the field is hidden, just display the input.
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
<?php
echo $tab->endPanel();
echo $tab->endPane();
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_ADMIN_FORMS' ), 'FORMS' );
echo $tab->startPane( 'content-pane' );
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_FR_FORM_MESSAGE' ), 'MESFORM' );
?>
<fieldset class="panelform">
    <ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("messageform") as $field):
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
<?php
echo $tab->endPanel();
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_FR_FORM_SERIES' ), 'SERIESFORM' );
?>
<fieldset class="panelform">
    <ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("seriesform") as $field):
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
<?php
echo $tab->endPanel();
echo $tab->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_FR_FORM_TEACHER' ), 'TEACHERFORM' );
?>
<fieldset class="panelform">
    <ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("teacherform") as $field):
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
<?php
echo $tab->endPanel();
echo $tab->endPane();
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_ADMIN_IMAGE' ), 'Image resize' );
?>
<fieldset class="panelform">
    <ul class="adminformlist">
<?php
foreach ($this->form->getFieldset("imgresize") as $field):
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
        <?php if (Tewebcheck::checkgd())   {?>
        <li>
            <label>
                <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMAGE_RESIZE');?><br />
                </label>
                <button type="button" onclick="submitbutton('resizeimages')">
                    <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMAGE_RESIZE_BUTTON');?> </button>
        </li>
        <?php } else { $app->enqueueMessage ( JText::_('COM_PREACHIT_BCKADMIN_NO_GD_LIBRARY'), 'error' );}?> 
    </ul>
    </fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_BCKADMIN_ADMIN_TASKS' ), 'Admin tasks' );
?>
<fieldset class="panelform">
<ul>
<li>
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_CHARACTERSET');?>
</label>
<?php echo $this->codeset;?><span style="padding: 0 0 0 10px;"><button type="button" onclick="submitbutton('codeset')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_CHANGE_DATABASE');?> </button></span>
</li>
<li>
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_UPDATETABLE');?><br />
<span style="padding: 0 0 0 10px; font-size: 80%;">
<?php echo $this->tableversion;?>
</span>
</label>
<button type="button" onclick="submitbutton('updatetable')">
<?php echo JText::_('COM_PREACHIT_BCKADMIN_UPDATE_TABLE');?> </button>
</li>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_RESET_CHECKED');?>
</label>
<button type="button" onclick="submitbutton('checkinall')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_RESET_CHECKED_BUTTON');?> </button>
</li>
<?php if ($this->allow)
{?>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_BACKUP');?>
</label>
<button type="button" onclick="submiturl('index.php?option=com_preachit&controller=admin&task=backupall&<?php echo $token;?>')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_BACKUP_BUTTON');?> </button>
 <?php echo PIHelpertooltips::backup();?>
</li>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_RESTORE');?>
</label>
<input type="file" name ="uploadfile" value="" /><button type="button" onclick="submitbutton('restore')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_RESTORE_BUTTON');?> </button><button type="button" onclick="submitbutton('import')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORT_BUTTON');?> </button>
 <?php echo PIHelpertooltips::restore();?>
</li>
<?php } ?>
<?php
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'sermon_sermons';
if (in_array($table, $tables))
{
?>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_MIGRATE_SERMONSPEAKER');?>
</label>
<button type="button" onclick="submitbutton('migratess')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORT_BUTTON');?> </button>
</li>
<?php } ?>
<?php
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'bsms_studies';
if (in_array($table, $tables))
{
?>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_MIGRATE_JOOMLABS');?>
</label>
<button type="button" onclick="submitbutton('migratejbs')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORT_BUTTON');?> </button>
</li>
<?php } ?>
<?php
$db    = & JFactory::getDBO();   
$tables = $db->getTableList();
$prefix = $db->getPrefix();
$table = $prefix.'submitsermon';
if (in_array($table, $tables))
{
?>
<li> 
<label>
<?php echo JText::_('COM_PREACHIT_BCKADMIN_MIGRATE_SERMON_MANAGER');?>
</label>
<button type="button" onclick="submitbutton('migratesm')">
 <?php echo JText::_('COM_PREACHIT_BCKADMIN_IMPORT_BUTTON');?> </button>
</li>
<?php } ?>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
</fieldset>
<!-- Footer -->
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="char" value="codeset" />
<input type="hidden" name="overwrite" value="0" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="admin" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>