    <div id="menu_bar">

      <p id="tagline"><span class="geomule"><em>geo</em>mula</span></p>  <!-- tagline -->
      <ul id="menu">

        <li class="f"><a href="<?php echo '/shrekcms/mimula/ws/geomula/0/0/' ?>">Lima y Callao</a>
          <ul>
              <li class="current s">Lima y Callao</li>
              <li class="s"><a href="<?php echo '/shrekcms/mimula/ws/geomula/0/callao/callao/' ?>">Callao</a>

              <ul>
              	<?php
              	$distritos = array('Bellavista', 'Carmen de la Legua',  'Cercado Callao', 'La Perla', 'La Punta', 'Ventanilla' ); 
              	foreach($distritos as $distrito)
              	{
              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/callao/callao/'. $distrito_url . '">' . $distrito . '</a></li>';
              	}
              	?>           
              </ul>                

              </li> 
                      
              <li class="s"><a href="#">Lima Centro</a> 

              <ul>

              	<?php
              	$distritos = array('Barranco', 'Breña',  'Jesús María', 'La Victoria', 'Lince', 'Miraflores','San Isidro', 'San Luis',  'Santiago de Surco', 'Surquillo', 'San Borja' ); 
              	foreach($distritos as $distrito)
              	{
              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/lima/lima/'. $distrito_url . '">' . $distrito . '</a></li>';
              	}
              	?>              
              </ul>

              </li>


              <li class="s"><a href="#">Lima Oeste</a>
        
                <ul>
	              	<?php
	              	$distritos = array('Cercado de Lima', 'Magdalena del Mar',  'Pueblo Libre', 'San Miguel'); 
	              	foreach($distritos as $distrito)
	              	{
	              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
	              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/lima/lima7'. $distrito_url . '">' . $distrito . '</a></li>';
	              	}
	              	?>             
                </ul>
          
              </li>                          
              

                        
              <li class="s"><a href="#">Lima Este</a>
              
              <ul>

              	<?php
              	$distritos = array('Chaclacayo', 'Cieneguilla',  'El Agustino', 'La Molina', 'Lurigancho', 'San Juan de Lurigancho','Santa Anita' ); 
              	foreach($distritos as $distrito)
              	{
              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/lima/lima/'. $distrito_url . '">' . $distrito . '</a></li>';
              	}
              	?>           

              </ul>

              </li>                   
                  
              <li class="s"><a href="#">Lima Norte</a>
        
                <ul>

	              	<?php
	              	$distritos = array('Carabayllo', 'Comas',  'Independencia', 'Los Olivos', 'Puente Piedra', 'Rimac','San Martin de Porres' ); 
	              	foreach($distritos as $distrito)
	              	{
	              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
	              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/lima/lima/'. $distrito_url . '">' . $distrito . '</a></li>';
	              	}
	              	?>
                </ul>
          
              </li>                          

              
              <li class="s"><a href="#">Lima Sur</a>    

              <ul>

	              	<?php
	              	$distritos = array('Chorrillos', 'Lurian',  'Pachacamac', 'Pucusana', 'San Bartolo', 'San Juan de Miraflores','Sta. Maria del Mar','Villa El Salvador','Villa Maria del Triunfo' ); 
	              	foreach($distritos as $distrito)
	              	{
	              		$distrito_url = strtolower(eregi_replace(' ', '-', $distrito));
	              		echo '<li class="t"><a href="/shrekcms/mimula/ws/geomula/0/lima/lima/'. $distrito_url . '">' . $distrito . '</a></li>';
	              	}
	              	?>                  

              </ul>
                    
              </li>

          </ul>
        </li>  <!-- lima y callao -->
  
        <li class="f"><a href="#">Centro</a>
          <ul>
                <li class="current s">Centro</li>

              	<?php
              	$departamentos = array('Apurimac', 'Huancavelica',  'Huanuco', 'Junin', 'Pasco'); 
              	foreach($departamentos as $departamento)
              	{
              		$departamento_url = strtolower(eregi_replace(' ', '-', $departamento));
              		echo '<li class="s"><a href="/shrekcms/mimula/ws/geomula/0/'. $departamento_url . '">' . $departamento . '</a></li>';
              	}
              	?>                     
          </ul>
        </li> <!-- centro -->

        <li class="f"><a href="#">Norte</a>
          <ul>
                <li class="current s">Norte</li>

              	
              	<?php
              	$departamentos = array('Ancash', 'Cajamarca',  'La Libertad', 'Lambayeque', 'Piura','Tumbes'); 
              	foreach($departamentos as $departamento)
              	{
              		$departamento_url = strtolower(eregi_replace(' ', '-', $departamento));
              		echo '<li class="s"><a href="/shrekcms/mimula/ws/geomula/0/'. $departamento_url . '">' . $departamento . '</a></li>';
              	}
              	?>                                                                                  
          </ul>
        </li>  <!-- norte -->

          <li class="f"><a href="#">Oriente</a>
            <ul>
                  <li class="current s">Oriente</li>
                    
	              	<?php
	              	$departamentos = array('Amazonas', 'Loreto',  'Madre de Dios', 'San Martin', 'Ucayali'); 
	              	foreach($departamentos as $departamento)
	              	{
	              		$departamento_url = strtolower(eregi_replace(' ', '-', $departamento));
	              		echo '<li class="s"><a href="/shrekcms/mimula/ws/geomula/0/'. $departamento_url . '">' . $departamento . '</a></li>';
	              	}
	              	?>                  
            </ul>
          </li>  <!-- oriente -->
      
        <li class="f"><a href="#">Sur</a>
          <ul>
                <li class="current s">Sur</li>  

              	<?php
              	$departamentos = array('Arequipa', 'Ayacucho',  'Cusco', 'Ica', 'Moquegua','Puno','Tacna'); 
              	foreach($departamentos as $departamento)
              	{
              		$departamento_url = strtolower(eregi_replace(' ', '-', $departamento));
              		echo '<li class="s"><a href="/shrekcms/mimula/ws/geomula/0/'. $departamento_url . '">' . $departamento . '</a></li>';
              	}
              	?>                                                                                                                    
          </ul>
        </li>  <!-- sur -->
    
      </ul>  <!-- menu -->

    </div> <!-- menu_bar -->