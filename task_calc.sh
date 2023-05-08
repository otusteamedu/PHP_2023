#!/bin/env bash

NUM1=$1
NUM2=$2
NUM_REGEXP=^-{0,1}[0-9]+\.{0,1}[0-9]*$                             #регулярка проверки на число




if [ -z "$NUM1" ]                                                  #проверка на пустоту
then
	echo "Числа для сложения не переданы!"
	exit -1;
fi

if [[ ! $NUM1 =~ $NUM_REGEXP ]]                                    #проверка на число
then
	echo "Первый введенный аргумент $NUM1 - не является числом!"
	exit -1;
fi

if [ -z "$NUM2" ]                                                  #проверка на пустоту
then
	echo "Второе число для сложения не передано"
	exit -1;
fi

if [[ ! $NUM2 =~ $NUM_REGEXP ]]                                    #проверка на число
then
	echo "Второй аргумент $NUM2 - не является числом!"
	exit -1;
fi


SUM_OF_NUMBERS=$(echo "$NUM1 $NUM2" | awk '{print $1 + $2}')

echo "$NUM1 + $NUM2 = $SUM_OF_NUMBERS"


