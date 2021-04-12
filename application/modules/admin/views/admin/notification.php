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
                    <a href="<?=base_url('admin/addnotification')?>" class="btn btn-outline-primary waves-effect waves-light">
                        Add Notification</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Notification List</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Type</th>
                                        <th>Message</th>
                                        <th>Image</th>									
										<th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($notification as $key) { ?>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=($key->vender_type == '0' ? 'Store' : ($key->vender_type == '1' ? 'Restaurant' : 'Delivery Boy '))?></td>
                                        <td><?=$key->message?></td>
                                        <td>
                                        <?php
                                        if(!empty($key->image))
                                        {
                                        ?>
                                            <img width='180px' height="120px" src="<?=base_url('assets/notification_image/').$key->image?>">
                                        <?php     
                                        }
                                        else
                                        {
                                            echo "Image Not Uploaded";
                                        }
                                        
                                        ?>
                                        </td>
                                        <td>
                                            <a class="btn-sm btn-danger" onclick="return confirm('Are you sure want to delete')" href="<?=base_url('admin/delete_notification/').base64_encode($key->id)?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    <?php include('include/footer.php')?>