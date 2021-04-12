<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Delivery_boy_apis_model extends CI_Model
{
	public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function hello()
	{
	echo "hello"; die;
	}
	
	public function select($tbl,$con='',$con1='',$con2='',$con3='')
	{

		$this->db->select('*');
		$this->db->from($tbl);

		if ($con)
			$this->db->where($con);

			if ($con1)
				$this->db->where($con1);

				if ($con2)
					$this->db->where($con2);

					if ($con3)
						$this->db->where($con3);


					$this->db->order_by("id", "Desc");
		$q = $this->db->get();
		return $q->result();

	}

	public function select_multi_row($column_name,$table,$con='') {

        $get_column_name = implode(',',$column_name);
        $this->db->select($get_column_name)->from($table)->where($con);
        $res = $this->db->get()->result();
        return $res;
    }

	public function select_hourly($tbl,$mall_id)
	{
		$this->db->select('*');
		$this->db->from($tbl);
		$this->db->where("tstp > DATE_SUB('".tstp."', INTERVAL 24 HOUR) AND mall_id='$mall_id'");		
		$this->db->order_by("id", "Desc");
		$q = $this->db->get();
		return $q->result();

	}

	public function select_ongoing_orders($tbl)
	{
		$this->db->select('*');
		$this->db->from($tbl);
			$this->db->where('order_status IN(1,2)');

					$this->db->order_by("id", "Desc");
		$q = $this->db->get();
		return $q->result();

	}

	public function join_select($select,$tbl1,$tbl2,$on,$con='')
	{
		$this->db->select($select);
		$this->db->from($tbl1);
		$this->db->join($tbl2, $on, 'INNER');	
		if ($con)
			$this->db->where($con);
		$q = $this->db->get();
		return $q->result();

	}

	public function triple_join_select($select,$tbl1,$tbl2,$tbl3,$on2,$on3,$join1,$join2,$con='')
	{
		$this->db->select($select);
		$this->db->from($tbl1);
		$this->db->join($tbl2, $on2, $join1);	
		$this->db->join($tbl3, $on3, $join2);	
		if ($con)
			$this->db->where($con);
		$q = $this->db->get();
		return $q->result();

	}


	public function selectrow($tbl,$con='',$con1='',$con2='',$con3='')
	{
		$this->db->select('*');
		$this->db->from($tbl);

		if ($con)
			$this->db->where($con);

			if ($con1)
				$this->db->where($con1);

				if ($con2)
					$this->db->where($con2);

					if ($con3)
						$this->db->where($con3);



		$q = $this->db->get();
		return $q->row();

	}
	
	public function check_rows_exists($table,$con) {

        $this->db->select('id')->from($table)->where($con);
        $res = $this->db->get()->row();
        return $res;
    } 

	public function insert($tbl,$data)
	{
		
		$res = $this->db->insert($tbl,$data);
		
		return $this->db->insert_id();

	}

	public function select_single_row($column_name,$table,$con='') {

        $get_column_name = implode(',',$column_name);
        $this->db->select($get_column_name)->from($table)->where($con);
        $res = $this->db->get()->row();
        return $res;
    }

	public function update($tbl,$data,$con='')
	{
		if ($con)
		$this->db->where($con);
		$this->db->update($tbl,$data);
		return $this->db->affected_rows();
	}

	public function delete($tbl,$con='')
	{
		$this->db->where($con);
		return $this->db->delete($tbl);
	}
	// ------------------------------------------

	// public function get_question_list()
	// {
	// 	$q=$this->db->select('q.*, s.subject,')
	// 	->from('quiz as q')
	// 	->join('subjects as s', 'q.subject_id=s.id')
	// 	->get()->result();
	// 	return $q;
	// }


}
?>
