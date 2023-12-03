#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Использование: $0 число1 число2"
    exit 1
fi

re='^-?[0-9]\d*(\.\d*)?'
if ! [[ $1 =~ $re ]] ; then
  echo "error: Not a number  $1" >&2; exit 1
fi
if ! [[ $2 =~ $re ]]; then
   echo "error1: Not a number $2 " >&2; exit 1
fi

num1=$1
num2=$2
sum=$(bc<<<"scale=3;$num1+$num2")
echo "Результат: $num1 + $num2 = $sum";
