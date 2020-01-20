<?php
$date = '2019-01-01';
$d = new DateTime($date);
$d->modify('+1 year');
$d->modify('+1 month');
$d->modify('+1 day');
echo $d->format('Y-m-d');











echo "\n";
