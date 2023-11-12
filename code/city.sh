#!/bin/env bash
echo $1
reg='^(-?)([0-9]+)([.,]?)([0-9]+)$'
num1=[ $1 | grep -E '^(-?)([0-9]+)([.,]?)([0-9]+)$' ]
echo 333fff,678 | grep -E '^(-?)([0-9]+)([.,]?)([0-9]+)$'
if  [ "$1"='~^(-?)([0-9]+)([.,]?)([0-9]+)$' ];
then
  echo $1
  echo $num1
  echo "ARGUMENT 1 " $1 " is a number"
else
 echo $1
 echo "ARGUMENT 1= " $1 " is not a number"
fi
NUM2= echo "$2" | grep -E '^(-?)([0-9]+)([.,]?)([0-9]+)$'
if [ "$2" = "$NUM2" ]
then
  echo $NUM2
else
 echo "ARGUMENT 2 is not a number"
fi
# SUM=$(($1+$2))


