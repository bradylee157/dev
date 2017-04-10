<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebcheck{

/**
	 * Method to check if user is on a mobile device
	 *
	 * @return	bolean
	 */

function checkmobile()
{
    jimport('teweb.checks.mobile_detect');
    
    $detect = new Mobile_Detect;

    // 1. Check for mobile environment.

    if ($detect->isMobile() && !$detect->isTablet()) {
    // Your code here.
        if(isset($_SESSION['isMobile']) && !$_SESSION['isMobile']){
        $_SESSION['isMobile'] = $detect->isMobile();
        }
        return true;
    }
    
	return false;
}

/**
     * Method to check if user is on tablet device
     *
     * @return    bolean
     */

function checktablet()
{
    jimport('teweb.checks.mobile_detect');
    
    $detect = new Mobile_Detect;

    // 1. Check for mobile environment.

    if ($detect->isTablet()) {
        return true;
    }
    
    return false;
}

/**
     * Method to check if user agent only supports html5
     * @return   boolean
     */   

function checkhtml5()
{
    $check = false;
    if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
            $check = true;
        } else if( stristr($_SERVER['HTTP_USER_AGENT'],'ipod') || strstr($_SERVER['HTTP_USER_AGENT'],'ipod') ) {
            $check = true;
        } else if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') || strstr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
            $check = true;
        } 
    
    return $check;
}

/**
     * Method to check if user agent is bot or not
     * @return   boolean
     */   

function is_bot(){
    $botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
    "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
    "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
    "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
    "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
    "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
    "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
    "Butterfly","Twitturls","Me.dium","Twiceler");
 
    foreach($botlist as $bot){
        if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
        return true;    // Is a bot
    }
 
    return false;    // Not a bot
}

/**
     * Method to get Joomla version
     * @return    string
     */

function getJversion()
{
$vers = new JVersion();
$version = substr($vers->getShortVersion(), 0, 3);
return $version;
}

/**
     * Method to check access
     * @param string $permission the permission to check for
     * @param string $component the component to check for
     * @return    bolean
     */    
    
function checksignup($permission, $component)
{
    $user    = JFactory::getUser();
    if ($user->authorise($permission, $component))
    {return true;}
    else {return false;}
}

/**
     * Method to check if the user needs to be directed to a 403 page or redirected to the login page
     * @param string $permission the permission to check for
     * @param string $component the component to check for
     * @return    bolean
     */    
    
function check403($params = null)
{
    $user    = JFactory::getUser();
    $itemid = null;
    if ($user->id > 0)
    {return JError::raiseError('403', JText::_('LIB_TEWEB_403_ERROR'));}
    else
    {
        $app = JFactory::getApplication();
        if ($params)
        {
            $itemid = $params->get('loginitem', '');
        }
        
        if (!$itemid)
        {
            // get Itemid if available
            $link = 'index.php?option=com_users&view=login';
            $item = null;
            $db =& JFactory::getDBO();
            $query = "SELECT ".$db->nameQuote('id')."
            FROM ".$db->nameQuote('#__menu')."
            WHERE published = 1 AND".$db->nameQuote('link')." LIKE ".$db->Quote('%'.$db->getEscaped($link, true).'%', false).";";
            $db->setQuery($query);
            $menuitem = $db->loadResult();
            if ($menuitem > 0)
            {$item = 'Itemid='.$menuitem;
            $link = 'index.php?'.$item;}
        }
        else {
            $item = 'Itemid='.$itemid;
            $link = 'index.php?'.$item;
            } 
        $app->Redirect($link);
    }
}

/**
     * Method to get php version
     * @return    array
     */    
     
function checkphp()
{
$phpversion = phpversion();
$versno = explode('.', $phpversion);
return $versno;
}

/**
     * Method to check if curl is enabled
     * @return    array
     */    
     
function checkcurl()
{
if  (!in_array  ('curl', get_loaded_extensions()))
{$curl = false;}
else {$curl = true;}
return $curl;
}

/**
     * Method to check if gd is enabled
     * @return    array
     */   

function checkgd()
{
if (!extension_loaded('gd') && !function_exists('gd_info'))
{$gd = false;}
else {$gd = true;}
return $gd;
}

/**
     * Method to process jform name down to element name
     * @param string $jformname name to process
     * @return    string
     */ 

function gettvalue($jformname)
{
    $name = str_replace('jform', '', $jformname);
    $name = str_replace(']', '', $name);
    $name = str_replace('[', '', $name);
    return $name;
}

/**
     * Method to check if tab should be shown
     * @param array $form form values
     * @param array $fieldset section name
     * @param array $hide elements to hide
     * @return    boolean
     */ 

function showtab($form, $fieldset, $hide)
{
    foreach ($form->getFieldset($fieldset) as $field)
    {
        if (!in_array(Tewebcheck::gettvalue($field->name), $hide))
        {return true;}
    }
    return false;  
}

/**
     * Method to remove common words from search string
     * @param string $input string to check
     * @return    string
     */ 

function removeCommonWords($input)
{
     
    // EEEEEEK Stop words
    $commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
     
    return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
}

/**
     * Method to check cc consent cookie
     * @param string $cookie cookie to check
     * @return    boolean
     */ 

function checkccconsent($cookie)
{
    if(isset($_COOKIE['cc_'.$cookie]) &&
    ($_COOKIE['cc_'.$cookie] == "no" || $_COOKIE['cc_'.$cookie] == "never"))
    {
    //the user has not consented, return
    return false;
    }
    return true;
}

/**
     * Method to check cc consent cookie
     * @param string $cookie cookie to check
     * @return    boolean
     */ 

function checkcookieset($cookie)
{
    if(isset($_COOKIE[$cookie]))
    {
    //the user has not consented, return
    return true;
    }
    return false;
}

/**
     * Method to check a boolean value from the database
     * @param string $table table name to search in
     * @param int $id id of table to search
     * @return    boolean
     */ 

function checkccneeded($table, $id)
{
    $db = JFactory::getDBO();
    $query = "
    SELECT ".$db->nameQuote('cookieconsent')."
    FROM ".$db->nameQuote('#__'.$table)."
    WHERE ".$db->nameQuote('id')." = ".$db->quote($id).";
     ";
     $db->setQuery($query);
     $value = $db->loadResult();
    
    return $value;
}

/**
     * Method to remove part of the code between {ccconsent} tags or just remove the tags
     * @param string $code the code to test and work on
     * @param boolean $remove set to true to remove content between the tags
     * @return    boolean
     */ 

function removeccconsent($code, $remove)
{
    if ($remove)
    {
        $pattern = "/{ccconsent}(.*?){\/ccconsent}/s";

        preg_match_all($pattern, $code, $matches);
        foreach( $matches[1] as $name )
        {
            $code = str_replace($name, '', $code);
        }
    }
    $code = str_replace('{ccconsent}', '', $code);
    $code = str_replace('{/ccconsent}', '', $code);
    return $code;
    
}

}
?>