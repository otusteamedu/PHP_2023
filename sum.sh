#!/usr/bin/env bash

x=$1
y=$2
regexp='^[-]?[0-9]+([.][0-9]+)?$'

if [[ ! $x =~ $regexp || ! $y =~ $regexp ]];
then
      echo 'Введите два числовых аргумента'
      exit 1
fi

echo "$x + $y" | bc -l
