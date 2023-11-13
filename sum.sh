#!/bin/bash

NUMBER_1=$1
NUMBER_2=$2

RE='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $NUMBER_1 =~ $RE ]]; then
	echo "1-й аргумент не является числом"
	exit 1
fi

if ! [[ $NUMBER_2 =~ $RE ]]; then
        echo "2-й аргумент не является числом"
        exit 1
fi

echo "$NUMBER_1 $NUMBER_2" | awk '{print $1, "+", $2, "=", $1 + $2}'
