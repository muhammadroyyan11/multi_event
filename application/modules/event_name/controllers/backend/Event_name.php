<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 16/10/2024 10:34*/
/*| Please DO NOT modify this information*/


class Event_name extends Backend{

private $title = "Event Name";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Event_name_model","model");
}

function index()
{
  $this->is_allowed('event_name_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

public function addForm($event_id)
  {
    $id = dec_url($event_id); // Decrypt the ID if needed

    // Get event details if necessary
    $data['event'] = $this->model->get_event($id);



    // Load the form generator view with event details
    $this->template->view('form_generator', $data);
  }

  public function save_form() {
    $event_id = $this->input->post('event_id');
    
    $formData = [
        'title' => $this->input->post('title'),
        'event_id'  => $event_id,
        'description' => $this->input->post('description')
    ];
    $formId = $this->model->save_form($formData);

    $fields = $this->input->post('fields');
    foreach ($fields as $field) {
        $fieldData = [
            'form_id' => $formId,
            'field_type' => $field['type'],
            'field_label' => $field['label'],
            'field_options' => isset($field['options']) ? $field['options'] : null
        ];
        $this->model->save_form_field($fieldData);
    }

    redirect('cpanel/event_name');
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('event_name_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    foreach ($list as $row) {
        $rows = array();
                $rows[] = $row->name;
                $rows[] = date("d-m-Y",  strtotime($row->date_start));
                $rows[] = date("d-m-Y",  strtotime($row->date_end));
                $rows[] = $row->place;
                $rows[] = $row->description;
                $rows[] = is_image($row->foto_sampul);
                $rows[] = $row->name;
                $rows[] = $row->name;
        
        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="' . url("event_name/addForm/" . enc_url($row->id)). '" id="addForm" class="btn btn-secondary" title="' . cclang("add form") . '">
                        <i class="mdi mdi-plus"></i>
                      </a>
                      <a href="'.url("event_name/detail/".enc_url($row->id)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="'.url("event_name/update/".enc_url($row->id)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="'.url("event_name/delete/".enc_url($row->id)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                        <i class="ti-trash"></i>
                      </a>
                    </div>
                 ';

        $data[] = $rows;
    }

    $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model->count_all(),
                    "recordsFiltered" => $this->model->count_filtered(),
                    "data" => $data,
            );
    //output to json format
    return $this->response($output);
  }
}

function filter()
{
  if(!is_allowed('event_name_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}

function detail($id)
{
  $this->is_allowed('event_name_detail');
    if ($row = $this->model->get_detail(dec_url($id))) {
    $this->template->set_title("Detail ".$this->title);
    $data = array(
          "name" => $row->name,
          "date_start" => $row->date_start,
          "date_end" => $row->date_end,
          "place" => $row->place,
          "description" => $row->description,
          "foto_sampul" => $row->foto_sampul,
          "categories_id" => $row->name,
          "admin_id" => $row->name,
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}

function add()
{
  $this->is_allowed('event_name_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("event_name/add_action"),
                  'name' => set_value("name"),
                  'date_start' => set_value("date_start"),
                  'date_end' => set_value("date_end"),
                  'place' => set_value("place"),
                  'description' => set_value("description"),
                  'foto_sampul' => set_value("foto_sampul"),
                  'categories_id' => set_value("categories_id"),
                  'admin_id' => set_value("admin_id"),
                  );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('event_name_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("name","* Name","trim|xss_clean|required");
    $this->form_validation->set_rules("date_start","* Date start","trim|xss_clean|required");
    $this->form_validation->set_rules("date_end","* Date end","trim|xss_clean|required");
    $this->form_validation->set_rules("place","* Place","trim|xss_clean|required");
    $this->form_validation->set_rules("description","* Description","trim|xss_clean|required");
    $this->form_validation->set_rules("foto_sampul","* Foto sampul","trim|xss_clean|required");
    $this->form_validation->set_rules("categories_id","* Categories","trim|xss_clean");
    $this->form_validation->set_rules("admin_id","* Admin","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['name'] = $this->input->post('name',true);
      $save_data['date_start'] = date("Y-m-d",  strtotime($this->input->post('date_start', true)));
      $save_data['date_end'] = date("Y-m-d",  strtotime($this->input->post('date_end', true)));
      $save_data['place'] = $this->input->post('place',true);
      $save_data['description'] = $this->input->post('description',true);
      $save_data['foto_sampul'] = $this->imageCopy($this->input->post('foto_sampul',true),$_POST['file-dir-foto_sampul']);
      $save_data['categories_id'] = $this->input->post('categories_id',true);
      $save_data['admin_id'] = $this->input->post('admin_id',true);

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("event_name");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function update($id)
{
  $this->is_allowed('event_name_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("event_name/update_action/$id"),
                  'name' => set_value("name", $row->name),
                  'date_start' => $row->date_start == "" ? "":date("Y-m-d",  strtotime($row->date_start)),
                  'date_end' => $row->date_end == "" ? "":date("Y-m-d",  strtotime($row->date_end)),
                  'place' => set_value("place", $row->place),
                  'description' => set_value("description", $row->description),
                  'foto_sampul' => set_value("foto_sampul", $row->foto_sampul),
                  'categories_id' => set_value("categories_id", $row->categories_id),
                  'admin_id' => set_value("admin_id", $row->admin_id),
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('event_name_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("name","* Name","trim|xss_clean|required");
    $this->form_validation->set_rules("date_start","* Date start","trim|xss_clean|required");
    $this->form_validation->set_rules("date_end","* Date end","trim|xss_clean|required");
    $this->form_validation->set_rules("place","* Place","trim|xss_clean|required");
    $this->form_validation->set_rules("description","* Description","trim|xss_clean|required");
    $this->form_validation->set_rules("foto_sampul","* Foto sampul","trim|xss_clean|required");
    $this->form_validation->set_rules("categories_id","* Categories","trim|xss_clean");
    $this->form_validation->set_rules("admin_id","* Admin","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['name'] = $this->input->post('name',true);
      $save_data['date_start'] = date("Y-m-d",  strtotime($this->input->post('date_start', true)));
      $save_data['date_end'] = date("Y-m-d",  strtotime($this->input->post('date_end', true)));
      $save_data['place'] = $this->input->post('place',true);
      $save_data['description'] = $this->input->post('description',true);
      $save_data['foto_sampul'] = $this->imageCopy($this->input->post('foto_sampul',true),$_POST['file-dir-foto_sampul']);
      $save_data['categories_id'] = $this->input->post('categories_id',true);
      $save_data['admin_id'] = $this->input->post('admin_id',true);

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("event_name");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function delete($id)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('event_name_delete')) {
      return $this->response([
        'type_msg' => "error",
        'msg' => "do not have permission to access"
      ]);
    }

      $this->model->remove(dec_url($id));
      $json['type_msg'] = "success";
      $json['msg'] = cclang("notif_delete");


    return $this->response($json);
  }
}


}

/* End of file Event_name.php */
/* Location: ./application/modules/event_name/controllers/backend/Event_name.php */
