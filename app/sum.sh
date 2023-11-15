#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo "Некорректное количество аргументов"
    exit 1
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]]; then
    echo "Некорректно переданные аргументы"
    exit 1
fi

echo $(awk "BEGIN { print $1 + $2 }")