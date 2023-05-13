#!/bin/bash

file=./table.txt

if [ ! -f "$file" ]
then
echo "$file — не найден"
exit 1
fi

awk '{print $3}' $file | sort | uniq -c | sort -nr | head -3
