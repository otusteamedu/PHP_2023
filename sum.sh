#!/bin/bash
value1=$1
value2=$2

value3=$(echo $value1 | awk '/[0-9]/{print $0}')
value4=$(echo $value2 | awk '/[0-9]/{print $0}')

if [[ $value3 ]] && [[ $value4 ]]; then
  echo "$(($value1 + $value2))"
else
  echo "data is not valid"
  exit 1
fi
