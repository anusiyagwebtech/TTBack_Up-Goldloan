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
                <h1 class="box-title">Check Bank Status</h1>
            </div>

            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center></center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.no</th>
                                    <th style="width:5%;">Loan Number</th>
                                    <th style="width:10%">Amount</th>
                                      <th style="width:10%">Status</th>
                                </tr>
                            </thead>
<tbody>
                            <?php
                            $sid = 1;
                        $sql4 = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`=1  ");
                            $sql4->execute();
                            
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {
                                  $tot=0;
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) 
                                {
                                    $pobj = $purchase['loanno'];
                                    $supplier = $purchase['amount'];
                                    $pqty = $purchase['status'];  
                                    //$tot = $tot + $supplier;
                                     $tot += $purchase['amount'];
                                    // $pdate = $purchase['pdate'];
                                      
                                    
                                        ?>
                                    
                                         <tr>

                                                     <td><?php echo $sid ?></td>
                                                    <td><?php echo $pobj ?></td>
                                                    <td><?php  echo $supplier ?></td>
                                                    <td><?php if($pqty==0){echo "return";}else{echo "pawned";} ?></td>
                                                    <?php $sid++; ?>

                                                 
                                                </tr>

                                               

                                                <?php 
                                  
                                }
                                
                            }


                            ?>
                           <tbody>

                            

                            
                            <tfoot>
                                 <h3>Total Amount : <?php echo number_format($tot,2); ?><br><br></h3>
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