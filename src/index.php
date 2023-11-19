<?php
declare(strict_types=1);
use Ekovalev\Otus\LivedDay;
require_once '../vendor/autoload.php';

$lDay = new LivedDay();

$amountDays = $lDay->calculate('13-01-1986');
echo "Вы прожили $amountDays дней";