<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Base_model', 'base');
    }

    public function event_detail() {

        $id = $this->input->get('id');

        $get_event = $this->base->get('event_name', ['id' => $id])->row();

        $form_id = $this->base->get('forms', ['event_id' => $id])->row()->id;

        $form = $this->base->get_form($form_id);
        $fields = $this->base->get_form_fields($form_id);

        $data = [
            'title' => 'Home Page',
            'row' => $get_event,
            'form' => $form,
            'fields' => $fields
        ];

        $this->frontend->load('frontend/template', 'frontend/event/event_detail', $data);
        
    }

}