<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('teweb.file.functions');
jimport('teweb.checks.standard');
$lang = & JFactory::getLanguage();
$lang->load('lib_teweb', JPATH_SITE);
class Tewebcomments{

/**
     * Method to build inbuilt comments form and list
     * @param    array $row info for the article
     * @param    string $option component name
     * @param    array $params plugin params
     * @return    string
     */ 
    
public function getteinbuilt($row, $option, $params)
{
    $document =& JFactory::getDocument();
    $user =& JFactory::getUser();
    $db =& JFactory::getDBO();
    if ($option == 'com_preachit')
    {$table = '#__picomments';
    $field = 'study_id';}
    if ($option == 'com_melody')
    {$table = '#__melcomments';
    $field = 'song_id';}
    // get comments from database
    
    $query = "SELECT full_name, comment_date, comment_text FROM ".$table." WHERE ".$field." = ".$db->quote($row->id)." AND published = 1";
    $db->setQuery($query);
    $commentlist = $db->loadObjectList();

    $comments = Tewebcomments::gettecommentlist($commentlist);
    
    // test whether user can add comments. If no then don't load form
    
    $groups = $user->authorisedLevels();
    $access = $params->get('access', 1);
    if (in_array($access, $groups))
    {
        $commentsJs = Tewebcomments::gettecommentsJS($field, $option, $params);
        $document->addScriptDeclaration($commentsJs);
        $commentform = Tewebcomments::gettecommentform($row, $option, $field, $params);
    }
    else {$commentform = null;}

    $html = $comments.$commentform;

    return $html;
}

/**
     * Method to build inbuilt comments list
     * @param    array $commentlist data for the comment list
     * @return    string
     */ 

public function gettecommentlist($commentlist, $ajax = 0)
{
    $i = 0;
    $html = '';
    foreach ($commentlist as $comment)
    {
        if ($i == 0)
        {$html .= '<h3 class="commentsheader">'.JText::_('PLG_TECOMMENTS_COMMENT_HEADER').'</h3>';}
        $html1 = '';
        $text = Tewebcomments::cleancommenttext(htmlspecialchars($comment->comment_text));
        $html1 = '<div class="comment-container">'
                    .'<div class="commentinfo">'
                    .'<h5>'.JText::_('PLG_TECOMMENTS_POSTED_ON').'</h5>'
                    .'<div class="comment-date">'.JHTML::Date($comment->comment_date).'</div>'
                    .'<h5>'.JText::_('PLG_TECOMMENTS_POSTED_BY').'</h5>'
                    .'<div class="comment-name">'.htmlspecialchars($comment->full_name).'</div>'
                    .'</div>'
                    .'<div class="comment">'.$text.'</div>'
                    .'<div class="clr"></div>'
                    .'</div>';
        
        $html = $html.$html1;
        $i++;
    }
    
    if ($ajax != 1)
    {
        $html = '<div id="tecommentslist" class="tecommentslist">'.$html.'</div>';
    }
    
    return $html;

}

/**
     * Method to get comment form
     * @param    array $row info for the article
     * @param    string $option component name
     * @param    string $fieldname field name to attach the comment to
     * @param    array $params plugin params
     * @return    string
     */ 

private function gettecommentform($row, $option, $fieldname, $params)
{
    $user =& JFactory::getUser();
    $item = JRequest::getVar('Itemid', '', 'GET', 'INT');    
    $view = JRequest::getVar('view', '');
    $lang = & JFactory::getLanguage();
    $lang->load($option);
    $escape = "\'";
    $recaptcha = null;
    $html = null;
    
    // get model
    jimport('teweb.messages.commentsmodel');
    $form = Modelcomment::getForm();
    $data = Modelcomment::getdata();


    $html .= '<form id="tecommentsform" class="tecommentsform" name="tecommentform" action="index.php" method="post">'
            .'<h3 class="commentsheader">'.JText::_('PLG_TECOMMENTS_FORM_HEADER').'</h3>'
            .'<div id="tecomments-message" class="hidden"></div>';
    $html .= '<div class="width-100"><fieldset class="adminform"><ul class="adminformlist">';  
    foreach ($form->getFieldset("maininfo") AS $field) {

                if ($field->hidden) {
                    $html .= $field->input;
                }
                else {
                    
                if ($field->name == 'jform[comment_text]')
                {
                    $html .= '<script type="text/javascript">document.write(\'<li class="bbcode">'
            .'<a id="bbcode-b" class="bbcode-b" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[b][/b]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_BOLD').'"></a>'
            .'<a id="bbcode-i" class="bbcode-i" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[i][/i]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_ITALIC').'"></a>'
            .'<a id="bbcode-u" class="bbcode-u" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[u][/u]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_UNDERLINED').'"></a>'
            .'<a id="bbcode-p" class="bbcode-p" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[p][/p]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_PARAGRAPH').'"></a>'
            .'<a id="bbcode-url" class="bbcode-url" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[url=http://linkhere.com]Link text[/url]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_URL').'"></a>'
            .'<a id="bbcode-quote" class="bbcode-quote" style="display: block;" onClick="document.tecommentform.comment_text.value+='.$escape.'[quote][/quote]'.$escape.'; return false;" href="#" title="'.JText::_('LIB_TEWEB_BBCODE_QUOTE').'"></a>'
            .'</li>\')</script><div class="clr"></div>';
                }
                    
                $html .= '<li>'.$field->label.$field->input.'</li>';
                $html .= '<div class="clr"></div>';
                }

    }
    $html .= '</ul></fieldset></div>';       
    $html .= '<input type="hidden" id="'.$fieldname.'" name="'.$fieldname.'" value="'. $row->id.'" />'
            .'<input type="hidden" id="view" name="view" value="'. $view.'" />'
            .'<input type="hidden" id="task" name="task" value="comment" />'
            .'<input type="hidden" id="option" name="option" value="'.$option.'" />'
            .'<input type="hidden" id="Itemid" name="Itemid" value="'.$item.'" />'.JHTML::_( 'form.token' )
            .'<script type="text/javascript">document.write(\'<a class="tecomment-button" href="#" onclick="submittecomment(); return false;">'. JText::_( 'TE_TOOLBAR_SUBMIT' ).'</a>\');</script>'
            .'<noscript><input type="submit" class="button" id="button" value="Submit" /></noscript>'
            .'<img id="tecomments-revolve" style="display:none;" src="libraries/teweb/messages/css/ajax-loader.gif">'
            .'</form>';

            return $html;
}

/**
     * Method to get comment form javascript
     * @param    string $field field name to attach the comment to
     * @param string $option component name
     * @param array $params plugin params
     * @return    string
     */ 

private function gettecommentsJS($field, $option, $params)
{
    if ($option == 'com_preachit')
    {$controller = 'studylist';}
    if ($option == 'com_melody')
    {$controller = 'songlist';}
    $recaptcha = null;
    $recaptchaparams = null;
    $recaptchareload= null;
    if ($params->get('recaptcha',0) == 1)
    {$recaptcha = 'var recaptcha = document.getElementById("recaptcha_response_field").value;
        var recaptchac = document.getElementById("recaptcha_challenge_field").value;';
    $recaptchaparams = ', recaptcha_response_field: recaptcha, recaptcha_challenge_field: recaptchac';
    $recaptchareload = 'javascript:Recaptcha.reload();';}
    
    JHTML::_( 'behavior.mootools' );
    $js = 'function submittecomment() 
    {
        var name = document.getElementById("jform_full_name").value;
        var email = document.getElementById("jform_email").value;
        var comment = document.getElementById("jform_comment_text").value;'

        .'if (!name)
        {document.getElementById("jform_full_name").setAttribute("class", "text_area noentry");
        alert ("'.JText::_('PLG_TECOMMENTS_NO_NAME').'"); return false;}
        else {document.getElementById("jform_full_name").setAttribute("class", "text_area");}
        if (!email)
        {document.getElementById("jform_email").setAttribute("class", "text_area noentry");
        alert ("'.JText::_('PLG_TECOMMENTS_NO_EMAIL').'"); return false;}
        else {document.getElementById("jform_email").setAttribute("class", "text_area");}
        if (!comment)
        {document.getElementById("jform_comment_text").setAttribute("class", "text_area noentry");
        alert ("'.JText::_('PLG_TECOMMENTS_NO_COMMENT').'"); return false;}
        else {document.getElementById("jform_comment_text").setAttribute("class", "text_area");}
    
        if (checkemail(email))
        {
            var params = $("tecommentsform").toQueryString().parseQueryString();
            var revolve = document.getElementById("tecomments-revolve").src;
            document.getElementById("tecomments-message").innerHTML = \'<div style="text-align: center;"><img style="margin: 0 50%;" src="\'+revolve+\'"></div>\';
            var container = new Element(\'div\', { \'class\': \'comtempcontainer\',
                                         \'styles\': { \'display\': \'none\'
                                                   }    });   
            url = "'.JURI::ROOT().'index.php?option='.$option.'&controller='.$controller.'&ajax=1&tmpl=component&format=raw"                                        
            var XHRCheckin = new Request.HTML({
            url: url, 
            method: \'post\',
            data: params,
            update: container,
            onComplete: function() {
                var response = container.innerHTML;
                if (response.indexOf("<!-- **comment message break** -->") != -1)
                {
                    var html = response.split("<!-- **comment message break** -->");
                    document.getElementById("tecomments-message").innerHTML = html[0];
                    document.getElementById("tecomments-message").setAttribute("class", "showmessage");
                    document.getElementById(\'tecommentslist\').innerHTML = document.getElementById(\'tecommentslist\').innerHTML+html[1];
                    document.getElementById("comment_text").value = "";
                }
                else
                {
                    document.getElementById("tecomments-message").innerHTML = response;
                    document.getElementById("tecomments-message").setAttribute("class", "showmessage error");
                }
                if(typeof Recaptcha.reload == "function") {
                Recaptcha.reload();
                }
            }
        }).send();
        return false;
        } 
        else {return false;}
    }
    
    function checkemail(email) 
    {
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
        if (filter.test(email))
        testresults=true
        else{
        alert("'.JText::_('PLG_TECOMMENTS_INVALID_EMAIL').'")
        testresults=false
        }
        return (testresults)
    }';
    return $js;
}

/**
     * Method to send notification email for inbuilt comments
     * @param    string $name name of user submitting comment
     * @param    string $comment text of the comment
     * @param    string $article name of the article the comment is attached to
     * @return    string
     */ 

public function sendtecommentnotify($name, $comment, $article, $params)
{
    jimport('teweb.messages.email');
    $email = false;
    if ($params->get('notify', 0) == 1)
    {
        $details = Tewebemail::initialise();
        $html = '<p>'.JText::_('PLG_TECOMMENTS_EMAIL_NOTIFY').'</p>';
        $html .= '<p>'.JText::_('PLG_TECOMMENTS_ARTICLE').' '.$article.'</p>';
        $html .= '<p>'.JText::_('PLG_TECOMMENTS_NAME').' '.$name.'</p>';
        $html .= '<p>'.JText::_('PLG_TECOMMENTS_COMMENT').' '.$comment.'</p>';
        $details->text = $html;
        $details->subject = JText::_('PLG_TECOMMENTS_NOTIFY_SUBJECT');
        $recipient = $params->get('emailaddress', '');
        if (!$recipient)
        {$details->emails[0] = $details->sender;}
        else {$details->emails[0] = $recipient;}
        $email = Tewebemail::sendemail($details);
    }
    return $email;
}

/**
     * Method to find and replace bb code in comment text
     * @param    string $text comment text
     * @return    string
     */ 

public function cleancommenttext($text)
{
    $search = array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[p]','[/p]', '[quote]', '[/quote]');
    $replace = array('<strong>','</strong>','<i>','</i>','<u>','</u>','<p>','</p>', '<div class="quote">', '</div>');
    $text = str_replace($search, $replace , $text);
    preg_match_all('/\[url=(.*)\[\/url\]/U', $text, $matches);
    if (is_array($matches[1]))
    {
        foreach ($matches[1] AS $match)
        {
            $link_text = null;
            $link = null;
            $linkinfo = explode(']', $match);
            if (isset($linkinfo[0]))
            {$link = $linkinfo[0];}
            if (isset($linkinfo[1]))
            {$link_text = $linkinfo[1];}
            $href = '<a href="'.$link.'">'.$link_text.'</a>';
            $text = str_replace('[url='.$link.']'.$link_text.'[/url]', $href, $text);
        }  
    }
    return $text;
}

/**
     * Method to get jcomments text
     * @param    array $row info for the article
     * @param    string $option component name
     * @return    string
     */ 

public function gettejcomments($row, $option)
{
    $app = JFactory::getApplication();
    $html = '';
    if ($option == 'com_preachit')
    {$name = $row->study_name;}
    if ($option == 'com_melody')
    {$name = $row->name;}
    $jcomments = $app->getCfg('absolute_path') . '/components/com_jcomments/jcomments.php';
    if (file_exists($jcomments)) {
    require_once($jcomments);
       $html = JComments::showComments($row->id, $option, $name);
    }  
    return $html;
}

/**
     * Method to get jomcomments text
     * @param    array $row info for the article
     * @param    string $option component name
     * @return    string
     */

public function gettejomcomments($row, $option)
{
    $html = '';
    include_once( JPATH_PLUGINS . DS . 'content' . DS . 'jom_comment_bot.php' );
    $html = jomcomment($row->id, $option);    
    return $html;
}

/**
     * Method to get intensedebate comments
     * @return    string
     */

public function getteintensedebate($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage)
{           
    $output = null;  
    $ccconsent = true;  
    // return if no cookie consent
    if (Tewebcheck::checkcookieset('cc_comments'))
    {
        if (!Tewebcheck::checkccconsent('comments'))
        {    
            //the user has not consented, return
            $ccconsent = false;
        }
    }
    else {
        if (!Tewebcheck::checkccconsent('social'))
        {    
            //the user has not consented, return
            $ccconsent = false;
        }
    }
    if ($ccconsent)
    {
            $output = '<script type="text/javascript">
            var idcomments_acct = "{account}";var idcomments_post_id = "{post-id}";var idcomments_post_url = "{post-url}";
            </script>
            <span id="IDCommentsPostTitle" style="display:none"></span>
            <script type="text/javascript" src="http://www.intensedebate.com/js/genericCommentWrapperV2.js"></script>';
    }
    else {$output = '<div class="ccconsent-needed">'.JText::_('LIB_TEWEB_COOKIE_CONSENT_NEEDED').'</div>';}
    $search     = array('{subdomain}','{post-id}','{post-url}','{post-path}','{devcode}','{te-icon}','{account}');
    $replace    = array($subdomain,$postid,$url,$path,$devcode,$commenticon,$account);
    $output = str_replace($search, $replace , $output);
    return $output;
}

/**
     * Method to get jcomments text
     * @return    string
     */

public function gettedisqus($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage)
{    
    $output = null;    
    $ccconsent = true;
    // return if no cookie consent
    if (Tewebcheck::checkcookieset('cc_comments'))
    {
        if (!Tewebcheck::checkccconsent('comments'))
        {    
            //the user has not consented, return
            $ccconsent = false;
        }
    }
    else {
        if (!Tewebcheck::checkccconsent('social'))
        {    
            //the user has not consented, return
            $ccconsent = false;
        }
    }
    $document       =& JFactory::getDocument();
    if ($ccconsent)
    {
        
    $output = '<div id="disqus_thread"></div><script type="text/javascript">
             /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
             var disqus_shortname = \'{subdomain}\'; // required: replace example with your forum shortname
             {devcode}
             var disqus_identifier = "{post-id}";

             /* * * DON\'T EDIT BELOW THIS LINE * * */
             (function() {
              var dsq = document.createElement(\'script\'); dsq.type = \'text/javascript\'; dsq.async = true;
              dsq.src = \'http://\' + disqus_shortname + \'.disqus.com/embed.js\';
              var disqus_developer = 1; // developer mode is on
              (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dsq);
              })();
              </script><noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
              <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>';}
              
    else {$output = '<div class="ccconsent-needed">'.JText::_('LIB_TEWEB_COOKIE_CONSENT_NEEDED').'</div>';}
    $search     = array('{subdomain}','{post-id}','{post-url}','{post-path}','{devcode}','{te-icon}','{account}');
    $replace    = array($subdomain,$postid,$url,$path,$devcode,$commenticon,$account);
    $output = str_replace($search, $replace , $output);
    return $output;
}

/**
     * Method to get facebook comments text
     * @param    array $row info for the article
     * @param    array $params plugin params
     * @param    string $option component name
     * @return    string
     */

public function gettefacebookcomments($row, $params, $option)
{
    $item = JRequest::getVar('Itemid', '', 'GET', 'INT');    
    $view = JRequest::getVar('view', '');
    $width = $params->get('fbcomwidth', 300);    
    $no = $params->get('fbcomno', 4);
    $cs = $params->get('fbcomcs', 'light');
    $slug = $row->id.':'.$row->alias;        
    $site = JURI::BASE();
    $parse_url = parse_url($site);
    $base = $host = 'http://'.$parse_url['host'];
    $link = $base.JRoute::_('index.php?option='.$option.'&view='.$view.'&id='.$slug.'&Itemid='.$item);
    $html = '<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                <fb:comments href="'.$link.'" num_posts="'.$no.'" width="'.$width.'" colorscheme="'.$cs.'"></fb:comments>';
    return $html;
}

/**
     * Method to check tecomments installed
     * @return    boolean
     */

public function checktecomments()
{
    $db =& JFactory::getDBO();
    $query = "SELECT ".$db->nameQuote('extension_id')."
    FROM ".$db->nameQuote('#__extensions')."
    WHERE ".$db->nameQuote('element')." = ".$db->quote('tecomments')." AND ".$db->nameQuote('enabled')." = ".$db->quote(1).";
  "; 
    $db->setQuery($query);
    $result = $db->loadResult();
    $file = JPATH_PLUGINS . DS . 'teweb' . DS . 'tecomments' . DS . 'tecomments.php';

    if ($result > 0 && Tewebfile::checkfile($file, 1))
    {return $file;}
    else {return false;}
}

/**
     * Method to get comment count from inbuilt comment engine
     * @param    array $row info for the article
     * @param    string $option component name
     * @param    string $path link to the media page
     * @return    string
     */ 
    
public function getteinbuiltcount($row, $option, $path)
{
    $db =& JFactory::getDBO();
    if ($option == 'com_preachit')
    {$table = '#__picomments';
    $field = 'study_id';}
    if ($option == 'com_melody')
    {$table = '#__melcomments';
    $field = 'song_id';}
    // get comment count from database

    $query = "SELECT count(*) FROM ".$table." WHERE ".$field." = ".$db->quote($row->id)." AND published = 1";
    $db->setQuery($query);
    $count = intval($db->loadResult());
    $commentlink = '<div class="te-commentcount te-icon"><a href="'.$path.'" title="'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT_TITLE').'">'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT').'</a></div>';
    $count = str_replace('{comment_no}', $count, $commentlink);
    return $count;
}

/**
     * Method to get comment count from jcomments comment engine
     * @param    array $row info for the article
     * @param    string $option component name
     * @param    string $path link to the media page
     * @return    string
     */ 
    
public function gettejcommentscount($row, $option, $path)
{
    $db =& JFactory::getDBO();

    // get comment count from database

    $query = "SELECT count(*) FROM #__jcomments WHERE object_group = ".$db->quote($option)." AND object_id = ".$db->quote($row->id)." AND published = 1";
    $db->setQuery($query);
    $count = intval($db->loadResult());
    $commentlink = '<div class="te-commentcount te-icon"><a href="'.$path.'" title="'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT_TITLE').'">'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT').'</a></div>';
    $count = str_replace('{comment_no}', $count, $commentlink);
    return $count;
}

/**
     * Method to get comment count from jomcomments comment engine
     * @param    array $row info for the article
     * @param    string $option component name
     * @param    string $path link to the media page
     * @return    string
     */ 
    
public function gettejomcommentscount($row, $option, $path)
{
    $db =& JFactory::getDBO();

    // get comment count from database

    $query = "SELECT count(*) FROM #__jomcomment WHERE option = ".$db->quote($option)." AND contentid = ".$db->quote($row->id)." AND published = 1";
    $db->setQuery($query);
    $count = intval($db->loadResult());
    $commentlink = '<div class="te-commentcount te-icon"><a href="'.$path.'" title="'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT_TITLE').'">'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT').'</a></div>';
    $count = str_replace('{comment_no}', $count, $commentlink);
    return $count;
}

/**
     * Method to get comment count from facebook comment engine
     * @param    array $row info for the article
     * @param    string $option component name
     * @return    string
     */ 
    
public function gettefacebookcommentscount($row, $path)
{
    $count = 0;
    $url = $base.$path;

    $request_url ="https://graph.facebook.com/?ids=" .$url;
    $requests = file_get_contents($request_url);
    if ($requests)
    {
        $result = json_decode($requests);
        if (isset($result->{$url}->comments))
        {$count = $result->{$url}->comments;}
    }
    $commentlink = '<div class="te-commentcount te-icon"><a href="'.$path.'" title="'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT_TITLE').'">'.JText::_('PLG_TECOMMENTS_COMMENT_COUNT').'</a></div>';
    $count = str_replace('{comment_no}', $count, $commentlink);
    return $count;
}

/**
     * Method to get comment count from disqus comments
     * @return    string
     */ 
    
public function gettedisquscount($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage)
{
    $output = null;    
    // return if no cookie consent
    if (Tewebcheck::checkcookieset('cc_comments'))
    {
        if (!Tewebcheck::checkccconsent('comments'))
        {    
            //the user has not consented, return
            return $output;
        }
    }
    else {
        if (!Tewebcheck::checkccconsent('social'))
        {    
            //the user has not consented, return
            return $output;
        }
    }
    $document =& JFactory::getDocument();
    $output = "<div class=\"te-commentcount{te-icon}\"><a class=\"tecomment-counter\" href=\"{post-url}#disqus_thread\" data-disqus-identifier=\"{post-id}\" title=\"Comments\">Comments</a></div>\n";
    if (!defined('TECOMMENT_COUNT'))
    {
    $headscript = "
    <script type=\"text/javascript\" class=\"cc-onconsent-social\">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '{subdomain}'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
    </script>";
    $headscript = str_replace("{subdomain}", $subdomain, $headscript);
    $document->addCustomTag($headscript);
    define('TECOMMENT_COUNT', true);
    }
    $search     = array('{subdomain}','{post-id}','{post-url}','{post-path}','{devcode}','{te-icon}','{account}');
    $replace    = array($subdomain,$postid,$url,$path,$devcode,$commenticon,$account);
    $output = str_replace($search, $replace , $output);
    return $output;
}

/**
     * Method to get intensedebate comments
     * @return    string
     */

public function getteintensedebatecount($subdomain,$postid,$url,$path,$devcode,$commenticon,$account, $commentpage)
{
    $output = null;    
    // return if no cookie consent
    if (Tewebcheck::checkcookieset('cc_comments'))
    {
        if (!Tewebcheck::checkccconsent('comments'))
        {    
            //the user has not consented, return
            return $output;
        }
    }
    else {
        if (!Tewebcheck::checkccconsent('social'))
        {    
            //the user has not consented, return
            return $output;
        }
    }
    
    $output = '<script type="text/javascript" class="cc-onconsent-social">
            var idcomments_acct = "{account}";var idcomments_post_id = "{post-id}";var idcomments_post_url = "{post-url}";
            </script>
            <div class="te-commentcount{te-icon}">            
            <script type="text/javascript" src="http://www.intensedebate.com/js/genericLinkWrapperV2.js"></script>
            </div>';
    $search = array('{subdomain}', '{post-id}', '{post-url}', '{post-path}', '{devcode}', '{te-icon}', '{account}');
        $replace = array($subdomain, $postid, $url, $path, $devcode, $commenticon, $account);

        $output = str_replace($search, $replace, $output);
        return $output;
}
}