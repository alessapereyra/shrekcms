<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class DI_Pagination extends CI_Pagination{

	var $per_pages_full_tag_open = '&nbsp;';
	var $per_pages_full_tag_close = '&nbsp;';
	
	var $per_pages_tag_open = '&nbsp;';
	var $per_pages_tag_close = '&nbsp;';

	var $per_pages_separator = '&nbsp;';
	var $per_pages = array(5, 10, 15, 20);
	
	var $uri_page_number;
	var $num_pages;
		
    function __construct($params = array())
    {
        parent::CI_Pagination();

		if (count($params) > 0)
		{
			$this->initialize($params);		
		}
		
		log_message('debug', "Pagination Class Initialized");        
    }

    function get_pages()
    {
    	$this->num_pages = ceil($this->total_rows / $this->per_page);
    	return $this->num_pages;
    }
    
    function get_uri_page_number()
    {  		
		$this->uri_page_number = $this->cur_page;
		
		if ($this->uri_page_number == 0)
		{
			$this->uri_page_number = 1;
		}

		return $this->uri_page_number;
    }
    
    function create_prevnext($page)
    {
    	$output = '';
    	$uri_page_number = $page;
    	//die($uri_page_number.'asdf');
    	//prev
    	if  ($uri_page_number != 1)
		{
			$i = $uri_page_number - 1;
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.'/'.$i.'/'.$this->per_page . '">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}
		
		//next
		if ($uri_page_number != $this->num_pages)
		{
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.'/'.($uri_page_number + 1).'/' . $this->per_page . '">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		//die($output);
		return $output;
    }
    
    function create_selector($current)
    {
    	$output = '';

    	$output .= $this->per_pages_full_tag_open;
    	
    	if ($this->cur_page == 0)
    	{
    		$this->cur_page = '/1'; 
    	}
    	
    	foreach ($this->per_pages as $per_page)
    	{
    		$tmp = $this->per_pages_tag_open;
    			
    		if ($current != $per_page)
    		{
    			$tmp .= '<a href="'.$this->base_url . $this->cur_page . '/' . $per_page . '" >' . $per_page . '</a>';	
    		}
    		else
    		{
    			$tmp .= $per_page;
    		}
    		
    		$tmp .= $this->per_pages_tag_close;
    		
    		$full_tmp[] = $tmp;
    	}

    	$output .= implode($this->per_pages_separator, $full_tmp) . $this->per_pages_full_tag_close;
    	
    	return $output;

    }
    
	function create_links()
	{
		//die($this->base_url);
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		// Calculate the total number of pages
		$num_pages = $this->get_pages();

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.		
		$CI =& get_instance();
		
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		
		if ( ($this->cur_page * $this->per_page) >= $this->total_rows)
		{
			$this->cur_page = $num_pages; //($num_pages - 1);// * $this->per_page;
		}
		
		$uri_page_number = $this->get_uri_page_number();
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		
		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($uri_page_number - $this->num_links) > 0) ? $uri_page_number - ($this->num_links) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $uri_page_number + $this->num_links : $num_pages;
		
		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

  		// And here we go...
		$output = '';

		// Render the "First" link
		if  (($uri_page_number - $this->num_links) >= 1)
		{
			$output .= $this->first_tag_open.'<a href="'.$this->base_url.'/1/' . $this->per_page . '">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($uri_page_number != 1)
		{
			$i = $uri_page_number - 1;
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.$i.'/'.$this->per_page . '">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}

		// Write the digit links
		for ($loop = $start; $loop <= $end; $loop++)
		{
			
			if ($loop <= $num_pages)
			{
				if ( ($uri_page_number) == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$output .= $this->num_tag_open.'<a href="'.$this->base_url.$loop.'/' . $this->per_page . '">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Render the "next" link
		if ($uri_page_number != $num_pages)
		{
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.($uri_page_number + 1).'/' . $this->per_page . '">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if (($uri_page_number + $this->num_links) <= $num_pages)
		{
			$output .= $this->last_tag_open.'<a href="'.$this->base_url.$num_pages . '/' . $this->per_page .'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return $output;		
	}
}

/* End of file DI_Pagination.php */
/* Location: ./system/application/libraries/DI_Pagination.php */