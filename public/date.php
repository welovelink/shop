<?php
$start = $_REQUEST['start'];
$days = $_REQUEST['days']; // กำหนดค่าจำนวนวัน

$date = date_create($start);
date_add($date, date_interval_create_from_date_string($days . " days"));
echo 'Start Date :: ' . $start . '<br>';
echo 'Days :: ' . $days . '<br>';
echo 'End Date :: '.date_format($date, "Y-m-d");
