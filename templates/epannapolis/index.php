<?php defined('_JEXEC') or die('Restricted access'); JHtml::_('behavior.framework', true); ?>
<!DOCTYPE html>
<html lang="en"><head>
<jdoc:include type="head" />
<link rel="icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon"> 
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon"> 
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/normalize.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/grid.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/menus.css" type="text/css" />

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/includes/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/includes/modernizr.min.js"></script>

<?php  if ($this->countModules('homeslide')): ?>
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/jScrollPane.css" type="text/css" />
  <script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/includes/jquery.mousewheel.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/includes/jScrollPane.js"></script>
<?php endif; ?>

<script type="text/javascript">

jQuery.noConflict();
(function($) 
{ 
  $(document).ready(function(){
    $('.scroll-pane').jScrollPane({verticalDragMaxHeight: 20,showArrows: true,});    
    $("#mainnav li").hover(
      function(){ $("ul", this).fadeIn("fast"); }, 
      function() { } 
    );
    if (document.all) {
      $("#mainnav ul.menu li").hoverClass("sfHover");
    }
    });
    $.fn.hoverClass = function(c) {
    return this.each(function(){
      $(this).hover(
        function() { $(this).addClass(c); },
        function() { $(this).removeClass(c); }
      );
    });
  };        
})(jQuery);


</script>
  
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84648681-1', 'auto');
  ga('send', 'pageview');

</script>  

</head>
<body>


<header id="header" role="banner" class="container row">
  <div id="header-inner">
    <div id="logo"><a href="<?php echo $this->baseurl ?>"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/logo2.jpg" /></a></div>
    <div id="search" role="search"><jdoc:include type="modules" name="search" /></div>
    <nav id="mainnav" role="navigation"><jdoc:include type="modules" name="mainmenu" /></nav>
  </div>
</header>
<main id="main" role="main" class="container row">
  <section id="content">
      <?php 
      if ($this->countModules('homeslide')) {
        $contentClass = 'home';
      } elseif ($this->countModules('right')) {
        $contentClass = 'threeCol';
      } else {
        $contentClass = 'twoCol';
      }
      if ($this->countModules('left')) : ?>
          <aside id="left" class="<?php echo $contentClass; ?>">
          <?php  if ($contentClass == 'home'): ?>
                    <jdoc:include type="modules" name="homeevents" style="homeEvents" />                                         
          <?php endif; ?>                        
                  <jdoc:include type="modules" name="left" style="xhtml" />                     
                </aside>
      <?php endif; ?> 
            <?php if ($contentClass == 'home'): ?>
              <div id="slideshow"><jdoc:include type="modules" name="homeslide" /></div>
                
                <div style="position:relative;width:748px;height:138px;float:left;">
                  <span style="position:absolute;top:0px;left:-10px;display:block;float:left;"><a href="index.php?option=com_content&amp;view=article&amp;id=142&amp;catid=79"><img src="images/ep/button-imnew.jpg" alt="button-imnew" onmouseover="this.src='images/ep/button-rollover-imnew.jpg';" onmouseout="this.src='images/ep/button-imnew.jpg';"  /></a></span> 
                  <span style="position:absolute;top:0px;left:245px;display:block;">                
                <a href="index.php?option=com_content&amp;view=article&amp;id=143&amp;catid=79"><img src="images/ep/button-connect.jpg" alt="button-connect" onmouseover="this.src='images/ep/button-rollover-connect.jpg';" onmouseout="this.src='images/ep/button-connect.jpg';"/></a> </span>
                  <span style="position:absolute;top:0px;left:500px;display:block;width:230px;">                
                <a href="index.php?option=com_content&amp;view=article&amp;id=144&amp;catid=79"><img src="images/ep/button-serve.jpg" alt="button-serve" onmouseover="this.src='images/ep/button-rollover-serve.jpg';" onmouseout="this.src='images/ep/button-serve.jpg';" /></a></span>
                </div>                
                         
            <?php endif; ?>       
        <article id="center" class="<?php echo $contentClass; ?>">
             <?php if ($this->countModules('top_image')) : ?>
          <div id="top_image" class="<?php echo $contentClass; ?>"><jdoc:include type="modules" name="top_image" /></div>            
        <?php endif; ?>                
                <jdoc:include type="component" />
            </article>
      <?php if ($this->countModules('right')) : ?>
          <aside id="right" class="<?php echo $contentClass; ?>"><jdoc:include type="modules" name="right" style="xhtml" /></aside>
      <?php endif; ?>        
      <div class="row cleafix">&nbsp;</div>
  </section>
</main> 
<footer id="footer" role="secondary" class="row">
  <div class="container">
      <div id="footer_left"><jdoc:include type="modules" name="footer_menu" /></div>
        <div id="footer_right">710 Ridgely Avenue, Annapolis, MD 21401 | Office 410-266-8090 | Fax 410-266-6736 | Contact Us: EP Church Office<br>WORSHIP TIMES: 8AM, 9:15AM, and 11AM | Office Hours: Monday - Thursday 8:30 - 4:30 | Friday 8:30 - 1:30</div>
  </div>        
</footer>
</body>
</html>