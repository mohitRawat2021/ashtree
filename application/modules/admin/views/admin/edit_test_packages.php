<?php include('include/header.php');  
$test_id = explode(',',$test_packages->test_id);
?>
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
                    <a href="<?=base_url('admin/lab_test')?>" class="btn btn-outline-primary waves-effect waves-light">Lab Test List</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Edit Test Package's</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/edit_test_packages/').$this->uri->segment('3')?>" id="all_mall" enctype="multipart/form-data"> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-3">
                                    <select class="form-control form-control-square js-example-basic-multiple"  name="cat_name[]" multiple="multiple">
                                        <option value="">Select Category</option>
                                        <?php                                        
                                        foreach($lab_test as $v)
                                        {
                                        ?>
                                            <option value="<?=$v->id?>"  <?=in_array($v->id, $test_id) ? 'selected' : ''?>><?=ucfirst($v->name)?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?=form_error('cat_name')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="name" value="<?=$test_packages->name?>" placeholder="Enter test Name">
                                    <?=form_error('name')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Price</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="price" value="<?=$test_packages->price?>" placeholder="Enter test Price">
                                    <?=form_error('price')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Preparation for test</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="preparation" value="<?=$test_packages->preparation?>" placeholder="Preparation">
                                    <?=form_error('preparation')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Do & Don't</label>
                                <div class="col-sm-3">
                                    <textarea class="form-control form-control-square" placeholder="Do & Don't" name="do_dont"><?=$test_packages->do_dont?></textarea>
                                    <?=form_error('do_dont')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Components</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="components" value="<?=$test_packages->components?>" placeholder="Components">
                                    <?=form_error('components')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Use of test</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-square" name="use_of_test" value="<?=$test_packages->use_of_test?>" placeholder="Use of Test">
                                    <?=form_error('use_of_test')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Thumb Image</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control form-control-square" name="thumb_img">
                                    <?=form_error('thumb_img')?>
                                </div>
                                <div class="col-sm-3">
                                    <img width="140px" height="120px" src="<?=base_url($test_packages->thumb_img)?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Galary Image</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control form-control-square" name="item_image">
                                    <?=form_error('item_image')?>
                                </div>
                                <div class="col-sm-3">
                                    <img width="140px" height="120px" src="<?=base_url($test_packages->galary_img)?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tests Information</label>
                                <div class="col-sm-3">
                                    <textarea class="form-control form-control-square" placeholder="Test Information" name="test_info"><?=set_value('test_info')?><?=$test_packages->test_info?></textarea>
                                    <?=form_error('test_info')?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Home Vist</label>
                                <div class="col-sm-3">
                                    <select class="form-control form-control-square" name="home_visit" id="home_visit">
                                            <option value="">Select</option>
                                            <option value="0" <?=$test_packages->home_visit == "0" ? 'selected' : ''?>>Avaliable</option>                                       
                                            <option value="1" <?=$test_packages->home_visit == "1" ? 'selected' : ''?>>Not-Avaliable</option>                                       
                                    </select>
                                    <?=form_error('home_visit')?>
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
    <?php include('include/footer.php')?>
    <script>
        $(document).ready(function(){
            $('#cat_name').on('change',function(){

                var cat_name = $(this).val();
        	    var fd = new FormData();
                fd.append('cat_name',cat_name);

                $.ajax({
                    url : "<?=base_url('vender/restaurant/get_subcat')?>",
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

<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
    placeholder: "Select Test For Packages",
    allowClear: true
});
});
</script>