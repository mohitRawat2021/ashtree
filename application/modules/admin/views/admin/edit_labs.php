

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
                <div class="btn-group float-sm-right">
                <a href="<?=base_url('admin/labs')?>" class="btn btn-outline-primary waves-effect waves-light">Delivery Boy List</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Delivery Boy Details</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/edit_labs/').$this->uri->segment('3')?>" id="" enctype="multipart/form-data">                           
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="name" value="<?=$labs->name?>" placeholder="Name">
                                    <?=form_error('name')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email ID</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="email" value="<?=$labs->email?>" placeholder="Email Id">
                                    <?=form_error('email')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="mobile" value="<?=$labs->mobile?>" placeholder="Mobile Number">
                                    <?=form_error('mobile')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Lab Address</label>
                                <div class="col-sm-3">
                                    <input type="text" id="address-input" class="form-control form-control-square map-input" name="lab_address" value="<?=$labs->lab_address?>" placeholder="Delivery Area">
                                    <?=form_error('lab_address')?>
                                    <input type="hidden" class="form-control manual-address-input" readonly name="longitude" id="address-langitude" placeholder="Longitude">
                                    <input type="hidden" class="form-control manual-address-input" readonly name="latitude" id="address-latitude" placeholder="Latitude">
                                    <div id="address-map"></div>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="account_holder_name" value="<?=$labs->account_holder_name?>" placeholder="Account Holder Name">
                                    <?=form_error('account_holder_name')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="bank_name" value="<?=$labs->bank_name?>" placeholder="Bank Name">
                                    <?=form_error('bank_name')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">IFSC Code</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="ifsc_code" value="<?=$labs->ifsc_code?>" placeholder="IFSC Code">
                                    <?=form_error('ifsc_code')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Branch Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="branch_name" value="<?=$labs->branch_name?>" placeholder="Branch Name">
                                    <?=form_error('branch_name')?>
                                </div>
                            </div>                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">A/c Number</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="account_number" value="<?=$labs->account_number?>" placeholder="A/c Number">
                                    <?=form_error('account_number')?>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="password" placeholder="Password">
                                    <?=form_error('password')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Admin Commission</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="admin_commission" value="<?=$labs->admin_commission?>" placeholder="Admin Commission">
                                    <?=form_error('admin_commission')?>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-1">
                                    <button type="submit"
                                        class="btn btn-primary shadow-primary btn-square">
                                        Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Row-->

    </div>
</div>
<style>
.ch_type
{
    
    color: #6b6b6b;
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    margin-bottom: 10px;
    padding-left: 5px;
    margin-left: 12px;

}

#che_type
{
    
    left: -10px;
  
    top: 2px;

}
    </style>    
<?php include('include/footer.php')?>

 