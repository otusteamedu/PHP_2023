#!/bin/bash

VAR1=$1;
VAR2=$2;

#проверка введенных значений на пустоту
if [ -z $VAR1 ]
then
	echo "Var1 is empty. Exiting!"
	exit -1
fi
if [ -z $VAR2 ]
then
	echo "Var2 is empty. Exiting!"
	exit -1	
fi

#проверка что введенные значения являются числом
if [[ !($VAR1 =~ ^(^[+-]?[0-9]+([.][0-9]+)?$)) ]]; then
	echo "${VAR1} is not a number. Exiting!"
	exit -1
fi
if [[ !($VAR2 =~ ^[+-]?[0-9]+([.][0-9]+)?$) ]]; then
	echo "${VAR2} is a number. Exiting!"
	exit -1
fi

echo "Sum for $VAR1 and $VAR2 is:"
echo $VAR1 $VAR2 | awk '{print $1+$2}'
   
