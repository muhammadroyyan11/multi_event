<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Base_model extends CI_Model
{
    public $perPage = 4;
    public function getUser($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function get_form($form_id)
    {
        return $this->db->where('id', $form_id)
            ->order_by('id', 'desc') // Order by id in descending order
            ->get('forms')
            ->row_array();
    }
    public function get_form_fields($form_id)
    {
        return $this->db->where('form_id', $form_id)->get('form_fields')->result_array();
    }

    public function get($table, $where = null, $order = null, $limit = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        if ($order != null) {
            $this->db->order_by($order);
        }
        if ($limit != null) {
            $this->db->limit($limit);
        }
        $sql = $this->db->get($table);
        return $sql;
    }

    public function get_price($where = null)
    {
        $this->db->select('*');
        $this->db->from('price_categories');
        $this->db->join('categories', 'categories.id = price_categories.categories_id');
        $this->db->join('event_name', 'event_name.categories_id = categories.id');

        if ($where != null) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        return $query;
    }

    public function get_last_number()
    {
        $this->db->select('RFQNumber');
        $this->db->from('rfq_request');
        $this->db->order_by('RFQNumber', 'DESC');
        return $this->db->get();
    }

    public function CreateCode()
    {
        $this->db->select('RIGHT(rfq_request.RFQNumber,5) as RFQNumber', FALSE);
        $this->db->order_by('RFQNumber', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('rfq_request');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->RFQNumber) + 1;
        } else {
            $kode = 1;
        }
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = "RFQ" . $batas;
        return $kodetampil;
    }

    public function getTable($table, $where = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != null) {
            $this->db->where($where);
        }

        return $this->db->get();
    }

    public function count($table, $where = null)
    {
        return $this->db->get_where($table, $where)->num_rows();
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function get_max_id($table, $field, $where)
    {
        $this->db->select_max($field);
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function get_group_id($table, $group_by)
    {
        $this->db->group_by($group_by);
        $this->db->order_by($group_by . " DESC");
        $sql = $this->db->get($table);
        return $sql;
    }
    public function add($table, $data)
    {
        $this->db->insert($table, $data);
    }
    public function del($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function edit($table, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function join_multiple($table, $join, $pq, $join1, $pq1, $order, $az)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($join, $pq);
        $this->db->join($join1, $pq1);
        $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function get_id($table, $where)
    {
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function fetch_data($table, $field, $num, $offset)
    {
        empty($offset) ? $offset = 0 : $offset;

        $this->db->query("SET @no=" . $offset);
        $this->db->select('*,(@no:=@no+1) AS nomor');
        $this->db->group_by($field);
        $this->db->order_by($field, 'DESC');

        $data = $this->db->get($table, $num, $offset);

        return $data->result();
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function makePagination($baseUrl, $uriSegment, $totalRows = null)
    {
        $this->load->library('pagination');

        $config = [
            'base_url'            => $baseUrl,
            'uri_segment'         => $uriSegment,
            'per_page'            => 3,
            'total_rows'          => $totalRows,
            'use_page_numbers'    => true,

            'full_tag_open'       => '<ul class="pagination justify-content-center">',
            'full_tag_close'      => '</ul>',

            'attributes'          => ['class' => 'page-link text-danger'],
            'first_link'          => false,
            'last_link'           => false,
            'first_tag_open'      => '<li class="page-item">',
            'first_tag_close'     => '</li>',
            'prev_link'           => '&lt',
            'prev_tag_open'       => '<li class="page-item">',
            'prev_tag_close'      => '</li>',
            'next-link'           => '&gt',
            'next_tag_open'       => '<li class="page-item">',
            'next_tag_close'      => '</li>',
            'last_tag_open'       => '<li class="page-item">',
            'last_tag_close'      => '</li>',
            'cur_tag_open'        => '<li class="page-item danger"><a href="#" class="page-link text-white">',
            'cur_tag_close'       => '<span class="sr-only"></span></a></li>',
            'num_tag_open'        => '<li class="page-item">',
            'num_tag_close'       => '</li>'
        ];

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    public function getAllPosting($id = null, $where = null, $page)
    {
        $this->db->from('artikel');
        if ($where != null) {
            $this->db->where($where);
        }
        $this->paginate($page);
        $this->db->order_by('artikel.id', 'desc');
        return $this->db->get()->result();
    }

    public function paginate($page)
    {
        return  $this->db->limit($this->perPage, $this->calculateRealOffset($page));
    }
    public function calculateRealOffset($page)
    {
        if (is_null($page) || empty($page)) {
            $offset = 0;
        } else {
            $offset = ($page * $this->perPage) - $this->perPage;
        }

        return $offset;
    }

    public function numbering()
    {
        $this->db->select('*');
        $this->db->from('numberFormat');
        $this->db->order_by('number', 'DESC');
        return $this->db->get()->row();
    }

    function get_all_id()
    {
        $this->db->select('id_user');
        $this->db->from('auth_user');
        return $this->db->get();
    }
}
