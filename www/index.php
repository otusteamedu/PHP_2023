<?php
require (__DIR__.'/vendor/autoload.php');
(new Singurix\Webpconverter\Converter())
    ->setSrcPath('test.jpg')
    ->setDestPath('test.webp')
    ->convert();