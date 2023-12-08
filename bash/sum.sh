#!/usr/bin/env bash

if ! which bc > /dev/null; then
    echo "Пакет bc не установлен"
    exit
fi

pattern='^-?[0-9]+?.[0-9]+'
if ! [[ $1 =~ $pattern || $2 =~ $pattern ]] ; then
    echo "Вы ввели не число, допустивы целые числа, десятичные, положительные и отрицательные"
    exit
fi

result=$(echo "$1 + $2" | bc)
echo $result
