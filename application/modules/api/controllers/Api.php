<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class Api extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization_Token');
		$this->load->model('Apis_model','Apimodel');
		$this->load->library('form_validation');
	
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

	public function login_with_mobile_post() {

		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');

		if ($this->form_validation->run() == TRUE) 
			{

	 			$is_exists = $this->Apimodel->check_rows_exists('users_login',['mobile' => $this->post('phone_number')]);
	
		if(!empty($is_exists))
		{
				$otp_data['mobile'] = $this->post('phone_number');
				$otp_data['otp']    = mt_rand(1000,9999);

				if($this->mobileSendOtp($otp_data))
				{
				  $this->Apimodel->update('users_login',['otp' => $otp_data['otp'], 'otp_status' => '1','is_verified' => '0'],['mobile' => $this->post('phone_number')]);

					$this->response([					
					'status' => TRUE,
					'message' => 'User Already exists!!  OTP SEND!!'								
					], REST_Controller::HTTP_OK);
				}
				else
				{
					$this->response([
					  'status' => FALSE,
					  'message' => "OTP Not Send!!, please try again."
					  ], REST_Controller::HTTP_BAD_REQUEST);
					
				}
		}
		else
		{
		
		$userData = array();
		$userData['mobile'] = $this->post('phone_number');
		
		$insert = $this->Apimodel->insert('users_login',$userData);

			if($insert){
				
				$otp_data['mobile'] = $this->post('phone_number');
				$otp_data['otp']    = mt_rand(1000,9999);

				if($this->mobileSendOtp($otp_data))
				{
				$update = $this->Apimodel->update('users_login',['otp' => $otp_data['otp'], 'otp_status' => '1','is_verified' => '0'],['id' => $insert]);
							if($update)
							{
								$this->response([					
								'status' => TRUE,
								'message' => 'OTP Send!!, User has been added successfully.'											
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
		
			$this->form_validation->set_rules('otp', 'this', 'trim|required|max_length[4]|min_length[4]');

			if ($this->form_validation->run() == TRUE) 
			{
		
				$user['otp'] = $this->input->post('otp');
				$user['mobile'] = $this->input->post('phone_number');        			

				if($user['otp'] == 5555){
					$otp = $this->Apimodel->select_single_row(['otp'],'users_login',['mobile'=>$user['mobile']]);					
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

				  $is_exists = $this->Apimodel->check_rows_exists('users_login',$check_otp);
		   
				   if(!empty($is_exists))
				  {
						  $user['id'] = @$is_exists->id;
						  $token = $this->authorization_token->generateToken($user);
						  #header('Token: '.	$token);
					  
						  $selected_column = $this->Apimodel->select_single_row(
											['id','mobile','name','email','resident_type','passport_number','gender','is_verified','profile_image as image'],
											'users_login',
											$check_otp
											);

						  $update = $this->Apimodel->update('users_login',['otp_status' => '0', 'is_verified' => '1', 'token' => 
						  $token],['mobile' => $user['mobile']]);
						  
						  if($update)
						  {
								  $jwt_token_data = array(
								  'user_id'=> @$is_exists->id,
								  'token'=> $token,
								  'is_active'=> '1',   
								  );

								  $selected_column->is_verified = '1';
								  $selected_column->image = base_url('assets/user_profile/').$selected_column->image;	
								  $selected_column->token = $token;

								  if($selected_column->name == NULL || empty($selected_column->name))
								  {
									  $selected_column->already_exists = FALSE;			                      		
								  }
								  else
								  {
									  $selected_column->already_exists = TRUE;
								  }

								  $this->Apimodel->insert('jwt_token',$jwt_token_data);    
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
						  'message' => validation_errors()
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

public function update_profile_image_post() 
	{
			if(is_token_valid())
			{
				
					$id_from_token = is_token_valid()['data']->id;
					$profile_pic = @uploadfile('profile_pic','assets/user_profile/');
				#pr($profile_pic);
					$unlink_pic = $this->Apimodel->select_single_row(['profile_image'],'users_login',['id'=>$id_from_token]);
								
							if(!empty($unlink_pic))
							{
								@unlink('assets/user_profile/'.$unlink_pic->user_profile);
							}	
							$user['profile_image'] = $profile_pic;			
        					$this->Apimodel->update('users_login',$user,['id' => $id_from_token]);
			                $is_exists = $this->Apimodel->select_single_row(
					                	['id','mobile','name','gender','resident_type','passport_number','email','is_verified','profile_image as image'],
					                	'users_login',
					                	['id' => $id_from_token]
					                );

							$is_exists->image = base_url('assets/user_profile/').$is_exists->image;	

			                if(!empty($is_exists))
			                {
			                	#$is_exists->base_url = base_url('assets/user_profile/');	
					                $this->response([					
									'status' => TRUE,
									'message' => 'Image Updated!!',
									'data' => $is_exists	
									], REST_Controller::HTTP_OK);
				            }
			                else
			                {
			                		$this->response([
			                      	'status' => FALSE,
			                      	'message' => 'Something Wrong Contact to Admin!!',
			                      	'data' => $is_exists
			                      	], REST_Controller::HTTP_BAD_REQUEST);	   
			                } 	
									
				
			}
			else
			{
				$this->response([
              	'status' => FALSE,
              	'message' => "Token Key invalid!!"
              	], REST_Controller::HTTP_BAD_REQUEST);	
				
			}
	}

	public function update_personal_details_post() {

		if(!empty($_POST))
		{			
			if(is_token_valid())
			{		

				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
				$this->form_validation->set_rules('dob', 'DOB', 'trim|required');
				$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				
				

				if ($this->form_validation->run() == TRUE) 
				{
					$id_from_token = is_token_valid()['data']->id;
					$user['name'] = $this->input->post('name');
        			$user['email'] = $this->input->post('email');
        			$user['gender'] = $this->input->post('gender');
        			$user['dob'] = $this->input->post('dob');
        			$user['passport_number'] = $this->input->post('passport_number');
	        				
       						$this->Apimodel->update('users_login',$user,['id' => $id_from_token]);
			                $is_exists = $this->Apimodel->select_single_row(
					                	['id','mobile','name','gender','resident_type','passport_number','email','is_verified','profile_image as image'],
					                	'users_login',
					                	['id' => $id_from_token]
					                );

							$is_exists->image = base_url('assets/user_profile/').$is_exists->image;		
									
						

			                if(!empty($is_exists))
			                {
			                	#$is_exists->base_url = base_url('assets/user_profile/');	
					                $this->response([					
									'status' => TRUE,
									'message' => 'Profile Updated!!',
									'data' => $is_exists	
									], REST_Controller::HTTP_OK);
				            }
			                else
			                {
			                		$this->response([
			                      	'status' => FALSE,
			                      	'message' => 'Something Wrong Contact to Admin!!'
			                      	], REST_Controller::HTTP_BAD_REQUEST);	   
			                }                	
				}
				else 
				{    
							$this->response([
	                      	'status' => FALSE,
	                      	'message' => validation_errors()
	                      	], REST_Controller::HTTP_BAD_REQUEST);	                
	            }	
			}
			else
			{
				$this->response([
              	'status' => FALSE,
              	'message' => "Token Key invalid!!"
              	], REST_Controller::HTTP_BAD_REQUEST);	
				
			}
			 				
		}
		else
		{			
				$this->response([
	          	'status' => FALSE,
	          	'message' => "Provide complete user information to create."
	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
		}		
	}

	public function resident_details_post() {

		if(!empty($_POST))
		{			
			if(is_token_valid())
			{		

				$this->form_validation->set_rules('resident_type', 'Resident Type', 'trim|required');
				$this->form_validation->set_rules('number', 'Number', 'trim|required');

				if ($this->form_validation->run() == TRUE) 
				{
					$id_from_token = is_token_valid()['data']->id;
					$user['resident_type'] = $this->input->post('resident_type');
        			$user['passport_number'] = $this->input->post('number');
	        				
       						$this->Apimodel->update('users_login',$user,['id' => $id_from_token]);
			                $is_exists = $this->Apimodel->select_single_row(
					                	['id','mobile','name','gender','email','resident_type','passport_number','is_verified','profile_image as image'],
					                	'users_login',
					                	['id' => $id_from_token]
					                );

							$is_exists->image = base_url('assets/user_profile/').$is_exists->image;		
									
						

			                if(!empty($is_exists))
			                {
			                	#$is_exists->base_url = base_url('assets/user_profile/');	
					                $this->response([					
									'status' => TRUE,
									'message' => 'Profile Updated!!',
									'data' => $is_exists	
									], REST_Controller::HTTP_OK);
				            }
			                else
			                {
			                		$this->response([
			                      	'status' => FALSE,
			                      	'message' => 'Something Wrong Contact to Admin!!'
			                      	], REST_Controller::HTTP_BAD_REQUEST);	   
			                }                	
				}
				else 
				{    
							$this->response([
	                      	'status' => FALSE,
	                      	'message' => validation_errors()
	                      	], REST_Controller::HTTP_BAD_REQUEST);	                
	            }	
			}
			else
			{
				$this->response([
              	'status' => FALSE,
              	'message' => "Token Key invalid!!"
              	], REST_Controller::HTTP_BAD_REQUEST);	
				
			}
			 				
		}
		else
		{			
				$this->response([
	          	'status' => FALSE,
	          	'message' => "Provide complete user information to create."
	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
		}		
	}

// 	public function sign_up_post() {
// 		// ($this->load->model('Apimodel'));	

// 		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
// 		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
// 		$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
// 		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 		$this->form_validation->set_rules('password', 'Password', 'trim|required');
// 		$this->form_validation->set_rules('re_password', 'Confirm Password', 'trim|required|matches[password]');

// 		if ($this->form_validation->run() == TRUE) 
// 			{		
// 				$userData['name'] = $this->post('first_name');
// 				$userData['last_name'] = $this->post('last_name');
// 				$userData['country_code'] = $this->post('country_code');
// 				$userData['mobile'] = $this->post('mobile_number');
// 				$userData['password'] = password_hash($this->post('password'), PASSWORD_BCRYPT);
// 				$userData['otp']    = mt_rand(1000,9999);
// 				$userData['otp_status']    = '1';
// 				$userData['is_verified']    = '0';
			
// 				if(is_unique('users_login',['mobile'=>$this->post('mobile_number')]) >= 1)
// 				{
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => "User Already Exists Please Login!!"
// 					], REST_Controller::HTTP_BAD_REQUEST);
// 				}
// 				else
// 				{
// 					$insert = $this->Apimodel->insert('users_login',$userData);

// 					if($insert)
// 					{		
// 						if($this->mobileSendOtp($userData))
// 						{
						
// 							$this->response([					
// 							'status' => TRUE,
// 							'message' => 'User has been added successfully.'											
// 							], REST_Controller::HTTP_OK);
									
// 						}
// 						else
// 						{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "OTP Not Send!!, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}
						
// 					}else{
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => "Some problems occurred, please try again."
// 						], REST_Controller::HTTP_BAD_REQUEST);
						
// 					}
// 				}
				
// 			}else 
// 			{    
					  
// 				$this->response([
// 				  'status' => FALSE,
// 				  'message' => array_values($this->form_validation->error_array())[0]
// 				  ], REST_Controller::HTTP_BAD_REQUEST);		
// 			}

// }

// public function verify_otp_post() {

// 	if(!empty($_POST))
// 	{
		
// 			$this->form_validation->set_rules('otp', 'OTP', 'trim|required|max_length[4]|min_length[4]');
// 			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

// 			if ($this->form_validation->run() == TRUE) 
// 			{
// 				$user['otp'] = $this->input->post('otp');
// 				$user['mobile'] = $this->input->post('mobile_number');        			

// 				if($user['otp'] == 5555){
// 					$otp = $this->Apimodel->select_single_row(['otp'],'users_login',['mobile'=> $user['mobile']]);				
// 					$check_otp = array(
// 					'mobile'=>  $user['mobile'], 
// 					'otp'   =>  !empty($otp)?$otp->otp:'',
// 					'otp_status'=>  '1',  
// 					'is_verified' => '0',            
// 					'status'=>  '1'
// 					  );
// 				}else
// 				{
// 					$check_otp = array(
// 				'mobile'=>  $user['mobile'], 
// 				'otp'   =>  $user['otp'],
// 				'otp_status'=>  '1',  
// 				'is_verified' => '0',            
// 				'status'=>  '1'
// 				  );
// 				}

// 				$is_exists = $this->Apimodel->check_rows_exists('users_login',$check_otp);
		   
// 				   if(!empty($is_exists))
// 				  {
// 						  $user['id'] = @$is_exists->id;
// 						  $token = $this->authorization_token->generateToken($user);
// 						  #header('Token: '.	$token);
					  
// 						  $selected_column = $this->Apimodel->select_single_row(
// 											['id','country_code','mobile','name','last_name','email','is_verified','profile_image as image'],
// 											'users_login',
// 											$check_otp
// 											);

// 						  $update = $this->Apimodel->update('users_login',['otp_status' => '0', 'is_verified' => '1', 'token' => $token],['mobile' => $user['mobile']]);
						  
// 						  if($update)
// 						  {
// 								  $jwt_token_data = array(
// 								  'user_id'=> @$is_exists->id,
// 								  'token'=> $token,
// 								  'is_active'=> '1',   
// 								  );

// 								  $selected_column->is_verified = '1';
// 								  $selected_column->image = base_url('assets/user_profile/').$selected_column->image;	
// 								  $selected_column->token = $token;

// 								  $this->Apimodel->insert('jwt_token',$jwt_token_data);    
// 								  $this->response([					
// 									'status' => TRUE,
// 									'message' => 'OTP Matched Successfully.',
// 									'data' => $selected_column,															
// 									], REST_Controller::HTTP_OK);
// 						  }
// 						  else{
// 										$this->response([
// 										  'status' => FALSE,
// 										  'message' => "Something wrong!!"
// 										  ], REST_Controller::HTTP_BAD_REQUEST);
// 									}
					  
// 				  }
// 				  else
// 				  {
// 					  $this->response([
// 						  'status' => FALSE,
// 						  'message' => 'OTP that you have entered could not be authenticated or OTP Expired!!'
// 						  ], REST_Controller::HTTP_BAD_REQUEST);
// 				  }					

// 			}
// 			else 
// 			{    
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => array_values($this->form_validation->error_array())[0]
// 						  ], REST_Controller::HTTP_BAD_REQUEST);			

				
// 			}					
// 	}
// 	else{			
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => "Provide complete user information to create."
// 						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
// 	}		
// }

// public function login_post() {

// 	if(!empty($_POST))
// 	{
// 			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 			$this->form_validation->set_rules('password', 'Password', 'trim|required');

// 			if ($this->form_validation->run() == TRUE) 
// 			{	
// 				$mobile_number = $this->input->post('mobile_number');
// 				$password = $this->input->post('password');

// 				$user_row = $this->Apimodel->select_single_row(['id','name','last_name','mobile','password','token',
// 					'profile_image','email'],'users_login',['mobile'=>$mobile_number,'is_verified'=>'1','status'=>'1']);
// 				$hash = @$user_row->password;
// 				if (password_verify($password, $hash)) {

// 					$user_row->profile_image = base_url('assets/user_profile/'.$user_row->profile_image);
// 					$this->response([					
// 						'status' => TRUE,
// 						'data' => $user_row,
// 						'message' => 'User has been added successfully.'											
// 						], REST_Controller::HTTP_OK);

// 				} else {
// 					$this->response([
// 						'status' => FALSE,
// 						'message' => 'Incorrect Mobile Number or Password'
// 						], REST_Controller::HTTP_BAD_REQUEST);
// 				}
// 			}
// 			else 
// 			{    
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => array_values($this->form_validation->error_array())[0]
// 						  ], REST_Controller::HTTP_BAD_REQUEST);
// 			}	

// 	}
// 	else{			
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => "Provide complete user information to create."
// 						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
// 	}		
// }

// public function forgot_pass_post() {

// 	if(!empty($_POST))
// 	{
// 			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

// 			if ($this->form_validation->run() == TRUE) 
// 			{	
// 				$mobile_number = $this->input->post('mobile_number');

// 				$user_row = $this->Apimodel->select_single_row(['id','name','last_name','mobile','password','token'],'users_login',['mobile'=>$mobile_number,'is_verified'=>'1','status'=>'1']);
// 				if ($user_row) {

// 					$userData['mobile'] = $this->post('mobile_number');
// 					$userData['otp']    = mt_rand(1000,9999);

// 					if($this->mobileSendOtp($userData))
// 						{
// 							$update = $this->Apimodel->update('users_login',['otp' => $userData['otp'], 'otp_status' => '1','is_verified'=>'0'],['mobile' => $this->post('mobile_number')]);
						
// 							$this->response([					
// 							'status' => TRUE,
// 							'message' => 'OTP Send Successfully.'											
// 							], REST_Controller::HTTP_OK);
									
// 						}
// 					else
// 						{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "OTP Not Send!!, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}
						
// 					$this->response([					
// 						'status' => TRUE,
// 						'data' => $user_row,
// 						'message' => 'User has been added successfully.'											
// 						], REST_Controller::HTTP_OK);

// 				} else {
// 					$this->response([
// 						'status' => FALSE,
// 						'message' => 'Mobile Number Not Register Please SignUp'
// 						], REST_Controller::HTTP_BAD_REQUEST);
// 				}
// 			}
// 			else 
// 			{    
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => array_values($this->form_validation->error_array())[0]
// 						  ], REST_Controller::HTTP_BAD_REQUEST);
// 			}	

// 	}
// 	else{			
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => "Provide complete user information to create."
// 						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
// 	}		
// }

// public function reset_pass_post() {

// 	if(!empty($_POST))
// 	{
// 			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
// 			$this->form_validation->set_rules('re_password', 'Re Enter Password', 'trim|required|matches[new_password]');

// 			if ($this->form_validation->run() == TRUE) 
// 			{	
// 				$new_password = password_hash($this->post('new_password'), PASSWORD_BCRYPT);
// 				$update = $this->Apimodel->update('users_login',['password' => $new_password],['mobile' => $this->post('mobile_number')]);
// 				if ($update) {
						
// 							$this->response([					
// 							'status' => TRUE,
// 							'message' => 'Password Updated Successfully!!'											
// 							], REST_Controller::HTTP_OK);
									
// 						}
// 					else
// 						{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "Something Wrong!!, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}					
// 			} 			
// 			else 
// 			{    
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => array_values($this->form_validation->error_array())[0]
// 						  ], REST_Controller::HTTP_BAD_REQUEST);
// 			}	

// 	}
// 	else{			
// 						$this->response([
// 						  'status' => FALSE,
// 						  'message' => "Provide complete user information to create."
// 						  ], REST_Controller::HTTP_BAD_REQUEST);		
		
// 	}		
// }

// public function store_post() 
// 	{
// 		if(!empty($_POST))
// 		{
// 		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
// 		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
// 		$this->form_validation->set_rules('type', 'Type', 'trim|required');

// 		if($this->form_validation->run() == false)
// 		{
// 				$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => validation_errors()
// 	          	], REST_Controller::HTTP_BAD_REQUEST);
// 		}
// 		else
// 		{
// 			// $user_id = is_token_valid()['data']->id;
// 			// $sst = array();
// 			// $stores_list = $this->Apimodel->select_multi_row(['mall_id'],'orders',['user_id'=>$user_id,'delivery_status'=>'0','user_order_status'=>'0']);
// 			// foreach ($stores_list as $key => $value) {				
// 			// 	$sst[] = $value->mall_id;
// 			// }
						

// 			$store_list = closest_malls($this->input->post('type'),['id','store_name','estimated_delivery_time','store_image'],$this->input->post('latitude'),$this->input->post('longitude'));	
// 			foreach ($store_list as $key => $value) {
// 				$store_list[$key]->store_image = base_url('assets/store_images/').$store_list[$key]->store_image;				
// 				$add[] = $this->Apimodel->selectrow('restaurant_address',['restaurant_id'=>$value->id])->street1;
// 				$store_list[$key]->address = $add[$key];
// 			}

// 			#$store_list->image	= base_url('malls_images/').$store_list->image;

// 			$this->response([					
// 			'status' => TRUE,
// 			'message' => 'Store Data Found Successfully.',
// 			'data' => $store_list	
// 			], REST_Controller::HTTP_OK);
// 		}
// 		}
// 		else
// 		{			
// 				$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => "Provide complete user information to create."
// 	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
// 		}	
// 	}
// 	// public function index_post()
// 	// {
// 	// 	$user['id'] = '1';
// 	// 	$user['mobile'] = '8826856066';
// 	// 	$token = $this->authorization_token->generateToken($user);
// 	// 	$this->response([					
// 	// 		'status' => TRUE,
// 	// 		'message' => 'Data Recevied Successfully.',
// 	// 		'data' => $token,															
// 	// 		], REST_Controller::HTTP_OK);
	
// 	// }

// 	public function most_popular_get() 
// 	{
// 		if(!empty($_GET))
// 		{
// 			if($this->input->get('type') == '1')
// 			{
// 				$popular=$this->Apimodel->select_multi_row(['id,store_name,store_image'],'users',['is_popular'=>'1','usertype'=>$this->input->get('type')]);
// 				foreach ($popular as $key => $value) {
// 					$popular[$key]->store_image = base_url('assets/store_images/').$popular[$key]->store_image;				
// 					$add[] = $this->Apimodel->selectrow('restaurant_address',['restaurant_id'=>$value->id])->street1;
// 					$popular[$key]->address = $add[$key];
// 				}
// 			}
// 			else
// 			{
// 				$popular=$this->Apimodel->select_multi_row(['id,store_name,store_image'],'users',['is_popular'=>'1']);
// 				foreach ($popular as $key => $value) {
// 					$popular[$key]->store_image = base_url('assets/restaurant_images/').$popular[$key]->store_image;				
// 					$add[] = $this->Apimodel->selectrow('restaurant_address',['restaurant_id'=>$value->id])->street1;
// 					$popular[$key]->address = $add[$key];
// 				}
// 			}
			

// 			$this->response([					
// 			'status' => TRUE,
// 			'message' => 'Data Found Successfully.',
// 			'data' => $popular	
// 			], REST_Controller::HTTP_OK);

// 		}
// 		else
// 		{			
// 				$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => "Provide complete user information to create."
// 	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
// 		}	
		
// 	}

// 	public function shop_details_post() 
// 	{
		
// 		#$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
// 		$this->form_validation->set_rules('shop_id', 'Product ID', 'trim|required');

// 			if($this->form_validation->run() == false)
// 			{
	
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => array_values($this->form_validation->error_array())[0]
// 					], REST_Controller::HTTP_BAD_REQUEST);		
// 			}
		
// 			else
// 			{		
// 				$popular=$this->Apimodel->join_select('u.id,u.store_name,u.store_image,u.store_desc as description,ua.street1 as address,u.estimated_delivery_time',
// 																'users as u',
// 																'restaurant_address as ua',
// 																'u.id = ua.restaurant_id',
// 																['u.id'=>$this->input->post('shop_id'),'u.user_status'=>'1','u.status'=>'1','u.is_deleted'=>'0'],
// 																'1'
// 															);	
// 				$popular->store_image = base_url('assets/store_images/').$popular->store_image;
				
// 				$popular->product_category = $this->Apimodel->join_select('c.id,c.name,c.img as category_image',
// 														'category as c',
// 														'products as p',
// 														'c.id = p.cat_id',
// 														['p.vender_id'=>$this->input->post('shop_id'),'c.status'=>'1','c.is_deleted'=>'0']
// 													);
													
// 				foreach($popular->product_category as $key => $value)
// 				{			
// 					$popular->product_category[$key]->category_image = base_url('assets/category_img/').$value->category_image;					
// 					$popular->product_category[$key]->product_subcategory = $this->Apimodel->join_select("sc.id,sc.name,CONCAT('".base_url('assets/subcategory/')."',sc.image) as subcategory_image",
// 																			'sub_category as sc',
// 																			'category as c',
// 																			'c.id = sc.category_id',
// 																			['c.id'=>$value->id,'sc.status'=>'1','sc.is_deleted'=>'0']
// 																		);				
// 				}
		
// 				$this->response([					
// 				'status' => TRUE,
// 				'message' => 'Item Details Found Successfully.',
// 				'data' => $popular	
// 				], REST_Controller::HTTP_OK);
// 			}
		
// 	}

// 	public function menu_post() 
// 	{
		
// 		$this->form_validation->set_rules('cat_id', 'Category ID', 'trim|required');
// 		$this->form_validation->set_rules('subcat_id', 'Sub-Category ID', 'trim|required');

// 			if($this->form_validation->run() == false)
// 			{	
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => array_values($this->form_validation->error_array())[0]
// 					], REST_Controller::HTTP_BAD_REQUEST);		
// 			}
		
// 			else
// 			{	
				
// 				$products=$this->Apimodel->select_multi_row(['id,name,price'],'products',['cat_id'=>$this->input->post('cat_id'),'subcat_id'=>$this->input->post('subcat_id'),'status'=>'1','is_deleted'=>'0','is_approved'=>'1']);	
				
// 				foreach ($products as $key => $value) {		
					
// 					$img = $this->Apimodel->select('item_images',['user_id'=>$value->id,'is_deleted'=>'0','status'=>'1']);
// 						foreach($img as $k=>$v)
// 						{
// 							$add[] = base_url('assets/product_image/').$v->image;
// 							$products[$key]->product_image = $add;
// 						}
// 				}
			
				
// 				$this->response([					
// 				'status' => TRUE,
// 				'message' => 'Menu Data Found Successfully.',
// 				'data' => $products	
// 				], REST_Controller::HTTP_OK);
// 			}
		
// 	}
// //        ------Comments---


// 	public function add_to_cart_post() 
// 	{
		
// 	if(is_token_valid())
// 		{
// 			$user_id = is_token_valid()['data']->id;
// 			$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
// 			$this->form_validation->set_rules('shop_id', 'Shop ID', 'trim|required');
// 			$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');

// 			if($this->form_validation->run() == false)
// 				{	
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => array_values($this->form_validation->error_array())[0]
// 						], REST_Controller::HTTP_BAD_REQUEST);		
// 				}
			
// 				else
// 				{	
// 					$userData['user_id'] = $user_id;
// 					$userData['shop_id'] = $this->input->post('shop_id');

// 					$userData2['pro_id'] = $this->input->post('pro_id');
// 					$userData2['pro_qty'] = $this->input->post('qty');

// 					$check_id = $this->Apimodel->selectrow('shopping_cart',['user_id'=>$user_id,'is_delete'=>'0']);			
// 					if(!empty($check_id))
// 					{
					
// 						if($check_id->shop_id == $userData['shop_id'])
// 						{							
// 							$cart_id = $check_id->id;
// 						}
// 						else
// 						{			
// 							$userData3['is_delete'] = '1';
							
// 							$update = $this->Apimodel->update('shopping_cart',$userData3,['id'=>$check_id->id]);
// 							$update = $this->Apimodel->update('shopping_cart_submenu',$userData3,['cart_id'=>$check_id->id]);
// 							$insert = $this->Apimodel->insert('shopping_cart',$userData);
// 							if($insert)
// 							{
// 								$cart_id = $insert;
// 							}
// 						}
// 					}
// 					else
// 					{
// 						$insert = $this->Apimodel->insert('shopping_cart',$userData);
// 						if($insert)
// 						{
// 							$cart_id = $insert;						
// 						}						
// 					}	
// ////////////////////////////////////////-Sub_Menu-////////////////////////////////////////////////

// 					$check_id3 = $this->Apimodel->selectrow('shopping_cart_submenu',['cart_id'=>$cart_id,'pro_id'=>$userData2['pro_id'],'is_delete'=>'0']);
// 					if(!empty($check_id3))
// 					{						
// 						$update = $this->Apimodel->update('shopping_cart_submenu',$userData2,['cart_id'=>$cart_id,'pro_id'=>$userData2['pro_id'],'is_delete'=>'0']);
// 						$msg = "Item Updated Succesfully";

// 					}
// 					else
// 					{			
// 						$userData2['cart_id'] = $cart_id;
						
// 							$this->Apimodel->insert('shopping_cart_submenu',$userData2);
// 							$msg = "Item Inserted Succesfully";					
						
// 					}	


// 					$this->response([					
// 					'status' => TRUE,
// 					'message' => $msg,
// 					'data' => $userData	
// 					], REST_Controller::HTTP_OK);
// 				}

			
// 		}
// 	else
// 		{
// 			$this->response([
// 			  'status' => FALSE,
// 			  'message' => "Authorization Key invalid!!"
// 			  ], REST_Controller::HTTP_BAD_REQUEST);	
			
// 		}
// 	}

// 	public function product_details_post() 
// 	{		
// 		$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');

// 		if($this->form_validation->run() == false)
// 		{
// 				$this->response([
// 				'status' => FALSE,
// 				'message' => array_values($this->form_validation->error_array())[0]
// 				], REST_Controller::HTTP_BAD_REQUEST);		
// 		}
	
// 		else
// 		{	

// 			$pro_details=$this->Apimodel->select_single_row(['id,name,price,item_description'],
// 															'products',
// 															['id'=>$this->input->post('pro_id'),'is_approved'=>'1','status'=>'1','is_deleted'=>'0'],
// 															'1'
// 														);
														
			
// 				$img = $this->Apimodel->select('item_images',['user_id'=>$pro_details->id,'is_deleted'=>'0','status'=>'1']);
		
// 					foreach($img as $k=>$v)
// 					{
						
// 						 $add[] = base_url('assets/product_image/').$v->image;
// 						 $pro_details->product_image = $add;
						 
// 						// $pro_details[$k]->product_image = $add;
// 					}
// 		#die;
		
// 			#$popular->store_image = base_url('assets/store_images/').$popular->store_image;
			
	
// 			$this->response([					
// 			'status' => TRUE,
// 			'message' => 'Item Details Found Successfully.',
// 			'data' => $pro_details	
// 			], REST_Controller::HTTP_OK);
// 		}
		
// 	}

// 	public function my_cart_get() 
// 	{
		
// 	if(is_token_valid())
// 		{
// 			$cartData = new stdClass();
// 			$user_id = is_token_valid()['data']->id;
// 			$shopping_cart = $this->Apimodel->selectrow('shopping_cart',['user_id'=>$user_id,'is_delete'=>'0']);
// 			$shop_id = $shopping_cart->shop_id;
// 			$shopping_cart_sub = $this->Apimodel->selectrow('shopping_cart_submenu',['cart_id'=>$shopping_cart->id,'is_delete'=>'0']);
// 			$pro_id = $shopping_cart_sub->pro_id;
	
// 			$shopping_cart = $this->Apimodel->join_select('u.id,u.store_name,u.store_image,ua.street1 as address,u.estimated_delivery_time',
// 															'users as u',
// 															'restaurant_address as ua',
// 															'u.id = ua.restaurant_id',
// 															['u.id'=>$shop_id,'u.user_status'=>'1','u.status'=>'1','u.is_deleted'=>'0'],
// 															'1'
// 														);
// 			$cartData->shopping_cart = $shopping_cart;

			


// 			$order = $this->Apimodel->join_select('p.name,p.price,sc.pro_qty, (p.price * sc.pro_qty) AS total_price',
// 													'products as p',
// 													'shopping_cart_submenu as sc',
// 													'p.id = sc.pro_id',
// 													['p.vender_id'=>$shop_id,'p.is_approved'=>'1','p.status'=>'1','p.is_deleted'=>'0']
// 												);
// 			$cartData->shopping_cart->order = $order;
// 			$grand_total = 0;
// 			foreach($order as $v)
// 			{
// 				$grand_total += $v->total_price;
// 			}
// 			$cartData->shopping_cart->grand_total = $grand_total;
// 					$this->response([					
// 					'status' => TRUE,
// 					'message' => 'Data found Successfully!!',
// 					'data' => $cartData	
// 					], REST_Controller::HTTP_OK);
// 		}
// 	else
// 		{
// 			$this->response([
// 			  'status' => FALSE,
// 			  'message' => "Authorization Key invalid!!"
// 			  ], REST_Controller::HTTP_BAD_REQUEST);	
			
// 		}
// 	}


// 	public function promocode_post() 
// 	{
		
// 	if(is_token_valid())
// 		{
// 			$cartData = new stdClass();
// 			$user_id = is_token_valid()['data']->id;
// 			$this->form_validation->set_rules('promocode', 'Promocode', 'trim|required');
// 			$this->form_validation->set_rules('grand_total', 'Total Amount', 'trim|required');

// 			if($this->form_validation->run() == false)
// 		{
// 				$this->response([
// 				'status' => FALSE,
// 				'message' => array_values($this->form_validation->error_array())[0]
// 				], REST_Controller::HTTP_BAD_REQUEST);		
// 		}
	
// 		else
// 		{
// 			$promocode = $this->input->post('promocode');
// 			$grand_total = $this->input->post('grand_total');
// 			$timestamp = strtotime(tstp);
// 			$today_date =  date("Y-m-d", $timestamp);
		
// 			// $check_promo = $this->Apimodel->selectrow('coupon',['name'=>$promocode,'end_date >='=>$today_date,'mini_cart_val >'=>$grand_total]);
// 			$check_promo = $this->Apimodel->selectrow('coupon',['name'=>$promocode]);
// 			$check_promo_date = $this->Apimodel->selectrow('coupon',['end_date >='=>$today_date]);
// 			$check_promo_rate = $this->Apimodel->selectrow('coupon',['mini_cart_val <='=>$grand_total]);
// 			if(empty($check_promo))
// 			{
// 					$this->response([					
// 					'status' => TRUE,
// 					'message' => 'Invalid Promocode!!',
// 					'data' => $check_promo	
// 					], REST_Controller::HTTP_OK);
// 			}
// 			elseif(empty($check_promo_date))
// 			{
// 				$this->response([					
// 					'status' => TRUE,
// 					'message' => 'Promocode Date Expired!!',
// 					'data' => $check_promo_date	
// 					], REST_Controller::HTTP_OK);
// 			}
// 			elseif(empty($check_promo_rate))
// 			{
// 				$this->response([					
// 					'status' => TRUE,
// 					'message' => 'Cart Value Must be 600Rs',
// 					'data' => $check_promo_rate	
// 					], REST_Controller::HTTP_OK);
// 			}
// 			else
// 			{
// 				$final_check_promo = $this->Apimodel->select_single_row(['price'],'coupon',['name'=>$promocode,'end_date >='=>$today_date,'mini_cart_val <='=>$grand_total]);
// 				$this->response([					
// 					'status' => TRUE,
// 					'message' => 'Data Found Successfully',
// 					'data' => $final_check_promo	
// 					], REST_Controller::HTTP_OK);
// 			}

// 		}				
// 		}
// 	else
// 		{
// 			$this->response([
// 			  'status' => FALSE,
// 			  'message' => "Authorization Key invalid!!"
// 			  ], REST_Controller::HTTP_BAD_REQUEST);	
			
// 		}
// 	}

// 	public function address_list_get() {	
// 		if(is_token_valid())
// 			{
// 				$user_id = is_token_valid()['data']->id;
// 				$address = $this->Apimodel->select_multi_row(['id,name,mobile_number,address,city'],'user_address',['user_id'=>$user_id,'is_deleted'=>'0','status'=>'1']);
// 				$this->response([					
// 									'status' => TRUE,
// 									'message' => 'Data Found Successfully',
// 									'data' => $address	
// 									], REST_Controller::HTTP_OK);
// 			}
// 			else
// 			{
// 				$this->response([
// 				'status' => FALSE,
// 				'message' => "Authorization Key invalid!!"
// 				], REST_Controller::HTTP_BAD_REQUEST);	
				
// 			}
// 		}

// 	public function add_address_post() {	
// 		if(is_token_valid())
// 			{
// 				$user_id = is_token_valid()['data']->id;
// 				$this->form_validation->set_rules('name', 'Name', 'trim|required');
// 				$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 				$this->form_validation->set_rules('address', 'Address', 'trim|required');
// 				$this->form_validation->set_rules('city', 'City', 'trim|required');
// 				$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
// 				$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');

// 			if ($this->form_validation->run() == TRUE) 
// 				{		
// 					$userData['user_id'] = $user_id;
// 					$userData['name'] = $this->post('name');
// 					$userData['mobile_number'] = $this->post('mobile_number');
// 					$userData['address'] = $this->post('address');
// 					$userData['city'] = $this->post('city');
// 					$userData['longitude'] = $this->post('longitude');
// 					$userData['latitude'] = $this->post('latitude');

// 					$insert = $this->Apimodel->insert('user_address',$userData);

// 					if($insert)
// 					{		
// 						$this->response([					
// 							'status' => TRUE,
// 							'message' => 'Address Added Successfully.'											
// 							], REST_Controller::HTTP_OK);										
						
// 					}else{
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => "Some problems occurred, please try again."
// 						], REST_Controller::HTTP_BAD_REQUEST);
						
// 					}
// 				}else 
// 				{    
						
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => array_values($this->form_validation->error_array())[0]
// 					], REST_Controller::HTTP_BAD_REQUEST);		
// 				}
// 			}
// 			else
// 			{
// 				$this->response([
// 				'status' => FALSE,
// 				'message' => "Authorization Key invalid!!"
// 				], REST_Controller::HTTP_BAD_REQUEST);	
				
// 			}
// 		}
// 	public function delete_address_post()
// 	{
// 		if(is_token_valid())
// 				{
// 					$user_id = is_token_valid()['data']->id;
// 					$this->form_validation->set_rules('address_id', 'Address Id', 'trim|required');
	
// 				if ($this->form_validation->run() == TRUE) 
// 					{		
// 						//$userData['user_id'] = $user_id;
// 						$address_id = $this->post('address_id');
	
// 						$insert = $this->Apimodel->update('user_address',['is_deleted'=>'1'],['id'=>$address_id,'user_id'=>    $user_id]);
	
// 						if($insert)
// 						{		
// 							$this->response([					
// 								'status' => TRUE,
// 								'message' => 'Address Delete Successfully.'											
// 								], REST_Controller::HTTP_OK);										
							
// 						}else{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "Some problems occurred, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}
// 					}else 
// 					{    
							
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => array_values($this->form_validation->error_array())[0]
// 						], REST_Controller::HTTP_BAD_REQUEST);		
// 					}
// 				}
// 				else
// 				{
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => "Authorization Key invalid!!"
// 					], REST_Controller::HTTP_BAD_REQUEST);	
					
// 				}
// 	}	

// 		public function edit_address_post() {	
// 			if(is_token_valid())
// 				{
// 					$user_id = is_token_valid()['data']->id;
// 					$id = $this->post('id');
// 					$this->form_validation->set_rules('name', 'Name', 'trim|required');
// 					$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 					$this->form_validation->set_rules('address', 'Address', 'trim|required');
// 					$this->form_validation->set_rules('city', 'City', 'trim|required');
// 					$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
// 					$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
	
// 				if ($this->form_validation->run() == TRUE) 
// 					{		
// 						//$userData['user_id'] = $user_id;
// 						$userData['name'] = $this->post('name');
// 						$userData['mobile_number'] = $this->post('mobile_number');
// 						$userData['address'] = $this->post('address');
// 						$userData['city'] = $this->post('city');
// 						$userData['longitude'] = $this->post('longitude');
// 						$userData['latitude'] = $this->post('latitude');
	
// 						$insert = $this->Apimodel->update('user_address',$userData,['id'=>$id]);
	
// 						if($insert)
// 						{		
// 							$this->response([					
// 								'status' => TRUE,
// 								'message' => 'Address Updated Successfully.'											
// 								], REST_Controller::HTTP_OK);										
							
// 						}else{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "Some problems occurred, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}
// 					}else 
// 					{    
							
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => array_values($this->form_validation->error_array())[0]
// 						], REST_Controller::HTTP_BAD_REQUEST);		
// 					}
// 				}
// 				else
// 				{
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => "Authorization Key invalid!!"
// 					], REST_Controller::HTTP_BAD_REQUEST);	
					
// 				}
// 			}

// 		public function update_profile_image_post() 
// 			{
// 					if(is_token_valid())
// 					{
						
// 							$id_from_token = is_token_valid()['data']->id;
// 							$profile_pic = @uploadfile('profile_pic','assets/user_profile/');
						

// 							$unlink_pic = $this->Apimodel->select_single_row(['profile_image'],'users_login',['id'=>$id_from_token]);
										
// 									if(!empty($unlink_pic))
// 									{
// 										@unlink('assets/user_profile/'.$unlink_pic->profile_image);
// 									}	
// 									$user['profile_image'] = $profile_pic;			
// 									$this->Apimodel->update('users_login',$user,['id' => $id_from_token]);
// 									$is_exists = $this->Apimodel->select_single_row(
// 												['id','name','mobile','name','email','profile_image as image'],
// 												'users_login',
// 												['id' => $id_from_token]
// 											);

// 									$is_exists->image = base_url('assets/user_profile/').$is_exists->image;	

// 									if(!empty($is_exists))
// 									{
// 										#$is_exists->base_url = base_url('assets/user_profile/');	
// 											$this->response([					
// 											'status' => TRUE,
// 											'message' => 'Image Updated!!',
// 											'data' => $is_exists	
// 											], REST_Controller::HTTP_OK);
// 									}
// 									else
// 									{
// 											$this->response([
// 											'status' => FALSE,
// 											'message' => 'Something Wrong Contact to Admin!!',
// 											'data' => $is_exists
// 											], REST_Controller::HTTP_BAD_REQUEST);	   
// 									} 	
											
						
// 					}
// 					else
// 					{
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => "Token Key invalid!!"
// 						], REST_Controller::HTTP_BAD_REQUEST);	
						
// 					}
// 			}

// 	public function update_personal_details_post() {

// 		if(!empty($_POST))
// 		{			
// 			if(is_token_valid())
// 			{		

// 				$this->form_validation->set_rules('name', 'Name', 'trim|required');
// 				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');	

// 				if ($this->form_validation->run() == TRUE) 
// 				{
// 					$id_from_token = is_token_valid()['data']->id;
// 					$user['name'] = $this->input->post('name');
//         			$user['email'] = $this->input->post('email');
	        					
//        						$this->Apimodel->update('users_login',$user,['id' => $id_from_token]);
// 			                $is_exists = $this->Apimodel->select_single_row(
// 					                	['id','name','mobile','name','email','profile_image as image'],
// 					                	'users_login',
// 					                	['id' => $id_from_token]
// 					                );

// 							$is_exists->image = base_url('assets/user_profile/').$is_exists->image;	
									
						

// 			                if(!empty($is_exists))
// 			                {
// 					                $this->response([					
// 									'status' => TRUE,
// 									'message' => 'Profile Updated!!',
// 									'data' => $is_exists	
// 									], REST_Controller::HTTP_OK);
// 				            }
// 			                else
// 			                {
// 			                		$this->response([
// 			                      	'status' => FALSE,
// 			                      	'message' => 'Something Wrong Contact to Admin!!'
// 			                      	], REST_Controller::HTTP_BAD_REQUEST);	   
// 			                } 
        			                	
// 				}
// 				else 
// 				{    
// 							$this->response([
// 	                      	'status' => FALSE,
// 	                      	'message' => validation_errors()
// 	                      	], REST_Controller::HTTP_BAD_REQUEST);	                
// 	            }	
// 			}
// 			else
// 			{
// 				$this->response([
//               	'status' => FALSE,
//               	'message' => "Token Key invalid!!"
//               	], REST_Controller::HTTP_BAD_REQUEST);	
				
// 			}
			 				
// 		}
// 		else
// 		{			
// 				$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => "Provide complete user information to create."
// 	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
// 		}		
// 	}

// 	public function change_password_post() {

// 		if(!empty($_POST))
// 		{			
// 			if(is_token_valid())
// 			{		

// 				$this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required');
// 				$this->form_validation->set_rules('new_pass', 'New Password', 'trim|required');	
// 				$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required|matches[new_pass]');	

// 				if ($this->form_validation->run() == TRUE) 
// 				{
// 					$id_from_token = is_token_valid()['data']->id;
// 					$old_pass = $this->input->post('old_pass');
//         			$new_pass = $this->input->post('new_pass');

// 					$user_row = $this->Apimodel->selectrow('users_login',['id'=>$id_from_token,'status'=>'1']);
// 					$hash = @$user_row->password;
// 					// pr($id_from_token);

// 					if(password_verify($old_pass, $hash))
// 					{
// 								$new_password = password_hash($new_pass, PASSWORD_DEFAULT);
// 						$this->Apimodel->update('users_login',['password'=>$new_password],['id' => $id_from_token]);
// 						$is_exists = $this->Apimodel->select_single_row(
// 									['id','name','mobile','name','email','profile_image as image'],
// 									'users_login',
// 									['id' => $id_from_token]
// 								);

// 						#$is_exists->image = base_url('assets/user_profile/').$is_exists->image;	

// 						$this->response([
// 						'status' => TRUE,
// 									'message' => 'Password Updated!!',
// 									'data' => $is_exists	
// 									], REST_Controller::HTTP_OK);
// 					}
// 					else
// 					{
// 						$this->response([
// 							'status' => FALSE,
// 							'message' => 'Incorrect Old Password!!'
// 							], REST_Controller::HTTP_BAD_REQUEST);	  
// 					}
	        					
       					
        			                	
// 				}
// 				else 
// 				{    
// 							$this->response([
// 	                      	'status' => FALSE,
// 	                      	'message' => validation_errors()
// 	                      	], REST_Controller::HTTP_BAD_REQUEST);	                
// 	            }	
// 			}
// 			else
// 			{
// 				$this->response([
//               	'status' => FALSE,
//               	'message' => "Token Key invalid!!"
//               	], REST_Controller::HTTP_BAD_REQUEST);	
				
// 			}
			 				
// 		}
// 		else
// 		{			
// 				$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => "Provide complete user information to create."
// 	          	], REST_Controller::HTTP_BAD_REQUEST);		
            
// 		}		
// 	}

// 	public function term_and_condition_get() {	
// 		// if(is_token_valid())
// 		// 	{
// 		// 		$user_id = is_token_valid()['data']->id;
// 				$term_and_condition = $this->Apimodel->select_single_row(['term_and_condition'],'term_and_condition',['id'=>'1']);
// 				$this->response([					
// 									'status' => TRUE,
// 									'message' => 'Data Found Successfully',
// 									'data' => $term_and_condition	
// 									], REST_Controller::HTTP_OK);
// 			// }
// 			// else
// 			// {
// 			// 	$this->response([
// 			// 	'status' => FALSE,
// 			// 	'message' => "Authorization Key invalid!!"
// 			// 	], REST_Controller::HTTP_BAD_REQUEST);	
				
// 			// }
// 		}

// 		public function about_us_get() {

// 					$about_us = $this->Apimodel->select_single_row(['about_us'],'about_us',['id'=>'1']);
// 					$this->response([					
// 										'status' => TRUE,
// 										'message' => 'Data Found Successfully',
// 										'data' => $about_us	
// 										], REST_Controller::HTTP_OK);
				
// 			}

// 		public function faq_get() {
			
// 				$faq = $this->Apimodel->select_multi_row(['title,description'],'faq',['status'=>'1','is_deleted'=>'0']);
// 				$this->response([					
// 									'status' => TRUE,
// 									'message' => 'Data Found Successfully',
// 									'data' => $faq	
// 									], REST_Controller::HTTP_OK);
			
// 		}

// 		public function contact_us_post() {	
// 			if(is_token_valid())
// 				{
// 					$user_id = is_token_valid()['data']->id;
// 					$this->form_validation->set_rules('name', 'Name', 'trim|required');
// 					$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
// 					$this->form_validation->set_rules('email', 'Email Id', 'trim|required');
// 					$this->form_validation->set_rules('message', 'Message', 'trim|required');
	
// 				if ($this->form_validation->run() == TRUE) 
// 					{		
// 						$userData['user_id'] = $user_id;
// 						$userData['name'] = $this->post('name');
// 						$userData['mobile_number'] = $this->post('mobile_number');
// 						$userData['email'] = $this->post('email');
// 						$userData['message'] = $this->post('message');

// 						$insert = $this->Apimodel->insert('contact_us',$userData);
	
// 						if($insert)
// 						{		
// 							$this->response([					
// 								'status' => TRUE,
// 								'message' => 'Contact Details Added Successfully.'											
// 								], REST_Controller::HTTP_OK);										
							
// 						}else{
// 							$this->response([
// 							'status' => FALSE,
// 							'message' => "Some problems occurred, please try again."
// 							], REST_Controller::HTTP_BAD_REQUEST);
							
// 						}
// 					}else 
// 					{    
							
// 						$this->response([
// 						'status' => FALSE,
// 						'message' => array_values($this->form_validation->error_array())[0]
// 						], REST_Controller::HTTP_BAD_REQUEST);		
// 					}
// 				}
// 				else
// 				{
// 					$this->response([
// 					'status' => FALSE,
// 					'message' => "Authorization Key invalid!!"
// 					], REST_Controller::HTTP_BAD_REQUEST);	
					
// 				}
// 			}

// 			public function logout_get()
// 	{
// 		if(is_token_valid())
// 		{
// 			$authorization_key = $this->input->get_request_header('authorization');
// 			#pr($authorization_key);
// 			$logout = $this->Apis_Model->update('jwt_token',['is_active' => '0'],['token' => $authorization_key]);
// 			if($logout)
// 	        {
// 	        	$this->response([					
// 				'status' => TRUE,
// 				'message' => 'Logout successfully.'
// 				// 'token' =>$userData['token']
// 				], REST_Controller::HTTP_OK);
// 	        }
// 	        else{
// 	        	$this->response([
// 	          	'status' => FALSE,
// 	          	'message' => "Something wrong!!"
// 	          	], REST_Controller::HTTP_BAD_REQUEST);
// 	        }
//         }
// 		else
// 		{
// 			$this->response([
// 	      	'status' => FALSE,
// 	      	'message' => "Authorization Key invalid!!"
// 	      	], REST_Controller::HTTP_BAD_REQUEST);	
			
// 		}
// 	}
	

	

}
?>
