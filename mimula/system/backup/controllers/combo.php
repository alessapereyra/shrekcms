<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de combos box
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de combos box
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Combo extends Controller {
	
	/**
	 * Obtiene las provincias
	 * @param integer $departamento departamento para filtrar
	 * @return array 
	 */		
	function provincia($departamento = NULL)
	{
		$this->load->library('combofiller');
		$combo = $this->combofiller->provinces($departamento, TRUE);
		
		$tmp = NULL;
		foreach($combo as $key => $value)
		{
			$tmp .= '<option value="' . $key . '">' . $value . '</option>';
		}
		echo $tmp;
	}
		
	/**
	 * Obtiene los distritos
	 * @param integer $distrito distrito para filtrar
	 * @return array 
	 */			
	function distrito($distrito = NULL)
	{
		$this->load->library('combofiller');
		$combo = $this->combofiller->districts($distrito, TRUE);
		
		$tmp = NULL;
		//echo print_r($combo);
		foreach($combo as $key => $value)
		{
			$tmp .= '<option value="' . $key . '">' . $value . '</option>';
		}
		echo $tmp;
	}

}

/* End of file combos.php */
/* Location: ./system/application/controllers/combos.php */