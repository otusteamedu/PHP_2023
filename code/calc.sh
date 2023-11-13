#!/bin/env bash

apt-get update && apt-get install bc

re='^-?([0-9]+)([\.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
  echo "ARGUMENT 1 " $1 " is not a number"
  exit 0
else
  echo "ARGUMENT 1= " $1 " is a number"
fi

if ! [[ $2 =~ $re ]] ; then
  echo "ARGUMENT 2 " $2 " is not a number"
  exit 0
else
  echo "ARGUMENT 2= " $2 " is a number"
fi
# Calculate

sum=$(echo "$1+$2" | bc)
echo $sum














