<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Base_model', 'base');
    }

    public function index() {

        $get_event = $this->base->get('event_name')->result();

        // var_dump($ge)

        $data = [
            'title' => 'Home Page',
            'event' => $get_event
        ];

        $this->frontend->load('frontend/template', 'frontend/home/home', $data);
        
    }

}