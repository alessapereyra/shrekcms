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
  <title>LaMulas</title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/site.js" type="text/javascript" charset="utf-8" ></script>

  <?php wp_head(); ?>
	
</head>

<body>
  
  <div id="top_menu">
    <p>
      <span class="left">resistencia ciudadana | mi&eacute;rcoles, 29 de abril de 2009</span>
      <span class="right"><a href="http://lamula.pe/mulapress/ci">mándanos tu noticia</a></span>
    </p>
  </div> <!-- top_menu -->
  
  
  <div id="wrapper">
  
      <div id="top_ad">
        <!-- <img src="<?php bloginfo('template_url'); ?>/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
      </div> <!-- top_ad -->
  

      <h1><a href="<?php bloginfo('siteurl'); ?>">La Mula</a></h1> 
  
  
      <div id="search_bar">
          <h2 id="status">...desaznadamente en linea</h2>        
          <form action="#">
            <input type="text" name="busqueda" value="" id="busqueda" />
            <input type="submit" value="buscar" />
          </form>
      </div> <!-- search_bar -->
  
      <div id="menu_bar">

        <p id="tagline"><span class="geomule"><em>geo</em>mula</span></p>  <!-- tagline -->
        <p id="zonas">zonas</p>  <!-- zonas -->

        <ul id="menu">
          <li><a href="#">Lima y Callao</a>
            <ul>
                <li class="current">Lima y Callao</li>
                <li><a href="#">Callao</a></li>         
                <li><a href="#">Lima Centro</a></li>           
                <li><a href="#">Lima Este</a></li>       
                <li><a href="#">Lima Norte</a>
          
                  <ul>
                    <li><a href="#">Los Olivos</a></li>         
                    <li><a href="#">Carabayllo</a></li>           
                    <li><a href="#">Comas</a></li>         
                    <li><a href="#">Independencia</a></li>           
                    <li><a href="#">Puente Piedra</a></li>         
                    <li><a href="#">San Mart&iacute;n de Porres</a></li>           
                  </ul>
            
                </li>          
                <li><a href="#">Lima Oeste</a></li>          
                <li><a href="#">Lima Sur</a></li>          

            </ul>
          </li>  <!-- lima y callao -->
    
          <li><a href="#">Centro</a>
            <ul>
                  <li class="current">Centro</li>
            
                  <li><a href="#">Apurimac</a></li>
                  <li><a href="#">Huancavelica</a></li>       
                  <li><a href="#">Huánuco</a></li>       
                  <li><a href="#">Jun&iacute;n</a></li>                 
                  <li><a href="#">Pasco</a></li>                                       
            </ul>
          </li> <!-- centro -->

          <li><a href="#">Norte</a>
            <ul>
                  <li class="current">Norte</li>
                  <li><a href="#">Ancash</a></li>            
                  <li><a href="#">Cajamarca</a></li>
                  <li><a href="#">La Libertad</a></li>         
                  <li><a href="#">Lambayeque</a></li>                               
                  <li><a href="#">Piura</a></li>                                                        
                  <li><a href="#">Tumbes</a></li>                                                                   
            </ul>
          </li>  <!-- norte -->

            <li><a href="#">Oriente</a>
              <ul>
                    <li class="current">Oriente</li>  
                    <li><a href="#">Amazonas</a></li>                     
                    <li><a href="#">Loreto</a></li>                      
                    <li><a href="#">Madre de Dios</a></li>          
                    <li><a href="#">San Martin</a></li>                    
                    <li><a href="#">Ucayali</a></li>                                                                
              </ul>
            </li>  <!-- oriente -->
        
          <li><a href="#">Sur</a>
            <ul>
                  <li class="current">Sur</li>  

                  <li><a href="#">Arequipa</a></li>
                  <li><a href="#">Ayacucho</a></li>     
                  <li><a href="#">Cusco</a></li>         
                  <li><a href="#">Ica</a></li>          
                  <li><a href="#">Moquegua</a></li>     
                  <li><a href="#">Puno</a></li>                        
                  <li><a href="#">Tacna</a></li>                                                                                                                         
            </ul>
          </li>  <!-- sur -->
      
        </ul>  <!-- menu -->

      </div> <!-- menu_bar -->