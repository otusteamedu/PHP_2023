#!/bin/bash

result=0
regEx="^-?[0-9]+(\.[0-9]+)?$"

if [ $# -ne 2 ]
then
    echo "Необходимо указать 2 числа."
    exit 1
fi

for arg in $*
do
    if ! [[ $arg =~ $regEx ]]
    then
        echo "Некорректное число '${arg}'."
        exit 1
    fi

    result=`echo "$result $arg" | awk '{ print $1 + $2 }'`
done

echo $result
