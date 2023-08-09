#!/bin/bash

#аргументы командной строки через пробел
arg1=$1
arg2=$2

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $arg1 =~ $re ]];
then
   echo "error: Not a number"; exit 1
fi

if ! [[ $arg2 =~ $re ]];
then
   echo "error: Not a number"; exit 1
fi

awk "BEGIN {print $arg1+$arg2; exit}"

#Выход с кодом 0 (удачное завершение работы скрипта)
exit 0