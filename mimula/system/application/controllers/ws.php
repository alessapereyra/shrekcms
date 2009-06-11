<?php
class Ws extends Controller {

	function geomula($pais = 0, $departamento = NULL, $provincia = NULL, $distrito = NULL)
	{
		
		$final = NULL;
		$this->load->helper('inflector');
		
		if ($pais != '0')
		{
			$final = $pais;
			$where['meta_key'] = 'pais';
			$where['meta_value'] = sanitize2url($pais);
		}
		else
		{
			if ($distrito != NULL)
			{
				$final = $distrito;	
				$where['meta_key'] = 'distrito';
				$where['meta_value'] = sanitize2url($distrito);	
			}
			else
			{
				if ($provincia != NULL)
				{
					$final = $provincia;	
					$where['meta_key'] = 'provincia';
					$where['meta_value'] = sanitize2url($provincia);			
				}
				else
				{
					if ($departamento != NULL)
					{

						if ($departamento == '0')
						{
  						$final = "Lima y Callao";	
							$where = '(meta_key = \'departamento\' AND meta_value = \'lima\')';
							$where = $where . ' OR (meta_key = \'departamento\' AND meta_value = \'callao\')';
						}
						else
						{						
						  $final = $departamento;	
							$where['meta_key'] = 'departamento';
							$where['meta_value'] = sanitize2url($departamento);
						}		
					}				
				}
			}
		}
		
		$this->load->model('post');
		
		$limit['from'] = 0;
		$limit['show'] = 1;
		
		$data['consulta'] = $this->post->get_geomula($where, $limit);
		$data['final'] = $final;
		
		$this->load->view('ws/geomula', $data);
	}
	
	function mularanking()
	{
		$this->load->model('users');
		$this->load->model('post');
		$this->load->model('comments');
		$this->load->model('mularangos');
		
		$users = $this->users->seleccionar();
		$mularangos = $this->mularangos->seleccionar();
		$mularangos = $mularangos->result_array();
		reset($mularangos);
		
		foreach ($users->result() as $user)
		{
		   $userid = $user->ID;
		   $published_posts = $this->post->published_posts($userid) * 1.2;
		   $comments = $this->comments->total_comments($userid);
		   $comments_received = $this->comments->total_received_comments($userid) * 1.05;
		   $promedios = $this->post->promedio($userid);
		   $promedios = $promedios->result_array();
		   $promedios = current($promedios);
		   
		   $user_prom = @($promedios['user_votes']/$promedios['user_voters']) * 1.05;
		   $visitor_prom = @($promedios['visitor_votes']/$promedios['visitor_voters']);
		   
		   $promedio = ($user_prom + $visitor_prom)/2;
		   
		   $tmp = (1) + @($comments_received/($comments*100));
		   
		   $promedio = $promedio * $tmp;
		   
		   $total = $published_posts + $comments + $comments_received + $promedio;
		   //echo $published_posts . ' ' . $comments . ' ' . $comments_received . ' ' . $promedio . ' ' . $tmp;
		   //die($total);
		   foreach($mularangos as $rango)
		   {
			   	if ($total >= $rango['minimo'])
			   	{
			   		$where['ID'] = $userid;
			   		$values['mularango'] = $rango['ranking'];
			   		$values['puntaje'] = $total;
			   		//echo 'final = ' . $total . ' ' . ($rango['ranking']) . '<br />';
			   		$this->users->actualizar($values, $where);
			   		break;
			   	}  
		   }
		}
		$this->load->view('ws/mularanking');
	}
}