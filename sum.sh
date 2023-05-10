#!/bin/bash

echo "numeric #1 = " "$1"
echo "numeric #2 = " "$2"

if [ $# -lt 2 ]; then
    echo "Error: Missing command line arguments"
    exit 1
fi

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $regex ]] || ! [[ $2 =~ $regex ]]; then
    echo "Error: Invalid argument(s)"
    exit 1
fi

regex2='^[+-]?[0-9]+([.][0-9]+)$'
if [[ $1 =~ $regex2 ]] || [[ $2 =~ $regex2 ]]; then
    sum=$(echo "$1 $2" | awk '{printf "%.2f", $1 + $2}'); else
	sum=$(( $1 + $2 ))
fi

echo "Sum: $sum"
