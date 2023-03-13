#!/bin/bash

echo "Enter first number = $1"
echo "Enter second number = $2"

var1=$1
var2=$2

if ! [[ "$var1" =~ ^[-]?[0-9][.]?[0-9]?+$ ]] && ! [[ "$var2" =~ ^[-]?[0-9][.]?[0-9]?+$ ]]
    then
        echo "Вы не ввели ни одного числа"
    elif  ! [[ "$var1" =~ ^[-]?[0-9][0-9]?[.]?[0-9]?+$ ]]
           then
               echo "Вы не ввели первое число"
    elif  ! [[ "$var2" =~ ^[-]?[0-9][0-9]?[.]?[0-9]?+$ ]]
           then
               echo "Вы не ввели второе число"
    else
        varsum=$( echo | awk '{ print '$var1' + '$var2'}' )
        echo "Сумма чисел равна "$varsum
fi