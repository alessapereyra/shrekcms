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
				$("ul#geomula a").removeClass("current");
				//Esconder a los hermanos
				$(this).parent().siblings().hide("fast");
				//Esconde a los hijos
				$(this).parent().find('li').hide("fast");
	
	
				//Muestra a los hijos
				$(this).next().children().show("fast");
	
				$(this).addClass('current');
			}
						
			return false;
		});
	});
	</script> 
	
	</head>
	
	<body>
	<a href="#" class="geomula"><em>geo</em>mula</a>
	<ul id="geomula">
		<li class="top">
			<a href="#">Lima y Callao</a>
			<ul>
				<li>
					<a href="#">Callao</a>
					<ul>
						<li><a href="#" class="last">Bellavista</a></li>
						<li><a href="#">Callao</a></li>
					</ul>
				</li>
				<li><a href="#">Lima norte</a></li>
				<li><a href="#">Lima sur</a></li>
				<li><a href="#">Lima ete</a></li>
				<li><a href="#">Lima oete</a></li>
			</ul>			
		</li>
		
		<li>
			<a href="#">Centro</a>		
			<ul>
				<li><a href="#">Apurimac</a></li>
				<li><a href="#">Apurimac</a></li>
			</ul>
		</li>
		
		<li class="top">
			<a href="#">Norte</a>
			<ul>
				<li><a href="#">Ancash</a></li>
				<li><a href="#">Ancash</a></li>
			</ul>		
		</li>
		
		<li class="top">
			<a href="#">Oriente</a>
			<ul>
				<li><a href="#">Amazonas</a></li>
				<li><a href="#">Amazonas</a></li>
			</ul>		
		</li>
		
		<li class="top">
		
			<a href="#">Sur</a>
			<ul>
				<li><a href="#">Arequipa</a></li>
				<li><a href="#">Arequipa</a></li>
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