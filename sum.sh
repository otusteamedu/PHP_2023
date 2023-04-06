#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Пожалуйста введите 2 аргумента"
    exit 1
fi

regexp='^[0-9\.\+\-]*$'
if ! [[ $1 =~ $regexp ]] || ! [[ $2 =~ $regexp ]]; then
    echo "Не правильный ввод одного из аргументов"
    exit 1
fi

echo "$1 $2" | awk '{print $1 + $2}'
