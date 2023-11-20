#!/bin/bash

# Если в числах присутствуют точка вместо запятой, то на выходе в сумме получается число без плавающей точки
FIRST_NUMBER="${1//./,}"
SECOND_NUMBER="${2//./,}"

REGEX='^[+-]?[0-9]+([,][0-9]+)?$'

if [[ ! "$FIRST_NUMBER" =~ $REGEX ]] || [[ ! "$SECOND_NUMBER" =~ $REGEX ]]
    then
        echo "Переменные должны быть вещественными числами"
        exit 1
fi

echo "$FIRST_NUMBER $SECOND_NUMBER" | awk '{print $1 + $2}'
