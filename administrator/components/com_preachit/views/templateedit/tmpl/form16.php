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
$option = JRequest::getCmd('option');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/tooltips.php');
$user	= JFactory::getUser();
jimport('joomla.html.pane');
$blinds =& JPane::getInstance( 'tabs' );
$id = '';
JHtml::_('behavior.formvalidation');
$document =& JFactory::getDocument();      
$document->addScript(JURI::root() . 'administrator/components/com_preachit/views/templateedit/tmpl/submitbutton.js');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-100">
<fieldset class="adminform">
<?php
foreach ($this->tform->getFieldset("general") as $field):
        ?> <div class="pitempdetails">
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
            </ul> </div>
        <?php
        endforeach;?>
<?php 
echo $blinds->startPane( 'content-pane' );
if ($this->paramform->getFieldset("general"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_GENERAL' ), 'GENERAL' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("general") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("messagelist"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_MESSAGELIST' ), 'MESSAGELIST' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("messagelist") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("video"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_VIDEO' ), 'VIDEO' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("video") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("audio"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_AUDIO' ), 'AUDIO' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("audio") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("studypopup"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_POPUP' ), 'STUDYPOPUP' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("studypopup") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("audiopopup"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_AUDIOPOPUP' ), 'AUDIOPOPUP' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("audiopopup") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("videopopup"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_VIDEOPOPUP' ), 'VIDEOPOPUP' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("videopopup") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("text"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_TEXT' ), 'TEXT' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("text") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("generalmedia"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_GENMEDIA' ), 'GENERALMEDIA' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("generalmedia") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("serieslist"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_SERIESLIST' ), 'SERIESLIST' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("serieslist") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("series"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_SERIES' ), 'SERIES' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("series") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("teacherlist"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_TEACHERLIST' ), 'TEACHERLIST' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("teacherlist") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("teacher"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_TEACHER' ), 'TEACHER' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("teacher") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("ministrylist"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_MINISTRYLIST' ), 'MINISTRYLIST' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("ministrylist") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("ministry"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_MINISTRY' ), 'MINISTRY' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("ministry") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("asmedia"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_ASMEDIA' ), 'ASMEDIA' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("asmedia") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->paramform->getFieldset("taglist"))
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_TAGLIST' ), 'TAGLIST' );
?>
<fieldset class="panelform">
<?php
foreach ($this->paramform->getFieldset("taglist") as $field):
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
<?php echo $blinds->endPanel();
}
if ($this->temp == 'custom')
{
echo $blinds->startPanel( JText::_( 'COM_PREACHIT_TEMPLATE_PARAMS_CUSTOM' ), 'customtemp' );

$pane =& JPane::getInstance( 'tabs' );
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_MESSAGELIST' ), 'MESSAGELIST' );
?>
<input type="hidden" name="jform[id]" value="1" />
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('messortlists'); ?>
				<?php echo $this->form->getInput('messortlists'); ?>
<?php echo PIHelpertooltips::sortltemp();?>
</li>
<li><?php echo $this->form->getLabel('messagelist'); ?>
				<?php echo $this->form->getInput('messagelist'); ?>
<?php echo PIHelpertooltips::mltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_AUDIO' ), 'AUDIO' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('audio'); ?>
				<?php echo $this->form->getInput('audio'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_AUDIOPOPUP' ), 'AUDIOPOPUP' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('audiopopup'); ?>
				<?php echo $this->form->getInput('audiopopup'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_VIDEO' ), 'VIDEO' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('video'); ?>
				<?php echo $this->form->getInput('video'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_VIDEOPOPUP' ), 'VIDEOPOPUP' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('videopopup'); ?>
				<?php echo $this->form->getInput('videopopup'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_TEXT' ), 'TEXT' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('text'); ?>
				<?php echo $this->form->getInput('text'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_SERIESLIST' ), 'SERIESLIST' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('seriesheader'); ?>
				<?php echo $this->form->getInput('seriesheader'); ?>
</li>
<li><?php echo $this->form->getLabel('serieslist'); ?>
				<?php echo $this->form->getInput('serieslist'); ?>
<?php echo PIHelpertooltips::sltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_SERIES' ), 'SERIES' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('series'); ?>
				<?php echo $this->form->getInput('series'); ?>
<?php echo PIHelpertooltips::svheadtemp();?>
</li>
<li><?php echo $this->form->getLabel('seriessermons'); ?>
				<?php echo $this->form->getInput('seriessermons'); ?>
<?php echo PIHelpertooltips::mltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_TEACHERLIST' ), 'TEACHERLIST' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('teacherheader'); ?>
				<?php echo $this->form->getInput('teacherheader'); ?>
</li>
<li><?php echo $this->form->getLabel('teacherlist'); ?>
				<?php echo $this->form->getInput('teacherlist'); ?>
<?php echo PIHelpertooltips::tltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_TEACHER' ), 'TEACHER' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('teacher'); ?>
				<?php echo $this->form->getInput('teacher'); ?>
<?php echo PIHelpertooltips::tvheadtemp();?>
</li>
<li><?php echo $this->form->getLabel('teachersermons'); ?>
				<?php echo $this->form->getInput('teachersermons'); ?>
<?php echo PIHelpertooltips::mltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_MINISTRYLIST' ), 'MINISTRYLIST' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('ministryheader'); ?>
				<?php echo $this->form->getInput('ministryheader'); ?>
</li>
<li><?php echo $this->form->getLabel('ministrylist'); ?>
				<?php echo $this->form->getInput('ministrylist'); ?>
<?php echo PIHelpertooltips::minltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_MINISTRY' ), 'MINISTRY' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('ministry'); ?>
				<?php echo $this->form->getInput('ministry'); ?>
<?php echo PIHelpertooltips::minvheadtemp();?>
</li>
<li><?php echo $this->form->getLabel('ministryseries'); ?>
				<?php echo $this->form->getInput('ministryseries'); ?>
<?php echo PIHelpertooltips::minsertemp();?></li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_MEDIALIST' ), 'MEDIALIST' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('medialisthead'); ?>
				<?php echo $this->form->getInput('medialisthead'); ?>
<?php echo PIHelpertooltips::mediatemp();?>
</li>
<li><?php echo $this->form->getLabel('mediasermons'); ?>
				<?php echo $this->form->getInput('mediasermons'); ?>
<?php echo PIHelpertooltips::mltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'COM_PREACHIT_TEMP_TAGLIST' ), 'TAGLIST' );
?>
<fieldset class="adminform">
<ul class="adminformlist">
<li><?php echo $this->form->getLabel('taglist'); ?>
				<?php echo $this->form->getInput('taglist'); ?>
<?php echo PIHelpertooltips::mltemp();?>
</li>
</ul>
</fieldset>
<?php
echo $pane->endPanel();
echo $pane->endPane();
echo $blinds->endPanel();
} 
echo $blinds->endPane();?>
</fieldset>
</div>
<div style="text-align: center">
<?php $abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'administrator/components/com_preachit/lib/preachit.footer.php');?>
<?php echo PIfooter::footer();?></div>
<!-- /Footer -->
<input type="hidden" name="id" value="<?php echo $this->temp; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="controller" value="templates" />
<input type="hidden" name="task" value ="" />
<?php echo JHTML::_( 'form.token' ); ?>

</form>