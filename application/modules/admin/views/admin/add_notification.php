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
                    <a href="<?=base_url('admin/notification')?>" class="btn btn-outline-primary waves-effect waves-light">Notification List</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Notification Details</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/addnotification')?>" id="" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Type</label>
                                    <div class="col-sm-3">
                                    <label class="radio-inline ch_type">
                                        <input id="che_type" type="radio" name="type" value="0" checked>Store
                                    </label>
                                    <label class="radio-inline ch_type">
                                        <input id="che_type" type="radio" name="type" value="1">Restaurant
                                    </label> 
                                    <label class="radio-inline ch_type">
                                        <input id="che_type" type="radio" name="type" value="2">Delivery Boy
                                    </label>                                  
                                    </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Message</label>
                                <div class="col-sm-5">
                                    <textarea rows="10" class="form-control form-control-square" name="message" placeholder="Message"><?=set_value('message')?></textarea>
                                    <?=form_error('message')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control form-control-square" name="img" id='img'>
                                    <?=form_error('img')?>
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
      
 