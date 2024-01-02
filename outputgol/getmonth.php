<?php $date1 = '2000-01-25';
$date2 = '2000-02-05';

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

echo $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
?>