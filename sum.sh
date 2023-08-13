#!/bin/bash

if ! dpkg -s bc >/dev/null 2>&1
  then
    echo "Не установлен пакет bc для вычислений с плавающей точкой"
    exit 1
fi

if [[ $# -ne 2 ]]
  then
    echo "Кол-во аргументов должно быть = 2"
    exit 1

  else
    re='^[+-]?[0-9]+([.][0-9]+)?$'
    if ! [[ $1 =~ $re && $2 =~ $re ]]
      then
        echo "Аргументы должны быть числами"
        exit 1
    fi

    sum=$(bc<<<"scale=3;$1+$2")
    echo $sum
fi
