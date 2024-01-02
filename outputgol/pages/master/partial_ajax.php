<?php
include ('../../config/config.inc.php');

// echo "SELECT * FROM `loan` WHERE `status`='1' AND `id` ='". $_REQUEST['receiptno']."' ";
if ($_REQUEST['loanid'] != '') {

    $receiptlist = FETCH_ALL("SELECT * FROM `loan` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['loanid']);
     $interest_details = FETCH_ALL("SELECT COUNT(*) AS `totdue`, SUM(`paid_principal_amt`) AS `totamt` FROM `monthly_interest` WHERE `loanid`=? ", $_REQUEST['loanid']);
     $pending_loan_amt=$receiptlist['amount'] - $interest_details['totamt'];
     $intamt=$pending_loan_amt*($receiptlist['interestpercent']/100);
    $monthcount=getmonth(date('Y-m-d',strtotime($receiptlist['date'])),date('Y-m-d'));
    //$pendingdue=$monthcount-$interest_details['totdue'];
     $pdue=getdays(date('Y-m-d',strtotime($receiptlist['date'])),$intamt);
//$pendingdue=$monthcount-$interest_details['totdue'];
    $dueres=explode('-',$pdue);
    $pendingdue=$dueres[0];
 $pendingdueamt=$dueres[1];
    ?>
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  /*background-color: #dddddd;*/
}
</style>
<div class="panel panel-info">
                            <div class="panel-heading" style="background-color: #d9f7df;">Loan Details</div>
                            <div class="panel-body">
                           
    <div class="row">
        <!--<input type="text" name="currdate" id="currdate" value=""/>-->
        <div class="col-md-4">
            <label>Date of Pawn<span style="color:#FF0000;">*</span></label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" readonly="readonly" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                if (isset($_REQUEST['loanid'])) {
                    echo date('d-m-Y', strtotime($receiptlist['date']));
                } else {
                    echo date('d-m-Y');
                }
                ?>" >
            </div>  
        </div>
        <div class="col-md-4">
            <label>Name <span style="color:#FF0000;">*</span></label>
            <input type="text"  readonly name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo $receiptlist['name'] ?>" />
        </div>
        <div class="col-md-4">
            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
            <input type="text" readonly name="mobileno" id="mobileno" placeholder="Enter Mobile Number" class="form-control" value="<?php echo $receiptlist['mobileno']; ?>" maxlength="10"/>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label>Object <span style="color:#FF0000;"></span></label>
            <textarea name="objectname" id="objectname" class="form-control" readonly><?php
//                $customerlist = FETCH_all("SELECT * FROM `loan` WHERE `status`=? AND `receipt_no` =? AND `returnstatus`=? ", '1', $_REQUEST['receiptno'], '1');
//            echo $cutomerlist['id'].'<br>';
                $i = 1;
                $objectlist = $db->prepare("SELECT * FROM `object_detail` WHERE `status`=? AND `object_id` =?");
                $objectlist->execute(array('1',$_REQUEST['loanid']));
                $count = $objectlist->rowcount();
                while ($objectfetch = $objectlist->fetch(PDO::FETCH_ASSOC)) {
                    echo getobject('objectname', $objectfetch['object']) . ' - ' . $objectfetch['quantity'];
                    if ($i == $count) {
                        echo '';
                    } else {
                        echo ',';
                    }
                    $i++;
                }
                ?>  </textarea>
        </div>
        <div class="col-md-4">
            <label>Net Weight (in gms) <span style="color:#FF0000;"></span></label>
            <input type="text" readonly name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo $receiptlist['netweight']; ?>"/>
        </div>
        <div class="col-md-4">
            <label>Amount <span style="color:#FF0000;"></span></label>
            <input type="text" readonly name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo $receiptlist['amount']; ?>" onchange="amountvalue()"/>
        </div>
    </div>
    <br>
    <div class="row">
       
        <div class="col-md-4">
            <label>Interest <span style="color:#FF0000;"></span></label>
            <input type="text"  readonly id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo $receiptlist['interest']; ?>" />
            <!-- pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" -->
        </div>
        <div class="col-md-4">
            <label>Status <span style="color:#FF0000;">*</span></label>                                  
            <select name="status" readonly class="form-control">
                <option value="1" <?php
                if (stripslashes($receiptlist['returnstatus'] == '1')) {
                    echo 'selected';
                }
                ?>>Pawned</option>
                <option value="2" <?php
                if (stripslashes($receiptlist['returnstatus'] == '2')) {
                    echo 'selected';
                }
                ?>>Patialy Returned</option>
 <option value="3" <?php
                if (stripslashes($receiptlist['returnstatus'] == '3')) {
                    echo 'selected';
                }
                ?>>Fully Returned</option>
            </select>
        </div>
    </div>
    <br>
   <!--  <div class="row">
        <div class="col-md-4">
            <label>Pawn Days <span style="color:#FF0000;">*</span></label>
            <input type="text" id="pawndays"  name="pawndays" class="form-control" value="<?php echo $dateDiff; ?>" onchange="pawndays()" />
        </div>
    </div>
    <br> -->
</div></div>
 <div class="panel panel-info">
        <div class="panel-heading" style="background-color: #d9f7df;">Object Details</div>
        <div class="panel-body">
            <table width="100%" cellpadding="10" cellspacing="10" border="1">
                <tr>
                    <td></td>
                    <td><strong>S.no</strong></td>
                    <td><strong>Object Image</strong></td>
                    <td><strong>Object Name</strong></td>
                    <td><strong>Quantity</strong></td>
                </tr>
                <?php
                   $i = 1;
                $objectlist = $db->prepare("SELECT * FROM `object_detail` WHERE `status`=? AND `object_id` =?");
                $objectlist->execute(array('1',$_REQUEST['loanid']));
                $count = $objectlist->rowcount();
                while ($objectfetch = $objectlist->fetch(PDO::FETCH_ASSOC)) {
                ?>   
                  <tr>
                    <td><input type="checkbox" name="object[]" value="<?php echo $objectfetch['id']; ?>"></td>
                     <td><?php echo $i; ?></td>
                   
                    <td><img src="<?php echo $sitename; ?>img/loan/<?php echo $objectfetch['object_image']; ?>" width="80"></td>
                    <td><?php echo getobject('objectname',$objectfetch['object']); ?></td>
                    <td><?php echo $objectfetch['quantity']; ?></td>
                </tr> 
            <?php $i++; } ?>
            </table>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading" style="background-color: #d9f7df;">Calculation</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                <table width="100%" cellpadding="10" border="1" cellspacing="10"> 
                    <tr>
                        <td><label>&nbsp;&nbsp;Total Paid Due</label></td>
                        <td><label>&nbsp;&nbsp;Total Paid </label></td>
                        <td><label>&nbsp;&nbsp;Total Pending Due</label></td>
                        <td><label>&nbsp;&nbsp;Total Interest Amount</label></td>
                    </tr>
                    <tr>
                    <td>&nbsp;&nbsp;<?php echo $interest_details['totdue']; ?></td>   
                     <td>&nbsp;&nbsp;Rs. <?php echo $interest_details['totamt']; ?></td> 
                     <td>
                        <input type="hidden" name="pending_due" value="<?php echo $pendingdue; ?>">
                        &nbsp;&nbsp;<?php echo $pendingdue; ?></td>  
                     <td>&nbsp;&nbsp;Rs. <?php //$totpending=$pendingdue*$intamt; 
                     $totpending=$pendingdueamt;
                     echo $totpending; ?></td>
                    </tr>
                 </table>
                </div>
</div>
<br>
            <div class="row">
                 <div class="col-md-4">
                <label>Pending Loan Amount <span style="color:#FF0000;">*</span></label>
                <input type="text" name="pending_loan_amount" id="pending_loan_amount1" value="<?php echo $pending_loan_amt; ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Interest Amount <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="interest_amount1"  name="interest_amount" class="form-control" value="<?php echo $totpending; ?>" />

            </div>
            <div class="col-md-4">
                <label>Principal Loan Amount <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="monthly_payment1"  name="monthly_payment" class="form-control" />
            </div>
        
        </div>
        <br>
        <div class="row">
              <div class="col-md-4">
                <label>Paid Principal Amount<span style="color:#FF0000;">*</span></label>
                <input type="text" readonly id="paid_principal_amt1"  name="paid_principal_amt" class="form-control" />
            </div>
            <div class="col-md-4">
                <label>Eligible Gram to Return<span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="eligible_gram1"  name="eligible_gram" class="form-control" value="<?php echo $receiptlist['eligible_gram']; ?>" />
            </div>
            <div class="col-md-4">
                <label>Balance Principal Amount<span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="balance_principal_amt1"  name="balance_principal_amt" class="form-control" value="<?php echo $pending_loan_amt; ?>" />
            </div>
            
        </div>
    </div>
</div>
  
    <?php
}
?>
<script>
    $('.usedatepicker').datepicker({
        autoclose: true
    });
    function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

    function final_pay(a) {

        var d = document.getElementById('date').value;
        var current_date = a;
        from = moment(d, 'DD-MM-YYYY'); // format in which you have the date
        to = moment(current_date, 'DD-MM-YYYY');
        var resultdate = to.diff(from, 'days');
//        var resultdate = Math.abs(different / 86400);
        $('#days').val(resultdate);
        $('#pawndays').val(resultdate);

//        alert(current_date);
//        var days = $('#days').val();
        var amount = $('#amount').val();
        var interest = $('#interest').val();
        var interestminus = (amount - interest);
        var interesrperday = (interestminus / 30);
        var totalinterest = interesrperday * resultdate;
        document.getElementById('totalinterest').value = roundToTwo(totalinterest);
        var finalamount = +totalinterest + +amount;
//                alert(finalamount);
        document.getElementById('finalpay').value = roundToTwo(finalamount);


//         document getElementById('currdate').value = current_date;
    }
//    function dateDiffInDays(date1, date2) {
//        // Calulating the difference in timestamps 
//        var dateobj = new Date(date1); 
//        alert(date1);
//        var dateobj1 = new Date(date2); 
//        var diff = dateobj.toTimeString() - dateobj1.toTimeString();
//        var resultdate = Math.abs(diff / 86400);
//        // 1 day = 24 hours 
//        // 24 * 60 * 60 = 86400 seconds 
//        return resultdate;
//    }
</script>

