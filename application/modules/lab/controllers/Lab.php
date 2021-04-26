	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lab_Model');	
	}

	// public function mobileSendOtp($user_data)
    // {
    // 	return 1;
    // 	die;
    //     try {
    //         //Integrate SMS API here
    //         $mobile = $user_data['mobile'];
    //         $otp = $user_data['otp'];
    //         $authKey = "309952Aq8MczyMxu5e03001fP1";
    //         $senderId = "ADSURL";
    //         $messageMsg = urlencode("<#>Your OTP is: $otp ");
    //         $postData = array(
    //             'authkey' => $authKey,
    //             'mobiles' => $mobile,
    //             'message' => $messageMsg,
    //             'sender' => $senderId,
    //             'route' => 4,
    //             'country' => 91
    //         );
    //         $url = "https://api.msg91.com/api/sendhttp.php";
    //         $ch = curl_init();
    //         curl_setopt_array($ch, array(
    //             CURLOPT_URL => $url,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_POST => true,
    //             CURLOPT_POSTFIELDS => $postData
    //         ));
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //         $output = curl_exec($ch);
    //         if (curl_errno($ch)) {
    //             echo 'error:' . curl_error($ch);
    //         }
    //         curl_close($ch);
    //         if (strlen($output) == 24) {
    //             return 1;
    //         }else{
    //             return 2;
    //         }        } catch (Exception $e) {
    //         return response()->json(['custom_error'=> $e->getMessage()], $this->invalidStatus);        
    //     }   
    //  }


	// public function signup()
	// {		
	// 	$data['setting'] = $this->Lab_Model->selectrow('setting',['id'=>'1']);
	// 	if(!empty($_POST))
	// 		{				
	// 		$this->form_validation->set_rules('name','Name','trim|required');
	// 		$this->form_validation->set_rules('l_name','Last Name','trim|required');
	// 		$this->form_validation->set_rules('mobile_number','Mobile','trim|required');
	// 		$this->form_validation->set_rules('email','Email','trim|required');
	// 		$this->form_validation->set_rules('restaurant_name','restaurant Name','required');
	// 		$this->form_validation->set_rules('street_address','Street Address','required');
	// 		$this->form_validation->set_rules('city','City','required');
	// 		$this->form_validation->set_rules('country','Country','required');
	// 		$this->form_validation->set_rules('estimated_delivery_time','Estimated Delivery Time','required');
	// 		$this->form_validation->set_rules('restaurant_open_timings','Restaurant Open Timings','required');
	// 		$this->form_validation->set_rules('restaurant_close_timings','restaurant_close_timings','required');
	// 		#$this->form_validation->set_rules('restaurant_image','restaurant Image','trim|required');
	// 		#$this->form_validation->set_rules('estimated_delivery_time','Estimated Delivery Time','trim|required');
	// 		#$this->form_validation->set_rules('restaurant_desc','Description','trim|required');
	// 		if (empty($_FILES['id_proof']['name'])) {
	// 			$this->form_validation->set_rules('id_proof','Id Proof','trim|required');
	// 		}

	// 		if (empty($_FILES['restaurant_license']['name'])) {
	// 			$this->form_validation->set_rules('restaurant_license','Restaurant License','trim|required');
	// 		}	
			
	// 		if (empty($_FILES['restaurant_img']['name'])) {
	// 			$this->form_validation->set_rules('restaurant_img','Restaurant Image','trim|required');
	// 		}	

	// 		$this->form_validation->set_rules('account_holder_name','Account Holder Name','trim|required');
	// 		$this->form_validation->set_rules('bank_code','Bank Code','trim|required');
	// 		$this->form_validation->set_rules('account_number','Account Number','trim|required');
	// 		$this->form_validation->set_rules('c_account_number','Confirm Account Number','trim|required|matches[account_number]');
	// 		$this->form_validation->set_rules('password','Password','trim|required');
	// 		$this->form_validation->set_rules('re_password','Re-Enter Password','trim|required|matches[password]');
	// 		$this->form_validation->set_rules('condition','T&C','trim|required');

	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('lab/loginhead');
	// 			mylabview('lab/signup',$data);
	// 		}
	// 		else
	// 		{
	// 			// if (!empty($_FILES['restaurant_image']['name'])) 
	// 			// {
	// 			// 	$v = uploadfile('restaurant_image','assets/restaurant_images/');
	// 			// 	$insert['restaurant_image'] = $v;		
	// 			// }
	// 			if (!empty($_FILES['id_proof']['name'])) 
	// 			{
	// 				$r = uploadfile('id_proof','assets/restaurant_id_proof/');
	// 				$insert['id_proof'] = $r;		
	// 			}

	// 			if (!empty($_FILES['restaurant_license']['name'])) 
	// 			{
	// 				$s = uploadfile('restaurant_license','assets/restaurant_license/');
	// 				$insert['store_license'] = $s;		
	// 			}

	// 			if (!empty($_FILES['restaurant_img']['name'])) 
	// 			{
	// 				$s = uploadfile('restaurant_img','assets/restaurant_images/');
	// 				$insert['store_image'] = $s;		
	// 			}

	// 			$insert['username'] = $this->input->post('name');
	// 			$insert['l_name'] = $this->input->post('l_name');
	// 			$insert['country_code'] = $this->input->post('country_code');
	// 			$insert['mobile'] = $this->input->post('mobile_number');
	// 			$insert['email'] = $this->input->post('email');
	// 			$insert['store_name'] = $this->input->post('restaurant_name');
	// 			$insert['estimated_delivery_time'] = $this->input->post('estimated_delivery_time');
	// 			$insert['store_desc'] = $this->input->post('restaurant_desc');	
	// 			$insert['account_holder_name'] = $this->input->post('account_holder_name');
	// 			$insert['bank_code'] = $this->input->post('bank_code');
	// 			$insert['account_number'] = $this->input->post('account_number');
	// 			$insert['longitude'] = $this->input->post('longitude');
	// 			$insert['latitude'] = $this->input->post('latitude');
	// 			$insert['password'] = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
	// 			$insert['user_status'] = '0';	
	// 			$insert['status'] = '1';	
	// 			$insert['is_deleted'] = '0';	
	// 			$insert['usertype'] = '2';
	// 			$insert['otp '] = mt_rand(1000,9999);
	// 			$insert['otp_status'] = '1';
	// 			$insert['is_verified'] = '0';
	// 			#pr($insert);
	// 			$insert_into = $this->Lab_Model->insert('users',$insert);
	// 			if(!empty($insert_into))
	// 			{ 
	// 				#$this->mobileSendOtp($insert);
	// 				#$this->session->set_flashdata('message',"restaurant has gone ahead for verification.");
					
	// 				$restaurant_address['restaurant_id'] = $insert_into;
	// 				$restaurant_address['street1'] = $this->input->post('street_address');
	// 				$restaurant_address['street2'] = $this->input->post('street_address2');
	// 				$restaurant_address['city'] = $this->input->post('city');
	// 				$restaurant_address['country'] = $this->input->post('country');
	// 				$restaurant_address['is_deleted '] = '0';
	// 				$restaurant_address['status '] = '1';

	// 				$restaurant_address_id = $this->Lab_Model->insert('restaurant_address',$restaurant_address);
	// 				if(!empty($restaurant_address_id))
	// 				{
	// 					$restaurant_timings['restaurant_id'] = $insert_into;
	// 					$restaurant_timings['open_time '] = $this->input->post('restaurant_open_timings');
	// 					$restaurant_timings['close_time '] = $this->input->post('restaurant_close_timings');
	// 					$restaurant_timings['is_deleted '] = '0';
	// 					$restaurant_timings['status '] = '1';
	// 					$this->Lab_Model->insert('restaurant_timings',$restaurant_timings);
	// 					$user_id = $this->session->set_userdata('user_id', $insert_into);
	// 					redirect('lab/otp');
	// 				}
	// 			}
	// 			else
	// 			{   
	// 				$this->session->set_flashdata('error',"Something Wrong!!");
	// 				redirect('lab/login');	
	// 			}
	// 	}
	// 	}else
	// 	{
	// 		mylabview('lab/loginhead');
	// 		mylabview('lab/signup',$data);
	// 	}
	// }

	// public function otp()
	// {
	// 	if($this->session->has_userdata('user_id'))
	// 	{
	// 		$user_id = $this->session->userdata('user_id');
			
	// 		$this->form_validation->set_rules('otp','OTP','trim|required');

	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('restaurant/loginhead');
	// 			mylabview('restaurant/otp');
	// 		}
	// 		else
	// 		{
	// 			$get_otp = $this->input->post('otp');
	// 			$insert_into = $this->Lab_Model->selectrow('users',['otp'=>$get_otp,'id'=>$user_id,'otp_status'=>'1','is_verified'=>'0']);
	// 			if($insert_into)
	// 			{
	// 				$this->Lab_Model->update('users',['otp_status'=>'0','is_verified'=>'1'],['id'=>$user_id]);
	// 				$this->session->unset_userdata('user_id');
	// 				// $this->session->set_userdata('loginrestaurant', $user_id);
	// 				// redirect('restaurant/dashboard');
	// 				$this->session->set_flashdata('message',"Restaurant has gone ahead for verification.");
	// 				redirect('restaurant/login');
	// 			}
	// 			else
	// 			{
	// 				$this->session->set_flashdata('error',"Enter Correct OTP!!");
	// 				redirect('restaurant/otp');
	// 			}
	// 		}			
	// 	}
	// 	else
	// 	{
	// 		redirect('restaurant/login');
	// 	}
	
	// }

	// public function forget_password_otp()
	// {
	// 	if($this->session->has_userdata('user_id'))
	// 	{
	// 		$user_id = $this->session->userdata('user_id');			
	// 		$this->form_validation->set_rules('otp','OTP','trim|required');
	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('restaurant/loginhead');
	// 			mylabview('restaurant/otp');
	// 		}
	// 		else
	// 		{
	// 			$get_otp = $this->input->post('otp');
	// 			$insert_into = $this->Lab_Model->selectrow('users',['otp'=>$get_otp,'id'=>$user_id,'otp_status'=>'1','is_verified'=>'0']);
	// 			if($insert_into)
	// 			{
	// 				$this->Lab_Model->update('users',['otp_status'=>'0','is_verified'=>'1'],['id'=>$user_id]);
	// 				$this->session->unset_userdata('user_id');
	// 				$this->session->set_userdata('new_pass', $user_id);
	// 				redirect('restaurant/create_password');
	// 			}
	// 			else
	// 			{
	// 				$this->session->set_flashdata('error',"Enter Correct OTP!!");
	// 				redirect('restaurant/otp');
	// 			}
	// 		}			
	// 	}
	// 	else
	// 	{
	// 		redirect('restaurant/login');
	// 	}	
	// }

	// public function create_password()
	// {
	// 	if($this->session->has_userdata('new_pass'))
	// 	{
	// 		$user_id = $this->session->userdata('new_pass');		
	// 		$this->form_validation->set_rules('password','Password','trim|required');
	// 		$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]');
	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('restaurant/loginhead');
	// 			mylabview('restaurant/new_password');
	// 		}
	// 		else
	// 		{
	// 			$updated_pass = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
	// 			$update_into = $this->Lab_Model->update('users',['password'=>$updated_pass],['id'=>$user_id]);
	// 			if($update_into)
	// 			{
	// 				$this->session->set_flashdata('message',"Password Updated Successfully!!");
	// 				redirect('restaurant/login');
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		redirect('restaurant/forget');
	// 	}
	// }


	public function login()
	{
		if(!empty($_POST))
			{
			$this->form_validation->set_rules('mobile','Mobile Number','required');
			$this->form_validation->set_rules('password','Password','required');
			if($this->form_validation->run() === FALSE)
			{ 
				mylabview('lab/loginhead');
				mylabview('lab/login');
			}
			else
			{
				$mobile = $this->input->post('mobile');
				$password = $this->input->post('password');

				$user_row = $this->Lab_Model->selectrow('labs',['mobile'=>$mobile,'status'=>'1','is_deleted'=>'0']);

				$hash = @$user_row->password;
			
				if (password_verify($password, $hash)) {
					$this->session->set_userdata('loginlab',$user_row);
					redirect('lab/dashboard');
				} else {					
					$this->session->set_flashdata('error',"Incorrect Username or Password");
					redirect($_SERVER['HTTP_REFERER']);
				}				
			}
		}else
		{
			mylabview('lab/loginhead');
			mylabview('lab/login');
		}
	}
	
	public function lab_timing()
	{
		checklabslogin();
		$id = $this->session->userdata('loginlab')->id;
		$data['sun']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'0']);
		$data['mon']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'1']);
		$data['tue']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'2']);
		$data['wed']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'3']);
		$data['thus']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'4']);
		$data['fri']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'5']);
		$data['sat']=$this->Lab_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'6']);

		if(!empty($_POST))
		{	
			$this->Lab_Model->delete('lab_timing',['lab_id'=>$id]);

			foreach($this->input->post('days') as $k=>$v)
			{	
					$this->Lab_Model->insert('lab_timing',['lab_id'=>$id,'days'=>$v,'o_time'=>$this->input->post('open')[$v],'status'=>'2','c_time'=>$this->input->post('close')[$v]]);
			}	
			
			
					$this->session->set_flashdata('message',"Labs added successfully");
					return redirect($_SERVER['HTTP_REFERER']);
			
		}else{
			mylabview('lab/lab_timing',$data);
		}
		
	}
	
	
	public function forget()
	{
		die('on_process.........');
			$this->form_validation->set_rules('mobile','Mobile Number','required');
			if($this->form_validation->run() === FALSE)
			{ 
				mylabview('restaurant/loginhead');
				mylabview('restaurant/forget');
			}
			else
			{
				$mobile = $this->input->post('mobile');
				$user_row = $this->Lab_Model->selectrow('users',['mobile'=>$mobile,'usertype'=>'1','user_status !='=>'3','status'=>'1','is_deleted'=>'0']);
				if(!empty($user_row))
				{
					
					$update['otp '] = mt_rand(1000,9999);
					$update['otp_status'] = '1';
					$update['is_verified'] = '0';	
					$update_into = $this->Lab_Model->update('users',$update,['id'=>$user_row->id]);
					$user_id = $this->session->set_userdata('user_id', $user_row->id);
					redirect('restaurant/forget_password_otp');

				}
				else
				{
					$this->session->set_flashdata('error',"Mobile Number is not Register with us!!");
					redirect($_SERVER['HTTP_REFERER']);
				}

			}
	}


	public function dashboard()
	{
		checklabslogin();

		// $this->checkporterlogin();
		// $mall_id=$this->session->userdata('loginporter')->mall_id;
		// $data['orders']=$this->Porter_Model->select('orders',['mall_id'=>$mall_id]);
		// $data['pending_orders']=$this->Porter_Model->select('orders',['delivery_status'=>'0','mall_id'=>$mall_id]);
		// $data['complete_orders']=$this->Porter_Model->select('orders',['delivery_status'=>'1','mall_id'=>$mall_id]);
		// $data['today_orders']=$this->Porter_Model->select_hourly('orders',$mall_id);		
		mylabview('lab/dashboard');
	}

	public function logout()
	{
		checklabslogin();
		$this->session->sess_destroy($this->session->userdata('loginrestaurant'));
		redirect('lab/login');	
	}

	// public function product()
	// {
	// 	checkrestaurantlogin();
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;

	// 	$data['product']=$this->Lab_Model->select('products',['vender_id'=>$restaurant_id,'is_approved'=>'1','is_deleted'=>'0']);
	// 	mylabview('restaurant/product',$data);
	// }	

	// public function addProduct()
	// {
	// 	checkrestaurantlogin();
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;

	// 	$data['category']=$this->Lab_Model->select('category',['type'=>'1','status'=>'1','is_deleted'=>'0']);
	// 	if(!empty($_POST))
	// 	{
	// 		$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
	// 		$this->form_validation->set_rules('name', 'Name', 'trim|required');
	// 		$this->form_validation->set_rules('price', 'Price', 'trim|required');
	// 		$this->form_validation->set_rules('item_description', 'Description', 'trim|required');
			
	// 		// if (empty($_FILES['item_image']['name'])) {
	// 		// 	$this->form_validation->set_rules('item_image', 'Item Images', 'required');
	// 		// }

	// 		if($this->form_validation->run()==FALSE){

	// 			mylabview('restaurant/addproduct',$data);
	// 		}else{
				
	// 			$image_data = multiple_uploadfile($_FILES['item_image'],'assets/product_image/');	
	// 			$data = array(
	// 							'name' => ucfirst($this->input->post('name')),
	// 							'price' => $this->input->post('price'),
	// 							'item_description' => $this->input->post('item_description'),
	// 							'vender_id' => $restaurant_id,
	// 							'cat_id' => $this->input->post('cat_name'),
	// 							'subcat_id' => $this->input->post('subcat_name'),								
	// 							'other_details' => $this->input->post('other_details')								
	// 						);
					
	// 			$insert = $this->Lab_Model->insert('products',$data);
	// 			if($insert)
	// 			{
	// 				foreach($image_data as $v)
	// 				{
	// 					$this->Lab_Model->insert('item_images',['user_id'=>$insert,'image'=>$v]);
	// 				}
	// 				$this->session->set_flashdata('message',"Product Send to Admin For Approval");
	// 				return redirect('restaurant/product');
	// 			}				
	// 		}
	// 	}else{
	// 		mylabview('restaurant/addproduct',$data);
	// 	}
	// }

	// public function get_subcat()
	// {
	// 	checkrestaurantlogin();
	// 	$status = false;
	// 	$cat_name = $this->input->post('cat_name');
	// 	$data=$this->Lab_Model->select('sub_category',['category_type'=>'1','is_deleted'=>'0','category_id'=>$cat_name]);
	// 	if($data)
	// 	{
	// 		$status = true;
	// 	}
	// 	echo json_encode(array('status'=>$status, 'data'=>$data));
	// }

	// public function item_status($ide)
    // {
	// 	checkrestaurantlogin();
    //     if(!empty($ide))
    //     {
    //         $id=base64_decode($ide);            
	// 		$check = $this->Lab_Model->selectrow('products',['id'=>$id]);
	// 		$value = ($check->status==1)?'0':'1';
	// 		$msg=($value=='1')?'Product active successfully':'Product inactive successfully';
			
	// 		$this->Lab_Model->update('products',['status'=>$value],['id'=>$check->id]);
    //         $this->session->set_flashdata('message',$msg);
    //         return redirect('restaurant/product');
    //     }else{
    //         return redirect('restaurant/product');
    //     }
	// }

	// public function delete_item($ide)
	// {
	// 	checkrestaurantlogin();
	// 	$id=base64_decode($ide);
	// 	$this->Lab_Model->update('products',['is_deleted'=>'1'],['id'=>$id]);
	// 	$this->session->set_flashdata('message',"Item delete successfully");
	// 	return redirect('restaurant/product');
	// }

	// public function item_image($id)
	// {
	// 	checkrestaurantlogin();
	// 	$id = base64_decode($id);
	// 	$data['products_image']=$this->Lab_Model->select('item_images',['user_id'=>$id,'is_deleted'=>'0']);
	// 	mylabview('restaurant/product_images',$data);
	// 	// if(!empty($_POST))
	// 	// {
	// 	// 	$this->form_validation->set_rules('name', 'Name', 'trim|required');
	// 	// 	$this->form_validation->set_rules('price', 'Address', 'trim|required');
	// 	// 	$this->form_validation->set_rules('product_qty', 'Address', 'trim|required');
			
	// 	// 	if($this->form_validation->run()==FALSE){
	// 	// 		mylabview('restaurant/product_images',$data);
	// 	// 	}else{				
					
	// 	// 		$data = array(
	// 	// 						'name' => ucfirst($this->input->post('name')),
	// 	// 						'price' => $this->input->post('price'),
	// 	// 						'qty' => $this->input->post('product_qty')								
	// 	// 					);
	// 	// 		$insert = $this->Lab_Model->update('products',$data,['id'=>$id]);
	// 	// 		if($insert)
	// 	// 		{				
	// 	// 			$this->session->set_flashdata('message',"Product Update successfully");
	// 	// 			return redirect('restaurant/product');
	// 	// 		}				
	// 	// 	}
	// 	// }else{
	// 	// 	mylabview('restaurant/product_images',$data);
	// 	// }
	// }

	// public function add_more_img($ide)
	// {
	// 	checkrestaurantlogin();
	// 	$id = base64_decode($ide);	
	// 		if(!empty($_FILES['more_img']['name'][0]))
	// 		{
	// 			$image_data = multiple_uploadfile($_FILES['more_img'],'assets/product_image/');				
	// 			if($image_data)
	// 			{
	// 				foreach($image_data as $v)
	// 				{
	// 					$this->Lab_Model->insert('item_images',['user_id'=>$id,'image'=>$v]);
	// 				}
	// 				$this->session->set_flashdata('message',"Image add successfully");
	// 				#return redirect('store/product');
	// 				return redirect($_SERVER['HTTP_REFERER']);
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$this->session->set_flashdata('error',"Select atleast one single picture!!");
	// 			return redirect($_SERVER['HTTP_REFERER']);
	// 		}
			
	// }

	// public function delete_item_image($ide)
	// {
	// 	checkrestaurantlogin();
	// 	$id=base64_decode($ide);
	// 	$data=array('is_deleted'=>'1');

	// 	$this->Lab_Model->update('item_images',$data,['id'=>$id]);
	// 	$this->session->set_flashdata('message',"Image deleted successfully");
	// 	return redirect($_SERVER['HTTP_REFERER']);
	// }

	// public function edit_item($id)
	// {
	// 	checkrestaurantlogin();
	// 	$id = base64_decode($id);
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;
	// 	$data['products']=$this->Lab_Model->selectrow('products',['id'=>$id]);
	// 	$data['category']=$this->Lab_Model->select('category',['type'=>'1','status'=>'1','is_deleted'=>'0']);
	// 	$data['sub_category']=$this->Lab_Model->select('sub_category',['category_type'=>'1','status'=>'1','is_deleted'=>'0','category_id'=>$data['products']->cat_id]);

	// 	if(!empty($_POST))
	// 	{
	// 		$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
	// 		$this->form_validation->set_rules('name', 'Name', 'trim|required');
	// 		$this->form_validation->set_rules('price', 'Price', 'trim|required');
	// 		$this->form_validation->set_rules('item_description', 'Description', 'trim|required');
			
	// 		if($this->form_validation->run()==FALSE){
	// 			mylabview('restaurant/editproduct',$data);
	// 		}else{				
				
	// 			$data = array(
	// 				'name' => ucfirst($this->input->post('name')),
	// 				'price' => $this->input->post('price'),
	// 				'item_description' => $this->input->post('item_description'),
	// 				'vender_id' => $restaurant_id,
	// 				'cat_id' => $this->input->post('cat_name'),
	// 				'subcat_id' => $this->input->post('subcat_name'),								
	// 				'other_details' => $this->input->post('other_details')								
	// 			);
				
	// 			$insert = $this->Lab_Model->update('products',$data,['id'=>$id]);
	// 			if($insert)
	// 			{				
	// 				$this->session->set_flashdata('message',"Product Update successfully");
	// 				return redirect('restaurant/product');
	// 			}				
	// 		}
	// 	}else{
	// 		mylabview('restaurant/editproduct',$data);
	// 	}
	// }

	// public function orders_request()
	// {
	// 	checkrestaurantlogin();
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;
	// 		$data['orders_request'] = $this->Lab_Model->select('orders',['is_approved'=>'0','vendor_type '=>'1','vendor_id'=>$restaurant_id]);		
	// 		mylabview('restaurant/order_request',$data);		
	// }

	// public function ongoing_orders()
	// {
	// 	checkrestaurantlogin();
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;
	// 		$data['ongoing_orders'] = $this->Lab_Model->select_ongoing_orders('orders',$restaurant_id);		
	// 		mylabview('restaurant/ongoing_orders',$data);		
	// }

	// public function complete_orders()
	// {
	// 	checkrestaurantlogin();
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;
	// 		$data['complete_orders'] = $this->Lab_Model->select('orders',['order_status'=>'3','vendor_type '=>'1','vendor_id'=>$restaurant_id]);		
	// 		mylabview('restaurant/complete_orders',$data);		
	// }

	// public function view_request_orders_details($id)
	// {
	// 	checkrestaurantlogin();
	// 	$id = base64_decode($id);

	// 	$data['orders']=$this->Lab_Model->selectrow('orders',['id'=>$id]);
	// 	$data['vender_details']=$this->Lab_Model->selectrow('users',['id'=>$data['orders']->vendor_id]);
	// 	$product_details = json_decode($data['orders']->product_details); 
	// 	foreach($product_details as $key) 
	// 	{ 	
	// 		$datadetails = $this->Lab_Model->selectrow('products',['id'=>$key->product_id]);
	// 		$datadetails->qty = $key->qty;
	// 		$productName[] = $datadetails;
	// 		// pr($data);	
	// 	}
		
	// 	$data['orders']->pro_name = $productName;
	// 	mylabview('restaurant/view_request_orders_details',$data);
	// }

	// public function action_orders_request($action='',$id='')
	// {
	// 	checkrestaurantlogin();		
	// 	if(!empty($action) || !empty($id))
	// 	{			
	// 		$action = base64_decode($action);
	// 		$id = base64_decode($id);
			
	// 		if($action === '1')
	// 		{
	// 			$this->Lab_Model->update('orders',['order_status'=>'1'],['id'=>$id]);	
	// 		}			
	// 		$this->Lab_Model->update('orders',['is_approved'=>$action],['id'=>$id]);
	// 	}
	// 	else
	// 	{
	// 		redirect('restaurant/orders_request');
	// 	}
	// 	redirect('restaurant/orders_request');
	// }
	// public function update_delivery_status()
	// {
	// 	checkrestaurantlogin();
	// 	$status = false;
	// 	if(isset($_POST))
	// 	{		
	// 		$d_status = $this->input->post('d_status');
	// 		$row_id = $this->input->post('row_id');

	// 		$update = $this->Lab_Model->update('orders',['order_status'=>$d_status],['id'=>$row_id]);
	// 		if($update)
	// 		{				
	// 			$status = true;
	// 		}
	// 		else
	// 		{
	// 			$status = false;
	// 		}
	// 	}	
	// 	echo json_encode(array('status'=>$status));
	// }

	// public function update_profile()
	// {
	// 	checkrestaurantlogin();
	// 	$id = $this->session->userdata('loginrestaurant')->id;

	// 	$data['profile_details'] = $this->Lab_Model->selectrow('users',['id'=>$id,'usertype'=>'2','is_verified'=>'1','user_status'=>'1','status'=>'1','is_deleted'=>'0']);
	// 	$data['address'] = $this->Lab_Model->selectrow('restaurant_address',['restaurant_id'=>$data['profile_details']->id,'status'=>'1','is_deleted'=>'0']);
	// 	$data['timming'] = $this->Lab_Model->selectrow('restaurant_timings',['restaurant_id'=>$data['profile_details']->id,'status'=>'1','is_deleted'=>'0']);
		
		
		
	// 	if(!empty($_POST))
	// 	{	
	// 		$this->form_validation->set_rules('name','Name','trim|required');
	// 		$this->form_validation->set_rules('l_name','Last Name','trim|required');
	// 		$this->form_validation->set_rules('email','Email','trim|required');
	// 		$this->form_validation->set_rules('restaurant_name','restaurant Name','required');
	// 		$this->form_validation->set_rules('street1','Street Address','required');
	// 		$this->form_validation->set_rules('city','City','required');
	// 		$this->form_validation->set_rules('country','Country','required');
	// 		$this->form_validation->set_rules('estimated_delivery_time','Estimated Delivery Time','required');
	// 		$this->form_validation->set_rules('restaurant_open_timings','Restaurant Open Timings','required');
	// 		$this->form_validation->set_rules('restaurant_close_timings','restaurant_close_timings','required');
			
	// 		$this->form_validation->set_rules('account_holder_name','Account Holder Name','trim|required');
	// 		$this->form_validation->set_rules('bank_code','Bank Code','trim|required');
	// 		$this->form_validation->set_rules('account_number','Account Number','trim|required');
	// 		$this->form_validation->set_rules('confirmation','Checkbox','required');
			
	// 		if($this->form_validation->run()==FALSE){
	// 			mylabview('restaurant/edit_profile',$data);
	// 		}
	// 		else
	// 		{
	// 			if (!empty($_FILES['id_proof']['name'])) 
	// 			{
	// 				$r = uploadfile('id_proof','assets/restaurant_id_proof/');
	// 				$insert['id_proof'] = $r;		
	// 			}

	// 			if (!empty($_FILES['restaurant_license']['name'])) 
	// 			{
	// 				$s = uploadfile('restaurant_license','assets/restaurant_license/');
	// 				$insert['store_license'] = $s;		
	// 			}


	// 			$insert['username'] = $this->input->post('name');
	// 			$insert['l_name'] = $this->input->post('l_name');
	// 			$insert['email'] = $this->input->post('email');
	// 			$insert['store_name'] = $this->input->post('restaurant_name');
	// 			$insert['estimated_delivery_time'] = $this->input->post('estimated_delivery_time');
	// 			$insert['account_holder_name'] = $this->input->post('account_holder_name');
	// 			$insert['bank_code'] = $this->input->post('bank_code');
	// 			$insert['account_number'] = $this->input->post('account_number');
	// 			$insert['user_status'] = '0';	

	// 			$restaurant_address['street1'] = $this->input->post('street1');
	// 			$restaurant_address['street2'] = $this->input->post('street2');
	// 			$restaurant_address['city'] = $this->input->post('city');
	// 			$restaurant_address['country'] = $this->input->post('country');

	// 			$restaurant_timings['open_time '] = $this->input->post('restaurant_open_timings');
	// 			$restaurant_timings['close_time '] = $this->input->post('restaurant_close_timings');

				
	// 			$this->Lab_Model->update('users',$insert,['id'=>$id]);
	// 			$this->Lab_Model->update('restaurant_address',$restaurant_address,['restaurant_id'=>$id]);
	// 			$this->Lab_Model->update('restaurant_timings',$restaurant_timings,['restaurant_id'=>$id]);
	// 			#$this->session->set_flashdata('message',"Password Updated");
	// 			return redirect('restaurant/logout');								
	// 		}				
			
	// 	}
	// 	else{
	// 		mylabview('restaurant/edit_profile',$data);
	// 	}
	// }

	// public function change_password()
	// {
	// 	checkrestaurantlogin();	
	// 	$id = $this->session->userdata('loginrestaurant')->id;

	// 	if(!empty($_POST))
	// 	{	
	// 		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
	// 		$this->form_validation->set_rules('password', 'Password', 'trim|required');
	// 		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
			
	// 		if($this->form_validation->run()==FALSE){
	// 			mylabview('restaurant/change_password');
	// 		}
	// 		else
	// 		{
	// 			$restaurant_pass = $this->Lab_Model->selectrow('users',['id'=>$id]);

	// 			if(password_verify($this->input->post('old_password'),$restaurant_pass->password))
	// 			{
	// 				$data2['password']  = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
	// 				$this->Lab_Model->update('users',$data2,['id'=>$id]);
	// 				$this->session->set_flashdata('message',"Password Updated");
	// 				return redirect($_SERVER['HTTP_REFERER']);
	// 			}
	// 			else
	// 			{
	// 				$this->session->set_flashdata('message',"Old Password Incorrect!!");
	// 				return redirect($_SERVER['HTTP_REFERER']);			
	// 			}		
	// 		}	
	// 	}
	// 	else{
	// 		mylabview('restaurant/change_password');
	// 	}
	// }

	// public function faq()
	// {
	// 	$user_id = $this->session->userdata('loginrestaurant')->id;			
	// 		$this->form_validation->set_rules('faq','FAQ','trim|required');
	// 		$data['insert_into'] = $this->Lab_Model->selectrow('faq',['vendor_id'=>$user_id]);

	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('restaurant/faq',$data);
	// 		}
	// 		else
	// 		{
	// 			$faq = $this->input->post('faq');

	// 			if($data['insert_into'])
	// 			{
	// 				$this->Lab_Model->update('faq',['faq '=>$faq],['vendor_id'=>$user_id]);				
	// 				$this->session->set_flashdata('message',"FAQ's Updated Successfully");
	// 				return redirect($_SERVER['HTTP_REFERER']);		
	// 			}
	// 			else
	// 			{
	// 				$this->Lab_Model->insert('faq',['faq '=>$faq,'vendor_id'=>$user_id]);
	// 				$this->session->set_flashdata('message',"FAQ's Added Successfully");
	// 				return redirect($_SERVER['HTTP_REFERER']);		
	// 			}
	// 		}	
	
	// }

	// public function about_us()
	// {
	// 	$user_id = $this->session->userdata('loginrestaurant')->id;			
	// 		$this->form_validation->set_rules('about_us','About us','trim|required');
	// 		$data['insert_into'] = $this->Lab_Model->selectrow('about_us',['vendor_id'=>$user_id]);

	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			mylabview('restaurant/about_us',$data);
	// 		}
	// 		else
	// 		{
	// 			$about_us = $this->input->post('about_us');

	// 			if($data['insert_into'])
	// 			{
	// 				$this->Lab_Model->update('about_us',['about_us '=>$about_us],['vendor_id'=>$user_id]);				
	// 				$this->session->set_flashdata('message',"About Us Updated Successfully");
	// 				return redirect($_SERVER['HTTP_REFERER']);		
	// 			}
	// 			else
	// 			{
	// 				$this->Lab_Model->insert('about_us',['about_us '=>$about_us,'vendor_id'=>$user_id]);
	// 				$this->session->set_flashdata('message',"About Us Added Successfully");
	// 				return redirect($_SERVER['HTTP_REFERER']);		
	// 			}
	// 		}	
	
	// }
	


}
?>