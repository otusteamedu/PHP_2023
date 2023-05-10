#!/bin/bash

if [ $# -ne 2 ]
then
    echo "Введите два числа"
    exit 1
fi

reg='^-?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $reg ]] || ! [[ $2 =~ $reg ]]
then
    echo "Аргументы должны быть числами"
    exit 1
fi

sum=$( echo "$1 + $2" | bc )

echo "$sum"
