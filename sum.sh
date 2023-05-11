#!/bin/bash

if ! command -v bc &> /dev/null
then
    echo "установка bc. Введите пароль"
    sudo apt-get update
    sudo apt-get install bc
fi

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
