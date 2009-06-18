<?php
class Combo extends Controller {
	
	function provincia($departamento = NULL)
	{
		$this->load->library('combofiller');
		$combo = $this->combofiller->providences($departamento, TRUE);
		
		$tmp = NULL;
		foreach($combo as $key => $value)
		{
			$tmp .= '<option value="' . $key . '">' . $value . '</option>';
		}
		echo $tmp;
	}
		
	function distrito($distrito = NULL)
	{
		$this->load->library('combofiller');
		$combo = $this->combofiller->distrits($distrito, TRUE);
		
		$tmp = NULL;
		//echo print_r($combo);
		foreach($combo as $key => $value)
		{
			$tmp .= '<option value="' . $key . '">' . $value . '</option>';
		}
		echo $tmp;
	}

}
?>