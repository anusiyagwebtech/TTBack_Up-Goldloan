<?php
if ($_REQUEST['gid'] != '') {
    $thispageeditid = 2;
} else {
    $thispageaddid = 2;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['sid'] = '';


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['gid'] = $_REQUEST['gid'];
    $ip = $_SERVER['REMOTE_ADDR'];

$gid = $_SESSION['gid'];
    $msg = addgeneral($gold_rate,$silver_rate,$gid);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            General Settings
            <small><?php
                if ($_REQUEST['gid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> General Settings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/general.htm">General Settings </a></li>
            <li class="active"><?php
                if ($_REQUEST['gid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;General Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['gid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> General Settings</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">General Settings Details</div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Gold Rate</label>
                                    <textarea class="form-control"  name="gold_rate" id="gold_rate" /><?php echo stripslashes(getgeneral('gold_rate', $_REQUEST['gid'])); ?></textarea>
                                    <br />
                                </div>
                                <div class="col-md-6">
                                    <label>Silver Rate</label>
                                    <textarea class="form-control"  name="silver_rate" id="silver_rate" /><?php echo stripslashes(getgeneral('silver_rate', $_REQUEST['gid'])); ?></textarea>
                                    <br />
                                </div>
                            </div>
                            <br />
                            <br/>
                            
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/general.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['gid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SAVE';
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