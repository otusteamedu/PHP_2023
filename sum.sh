#!/bin/bash

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

    if dpkg -s bc >/dev/null 2>&1
      then
        sum=$(bc<<<"scale=3;$1+$2")
        echo $sum
      else
        echo $1 $2 | awk '{print $1+$2}'
    fi
fi
