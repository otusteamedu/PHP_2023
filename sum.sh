#!/bin/bash

if ! [[ $# == 2 ]]; then
    printf "Please, specify two arguments as digits. Found%s $# argument(s)"
    exit 0
fi

if ! [[ $1 =~ ^[\-0-9]+([.,][0-9]+)?$ ]]; then
    echo "First argument is not a digit. Argument = '$1'. Please type digit"
    exit 0
fi

if ! [[ $2 =~ ^[\-0-9]+([.,][0-9]+)?$ ]]; then
    echo "Second argument is not a digit. Argument = '$2'. Please type digit"
    exit 0
fi

num1=$1
num2=$2
sum=$(echo "$num1 $num2"| awk '{print $1 + $2}')
echo "$num1 + $num2 = "$sum
