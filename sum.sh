#!/bin/bash

if [ $# -lt 2 ]
  then
    echo "Необходимо передать 2 аргумента"
    exit 1
fi

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $regex ]]
  then
    echo "Первый аргумент должен быть числом"
    exit 1
fi

if ! [[ $2 =~ $regex ]]
  then
    echo "Второй аргумент должен быть числом"
    exit 1
fi

echo "$1 $2" | awk '{print $1 + $2}'