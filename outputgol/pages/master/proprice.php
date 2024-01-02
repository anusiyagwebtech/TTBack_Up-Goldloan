<?php 
include ('../../config/config.inc.php');

if($_POST['request1'] == 1){
 $search = $_POST['search'];
$customer = pFETCH("SELECT * FROM `stock_product` WHERE objectname like'%".$search."%' AND `id`!=?", '0');
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
  $response[] = array("value"=>$row['id'],"label"=>$row['objectname']);
 }

 // encoding array to json format
 echo json_encode($response);
 exit;
}


if($_POST['request'] == 1){
 $search = $_POST['search'];
$customer = pFETCH("SELECT * FROM `object` WHERE (objectname like'%".$search."%' ) AND `id`!=?", '0');
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
	$labl=$row['objectname'];
  $response[] = array("value"=>$row['id'],"label"=>$labl);
 }

 // encoding array to json format
 echo json_encode($response);
 exit;
}



?>