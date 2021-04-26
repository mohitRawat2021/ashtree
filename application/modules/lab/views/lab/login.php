<body>

 <div id="wrapper">
	<div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-5 animated bounceInDown">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
			 <div class="col-sm-12">
                <?php if($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" id="msg"><?=$this->session->flashdata('error')?></div>
                <?php }
				else{
					?>
				<div class="alert alert-success" id="msg"><?=$this->session->flashdata('message')?></div>
					<?php
				} ?>
            </div>
		 		<!-- <img src="<?=base_url()?>assets/images/logo-icon.png"> -->
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Lab Sign In</div>
		    <form method="post" action="">
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputUsername" class="sr-only">Mobile Number</label>
				  <input type="text" id="exampleInputUsername" name="mobile" class="form-control form-control-rounded" placeholder="Mobile Number" value="<?=set_value('mobile')?>">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
				  <?=form_error('mobile')?>
			   </div>
			  </div>

			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputPassword" class="sr-only">Password</label>
				  <input type="password" id="exampleInputPassword" name="password" class="form-control form-control-rounded" placeholder="Password" <?=set_value('password')?>>
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
				  <?=form_error('password')?>

			   </div>
			  </div>

			<div class="form-row mr-0 ml-0">
			<div class="form-group col-6 text-left">
			  <a href="<?=base_url('restaurant/forget')?>">Reset Password</a>
			 </div>
			 <div class="form-group col-6 text-right">
			 </div>
			</div>
			 <button type="submit" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light">Sign In</button>
			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->

  <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  
</body>

</html>
