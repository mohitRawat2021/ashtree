<!--End topbar header-->
<?php include('include/header.php')?>
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->

        <div class="row mt-3">
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card bg-pattern-success">
                    <a href="<?=base_url('orders')?>">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">12</h4>
                                <span class="text-white">Total Number of Products</span>
                            </div>
                            <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                                <i class="icon-pin text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card bg-pattern-warning">
                    <a href="<?=base_url('complete_orders')?>">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">23</h4>
                                <span class="text-white">Total Number of Orders</span>
                            </div>
                            <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                                <i class="icon-briefcase text-white"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card bg-pattern-primary">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">56</h4>
                                <span class="text-white">Total Revenues</span>
                            </div>
                            <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                                <i class="icon-basket text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
  
</div>
<?php include('include/footer.php')?>