<?php
include '../vendor/autoload.php';

use Yakovgulyuta\OtusComposerPackage\Composer;

$object = new Composer();
echo $object->hello();
echo $object->goodBy();