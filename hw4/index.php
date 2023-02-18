<?php

declare(strict_types=1);

use Builov\CyrillicRemover\CyrillicRemover;

require __DIR__ . '/vendor/autoload.php';

// строка с кириллическими символами
$str = "Whаt functiоn dо yоu use tо get innerHTML оf а given DОMNоde in the PHP DОM implementаtiоn? Cаn sоmeоne give reliаble sоlutiоn?";

$cr = new CyrillicRemover($str);
if ($cr->checkString()) {
    echo $cr->clear(); // строка без кириллических символов
}