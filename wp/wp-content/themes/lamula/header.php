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

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox-1.2.1.pack.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jyoutube.js" type="text/javascript" charset="utf-8" ></script>

  <!--[if !IE]><!-->

    <script src="<?php bloginfo('template_url'); ?>/js/site.js" type="text/javascript" charset="utf-8" ></script>

  <!-- <![endif]-->


  <!--[if lte IE 8]>

    <script src="<?php bloginfo('template_url'); ?>/js/siteie.js" type="text/javascript" charset="utf-8" ></script>

  <![endif]-->


  <?php wp_head(); ?>
	
</head>

<body>
  
  <div id="top_menu">
    <p>
      <span class="left">resistencia ciudadana | mi&eacute;rcoles, 29 de abril de 2009</span>
      <span class="right">
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

        <h1><a href="<?php bloginfo('siteurl'); ?>">La Mula</a></h1> 
    
        <div id="search_bar">
            <form action="#">
              <input type="text" name="busqueda" value="" id="busqueda" />
              <input type="submit" value="buscar" />
            </form>
        </div> <!-- search_bar -->
      
      </div> <!-- logo_bar -->
  
      <div id="status_bar">
          <h2 id="status">lamula est&aacute;... <strong>desaznadamente en linea</strong></h2>        
          <p id="site_stats">241 noticias enviadas, <a href="http://lamula.pe/mulapress/ci">env&iacute;a la tuya</a></p>
      </div> <!-- status_bar -->
  
      <div id="menu_bar">

        <p id="tagline"><span class="geomule"><em>geo</em>mula</span></p>  <!-- tagline -->
        <ul id="menu">
          <li class="f"><a href="#">Lima y Callao</a>
            <ul>
                <li class="current s">Lima y Callao</li>
                <li class="s"><a href="#">Callao</a></li>         
                <li class="s"><a href="#">Lima Centro</a></li>           
                <li class="s"><a href="#">Lima Este</a></li>       
                <li class="s"><a href="#">Lima Norte</a>
          
                  <ul>
                    <li class="t"><a href="#">Los Olivos</a></li>         
                    <li class="t"><a href="#">Carabayllo</a></li>           
                    <li class="t"><a href="#">Comas</a></li>         
                    <li class="t"><a href="#">Independencia</a></li>           
                    <li class="t"><a href="#">Puente Piedra</a></li>         
                    <li class="t"><a href="#">San Mart&iacute;n de Porres</a></li>           
                  </ul>
            
                </li>          
                <li><a href="#">Lima Oeste</a></li>          
                <li><a href="#">Lima Sur</a></li>          

            </ul>
          </li>  <!-- lima y callao -->
    
          <li class="f"><a href="#">Centro</a>
            <ul>
                  <li class="current s">Centro</li>
            
                  <li class="s"><a href="#">Apurimac</a></li>
                  <li class="s"><a href="#">Huancavelica</a></li>       
                  <li class="s"><a href="#">Huánuco</a></li>       
                  <li class="s"><a href="#">Jun&iacute;n</a></li>                 
                  <li class="s"><a href="#">Pasco</a></li>                                       
            </ul>
          </li> <!-- centro -->

          <li class="f"><a href="#">Norte</a>
            <ul>
                  <li class="current s">Norte</li>
                  <li class="s"><a href="#">Ancash</a></li>            
                  <li class="s"><a href="#">Cajamarca</a></li>
                  <li class="s"><a href="#">La Libertad</a></li>         
                  <li class="s"><a href="#">Lambayeque</a></li>                               
                  <li class="s"><a href="#">Piura</a></li>                                                        
                  <li class="s"><a href="#">Tumbes</a></li>                                                                   
            </ul>
          </li>  <!-- norte -->

            <li class="f"><a href="#">Oriente</a>
              <ul>
                    <li class="current s">Oriente</li>  
                    <li class="s"><a href="#">Amazonas</a></li>                     
                    <li class="s"><a href="#">Loreto</a></li>                      
                    <li class="s"><a href="#">Madre de Dios</a></li>          
                    <li class="s"><a href="#">San Martin</a></li>                    
                    <li class="s"><a href="#">Ucayali</a></li>                                                                
              </ul>
            </li>  <!-- oriente -->
        
          <li class="f"><a href="#">Sur</a>
            <ul>
                  <li class="current s">Sur</li>  

                  <li class="s"><a href="#">Arequipa</a></li>
                  <li class="s"><a href="#">Ayacucho</a></li>     
                  <li class="s"><a href="#">Cusco</a></li>         
                  <li class="s"><a href="#">Ica</a></li>          
                  <li class="s"><a href="#">Moquegua</a></li>     
                  <li class="s"><a href="#">Puno</a></li>                        
                  <li class="s"><a href="#">Tacna</a></li>                                                                                                                         
            </ul>
          </li>  <!-- sur -->
      
        </ul>  <!-- menu -->

      </div> <!-- menu_bar -->