#!/usr/bin/env bash

CITY_COLUMN=$(sed '1!d' table.csv)
CITY_COLUMN_NAME='city'
IFS='   ' read -a COLUMN_NAMES <<< $CITY_COLUMN

ITERATOR=1
for name in $COLUMN_NAMES
do
    if [ $name = $CITY_COLUMN_NAME ] 
    then
        break;
    fi
    ITERATOR=$((ITERATOR + 1))
done


RESULT=$(sed '1d' table.csv | awk '{print $'$ITERATOR'}' | sort | uniq -c | sort -n -k1 -r | head -n3 | awk '{print $2}' | xargs)
echo 'Самые популярные города в таблице: '$RESULT