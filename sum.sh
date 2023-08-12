#!/usr/bin/env bash
regNum='^[+-]?[0-9]+([.][0-9]+)?$';
if [[ $1 =~ $regNum && $2 =~ $regNum ]]; then
   echo $1 $2 | awk '{print $1 + $2}'
else
   echo "Представлены неверные аргументы"
fi