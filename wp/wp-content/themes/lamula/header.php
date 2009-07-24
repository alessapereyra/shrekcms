<?php
/**
 * @package WordPress
 * @subpackage LaMula Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>LaMula</title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/fancybox.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <!--[if IE 7]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE.css" type="text/css" media="screen" />

  <![endif]-->

  <!--[if IE 6]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE6.css" type="text/css" media="screen" />

  <![endif]-->

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox-1.2.1.pack.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.scrollable-1.0.2.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.swfobject.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.mousewheel.min.js" type="text/javascript" charset="utf-8" ></script>
  <!-- <script src="<?php bloginfo('template_url'); ?>/js/jquery.livequery" type="text/javascript" charset="utf-8" ></script> --> 
  
  <!--[if !IE]><!-->

    <script src="<?php bloginfo('template_url'); ?>/js/site.js" type="text/javascript" charset="utf-8" ></script>

    <!--<![endif]-->


  <!--[if IE]>

    <script src="<?php bloginfo('template_url'); ?>/js/siteie.js" type="text/javascript" charset="utf-8" ></script>

  <![endif]-->

<link rel="alternate" type="application/rss+xml" 
  title="La Mula RSS" 
  href="<?php bloginfo('siteurl') ?>/feed/" />

  <?php wp_head(); ?>
  	
</head>

<body>
  
  <div id="top_menu">
    <p>
      <span class="left">
        <a href="<?php bloginfo('siteurl'); ?>/nosotros">nosotros</a>
        <a href="<?php bloginfo('siteurl'); ?>/el-concepto">el concepto</a>
        <a href="<?php bloginfo('siteurl'); ?>/te-recomendamos">te recomendamos</a>        
      </span>
      <span class="right">
        <a href="http://lamula.pe/wp-login.php">inicia sesi&oacute;n</a>
        <a href="http://lamula.pe/wp-signup.php">crea tu blog</a>
        <a href="http://lamula.pe/mimula">m&aacute;ndanos tu noticia</a>
      </span>
    </p>
  </div> <!-- top_menu -->
  
  
  <div id="wrapper">
  
      <div id="top_ad">
        <!-- <img src="<?php bloginfo('template_url'); ?>/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
      </div> <!-- top_ad -->
  
      <!-- <div id="flag">
        <a href="#logo_bar">Arriba</a>
      </div> -->
  
      <div id="logo_bar">

        <div id="logo">
          <h1><a href="<?php bloginfo('siteurl'); ?>">La Mula</a></h1> 
          <strong id="twitter_status"></strong>
        </div>
        
        <div id="search_bar">
			<p class="feed-button"><a href="<?php bloginfo('siteurl') ?>/feed">suscribete por rss</a></p>
            <form action="<?php bloginfo('home'); ?>/" method="get" id="searchform">
              <input type="text" name="s" value="" id="busqueda" />
              <input type="submit" value="buscar" />
            </form>
        </div> <!-- search_bar -->
      
      </div> <!-- logo_bar -->
      
      <div><object width="922" height="134" title="banner" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
		  <param value="http://lamula.pe/wp-content/themes/lamula/cabecera.swf" name="movie"/>
		  <param value="high" name="quality"/>
		  <embed width="922" height="134" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="http://lamula.pe/wp-content/themes/lamula/cabecera.swf"/>
		</object>
		</div>
