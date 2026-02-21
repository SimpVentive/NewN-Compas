<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router
{
    function _set_request ($seg = array())
    {
        // The str_replace() below goes through all our segments
        // and replaces the hyphens with underscores making it
        // possible to use hyphens in controllers, folder names and
        // function names
        parent::_set_request(str_replace('-', '_', $seg));
    }
}  

class MY_Controller extends CI_Controller {
	
	protected function render($layout,$content) {
		$view_data = array('content' => $content,'stylesheets' => $this->get_stylesheets(),'javascripts' => $this->get_javascripts());
		$this->load->view($layout,$view_data);
	}

	protected $stylesheets = array('app.css');
	protected $javascripts = array('app.js');
	protected $local_stylesheets = array();
	protected $local_javascripts = array();

	protected function get_stylesheets() {
		return array_merge($this->stylesheets,$this->local_stylesheets);
	}

	protected function get_javascripts() {
		return array_merge($this->javascripts,$this->local_javascripts);
	}
}
