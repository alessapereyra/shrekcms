<?php
/**
 * @package WordPress
 * @subpackage LaMula Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>LaMula</title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/fancybox.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <!--[if lte IE 8]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE.css" type="text/css" media="screen" />

  <![endif]-->

  <!--[if lte IE 7]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE6.css" type="text/css" media="screen" />

  <![endif]-->
  
  <?php wp_head(); ?>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox-1.2.1.pack.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.scrollable-1.0.2.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.mousewheel.min.js" type="text/javascript" charset="utf-8" ></script>
  <!--[if !IE]><!-->

    <script src="<?php bloginfo('template_url'); ?>/js/site.js" type="text/javascript" charset="utf-8" ></script>

  <!-- <![endif]-->


  <!--[if lte IE 8]>

    <script src="<?php bloginfo('template_url'); ?>/js/siteie.js" type="text/javascript" charset="utf-8" ></script>

  <![endif]-->

	
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
        <a href="http://lamula.pe/crear-blog/">crea tu blog</a>
        <a href="http://lamula.pe/mulapress/ci">mándanos tu noticia</a>
      </span>
    </p>
  </div> <!-- top_menu -->
  
  
  <div id="wrapper">
  
      <div id="top_ad">
        <!-- <img src="<?php bloginfo('template_url'); ?>/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
      </div> <!-- top_ad -->
  
      <div id="logo_bar">

        <div id="logo">
          <h1><a href="<?php bloginfo('siteurl'); ?>">La Mula</a></h1> 
          <strong id="twitter_status">desaznadamente en linea</strong>
        </div>
        
        <div id="search_bar">
            <form action="<?php bloginfo('home'); ?>/" method="get" id="searchform">
              <input type="text" name="s" value="" id="busqueda" />
              <input type="submit" value="buscar" />
            </form>
        </div> <!-- search_bar -->
      
      </div> <!-- logo_bar -->