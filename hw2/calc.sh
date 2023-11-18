#!/bin/bash

if [ "$#" -ne 2 ]; then
  echo "Неверное количество аргументов"
  exit 1
fi

re='^-?[0-9]+([.][0-9]+)?$'

for arg in $@
do
    if ! [[ $arg =~ $re ]] ; then
        echo "Аргумент '$arg' некорректное число"
        exit 2
    fi
done

RESULT=$(echo "$1 $2" | awk '{print $1 + $2}')

echo "$RESULT"