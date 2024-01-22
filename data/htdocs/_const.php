<?php
$hallsCount = 10;
$rowsCount = 20;
$seatsPerRowCount = 10;
$filmsCount = 100;
$dateFrom = '2024-01-01 00:00:00';
$dateTo = '2025-01-05 23:59:59';
$seanceDuration = 3 * 60 * 60;
//$sessionCount = $hallsCount * (\DateTime::createFromFormat('Y-m-d H:i:s', $dateTo)->getTimestamp() - \DateTime::createFromFormat('Y-m-d H:i:s', $dateFrom)->getTimestamp()) / $seanceDuration;
$sessionCount = 100;
$customersCount = 100;


// no memody limit
ini_set('memory_limit', '-1');