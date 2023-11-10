#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo "Ошибка: Необходимо указать два числа в качестве аргументов"
    exit 1
fi

re='^-?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
    echo "Ошибка: '$1' не является числом"
    exit 1
fi
if ! [[ $2 =~ $re ]] ; then
    echo "Ошибка: '$2' не является числом"
    exit 1
fi

result=$(awk "BEGIN {print $1 + $2; exit}")
echo "Сумма: $result"