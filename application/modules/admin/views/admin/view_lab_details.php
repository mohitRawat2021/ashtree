<?php include('include/header.php')?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">   
      
        <div class="row">      
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Personal Detail's</div>                        
                        <hr>
                        <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="20%">Full Name</th>
                                        <td width="80%"><?=ucfirst($labs->name)?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Email</th>
                                        <td width="80%"><?=$labs->email?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Mobile Number</th>
                                        <td width="80%"><?=$labs->mobile?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Address</th>
                                        <td width="80%"><?=$labs->lab_address?></td>
                                    </tr>                                                          
                        </table>
                        <hr>
                       
                        <div class="card-title">Bank Detail's</div>
                        <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="20%">Bank Name</th>
                                        <td width="80%"><?=$labs->bank_name?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Branch Name</th>
                                        <td width="80%"><?=$labs->branch_name?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Account Holder Name</th>
                                        <td width="80%"><?=$labs->account_holder_name?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%">IFSC Code</th>
                                        <td width="80%"><?=$labs->ifsc_code?></td>
                                    </tr>                                   
                                    <tr>
                                        <th width="20%">Account Number</th>
                                        <td width="80%"><?=$labs->account_number?></td>
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
