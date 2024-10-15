<?php defined('BASEPATH') or exit('No direct script access allowed');

/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 13/10/2024 20:47*/
/*| Please DO NOT modify this information*/


class Event_name_model extends MY_Model
{

  private $table        = "event_name";
  private $primary_key  = "id";
  private $column_order = array('name', 'date_start', 'date_end', 'place', 'description', 'admin_id');
  private $order        = array('event_name.id' => "DESC");
  private $select       = "event_name.id,event_name.name,event_name.date_start,event_name.date_end,event_name.place,event_name.description,event_name.admin_id";

  public function __construct()
  {
    $config = array(
      'table'         => $this->table,
      'primary_key'   => $this->primary_key,
      'select'         => $this->select,
      'column_order'   => $this->column_order,
      'order'         => $this->order,
    );

    parent::__construct($config);
  }

  private function _get_datatables_query()
  {
    $this->db->select($this->select);
    $this->db->from($this->table);
    $this->_get_join();

    if ($this->input->post("name")) {
      $this->db->like("event_name.name", $this->input->post("name"));
    }

    if ($this->input->post("date_start")) {
      $this->db->like("event_name.date_start", date('Y-m-d', strtotime($this->input->post("date_start"))));
    }

    if ($this->input->post("date_end")) {
      $this->db->like("event_name.date_end", date('Y-m-d', strtotime($this->input->post("date_end"))));
    }

    if ($this->input->post("place")) {
      $this->db->like("event_name.place", $this->input->post("place"));
    }

    if ($this->input->post("description")) {
      $this->db->like("event_name.description", $this->input->post("description"));
    }

    if ($this->input->post("admin_id")) {
      $this->db->like("event_name.admin_id", $this->input->post("admin_id"));
    }

    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function get_event($event_id)
  {
    $this->db->select('*');
    $this->db->from('event_name'); // Replace 'event_name' with your event table name
    $this->db->where('id', $event_id);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->row_array(); // Return the event data as an associative array
    } else {
      return false; // Return false if no event found
    }
  }

  public function save_form($data)
  {
    $this->db->insert('forms', $data);
    return $this->db->insert_id();
  }

  public function save_form_field($data)
  {
    $this->db->insert('form_fields', $data);
  }

  public function get_form($form_id)
  {
    // Fetch form details
    return $this->db->where('id', $form_id)->get('forms')->row_array();
  }

  public function get_form_fields($form_id)
  {
    // Fetch form fields
    return $this->db->where('form_id', $form_id)->get('form_fields')->result_array();
  }


  public function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->select($this->select);
    $this->db->from("$this->table");
    $this->_get_join();
    return $this->db->count_all_results();
  }

  public function _get_join()
  {
    $this->db->select("auth_user.name");
    $this->db->join("auth_user", "auth_user.id_user = event_name.admin_id", "left");
  }

  public function get_detail($id)
  {
    $this->db->select("" . $this->table . ".*");
    $this->db->from($this->table);
    $this->_get_join();
    $this->db->where("" . $this->table . '.' . $this->primary_key, $id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return FALSE;
    }
  }
}

/* End of file Event_name_model.php */
/* Location: ./application/modules/event_name/models/Event_name_model.php */
