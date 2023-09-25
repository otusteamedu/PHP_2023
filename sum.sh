#!/bin/bash

if [[ $1 =~ ^(\d+)(.\d+)?$ ]]
then
    echo 'First arg should be a number'
    exit 1
fi

if [[ $2 =~ ^(\d+)(.\d+)?$ ]]
then
    echo 'Second arg should be a number'
    exit 1
fi

result=$(echo "$1+$2" | bc)
echo $result
exit 0