#! /bin/bash

NUMBER_1=$1
NUMBER_2=$2

REGEX='^[+-]?[0-9]+([.][0-9]+)?$'

if [ -z $NUMBER_1 ]
then
   echo "Ошибка в количестве аргументов"
   exit -1;
fi

if [ -z $NUMBER_2 ]
then
   echo "Ошибка в количестве аргументов"
   exit -1;
fi

if [[ $NUMBER_1 =~ $REGEX ]] && [[ $NUMBER_2 =~ $REGEX ]];
then
   echo $NUMBER_1 $NUMBER_2 | LC_NUMERIC="C" awk '{printf "%f\n", $1 + $2}'
else
   echo "Ошибка - переданы не числовые параметры"
   exit -1;
fi