<?php include('include/header.php');?>
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
                <!-- <div class="btn-group float-sm-right">
                <a href="<?=base_url('admin/labs')?>" class="btn btn-outline-primary waves-effect waves-light">Delivery Boy List</a>
                </div> -->
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Schedule</div>
                        <hr>
                        <form method="post" action="<?=base_url('admin/lab_timing/').$this->uri->segment('3')?>">                           
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sunday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="0" <?=@$sun->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$sun->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$sun->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Monday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="1" <?=@$mon->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$mon->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$mon->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tuesday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="2" <?=@$tue->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$tue->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$tue->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Wednesday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="3" <?=@$wed->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$wed->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$wed->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Thursday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="4" <?=@$thus->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$thus->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$thus->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Friday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="5" <?=@$fri->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$fri->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$fri->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Saturday</label>                        
                            <div class="col-sm-1 form-check">
                               <input type="checkbox" class="form-check-input" name="days[]" value="6" <?=@$sat->status =='2'?'checked':''?>>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="open[]" value="<?=@$sat->o_time?>">
                                <?=form_error('open[]')?>
                            </div>
                            <div class="col-sm-3">
                                <input type="time" class="form-control form-control-square" name="close[]" value="<?=@$sat->c_time?>">
                                <?=form_error('close[]')?>
                            </div>
                        </div>
                        
                            <!-- <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="">Option 2
                            </label>
                            </div> -->
                            
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

 