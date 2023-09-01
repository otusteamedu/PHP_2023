#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Передайте два аргумента"
    exit 1
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]]; then
    echo "Один из аргументов не является числом"
    exit 1
fi

sum=$(echo "$1 + $2" | bc)
echo "$1 + $2 = $sum"