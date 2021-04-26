<?php
class Lab_Model extends CI_Model
{
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

	public function select_ongoing_orders($tbl,$restaurant_id)
	{
		$this->db->select('*');
		$this->db->from($tbl);
			$this->db->where('order_status IN(1,2) AND vendor_id='.$restaurant_id);

					$this->db->order_by("id", "Desc");
		$q = $this->db->get();
		return $q->result();

	}

	public function select_product_name($id)
	{
		$this->db->select('name');
		$this->db->from('products');
		$this->db->where('id IN('.$id.')');
		$this->db->order_by("id", "Desc");
		$q = $this->db->get();
		return $q->result();

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

	public function triple_join_select($select,$tbl1,$tbl2,$tbl3,$on2,$on3,$con='')
	{
		$this->db->select($select);
		$this->db->from($tbl1);
		$this->db->join($tbl2, $on2, 'INNER');	
		$this->db->join($tbl3, $on3, 'INNER');	
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
	public function insert($tbl,$data)
	{
		$this->db->insert($tbl,$data);
		return $this->db->insert_id();

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
	
	public function select_single_row($column_name,$table,$con='') {

        $get_column_name = implode(',',$column_name);
        $this->db->select($get_column_name)->from($table)->where($con);
        $res = $this->db->get()->row();
        return $res;
    }


}
