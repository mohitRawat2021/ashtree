<?php 
include('include/header.php');
//  pr($orders);
?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">   
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="display: flex;align-items: center; background-color: #c8eaeebd;"><i class="fa fa-table"></i>Order's Details
                          <div style="font-size: 17px;margin-left: auto;">Order ID : 
                        <span class="colorred" style="margin-right: 17px;"><?=@$orders->order_id?></span>
                        <button class="btn btn-info" onclick="goBack()">Go Back</button>
                    </div>
                    </div>
                  
                    <div class="card-body" style="background-color: #eaf2f9;">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Sl No.</th>            
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Product Qty</th>         
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                      #$product_details = json_decode($orders->product_details);$i=1; 
                                      $product_details = $orders->pro_name;
                                      $i=1; 
                                      foreach($product_details as $k=>$v) 
                                      { 
                                       
                                    ?>
                                     <tr data-id="<?=$orders->id?>">
                                        <th scope="row"><?=$i++?></th>                                      
                                        <td>
                                        <?=$v->name?>
                                        </td>
                                        <td><?=$v->qty?></td>                                     
                                        
                                    </tr>
                                    <?php 
                                    } 
                                    ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">      
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                    <hr>
                        <div class="card-title">Order Detail's</div>   
                        
                        <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="20%">Product Category</th>
                                        <td width="80%"><?=$orders->vendor_type =='0' ? 'Store' : 'Restaurant'?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Order Id</th>
                                        <td width="80%"><?=$orders->order_id?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Total Payble Amount</th>
                                        <td width="80%"><?=$orders->total_amount?> Rs.</td>
                                    </tr>  
                                    <tr>
                                        <th width="20%">Discount Amount</th>
                                        <td width="80%"><?=$orders->discount_amount?> Rs.</td>
                                    </tr>     
                                    <tr>
                                        <th width="20%">Payment Method</th>
                                        <td width="80%"><?=$orders->payment_method == 0 ? "Cash on Delivery" : "Online Payment"?></td>
                                    </tr> 
                                    <tr>
                                        <th width="20%">Transaction Id</th>
                                        <td width="80%"><?=$orders->transaction_id?></td>
                                    </tr>  
                                    <tr>
                                        <th width="20%">Payment Status</th>
                                        <td width="80%"><?=$orders->payment_status?></td>
                                    </tr> 
                                    <tr>
                                        <th width="20%">Used Coupon</th>
                                        <td width="80%"><?=$orders->coupon_code?></td>
                                    </tr>                                
                                   
                                      
                                              
                        </table>
                        <div class="card-title">Customer Detail's</div>     
                                           
                        <hr>
                        <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="20%">Full Name</th>
                                        <td width="80%"><?=ucfirst($orders->customer_name)?></td>
                                    </tr>                                   
                                    <tr>
                                        <th width="20%">Mobile Number</th>
                                        <td width="80%"><?=$orders->mobile?></td>
                                    </tr> 
                                    <tr>
                                        <th width="20%">Shipping Address</th>
                                        <td width="80%"><?=$orders->shipping_add?></td>
                                    </tr>                                                                    
                        </table>
                        <hr>
                        <div class="card-title"><?=$orders->vendor_type=='0' ? 'Store' : 'Restaurant'?> Detail's</div>   
                        
                        <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="20%">Owner Name</th>
                                        <td width="80%"><?=$vender_details->username.' '.$vender_details->l_name?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Mobile Number</th>
                                        <td width="80%"><?=$vender_details->country_code.'-'.$vender_details->mobile?></td>
                                    </tr>                                   
                                    <tr>
                                        <th width="20%">Store Name</th>
                                        <td width="80%"><?=$vender_details->store_name?></td>
                                    </tr>                                   
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--End Row-->

    </div>
</div>
<?php include('include/footer.php')?>
