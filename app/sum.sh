#!/bin/sh

a=$1
b=$2
p='^\-?[0-9]+(\.?[0-9]+)?$'

if [[ "$#" -ne 2 ]]; then
  echo "Error: You must enter two numbers"
  exit 1
fi

if [[ ! $a =~ $p && ! $b =~ $p ]]; then
  echo "Error: incorrect value";
  exit 1
fi

echo $a $b | awk '{print $1 + $2}'
