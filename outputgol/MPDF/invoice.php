<?php
//include ('../../config/config.inc.php');
include ('../config/config.inc.php');
require_once __DIR__ . '/vendor/autoload.php';
$loandetails = FETCH_all("SELECT * FROM `loan` WHERE `id`=?", $_REQUEST['id']);

?>

<?php 

$message .= "
  <!DOCTYPE html>
<html>
<head>
<meta http-equiv=Content-Type content='text/html; charset=utf-8'>
</head>
<body>
<div style='border:3px solid #000; border-radius:5px;'>
<div align='center' style='color:#000;font-size:30px;'>INDIRA GOLD LOANS<br>இந்திரா தங்க நகை கடன்</div>
<div align='center' style='color:#425C36;font-size:20px;'>
1/45, kancharampettai, Kavanur Village, Madurai 625014<br>
</div>
<div align='center' style='color:#425C36;font-size:20px;border-top:1px solid #000; '>
To be produced at the time of remittance and redeeming jewels<br>
இதை நகை கடனுக்காக பணம் செலுத்த வரும் போதும் நகையை மீட்கும் போதும் கொண்டு வர வேண்டும் 
</div>
<table width='100%' style='font-size:16px;border-top:1px solid #000;'>
<tr>
<td width='50%'>&nbsp;&nbsp;Jewel loan card.<br> &nbsp;&nbsp;நகை கடன் அட்டை</td>
<td width='50%' align='right'>&nbsp;&nbsp;Customer copy.<br>&nbsp;&nbsp;வாடிக்கையாளர் நகல்</td>
</tr>
</table>
<table width='100%' style='font-size:16px;border-top:1px solid #000;'>
<tr>
<td width='50%'>&nbsp;&nbsp;Jewel Loan No. : ".$loandetails['receipt_no']."<br> &nbsp;&nbsp;நகை கடன் நம்பர்  : ".$loandetails['receipt_no']."</td>
<td width='50%' align='right'>&nbsp;&nbsp;Date : ".$loandetails['date']."<br>&nbsp;&nbsp;தேதி : ".$loandetails['date']."</td>
</tr>
</table>
<table width='100%' style='font-size:16px;border-top:1px solid #000;'>
<tr>
<td>&nbsp;&nbsp;Name : ".getcustomer('name',$loandetails['cusid'])."</td>
</tr>
<tr>
<td>&nbsp;&nbsp;பெயர் : ".getcustomer('name',$loandetails['cusid'])."</td>
</tr>
</table>
<table width='100%' cellpadding='10' border='1' cellspacing='0'>
<tr>
<td>Jewel  Details<br>நகை விபரம்</td>
<td>No of items </td>
<td>&nbsp;</td>
<td>Wt / Gram</td>
</tr>";
 $object_detail = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`=? ");
  $object_detail->execute(array($loandetails['id']));
  while ($object_detaillist = $object_detail->fetch(PDO::FETCH_ASSOC)) {
$message .="<tr>
<td>".getobject('objectname', $object_detaillist['object'])."</td>
<td>".$object_detaillist['quantity']."</td>
<td>&nbsp;</td>
<td>".$object_detaillist['objweight']."</td>
</tr>";
}
$message .="
<tr>
<td>Total No of Jewels :</td>
<td>".$loandetails['totalquantity']."</td>
<td>Total Wt : </td>
<td>".$loandetails['netweight']."</td>
</tr>
</table>
<table width='100%'>
<tr>
<td>Loan amount Rs.".$loandetails['amount']."</td>
</tr>
<tr>
<td>கடன் தொகை Rs.".$loandetails['amount']."</td>
</tr>
</table>
</div>
</body>
</html>";

//echo $message;
$mpdf=new mPDF('ta', 'A4', 0, '', 10, 10, 10, 0, 0, 'L');
$mpdf->shrink_tables_to_fit = 1;
// $mpdf->SetDisplayMode('default');
// $mpdf->SetWatermarkText('janani fertility center');
// $mpdf->showWatermarkText = true;
// $mpdf->WriteHTML('Hello World');
//$mpdf->SetWatermarkImage('../img/semen.jpg');
//$mpdf->showWatermarkImage = true;
$mpdf->watermarkImageAlpha = 0.2;
$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->Image('img/header.jpg', 0, 0, 210, 297, 'jpg', '', true, false);
$filename = "test.txt";
$file = fopen($filename, "w");
fwrite($file, $message);
$mpdf->SetTitle('invoice report');
$mpdf->keep_table_proportions = false;
$mpdf->shrink_this_table_to_fit = 0;
$mpdf->SetAutoPageBreak(true, 10);
$mpdf->WriteHTML(file_get_contents($filename));
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->Output('yourFileName.pdf', 'I');
$mpdf->KeepColumns = true; 
?>
?>