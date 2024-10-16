<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 16/10/2024 12:03*/
/*| Please DO NOT modify this information*/


class Price_categories_model extends MY_Model{

  private $table        = "price_categories";
  private $primary_key  = "id";
  private $column_order = array('id', 'categories_id', 'sub_categories', 'price');
  private $order        = array('price_categories.id'=>"DESC");
  private $select       = "price_categories.id,price_categories.id,price_categories.categories_id,price_categories.sub_categories,price_categories.price";

public function __construct()
	{
		$config = array(
      'table' 	      => $this->table,
			'primary_key' 	=> $this->primary_key,
		 	'select' 	      => $this->select,
      'column_order' 	=> $this->column_order,
      'order' 	      => $this->order,
		 );

		parent::__construct($config);
	}

  private function _get_datatables_query()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);
      $this->_get_join();

    if($this->input->post("categories_id"))
        {
          $this->db->like("price_categories.categories_id", $this->input->post("categories_id"));
        }

    if($this->input->post("sub_categories"))
        {
          $this->db->like("price_categories.sub_categories", $this->input->post("sub_categories"));
        }

    if($this->input->post("price"))
        {
          $this->db->like("price_categories.price", $this->input->post("price"));
        }

      if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }

    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
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
      $this->db->select("categories.name");
      $this->db->join("categories","categories.id = price_categories.categories_id","left");
    }

    public function get_detail($id)
    {
        $this->db->select("".$this->table.".*");
        $this->db->from($this->table);
        $this->_get_join();
        $this->db->where("".$this->table.'.'.$this->primary_key,$id);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
          return $query->row();
        }else{
          return FALSE;
        }
    }

}

/* End of file Price_categories_model.php */
/* Location: ./application/modules/price_categories/models/Price_categories_model.php */
