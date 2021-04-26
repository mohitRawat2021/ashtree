<?php
function pr($data)
   {
       echo "<pre>";
       print_r($data);
       die;
   }
function uploadfile($name,$location)  //upload method
  {
    $ci= & get_instance();
    if(!empty($name))
    {
      // $this->form_validation->set_rules($name, 'Document', 'required');
    $config['upload_path']      = $location;
    $config['allowed_types']    = 'gif|jpg|png';          
    $config['file_name']        = date('ymdhis').$_FILES[$name]['name'];
    
    $ci->upload->initialize($config);
    $ci->load->library('upload', $config);
   
      if (!$ci->upload->do_upload($name))
      {
      echo $ci->upload->display_errors();
      }
      else
      {
        $imgdata = $ci->upload->data();
      return  $img = $imgdata['file_name'];
      }
    }else{
    return  $img = '';
    }
  }

  function multiple_uploadfile($files,$uploadPath){
       
    $data = array();   
    $cpt = count($files['name']);
    if(!empty($files['name'])){
    for($i=0; $i<$cpt; $i++){

            $_FILES['file']['name']     = date('ymdhis').$files['name'][$i];
            $_FILES['file']['type']     = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error']     = $files['error'][$i];
            $_FILES['file']['size']     = $files['size'][$i];

            $ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);//get extension

          move_uploaded_file($_FILES['file']['tmp_name'],$uploadPath.$_FILES['file']['name']);            
        $aa[]=$_FILES['file']['name'];      
    }
    return $aa;
  }
      return false;
}

  function checklabslogin()
  {
    $ci = & get_instance();
    if(empty($ci->session->userdata('loginlab')))
    {
      redirect('lab/login');
    }    
  }

  function is_unique($table,$con)
  {
    $ci = & get_instance();
    $ci->db->select('id');
		$ci->db->from($table);
		$ci->db->where($con);	
    $q = $ci->db->get();
		$count = $q->result();
    return count($count);
  }

  function checkadminlogin()
  {
    $ci = & get_instance();
    if(empty($ci->session->userdata('loginadmin')))
    {
      redirect('admin');
    }    
  }

  function myview($data,$data2='')
  {
    $ci = & get_instance();
    $ci->load->view('admin/'.$data,$data2);
    return true;
  }

  function mylabview($data,$data2='')
  {
    $ci = & get_instance();
    $ci->load->view('lab/'.$data,$data2);
    return true;
  }

  function is_token_valid()  //upload method
  {
    $ci= & get_instance();

    $headerStringValue = apache_request_headers();
    $authorization_key = @$headerStringValue['authorization'];

    $check_exist = $ci->Apimodel->check_rows_exists('jwt_token',['token'=>$authorization_key, 'is_active'=>'1']);
    if(!empty($check_exist))
    {
        if($ci->authorization_token->validateToken()['status'] === 1)
        {
          return $ci->authorization_token->validateToken();
        }
        else
        {
         return false;
        }
    }
    else
    {
        return false;
    }
  }

  function closest_malls($type,$column, $lat, $lng, $max_distance_km= 50, $units = 'kilometers',$keys='')
  {
    $ci= & get_instance();      
    switch ( $units ) {
    default:
    case 'miles':
    //radius of the great circle in miles
    $gr_circle_radius = 3959;
    break;
    case 'kilometers':
    //radius of the great circle in kilometers
    $gr_circle_radius = 6371;
    break;
    }
      $column_name = implode(',',$column);
      $ci->db->select("$column_name, ( $gr_circle_radius * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( `longitude` ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance");
      $ci->db->from("users");
      $ci->db->having(('distance < '.$max_distance_km));
      $ci->db->where('status','1');
      $ci->db->where('is_verified','1');
      $ci->db->where('is_deleted','0');
      $ci->db->where('usertype',$type);
      if(!empty($keys))
      $ci->db->where_not_in('id', $keys);
      // $query = "SELECT id, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( `long` ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM monastery HAVING distance < $max_distance_km_order ORDER BY distance LIMIT 0 , 20";
      $query = $ci->db->get();
      return $query->result();
    }
  
?>