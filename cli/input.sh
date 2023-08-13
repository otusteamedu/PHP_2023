#!/bin/bash

if (($# > 2))
then
  echo "Допустимо только два аргумента"
  exit 1
fi

num1=$1
num2=$2

