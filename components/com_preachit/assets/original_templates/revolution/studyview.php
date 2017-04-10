<?php
/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$params = PIHelperadditional::getPIparams();
$Mparams =& $app->getParams();
// set heading vaiables

$show = $Mparams->get('show_page_heading', 1);
$enttitle = $Mparams->get('page_heading', '');
$pgtitle = $Mparams->get('page_title', '');
if ($enttitle)
{$pgheader = $enttitle;}
else {$pgheader = $pgtitle;} 
?>

<?php /** Begin Page Title **/ if ($show) : ?>
        <h1 class="title">
            <?php echo $pgheader; ?>
        </h1>
<?php /** End Page Title **/ endif; ?>

<!-- display the sortlists -->

<?php

if  ($this->mode == 'listen')
    {
        echo $this->loadTemplate('audioview');
    }
elseif ($this->mode == 'watch')
    {
        echo $this->loadTemplate('videoview');
    }
elseif ($this->mode == 'read')
    {
        echo $this->loadTemplate('textview');
    }
elseif ($this->message->audioplayer && !$this->message->videoplayer)
    {
        echo $this->loadTemplate('audioview');
    }
elseif (!$this->message->audioplayer && $this->message->videoplayer)
    {
        echo $this->loadTemplate('videoview');
    }
else
    {
        if ($params->get('mediapriority', 1) == 1)
        {echo $this->loadTemplate('audioview');}
        elseif ($params->get('mediapriority', 1) == 2)
        {echo $this->loadTemplate('videoview');}  
    }