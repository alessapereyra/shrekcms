<?php

function active_controller($target) {

	if (in_array($this->uri->segment(1), $subidon))
	{
	
	    if ($this->uri->segment(1) == $target)
	    {
	      
	        return "selected";
	      
	    }
	}
}

?>
<div id="top_menu">
  <p>
    <span class="left">resistencia ciudadana | mi&eacute;rcoles, 29 de abril de 2009</span>
    <span class="right">
      <a href="http://lamula.pe/crear-blog/">crea tu blog</a> |
      <a href="http://lamula.pe/mulapress/ci">mándanos tu noticia</a>
    </span>
  </p>
</div> <!-- top_menu -->

<div id="wrapper">

    <div id="top_ad">
      <!-- <img src="/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
    </div> <!-- top_ad -->

    <div id="logo_bar">

      <h1><a href="http://lamula.pe/mulapress">La Mula</a></h1> 
  
      <div id="search_bar">

       	<?php if ($log) : ?>
  				<ul>
  					<li><a href="http://lamula.pe/mulapress/author/">Ver Perfil</a></li>
  					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
  				</ul>
  			<?php endif; ?>		

    </div> <!-- search_bar -->
    
    </div> <!-- logo_bar -->

    <div id="status_bar">
        <h2 id="status">lamula est&aacute;... <strong>desaznadamente en linea</strong></h2>        
        <p id="site_stats">241 noticias enviadas, <a href="http://lamula.pe/mulapress/ci">env&iacute;a la tuya</a></p>
    </div> <!-- status_bar -->

		  <h2>Env&iacute;a a la mula... </h2>
		  <ul id="menu">
				<li class="foto " ><?php echo anchor('fotos/formulario', 'foto') ?></li>		    
				<li class="video "><?php echo anchor('videos/formulario', 'video') ?></li>
				<li class="articulo "><?php echo anchor('articulos/formulario', 'articulo') ?></li>
				<li class="audio "><?php echo anchor('audios/formulario', 'audio') ?></li>
				<li class="documento "><?php echo anchor('documentos/formulario', 'documento') ?></li>					
			</ul> <!-- menu -->