<?php
if (isset($_REQUEST['cid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,11";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');



if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getcustomer('image', $getid);


 $imag1 = strtolower($_FILES["id_proof_image"]["name"]);
    $pimage1 = getcustomer('idproof_img', $getid);


    if ($imag) {
        if ($pimage != '') {
            unlink("../../img/customer/" . $pimage);
            unlink("../../img/customer/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 2000;
        $height = 500;
        $width1 = 1000;
        $height1 = 300;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = strtolower($imagec);
            $imagev = strtolower($m) . "." . $extension;
            $thumppath = "../../img/customer/";
            $filepath = "../../img/customer/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($getid!='') {
            $image = $pimage;
        } else {
            $image = '';
        }
    }



    if ($imag1) {
        if ($pimage1 != '') {
            unlink("../../img/id_proof_image/" . $pimage1);
        }
        $main1 = $_FILES['id_proof_image']['name'];
        $tmp1 = $_FILES['id_proof_image']['tmp_name'];
        $size1 = $_FILES['id_proof_image']['size'];
        $width1 = 1000;
        $height1 = 300;
        $extension1 = getExtension($main1);
        $extension1 = strtolower($extension1);
        if (($extension1 == 'jpg') || ($extension1 == 'png') || ($extension1 == 'gif')) {
            $m1 = time();
            $imagev1 = strtolower($m1) . "." . $extension1;
            $thumppath1 = "../../img/id_proof_image/";
            $filepath1 = "../../img/id_proof_image/";
            $bbb1 = Imageupload($main1, $size1, $width1, $filepath1, $filepath1, '255', '255', '255', $height1, strtolower($m1), $tmp1);
        } else {
            $ext1 = '1';
        }
        $image1= $imagev1;
    } else {
        if ($getid!='') {
            $image1 = $pimage1;
        } else {
            $image1 = '';
        }
    }



// $proofname1 = implode(',',$proofname);
// $proof1 = implode(',',$proof);

// $object1 = implode(',',$objectval);
// $quantity1 = implode(',',$quantity);

// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
$msg = addcustomer($cusid,$date,$receipt_no,$name,$mobileno,$image,$address,$object1,$image1,$idproof,$proofname1,$proof1,$quantity1,$netweight,$amount,$interestpercent,$interest,$status,$ip, $getid);
}

if (isset($_REQUEST['cid']) && ($_REQUEST['cid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['cid'];
    echo '<script>window.location.href="' . $sitename . 'master/' + $_REQUEST['cid'] + 'editcustomer.htm"</script>';
}
?>


    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Customer</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/customer.htm"><i class="fa fa-circle-o"></i> Customer</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Customer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Customer</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        <div class="col-md-4">
                             <label>Customer ID <span style="color:#FF0000;">*</span></label>
                         <?php $purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '2'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="cusid" id="cusid" class="form-control" placeholder="Enter the Customer ID" value="<?php if(getcustomer('cusid',$_REQUEST['cid'])!= ''){ echo getcustomer('cusid',$_REQUEST['cid']); }else{ echo $purid; } ?>" readonly />
                        </div> 
                        <div class="col-md-4">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                             <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                        if (isset($_REQUEST['cid']) && (date('d-m-Y', strtotime(getcustomer('date',$_REQUEST['cid']))) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime(getcustomer('date',$_REQUEST['cid'])));
                                        } else {
                                            echo date('d-m-Y');
                                        }
                                        ?>" >
                                    </div>  
                        </div>
                         <!-- <div class="col-md-4">
                             <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo (getcustomer('receipt_no',$_REQUEST['cid'])); ?>" />
                        </div>  -->
                          <div class="col-md-4">
                            <label>Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo stripslashes(getcustomer('name',$_REQUEST['cid'])); ?>" />
                        </div>
                    </div>
                    
                     <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Mobile Number</label>
                            <input type="text" name="mobileno" id="mobileno" placeholder="Enter Mobile Number" class="form-control" value="<?php echo stripslashes(getcustomer('mobileno',$_REQUEST['cid'])); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getcustomer('address',$_REQUEST['cid']); ?></textarea>
                        </div>
                         <div class="col-md-4">
                                <label>ID Proof</label>
                                <input type="text" id="idproof"  name="idproof" placeholder="Enter The ID Proof" class="form-control" value="<?php echo stripslashes(getcustomer('idproof',$_REQUEST['cid'])); ?>" />
                        </div>
                        
                    </div><br>
                    <div class="row">
                    
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Customer Photo <span style="color:#FF0000;"> (Recommended Size 1920 * 450)</span></label>
                                    <input class="form-control spinner" <?php if (getcustomer('image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="image" type="file"> 
                                </div>
                        </div>
                            
                            <?php if (getcustomer('image', $_REQUEST['cid']) != '') { ?>
                                <div class="col-md-4" id="delimage">
                                    <label> </label>
                                    <img src="<?php echo $fsitename; ?>img/customer/<?php echo getcustomer('image', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                    <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getcustomer('image', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'customer', '../../../img/customer/', 'image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                </div>
                            <?php } ?>
                        
                        
                    </div>
                    <div class="row">
                         
                        <!-- <div class="col-md-4">
                            <label>Object<span style="color:#FF0000;">*</span>&nbsp;&nbsp;<a href="<?php // echo $sitename; ?>master/addobject.htm">Add object</a></label>
                            <select name="object" id="object" class="form-control" required="required">
                            <option value="">Select</option>
                            <?php
                            // $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
                            // while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php // echo $objectfetch['id']; ?>" <?php //if (getcustomer('object', $_REQUEST['cid']) == $objectfetch['id']) { ?> selected <?php // } ?>><?php // echo $objectfetch['objectname']; ?></option>
                            <?php // } ?>               
                        </select> 
                        </div>
                        <div class="col-md-4">
                            <label>Quantity <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="quantity" id="quantity" placeholder="Enter quantity" class="form-control" value="<?php //echo stripslashes(getcustomer('quantity',$_REQUEST['cid'])); ?>" maxlength="10"/>
                        </div> -->
                        
                    </div>  <br>
                    <!-- <div class="clearfix"><br /></div>
                     <div class="panel panel-info">
                        <div class="panel-heading" style="background-color: #d9f7df;">Object Details</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.no</th>
                                                    <th width="20%">Object</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="55%">Image</th>
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
                                                   <td>
                                                   <select name="objectval[]" id="objectval[]" class="form-control" >
                                                        <option value="">Select</option>
                                                        <?php
                                                        $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
                                                        while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $objectfetch['id']; ?>" <?php if (getobjectdetail('object', $_REQUEST['cid']) == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['objectname']; ?></option>
                                                        <?php } ?>               
                                                    </select> -->
                                                       <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                  <!-- </td>
                                                    <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" class="form-control" value="<?php echo getobjectdetail('quantity',$_REQUEST['cid']); ?>"/></td>
                                                    <td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>
                                                </tr>
                                                <?php
                                                    $b = 1;
                                                    $object1 = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`= ?");
                                                    $object1->execute(array($_REQUEST['cid']));
                                                    $scount = $object1->rowcount();
                                                    if ($scount != '0') {
                                                        while ($object1list = $object1->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $b; ?></td>
                                                   <td>
                                                   <select name="objectval[]" id="objectval[]" class="form-control" >
                                                        <option value="">Select</option>
                                                        <?php
                                                        $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
                                                        while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $objectfetch['id']; ?>" <?php if ($object1list['object'] == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['objectname']; ?></option>
                                                        <?php } ?>               
                                                    </select> -->
                                                       <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                  <!-- </td>
                                                    <td><input type="number" style="text-align: right;" name="quantity[]" class="form-control" value="<?php echo $object1list['quantity']; ?>"/></td>
                                                    <td>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="object_image[]" type="file">
                                                        </div>                 
                                                         <?php if($object1list['object_image'] != '') { ?>   
                                                        <div class="col-md-8" id="delimage">
                                                        <input class="form-control spinner"value="<?php echo $object1list['object_image'];?>" name="object_image[]" type="text">
                                                            <img src="<?php echo $fsitename; ?>img/object/<?php echo $object1list['object_image']; ?>" style="padding-bottom:10px;" height="100" /> -->
                                                            <!-- <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo $object1list['object_image']; ?>', '<?php echo $object1list['id']; ?>', 'object_detail', '../../img/object/', 'object_image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>                                                             -->
                                                        <!-- </div>
<?php } ?>
                                                    </div>
                                                        </td>
                                                    <td onclick="delrec1($(this), '<?php echo $object1list['id']; ?>')" style="border: 1px solid #f4f4f4;"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                    </tr>
                                                    <?php  
                                                           $b++; }
                                                        }
                                                    ?>
                                            </tbody>
                                            <tfoot>  
                                                <tr><td colspan="2" ></td></tr>
                                                <tr>
                                                    <td colspan="2" style="border:0;"><button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-md-4">
                            <label>Net Weight (in gms) <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getcustomer("netweight",$_REQUEST['cid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getcustomer("amount",$_REQUEST['cid']));  ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;"></span></label>
                            <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" onchange="interest_calculation()" value="<?php echo stripslashes(getcustomer("interestpercent",$_REQUEST['cid'])); ?>" />
                        </div>
                       
                    </div> <br> -->
                         <!-- <div class="panel panel-info">
                        <div class="panel-heading">ID Proof Details</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="proof_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.no</th>
                                                    <th width="10%">Proof Name</th>
                                                    <th width="10%">Proof</th>
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                    <tr id="firstprooftr" style="display:none;">
                                                    <td>1</td>

                                                   <td>
                                                       <input type="text" name="proofname[]" id="proofname[]" class="form-control">
                                                      
                                                  </td>
                                                   
                                                  <td><input type="file" name="proof[]" id="proof[]"  class="form-control"></td>
                                                  
                                                </tr>


                                            </tbody>
                                            <tfoot>
                                                
                                                <tr><td colspan="2"></td></tr>
                                                <tr>
                                                    <td colspan="2" style="border:0;"><button type="button" class="btn btn-info" id="add_proof">Add Proof</button></td>
                                                    
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>                                   
                                </div>
                            </div>
                        </div>

                    </div> -->
                     <!-- <div class="clearfix"><br /></div> -->
                    <!-- <div class="row">
                          <div class="col-md-4">
                            <label>Net Weight (in gms) <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getcustomer('netweight',$_REQUEST['cid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getcustomer('amount',$_REQUEST['cid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getcustomer('interestpercent',$_REQUEST['cid'])); ?>" />
                        </div>
                       
                    </div> 
                     
                     <br> -->
                     <div class="row">
                          <!-- <div class="col-md-4">
                            <label>Interest <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo stripslashes(getcustomer('interest',$_REQUEST['cid'])); ?>" />
                        </div> -->
                       
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>ID Proof Image <span style="color:#FF0000;"> </span></label>
                                    <input class="form-control spinner" <?php if (getcustomer('id_proof_image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="id_proof_image" type="file"> 
                                </div>
                        </div>

                         <?php if (getcustomer('idproof_img', $_REQUEST['cid']) != '') { ?>
                                <div class="col-md-4" id="delimage1">
                                    <label> </label>
                                    <img src="<?php echo $fsitename; ?>img/id_proof_image/<?php echo getcustomer('idproof_img', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                    <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del1" id="del1" onclick="javascript:deleteimage1('<?php echo getcustomer('idproof_img', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'customer', '../../../img/id_proof_image/', 'idproof_img', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                </div>
                            <?php } ?>


                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           
                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                                            <select name="status" class="form-control">
                                                                <option value="1" <?php
                                                                if (stripslashes(getcustomer('status', $_REQUEST['cid'])) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Active</option>
                                                                <option value="0" <?php
                                                                if (stripslashes(getcustomer('status', $_REQUEST['cid']) == '0')) {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Inactive</option>

                                                            </select>
                        </div>
                     </div>    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/customer.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['cid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">

     function show_contacts(id) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
        });
    }


      function delrec(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['cid']); ?>/editprovider.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {
        
        $('#add_task').click(function () {

           
            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Offer?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });
       
         $('#add_proof').click(function () {

           
            var data = $('#firstprooftr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Proof?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#proof_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });

        

      });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }


   
   
    
    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }

    function delrec1(elem, id) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();

            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['cid']); ?>/editcustomer.htm?delid1=" + id;
        }
    }

    function interest_calculation(){
        var interest_amount = $('#amount').val();
        var interest_percent = $('#interestpercent').val();
        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = interest_amount - (interest_amount *  a);
        // alert(interest_total);
        document.getElementById('interest').value = interest_total;
        // $('#interest').html(interest_total);
    }
    

</script>