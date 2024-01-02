<?php
$dynamic = '';
$menu = '1,0,0,0';
$index='1';
include ('require/header.php');
//print_r($_SESSION);
?>
<style>
    /*.content-wrapper{*/
    /*    background-image : url("img/coins1.jpg");*/
    /*    height: 480px;*/
    /*}*/
</style>
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    if ($_SESSION['type'] == 'admin') {
        ?>
        <section class="content-header">

            <h2 style="color:#c5b276;">
                <b> INDIRA LOANS </b>
                <small>Control panel</small>
            </h2>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">INDIRA LOANS</li>
            </ol>
        </section>
<section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
            <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/loan.htm">
                <div class="small-box"style="background-color:#D91505;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                          $stmt=$db->prepare("SELECT * FROM loan");
 $stmt->execute();
 $cnt=$stmt->rowCount();
 echo $cnt;
                           ?></h3>
                        <p style="color:white;">No Of Loans<br> click here to details </p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
                </a>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/particalloan_return.htm">
                <div class="small-box"style="background-color:#c5b275;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                          $stmt=$db->prepare("SELECT * FROM partial_return WHERE `id`!='0'");
 $stmt->execute();
 $cnt=$stmt->rowCount();
 echo $cnt;
                           ?></h3>
                        <p style="color:white;">Number Of Loans Partically Return</p><br>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
               </a>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/monthlyloan_return.htm">
                <div class="small-box"style="background-color:#0F9F04;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                          $stmt=$db->prepare("SELECT * FROM monthly_return WHERE `id`!=0");
 $stmt->execute();
 $cnt=$stmt->rowCount();
 echo $cnt;
                           ?></h3>
                        <p style="color:white;">No Of Loans Fully Return</p><br>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
               </a>
            </div>
             <div class="col-md-3">
                <!-- small box -->
               
                <div class="small-box"style="background-color:#001ae3;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                          $stmt=$db->prepare("SELECT * FROM customer WHERE `status`=1");
 $stmt->execute();
 $cnt=$stmt->rowCount();
 echo $cnt;
                           ?></h3>
                        <p style="color:white;">No Of Customers</p><br>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
             
            </div>
            </div><!-- /.row -->

        </section>
        
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!--<img src="img/index.PNG" style="margin-left:123px;"/>-->
            </div><!-- /.row -->

        </section><!-- /.content -->
    <?php } else { ?>
        <section class="content-header">
            <h1>
                Welcome to Annamalai Finance
            </h1>
        </section>

<?php } ?>
</div><!-- /.content-wrapper -->
<?php include 'require/footer.php'; ?>      
