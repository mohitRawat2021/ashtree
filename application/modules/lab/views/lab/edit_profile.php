<?php include('include/header.php')?>
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
            <?php if($this->session->flashdata('message')) { ?>
                    <div class="alert alert-success" id="msg"><?=$this->session->flashdata('message')?></div>
                <?php } ?>
            </div>
            <div class="col-sm-3">
               
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Edit Profile</div>
                        <hr>
                        <form method="post" action="<?=base_url('restaurant/update_profile')?>"  enctype="multipart/form-data"> 
                       
                       		<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="name" value="<?=ucfirst($profile_details->username)?>" >
                                    <?=form_error('name')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="l_name" value="<?=ucfirst($profile_details->l_name)?>" >
                                    <?=form_error('l_name')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="" value="+<?=$profile_details->country_code.' '.$profile_details->mobile?>" readonly>
                                    <?=form_error('name')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email Id</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="email" value="<?=$profile_details->email?>" >
                                    <?=form_error('email')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Restaurant Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="restaurant_name" value="<?=ucfirst($profile_details->store_name)?>" >
                                    <?=form_error('restaurant_namename')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Estimated Delivery time (In Minutes)</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="estimated_delivery_time" value="<?=ucfirst($profile_details->estimated_delivery_time)?>" >
                                    <?=form_error('estimated_delivery_time')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account Holder Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="account_holder_name" value="<?=ucfirst($profile_details->account_holder_name)?>" >
                                    <?=form_error('account_holder_name')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account Number</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="account_number" value="<?=ucfirst($profile_details->account_number)?>" >
                                    <?=form_error('account_number')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank Code</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="bank_code"value="<?=ucfirst($profile_details->bank_code)?>" >
                                    <?=form_error('bank_code')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Street Address 1</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="street1" value="<?=ucfirst($address->street1)?>" >
                                    <?=form_error('street1')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Street Address 2</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="street2" value="<?=ucfirst($address->street2)?>" >
                                    <?=form_error('street2')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="city" value="<?=ucfirst($address->city)?>" >
                                    <?=form_error('city')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="country" value="<?=ucfirst($address->country)?>" >
                                    <?=form_error('country')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Restaurant Open timings</label>
                                <div class="col-sm-3">                               
                                    <input type="time" class="form-control form-control-square" name="restaurant_open_timings" value="<?php echo $timming->open_time ?>" > 
                                    <?=form_error('open_time')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Restaurant Close timings</label>
                                <div class="col-sm-3">
                                    <input type="time" class="form-control form-control-square" name="restaurant_close_timings" value="<?php echo $timming->close_time?>" >
                                    <?=form_error('close_time')?>
             
                                </div>
                            </div>
                            
							<div class="form-group row">    
							<label class="col-sm-2 col-form-label">Restaurant License</label>
                            <div class="col-sm-3">
									<input id="country" name="restaurant_license" type="file" class="form-control">
                                    <?=form_error('restaurant_license')?>
             
								</div>                           
                                <div class="col-sm-4">
								<img width="190px" height="150px" src="<?=base_url('assets/restaurant_license/').$profile_details->store_license?>">   
                                </div>							
                            </div>

							<div class="form-group row">    
							<label class="col-sm-2 col-form-label">Restaurant Id Proof</label>  
                            <div class="col-sm-3">
									<input name="id_proof" type="file" class="form-control">
                                    <?=form_error('id_proof')?>
             
								</div>                          
                                <div class="col-sm-4">
								<img width="190px" height="150px" src="<?=base_url('assets/restaurant_id_proof/').$profile_details->id_proof?>">    
                                </div>							
                            </div>
                            <div class="row">
                                <div class="col-md-6">	
                                <div class="form-group row">
                                    <input type="checkbox" id="vehicle2" name="confirmation">
                                    <label for="vehicle2">If You Update Your Profile It will move to Admin for the Approval....</label><br>
                                    <?=form_error('confirmation')?>
                                </div>				
                                </div>
							                           
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-3">
                                    <button  onclick="return confirm('Are you sure for Update Your Profile?')" type="submit"
                                        class="btn btn-primary shadow-primary btn-square">
                                        Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Row-->

    </div>
 
<?php include('include/footer.php')?>
<script>
        $(document).ready(function(){
            $('#cat_name').on('change',function(){

                var cat_name = $(this).val();
        	    var fd = new FormData();
                fd.append('cat_name',cat_name);

                $.ajax({
                    url : "<?=base_url('store/get_subcat')?>",
                    method : "POST",
                    dataType : 'json',
                    data : fd,
                    processData: false,
                    contentType: false,
                    success : function(status){
                        $("#subcat_name option:not(:first-child)").remove();
                        status.data.forEach(item => {
                            $("#subcat_name").append(`<option value="${item.id}">${item.name}</option>`);
                        })
                    }
                });
            });
        });
    </script>