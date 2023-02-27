#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Error. Please provide two arguments."
    exit 1;
fi

if ! [[ $1 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
    echo "The first argument is not a number"
    exit 1;
fi

if ! [[ $2 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
    echo "The second argument is not a number"
    exit 1;
fi

sum=$(echo "$1 + $2" | bc)
echo "$1 + $2" = $sum