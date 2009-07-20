<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$from_email = 'admin@lamula.pe';
$from_name = 'La mulamaster';

//Recupero de contraseña
$email['from_email'] = $from_email;
$email['from_name'] = $from_name;
$email['subject'] = 'Mula: Cambio de contraseña';
$email['message'] = 'Su nueva contraeña es: ';

$config['retrieve_password'] = $email;

//Formulario de bienvenido
$email['from_email'] = $from_email;
$email['from_name'] = $from_name;
$email['subject'] = 'Nuevo Bienvenido';
$email['message'] = '<p>Bienvenido</p>
<p>Estás a un paso de ser parte de la comunidad de La Mula.</p>
<p>Primero debemos confirmar tu identidad. Espera nuestra llamada, porque nos comunicaremos  contigo lo más pronto posible.</p>
<p>Mientras tanto, podrás <a href="http://lamula.pe/mimula/index.php/articulos/formulario"><strong>enviar noticias a La Mula</strong></a> y éstas serán publicadas, pero no llegarán a la portada y tampoco  competirás en nuestro ranking. De todas formas, apenas recibas nuestra llamada serás un mulero con todos los privilegios.</p>
<p>Por favor, lee las <strong>Reglas de la Casa</strong>, para que conozcas cómo funciona La Mula y cómo comportarte para que todos nos llevemos bien en medio de nuestras diferencias.</p>
<p>Además, no estaría mal que leas nuestras <strong><a href="http://lamula.pe/te-recomendamos" target="_blank">Recomendaciones</a></strong> para que tus noticias sean más visitadas por nuestro público y asegurarte que tengan un impacto en el Mundo Real™.</p>
<p>¿Qué puedes  hacer en La Mula?</p>
<p>Puedes hacer casi de todo.</p>
<ul>
	<li><strong><a href="http://lamula.pe/wp-signup.php" target="_blank">Crear un blog</a></strong>.</li>
    <li>Puedes subir <a href="http://lamula.pe/mimula/index.php/videos/formulario"><strong>videos</strong></a>, <a href="http://lamula.pe/mimula/index.php/fotos/formulario"><strong>fotos</strong></a> o <a href="http://lamula.pe/mimula/index.php/articulos/formulario"><strong>contarnos</strong></a> algo que te haya sucedido.</li>
    <li>Puedes ser <strong><a href="http://lamula.pe/members/" target="_blank">parte de la comunidad</a></strong> de La Mula: crear grupos de intereses, encontrar  noticias que vengan desde todo el Perú, denunciar un abuso o promover una buena obra.</li>
    <li>Puedes iniciar campañas para ayudar o defender alguna  causa.</li>
</ul>
<p>Pronto La Mula irá creciendo. Esperamos que tú nos acompañes. Gracias por  inscribirte, disfruta la Mula y pronto nos comunicaremos contigo.</p>
<p>El Equipo de La Mula</p>';

$config['send_welcome'] = $email;

/* End of file config.php */
/* Location: ./system/application/config/config.php */
