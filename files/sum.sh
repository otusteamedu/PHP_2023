#!/bin/bash
if (($# < 2))
then
    echo "Количество аргументов меньше 2"
elif (($#> 2))
then
    echo "Количество аргументов больше 2"
else
    REGEX="^[+-]?[0-9]+([.][0-9]+)?$";
    if [[ $1 =~ $REGEX && $2 =~ $REGEX ]];
    then
       RES=`awk -v A="$1" -v B="$2" 'BEGIN{ {printf "%.2f\n", A + B}}'` 
       echo "$1 + $2 = $RES"
    else
       echo "Аргументы должны содержать числа"
    fi 
fi