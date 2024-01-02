<?php
$menu = "8,8,27";
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
    #normalexamples tbody tr td:nth-child(2),  tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8),tbody tr td:nth-child(9) {
        text-align:left;
        font-size: 19px;
    }
    #normalexamples tbody tr td:nth-child(3),  tbody tr td:nth-child(4) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stocks
            <small>List of Stocks</small>
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
                <h3 class="box-title">List of Stocks</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:5%;">Name</th>
                                    <th style="width:10%">Total</th>
                                     <th style="width:10%">Sales</th>
                                     <th style="width:10%">Balance</th>
                                      <th style="width:10%">Purchase Date</th>
                                      <th style="width:10%">Sales Date</th>
                                   
                                </tr>
                            </thead>

                            <?php
                            $sql4 = $db->prepare("SELECT SUM(p.`pquantity`)AS `tot_quantity`,p.pdate,s.sdate,p.object,s.squantity,p.pquantity  FROM purchase_object_detail p JOIN sales_object_detail s on p.object = s.object GROUP BY p.object");
                            $sql4->execute();
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {      
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) {
                                    $pobj = $purchase['object'];
                                    $pqty=0;
            $res2 = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object`=?",$pobj);
                                while($row2 = $res2->fetch(PDO::FETCH_ASSOC)) {
                                // echo "<script>alert('".$row1['squantity']."');</script>";
                                    $pqty += $row2['pquantity'];
                                    }

                                    $sqty=0;
            $res1 = pFETCH("SELECT * FROM `sales_object_detail` WHERE `object`=?",$pobj);
                                while($row1 = $res1->fetch(PDO::FETCH_ASSOC)) {
                                // echo "<script>alert('".$row1['squantity']."');</script>";
                                    $sqty += $row1['squantity'];
                                    }    
                                    // $pqty = $purchase['squantity'];
                                     $pdate = $purchase['pdate'];
                                      $sdate = $purchase['sdate'];   
                                    $bqty = $pqty - $sqty;
                                        ?>
                                    
                                         <tr>
                                                    <td><?php echo getobjectsilver('objectname', $purchase['object']); ?></td>

                                                    <td><?php echo $pqty; ?></td>
                                                     <td><?php echo $sqty; ?></td>
                                                      <td><?php echo $bqty; ?></td>
                                                       <td><?php //echo $pdate; 
                                                       $newDate = date("d-m-Y", strtotime($pdate));
                                                       echo $newDate;
                                                       ?></td>
                                                     <td><?php //echo $pdate; 
                                                       $newDate = date("d-m-Y", strtotime($sdate));
                                                       echo $newDate;
                                                       ?></td>


                                                </tr>
                                                <tr>
                                            
                                                </tr>

                                                <?php
                                  
                                }

                            }


                            ?>
                           
                            

                            
                            <tfoot>
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
