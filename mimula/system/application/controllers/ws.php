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
					$final = $distrito;	
					$where['meta_key'] = 'provincia';
					$where['meta_value'] = sanitize2url($provincia);			
				}
				else
				{
					if ($departamento != NULL)
					{
						$final = $departamento;	
						if ($departamento == '0')
						{
							$where = '(meta_key = \'departamento\' AND meta_value = \'lima\')';
							$where = $where . ' OR (meta_key = \'departamento\' AND meta_value = \'callao\')';
						}
						else
						{						
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
}