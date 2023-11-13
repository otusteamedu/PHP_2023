#!/bin/env bash

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

# calc
echo $1 $2 | awk '{print $1+$2}'




















