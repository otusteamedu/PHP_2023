#!/bin/bash

if [ "$#" -ne 2 ]; then
  echo "Необходимо два парметра"
  exit -1
fi

if ! [[ $1 =~ ^[0-9] ]]; then
   echo "Первый аргумент должен быть числом"
   exit -1
fi

if ! [[ $2 =~ ^[0-9] ]]; then
   echo "Второй аргумент должен быть числом"
   exit -1
fi

sum=$(echo "$1 $2" | awk '{ printf "%.2f\n", $1 + $2 }')

echo "Ответ: $sum"