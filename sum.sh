#!/usr/bin/env bash

x=$1
y=$2

if [[ ! $x =~ ^[0-9]+$ || ! $y =~ ^[0-9]+$ ]];
then
      echo 'Введите два числовых аргумента'
      exit 1
fi

echo $(($x + $y))
