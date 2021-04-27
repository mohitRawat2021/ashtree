<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_Model');	
	}

	// public function forget_password()
	// {
	// 	if($this->session->has_userdata('user_id'))
	// 	{
	// 		$user_id = $this->session->userdata('user_id');			
	// 		$this->form_validation->set_rules('otp','OTP','trim|required');
	// 		if($this->form_validation->run() === FALSE)
	// 		{ 
	// 			myview('store/loginhead');
	// 			myview('store/otp');
	// 		}
	// 		else
	// 		{
	// 			$get_otp = $this->input->post('otp');
	// 			$insert_into = $this->Store_Model->selectrow('users',['otp'=>$get_otp,'id'=>$user_id,'otp_status'=>'1','is_verified'=>'0']);
	// 			if($insert_into)
	// 			{
	// 				$this->Store_Model->update('users',['otp_status'=>'0','is_verified'=>'1'],['id'=>$user_id]);
	// 				$this->session->unset_userdata('user_id');
	// 				$this->session->set_userdata('new_pass', $user_id);
	// 				redirect('store/create_password');
	// 			}
	// 			else
	// 			{
	// 				$this->session->set_flashdata('error',"Enter Correct OTP!!");
	// 				redirect('store/otp');
	// 			}
	// 		}			
	// 	}
	// 	else
	// 	{
	// 		redirect('store/login');
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
	// 			myview('store/loginhead');
	// 			myview('store/new_password');
	// 		}
	// 		else
	// 		{
	// 			$updated_pass = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
	// 			$update_into = $this->Store_Model->update('users',['password'=>$updated_pass],['id'=>$user_id]);
	// 			if($update_into)
	// 			{
	// 				$this->session->set_flashdata('message',"Password Updated Successfully!!");
	// 				redirect('store/login');
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		redirect('store/forget');
	// 	}
	// }


	public function index()
	{
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('email','Email Id','required');
			$this->form_validation->set_rules('password','Password','required');
			if($this->form_validation->run() === FALSE)
			{ 
				myview('admin/loginhead');
				myview('admin/login');
			}
			else
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$user_row = $this->Admin_Model->selectrow('users',['email'=>$email,'usertype'=>'0','is_verified'=>'1','user_status'=>'1','status'=>'1','is_deleted'=>'0']);
				$hash = @$user_row->password;
				if (password_verify($password, $hash)) {
					$this->session->set_userdata('loginadmin',$user_row);
					redirect('admin/dashboard');
				} else {
					$this->session->set_flashdata('error',"Incorrect Email or Password");
					redirect($_SERVER['HTTP_REFERER']);
			}				
		}
		}else
		{
			myview('admin/loginhead');
			myview('admin/login');
		}
	}
	
	
	public function forget()
	{
		die('work on_process..........');
			$this->form_validation->set_rules('mobile','Mobile Number','required');
			if($this->form_validation->run() === FALSE)
			{ 
				myview('store/loginhead');
				myview('store/forget');
			}
			else
			{
				$mobile = $this->input->post('mobile');
				$user_row = $this->Store_Model->selectrow('users',['mobile'=>$mobile,'usertype'=>'1','user_status !='=>'3','status'=>'1','is_deleted'=>'0']);
				if(!empty($user_row))
				{
					
					$update['otp '] = mt_rand(1000,9999);
					$update['otp_status'] = '1';
					$update['is_verified'] = '0';	
					$update_into = $this->Store_Model->update('users',$update,['id'=>$user_row->id]);
					$user_id = $this->session->set_userdata('user_id', $user_row->id);
					redirect('store/forget_password_otp');

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
		checkadminlogin();
		// $this->checkporterlogin();
		// $mall_id=$this->session->userdata('loginporter')->mall_id;
		// $data['orders']=$this->Porter_Model->select('orders',['mall_id'=>$mall_id]);
		// $data['pending_orders']=$this->Porter_Model->select('orders',['delivery_status'=>'0','mall_id'=>$mall_id]);
		// $data['complete_orders']=$this->Porter_Model->select('orders',['delivery_status'=>'1','mall_id'=>$mall_id]);
		// $data['today_orders']=$this->Porter_Model->select_hourly('orders',$mall_id);		
		myview('admin/dashboard');
	}

	public function logout()
	{
		checkadminlogin();
		$this->session->sess_destroy($this->session->userdata('loginadmin'));
		redirect('admin');	
	}

	// public function registration_requests()
	// {
	// 	checkadminlogin();
	// 	$data['select_request'] = $this->Admin_Model->select('users',['usertype !='=>'0','is_verified'=>'1','user_status'=>'0','status'=>'1','is_deleted'=>'0']);		
	// 	myview('admin/registration_request',$data);
	// }

	
	// public function action_request($action='',$id='')
	// {
	// 	checkadminlogin();		
	// 	if(!empty($action) || !empty($id))
	// 	{
	// 		$action = base64_decode($action);
	// 		$id = base64_decode($id);			
	// 		$this->Admin_Model->update('users',['user_status'=>$action],['id'=>$id]);
	// 	}
	// 	else
	// 	{
	// 		redirect('admin/registration_requests');
	// 	}
	// 	redirect('admin/registration_requests');
	// }

	// public function view_details($id='')
	// {
	// 	checkadminlogin();		
	// 	if(!empty($id))
	// 	{
	// 		$id = base64_decode($id);			
	// 		$get_usertype = $this->Admin_Model->selectrow('users',['id'=>$id]);
	// 		if($get_usertype->usertype === '1') //1=store
	// 		{
	// 			$data['store_details'] =  $this->Admin_Model->selectrow('users',['id'=>$id]);
	// 			myview('admin/view_store_details',$data);
	// 		}
	// 		else if($get_usertype->usertype === '2') //2=restaurant
	// 		{
	// 			$data['restaurant_details'] =  $this->Admin_Model->triple_join_select('u.*,rt.open_time,rt.close_time,ra.street1,ra.street2,ra.city,ra.country',
	// 																				  'users as u',
	// 																				  'restaurant_timings as rt',
	// 																				  'restaurant_address as ra',
	// 																				  'u.id=rt.restaurant_id',
	// 																				  'u.id=ra.restaurant_id',
	// 																				  'left',
	// 																				  'left',
	// 																				  ['u.is_verified=>"1"','u.id'=>$id]
	// 																				);
	// 			myview('admin/view_restaurant_details',$data);
	// 		}
	// 		else
	// 		{
	// 			redirect('admin/registration_requests');
	// 		}	
	// 	}
	// 	else
	// 	{
	// 		redirect('admin/registration_requests');
	// 	}
	// }

	public function category()
	{
		checkadminlogin();
		$data['category']=$this->Admin_Model->select('category',['is_deleted'=>'0']);
		myview('admin/category',$data);
	}	

	public function addCategory()
	{
		checkadminlogin();
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			
			if (empty($_FILES['img']['name'])) {
				$this->form_validation->set_rules('img', 'Images', 'required');
			}

			if($this->form_validation->run()==FALSE){
				myview('admin/addcategory');

			}else{
				
				$image_data = uploadfile('img','assets/category_img/');	
				#pr($image_data);			
				$data = array(
								'name' => ucfirst($this->input->post('name')),						
								'img' => $image_data
							);		
				$insert = $this->Admin_Model->insert('category',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Category add successfully");
					return redirect('admin/category');
				}				
			}
		}else{
			myview('admin/addcategory');
		}
	}

	public function edit_category($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);  
		$data['category_details']=$this->Admin_Model->selectrow('category',['id'=>$id]);
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');			

			if($this->form_validation->run()==FALSE){
				myview('admin/editcategory',$data);

			}else{			

				$datas['name'] = ucfirst($this->input->post('name'));
				$datas['type'] = $this->input->post('type');
				if (!empty($_FILES['img']['name'])) {
					$image_data = uploadfile('img','assets/category_img/');	
					$datas['img'] = $image_data;

				}
				$insert = $this->Admin_Model->update('category',$datas,['id'=>$id]);
				if($insert)
				{
					$this->session->set_flashdata('message',"Category Updated successfully");
					return redirect('admin/category');
				}				
			}
		}else{
			myview('admin/editcategory',$data);
		}
	}

	public function categoryStatus($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('category',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'Category active successfully':'Category inactive successfully';
			
			$this->Admin_Model->update('category',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/category');
        }else{
            return redirect('admin/category');
        }
	}
	public function categorydelete($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('category',['is_deleted'=>'1'],['id'=>$id]);
		$this->Admin_Model->update('sub_category',['is_deleted'=>'1'],['category_id'=>$id]);
		$this->session->set_flashdata('message',"Category delete successfully");
		return redirect('admin/category');
	}	

	public function lab_test()
	{
		checkadminlogin();		
		#$data['lab_test']=$this->Admin_Model->select('lab_test',['is_deleted'=>'0']);
		$data['lab_test']=$this->Admin_Model->join_select('lt.*,c.name as cat_name',
															'lab_test as lt',
															'category as c','c.id=lt.cat_id',
															'Inner',
															['c.is_deleted'=>'0','c.status'=>'1','lt.is_deleted'=>'0']);

		myview('admin/lab_test',$data);
	}	

	public function add_lab_test()
	{
		checkadminlogin();

		$data['category']=$this->Admin_Model->select('category',['status'=>'1','is_deleted'=>'0']);
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('preparation', 'Preparation', 'trim|required');
			$this->form_validation->set_rules('do_dont', "Do & Don't", 'trim|required');
			$this->form_validation->set_rules('components', 'Components', 'trim|required');
			$this->form_validation->set_rules('use_of_test', 'Use of Test', 'trim|required');
			$this->form_validation->set_rules('test_info', 'Test Information', 'trim|required');
			$this->form_validation->set_rules('home_visit', 'Home Visit', 'trim|required');
			
			if (empty($_FILES['thumb_img']['name'])) {
				$this->form_validation->set_rules('thumb_img', 'Thumb Images', 'required');
			}
			if (empty($_FILES['item_image']['name'])) {
				$this->form_validation->set_rules('item_image', 'Item Images', 'required');
			}

			if($this->form_validation->run()==FALSE){

				myview('admin/add_lab_test',$data);
			}else{
				
				$thumb_img = uploadfile('thumb_img','assets/test_image/');	
				$image_data = uploadfile('item_image','assets/test_image/');	
				$data = array(
								'name' => $this->input->post('name'),
								'price' => $this->input->post('price'),
								'preparation' => $this->input->post('preparation'),
								'cat_id' => $this->input->post('cat_name'),
								'do_dont' => $this->input->post('do_dont'),								
								'use_of_test' => $this->input->post('use_of_test'),								
								'test_info' => $this->input->post('test_info'),								
								'home_visit' => $this->input->post('home_visit'),								
								'thumb_img' => '/assets/test_image/'.$thumb_img,								
								'galary_img' => '/assets/test_image/'.$image_data,								
								'components' => $this->input->post('components')								
							);
				$insert = $this->Admin_Model->insert('lab_test',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Test Added Successfully");
					return redirect('admin/lab_test');
				}				
			}
		}else{
			myview('admin/add_lab_test',$data);
		}
	}

	public function edit_lab_test($eid)
	{
		checkadminlogin();
		$id = base64_decode($eid);

		$data['category']=$this->Admin_Model->select('category',['status'=>'1','is_deleted'=>'0']);
		$data['lab_test']=$this->Admin_Model->selectrow('lab_test',['id'=>$id]);

		if(!empty($_POST))
		{
			$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('preparation', 'Preparation', 'trim|required');
			$this->form_validation->set_rules('do_dont', "Do & Don't", 'trim|required');
			$this->form_validation->set_rules('components', 'Components', 'trim|required');
			$this->form_validation->set_rules('use_of_test', 'Use of Test', 'trim|required');
			$this->form_validation->set_rules('test_info', 'Test Information', 'trim|required');
			$this->form_validation->set_rules('home_visit', 'Home Visit', 'trim|required');

			
			// if (empty($_FILES['thumb_img']['name'])) {
			// 	$this->form_validation->set_rules('thumb_img', 'Thumb Images', 'required');
			// }
			// if (empty($_FILES['item_image']['name'])) {
			// 	$this->form_validation->set_rules('item_image', 'Item Images', 'required');
			// }

			if($this->form_validation->run()==FALSE){
				myview('admin/edit_lab_test',$data);
			}else{
				if (!empty($_FILES['thumb_img']['name'])) {
						$thumb_img = uploadfile('thumb_img','assets/test_image/');
						$data2['thumb_img'] = '/assets/test_image/'.$thumb_img;
					}
				
				if (!empty($_FILES['item_image']['name'])) {
					$image_data = uploadfile('item_image','assets/test_image/');	
					$data2['thumb_img'] = '/assets/test_image/'.$image_data;
				}
				
				$data2['name'] = $this->input->post('name');
				$data2['price'] = $this->input->post('price');
				$data2['preparation'] = $this->input->post('preparation');
				$data2['cat_id'] = $this->input->post('cat_name');
				$data2['do_dont'] = $this->input->post('do_dont');								
				$data2['use_of_test'] = $this->input->post('use_of_test');								
				$data2['test_info'] = $this->input->post('test_info');								
				$data2['components'] = $this->input->post('components');							
				$data2['home_visit'] = $this->input->post('home_visit');							
				
				$insert = $this->Admin_Model->update('lab_test',$data2,['id'=>$id]);
				if($insert)
				{
					$this->session->set_flashdata('message',"Test Updated Successfully");
					return redirect('admin/lab_test');
				}				
			}
		}else{
			myview('admin/edit_lab_test',$data);
		}
	}

	public function test_status($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('lab_test',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'Lab Test active successfully':'Lab Test inactive successfully';
			
			$this->Admin_Model->update('lab_test',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/lab_test');
        }else{
            return redirect('admin/lab_test');
        }
	}

	public function delete_test($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('lab_test',['is_deleted'=>'1'],['id'=>$id]);
		$this->session->set_flashdata('message',"Item delete successfully");
		return redirect('admin/lab_test');
	}

	// public function edit_item($id)
	// {
	// 	checkadminlogin();
	// 	$id = base64_decode($id);
	// 	$restaurant_id = $this->session->userdata('loginrestaurant')->id;
	// 	$data['products']=$this->Admin_Model->selectrow('products',['id'=>$id]);
	// 	$data['category']=$this->Admin_Model->select('category',['type'=>'1','status'=>'1','is_deleted'=>'0']);
	// 	$data['sub_category']=$this->Admin_Model->select('sub_category',['category_type'=>'1','status'=>'1','is_deleted'=>'0','category_id'=>$data['products']->cat_id]);

	// 	if(!empty($_POST))
	// 	{
	// 		$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
	// 		$this->form_validation->set_rules('name', 'Name', 'trim|required');
	// 		$this->form_validation->set_rules('price', 'Price', 'trim|required');
	// 		$this->form_validation->set_rules('item_description', 'Description', 'trim|required');
			
	// 		if($this->form_validation->run()==FALSE){
	// 			myview('restaurant/editproduct',$data);
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
				
	// 			$insert = $this->Admin_Model->update('products',$data,['id'=>$id]);
	// 			if($insert)
	// 			{				
	// 				$this->session->set_flashdata('message',"Product Update successfully");
	// 				return redirect('restaurant/product');
	// 			}				
	// 		}
	// 	}else{
	// 		myview('restaurant/editproduct',$data);
	// 	}
	// }


	// public function product_requests($id="")
	// {
	// 	checkadminlogin();
	// 	if(!empty($id))
	// 	{
	// 		$id=base64_decode($id);		
	// 		$data['selected_product'] = $this->Admin_Model->select('products',['is_approved'=>'1','vender_id'=>$id]);		
	// 		myview('admin/store_products',$data);
	// 	}
	// 	else
	// 	{
	// 		$data['select_request'] = $this->Admin_Model->select('products',['is_approved'=>'0']);		
	// 		myview('admin/product_request',$data);
	// 	}
		
	// }

	// public function restaurant_items($id="")
	// {
	// 	checkadminlogin();
	// 	if(!empty($id))
	// 	{
	// 		$id=base64_decode($id);		
	// 		$data['selected_product'] = $this->Admin_Model->select('products',['is_approved'=>'1','vender_id'=>$id]);		
	// 		myview('admin/items_products',$data);
	// 	}		
	// }

	// public function action_product_request($action='',$id='')
	// {
	// 	checkadminlogin();		
	// 	if(!empty($action) || !empty($id))
	// 	{
	// 		$action = base64_decode($action);
	// 		$id = base64_decode($id);			
	// 		$this->Admin_Model->update('products',['is_approved'=>$action],['id'=>$id]);
	// 	}
	// 	else
	// 	{
	// 		redirect('admin/product_requests');
	// 	}
	// 	redirect('admin/product_requests');
	// }

	// public function view_product_images($id='')
	// {
	// 	checkadminlogin();		
	// 	if(!empty($id))
	// 	{
	// 		$id = base64_decode($id);			
	// 		$data['products_image']=$this->Admin_Model->select('item_images',['user_id'=>$id,'is_deleted'=>'0']);
	// 		myview('admin/product_images',$data);			
	// 	}
	// 	else
	// 	{
	// 		redirect('admin/product_requests');
	// 	}
	// }
	// public function view_items_images($id='')
	// {
	// 	checkadminlogin();		
	// 	if(!empty($id))
	// 	{
	// 		$id = base64_decode($id);			
	// 		$data['products_image']=$this->Admin_Model->select('item_images',['user_id'=>$id,'is_deleted'=>'0']);
	// 		myview('admin/items_images',$data);			
	// 	}
	// 	else
	// 	{
	// 		redirect('admin/restaurant_items');
	// 	}
	// }

	// public function delete_product_image($ide,$uid)
	// {
	// 	checkadminlogin();
	// 	$id=base64_decode($ide);
	// 	$this->Admin_Model->update('item_images',['is_deleted'=>'1'],['id'=>$id]);
	// 	$this->session->set_flashdata('message',"Product Image delete successfully");
	// 	return redirect('admin/view_product_images/'.$uid);
	// }

	// public function sub_category()
	// {
	// 	checkadminlogin();
	// 	$data['sub_category']=$this->Admin_Model->select('sub_category',['is_deleted'=>'0']);
	// 	$data['cat_name']=$this->Admin_Model->select('category',['is_deleted'=>'0','status'=>'1','id'=>@$data['sub_category'][0]->category_id]);
	// 	#pr($data);
	// 	myview('admin/sub_category',$data);
	// }

	// public function get_cat()
	// {
	// 	checkadminlogin();
	// 	$status = false;
	// 	$cat_type = $this->input->post('cat_type');
	// 	$data=$this->Admin_Model->select('category',['is_deleted'=>'0','type'=>$cat_type]);
	// 	if($data)
	// 	{
	// 		$status = true;
	// 	}
	// 	echo json_encode(array('status'=>$status, 'data'=>$data));
	// }

	// public function add_subcategory()
	// {
	// 	checkadminlogin();
	// 	if(!empty($_POST))
	// 	{
	// 		$this->form_validation->set_rules('cat_type', 'Category Type', 'trim|required');
	// 		$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
	// 		$this->form_validation->set_rules('name', 'Sub-Category Name', 'trim|required');
			
	// 		if (empty($_FILES['img']['name'])) {
	// 			$this->form_validation->set_rules('img', 'Images', 'required');
	// 		}

	// 		if($this->form_validation->run()==FALSE){
	// 			myview('admin/add_subcategory');

	// 		}else{

	// 			$image_data = uploadfile('img','assets/subcategory_img/');
	// 			$data = array(
	// 							'category_id' => $this->input->post('cat_name'),
	// 							'category_type' => $this->input->post('cat_type'),
	// 							'name' => ucfirst($this->input->post('name')),						
	// 							'image' => $image_data
	// 						);		
	// 			$insert = $this->Admin_Model->insert('sub_category',$data);
	// 			if($insert)
	// 			{
	// 				$this->session->set_flashdata('message',"Sub-Category add successfully");
	// 				return redirect('admin/sub_category');
	// 			}				
	// 		}
	// 	}else{
	// 		myview('admin/add_subcategory');
	// 	}
	// }

	// public function subcategoryStatus($ide)
    // {
	// 	checkadminlogin();
    //     if(!empty($ide))
    //     {
    //         $id=base64_decode($ide);            
	// 		$check = $this->Admin_Model->selectrow('sub_category',['id'=>$id]);
	// 		$value = ($check->status==1)?'0':'1';
	// 		$msg=($value=='1')?'Sub-Category active successfully':'Sub-Category inactive successfully';
			
	// 		$this->Admin_Model->update('sub_category',['status'=>$value],['id'=>$check->id]);
    //         $this->session->set_flashdata('message',$msg);
    //         return redirect('admin/sub_category');
    //     }else{
    //         return redirect('admin/sub_category');
    //     }
	// }
	// public function subcategorydelete($ide)
	// {
	// 	checkadminlogin();
	// 	$id=base64_decode($ide);
	// 	$this->Admin_Model->update('sub_category',['is_deleted'=>'1'],['id'=>$id]);
	// 	$this->session->set_flashdata('message',"Sub-Category delete successfully");
	// 	return redirect('admin/sub_category');
	// }	
	// public function edit_subcategory($ide)
	// {
	// 	checkadminlogin();
	// 	$id=base64_decode($ide);  
	// 	$data['subcategory_details']=$this->Admin_Model->selectrow('sub_category',['id'=>$id]);
	// 	$data['cat_name']=$this->Admin_Model->select('category',['is_deleted'=>'0','status'=>'1','type'=>$data['subcategory_details']->category_type]);
		
	// 	if(!empty($_POST))
	// 	{
	// 		$this->form_validation->set_rules('cat_type', 'Category Type', 'trim|required');
	// 		$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
	// 		$this->form_validation->set_rules('name', 'Sub-Category Name', 'trim|required');			

	// 		if($this->form_validation->run()==FALSE){
	// 			myview('admin/edit_subcategory',$data);

	// 		}else{			

	// 			$datas['category_id'] = ucfirst($this->input->post('cat_name'));
	// 			$datas['category_type'] = ucfirst($this->input->post('cat_type'));
	// 			$datas['name'] = ucfirst($this->input->post('name'));
	// 			if (!empty($_FILES['img']['name'])) {
	// 				$image_data = uploadfile('img','assets/subcategory_img/');	
	// 				$datas['image'] = $image_data;

	// 			}
	// 			$insert = $this->Admin_Model->update('sub_category',$datas,['id'=>$id]);
	// 			if($insert)
	// 			{
	// 				$this->session->set_flashdata('message',"Sub-Category Updated successfully");
	// 				return redirect('admin/sub_category');
	// 			}				
	// 		}
	// 	}else{
	// 		myview('admin/edit_subcategory',$data);
	// 	}
	// }

	public function manage_user()
	{
		checkadminlogin();
		$data['users']=$this->Admin_Model->join_select('ul.*,ua.country','users_login as ul','user_address as ua','ul.id=ua.user_id','left',['ul.is_verified'=>'1','ul.is_deleted'=>'0']);		
		myview('admin/manage_user',$data);
	}

	public function userstatus($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('users_login',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'User Active successfully':'User Inactive successfully';
			
			$this->Admin_Model->update('users_login',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/manage_user');
        }else{
            return redirect('admin/manage_user');
        }
	}

	public function user_delete($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('users_login',['is_deleted'=>'1'],['id'=>$id]);
		$this->session->set_flashdata('message',"User Delete successfully");
		return redirect('admin/manage_user');
	}	

	// public function manage_store()
	// {
	// 	checkadminlogin();
	// 	#$data['store']=$this->Admin_Model->join_select('ul.*,ua.country','users_login as ul','user_address as ua','ul.id=ua.user_id',['ul.is_verified'=>'1']);
	// 	$data['store']=$this->Admin_Model->select('users',['usertype'=>'1','is_verified'=>'1']);		
	// 	myview('admin/manage_store',$data);
	// }

	// public function storestatus($ide)
    // {
	// 	checkadminlogin();
    //     if(!empty($ide))
    //     {
    //         $id=base64_decode($ide);            
	// 		$check = $this->Admin_Model->selectrow('users',['id'=>$id]);
	// 		$value = ($check->status==1)?'0':'1';
	// 		$msg=($value=='1')?'Store Active successfully':'Store Block successfully';
			
	// 		$this->Admin_Model->update('users',['status'=>$value],['id'=>$check->id]);
    //         $this->session->set_flashdata('message',$msg);
    //         return redirect('admin/manage_store');
    //     }else{
    //         return redirect('admin/manage_store');
    //     }
	// }

	// public function manage_restaurant()
	// {
	// 	checkadminlogin();
	// 	#$data['store']=$this->Admin_Model->join_select('ul.*,ua.country','users_login as ul','user_address as ua','ul.id=ua.user_id',['ul.is_verified'=>'1']);
	// 	$data['restaurant']=$this->Admin_Model->select('users',['usertype'=>'2','is_verified'=>'1']);		
	// 	myview('admin/manage_restaurant',$data);
	// }

	// public function restaurantstatus($ide)
    // {
	// 	checkadminlogin();
    //     if(!empty($ide))
    //     {
    //         $id=base64_decode($ide);            
	// 		$check = $this->Admin_Model->selectrow('users',['id'=>$id]);
	// 		$value = ($check->status==1)?'0':'1';
	// 		$msg=($value=='1')?'Restaurant Active successfully':'Restaurant Block successfully';
			
	// 		$this->Admin_Model->update('users',['status'=>$value],['id'=>$check->id]);
    //         $this->session->set_flashdata('message',$msg);
    //         return redirect('admin/manage_restaurant');
    //     }else{
    //         return redirect('admin/manage_restaurant');
    //     }
	// }

	// public function productstatus($ide,$rowid)
    // {
	// 	checkadminlogin();
    //     if(!empty($ide))
    //     {
    //         $id=base64_decode($ide);            
	// 		$check = $this->Admin_Model->selectrow('products',['id'=>$id]);
	// 		$value = ($check->status==1)?'0':'1';
	// 		$msg=($value=='1')?'Product Active successfully':'Product Block successfully';
			
	// 		$this->Admin_Model->update('products',['status'=>$value],['id'=>$check->id]);
    //         $this->session->set_flashdata('message',$msg);
    //         return redirect('admin/selected_product/'.$rowid);
    //     }else{
    //         return redirect('admin/selected_product/'.$rowid);
    //     }
	// }

	public function lab_timing($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$data['sun']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'0']);
		$data['mon']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'1']);
		$data['tue']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'2']);
		$data['wed']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'3']);
		$data['thus']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'4']);
		$data['fri']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'5']);
		$data['sat']=$this->Admin_Model->selectrow('lab_timing',['status'=>'2','lab_id'=>$id,'days'=>'6']);

		if(!empty($_POST))
		{	
			$this->Admin_Model->delete('lab_timing',['lab_id'=>$id]);

			foreach($this->input->post('days') as $k=>$v)
			{	
					$this->Admin_Model->insert('lab_timing',['lab_id'=>$id,'days'=>$v,'o_time'=>$this->input->post('open')[$v],'status'=>'2','c_time'=>$this->input->post('close')[$v]]);
			}	
			
			
					$this->session->set_flashdata('message',"Labs added successfully");
					return redirect($_SERVER['HTTP_REFERER']);
			
		}else{
			myview('admin/lab_timing',$data);
		}
		
	}
	
	public function labs()
	{
		checkadminlogin();
		$data['labs']=$this->Admin_Model->select('labs',['is_deleted'=>'0']);
		myview('admin/labs',$data);
	}	

	public function add_labs()
	{
		checkadminlogin();
		if(!empty($_POST))
		{	
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Id', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('lab_address', 'Delivery Area', 'trim|required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
			$this->form_validation->set_rules('account_holder_name', 'Account Holder Name', 'trim|required');
			$this->form_validation->set_rules('ifsc_code', 'IFSC code', 'trim|required');
			$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
			$this->form_validation->set_rules('account_number', 'Acoount Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('admin_commission', 'Account Number', 'trim|required');


			if($this->form_validation->run()==FALSE){
				myview('admin/add_labs');
			}else{							
				$data = array(
								'name' => ucfirst($this->input->post('name')),
								'email' => $this->input->post('email'),								
								'mobile' => $this->input->post('mobile'),
								'lab_address' => $this->input->post('lab_address'),																	
								'longitude' => $this->input->post('longitude'),								
								'latitude' => $this->input->post('latitude'),							
								'bank_name' => $this->input->post('bank_name'),								
								'account_holder_name' => $this->input->post('account_holder_name'),								
								'ifsc_code' => $this->input->post('ifsc_code'),								
								'branch_name' => $this->input->post('branch_name'),								
								'account_number' => $this->input->post('account_number'),
								'admin_commission' => $this->input->post('admin_commission'),								
								'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT)
							);		
				$insert = $this->Admin_Model->insert('labs',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Labs added successfully");
					return redirect('admin/labs');
				}				
			}
		}else{
			myview('admin/add_labs');
		}
	}

	public function view_lab_details($id='')
	{
		checkadminlogin();		
		if(!empty($id))
		{			
			$id=base64_decode($id);  

			$data['labs'] =  $this->Admin_Model->selectrow('labs',['id'=>$id]);
			myview('admin/view_lab_details',$data);			
		}
		else
		{
			redirect('admin/labs');
		}
	}

	public function edit_labs($id)
	{
		checkadminlogin();
		$id=base64_decode($id); 
		$data['labs'] =  $this->Admin_Model->selectrow('labs',['id'=>$id]);
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Id', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('lab_address', 'Delivery Area', 'trim|required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
			$this->form_validation->set_rules('account_holder_name', 'Account Holder Name', 'trim|required');
			$this->form_validation->set_rules('ifsc_code', 'IFSC code', 'trim|required');
			$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
			$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
			$this->form_validation->set_rules('admin_commission', 'Account Number', 'trim|required');

			if($this->form_validation->run()==FALSE){
				
				myview('admin/edit_labs',$data);
			}else{				

				if ($this->input->post('password')) 
				{
					$data2['password'] = password_hash($this->input->post('password'),PASSWORD_DEFAULT);		
				}
							
				
					$data2['name'] = ucfirst($this->input->post('name'));
					$data2['email'] = $this->input->post('email');						
					$data2['mobile'] = $this->input->post('mobile');													
					$data2['lab_address'] = $this->input->post('lab_address');								
					$data2['longitude'] = $this->input->post('longitude');								
					$data2['latitude'] = $this->input->post('latitude');								
					$data2['bank_name'] = $this->input->post('bank_name');								
					$data2['account_holder_name'] = $this->input->post('account_holder_name');								
					$data2['ifsc_code'] = $this->input->post('ifsc_code');								
					$data2['branch_name'] = $this->input->post('branch_name');								
					$data2['account_number'] = $this->input->post('account_number');
					$data2['admin_commission'] = $this->input->post('admin_commission');
						
				$this->Admin_Model->update('labs',$data2,['id'=>$id]);
				
					$this->session->set_flashdata('message',"Labs Updated successfully");
					return redirect('admin/labs');
				
								
			}
		}else{
			myview('admin/edit_labs',$data);
		}
	}

	public function labs_status($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('labs',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'Lab active successfully':'Lab inactive successfully';
			
			$this->Admin_Model->update('labs',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/labs');
        }else{
            return redirect('admin/labs');
        }
	}

	public function lab_delete($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('labs',['is_deleted'=>'1'],['id'=>$id]);
		$this->session->set_flashdata('message',"Lab Delete successfully");
		return redirect('admin/labs');
	}	

	public function coupon()
	{
		checkadminlogin();
		$data['coupon']=$this->Admin_Model->select('coupon',['is_deleted'=>'0']);
		myview('admin/coupon',$data);
	}	

	public function addCoupon()
	{
		checkadminlogin();
		if(!empty($_POST))
		{				
			$this->form_validation->set_rules('title', 'Name', 'trim|required');
			$this->form_validation->set_rules('name', 'Email Id', 'trim|required');
			$this->form_validation->set_rules('price', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('start_date', 'Driving License', 'trim|required');
			$this->form_validation->set_rules('end_date', 'Delivery Area', 'trim|required');

			if($this->form_validation->run()==FALSE){
				myview('admin/addcoupon');
			}else{				
				$image_data = uploadfile('img','assets/coupon/');			
				$data = array(
								'title' => ucfirst($this->input->post('title')),
								'name' => $this->input->post('name'),								
								'mini_cart_val' => $this->input->post('mini_cart_val'),								
								'price' => $this->input->post('price'),								
								'start_date' => $this->input->post('start_date'),								
								'end_date' => $this->input->post('end_date')					
								
							);		
				$insert = $this->Admin_Model->insert('coupon',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Coupon added successfully");
					return redirect('admin/coupon');
				}				
			}
		}else{
			myview('admin/addcoupon');
		}
	}

	public function editcoupon($eid)
	{
		checkadminlogin();
		$id=base64_decode($eid); 
		$data['coupon'] =  $this->Admin_Model->selectrow('coupon',['id'=>$id]);
		if(!empty($_POST))
		{	

			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('mini_cart_val', 'Minimum Cart Value', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

			if($this->form_validation->run()==FALSE){
				myview('admin/editcoupon',$data);
			}else{				
				$data2['title'] = ucfirst($this->input->post('title'));			
				$data2['name'] = ucfirst($this->input->post('name'));			
				$data2['mini_cart_val'] = ucfirst($this->input->post('mini_cart_val'));			
				$data2['price'] = ucfirst($this->input->post('price'));			
				$data2['start_date'] = ucfirst($this->input->post('start_date'));			
				$data2['end_date'] = ucfirst($this->input->post('end_date'));
				$insert = $this->Admin_Model->update('coupon',$data2,['id'=>$id]);
				$this->session->set_flashdata('message',"Coupon Updated successfully");
					return redirect('admin/coupon');
			}
		}else{
			myview('admin/editcoupon',$data);
		}
	}

	public function couponstatus($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('coupon',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'Coupon active successfully':'Coupon inactive successfully';
			
			$this->Admin_Model->update('coupon',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/coupon');
        }else{
            return redirect('admin/coupon');
        }
	}

	public function deletecoupon($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('coupon',['is_deleted'=>'1'],['id'=>$id]);
		$this->session->set_flashdata('message',"Coupon Delete successfully");
		return redirect('admin/coupon');
	}	

	public function orders_request()
	{
		checkadminlogin();
		
			$data['orders_request'] = $this->Admin_Model->select('orders',['is_approved'=>'0']);		
			myview('admin/order_request',$data);		
	}

	public function ongoing_orders()
	{
		checkadminlogin();
		
			$data['ongoing_orders'] = $this->Admin_Model->select_ongoing_orders('orders');		
			myview('admin/ongoing_orders',$data);		
	}

	public function view_request_orders_details($id)
	{
		checkadminlogin();
		$id = base64_decode($id);

		$data['orders']=$this->Admin_Model->selectrow('orders',['id'=>$id]);
		$data['vender_details']=$this->Admin_Model->selectrow('users',['id'=>$data['orders']->vendor_id]);
		$product_details = json_decode($data['orders']->product_details); 
		foreach($product_details as $key) 
		{ 	
			$datadetails = $this->Admin_Model->selectrow('products',['id'=>$key->product_id]);
			$datadetails->qty = $key->qty;
			$productName[] = $datadetails;
			// pr($data);	
		}
		
		$data['orders']->pro_name = $productName;
		myview('admin/view_request_orders_details',$data);
	}

	public function action_orders_request($action='',$id='')
	{
		checkadminlogin();		
		if(!empty($action) || !empty($id))
		{			
			$action = base64_decode($action);
			$id = base64_decode($id);
			
			if($action === '1')
			{
				$this->Admin_Model->update('orders',['order_status'=>'1'],['id'=>$id]);	
			}			
			$this->Admin_Model->update('orders',['is_approved'=>$action],['id'=>$id]);
		}
		else
		{
			redirect('admin/orders_request');
		}
		redirect('admin/orders_request');
	}

	public function update_delivery_status()
	{
		checkadminlogin();
		$status = false;
		if(isset($_POST))
		{		
			$d_status = $this->input->post('d_status');
			$row_id = $this->input->post('row_id');

			$update = $this->Admin_Model->update('orders',['order_status'=>$d_status],['id'=>$row_id]);
			if($update)
			{				
				$status = true;
			}
			else
			{
				$status = false;
			}
		}	
		echo json_encode(array('status'=>$status));
	}

	public function is_popular()
	{
		checkadminlogin();
		$status = false;
		if(isset($_POST))
		{		
			$is_popular = $this->input->post('is_popular');
			$row_id = $this->input->post('row_id');

			$update = $this->Admin_Model->update('users',['is_popular'=>$is_popular],['id'=>$row_id]);
			if($update)
			{				
				$status = true;
			}
			else
			{
				$status = false;
			}
		}	
		echo json_encode(array('status'=>$status));
	}

	public function complete_orders()
	{
		checkadminlogin();
			$data['complete_orders'] = $this->Admin_Model->select('orders',['order_status'=>'3']);		
			myview('admin/complete_orders',$data);		
	}

	public function update_profile()
	{
		checkadminlogin();
		#$data['profile_details'] = $this->Admin_Model->selectrow('users',['id'=>$id,'usertype'=>'1','is_verified'=>'1','user_status'=>'1','status'=>'1','is_deleted'=>'0']);

		if(!empty($_POST))
		{	
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
			
			if($this->form_validation->run()==FALSE){
				myview('admin/edit_profile');
			}
			else
			{
				$admin_pass = $this->Admin_Model->selectrow('users',['id'=>'3']);

				if(password_verify($this->input->post('old_password'),$admin_pass->password))
				{
					$data2['password']  = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
					$this->Admin_Model->update('users',$data2,['id'=>'3']);
					$this->session->set_flashdata('message',"Password Updated");
					return redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('message',"Old Password Incorrect!!");
					return redirect($_SERVER['HTTP_REFERER']);			
				}

							
			}				
			
		}
		else{
			myview('admin/edit_profile');
		}
		
	}

	public function setting()
	{
		checkadminlogin();
		#$data['profile_details'] = $this->Admin_Model->selectrow('users',['id'=>$id,'usertype'=>'1','is_verified'=>'1','user_status'=>'1','status'=>'1','is_deleted'=>'0']);
		$data['setting'] = $this->Admin_Model->selectrow('setting',['id'=>'1']);
		if(!empty($_POST))
		{	
			$this->form_validation->set_rules('google_api', 'Google Api', 'trim|required');
			$this->form_validation->set_rules('sms_api', 'Sms Api', 'trim|required');
			$this->form_validation->set_rules('per_km_charges', 'Per Km Charges', 'trim|required');
			$this->form_validation->set_rules('default_km_range', 'Default Km Range', 'trim|required');
			
			if($this->form_validation->run()==FALSE){
				myview('admin/setting',$data);
			}
			else
			{	
					
				$data2['google_api']  = $this->input->post('google_api');
				$data2['sms_api']  = $this->input->post('sms_api');
				$data2['per_km_charges']  = $this->input->post('per_km_charges');
				$data2['default_km_range']  = $this->input->post('default_km_range');

					$this->Admin_Model->update('setting',$data2,['id'=>'1']);
					$this->session->set_flashdata('message',"Updated Updated");
					return redirect($_SERVER['HTTP_REFERER']);
			}				
			
		}
		else{
			myview('admin/setting',$data);
		}
	}

	public function notification()
	{
		checkadminlogin();
		$data['notification']=$this->Admin_Model->select('notification',['is_deleted'=>'0']);
		myview('admin/notification',$data);
	}	

	public function addnotification()
	{
		checkadminlogin();
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			
			// if (empty($_FILES['img']['name'])) {
			// 	$this->form_validation->set_rules('img', 'Images', 'required');
			// }

			if($this->form_validation->run()==FALSE){
				myview('admin/add_notification');

			}else{
				$image_data = NULL;
				if (!empty($_FILES['img']['name'])) {
					$image_data = uploadfile('img','assets/notification_image/');	
					}
				$data = array(
								'message' => $this->input->post('message'),
								'vender_type' => $this->input->post('type'),								
								'image' => $image_data
							);		
				$insert = $this->Admin_Model->insert('notification',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Notification Send to ". ($this->input->post('type') == '0' ? 'Store' : ($this->input->post('type') == '1' ? 'Restaurant' : 'Delivery Boy'))." successfully");
					return redirect('admin/notification');
				}				
			}
		}else{
			myview('admin/add_notification');
		}
	}

	public function delete_notification($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('notification',['is_deleted'=>'1'],['id'=>$id]);		
		$this->session->set_flashdata('message',"Notification delete successfully");
		return redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function manage_faq()
	{
		checkadminlogin();
		$data['faq']=$this->Admin_Model->select('faq',['is_deleted'=>'0']);
		myview('admin/manage_faq',$data);
	}	

	public function faq()
	{			
			$this->form_validation->set_rules('title','Title','trim|required');
			$this->form_validation->set_rules('description','Description','trim|required');

			if($this->form_validation->run() === FALSE)
			{ 
				myview('admin/faq');
			}
			else
			{
				$title = $this->input->post('title');
				$description = $this->input->post('description');

				
				$this->Admin_Model->insert('faq',['title'=>$title,'description'=>$description]);
				$this->session->set_flashdata('message',"FAQ's Added Successfully");
				return redirect('admin/manage_faq');		
				
			}	
	
	}

	public function faqstatus($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('faq',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'FAQ active successfully':'FAQ inactive successfully';
			
			$this->Admin_Model->update('faq',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
			return redirect($_SERVER['HTTP_REFERER']);

        }else{
			return redirect($_SERVER['HTTP_REFERER']);

        }
	}

	public function delete_faq($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('faq',['is_deleted'=>'1'],['id'=>$id]);		
		$this->session->set_flashdata('message',"FAQ delete successfully");
		return redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_faq($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);  
		$data['faq']=$this->Admin_Model->selectrow('faq',['id'=>$id]);
		
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('title','Title','trim|required');
			$this->form_validation->set_rules('description','Description','trim|required');		

			if($this->form_validation->run()==FALSE){
				myview('admin/edit_faq',$data);

			}else{			

				$title = $this->input->post('title');
				$description = $this->input->post('description');
				$insert = $this->Admin_Model->update('faq',['title'=>$title,'description'=>$description],['id'=>$id]);
				if($insert)
				{
					$this->session->set_flashdata('message',"FAQ Updated successfully");
					return redirect('admin/manage_faq');
				}				
			}
		}else{
			myview('admin/edit_faq',$data);
		}
	}


	public function about_us()
	{
			$this->form_validation->set_rules('about_us','About us','trim|required');
			$data['insert_into'] = $this->Admin_Model->selectrow('about_us');

			if($this->form_validation->run() === FALSE)
			{ 
				myview('admin/about_us',$data);
			}
			else
			{
				$about_us = $this->input->post('about_us');

				if($data['insert_into'])
				{
					$this->Admin_Model->update('about_us',['about_us '=>$about_us],['id'=>'1']);				
					$this->session->set_flashdata('message',"About Us Updated Successfully");
					return redirect($_SERVER['HTTP_REFERER']);		
				}
				else
				{
					$this->Admin_Model->insert('about_us',['about_us '=>$about_us]);
					$this->session->set_flashdata('message',"About Us Added Successfully");
					return redirect($_SERVER['HTTP_REFERER']);		
				}
			}	
	
	}

	public function term_and_condition()
	{
			$this->form_validation->set_rules('term_and_condition','Term And Condition','required');
			$data['insert_into'] = $this->Admin_Model->selectrow('term_and_condition');

			if($this->form_validation->run() === FALSE)
			{ 
				myview('admin/term_and_condition',$data);
			}
			else
			{
				$term_and_condition = $this->input->post('term_and_condition');

				if($data['insert_into'])
				{
					$this->Admin_Model->update('term_and_condition',['term_and_condition '=>$term_and_condition],['id'=>'1']);				
					$this->session->set_flashdata('message',"Term And Condition Updated Successfully");
					return redirect($_SERVER['HTTP_REFERER']);		
				}
				else
				{
					$this->Admin_Model->insert('term_and_condition',['term_and_condition '=>$term_and_condition]);
					$this->session->set_flashdata('message',"Term And Condition  Added Successfully");
					return redirect($_SERVER['HTTP_REFERER']);		
				}
			}	
	
	}

	public function test_packages()
	{
		checkadminlogin();		
		$data['test_packages']=$this->Admin_Model->select('test_packages',['is_deleted'=>'0']);
	

		myview('admin/test_packages',$data);
	}	

	public function add_test_packages()
	{
		checkadminlogin();

		$data['lab_test']=$this->Admin_Model->select('lab_test',['status'=>'1','is_deleted'=>'0']);
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('cat_name[]', 'Test', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('preparation', 'Preparation', 'trim|required');
			$this->form_validation->set_rules('do_dont', "Do & Don't", 'trim|required');
			$this->form_validation->set_rules('components', 'Components', 'trim|required');
			$this->form_validation->set_rules('use_of_test', 'Use of Test', 'trim|required');
			$this->form_validation->set_rules('test_info', 'Test Information', 'trim|required');
			$this->form_validation->set_rules('home_visit', 'Home Visit', 'trim|required');
			
			if (empty($_FILES['thumb_img']['name'])) {
				$this->form_validation->set_rules('thumb_img', 'Thumb Images', 'required');
			}
			if (empty($_FILES['item_image']['name'])) {
				$this->form_validation->set_rules('item_image', 'Item Images', 'required');
			}

			if($this->form_validation->run()==FALSE){
				myview('admin/add_test_packages',$data);
			}else{
				
				$thumb_img = uploadfile('thumb_img','assets/test_image/');	
				$image_data = uploadfile('item_image','assets/test_image/');	
				$data = array(
								'name' => $this->input->post('name'),
								'price' => $this->input->post('price'),
								'preparation' => $this->input->post('preparation'),
								'test_id' => implode(',',$this->input->post('cat_name')),
								'do_dont' => $this->input->post('do_dont'),								
								'use_of_test' => $this->input->post('use_of_test'),								
								'test_info' => $this->input->post('test_info'),								
								'home_visit' => $this->input->post('home_visit'),								
								'thumb_img' => '/assets/test_image/'.$thumb_img,								
								'galary_img' => '/assets/test_image/'.$image_data,								
								'components' => $this->input->post('components')								
							);
				$insert = $this->Admin_Model->insert('test_packages',$data);
				if($insert)
				{
					$this->session->set_flashdata('message',"Package's Added Successfully");
					return redirect('admin/test_packages');
				}				
			}
		}else{
			myview('admin/add_test_packages',$data);
		}
	}

	public function edit_test_packages($eid)
	{
		checkadminlogin();
		$id = base64_decode($eid);

		$data['lab_test']=$this->Admin_Model->select('lab_test',['status'=>'1','is_deleted'=>'0']);		
		$data['test_packages']=$this->Admin_Model->selectrow('test_packages',['id'=>$id]);

		if(!empty($_POST))
		{
			$this->form_validation->set_rules('cat_name[]', 'Test', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('preparation', 'Preparation', 'trim|required');
			$this->form_validation->set_rules('do_dont', "Do & Don't", 'trim|required');
			$this->form_validation->set_rules('components', 'Components', 'trim|required');
			$this->form_validation->set_rules('use_of_test', 'Use of Test', 'trim|required');
			$this->form_validation->set_rules('test_info', 'Test Information', 'trim|required');
			$this->form_validation->set_rules('home_visit', 'Home Visit', 'trim|required');

			if($this->form_validation->run()==FALSE){
				myview('admin/edit_test_packages',$data);
			}else{
				if (!empty($_FILES['thumb_img']['name'])) {
						$thumb_img = uploadfile('thumb_img','assets/test_image/');
						$data2['thumb_img'] = '/assets/test_image/'.$thumb_img;
					}
				
				if (!empty($_FILES['item_image']['name'])) {
					$image_data = uploadfile('item_image','assets/test_image/');	
					$data2['thumb_img'] = '/assets/test_image/'.$image_data;
				}
				
				$data2['name'] = $this->input->post('name');
				$data2['price'] = $this->input->post('price');
				$data2['preparation'] = $this->input->post('preparation');
				$data2['test_id'] =  implode(',',$this->input->post('cat_name'));
				$data2['do_dont'] = $this->input->post('do_dont');								
				$data2['use_of_test'] = $this->input->post('use_of_test');								
				$data2['test_info'] = $this->input->post('test_info');								
				$data2['components'] = $this->input->post('components');							
				$data2['home_visit'] = $this->input->post('home_visit');							
				
				$insert = $this->Admin_Model->update('test_packages',$data2,['id'=>$id]);
				if($insert)
				{
					$this->session->set_flashdata('message',"Package Updated Successfully");
					return redirect('admin/test_packages');
				}				
			}
		}else{
			myview('admin/edit_test_packages',$data);
		}
	}

	public function test_packages_status($ide)
    {
		checkadminlogin();
        if(!empty($ide))
        {
            $id=base64_decode($ide);            
			$check = $this->Admin_Model->selectrow('test_packages',['id'=>$id]);
			$value = ($check->status==1)?'0':'1';
			$msg=($value=='1')?'Package active successfully':'Package inactive successfully';
			
			$this->Admin_Model->update('test_packages',['status'=>$value],['id'=>$check->id]);
            $this->session->set_flashdata('message',$msg);
            return redirect('admin/test_packages');
        }else{
            return redirect('admin/test_packages');
        }
	}

	public function delete_test_packages($ide)
	{
		checkadminlogin();
		$id=base64_decode($ide);
		$this->Admin_Model->update('test_packages',['is_deleted'=>'1'],['id'=>$id]);
		$this->session->set_flashdata('message',"Package delete successfully");
		return redirect('admin/test_packages');
	}


	
}
?>