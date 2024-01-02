<?php
$menu = "249,249,249";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delobject($chk);
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Do you want to delete the Object(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

</script>
<script type="text/javascript">
    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>
<style type="text/css">
    .row { margin:0;}
 

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Master(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Silver Object Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h1 class="box-title">Loan Report</h1>
            </div>

            <div class="box-body">
                <div class="panel panel-info">

                        <div class="panel-heading">

                            <div class="panel-title">
Search
                            </div>

                        </div>

                        <div class="panel-body">
                        <form name="sform" method="post" autocomplete="off">
                        <div class="row">
                        <div class="col-md-3">
                     <label>Form Date <span style="color:red;">*</span></label>
                         <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="fromdate" id="fromdate" required="required" value="<?php echo $_REQUEST['fromdate']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                        <label>To Date <span style="color:red;">*</span></label>
                        <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="todate" id="todate" required="required" value="<?php echo $_REQUEST['todate']; ?>">
                            </div>
                        
                        </div>
                         <div class="col-md-3">
                        <label>Customer</label>
                        <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                              <select name="customer" class="form-control">
                                <option value="">Select</option>
                               <?php
                                $customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
                                while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $customerfetch['id']; ?>" <?php if (getfullyretun('customer_id', $_REQUEST['cid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                                        echo $customerfetch['cusid'];
                                        echo '-';
                                        echo $customerfetch['name'];
                                        ?></option>
                                <?php } ?>     
                              </select>
                            </div>
                        
                        </div>
                        <div class="col-md-3">
                        <label>Loan Type <span style="color:red;">*</span></label>
                        <select name="loan_type" class="form-control" required>
                        <option value="">Select</option>
                            <option value="1" <?php if($_REQUEST['loan_type']=='1') { ?> selected="selected" <?php } ?>>Monthly Interest Paid</option> 
                        <option value="2" <?php if($_REQUEST['loan_type']=='2') { ?> selected="selected" <?php } ?>>Partial Loan Return</option>   
                        <option value="3" <?php if($_REQUEST['loan_type']=='3') { ?> selected="selected" <?php } ?>>Fully Loan Return</option>  
                        </select>
                        </div>
                         <div class="col-md-3"><br>
                        <button type="submit" class="btn btn-info btn-sm" name="search" style="font-size:16px;">Search</button>
                        </div>

                        </div>
                        <br>
                        </form>
                        </div></div>

                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center></center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:1%;">S.no</th>
                                    <th style="width:10%;">Pawned Date</th>
                                      <th style="width:7%;">Loan ID</th>
                                    <th style="width:8%">Customer ID</th>
                                    <th style="width:12%">Customer Name</th>
                                    <th style="width:13%">Items</th>
                                    <th style="width:12%">Interest Amount</th>
                                    <th style="width:15%">Paid Principle Amount</th>
                                    <th style="width:15%">Balance Principle Amount</th>
                                </tr>
                            </thead>
<tbody>
                            <?php
                            $s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(date(`cudate`)>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND date(`cudate`)<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['customer']!='') {
$s1[]="`customer_id`='".$_REQUEST['customer']."' ";
}
if(is_countable($s1) && count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($_REQUEST['loan_type']!='') {

                            $sid = 1;
                          

                            if($_REQUEST['loan_type']=='1') {
                           $sql4 = $db->prepare("SELECT * FROM `monthly_interest` WHERE `id`!='0' AND $s ORDER BY `id` DESC");
                            $sql4->execute();
                            }
                            if($_REQUEST['loan_type']=='2') {
                                $sql4 = $db->prepare("SELECT * FROM `partial_return` WHERE `id`!='0' AND $s  ORDER BY `id` DESC");
                            $sql4->execute();
                            }
                            if($_REQUEST['loan_type']=='3') {
                            $sql4 = $db->prepare("SELECT * FROM `monthly_return` WHERE `id`!='0' AND $s ORDER BY `id` DESC ");
                            $sql4->execute();
                            }
                       
                            
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {
                                  $tot=0;
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) 
                                {
                                    $date = getloan('date',$purchase['loanid']);
                                    $customerid = getcustomer('cusid',$purchase['customer_id']);
                                    $customername = getcustomer('name',$purchase['customer_id']);
     $sqlitems = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`='".$purchase['loanid']."' ");
     $sqlitems->execute();
     while ($sqlitemsfetch = $sqlitems->fetch(PDO::FETCH_ASSOC)) 
                                {  
                                    $items[] =getobject('objectname',$sqlitemsfetch['object']).' - '.$sqlitemsfetch['quantity'];
                                    } 
                                    $itemss=implode('<br>',$items);
                                    $intamt = $purchase['interest_amount'];
                                    $paidamt =  $purchase['paid_principal_amt'];
                                   
                                   ?>
                                    
                                         <tr>

                                                     <td><?php echo $sid; ?></td>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo $purchase['loanid']; ?>
                                                        
                                                    </td>
                                                    <td><?php  echo $customerid; ?></td>
                                                    <td><?php  echo $customername; ?></td>
                                                    <td><?php  echo $itemss; ?></td>
                                                    <td><?php  echo $intamt; ?></td>
                                                    <td><?php  echo $paidamt; ?></td>
                                                    <td><?php echo $purchase['balance_principal_amt']; ?></td>
                                                    <?php $sid++; ?>

                                                 
                                                </tr>

                                               

                                                <?php 
                                  
                                }
                                
                            }
}

                            ?>
                           <tbody>

                            

                            
                            <tfoot>
                                 <!-- <h3>Total Amount : <?php echo number_format($tot,2); ?><br><br></h3> -->
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>  
<script type="text/javascript">
      $('#normalexamples').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true
    
    });
</script>