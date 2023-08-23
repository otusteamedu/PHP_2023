<?php

function autoload($className)
{
  $prefix = 'Nalofree\\WsTest';
  $baseDir = './src';
  if (substr($className, 0, strlen($prefix)) == $prefix) {
    $className = substr($className, strlen($prefix));
    $className = $baseDir . $className;
  }
  $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
  $fileName = $className . ".php";
  if (is_readable($fileName)) {
    require_once $fileName;
  }
}

spl_autoload_register("autoload");