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
                        <div class="card-title">Setting</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/setting')?>"> 
                       
                         <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Google API's</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" value="<?php echo $setting->google_api ?>" name="google_api">
                                    <?=form_error('google_api')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">SMS API's</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" value="<?php echo $setting->sms_api ?>" name="sms_api">
                                    <?=form_error('sms_api')?>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label">Per KM Charge's</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" value="<?php echo $setting->per_km_charges ?>" name="per_km_charges">
                                    <?=form_error('per_km_charges')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Default KM Range</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" value="<?php echo $setting->default_km_range ?>" name="default_km_range">
                                    <?=form_error('default_km_range')?>
                                </div>
                            </div>                     
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-3">
                                    <button type="submit"
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