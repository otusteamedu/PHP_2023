#!/usr/bin/env bash

if [ "$#" -ne 2 ]; then
    echo "Error: Needs two args."
    exit 1
fi

REGEX='^-?[0-9]+([.][0-9]+)?$'

if [[ ! $1 =~ $REGEX ]] || [[ ! $2 =~ $REGEX ]]
    then
        echo "Error: Both args must be the numbers."
        exit 1
fi

result=$(awk "BEGIN {print $1 + $2; exit}")
echo "$1 + $2 = $result"
