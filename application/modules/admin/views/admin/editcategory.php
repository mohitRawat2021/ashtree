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
                    <a href="<?=base_url('malls')?>" class="btn btn-outline-primary waves-effect waves-light">Malls List</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Edit Category Name</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/edit_category/').$this->uri->segment(3)?>" id="" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Type</label>
                                    <div class="col-sm-3">
                                    <label class="radio-inline ch_type">
                                        <input id="che_type" type="radio" name="type" value="0" <?=$category_details->type == "0" ? 'checked' : '' ?> >Store
                                    </label>
                                    <label class="radio-inline ch_type">
                                        <input id="che_type" type="radio" name="type" value="1" <?=$category_details->type == "1" ? 'checked' : '' ?>>Restaurant
                                    </label>                                  
                                    </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="name" value="<?=!empty($category_details) ? $category_details->name : set_value('name')?>" placeholder="Category Name">
                                    <?=form_error('name')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Image</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control form-control-square" name="img" id='img'>
                                    <?=form_error('img')?>
                                </div> 
                                <div class="col-sm-3">
                                    <img width="140px" height="120px" src="<?=base_url('assets/category_img/').$category_details->img?>">
                                </div>                                
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-1">
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

