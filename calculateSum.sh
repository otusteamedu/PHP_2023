#!/bin/bash

regexp='^-?[0-9]+(\.+[0-9]+)?$'

for i in $1 $2;
    do :
        if !  [[ "$i" =~ $regexp ]];
        then
            echo 'Можно вводить только числа. Введено не число: '$i
            exit 1
        fi
done

awk -v arg1=$1 -v arg2=$2 'BEGIN{print arg1 + arg2}'
