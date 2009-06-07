<?php
class Ws extends Controller {

	function geomula($pais = 0, $departamento = NULL, $provincia = NULL, $distrito = NULL)
	{
		$final = NULL;
		$this->load->helper('inflector');
		
		if ($pais != '0')
		{
			$where['meta_key'] = 'pais';
			$where['meta_value'] = score($pais);
			$final = $pais;
		}
		else
		{
			if ($distrito != NULL)
			{
				$where['meta_key'] = 'distrito';
				$where['meta_value'] = score($distrito);	
				$final = $distrito;		
			}
			else
			{
				if ($provincia != NULL)
				{
					$where['meta_key'] = 'provincia';
					$where['meta_value'] = score($provincia);	
					$final = $provincia;			
				}
				else
				{
					if ($departamento != NULL)
					{
						if ($departamento == '0')
						{
							$where = '(meta_key = \'departamento\' AND meta_value = \'lima\')';
							$where = $where . ' OR (meta_key = \'departamento\' AND meta_value = \'callao\')';
						}
						else
						{						
							$where['meta_key'] = 'departamento';
							$where['meta_value'] = score($departamento);
						}
						$final = $departamento;				
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
}