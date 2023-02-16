<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    var $logged_in      = false;
    var $skin = 'templates/body';

    public function __construct()
    {
        parent::__construct();
        $this->logged_in = $this->session->userdata('logged_in');
    }

    public function view($vista=false, $datos=false, $as_string=false)
    {
        $data['header'] = $this->header($datos);
        $data['content'] = $vista?$this->load->view($vista, $datos, true):'';
        return $this->load->view($this->skin, $data, $as_string);
    }

    protected function header($datos) {
        if (!$this->logged_in) {
            return $this->load->view('templates/header', $datos, true);
        }
     }
}
