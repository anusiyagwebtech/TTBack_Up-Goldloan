<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,18";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['lid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getloan('image', $getid);

    if ($imag) {
        if ($pimage != '') {
            unlink("../../img/loan/" . $pimage);
            unlink("../../img/loan/thump/" . $pimage);
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
            $thumppath = "../../img/loan/";
            $filepath = "../../img/loan/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['lid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }

  
    for ($i = 0; $i < count($_FILES['object_image']['name']); $i++) {
    
        if ($_FILES['object_image']['name'][$i]) {
                  
            $main = $_FILES['object_image']['name'][$i];
            $tmp = $_FILES['object_image']['tmp_name'][$i];
            $extension = getExtension($main);
            $extension = strtolower($extension);
            $m = time() . rand();
            $object_image = $m . "." . $extension;
            move_uploaded_file($tmp, '../../img/loan/' . $object_image);

                $object_images[] = $object_image;
            
        }
    else
    {
      if($eobject_image[$i]!='') {
       $object_images[] = $eobject_image[$i];
      }
      else {
        $object_images[]='';
      }       
            
    }
    }


    

    // echo 'hiii';
    // print_r($object_image1);
    // exit;
    // $object_image11 = ltrim($object_image1, ',');
    // print_r($object_image1);
    // exit;

    //$proofname1 = implode(',', $proofname);
   // $proof1 = implode(',', $proof);
    $objectvalname1=implode(',',$objectvalname);
    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $objweight1=implode(',',$objweight);
//    print_r($object1);
//    exit;

 $object_imagess1=implode(',',$object_images);
   
    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);

    $customerid = $customerid1['cusid'];
// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');

    $msg = addloan($objectvalname1,$detection_gram,$today_rate,$objweight1,$cusid, $customerid, $date,$valueofitem, $receipt_no, $name, $mobileno, $image, $address, $object1, $object_imagess1, $idproof, $proofname1, $proof1, $quantity1, $totalquantity,$gross_weight,$gross_weight_detection, $netweight, $amount, $interestpercent, $interest,$return_type, $status, $ip, $getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];
    echo '<script>window.location.href="' . $sitename . 'master/' + $_REQUEST['lid'] + 'editloan.htm"</script>';
}

///////GET GOLD RATE
$gen_id = 1;
$smstemplate = FETCH_all("SELECT * FROM `generalsettings` WHERE `generalid` = ?", $gen_id);
    $gold_rate = $smstemplate['gold_rate'];

?>




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loan
            <small><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Loan</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/loan.htm"><i class="fa fa-circle-o"></i> Loan</a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Loan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['lid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Loan</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                            <?php $purid = getlastloanid('loan', 'receipt_no');
                            ?>
                             <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" required value="<?php
                            if (getloan('receipt_no', $_REQUEST['lid']) != '') {
                                echo getloan('receipt_no', $_REQUEST['lid']);
                            } else {
                                echo "";
                            }
                            ?>"/>
                           <!--  <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php
                            if (getloan('receipt_no', $_REQUEST['lid']) != '') {
                                echo getloan('receipt_no', $_REQUEST['lid']);
                            } else {
                                echo $purid;
                            }
                            ?>"/> -->
                                <!-- <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo (getloan('receipt_no', $_REQUEST['lid'])); ?>" /> -->
                        </div>
                        <!-- <div class="col-md-4">
                        <label>Customer ID <span style="color:#FF0000;">*</span><a href="<?php $fsitename; ?>addcustomer.htm"> Add Customer </a></label>
                        <input list="cusid">
                        <datalist name="cusid" id="cusid" class="form-control" required="required" onchange="customer(this.value)">
                           <option value="Internet Explorer"> -->
                        <!-- <option value="">Select</option> -->
                        <?php
                        $customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
                        while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                                        <!-- <option value="<?php echo $customerfetch['id']; ?>" <?php if (getloan('cusid', $_REQUEST['lid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                            echo $customerfetch['cusid'];
                            echo '-';
                            echo $customerfetch['name'];
                            ?></option>  -->
                                                        <!-- <input type="text" name="customerid" id="customerid" value="<?php
                            if ($_REQUEST['lid'] == $customerfetch['id']) {
                                echo $customerfetch['cusid'];
                            }
                            ?>" /> -->
                        <?php } ?>
                        <!-- </datalist>                        
                        </div>  -->
                        <div class="col-md-4">
                            <label>Customer ID <span style="color:#FF0000;">*</span><a href="<?php $fsitename; ?>addcustomer.htm"> Add Customer </a></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <select name="cusid" id="cusid" class="form-control select2" required="required" onchange="customer(this.value)" style="font-size: 19px;font-weight: bold;">
                                <option value="">Select</option>
                                <?php
                                $customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
                                while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $customerfetch['id']; ?>" <?php if (getloan('cusid', $_REQUEST['lid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                                        echo $customerfetch['cusid'];
                                        echo '-';
                                        echo $customerfetch['name'];
                                        ?></option>
                                   
                                <?php } ?>               
                            </select>

<!-- <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Enter the Customer ID" value="<?php echo getreturn("customerid", $_REQUEST['cid']); ?>" /> -->
                        </div> 
                        <div class="col-md-4">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime(getloan('date', $_REQUEST['lid']))) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime(getloan('date', $_REQUEST['lid'])));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>

                    </div>
                    <!-- <div class="row">
                        
                        <div class="col-md-4">
                            <label>Value of Items  <span style="color:#FF0000;"></span></label>
                            <input type="text" name="valueofitem" id="valueofitem" placeholder="Enter Value of Item" class="form-control" value="<?php echo stripslashes(getloan("valueofitem", $_REQUEST['lid'])); ?>"/>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image <span style="color:#FF0000;"> (Recommended Size 1920 * 450)</span></label>
                                    <input class="form-control spinner" <?php if (getloan('image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="image" type="file"> 
                                </div>
                        </div>
                            
                            <?php if (getloan('image', $_REQUEST['cid']) != '') { ?>
                                <div class="col-md-4" id="delimage">
                                    <label> </label>
                                    <img src="<?php echo $fsitename; ?>img/customer/<?php echo getcustomer('image', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                    <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getloan('image', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'customer', '../../../img/loan/', 'image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                </div>
                            <?php } ?>
                    </div> -->
                    <div class="clearfix"><br /></div>
                    <div class="row" id="customerdetail">
                        <?php
                        if ($_REQUEST['lid'] != '') {
                            // $customerid = getsectorscheme('incharge', $_REQUEST['sid']);
                            $customerlist = FETCH_all("SELECT * FROM `customer` WHERE `status`=? AND `cusid` =?  AND `id` =? ", '1', getloan('cusid', $_REQUEST['lid']), getloan('id', $_REQUEST['lid']));
                            ?>
                            <div class="col-md-4">
                                <label>Name <span style="color:#FF0000;">*</span></label>
                                <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php
                                echo getloan('name', $_REQUEST['lid']);
                                echo $customerlist['name'];
                                ?>" />
                            </div>
                            <!-- <div class="col-md-4">
                                <label>Address <span style="color:#FF0000;">*</span></label>
                                <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getloan('address', $_REQUEST['lid']); ?></textarea>
                            </div> -->
                            <div class="col-md-4">
                                <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                                <input type="text" required="required" name="mobileno" id="mobileno" placeholder="Enter Mobile Number" class="form-control" value="<?php
                                echo getloan('mobileno', $_REQUEST['lid']);
                                echo $customerlist['mobileno'];
                                ?>" maxlength="10"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Address <span style="color:#FF0000;">*</span></label>
                                <textarea name="address" id="address" class="form-control" ><?php
                                    echo getloan('address', $_REQUEST['lid']);
                                    echo $customerlist['address'];
                                    ?></textarea>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image <span style="color:#FF0000;"> (Recommended Size 1920 * 450)</span></label>
                                    <input class="form-control spinner" <?php if (getloan('image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="image" type="file"> 
                                </div>
                        </div>
                            
                    <?php if (getloan('image', $_REQUEST['lid']) != '') { ?>
                                                            <div class="col-md-4" id="delimage">
                                                                <label> </label>
                                                                <img src="<?php echo $fsitename; ?>img/customer/<?php echo getloan('image', $_REQUEST['lid']); ?>" style="padding-bottom:10px;" height="100" />
                                                                <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getloan('image', $_REQUEST['lid']); ?>', '<?php echo $_REQUEST['lid']; ?>', 'customer', '../../../img/customer/', 'image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                                            </div>
                    <?php } ?>
                        
                        <div class="col-md-4">
                                <label>ID Proof<span style="color:#FF0000;">*</span></label>
                                <input type="text" required="required" id="idproof"  name="idproof" placeholder="Enter The ID Proof" class="form-control" value="<?php echo stripslashes(getloan('idproof', $_REQUEST['lid'])); ?>" />
                        </div>
                    </div> -->
                    <!--  <div class="row">
                           
                           <div class="col-md-4">
                              <label>Object<span style="color:#FF0000;">*</span>&nbsp;&nbsp;<a href="<?php // echo $sitename;        ?>master/addobject.htm">Add object</a></label>
                              <select name="object" id="object" class="form-control" required="required">
                              <option value="">Select</option>
                    <?php
// $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
// while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                                  <option value="<?php // echo $objectfetch['id'];        ?>" <?php //if (getloan('object', $_REQUEST['lid']) == $objectfetch['id']) {        ?> selected <?php // }        ?>><?php // echo $objectfetch['objectname'];        ?></option>
                    <?php // }    ?>               
                          </select> 
                          </div>
                          <div class="col-md-4">
                              <label>Quantity <span style="color:#FF0000;">*</span></label>
                              <input type="text"  required="required" name="quantity" id="quantity" placeholder="Enter quantity" class="form-control" value="<?php //echo stripslashes(getloan('quantity',$_REQUEST['lid']));        ?>" maxlength="10"/>
                          </div> 
                          
                      </div>  --> <br>
                    <!-- <div class="clearfix"><br /></div> -->
                    <div class="panel panel-info">
                        <div class="panel-heading" style="background-color: #d9f7df;">Object Details</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr style="font-size:19px;">
                                                    <th width="5%">S.no</th>
                                                    <th width="20%">Object</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="15%">Image</th>
                                                    <th width="15%">Weight</th>
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
                                                    <td>
                                                        <input type="text" class="form-control objectchange" name="objectvalname[]" id="objectvalname[]">
                                                        <input type="hidden" class="form-control" name="objectval[]" id="objectval">

                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
                                                    <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
                                                    <td style="border: 1px solid #f4f4f4;">

<input type="text" style="text-align: right;" name="eobject_image[]" id="eobject_image[]" class="form-control" />
                                                        <input type="file" style="text-align: right;" name="object_image[]" id="object_image[]" class="form-control" value="" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
                                                         <td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="objweight[]" id="objweight" class="form-control objweight" value="" onkeyup="weightcalculation(this.value);"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                                <?php
                                                $b = 1;
                                                $object1 = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`= ?");
                                                $object1->execute(array($_REQUEST['lid']));
                                                $scount = $object1->rowcount();
                                                if ($scount != '0') {
                                                    while ($object1list = $object1->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $b; ?></td>
                                                            <td>

                                                                 <input type="text" class="form-control objectchange" name="objectvalname[]" id="objectvalname[]" value="<?php echo $object1list['objectname']; ?>">
                                                        <input type="hidden" class="form-control" name="objectval[]" id="objectval" value="<?php echo $object1list['object']; ?>">


                                                                   <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                            </td>
                                                            <!--<td><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo $object1list['quantity']; ?>"/></td>-->
                                                            <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="<?php echo $object1list['quantity']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
                                                            <!-- image start -->
<td style="border: 1px solid #f4f4f4;">
<input type="file" style="text-align: right;" name="object_image[]" id="object_image[]" class="form-control" value=""/>
<input type="text" style="text-align: right;" name="eobject_image[]" id="eobject_image[]" class="form-control" value="<?php echo $object1list['object_image']; ?>"/>

    <img src="../../img/loan/<?php echo $object1list['object_image']; ?>" height="50"></td>
    <td><input type="text" style="text-align: right;" name="objweight[]" id="objweight" class="form-control objweight" value="<?php echo $object1list['objweight']; ?>" onkeyup="weightcalculation(this.value);"/></td>

                                                            <!-- image end -->
  <!--                                                          <td>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file">
                                                                    </div>                 
                                                                    <?php if ($object1list['object_image'] != '') { ?>   
                                                                        <div class="col-md-8" id="delimage">
                                                                            <input class="form-control spinner"value="<?php echo $object1list['object_image']; ?>" name="object_image[]" type="text">
                                                                            <img src="<?php echo $fsitename; ?>img/object/<?php echo $object1list['object_image']; ?>" style="padding-bottom:10px;" height="100" />
                                                                             <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo $object1list['object_image']; ?>', '<?php echo $object1list['id']; ?>', 'object_detail', '../../img/object/', 'object_image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>                                                             
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </td>-->
                                                            <td onclick="delrec1($(this), '<?php echo $object1list['id']; ?>')" style="border: 1px solid #f4f4f4;"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                        </tr>
                                                        <?php
                                                        $b++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="2" ></td></tr>
                                                <tr>
                                                    <td colspan="1" style="border:0;"><button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button></td>
                                                    <td style="text-align:right;"> <label>Total Quantity </label> </td>
                                                    <td><input type="text" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getloan('totalquantity', $_REQUEST['lid']); ?>" /></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Gross Weight<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="gross_weight" id="gross_weight" placeholder="Enter Gross Weight" class="form-control" value="<?php echo stripslashes(getloan("gross_weight", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-3">
                            <label>Deduction Gram<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="detection_gram" id="detection_gram" placeholder="Enter Deduction Gram" class="form-control" value="<?php echo stripslashes(getloan("detection_gram", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-3">
                            <label>Gross Weight After Deduction <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="gross_weight_detection" id="gross_weight_detection" placeholder="Enter Gross Weight Deduction" class="form-control" value="<?php echo stripslashes(getloan("gross_weight_detection", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-3">
                            <label>Net Weight (in gms) <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="netweight" id="netweight"  placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getloan("netweight", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                      
                    </div>
                    <br>
                    <div class="row">
                         <div class="col-md-3">
                            <label>Current Gold Rate <span style="color:#FF0000;">*</span></label>
    <input type="text" required="required"  id="today_rate" name="today_rate" value="<?php echo getloan("today_rate", $_REQUEST['lid']); ?>" class="form-control">  </div>
                          <div class="col-md-3">
                            <label>Amount <span style="color:#FF0000;">*</span></label>

                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getloan("amount", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-3">
                            <label>Interest Percent<span style="color:#FF0000;"></span></label>
                            <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" onkeyup="interest_calculation()" value="<?php echo stripslashes(getloan("interestpercent", $_REQUEST['lid'])); ?>" />
                             <label>Per Month</label>
                        </div>
                        <div class="col-md-3">
                            <label>Interest Amount<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo stripslashes(getloan('interest', $_REQUEST['lid'])); ?>" />
                            <label>Per Month</label>
                        </div>
                          <!-- <div class="col-md-3">
                            <label>Return Amount<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="return_amount"  name="return_amount" placeholder="Enter Return Amount" class="form-control" value="<?php echo stripslashes(getloan('return_amount', $_REQUEST['lid'])); ?>" />
                        </div> -->

                       <!--  <div class="col-md-3">

                            <label>Return Type <span style="color:#FF0000;">*</span></label>                                  
                            <select name="return_type" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getloan('return_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Full Return</option>
                                <option value="2" <?php
                                if (stripslashes(getloan('return_type', $_REQUEST['lid']) == '2')) {
                                    echo 'selected';
                                }
                                ?>>Partial Return</option>
                                <option value="3" <?php
                                if (stripslashes(getloan('return_type', $_REQUEST['lid']) == '3')) {
                                    echo 'selected';
                                }
                                ?>>Monthly Interest Paid</option>

                            </select>
                        </div> -->
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">

                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getloan('status', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (stripslashes(getloan('status', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Canceled</option>

                            </select>
                        </div>

                    </div> <br>
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
                            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getloan('netweight', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getloan('amount', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getloan('interestpercent', $_REQUEST['lid'])); ?>" />
                        </div>
                       
                    </div> 
                     
                     <br> -->
                    <div class="row">
                        

                    </div> 
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($_REQUEST['lid'] != '') {
                                ?>
                                <a id="printbutton" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/loanreciept.php?id=' . $_REQUEST['lid']; ?>" target="__blank"></a>
                            <?php } ?>
                        </div>
                    </div>
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/loan.htm" style="font-size:19px;">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['lid'] != '') {
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
  function weightcalculation() {
    sum=0;
        $('.objweight').each(function(){
        sum+=Number($(this).val());
         
        });
 
        document.getElementById('gross_weight').value = sum;
}

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
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getloan('id', $_REQUEST['lid']); ?>/editprovider.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {

        $("input").click(function () {
            $(this).next().show();
            $(this).next().hide();
        });


$(document).on('keyup', '.objectchange', function (e){
    var product = $(this).val();
     $this = $(this);
     
     // Initialize jQuery UI autocomplete
  $('.objectchange').autocomplete({
   source: function( request, response ) {
    $.ajax({
   url:"<?php echo $sitename.'pages/master/'; ?>proprice.php",
     type: 'post',
     dataType: "json",
     data: {
      search: request.term,request:1
     },
     success: function( data ) {
      response( data );
     }
    });
   },
   select: function (event, ui) {
    $(this).val(ui.item.label); // display the selected text
    var userid = ui.item.value; // selected value

$(this).parent().find('#objectval').val(userid);



    return false;
   }
  });
  
    
            
});
   



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

            window.location.href = "<?php echo $sitename; ?>master/<?php echo getloan('id', $_REQUEST['lid']); ?>/editloan.htm?delid1=" + id;
        }
    }

    function interest_calculation() {
        var interest_amount = $('#amount').val();
        var interest_percent = $('#interestpercent').val();
        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = interest_amount - (interest_amount * a);
        //alert(interest_total);
        document.getElementById('interest').value = interest_amount - interest_total;
        // $('#interest').html(interest_total);
    }

    function customer(a) {

        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/ajax_page.php",
            data: {customerid: a},
            success: function (data) {
                $("#customerdetail").html(data);
                $("#customerid").val(a);

            }
        });
    }

    function quantitycalculation(a) {
sum=0;

        $('.quantity').each(function(){
        sum+=Number($(this).val());
         
        });

        document.getElementById('totalquantity').value = sum;
    }
/////calculate amount start 
 $("#gross_weight").keyup(function()
 {
    var gw = $("#gross_weight").val();
    var trate = $("#today_rate").val();
    if(trate!='') {
    var nw = gw;
    var amnt = nw * trate;
   // $("#netweight").val(nw);
    $("#amount").val(amnt.toFixed(2));
}

  });

 $("#detection_gram").keyup(function()
 {
    var gw = $("#gross_weight").val();
    var detection_gram = $("#detection_gram").val();
    var nw = gw*detection_gram;
    var amnt = gw - nw;
    $("#gross_weight_detection").val(amnt.toFixed(2));
    // $("#netweight").val(amnt.toFixed(2));
    
  });

  $("#today_rate").keyup(function()
 {
    var today_rate = $(this).val();
    var netweight = $("#netweight").val();
    var nw = today_rate*netweight;
   
     $("#amount").val(nw.toFixed(2));
    
  });


 $("#gross_weight_detection").keyup(function()
 {
    var gw = $("#gross_weight").val();
    var gwd = $("#gross_weight_detection").val();
    var interestpercent = $("#interestpercent").val();
    var trate = $("#today_rate").val();
    if(trate!='') {
    var nw = gw - gwd;
    var amnt = nw * trate;
    $("#netweight").val(nw.toFixed(2));
    $("#amount").val(amnt.toFixed(2));
    if(interestpercent!='') {
   interstval=amnt*(interestpercent/100);
    $("#interest").val(interstval.toFixed(2));
    }
       }
  });
/////calculate amount end
</script>


<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>