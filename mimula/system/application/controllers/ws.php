<?php
class ws extends Controller {

	function geomula($pais = 0, $departamento = NULL, $provincia = NULL, $distrito = NULL)
	{
		$this->load->helper('inflector');
		
		if ($pais != 0)
		{
			$where['meta_key'] = 'pais';
			$where['meta_value'] = score($pais);
		}
		else
		{
			if ($distrito != NULL)
			{
				$where['meta_key'] = 'distrito';
				$where['meta_value'] = score($distrito);			
			}
			else
			{
				if ($provincia != NULL)
				{
					$where['meta_key'] = 'provincia';
					$where['meta_value'] = score($provincia);			
				}
				else
				{
					if ($departamento != NULL)
					{
						$where['meta_key'] = 'departamento';
						$where['meta_value'] = score($departamento);			
					}				
				}
			}
		}
		
		$this->load->model('post');
		
		$limit['from'] = 0;
		$limit['show'] = 5;
		
		$data['consulta'] = $this->post->get_geomula($where, $limit);

		$this->load->view('ws/geomula', $data);
	}
}