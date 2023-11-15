#!/bin/bash

if [ $# -lt 2 ]
then
    echo "Добавьте слагаемое"
    exit 1
fi

pattern='/^[0-9]{1,}(\.[0-9]+)?$/'

for i in "$@"
do
  if [ -z $(echo "$i" | awk "$pattern") ]
  then
      echo "$i - не число. Введите числовое значение"
      exit 1
  fi
done

echo $1 $2 | awk '{print $1 + $2}'

