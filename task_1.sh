#!/bin/bash

VAR_NUMBER=$#

if [ $VAR_NUMBER -ne 2 ]
then
        echo "Минимальное кол-во параметров - 2"
exit 1
fi

RESULT=0
for i in $@
do
        if ! [[ $i =~  ^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$ ]]
        then
                echo "Параметр $i не является числом"
                exit 1
        fi
        RESULT=$(echo "$RESULT $i" | awk "{print $1 + $2}")
done

echo $RESULT
