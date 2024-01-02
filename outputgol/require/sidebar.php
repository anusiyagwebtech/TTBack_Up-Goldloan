<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- <li class="treeview <?php echo $tree1; ?>">
                <a href="<?php echo $sitename; ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li> -->

            <?php if ($_SESSION['UID'] == '1') { ?>
                <li class="treeview-menu menu-open <?php echo $tree8; ?>" id="ul_8" style="display:block;">
                    <a href="#">
                        <i class="fa fa-asterisk"></i>
                        <span>Masters</span>
                        <span class="label label-success pull-right" id="span_8">6</span>
                    </a>
                    <ul class="treeview-menu   menu-open" style="display: block;">
                        <li <?php echo $smenuitem10; ?> id="li_10">
                            <a href="<?php echo $sitename; ?>master/object.htm">
                                <i class="fa fa-circle-o"></i>Object Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem11; ?> id="li_11">
                            <a href="<?php echo $sitename; ?>master/customer.htm">
                                <i class="fa fa-circle-o"></i>Customer Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem18; ?> id="li_18">
                            <a href="<?php echo $sitename; ?>master/loan.htm">
                                <i class="fa fa-circle-o"></i>Loan Mgmt 
                            </a>
                        </li>
                       

                        <li <?php echo $smenuitem123; ?> id="li_123">
                            <a href="<?php echo $sitename; ?>master/monthly_intrst_paid.htm">
                                <i class="fa fa-circle-o"></i>Monthly Interest Paid 
                            </a>
                        </li>
                        <li <?php echo $smenuitem122; ?> id="li_122">
                            <a href="<?php echo $sitename; ?>master/particalloan_return.htm">
                                <i class="fa fa-circle-o"></i>Partial Loan Return Mgmt 
                            </a>
                        </li>
                         <li <?php echo $smenuitem12; ?> id="li_12">
                            <a href="<?php echo $sitename; ?>master/monthlyloan_return.htm">
                                <i class="fa fa-circle-o"></i>Full Loan Return Mgmt 
                            </a>
                        </li>
                       

                        <li <?php echo $smenuitem13; ?> id="li_13">
                            <a href="<?php echo $sitename; ?>master/bankstatus.htm">
                                <i class="fa fa-circle-o"></i>Bank Status Mgmt 
                            </a>
                        </li>
                        

        <!--                <li <?php echo $smenuitem23; ?> id="li_23">
                            <a href="<?php echo $sitename; ?>master/bankpawn.htm">
                                <i class="fa fa-circle-o"></i>Bank Pawn
                            </a>
                        </li>-->
                       


                    </ul>
                </li>
                <!-- <li class="treeview <?php echo $tree3; ?>" id="ul_3">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Silver</span>
                        <span class="label label-warning pull-right" id="span_3">4</span>
                    </a>
                    <ul class="treeview-menu   menu-open" style="display: block;">
                        <li <?php echo $smenuitem44; ?> id="li_44">
                            <a href="<?php echo $sitename; ?>pages/process/supplier.php">
                                <i class="fa fa-circle-o"></i>Supplier Mgmt 
                            </a>
                        </li>
                         <li <?php echo $smenuitem28; ?> id="li_28">
                            <a href="<?php echo $sitename; ?>pages/process/object.php">
                                <i class="fa fa-circle-o"></i>Silver Object Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem55; ?> id="li_55">
                            <a href="<?php echo $sitename; ?>pages/process/purchase.php">
                                <i class="fa fa-circle-o"></i>Purchase Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem26; ?> id="li_26">
                            <a href="<?php echo $sitename; ?>pages/process/sales.php">
                                <i class="fa fa-circle-o"></i>Sales Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem27; ?> id="li_27">
                            <a href="<?php echo $sitename; ?>pages/process/stock.php">
                                <i class="fa fa-circle-o"></i>Stock Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem29; ?> id="li_29">
                            <a href="<?php echo $sitename; ?>pages/process/avlstocks.php">
                                <i class="fa fa-circle-o"></i>Availabe Stock Mgmt 
                            </a>
                        </li>
                        <li <?php echo $smenuitem30; ?> id="li_30">
                            <a href="<?php echo $sitename; ?>pages/process/salesandpurchase.php">
                                <i class="fa fa-circle-o"></i>Silver Sales and Purchase
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="treeview <?php echo $tree249; ?>" id="ul_249">
                    <a href="#">
                        <i class="fa fa-plus-square-o"></i>
                        <span>Report</span>
                        <span class="label label-success pull-right" id="span_249">1</span>
                    </a>
                    <ul class="treeview-menu <?php echo $menutree249; ?>">
                       <!--  <li <?php echo $smenuitem60; ?> id="li_60"><a href="<?php echo $sitename; ?>others/addimage.htm"><i class="fa fa-circle-o"></i>Image Upload</a></li>
                        <li <?php echo $smenuitem61; ?> id="li_61"><a href="<?php echo $sitename; ?>others/addpurchasereturn.htm"><i class="fa fa-circle-o"></i>Purchase Return</a></li>
                        <li <?php echo $smenuitem62; ?> id="li_62"><a href="<?php echo $sitename; ?>others/addsalesreturn.htm"><i class="fa fa-circle-o"></i>Sales Return</a></li>
                         -->
                          <li <?php echo $smenuitem63; ?> id="li_63"><a href="<?php echo $sitename; ?>others/loan_report.htm"><i class="fa fa-circle-o"></i>Loan Report</a></li>
                        <li <?php echo $smenuitem63; ?> id="li_63"><a href="<?php echo $sitename; ?>others/bank.htm"><i class="fa fa-circle-o"></i>Check Bank Status</a></li>
                        

                    </ul>
                </li>
            <?php } else { ?>

                <li <?php echo $smenuitem15; ?> id="li_15">
                    <a href="<?php echo $sitename; ?>merchant/offers.htm">
                        <i class="fa fa-circle-o"></i>Offers Mgmt 
                    </a>
                </li>
                <li <?php echo $smenuitem16; ?> id="li_16">
                    <a href="<?php echo $sitename; ?>merchant/findcustomer.htm">
                        <i class="fa fa-circle-o"></i>Find Customer 
                    </a>
                </li>
                <li <?php echo $smenuitem17; ?> id="li_17">
                    <a href="<?php echo $sitename; ?>merchant/saleslist.htm">
                        <i class="fa fa-circle-o"></i>Sales Report
                    </a>
                </li>

            <?php } ?>
        </ul>
        <img src="<?php echo $sitename; ?>images/elogo1.jpg">
    </section>
    <!-- /.sidebar -->
</aside>
