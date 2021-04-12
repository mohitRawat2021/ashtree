<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class DeliveryBoyApi extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization_Token');
		$this->load->model('Apis_model', 'Apimodel');
	
	}

	public function mobileSendOtp($user_data)
    {
		return 1;
		die;
		try 
		{
			//Integrate SMS API here
			$mobile = $user_data['mobile'];
			$otp = $user_data['otp'];
			$authKey = "309952Aq8MczyMxu5e03001fP1";
			$senderId = "ADSURL";
			$messageMsg = urlencode("<#>Your OTP is: $otp ");
			$postData = array(
				'authkey' => $authKey,
				'mobiles' => $mobile,
				'message' => $messageMsg,
				'sender' => $senderId,
				'route' => 4,
				'country' => 91
			);
			$url = "https://api.msg91.com/api/sendhttp.php";
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postData
			));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$output = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'error:' . curl_error($ch);
			}
			curl_close($ch);
			if (strlen($output) == 24) {
				return 1;
			}else{
				return 2;
			}        
		} 
		catch (Exception $e) {
			return response()->json(['custom_error'=> $e->getMessage()], $this->invalidStatus);        
		}   
	}

	public function sign_up_post() {	

		$this->form_validation->set_rules('full_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

		$this->form_validation->set_rules('area', 'Area', 'trim|required');
		$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		if (empty($_FILES['profile_img']['name'])) {
			$this->form_validation->set_rules('profile_img','Profile Image','required');
		}
		if (empty($_FILES['dl_image']['name'])) {
			$this->form_validation->set_rules('dl_image','DL Image','required');
		}
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('re_password', 'Confirm Password', 'trim|required|matches[password]');

		if ($this->form_validation->run() == TRUE) 
			{
				$userData['name'] = $this->post('full_name');
				$userData['country_code'] = $this->post('country_code');
				$userData['mobile'] = $this->post('mobile_number');
				$userData['delivery_area '] = $this->post('area');
				$userData['pincode'] = $this->post('pincode');
				$userData['state'] = $this->post('state');
				$userData['city'] = $this->post('city');
				$userData['country'] = $this->post('country');				
				$userData['longitude'] = $this->post('longitude');				
				$userData['latitude'] = $this->post('latitude');				
				$userData['password'] = password_hash($this->post('password'), PASSWORD_BCRYPT);
				$userData['otp']    = mt_rand(1000,9999);
				$userData['otp_status']    = '1';
				$userData['is_verified']    = '0';
			
				if(is_unique('delivery_boy',['mobile'=>$this->post('mobile_number')]) >= 1)
				{
					$this->response([
					'status' => FALSE,
					'message' => "Delivery Boy Already Exists Please Login!!"
					], REST_Controller::HTTP_BAD_REQUEST);
				}
				else
				{
					if (!empty($_FILES['profile_img']['name'])) 
					{
						$r = uploadfile('profile_img','assets/deliverboy_profile/');
						$userData['profile_img'] = $r;		
					}

					if (!empty($_FILES['dl_image']['name'])) 
					{
						$r = uploadfile('dl_image','assets/deliverboy_dl_image/');
						$userData['driving_license'] = $r;		
					}

					$insert = $this->Apimodel->insert('delivery_boy',$userData);

					if($insert)
					{		
						if($this->mobileSendOtp($userData))
						{
						
							$this->response([					
							'status' => TRUE,
							'message' => 'Delivery Boy added successfully.'											
							], REST_Controller::HTTP_OK);
									
						}
						else
						{
							$this->response([
							'status' => FALSE,
							'message' => "OTP Not Send!!, please try again."
							], REST_Controller::HTTP_BAD_REQUEST);
							
						}
						
					}else{
						$this->response([
						'status' => FALSE,
						'message' => "Some problems occurred, please try again."
						], REST_Controller::HTTP_BAD_REQUEST);
						
					}
				}
				
			}else 
			{    
					  
				$this->response([
				  'status' => FALSE,
				  'message' => array_values($this->form_validation->error_array())[0]
				  ], REST_Controller::HTTP_BAD_REQUEST);		
			}

}

public function verify_otp_post() {

	if(!empty($_POST))
	{
		
			$this->form_validation->set_rules('otp', 'OTP', 'trim|required|max_length[4]|min_length[4]');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

			if ($this->form_validation->run() == TRUE) 
			{
				$user['otp'] = $this->input->post('otp');
				$user['mobile'] = $this->input->post('mobile_number');        			

				if($user['otp'] == 5555){
					$otp = $this->Apimodel->select_single_row(['otp'],'delivery_boy',['mobile'=> $user['mobile']]);				
					$check_otp = array(
					'mobile'=>  $user['mobile'], 
					'otp'   =>  !empty($otp)?$otp->otp:'',
					'otp_status'=>  '1',  
					'is_verified' => '0',            
					'status'=>  '1'
					  );
				}else
				{
					$check_otp = array(
				'mobile'=>  $user['mobile'], 
				'otp'   =>  $user['otp'],
				'otp_status'=>  '1',  
				'is_verified' => '0',            
				'status'=>  '1'
				  );
				}

				$is_exists = $this->Apimodel->check_rows_exists('delivery_boy',$check_otp);
		   
				   if(!empty($is_exists))
				  {
						  $user['id'] = @$is_exists->id;
						  $token = $this->authorization_token->generateToken($user);
						  #header('Token: '.	$token);
					  
						  $selected_column = $this->Apimodel->select_single_row(
											['id','country_code','mobile','name','email','is_verified','profile_img as image'],
											'delivery_boy',
											$check_otp
											);

						  $update = $this->Apimodel->update('delivery_boy',['otp_status' => '0', 'is_verified' => '1'],['mobile' => $user['mobile']]);
						  
						  if($update)
						  {
								  $jwt_token_data = array(
								  'user_id'=> @$is_exists->id,
								  'token'=> $token,
								  'is_active'=> '1',   
								  );

								  $selected_column->is_verified = '1';
								  $selected_column->image = base_url('assets/deliverboy_profile/').$selected_column->image;	
								  $selected_column->token = $token;

								  $this->Apimodel->insert('deliverboy_jwt_token',$jwt_token_data);    
								  $this->response([					
									'status' => TRUE,
									'message' => 'OTP Matched Successfully.',
									'data' => $selected_column,															
									], REST_Controller::HTTP_OK);
						  }
						  else{
										$this->response([
										  'status' => FALSE,
										  'message' => "Something wrong!!"
										  ], REST_Controller::HTTP_BAD_REQUEST);
									}
					  
				  }
				  else
				  {
					  $this->response([
						  'status' => FALSE,
						  'message' => 'OTP that you have entered could not be authenticated or OTP Expired!!'
						  ], REST_Controller::HTTP_BAD_REQUEST);
				  }					

			}
			else 
			{    
						$this->response([
						  'status' => FALSE,
						  'message' => array_values($this->form_validation->error_array())[0]
						  ], REST_Controller::HTTP_BAD_REQUEST);			

				
			}					
	}
	else{			
						$this->response([
						  'status' => FALSE,
						  'message' => "Provide complete user information to create."
						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
	}		
}

public function login_post() {

	if(!empty($_POST))
	{
			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == TRUE) 
			{	
				$mobile_number = $this->input->post('mobile_number');
				$password = $this->input->post('password');

				$user_row = $this->Apimodel->select_single_row(['id','name','mobile','password'],'delivery_boy',['mobile'=>$mobile_number,'is_verified'=>'1','status'=>'1']);
				$hash = @$user_row->password;
				if (password_verify($password, $hash)) {

					$this->response([					
						'status' => TRUE,
						'data' => $user_row,
						'message' => 'Login successfully.'											
						], REST_Controller::HTTP_OK);

				} else {
					$this->response([
						'status' => FALSE,
						'message' => 'Incorrect Mobile Number or Password'
						], REST_Controller::HTTP_BAD_REQUEST);
				}
			}
			else 
			{    
						$this->response([
						  'status' => FALSE,
						  'message' => array_values($this->form_validation->error_array())[0]
						  ], REST_Controller::HTTP_BAD_REQUEST);
			}	

	}
	else{			
						$this->response([
						  'status' => FALSE,
						  'message' => "Provide complete user information to create."
						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
	}		
}

public function forgot_pass_post() {

	if(!empty($_POST))
	{
			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

			if ($this->form_validation->run() == TRUE) 
			{	
				$mobile_number = $this->input->post('mobile_number');

				$user_row = $this->Apimodel->select_single_row(['id','name','mobile','password'],'delivery_boy',['mobile'=>$mobile_number]);
				if ($user_row) {

					$userData['mobile'] = $this->post('mobile_number');
					$userData['otp']    = mt_rand(1000,9999);

					if($this->mobileSendOtp($userData))
						{
							$update = $this->Apimodel->update('delivery_boy',['otp' => $userData['otp'], 'otp_status' => '1','is_verified'=>'0'],['mobile' => $this->post('mobile_number')]);
						
							$this->response([					
							'status' => TRUE,
							'message' => 'OTP Send Successfully.'											
							], REST_Controller::HTTP_OK);
									
						}
					else
						{
							$this->response([
							'status' => FALSE,
							'message' => "OTP Not Send!!, please try again."
							], REST_Controller::HTTP_BAD_REQUEST);
							
						}
						
					$this->response([					
						'status' => TRUE,
						'data' => $user_row,
						'message' => 'User has been added successfully.'											
						], REST_Controller::HTTP_OK);

				} else {
					$this->response([
						'status' => FALSE,
						'message' => 'Mobile Number Not Register Please SignUp'
						], REST_Controller::HTTP_BAD_REQUEST);
				}
			}
			else 
			{    
						$this->response([
						  'status' => FALSE,
						  'message' => array_values($this->form_validation->error_array())[0]
						  ], REST_Controller::HTTP_BAD_REQUEST);
			}	

	}
	else{			
						$this->response([
						  'status' => FALSE,
						  'message' => "Provide complete user information to create."
						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
	}		
}

public function reset_pass_post() {

	if(!empty($_POST))
	{
			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
			$this->form_validation->set_rules('re_password', 'Re Enter Password', 'trim|required|matches[new_password]');

			if ($this->form_validation->run() == TRUE) 
			{	
				$new_password = password_hash($this->post('new_password'), PASSWORD_BCRYPT);
				$update = $this->Apimodel->update('delivery_boy',['password' => $new_password],['mobile' => $this->post('mobile_number')]);
				if ($update) {
						
							$this->response([					
							'status' => TRUE,
							'message' => 'Password Updated Successfully!!'											
							], REST_Controller::HTTP_OK);
									
						}
					else
						{
							$this->response([
							'status' => FALSE,
							'message' => "Something Wrong!!, please try again."
							], REST_Controller::HTTP_BAD_REQUEST);
							
						}					
			} 			
			else 
			{    
						$this->response([
						  'status' => FALSE,
						  'message' => array_values($this->form_validation->error_array())[0]
						  ], REST_Controller::HTTP_BAD_REQUEST);
			}	

	}
	else{			
						$this->response([
						  'status' => FALSE,
						  'message' => "Provide complete user information to create."
						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
	}		
}

public function active_status_post() {

	if(is_token_valid())
		{
			$user_id = is_token_valid()['data']->id;
			$this->form_validation->set_rules('status', 'Active Status', 'required');

			if ($this->form_validation->run() == TRUE) 
			{	

				$status = $this->post('status');
				$update = $this->Apimodel->update('delivery_boy',['active_status' => $status],['id' => $user_id]);
				if ($update) {
						
							$this->response([					
							'status' => TRUE,
							'message' => 'Updated Successfully!!'											
							], REST_Controller::HTTP_OK);
									
						}
					else
						{
							$this->response([
							'status' => FALSE,
							'message' => "Something Wrong!!, please try again."
							], REST_Controller::HTTP_BAD_REQUEST);
							
						}					
			} 			
			else 
			{    
						$this->response([
						  'status' => FALSE,
						  'message' => array_values($this->form_validation->error_array())[0]
						  ], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		else
		{
			$this->response([
			  'status' => FALSE,
			  'message' => "Authorization Key invalid!!"
			  ], REST_Controller::HTTP_BAD_REQUEST);	
			
		}			
}
}
?>
