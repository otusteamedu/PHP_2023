#!/bin/bash

req='^[-]?[0-9]+([.][0-9]+)?$';

if (($# > 2)); then
  echo "Допустимо только два аргумента"
  exit 1
fi

if [[ ! $1 =~ $req || ! $2 =~ $req ]]; then
  echo "Допустимы только числа"
  exit 1
fi

echo "Сумма: $(echo $1 $2 | awk '{print $1 + $2}')"
