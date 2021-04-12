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
                    <a href="<?=base_url('admin/sub_category')?>" class="btn btn-outline-primary waves-effect waves-light">Sub-Category List</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Category Details</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/add_subcategory')?>" id="" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Type</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="cat_type" id="cat_type">
                                            <option value="">Select</option>
                                            <option value="0">Store</option>
                                            <option value="1">Restaurant</option>
                                        </select>                                 
                                    </div>                            
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category </label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="cat_name" id="cat_name">
                                            <option value="">Select</option>
                                        </select>                                 
                                    </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sub-Category Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="name" value="<?=set_value('name')?>" placeholder="Category Name">
                                    <?=form_error('name')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sub-Category Image</label>
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
<script>
        $(document).ready(function(){
            $('#cat_type').on('change',function(){

                var cat_type = $(this).val();
        	    var fd = new FormData();
                fd.append('cat_type',cat_type);

                $.ajax({
                    url : "<?=base_url('admin/get_cat')?>",
                    method : "POST",
                    dataType : 'json',
                    data : fd,
                    processData: false,
                    contentType: false,
                    success : function(status){
                        $("#cat_name option:not(:first-child)").remove();
                        status.data.forEach(item => {
                            $("#cat_name").append(`<option value="${item.id}">${item.name}</option>`);
                        })
                    }
                });
            });
        });
    </script>
      
 