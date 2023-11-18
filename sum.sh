#! /bin/env bash

if [ "$#" -ne 2 ]; then
  echo "Error. Enter two numbers"
  exit -1
fi

a=$1
b=$2

regexp='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $a =~ $regexp ]] || ! [[ $b =~ $regexp ]]; then
        echo "Error! Arguments is not numbers!"
	exit -1
fi

echo 'Sum:'
echo $a $b | awk '{print $1+$2}'
