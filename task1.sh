#!/bin/bash

FIRST_NUMBER=$1
SECOND_NUMBER=$2
FLOATING_POINT_NUMBER_REGEXP=^-{0,1}[0-9]+\.{0,1}[0-9]*$




if [ -z "$FIRST_NUMBER" ]
then
	echo "Не переданы числа для сложения!"
	exit -1;
fi

if [[ ! $FIRST_NUMBER =~ $FLOATING_POINT_NUMBER_REGEXP ]]
then
	echo "Первый аргумент $FIRST_NUMBER - не является числом!"
	exit -1;
fi

if [ -z "$SECOND_NUMBER" ]
then
	echo "Не передано второе число для сложения!"
	exit -1;
fi

if [[ ! $SECOND_NUMBER =~ $FLOATING_POINT_NUMBER_REGEXP ]]
then
	echo "Второй аргумент $SECOND_NUMBER - не является числом!"
	exit -1;
fi


SUM_OF_NUMBERS=$(echo "$FIRST_NUMBER $SECOND_NUMBER" | awk '{print $1 + $2}')

echo "Сумма чисел: $FIRST_NUMBER и $SECOND_NUMBER равна $SUM_OF_NUMBERS"


