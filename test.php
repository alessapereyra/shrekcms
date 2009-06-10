<html>
	<head>
	<title>Geomula</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
	<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$("ul#geomula li").hide();
		$("ul#geomula li.top").show();

		$("a.geomula").click(function(){
			$("ul#geomula li").hide();
			$("ul#geomula li.top").show();
			$("ul#geomula a").removeClass("current");
			return false;
		});
		
		$("ul#geomula a").click(function(){

			
			if ($(this).hasClass("last") != true)
			{
				//quita el current a todos
				$("ul#geomula a").removeClass("current");
				//Esconder a los hermanos
				$(this).parent().siblings().hide("fast");
				//Esconde a los hijos
				$(this).parent().find('li').hide("fast");
	

				//Muestra a los hijos
				$(this).next().children().show("fast");

				//agrega el current al actual
				$(this).addClass('current');
			}
						
			return false;
		});
	});
	</script> 
	
	</head>
	
	<body>
	<?php $ci_url= "/mulapress/ci/index.php/"; ?>
	<a href="#" class="geomula"><em>geo</em>mula</a>
	<ul id="geomula">
		<li class="top">
			<a href="#">Lima y Callao</a>
			<ul>
				<li>
					<a href="#">Callao</a>
					<ul>
						<li><a class="last" rel="callao/bellavista" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/bellavista">Bellavista</a></li> 
						<li><a class="last" rel="callao/carmen-de-la-legua" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/carmen-de-la-legua">Carmen de la Legua</a></li> 
						<li><a class="last" rel="callao/cercado-callao" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/cercado-callao">Cercado Callao</a></li> 
						<li><a class="last" rel="callao/la-perla" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/la-perla">La Perla</a></li> 
						<li><a class="last" rel="callao/la-punta" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/la-punta">La Punta</a></li> 
						<li><a class="last" rel="callao/ventanilla" href="<?php echo $ci_url; ?>ws/geomula/0/callao/callao/ventanilla">Ventanilla</a></li> 
					</ul>
				</li>
				<li>
					<a href="#">Lima Centro</a>
					<ul>
						<li><a class="last" rel="lima/barranco" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/barranco">Barranco</a></li> 
						<li><a class="last" rel="lima/breña" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/breña">Breña</a></li> 
						<li><a class="last" rel="lima/jesús-maría" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/jess-mara">Jesús María</a></li> 
						<li><a class="last" rel="lima/la-victoria" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/la-victoria">La Victoria</a></li> 
						<li><a class="last" rel="lima/lince" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/lince">Lince</a></li> 
						<li><a class="last" rel="lima/miraflores" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/miraflores">Miraflores</a></li> 
						<li><a class="last" rel="lima/san-isidro" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-isidro">San Isidro</a></li> 
						<li><a class="last" rel="lima/san-luis" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-luis">San Luis</a></li>				
						<li><a class="last" rel="lima/santiago-de-surco" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/santiago-de-surco">Santiago de Surco</a></li> 
						<li><a class="last" rel="lima/surquillo" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/surquillo">Surquillo</a></li> 
						<li><a class="last" rel="lima/san-borja" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-borja">San Borja</a></li>
					</ul>					
				</li>
				<li>
					<a href="#">Lima Oeste</a>
					<ul>
						<li><a class="last" rel="lima/cercado-de-lima" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/cercado-de-lima">Cercado de Lima</a></li> 
						<li><a class="last" rel="lima/magdalena-del-mar" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/magdalena-del-mar">Magdalena del Mar</a></li> 
						<li><a class="last" rel="lima/pueblo-libre" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/pueblo-libre">Pueblo Libre</a></li> 
						<li><a class="last" rel="lima/san-miguel" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-miguel">San Miguel</a></li> 
					</ul>					
				</li>
				<li>
					<a href="#">Lima Este</a>
					<ul>
						<li><a class="last" rel="lima/chaclacayo" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/chaclacayo">Chaclacayo</a></li> 
						<li><a class="last" rel="lima/cieneguilla" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/cieneguilla">Cieneguilla</a></li> 
						<li><a class="last" rel="lima/el-agustino" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/el-agustino">El Agustino</a></li> 
						<li><a class="last" rel="lima/la-molina" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/la-molina">La Molina</a></li> 
						<li><a class="last" rel="lima/lurigancho" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/lurigancho">Lurigancho</a></li> 
						<li><a class="last" rel="lima/san-juan-de-lurigancho" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-juan-de-lurigancho">San Juan de Lurigancho</a></li> 
						<li><a class="last" rel="lima/santa-anita" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/santa-anita">Santa Anita</a></li>
					</ul>					
				</li>
				<li>
					<a href="#">Lima Norte</a>
					<ul>
						<li><a class="last" rel="lima/carabayllo" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/carabayllo">Carabayllo</a></li> 
						<li><a class="last" rel="lima/comas" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/comas">Comas</a></li> 
						<li><a class="last" rel="lima/independencia" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/independencia">Independencia</a></li> 
						<li><a class="last" rel="lima/los-olivos" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/los-olivos">Los Olivos</a></li> 
						<li><a class="last" rel="lima/puente-piedra" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/puente-piedra">Puente Piedra</a></li> 
						<li><a class="last" rel="lima/rimac" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/rimac">Rimac</a></li> 
						<li><a class="last" rel="lima/san-martin-de-porres" href="<?php echo $ci_url; ?>ws/geomula/0/lima/lima/san-martin-de-porres">San Martin de Porres</a></li>					</ul>
				</li>
			</ul>			
		</li>
		
		<li>
			<a href="#">Centro</a>		
			<ul>
				<li><a class="last" rel="apurimac" href="<?php echo $ci_url; ?>ws/geomula/0/apurimac">Apurimac</a></li> 
				<li><a class="last" rel="huancavelica" href="<?php echo $ci_url; ?>ws/geomula/0/huancavelica">Huancavelica</a></li> 
				<li><a class="last" rel="huanuco" href="<?php echo $ci_url; ?>ws/geomula/0/huanuco">Huanuco</a></li> 
				<li><a class="last" rel="junin" href="<?php echo $ci_url; ?>ws/geomula/0/junin">Junin</a></li> 
				<li><a class="last" rel="pasco" href="<?php echo $ci_url; ?>ws/geomula/0/pasco">Pasco</a></li>
			</ul>
		</li>
		
		<li class="top">
			<a href="#">Norte</a>
			<ul>
				<li><a class="last" rel="ancash" href="<?php echo $ci_url; ?>ws/geomula/0/ancash">Ancash</a></li> 
				<li><a class="last" rel="cajamarca" href="<?php echo $ci_url; ?>ws/geomula/0/cajamarca">Cajamarca</a></li> 
				<li><a class="last" rel="la-libertad" href="<?php echo $ci_url; ?>ws/geomula/0/la-libertad">La Libertad</a></li> 
				<li><a class="last" rel="lambayeque" href="<?php echo $ci_url; ?>ws/geomula/0/lambayeque">Lambayeque</a></li> 
				<li><a class="last" rel="piura" href="<?php echo $ci_url; ?>ws/geomula/0/piura">Piura</a></li> 				
				<li><a class="last" rel="tumbes" href="<?php echo $ci_url; ?>ws/geomula/0/tumbes">Tumbes</a></li>
			</ul>		
		</li>
		
		<li class="top">
			<a href="#">Oriente</a>
			<ul>
				<li><a class="last" rel="amazonas" href="<?php echo $ci_url; ?>ws/geomula/0/amazonas">Amazonas</a></li> 
				<li><a class="last" rel="loreto" href="<?php echo $ci_url; ?>ws/geomula/0/loreto">Loreto</a></li> 
				<li><a class="last" rel="madre-de-dios" href="<?php echo $ci_url; ?>ws/geomula/0/madre-de-dios">Madre de Dios</a></li> 
				<li><a class="last" rel="san-martin" href="<?php echo $ci_url; ?>ws/geomula/0/san-martin">San Martin</a></li> 
				<li><a class="last" rel="ucayali" href="<?php echo $ci_url; ?>ws/geomula/0/ucayali">Ucayali</a></li> 
			</ul>		
		</li>
		
		<li class="top">
		
			<a href="#">Sur</a>
			<ul>
				<li><a class="last" rel="arequipa" href="<?php echo $ci_url; ?>ws/geomula/0/arequipa">Arequipa</a></li> 
				<li><a class="last" rel="ayacucho" href="<?php echo $ci_url; ?>ws/geomula/0/ayacucho">Ayacucho</a></li> 
				<li><a class="last" rel="cusco" href="<?php echo $ci_url; ?>ws/geomula/0/cusco">Cusco</a></li> 
				<li><a class="last" rel="ica" href="<?php echo $ci_url; ?>ws/geomula/0/ica">Ica</a></li> 
				<li><a class="last" rel="moquegua" href="<?php echo $ci_url; ?>ws/geomula/0/moquegua">Moquegua</a></li> 
				<li><a class="last" rel="puno" href="<?php echo $ci_url; ?>ws/geomula/0/puno">Puno</a></li> 
				<li><a class="last" rel="tacna" href="<?php echo $ci_url; ?>ws/geomula/0/tacna">Tacna</a></li>
			</ul>
		</li>
	</ul>
	<script>
	
	/*
	next = $(this).next();
	next.siblings().show("fast");
	*/		
	//Mostrar los hijos
	/*
	alert($(this).nextAll().html());
	list = $(this).nextAll().html()
	list.show();
	*/
	//alert($(this).next().html());
	//$(this).next().html().show();
	//next = $(this).children();
	//next.show("fast");
	//$(this).find("ul").show("fast");
	//$(this).find("ul:first li").show();
	//parent.find("li:first").show("fast");
	//parent.children().show("fast");
	
	</script>
	
	</body>
</html>